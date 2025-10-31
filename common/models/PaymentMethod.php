<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "payment_method".
 *
 * @property int $id
 * @property string $name Название способа оплаты
 * @property string $code Код способа оплаты
 * @property string|null $description Описание способа оплаты
 * @property string|null $instructions Инструкции для клиента
 * @property float|null $fee_fixed Фиксированная комиссия
 * @property float|null $fee_percent Процентная комиссия
 * @property float|null $min_amount Минимальная сумма
 * @property float|null $max_amount Максимальная сумма
 * @property int|null $is_active Активен
 * @property int|null $is_online Онлайн оплата
 * @property int|null $available_for_guest Доступен для гостей
 * @property string|null $available_countries Доступные страны
 * @property string|null $excluded_countries Исключенные страны
 * @property int|null $sort_order Порядок сортировки
 * @property string|null $group Группа способов оплаты
 * @property string|null $handler_class Класс обработчика
 * @property string|null $config Конфигурация
 * @property string|null $icon Иконка
 * @property string|null $color Цвет
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Order[] $orders
 */
class PaymentMethod extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payment_method';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description', 'instructions', 'max_amount', 'available_countries', 'excluded_countries', 'group', 'handler_class', 'config', 'icon', 'color'], 'default', 'value' => null],
            [['min_amount'], 'default', 'value' => 0.00],
            [['available_for_guest'], 'default', 'value' => 1],
            [['sort_order'], 'default', 'value' => 0],
            [['name', 'code'], 'required'],
            [['description', 'instructions'], 'string'],
            [['fee_fixed', 'fee_percent', 'min_amount', 'max_amount'], 'number'],
            [['is_active', 'is_online', 'available_for_guest', 'sort_order'], 'integer'],
            [['available_countries', 'excluded_countries', 'config', 'created_at', 'updated_at'], 'safe'],
            [['name', 'handler_class', 'icon'], 'string', 'max' => 255],
            [['code'], 'string', 'max' => 50],
            [['group'], 'string', 'max' => 100],
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
            'instructions' => 'Instructions',
            'fee_fixed' => 'Fee Fixed',
            'fee_percent' => 'Fee Percent',
            'min_amount' => 'Min Amount',
            'max_amount' => 'Max Amount',
            'is_active' => 'Is Active',
            'is_online' => 'Is Online',
            'available_for_guest' => 'Available For Guest',
            'available_countries' => 'Available Countries',
            'excluded_countries' => 'Excluded Countries',
            'sort_order' => 'Sort Order',
            'group' => 'Group',
            'handler_class' => 'Handler Class',
            'config' => 'Config',
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
        return $this->hasMany(Order::class, ['payment_method' => 'code']);
    }

}
