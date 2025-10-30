<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_characteristic".
 *
 * @property int $id
 * @property int $product_id
 * @property int $characteristic_id
 * @property string|null $value_string
 * @property int|null $value_integer
 * @property float|null $value_decimal
 * @property int|null $value_boolean
 * @property string|null $value_text
 *
 * @property Characteristic $characteristic
 * @property Product $product
 */
class ProductCharacteristic extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_characteristic';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['value_string', 'value_integer', 'value_decimal', 'value_boolean', 'value_text'], 'default', 'value' => null],
            [['product_id', 'characteristic_id'], 'required'],
            [['product_id', 'characteristic_id', 'value_integer', 'value_boolean'], 'integer'],
            [['value_decimal'], 'number'],
            [['value_text'], 'string'],
            [['value_string'], 'string', 'max' => 500],
            [['product_id', 'characteristic_id'], 'unique', 'targetAttribute' => ['product_id', 'characteristic_id']],
            [['characteristic_id'], 'exist', 'skipOnError' => true, 'targetClass' => Characteristic::class, 'targetAttribute' => ['characteristic_id' => 'id']],
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
            'characteristic_id' => 'Characteristic ID',
            'value_string' => 'Value String',
            'value_integer' => 'Value Integer',
            'value_decimal' => 'Value Decimal',
            'value_boolean' => 'Value Boolean',
            'value_text' => 'Value Text',
        ];
    }

    /**
     * Gets query for [[Characteristic]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCharacteristic()
    {
        return $this->hasOne(Characteristic::class, ['id' => 'characteristic_id']);
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
