<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "characteristic".
 *
 * @property int $id
 * @property string $name
 * @property string $type
 * @property string|null $unit
 * @property int|null $sort_order
 * @property int|null $required
 * @property string|null $variants
 * @property int|null $category_id
 * @property int|null $filterable
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Category $category
 * @property ProductCharacteristic[] $productCharacteristics
 * @property Product[] $products
 */
class Characteristic extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'characteristic';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['unit', 'variants', 'category_id'], 'default', 'value' => null],
            [['type'], 'default', 'value' => 'string'],
            [['filterable'], 'default', 'value' => 0],
            [['name'], 'required'],
            [['sort_order', 'required', 'category_id', 'filterable'], 'integer'],
            [['variants'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['type', 'unit'], 'string', 'max' => 50],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
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
            'type' => 'Type',
            'unit' => 'Unit',
            'sort_order' => 'Sort Order',
            'required' => 'Required',
            'variants' => 'Variants',
            'category_id' => 'Category ID',
            'filterable' => 'Filterable',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
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
     * Gets query for [[ProductCharacteristics]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductCharacteristics()
    {
        return $this->hasMany(ProductCharacteristic::class, ['characteristic_id' => 'id']);
    }

    /**
     * Gets query for [[Products]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::class, ['id' => 'product_id'])->viaTable('product_characteristic', ['characteristic_id' => 'id']);
    }

}
