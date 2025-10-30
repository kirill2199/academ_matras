<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_description".
 *
 * @property int $id
 * @property int $product_id
 * @property string|null $short_description
 * @property string|null $description
 * @property string $created_at
 * @property string $updated_at
 * @property string|null $published_at
 *
 * @property Product $product
 * @property Product[] $products
 * @property Product[] $products0
 */
class ProductDescription extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_description';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['short_description', 'description', 'published_at'], 'default', 'value' => null],
            [['product_id'], 'required'],
            [['product_id'], 'integer'],
            [['short_description', 'description'], 'string'],
            [['created_at', 'updated_at', 'published_at'], 'safe'],
            [['product_id'], 'unique'],
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
            'short_description' => 'Short Description',
            'description' => 'Description',
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

    /**
     * Gets query for [[Products]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::class, ['description_id' => 'id']);
    }

    /**
     * Gets query for [[Products0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducts0()
    {
        return $this->hasMany(Product::class, ['short_description_id' => 'id']);
    }

}
