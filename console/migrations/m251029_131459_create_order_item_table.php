<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order_item}}`.
 */
class m251029_131459_create_order_item_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%order_item}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
            'name' => $this->string(255)->notNull(), // название на момент заказа
            'sku' => $this->string(100), // артикул на момент заказа
            'quantity' => $this->integer()->notNull(),
            'price' => $this->decimal(10, 2)->notNull(), // цена за единицу на момент заказа
            'total' => $this->decimal(10, 2)->notNull(), // общая стоимость
            'weight' => $this->decimal(8, 3),
            'attributes' => $this->text(), // JSON с характеристиками на момент заказа
            'created_at' => $this->datetime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // Индексы
        $this->createIndex('idx-order_item-order_id', '{{%order_item}}', 'order_id');
        $this->createIndex('idx-order_item-product_id', '{{%order_item}}', 'product_id');

        // Внешние ключи
        $this->addForeignKey(
            'fk-order_item-order_id',
            '{{%order_item}}',
            'order_id',
            '{{%order}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-order_item-product_id',
            '{{%order_item}}',
            'product_id',
            '{{%product}}',
            'id',
            'RESTRICT',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-order_item-order_id', '{{%order_item}}');
        $this->dropForeignKey('fk-order_item-product_id', '{{%order_item}}');
        $this->dropTable('{{%order_item}}');
    }
}
