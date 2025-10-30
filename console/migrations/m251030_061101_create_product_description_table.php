<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product_description}}`.
 */
class m251030_061101_create_product_description_table extends Migration
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

        // Создаем таблицу product_description
        $this->createTable('{{%product_description}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'short_description' => $this->text(),
            'description' => $this->text(),
            'created_at' => $this->datetime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->datetime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'published_at' => $this->datetime()->null(),
        ], $tableOptions);

        // Создаем индексы для product_description
        $this->createIndex(
            'idx-product_description-product_id',
            '{{%product_description}}',
            'product_id'
        );

        $this->createIndex(
            'idx-product_description-published_at',
            '{{%product_description}}',
            'published_at'
        );

        // Уникальный индекс, чтобы у каждого товара было только одно описание
        $this->createIndex(
            'idx-product_description-product_id-unique',
            '{{%product_description}}',
            'product_id',
            true
        );

        // Добавляем внешний ключ из product_description в product
        $this->addForeignKey(
            'fk-product_description-product_id',
            '{{%product_description}}',
            'product_id',
            '{{%product}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        // Создаем индексы для новых полей в product
        $this->createIndex(
            'idx-product-description_id',
            '{{%product}}',
            'description_id'
        );

        $this->createIndex(
            'idx-product-short_description_id',
            '{{%product}}',
            'short_description_id'
        );

        // Добавляем внешние ключи из product в product_description
        $this->addForeignKey(
            'fk-product-description_id',
            '{{%product}}',
            'description_id',
            '{{%product_description}}',
            'id',
            'SET NULL',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-product-short_description_id',
            '{{%product}}',
            'short_description_id',
            '{{%product_description}}',
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
        // Удаляем внешние ключи из product
        $this->dropForeignKey('fk-product-description_id', '{{%product}}');
        $this->dropForeignKey('fk-product-short_description_id', '{{%product}}');

        // Удаляем поля из product
        $this->dropColumn('{{%product}}', 'description_id');
        $this->dropColumn('{{%product}}', 'short_description_id');

        // Удаляем внешний ключ из product_description
        $this->dropForeignKey('fk-product_description-product_id', '{{%product_description}}');

        // Удаляем таблицу product_description
        $this->dropTable('{{%product_description}}');
    }
}
