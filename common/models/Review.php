<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "review".
 *
 * @property int $id
 * @property int $product_id
 * @property int|null $user_id
 * @property string $user_name
 * @property string|null $user_email
 * @property float $rating
 * @property string|null $title
 * @property string $comment
 * @property string|null $advantages
 * @property string|null $disadvantages
 * @property int $status
 * @property int|null $is_verified
 * @property int|null $likes
 * @property int|null $dislikes
 * @property string|null $ip_address
 * @property string|null $user_agent
 * @property string $created_at
 * @property string $updated_at
 * @property string|null $published_at
 *
 * @property Product $product
 */
class Review extends \yii\db\ActiveRecord
{
    const STATUS_PENDING = 0;
    const STATUS_APPROVED = 1;
    const STATUS_REJECTED = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'review';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'user_email', 'title', 'advantages', 'disadvantages', 'ip_address', 'user_agent', 'published_at'], 'default', 'value' => null],
            [['rating'], 'default', 'value' => 0.0],
            [['dislikes'], 'default', 'value' => 0],
            [['product_id', 'user_name', 'comment'], 'required'],
            [['product_id', 'user_id', 'status', 'is_verified', 'likes', 'dislikes'], 'integer'],
            [['rating'], 'number'],
            [['comment', 'advantages', 'disadvantages'], 'string'],
            [['created_at', 'updated_at', 'published_at'], 'safe'],
            [['user_name', 'user_email'], 'string', 'max' => 255],
            [['title', 'user_agent'], 'string', 'max' => 500],
            [['ip_address'], 'string', 'max' => 45],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'user_id' => 'User ID',
            'user_name' => 'User Name',
            'user_email' => 'User Email',
            'rating' => 'Rating',
            'title' => 'Title',
            'comment' => 'Comment',
            'advantages' => 'Advantages',
            'disadvantages' => 'Disadvantages',
            'status' => 'Status',
            'is_verified' => 'Is Verified',
            'likes' => 'Likes',
            'dislikes' => 'Dislikes',
            'ip_address' => 'Ip Address',
            'user_agent' => 'User Agent',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'published_at' => 'Published At',
        ];
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->created_at = time();
                if ($this->status === self::STATUS_APPROVED) {
                    $this->published_at = time();
                }
            }
            $this->updated_at = time();

            // Автоматически публикуем если статус изменился на APPROVED
            if ($this->isAttributeChanged('status') && $this->status === self::STATUS_APPROVED) {
                $this->published_at = time();
            }

            return true;
        }
        return false;
    }

    /**
     * Получает массив ID отзывов из строки
     */
    public static function getReviewIdsFromString($reviewsString)
    {
        if (empty($reviewsString)) {
            return [];
        }
        return array_map('intval', explode(',', $reviewsString));
    }

    /**
     * Получает отзывы по строке ID
     */
    public static function getReviewsByIdsString($reviewsString)
    {
        $ids = self::getReviewIdsFromString($reviewsString);
        if (empty($ids)) {
            return [];
        }
        return self::find()->where(['id' => $ids, 'status' => self::STATUS_APPROVED])->all();
    }
    /**
     * Обновляет поле reviews в товаре после создания отзыва
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if ($insert || array_key_exists('status', $changedAttributes) || array_key_exists('product_id', $changedAttributes)) {
            $this->updateProductReviewsField();
        }
    }

    /**
     * Обновляет поле reviews в товаре после удаления отзыва
     */
    public function afterDelete()
    {
        parent::afterDelete();
        $this->updateProductReviewsField();
    }

    /**
     * Обновляет поле reviews в связанном товаре
     */
    private function updateProductReviewsField()
    {
        $productId = $this->product_id;

        // Получаем все опубликованные отзывы для этого товара
        $reviewIds = self::find()
            ->select('id')
            ->where([
                'product_id' => $productId,
                'status' => self::STATUS_APPROVED
            ])
            ->orderBy(['published_at' => SORT_DESC])
            ->column();

        // Обновляем поле reviews в товаре
        $reviewsString = !empty($reviewIds) ? implode(',', $reviewIds) : null;

        Yii::$app->db->createCommand()
            ->update(
                '{{%product}}',
                ['reviews' => $reviewsString],
                ['id' => $productId]
            )
            ->execute();

        // Также обновляем рейтинг товара
        $this->updateProductRating($productId);
    }

    /**
     * Обновляет средний рейтинг товара
     */
    private function updateProductRating($productId)
    {
        $averageRating = self::find()
            ->where([
                'product_id' => $productId,
                'status' => self::STATUS_APPROVED
            ])
            ->average('rating');

        Yii::$app->db->createCommand()
            ->update(
                '{{%product}}',
                [
                    'rating' => $averageRating ? round($averageRating, 2) : 0,
                    'reviews_count' => self::find()
                        ->where([
                            'product_id' => $productId,
                            'status' => self::STATUS_APPROVED
                        ])
                        ->count()
                ],
                ['id' => $productId]
            )
            ->execute();
    }

    /**
     * Массовое обновление поля reviews для всех товаров
     * Полезно для первоначального заполнения или исправления данных
     */
    public static function updateAllProductsReviews()
    {
        $products = Product::find()->all();

        foreach ($products as $product) {
            self::updateProductReviews($product->id);
        }

        return count($products);
    }

    /**
     * Статический метод для обновления reviews конкретного товара
     */
    public static function updateProductReviews($productId)
    {
        $reviewIds = self::find()
            ->select('id')
            ->where([
                'product_id' => $productId,
                'status' => self::STATUS_APPROVED
            ])
            ->orderBy(['published_at' => SORT_DESC])
            ->column();

        $reviewsString = !empty($reviewIds) ? implode(',', $reviewIds) : null;

        Yii::$app->db->createCommand()
            ->update(
                '{{%product}}',
                ['reviews' => $reviewsString],
                ['id' => $productId]
            )
            ->execute();

        // Обновляем рейтинг
        $averageRating = self::find()
            ->where([
                'product_id' => $productId,
                'status' => self::STATUS_APPROVED
            ])
            ->average('rating');

        Yii::$app->db->createCommand()
            ->update(
                '{{%product}}',
                [
                    'rating' => $averageRating ? round($averageRating, 2) : 0,
                    'reviews_count' => count($reviewIds)
                ],
                ['id' => $productId]
            )
            ->execute();
    }


}
