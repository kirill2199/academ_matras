<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "delivery_method".
 *
 * @property int $id
 * @property string $name Название способа доставки
 * @property string $code Код способа доставки
 * @property string|null $description Описание способа доставки
 * @property float|null $price Базовая стоимость
 * @property float|null $free_from Бесплатно от суммы
 * @property string|null $calculation_type Тип расчета: fixed, weight, distance
 * @property int|null $min_days Минимальное кол-во дней
 * @property int|null $max_days Максимальное кол-во дней
 * @property string|null $cutoff_time Время отсечения
 * @property float|null $min_weight Минимальный вес
 * @property float|null $max_weight Максимальный вес
 * @property string|null $available_countries Доступные страны
 * @property string|null $excluded_countries Исключенные страны
 * @property string|null $available_regions Доступные регионы
 * @property string|null $available_cities Доступные города
 * @property int|null $is_active Активен
 * @property int|null $is_self_delivery Самовывоз
 * @property int|null $needs_address Требуется адрес
 * @property int|null $sort_order Порядок сортировки
 * @property string|null $group Группа способов доставки
 * @property string|null $handler_class Класс обработчика
 * @property string|null $tracking_url URL для отслеживания
 * @property string|null $config Конфигурация
 * @property int|null $insurance_available Доступна страховка
 * @property float|null $insurance_rate Ставка страховки
 * @property float|null $packaging_fee Стоимость упаковки
 * @property string|null $icon Иконка
 * @property string|null $color Цвет
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Order[] $orders
 */
class DeliveryMethod extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'delivery_method';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description', 'free_from', 'min_days', 'max_days', 'cutoff_time', 'min_weight', 'max_weight', 'available_countries', 'excluded_countries', 'available_regions', 'available_cities', 'group', 'handler_class', 'tracking_url', 'config', 'icon', 'color'], 'default', 'value' => null],
            [['packaging_fee'], 'default', 'value' => 0.00],
            [['calculation_type'], 'default', 'value' => 'fixed'],
            [['needs_address'], 'default', 'value' => 1],
            [['insurance_available'], 'default', 'value' => 0],
            [['name', 'code'], 'required'],
            [['description'], 'string'],
            [['price', 'free_from', 'min_weight', 'max_weight', 'insurance_rate', 'packaging_fee'], 'number'],
            [['min_days', 'max_days', 'is_active', 'is_self_delivery', 'needs_address', 'sort_order', 'insurance_available'], 'integer'],
            [['cutoff_time', 'available_countries', 'excluded_countries', 'available_regions', 'available_cities', 'config', 'created_at', 'updated_at'], 'safe'],
            [['name', 'handler_class', 'icon'], 'string', 'max' => 255],
            [['code'], 'string', 'max' => 50],
            [['calculation_type'], 'string', 'max' => 20],
            [['group'], 'string', 'max' => 100],
            [['tracking_url'], 'string', 'max' => 500],
            [['color'], 'string', 'max' => 7],
            [['code'], 'unique'],
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
            'code' => 'Code',
            'description' => 'Description',
            'price' => 'Price',
            'free_from' => 'Free From',
            'calculation_type' => 'Calculation Type',
            'min_days' => 'Min Days',
            'max_days' => 'Max Days',
            'cutoff_time' => 'Cutoff Time',
            'min_weight' => 'Min Weight',
            'max_weight' => 'Max Weight',
            'available_countries' => 'Available Countries',
            'excluded_countries' => 'Excluded Countries',
            'available_regions' => 'Available Regions',
            'available_cities' => 'Available Cities',
            'is_active' => 'Is Active',
            'is_self_delivery' => 'Is Self Delivery',
            'needs_address' => 'Needs Address',
            'sort_order' => 'Sort Order',
            'group' => 'Group',
            'handler_class' => 'Handler Class',
            'tracking_url' => 'Tracking Url',
            'config' => 'Config',
            'insurance_available' => 'Insurance Available',
            'insurance_rate' => 'Insurance Rate',
            'packaging_fee' => 'Packaging Fee',
            'icon' => 'Icon',
            'color' => 'Color',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::class, ['delivery_method' => 'code']);
    }

}
