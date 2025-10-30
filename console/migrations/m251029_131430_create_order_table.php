<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order}}`.
 */
class m251029_131430_create_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%order}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'number' => $this->string(50)->notNull()->unique(), // номер заказа
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'payment_status' => $this->smallInteger()->notNull()->defaultValue(0),
            'payment_method' => $this->string(100),
            'delivery_method' => $this->string(100),
            'delivery_price' => $this->decimal(10, 2)->defaultValue(0),
            
            // Контактная информация
            'customer_name' => $this->string(255)->notNull(),
            'customer_email' => $this->string(255),
            'customer_phone' => $this->string(50)->notNull(),
            
            // Адрес доставки
            'delivery_address' => $this->text(),
            'delivery_city' => $this->string(255),
            'delivery_region' => $this->string(255),
            'delivery_country' => $this->string(100),
            'delivery_postcode' => $this->string(20),
            
            // Стоимость
            'subtotal' => $this->decimal(10, 2)->notNull(),
            'tax_amount' => $this->decimal(10, 2)->defaultValue(0),
            'discount_amount' => $this->decimal(10, 2)->defaultValue(0),
            'total' => $this->decimal(10, 2)->notNull(),
            
            // Валюта
            'currency' => $this->string(3)->defaultValue('RUB'),
            'exchange_rate' => $this->decimal(10, 6)->defaultValue(1),
            
            // Комментарии
            'customer_comment' => $this->text(),
            'admin_comment' => $this->text(),
            
            // Временные метки
            'created_at' => $this->datetime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->datetime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'paid_at' => $this->datetime(),
            'completed_at' => $this->datetime(),
            'cancelled_at' => $this->datetime(),
            
            // Дополнительная информация
            'ip_address' => $this->string(45),
            'user_agent' => $this->string(500),
            'tracking_number' => $this->string(100), // номер отслеживания
            'weight_total' => $this->decimal(8, 3), // общий вес заказа
        ]);

        // Индексы
        $this->createIndex('idx-order-user_id', '{{%order}}', 'user_id');
        $this->createIndex('idx-order-status', '{{%order}}', 'status');
        $this->createIndex('idx-order-payment_status', '{{%order}}', 'payment_status');
        $this->createIndex('idx-order-number', '{{%order}}', 'number');
        $this->createIndex('idx-order-created_at', '{{%order}}', 'created_at');
        $this->createIndex('idx-order-customer_email', '{{%order}}', 'customer_email');
        $this->createIndex('idx-order-customer_phone', '{{%order}}', 'customer_phone');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%order}}');
    }
}