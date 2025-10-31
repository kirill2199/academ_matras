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
            'customer_last_name' => $this->string(255), // добавлено недостающее поле
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
            'user_agent' => $this->text(), // изменено на text для хранения полного User Agent
            'tracking_number' => $this->string(100), // номер отслеживания
            'weight_total' => $this->decimal(8, 3)->defaultValue(0), // общий вес заказа

            // Добавлены новые поля для расширенной функциональности
            'source' => $this->string(50)->defaultValue('website'), // источник заказа (website, mobile, api)
            'referrer' => $this->string(500), // источник перехода
            'utm_source' => $this->string(100), // UTM метки для аналитики
            'utm_medium' => $this->string(100),
            'utm_campaign' => $this->string(100),
            'utm_term' => $this->string(100),
            'utm_content' => $this->string(100),
            
            // Поля для управления заказом
            'manager_id' => $this->integer(), // менеджер, обрабатывающий заказ
            'priority' => $this->smallInteger()->defaultValue(0), // приоритет заказа
            'estimated_delivery_date' => $this->date(), // предполагаемая дата доставки
            'actual_delivery_date' => $this->datetime(), // фактическая дата доставки
            
            // Поля для возвратов и отмен
            'refund_amount' => $this->decimal(10, 2)->defaultValue(0), // сумма возврата
            'refund_reason' => $this->text(), // причина возврата
            'cancellation_reason' => $this->text(), // причина отмены
            
            // Технические поля
            'version' => $this->integer()->defaultValue(1), // версия для optimistic lock
            'is_deleted' => $this->boolean()->defaultValue(false), // мягкое удаление
        ]);

        // Индексы для основных полей
        $this->createIndex('idx-order-user_id', '{{%order}}', 'user_id');
        $this->createIndex('idx-order-status', '{{%order}}', 'status');
        $this->createIndex('idx-order-payment_status', '{{%order}}', 'payment_status');
        $this->createIndex('idx-order-number', '{{%order}}', 'number');
        $this->createIndex('idx-order-created_at', '{{%order}}', 'created_at');
        $this->createIndex('idx-order-customer_email', '{{%order}}', 'customer_email');
        $this->createIndex('idx-order-customer_phone', '{{%order}}', 'customer_phone');
        
        // Индексы для новых полей
        $this->createIndex('idx-order-manager_id', '{{%order}}', 'manager_id');
        $this->createIndex('idx-order-source', '{{%order}}', 'source');
        $this->createIndex('idx-order-priority', '{{%order}}', 'priority');
        $this->createIndex('idx-order-estimated_delivery_date', '{{%order}}', 'estimated_delivery_date');
        $this->createIndex('idx-order-is_deleted', '{{%order}}', 'is_deleted');
        
        // Составные индексы для часто используемых запросов
        $this->createIndex('idx-order-status-payment', '{{%order}}', ['status', 'payment_status']);
        $this->createIndex('idx-order-created-status', '{{%order}}', ['created_at', 'status']);
        $this->createIndex('idx-order-customer-search', '{{%order}}', ['customer_name', 'customer_last_name', 'customer_email']);

        // Внешние ключи (раскомментировать при необходимости)
        /*
        $this->addForeignKey(
            'fk-order-user_id', 
            '{{%order}}', 
            'user_id', 
            '{{%user}}', 
            'id', 
            'SET NULL', 
            'CASCADE'
        );
        
        $this->addForeignKey(
            'fk-order-manager_id', 
            '{{%order}}', 
            'manager_id', 
            '{{%user}}', 
            'id', 
            'SET NULL', 
            'CASCADE'
        );
        */
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Удаляем внешние ключи если они были созданы
        /*
        $this->dropForeignKey('fk-order-user_id', '{{%order}}');
        $this->dropForeignKey('fk-order-manager_id', '{{%order}}');
        */
        
        $this->dropTable('{{%order}}');
    }
}