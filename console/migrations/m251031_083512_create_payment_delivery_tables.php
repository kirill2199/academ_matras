<?php

use yii\db\Migration;

class m251031_083512_create_payment_delivery_tables extends Migration
{

// Основные поля: название, код, описание, инструкции

// Комиссии: фиксированная и процентная

// Ограничения: минимальная/максимальная сумма, страны

// Тип оплаты: онлайн/офлайн, доступность для гостей

// Интеграция: класс обработчика, конфигурация

// Визуал: иконка, цвет, сортировка

// Таблица delivery_method:
// Основные поля: название, код, описание

// Стоимость: базовая цена, бесплатная доставка от суммы

// Сроки: минимальное/максимальное время доставки

// Ограничения: вес, география (страны, регионы, города)

// Типы доставки: самовывоз, курьерская

// Дополнительно: страховка, упаковка

// Ключевые особенности:
// Внешние ключи связывают с таблицей заказов через поле code

// Начальные данные с популярными способами оплаты и доставки

// JSON поля для гибкого хранения настроек и ограничений

// Индексы для оптимизации запросов

// Группировка методов для лучшей организации в интерфейсе

// Миграция создает полнофункциональную систему управления способами оплаты и доставки с поддержкой различных сценариев использования.
   


    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        // Таблица способов оплаты
        $this->createTable('{{%payment_method}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull()->comment('Название способа оплаты'),
            'code' => $this->string(50)->notNull()->unique()->comment('Код способа оплаты'),
            'description' => $this->text()->comment('Описание способа оплаты'),
            'instructions' => $this->text()->comment('Инструкции для клиента'),
            
            // Настройки комиссий
            'fee_fixed' => $this->decimal(10, 2)->defaultValue(0)->comment('Фиксированная комиссия'),
            'fee_percent' => $this->decimal(5, 2)->defaultValue(0)->comment('Процентная комиссия'),
            'min_amount' => $this->decimal(10, 2)->defaultValue(0)->comment('Минимальная сумма'),
            'max_amount' => $this->decimal(10, 2)->comment('Максимальная сумма'),
            
            // Настройки доступности
            'is_active' => $this->boolean()->defaultValue(true)->comment('Активен'),
            'is_online' => $this->boolean()->defaultValue(false)->comment('Онлайн оплата'),
            'available_for_guest' => $this->boolean()->defaultValue(true)->comment('Доступен для гостей'),
            'available_countries' => $this->json()->comment('Доступные страны'),
            'excluded_countries' => $this->json()->comment('Исключенные страны'),
            
            // Сортировка и группировка
            'sort_order' => $this->integer()->defaultValue(0)->comment('Порядок сортировки'),
            'group' => $this->string(100)->comment('Группа способов оплаты'),
            
            // Настройки интеграции
            'handler_class' => $this->string(255)->comment('Класс обработчика'),
            'config' => $this->json()->comment('Конфигурация'),
            
            // Визуальные настройки
            'icon' => $this->string(255)->comment('Иконка'),
            'color' => $this->string(7)->comment('Цвет'),
            
            // Временные метки
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ], $tableOptions);

        // Таблица способов доставки
        $this->createTable('{{%delivery_method}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull()->comment('Название способа доставки'),
            'code' => $this->string(50)->notNull()->unique()->comment('Код способа доставки'),
            'description' => $this->text()->comment('Описание способа доставки'),
            
            // Стоимость доставки
            'price' => $this->decimal(10, 2)->defaultValue(0)->comment('Базовая стоимость'),
            'free_from' => $this->decimal(10, 2)->comment('Бесплатно от суммы'),
            'calculation_type' => $this->string(20)->defaultValue('fixed')->comment('Тип расчета: fixed, weight, distance'),
            
            // Временные параметры
            'min_days' => $this->integer()->comment('Минимальное кол-во дней'),
            'max_days' => $this->integer()->comment('Максимальное кол-во дней'),
            'cutoff_time' => $this->time()->comment('Время отсечения'),
            
            // Весовые ограничения
            'min_weight' => $this->decimal(8, 3)->comment('Минимальный вес'),
            'max_weight' => $this->decimal(8, 3)->comment('Максимальный вес'),
            
            // Географические ограничения
            'available_countries' => $this->json()->comment('Доступные страны'),
            'excluded_countries' => $this->json()->comment('Исключенные страны'),
            'available_regions' => $this->json()->comment('Доступные регионы'),
            'available_cities' => $this->json()->comment('Доступные города'),
            
            // Настройки доступности
            'is_active' => $this->boolean()->defaultValue(true)->comment('Активен'),
            'is_self_delivery' => $this->boolean()->defaultValue(false)->comment('Самовывоз'),
            'needs_address' => $this->boolean()->defaultValue(true)->comment('Требуется адрес'),
            
            // Сортировка и группировка
            'sort_order' => $this->integer()->defaultValue(0)->comment('Порядок сортировки'),
            'group' => $this->string(100)->comment('Группа способов доставки'),
            
            // Настройки интеграции
            'handler_class' => $this->string(255)->comment('Класс обработчика'),
            'tracking_url' => $this->string(500)->comment('URL для отслеживания'),
            'config' => $this->json()->comment('Конфигурация'),
            
            // Дополнительные настройки
            'insurance_available' => $this->boolean()->defaultValue(false)->comment('Доступна страховка'),
            'insurance_rate' => $this->decimal(5, 2)->defaultValue(0)->comment('Ставка страховки'),
            'packaging_fee' => $this->decimal(10, 2)->defaultValue(0)->comment('Стоимость упаковки'),
            
            // Визуальные настройки
            'icon' => $this->string(255)->comment('Иконка'),
            'color' => $this->string(7)->comment('Цвет'),
            
            // Временные метки
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ], $tableOptions);

        // Индексы для payment_method
        $this->createIndex('idx-payment_method-code', '{{%payment_method}}', 'code');
        $this->createIndex('idx-payment_method-active', '{{%payment_method}}', 'is_active');
        $this->createIndex('idx-payment_method-sort', '{{%payment_method}}', ['sort_order', 'id']);
        $this->createIndex('idx-payment_method-online', '{{%payment_method}}', 'is_online');
        
        // Индексы для delivery_method
        $this->createIndex('idx-delivery_method-code', '{{%delivery_method}}', 'code');
        $this->createIndex('idx-delivery_method-active', '{{%delivery_method}}', 'is_active');
        $this->createIndex('idx-delivery_method-sort', '{{%delivery_method}}', ['sort_order', 'id']);
        $this->createIndex('idx-delivery_method-self', '{{%delivery_method}}', 'is_self_delivery');
        $this->createIndex('idx-delivery_method-price', '{{%delivery_method}}', 'price');

        // Добавляем связь с таблицей заказов (внешние ключи)
        $this->addForeignKey(
            'fk-order-payment_method', 
            '{{%order}}', 
            'payment_method', 
            '{{%payment_method}}', 
            'code', 
            'SET NULL', 
            'CASCADE'
        );
        
        $this->addForeignKey(
            'fk-order-delivery_method', 
            '{{%order}}', 
            'delivery_method', 
            '{{%delivery_method}}', 
            'code', 
            'SET NULL', 
            'CASCADE'
        );

        // Заполняем таблицы начальными данными
        $this->insertInitialData();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Удаляем внешние ключи
        $this->dropForeignKey('fk-order-payment_method', '{{%order}}');
        $this->dropForeignKey('fk-order-delivery_method', '{{%order}}');
        
        // Удаляем таблицы
        $this->dropTable('{{%delivery_method}}');
        $this->dropTable('{{%payment_method}}');
    }

    /**
     * Заполняет таблицы начальными данными
     */
    private function insertInitialData()
    {
        // Начальные данные для способов оплаты
        $this->batchInsert('{{%payment_method}}', [
            'name', 'code', 'description', 'is_online', 'fee_percent', 'sort_order', 'group'
        ], [
            ['Наличными при получении', 'cash', 'Оплата наличными курьеру при получении заказа', false, 0, 1, 'offline'],
            ['Банковской картой онлайн', 'card', 'Оплата банковской картой через безопасный шлюз', true, 2.5, 2, 'online'],
            ['Apple Pay/Google Pay', 'wallet', 'Оплата через Apple Pay или Google Pay', true, 2.0, 3, 'online'],
            ['СБП (Система быстрых платежей)', 'sbp', 'Оплата через СБП по QR-коду', true, 1.5, 4, 'online'],
            ['ЮMoney', 'yoomoney', 'Оплата через ЮMoney', true, 2.0, 5, 'online'],
            ['Сбербанк Онлайн', 'sberbank', 'Оплата через Сбербанк Онлайн', true, 2.0, 6, 'online'],
            ['Тинькофф', 'tinkoff', 'Оплата через Тинькофф', true, 2.0, 7, 'online'],
            ['Криптовалюта', 'crypto', 'Оплата криптовалютой (Bitcoin, Ethereum)', true, 3.0, 8, 'online'],
        ]);

        // Начальные данные для способов доставки
        $this->batchInsert('{{%delivery_method}}', [
            'name', 'code', 'description', 'price', 'free_from', 'min_days', 'max_days', 'is_self_delivery', 'sort_order'
        ], [
            ['Курьерская доставка', 'courier', 'Доставка курьером до двери', 300.00, 2000.00, 1, 3, false, 1],
            ['Самовывоз из пункта выдачи', 'pickup', 'Самовывоз из пункта выдачи заказов', 0.00, 0.00, 1, 2, true, 2],
            ['Почта России', 'russian_post', 'Доставка через Почту России', 250.00, 3000.00, 5, 14, false, 3],
            ['СДЭК', 'cdek', 'Доставка через службу СДЭК', 350.00, 2500.00, 2, 5, false, 4],
            ['Boxberry', 'boxberry', 'Доставка через Boxberry', 320.00, 2200.00, 2, 6, false, 5],
            ['DHL', 'dhl', 'Международная доставка DHL', 1500.00, null, 3, 7, false, 6],
            ['Экспресс-доставка', 'express', 'Экспресс-доставка в течение 24 часов', 800.00, 5000.00, 1, 1, false, 7],
        ]);
    }
}