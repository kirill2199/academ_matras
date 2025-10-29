<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%category}}`.
 */
class m251029_131133_create_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%category}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'slug' => $this->string(255)->notNull()->unique(),
            'description' => $this->text(),
            'meta_title' => $this->string(255),
            'meta_description' => $this->string(500),
            'meta_keywords' => $this->string(500),
            'parent_id' => $this->integer()->defaultValue(null),
            'image' => $this->string(500),
            'sort_order' => $this->integer()->defaultValue(0),
            'status' => $this->smallInteger()->defaultValue(1),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        // Индексы
        $this->createIndex('idx-category-parent_id', '{{%category}}', 'parent_id');
        $this->createIndex('idx-category-status', '{{%category}}', 'status');
        $this->createIndex('idx-category-sort_order', '{{%category}}', 'sort_order');
        
        // Внешний ключ для родительской категории
        $this->addForeignKey(
            'fk-category-parent_id',
            '{{%category}}',
            'parent_id',
            '{{%category}}',
            'id',
            'SET NULL',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-category-parent_id', '{{%category}}');
        $this->dropTable('{{%category}}');
    }
}