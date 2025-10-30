<?php

namespace common\models;

use Yii;
use \frontend\modules\Cart\models\Cart;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $sku
 * @property int|null $description_id
 * @property int|null $short_description_id
 * @property float $price
 * @property float|null $old_price
 * @property float|null $purchase_price
 * @property string|null $currency
 * @property int|null $quantity
 * @property int|null $reserved_quantity
 * @property float|null $weight
 * @property float|null $length
 * @property float|null $width
 * @property float|null $height
 * @property float|null $volume
 * @property string|null $main_image
 * @property string|null $images
 * @property int $category_id
 * @property string|null $brand
 * @property string|null $model
 * @property int|null $warranty
 * @property string|null $country
 * @property string|null $manufacturer
 * @property string|null $barcode
 * @property string|null $seo_title
 * @property string|null $seo_description
 * @property string|null $seo_keywords
 * @property int|null $status
 * @property int|null $in_stock
 * @property int|null $is_new
 * @property int|null $is_featured
 * @property int|null $is_sale
 * @property float|null $rating
 * @property int|null $reviews_count
 * @property int|null $views_count
 * @property int|null $sales_count
 * @property int|null $min_order_quantity
 * @property int|null $max_order_quantity
 * @property int|null $step_order_quantity
 * @property string $created_at
 * @property string $updated_at
 * @property string|null $published_at
 * @property string|null $reviews
 *
 * @property Cart[] $carts
 * @property Category $category
 * @property Characteristic[] $characteristics
 * @property ProductDescription $description
 * @property OrderItem[] $orderItems
 * @property ProductCharacteristic[] $productCharacteristics
 * @property ProductDescription $productDescription
 * @property ProductDescription $shortDescription
 */
