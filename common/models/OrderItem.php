<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "order_item".
 *
 * @property int $id
 * @property int $order_id
 * @property int $product_id
 * @property string $name
 * @property string|null $sku
 * @property int $quantity
 * @property float $price
 * @property float $total
 * @property float|null $weight
 * @property string|null $attributes
 * @property string $created_at
 *
 * @property Order $order
 * @property Product $product
 */
class OrderItem extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sku', 'weight', 'attributes'], 'default', 'value' => null],
            [['order_id', 'product_id', 'name', 'quantity', 'price', 'total'], 'required'],
            [['order_id', 'product_id', 'quantity'], 'integer'],
            [['price', 'total', 'weight'], 'number'],
            [['attributes'], 'string'],
            [['created_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['sku'], 'string', 'max' => 100],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::class, 'targetAttribute' => ['order_id' => 'id']],
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
            'order_id' => 'Order ID',
            'product_id' => 'Product ID',
            'name' => 'Name',
            'sku' => 'Sku',
            'quantity' => 'Quantity',
            'price' => 'Price',
            'total' => 'Total',
            'weight' => 'Weight',
            'attributes' => 'Attributes',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Order]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::class, ['id' => 'order_id']);
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

}
