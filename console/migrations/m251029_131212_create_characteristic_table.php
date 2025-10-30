<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%characteristic}}`.
 */
class m251029_131212_create_characteristic_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%characteristic}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'type' => $this->string(50)->notNull()->defaultValue('string'), // string, integer, decimal, boolean, select
            'unit' => $this->string(50), // единица измерения (кг, см, мм и т.д.)
            'sort_order' => $this->integer()->defaultValue(0),
            'required' => $this->boolean()->defaultValue(false),
            'variants' => $this->text(), // JSON с вариантами для select типа
            'category_id' => $this->integer(),
            'filterable' => $this->boolean()->defaultValue(false),
            'created_at' => $this->datetime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->datetime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // Индексы
        $this->createIndex('idx-characteristic-category_id', '{{%characteristic}}', 'category_id');
        $this->createIndex('idx-characteristic-type', '{{%characteristic}}', 'type');
        $this->createIndex('idx-characteristic-sort_order', '{{%characteristic}}', 'sort_order');
        
        // Внешний ключ
        $this->addForeignKey(
            'fk-characteristic-category_id',
            '{{%characteristic}}',
            'category_id',
            '{{%category}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-characteristic-category_id', '{{%characteristic}}');
        $this->dropTable('{{%characteristic}}');
    }
}