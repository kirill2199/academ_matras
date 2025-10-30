<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product_characteristic}}`.
 */
class m251029_131327_create_product_characteristic_table extends Migration
{
     /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product_characteristic}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'characteristic_id' => $this->integer()->notNull(),
            'value_string' => $this->string(500),
            'value_integer' => $this->integer(),
            'value_decimal' => $this->decimal(10, 3),
            'value_boolean' => $this->boolean(),
            'value_text' => $this->text(),
        ]);

        // Составной уникальный индекс
        $this->createIndex(
            'idx-product_characteristic-product_id-characteristic_id', 
            '{{%product_characteristic}}', 
            ['product_id', 'characteristic_id'],
            true
        );

        // Индексы для поиска по значениям
        $this->createIndex('idx-product_characteristic-value_string', '{{%product_characteristic}}', 'value_string');
        $this->createIndex('idx-product_characteristic-value_integer', '{{%product_characteristic}}', 'value_integer');
        $this->createIndex('idx-product_characteristic-value_decimal', '{{%product_characteristic}}', 'value_decimal');

        // Внешние ключи
        $this->addForeignKey(
            'fk-product_characteristic-product_id',
            '{{%product_characteristic}}',
            'product_id',
            '{{%product}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-product_characteristic-characteristic_id',
            '{{%product_characteristic}}',
            'characteristic_id',
            '{{%characteristic}}',
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
        $this->dropForeignKey('fk-product_characteristic-product_id', '{{%product_characteristic}}');
        $this->dropForeignKey('fk-product_characteristic-characteristic_id', '{{%product_characteristic}}');
        $this->dropTable('{{%product_characteristic}}');
    }
}