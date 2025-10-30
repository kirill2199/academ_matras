<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%cart}}`.
 */
class m251029_131406_create_cart_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%cart}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'session_id' => $this->string(255),
            'product_id' => $this->integer()->notNull(),
            'quantity' => $this->integer()->notNull()->defaultValue(1),
            'price' => $this->decimal(10, 2),
            'attributes' => $this->text(), // JSON с выбранными атрибутами
            'created_at' => $this->datetime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->datetime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // Индексы
        $this->createIndex('idx-cart-user_id', '{{%cart}}', 'user_id');
        $this->createIndex('idx-cart-session_id', '{{%cart}}', 'session_id');
        $this->createIndex('idx-cart-product_id', '{{%cart}}', 'product_id');
        $this->createIndex('idx-cart-user_session', '{{%cart}}', ['user_id', 'session_id']);

        // Внешние ключи
        $this->addForeignKey(
            'fk-cart-product_id',
            '{{%cart}}',
            'product_id',
            '{{%product}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        // Если у вас есть таблица пользователей
        // $this->addForeignKey(
        //     'fk-cart-user_id',
        //     '{{%cart}}',
        //     'user_id',
        //     '{{%user}}',
        //     'id',
        //     'CASCADE',
        //     'CASCADE'
        // );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-cart-product_id', '{{%cart}}');
        // $this->dropForeignKey('fk-cart-user_id', '{{%cart}}');
        $this->dropTable('{{%cart}}');
    }
}