<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $number
 * @property int $status
 * @property int $payment_status
 * @property string|null $payment_method
 * @property string|null $delivery_method
 * @property float|null $delivery_price
 * @property string $customer_name
 * @property string|null $customer_last_name
 * @property string|null $customer_email
 * @property string $customer_phone
 * @property string|null $delivery_address
 * @property string|null $delivery_city
 * @property string|null $delivery_region
 * @property string|null $delivery_country
 * @property string|null $delivery_postcode
 * @property float $subtotal
 * @property float|null $tax_amount
 * @property float|null $discount_amount
 * @property float $total
 * @property string|null $currency
 * @property float|null $exchange_rate
 * @property string|null $customer_comment
 * @property string|null $admin_comment
 * @property string $created_at
 * @property string $updated_at
 * @property string|null $paid_at
 * @property string|null $completed_at
 * @property string|null $cancelled_at
 * @property string|null $ip_address
 * @property string|null $user_agent
 * @property string|null $tracking_number
 * @property float|null $weight_total
 * @property string|null $source
 * @property string|null $referrer
 * @property string|null $utm_source
 * @property string|null $utm_medium
 * @property string|null $utm_campaign
 * @property string|null $utm_term
 * @property string|null $utm_content
 * @property int|null $manager_id
 * @property int|null $priority
 * @property string|null $estimated_delivery_date
 * @property string|null $actual_delivery_date
 * @property float|null $refund_amount
 * @property string|null $refund_reason
 * @property string|null $cancellation_reason
 * @property int|null $version
 * @property int|null $is_deleted
 *
 * @property OrderItem[] $orderItems
 */
class Order extends \yii\db\ActiveRecord
{
    const STATUS_NEW = 1;
    const STATUS_PROCESSING = 2;
    const STATUS_SHIPPED = 3;
    const STATUS_COMPLETED = 4;
    const STATUS_CANCELLED = 5;
    
    const PAYMENT_STATUS_PENDING = 1;
    const PAYMENT_STATUS_PAID = 2;
    const PAYMENT_STATUS_FAILED = 3;
    const PAYMENT_STATUS_REFUNDED = 4;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'payment_method', 'delivery_method', 'customer_last_name', 'customer_email', 'delivery_address', 'delivery_city', 'delivery_region', 'delivery_country', 'delivery_postcode', 'customer_comment', 'admin_comment', 'paid_at', 'completed_at', 'cancelled_at', 'ip_address', 'user_agent', 'tracking_number', 'referrer', 'utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content', 'manager_id', 'estimated_delivery_date', 'actual_delivery_date', 'refund_reason', 'cancellation_reason'], 'default', 'value' => null],
            [['is_deleted'], 'default', 'value' => 0],
            [['refund_amount'], 'default', 'value' => 0.00],
            [['currency'], 'default', 'value' => 'RUB'],
            [['exchange_rate'], 'default', 'value' => 1.000000],
            [['weight_total'], 'default', 'value' => 0.000],
            [['source'], 'default', 'value' => 'website'],
            [['version'], 'default', 'value' => 1],
            [['user_id', 'status', 'payment_status', 'manager_id', 'priority', 'version', 'is_deleted'], 'integer'],
            [['number', 'customer_name', 'customer_phone', 'subtotal', 'total'], 'required'],
            [['delivery_price', 'subtotal', 'tax_amount', 'discount_amount', 'total', 'exchange_rate', 'weight_total', 'refund_amount'], 'number'],
            [['delivery_address', 'customer_comment', 'admin_comment', 'user_agent', 'refund_reason', 'cancellation_reason'], 'string'],
            [['created_at', 'updated_at', 'paid_at', 'completed_at', 'cancelled_at', 'estimated_delivery_date', 'actual_delivery_date'], 'safe'],
            [['number', 'customer_phone', 'source'], 'string', 'max' => 50],
            [['payment_method', 'delivery_method', 'delivery_country', 'tracking_number', 'utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content'], 'string', 'max' => 100],
            [['customer_name', 'customer_last_name', 'customer_email', 'delivery_city', 'delivery_region'], 'string', 'max' => 255],
            [['delivery_postcode'], 'string', 'max' => 20],
            [['currency'], 'string', 'max' => 3],
            [['ip_address'], 'string', 'max' => 45],
            [['referrer'], 'string', 'max' => 500],
            [['number'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'number' => 'Number',
            'status' => 'Status',
            'payment_status' => 'Payment Status',
            'payment_method' => 'Payment Method',
            'delivery_method' => 'Delivery Method',
            'delivery_price' => 'Delivery Price',
            'customer_name' => 'Customer Name',
            'customer_last_name' => 'Customer Last Name',
            'customer_email' => 'Customer Email',
            'customer_phone' => 'Customer Phone',
            'delivery_address' => 'Delivery Address',
            'delivery_city' => 'Delivery City',
            'delivery_region' => 'Delivery Region',
            'delivery_country' => 'Delivery Country',
            'delivery_postcode' => 'Delivery Postcode',
            'subtotal' => 'Subtotal',
            'tax_amount' => 'Tax Amount',
            'discount_amount' => 'Discount Amount',
            'total' => 'Total',
            'currency' => 'Currency',
            'exchange_rate' => 'Exchange Rate',
            'customer_comment' => 'Customer Comment',
            'admin_comment' => 'Admin Comment',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'paid_at' => 'Paid At',
            'completed_at' => 'Completed At',
            'cancelled_at' => 'Cancelled At',
            'ip_address' => 'Ip Address',
            'user_agent' => 'User Agent',
            'tracking_number' => 'Tracking Number',
            'weight_total' => 'Weight Total',
            'source' => 'Source',
            'referrer' => 'Referrer',
            'utm_source' => 'Utm Source',
            'utm_medium' => 'Utm Medium',
            'utm_campaign' => 'Utm Campaign',
            'utm_term' => 'Utm Term',
            'utm_content' => 'Utm Content',
            'manager_id' => 'Manager ID',
            'priority' => 'Priority',
            'estimated_delivery_date' => 'Estimated Delivery Date',
            'actual_delivery_date' => 'Actual Delivery Date',
            'refund_amount' => 'Refund Amount',
            'refund_reason' => 'Refund Reason',
            'cancellation_reason' => 'Cancellation Reason',
            'version' => 'Version',
            'is_deleted' => 'Is Deleted',
        ];
    }

    /**
     * Gets query for [[OrderItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::class, ['order_id' => 'id']);
    }

}