class Product extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sku', 'description_id', 'short_description_id', 'old_price', 'purchase_price', 'weight', 'length', 'width', 'height', 'volume', 'main_image', 'images', 'brand', 'model', 'warranty', 'country', 'manufacturer', 'barcode', 'seo_title', 'seo_description', 'seo_keywords', 'max_order_quantity', 'published_at'], 'default', 'value' => null],
            [['currency'], 'default', 'value' => 'RUB'],
            [['sales_count'], 'default', 'value' => 0],
            [['step_order_quantity'], 'default', 'value' => 1],
            [['rating'], 'default', 'value' => 0.00],
            [['name', 'slug', 'price', 'category_id'], 'required'],
            [['description_id', 'short_description_id', 'quantity', 'reserved_quantity', 'category_id', 'warranty', 'status', 'in_stock', 'is_new', 'is_featured', 'is_sale', 'reviews_count', 'views_count', 'sales_count', 'min_order_quantity', 'max_order_quantity', 'step_order_quantity'], 'integer'],
            [['price', 'old_price', 'purchase_price', 'weight', 'length', 'width', 'height', 'volume', 'rating'], 'number'],
            [['images', 'reviews'], 'string'],
            [['created_at', 'updated_at', 'published_at'], 'safe'],
            [['name', 'slug', 'brand', 'model', 'manufacturer', 'seo_title'], 'string', 'max' => 255],
            [['sku', 'country', 'barcode'], 'string', 'max' => 100],
            [['currency'], 'string', 'max' => 3],
            [['main_image', 'seo_description', 'seo_keywords'], 'string', 'max' => 500],
            [['slug'], 'unique'],
            [['sku'], 'unique'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            [['description_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductDescription::class, 'targetAttribute' => ['description_id' => 'id']],
            [['short_description_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductDescription::class, 'targetAttribute' => ['short_description_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'slug' => 'Slug',
            'sku' => 'Sku',
            'description_id' => 'Description ID',
            'short_description_id' => 'Short Description ID',
            'price' => 'Price',
            'old_price' => 'Old Price',
            'purchase_price' => 'Purchase Price',
            'currency' => 'Currency',
            'quantity' => 'Quantity',
            'reserved_quantity' => 'Reserved Quantity',
            'weight' => 'Weight',
            'length' => 'Length',
            'width' => 'Width',
            'height' => 'Height',
            'volume' => 'Volume',
            'main_image' => 'Main Image',
            'images' => 'Images',
            'category_id' => 'Category ID',
            'brand' => 'Brand',
            'model' => 'Model',
            'warranty' => 'Warranty',
            'country' => 'Country',
            'manufacturer' => 'Manufacturer',
            'barcode' => 'Barcode',
            'seo_title' => 'Seo Title',
            'seo_description' => 'Seo Description',
            'seo_keywords' => 'Seo Keywords',
            'status' => 'Status',
            'in_stock' => 'In Stock',
            'is_new' => 'Is New',
            'is_featured' => 'Is Featured',
            'is_sale' => 'Is Sale',
            'rating' => 'Rating',
            'reviews_count' => 'Reviews Count',
            'views_count' => 'Views Count',
            'sales_count' => 'Sales Count',
            'min_order_quantity' => 'Min Order Quantity',
            'max_order_quantity' => 'Max Order Quantity',
            'step_order_quantity' => 'Step Order Quantity',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'published_at' => 'Published At',
            'reviews'=> 'reviews',
        ];
    }

    /**
     * Gets query for [[Carts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCarts()
    {
        return $this->hasMany(Cart::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[Characteristics]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCharacteristics()
    {
        return $this->hasMany(Characteristic::class, ['id' => 'characteristic_id'])->viaTable('product_characteristic', ['product_id' => 'id']);
    }

    /**
     * Gets query for [[Description]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDescription()
    {
        return $this->hasOne(ProductDescription::class, ['id' => 'description_id']);
    }

    /**
     * Gets query for [[OrderItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[ProductCharacteristics]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductCharacteristics()
    {
        return $this->hasMany(ProductCharacteristic::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[ProductDescription]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductDescription()
    {
        return $this->hasOne(ProductDescription::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[ShortDescription]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getShortDescription()
    {
        return $this->hasOne(ProductDescription::class, ['id' => 'short_description_id']);
    }
    /**
     * Получает уникальные размеры для категории товаров
     * @param int $categoryId ID категории
     * @return array Массив размеров ['3x3x5' => ['length' => 3, 'width' => 3, 'height' => 5]]
     */
    public static function getUniqueSizesByCategory($categoryId)
    {
        $sizes = Product::find()
            ->where(['category_id' => $categoryId])
            ->andWhere(['IS NOT', 'length', null])
            ->andWhere(['IS NOT', 'width', null])
            ->andWhere(['IS NOT', 'height', null])
            ->andWhere(['>', 'length', 0])
            ->andWhere(['>', 'width', 0])
            ->andWhere(['>', 'height', 0])
            ->andWhere(['status' => 1]) // только активные товары
            ->distinct()
            ->orderBy(['length' => SORT_ASC, 'width' => SORT_ASC, 'height' => SORT_ASC])
            ->all();

        $uniqueSizes = [];
        
        foreach ($sizes as $size) {
            $key = (int)$size['length'] . 'x' . (int)$size['width'] . 'x' . (int)$size['height'];
            $uniqueSizes[$key] = (int)$size['length'] . 'x' . (int)$size['width'] . 'x' . (int)$size['height'];
        }

        return $uniqueSizes;
    }
    /**
     * Получает отзывы товара
     */
    public function getProductReviews()
    {
        return $this->hasMany(Review::class, ['product_id' => 'id'])
            ->where(['status' => Review::STATUS_APPROVED])
            ->orderBy(['published_at' => SORT_DESC]);
    }

    /**
     * Получает опубликованные отзывы из строки reviews
     */
    public function getReviewsFromString()
    {
        return Review::getReviewsByIdsString($this->reviews);
    }

    /**
     * Получает средний рейтинг товара
     */
    public function getAverageRating()
    {
        return $this->getProductReviews()->average('rating') ?: 0;
    }

    /**
     * Получает количество отзывов
     */
    public function getReviewsCount()
    {
        return $this->getProductReviews()->count();
    }

    /**
     * Обновляет поле reviews с ID отзывов
     */
    public function updateReviewsField()
    {
        $reviewIds = $this->getProductReviews()->select('id')->column();
        $this->reviews = !empty($reviewIds) ? implode(',', $reviewIds) : null;
        return $this->save(false);
    }

}
