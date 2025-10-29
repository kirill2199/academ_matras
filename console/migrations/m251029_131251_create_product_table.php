<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product}}`.
 */
class m251029_131251_create_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'slug' => $this->string(255)->notNull()->unique(),
            'sku' => $this->string(100)->unique(), // артикул
            'description' => $this->text(),
            'short_description' => $this->text(),
            'price' => $this->decimal(10, 2)->notNull(),
            'old_price' => $this->decimal(10, 2),
            'purchase_price' => $this->decimal(10, 2), // закупочная цена
            'currency' => $this->string(3)->defaultValue('RUB'),
            'quantity' => $this->integer()->defaultValue(0),
            'reserved_quantity' => $this->integer()->defaultValue(0), // зарезервированное количество
            'weight' => $this->decimal(8, 3), // вес
            'length' => $this->decimal(8, 2), // длина
            'width' => $this->decimal(8, 2), // ширина
            'height' => $this->decimal(8, 2), // высота
            'volume' => $this->decimal(8, 3), // объем
            'main_image' => $this->string(500),
            'images' => $this->text(), // JSON массив дополнительных изображений
            'category_id' => $this->integer()->notNull(),
            'brand' => $this->string(255),
            'model' => $this->string(255),
            'warranty' => $this->integer(), // гарантия в месяцах
            'country' => $this->string(100),
            'manufacturer' => $this->string(255),
            'barcode' => $this->string(100),
            'seo_title' => $this->string(255),
            'seo_description' => $this->string(500),
            'seo_keywords' => $this->string(500),
            'status' => $this->smallInteger()->defaultValue(1),
            'in_stock' => $this->boolean()->defaultValue(true),
            'is_new' => $this->boolean()->defaultValue(false),
            'is_featured' => $this->boolean()->defaultValue(false),
            'is_sale' => $this->boolean()->defaultValue(false),
            'rating' => $this->decimal(3, 2)->defaultValue(0),
            'reviews_count' => $this->integer()->defaultValue(0),
            'views_count' => $this->integer()->defaultValue(0),
            'sales_count' => $this->integer()->defaultValue(0),
            'min_order_quantity' => $this->integer()->defaultValue(1),
            'max_order_quantity' => $this->integer(),
            'step_order_quantity' => $this->integer()->defaultValue(1),
            'created_at' => $this->datetime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->datetime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'published_at' => $this->datetime()->null(),
        ]);

        // Индексы
        $this->createIndex('idx-product-category_id', '{{%product}}', 'category_id');
        $this->createIndex('idx-product-status', '{{%product}}', 'status');
        $this->createIndex('idx-product-price', '{{%product}}', 'price');
        $this->createIndex('idx-product-in_stock', '{{%product}}', 'in_stock');
        $this->createIndex('idx-product-is_new', '{{%product}}', 'is_new');
        $this->createIndex('idx-product-is_featured', '{{%product}}', 'is_featured');
        $this->createIndex('idx-product-rating', '{{%product}}', 'rating');
        $this->createIndex('idx-product-created_at', '{{%product}}', 'created_at');
        
        // Внешний ключ
        $this->addForeignKey(
            'fk-product-category_id',
            '{{%product}}',
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
        $this->dropForeignKey('fk-product-category_id', '{{%product}}');
        $this->dropTable('{{%product}}');
    }
}