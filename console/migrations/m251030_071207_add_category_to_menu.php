<?php

use yii\db\Migration;

class m251030_071207_add_category_to_menu extends Migration
{
     /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Добавляем поле для связи с категорией
        $this->addColumn('{{%menu_item}}', 'category_id', $this->integer()->null());

        // Добавляем индекс
        $this->createIndex('idx-menu_item-category_id', '{{%menu_item}}', 'category_id');

        // Внешний ключ для категорий
        $this->addForeignKey(
            'fk-menu_item-category_id',
            '{{%menu_item}}',
            'category_id',
            '{{%category}}',
            'id',
            'SET NULL',
            'CASCADE'
        );

        // Добавляем поле для типа контента
        $this->addColumn('{{%menu_item}}', 'item_type', $this->string(50)->defaultValue('custom'));
        // custom, category, page, product, url

        $this->createIndex('idx-menu_item-item_type', '{{%menu_item}}', 'item_type');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-menu_item-category_id', '{{%menu_item}}');
        $this->dropIndex('idx-menu_item-category_id', '{{%menu_item}}');
        $this->dropIndex('idx-menu_item-item_type', '{{%menu_item}}');
        $this->dropColumn('{{%menu_item}}', 'category_id');
        $this->dropColumn('{{%menu_item}}', 'item_type');
    }
}