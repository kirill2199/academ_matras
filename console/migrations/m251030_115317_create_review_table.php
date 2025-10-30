<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%review}}`.
 */
class m251030_115317_create_review_table extends Migration
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

        // Создаем таблицу отзывов
        $this->createTable('{{%review}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->null(),
            'user_name' => $this->string(255)->notNull(),
            'user_email' => $this->string(255),
            'rating' => $this->decimal(2, 1)->notNull()->defaultValue(0.0), // рейтинг от 0.0 до 5.0
            'title' => $this->string(500),
            'comment' => $this->text()->notNull(),
            'advantages' => $this->text(), // преимущества товара
            'disadvantages' => $this->text(), // недостатки товара
            'status' => $this->smallInteger()->notNull()->defaultValue(0), // 0 - на модерации, 1 - опубликован, 2 - отклонен
            'is_verified' => $this->boolean()->defaultValue(false), // подтвержденная покупка
            'likes' => $this->integer()->defaultValue(0), // количество лайков
            'dislikes' => $this->integer()->defaultValue(0), // количество дизлайков
            'ip_address' => $this->string(45),
            'user_agent' => $this->string(500),
            'created_at' => $this->datetime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->datetime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'published_at' => $this->datetime()->null(), // дата публикации
        ], $tableOptions);

        // Добавляем колонку в таблицу product для хранения ID отзывов
        $this->addColumn('{{%product}}', 'reviews', $this->text()->null());

        // Индексы для таблицы review
        $this->createIndex('idx-review-product_id', '{{%review}}', 'product_id');
        $this->createIndex('idx-review-user_id', '{{%review}}', 'user_id');
        $this->createIndex('idx-review-rating', '{{%review}}', 'rating');
        $this->createIndex('idx-review-status', '{{%review}}', 'status');
        $this->createIndex('idx-review-created_at', '{{%review}}', 'created_at');
        $this->createIndex('idx-review-published_at', '{{%review}}', 'published_at');

        // Составной индекс для оптимизации запросов
        $this->createIndex('idx-review-product_status', '{{%review}}', ['product_id', 'status']);

        // Внешние ключи
        $this->addForeignKey(
            'fk-review-product_id',
            '{{%review}}',
            'product_id',
            '{{%product}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        // Если есть таблица пользователей
        // $this->addForeignKey(
        //     'fk-review-user_id',
        //     '{{%review}}',
        //     'user_id',
        //     '{{%user}}',
        //     'id',
        //     'SET NULL',
        //     'CASCADE'
        // );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Удаляем внешние ключи
        $this->dropForeignKey('fk-review-product_id', '{{%review}}');
        // $this->dropForeignKey('fk-review-user_id', '{{%review}}');

        // Удаляем триггер
        $this->dropUpdateReviewsTrigger();

        // Удаляем колонку из product
        $this->dropColumn('{{%product}}', 'reviews');

        // Удаляем таблицу
        $this->dropTable('{{%review}}');
    }
}