<?php

use yii\db\Migration;

class m251030_071024_create_menu_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        // Таблица для меню
        $this->createTable('{{%menu}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'slug' => $this->string(255)->notNull()->unique(),
            'description' => $this->text(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => $this->datetime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->datetime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ], $tableOptions);

        // Таблица для пунктов меню
        $this->createTable('{{%menu_item}}', [
            'id' => $this->primaryKey(),
            'menu_id' => $this->integer()->notNull(),
            'parent_id' => $this->integer()->null(),
            'title' => $this->string(255)->notNull(),
            'url' => $this->string(500),
            'route' => $this->string(255),
            'params' => $this->text(), // JSON параметры для route
            'icon' => $this->string(100),
            'target' => $this->string(20)->defaultValue('_self'), // _self, _blank
            'rel' => $this->string(100),
            'css_class' => $this->string(100),
            'description' => $this->text(),
            'sort_order' => $this->integer()->defaultValue(0),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => $this->datetime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->datetime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ], $tableOptions);

        // Индексы для таблицы menu
        $this->createIndex('idx-menu-slug', '{{%menu}}', 'slug');
        $this->createIndex('idx-menu-status', '{{%menu}}', 'status');

        // ИСПРАВЛЕННЫЕ ИНДЕКСЫ для таблицы menu_item
        // Правильно: создаем индекс для поля menu_id в таблице menu_item
        $this->createIndex('idx-menu_item-menu_id', '{{%menu_item}}', 'menu_id');
        $this->createIndex('idx-menu_item-parent_id', '{{%menu_item}}', 'parent_id');
        $this->createIndex('idx-menu_item-sort_order', '{{%menu_item}}', 'sort_order');
        $this->createIndex('idx-menu_item-status', '{{%menu_item}}', 'status');
        $this->createIndex('idx-menu_item-route', '{{%menu_item}}', 'route');

        // Составной индекс для оптимизации
        $this->createIndex('idx-menu_item-menu_status', '{{%menu_item}}', ['menu_id', 'status']);

        // Внешние ключи
        $this->addForeignKey(
            'fk-menu_item-menu_id',
            '{{%menu_item}}',
            'menu_id',
            '{{%menu}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-menu_item-parent_id',
            '{{%menu_item}}',
            'parent_id',
            '{{%menu_item}}',
            'id',
            'SET NULL',
            'CASCADE'
        );

        // Добавляем базовые меню
        $this->insertMenuData();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Удаляем внешние ключи
        $this->dropForeignKey('fk-menu_item-parent_id', '{{%menu_item}}');
        $this->dropForeignKey('fk-menu_item-menu_id', '{{%menu_item}}');

        // Удаляем таблицы
        $this->dropTable('{{%menu_item}}');
        $this->dropTable('{{%menu}}');
    }

    /**
     * Добавляет базовые данные меню
     */
    private function insertMenuData()
    {
        $time = date('Y-m-d H:i:s'); // строка в формате DATETIME

        // Основные меню интернет-магазина
        $menus = [
            [
                'name' => 'Основное меню',
                'slug' => 'main-menu',
                'description' => 'Главное меню сайта',
                'status' => 1,
                'created_at' =>  $time,
                'updated_at' => $time,
            ],
            [
                'name' => 'Меню в подвале',
                'slug' => 'footer-menu',
                'description' => 'Меню в нижней части сайта',
                'status' => 1,
                'created_at' => $time,
                'updated_at' => $time,
            ],
            [
                'name' => 'Меню категорий',
                'slug' => 'category-menu',
                'description' => 'Меню категорий товаров',
                'status' => 1,
                'created_at' => $time,
                'updated_at' => $time,
            ],
            [
                'name' => 'Пользовательское меню',
                'slug' => 'user-menu',
                'description' => 'Меню для авторизованных пользователей',
                'status' => 1,
                'created_at' => $time,
                'updated_at' => $time,
            ],
        ];

        foreach ($menus as $menu) {
            $this->insert('{{%menu}}', $menu);
        }

        // Добавляем пункты для основного меню
        $mainMenuId = 1;
        $menuItems = [
            // Пункты верхнего уровня
            [
                'menu_id' => $mainMenuId,
                'parent_id' => null,
                'title' => 'Главная',
                'route' => '/',
                'sort_order' => 1,
                'status' => 1,
                'created_at' => $time,
                'updated_at' => $time,
            ],
            [
                'menu_id' => $mainMenuId,
                'parent_id' => null,
                'title' => 'Каталог',
                'route' => '/shop/default/index',
                'sort_order' => 2,
                'status' => 1,
                'created_at' => $time,
                'updated_at' => $time,
            ],
            [
                'menu_id' => $mainMenuId,
                'parent_id' => null,
                'title' => 'Акции',
                'route' => '/shop/default/sale',
                'sort_order' => 3,
                'status' => 1,
                'created_at' => $time,
                'updated_at' => $time,
            ],
            [
                'menu_id' => $mainMenuId,
                'parent_id' => null,
                'title' => 'Новинки',
                'route' => '/shop/default/new',
                'sort_order' => 4,
                'status' => 1,
                'created_at' => $time,
                'updated_at' => $time,
            ],
            [
                'menu_id' => $mainMenuId,
                'parent_id' => null,
                'title' => 'О нас',
                'route' => '/site/about',
                'sort_order' => 5,
                'status' => 1,
                'created_at' => $time,
                'updated_at' => $time,
            ],
            [
                'menu_id' => $mainMenuId,
                'parent_id' => null,
                'title' => 'Контакты',
                'route' => '/site/contact',
                'sort_order' => 6,
                'status' => 1,
                'created_at' => $time,
                'updated_at' => $time,
            ],
        ];

        foreach ($menuItems as $item) {
            $this->insert('{{%menu_item}}', $item);
        }

        // Добавляем подпункты для меню в подвале
        $footerMenuId = 2;
        $footerItems = [
            [
                'menu_id' => $footerMenuId,
                'parent_id' => null,
                'title' => 'Помощь',
                'route' => '/site/help',
                'sort_order' => 1,
                'status' => 1,
                'created_at' => $time,
                'updated_at' => $time,
            ],
            [
                'menu_id' => $footerMenuId,
                'parent_id' => null,
                'title' => 'Доставка',
                'route' => '/site/delivery',
                'sort_order' => 2,
                'status' => 1,
                'created_at' => $time,
                'updated_at' => $time,
            ],
            [
                'menu_id' => $footerMenuId,
                'parent_id' => null,
                'title' => 'Оплата',
                'route' => '/site/payment',
                'sort_order' => 3,
                'status' => 1,
                'created_at' => $time,
                'updated_at' => $time,
            ],
            [
                'menu_id' => $footerMenuId,
                'parent_id' => null,
                'title' => 'Гарантия',
                'route' => '/site/warranty',
                'sort_order' => 4,
                'status' => 1,
                'created_at' => $time,
                'updated_at' => $time,
            ],
            [
                'menu_id' => $footerMenuId,
                'parent_id' => null,
                'title' => 'Возврат',
                'route' => '/site/return',
                'sort_order' => 5,
                'status' => 1,
                'created_at' => $time,
                'updated_at' => $time,
            ],
        ];

        foreach ($footerItems as $item) {
            $this->insert('{{%menu_item}}', $item);
        }
    }
}