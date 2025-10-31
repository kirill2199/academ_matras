<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%page}}`.
 */
class m251031_113601_create_page_table extends Migration
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

        $this->createTable('{{%page}}', [
            'id' => $this->primaryKey(),

            // Основная информация
            'title' => $this->string(255)->notNull()->comment('Заголовок страницы'),
            'slug' => $this->string(255)->notNull()->unique()->comment('URL-адрес страницы'),
            'content' => $this->text()->notNull()->comment('Содержимое страницы'),
            'excerpt' => $this->text()->comment('Краткое описание'),

            // Мета-информация
            'meta_title' => $this->string(255)->comment('Meta title'),
            'meta_description' => $this->text()->comment('Meta description'),
            'meta_keywords' => $this->string(500)->comment('Meta keywords'),

            // Настройки отображения
            'template' => $this->string(100)->defaultValue('default')->comment('Шаблон страницы'),
            'sort_order' => $this->integer()->defaultValue(0)->comment('Порядок сортировки'),
            'is_published' => $this->boolean()->defaultValue(true)->comment('Опубликована'),
            'show_in_menu' => $this->boolean()->defaultValue(true)->comment('Показывать в меню'),
            'menu_order' => $this->integer()->defaultValue(0)->comment('Порядок в меню'),

            // Категория/тип страницы
            'type' => $this->string(50)->defaultValue('page')->comment('Тип страницы'),
            'parent_id' => $this->integer()->defaultValue(0)->comment('Родительская страница'),

            // Изображения
            'featured_image' => $this->string(500)->comment('Главное изображение'),
            'image_alt' => $this->string(255)->comment('Alt текст изображения'),

            // SEO и аналитика
            'canonical_url' => $this->string(500)->comment('Канонический URL'),
            'robots' => $this->string(100)->defaultValue('index, follow')->comment('Robots meta'),
            'og_image' => $this->string(500)->comment('Open Graph изображение'),

            // Доступ и видимость
            'access_level' => $this->string(20)->defaultValue('public')->comment('Уровень доступа'),
            'is_featured' => $this->boolean()->defaultValue(false)->comment('Рекомендуемая'),

            // Временные метки
            'published_at' => $this->timestamp()->comment('Дата публикации'),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),

            // Автор и изменения
            'created_by' => $this->integer()->comment('Автор'),
            'updated_by' => $this->integer()->comment('Редактор'),

            // Дополнительные поля
            'language' => $this->string(10)->defaultValue('ru')->comment('Язык'),
            'views_count' => $this->integer()->defaultValue(0)->comment('Количество просмотров'),
        ], $tableOptions);

        // Индексы
        $this->createIndex('idx-page-slug', '{{%page}}', 'slug');
        $this->createIndex('idx-page-published', '{{%page}}', ['is_published', 'published_at']);
        $this->createIndex('idx-page-type', '{{%page}}', 'type');
        $this->createIndex('idx-page-parent', '{{%page}}', 'parent_id');
        $this->createIndex('idx-page-menu', '{{%page}}', ['show_in_menu', 'menu_order']);
        $this->createIndex('idx-page-sort', '{{%page}}', ['sort_order', 'id']);
        $this->createIndex('idx-page-language', '{{%page}}', 'language');
        $this->createIndex('idx-page-created_by', '{{%page}}', 'created_by');

        // Составные индексы для оптимизации
        $this->createIndex('idx-page-status-type', '{{%page}}', ['is_published', 'type', 'sort_order']);
        $this->createIndex('idx-page-menu-status', '{{%page}}', ['show_in_menu', 'is_published', 'menu_order']);

        // Внешние ключи (раскомментировать при необходимости)
        /*
        $this->addForeignKey(
            'fk-page-created_by',
            '{{%page}}',
            'created_by',
            '{{%user}}',
            'id',
            'SET NULL',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-page-updated_by',
            '{{%page}}',
            'updated_by',
            '{{%user}}',
            'id',
            'SET NULL',
            'CASCADE'
        );
        */

        // Заполняем таблицу начальными данными
        $this->insertInitialPages();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Удаляем внешние ключи если они были созданы
        /*
        $this->dropForeignKey('fk-page-created_by', '{{%page}}');
        $this->dropForeignKey('fk-page-updated_by', '{{%page}}');
        */

        $this->dropTable('{{%page}}');
    }

    /**
     * Заполняет таблицу начальными страницами
     */
    private function insertInitialPages()
    {
        $pages = [
            [
                'title' => 'Помощь',
                'slug' => 'help',
                'content' => $this->getHelpContent(),
                'excerpt' => 'Часто задаваемые вопросы и помощь по использованию сайта',
                'meta_title' => 'Помощь - Часто задаваемые вопросы',
                'meta_description' => 'Найдите ответы на часто задаваемые вопросы о нашем магазине, доставке, оплате и возвратах',
                'type' => 'help',
                'sort_order' => 1,
                'menu_order' => 1,
            ],
            [
                'title' => 'Доставка',
                'slug' => 'delivery',
                'content' => $this->getDeliveryContent(),
                'excerpt' => 'Информация о способах доставки, сроках и стоимости',
                'meta_title' => 'Доставка - Способы и сроки доставки',
                'meta_description' => 'Условия доставки: способы, сроки, стоимость доставки по России и миру',
                'type' => 'info',
                'sort_order' => 2,
                'menu_order' => 2,
            ],
            [
                'title' => 'Оплата',
                'slug' => 'payment',
                'content' => $this->getPaymentContent(),
                'excerpt' => 'Способы оплаты заказов в нашем магазине',
                'meta_title' => 'Оплата - Способы оплаты заказов',
                'meta_description' => 'Доступные способы оплаты: банковские карты, электронные деньги, наличные',
                'type' => 'info',
                'sort_order' => 3,
                'menu_order' => 3,
            ],
            [
                'title' => 'Гарантия',
                'slug' => 'warranty',
                'content' => $this->getWarrantyContent(),
                'excerpt' => 'Информация о гарантийных обязательствах',
                'meta_title' => 'Гарантия - Гарантийные обязательства',
                'meta_description' => 'Гарантийные обязательства на товары, условия гарантийного обслуживания',
                'type' => 'info',
                'sort_order' => 4,
                'menu_order' => 4,
            ],
            [
                'title' => 'Возврат',
                'slug' => 'refund',
                'content' => $this->getRefundContent(),
                'excerpt' => 'Условия возврата и обмена товаров',
                'meta_title' => 'Возврат - Условия возврата товаров',
                'meta_description' => 'Правила возврата и обмена товаров, сроки возврата денежных средств',
                'type' => 'info',
                'sort_order' => 5,
                'menu_order' => 5,
            ],
            [
                'title' => 'О компании',
                'slug' => 'about',
                'content' => $this->getAboutContent(),
                'excerpt' => 'Информация о нашей компании',
                'meta_title' => 'О компании - О нашем магазине',
                'meta_description' => 'Информация о нашей компании, миссия и ценности',
                'type' => 'info',
                'sort_order' => 6,
                'menu_order' => 6,
            ],
            [
                'title' => 'Контакты',
                'slug' => 'contacts',
                'content' => $this->getContactsContent(),
                'excerpt' => 'Контактная информация и реквизиты',
                'meta_title' => 'Контакты - Как с нами связаться',
                'meta_description' => 'Контактная информация, адреса, телефоны, форма обратной связи',
                'type' => 'contact',
                'sort_order' => 7,
                'menu_order' => 7,
            ],
        ];

        foreach ($pages as $page) {
            $this->insert('{{%page}}', array_merge($page, [
                'published_at' => new \yii\db\Expression('CURRENT_TIMESTAMP'),
                'created_at' => new \yii\db\Expression('CURRENT_TIMESTAMP'),
                'updated_at' => new \yii\db\Expression('CURRENT_TIMESTAMP'),
            ]));
        }
    }

    /**
     * Возвращает контент для страницы Помощь
     */
    private function getHelpContent()
    {
        return <<<HTML
<h2>Часто задаваемые вопросы</h2>

<div class="faq-section">
    <h3>Общие вопросы</h3>
    
    <div class="faq-item">
        <h4>Как создать аккаунт?</h4>
        <p>Для создания аккаунта нажмите кнопку "Регистрация" в верхнем правом углу сайта и заполните необходимые данные.</p>
    </div>
    
    <div class="faq-item">
        <h4>Как восстановить пароль?</h4>
        <p>На странице входа нажмите "Забыли пароль?" и следуйте инструкциям для восстановления доступа.</p>
    </div>
    
    <div class="faq-item">
        <h4>Как отследить заказ?</h4>
        <p>После отправки заказа вам будет выслан номер для отслеживания. Вы можете отслеживать статус в личном кабинете.</p>
    </div>
</div>

<div class="contact-support">
    <h3>Не нашли ответ?</h3>
    <p>Свяжитесь с нашей службой поддержки:</p>
    <ul>
        <li>Телефон: +7 (800) 123-45-67</li>
        <li>Email: support@example.com</li>
        <li>Часы работы: Пн-Пт 9:00-18:00</li>
    </ul>
</div>
HTML;
    }

    /**
     * Возвращает контент для страницы Доставка
     */
    private function getDeliveryContent()
    {
        return <<<HTML
<h2>Условия доставки</h2>

<div class="delivery-methods">
    <h3>Способы доставки</h3>
    
    <div class="delivery-method">
        <h4>Курьерская доставка</h4>
        <p>Доставка курьером до двери. Срок доставки: 1-3 рабочих дня.</p>
        <p><strong>Стоимость:</strong> 300 руб. Бесплатно при заказе от 2000 руб.</p>
    </div>
    
    <div class="delivery-method">
        <h4>Самовывоз</h4>
        <p>Самовывоз из пунктов выдачи заказов. Срок: 1-2 дня.</p>
        <p><strong>Стоимость:</strong> бесплатно</p>
    </div>
    
    <div class="delivery-method">
        <h4>Почта России</h4>
        <p>Доставка через отделения Почты России. Срок: 5-14 дней.</p>
        <p><strong>Стоимость:</strong> 250 руб. Бесплатно при заказе от 3000 руб.</p>
    </div>
</div>

<div class="delivery-regions">
    <h3>Регионы доставки</h3>
    <p>Мы осуществляем доставку по всей территории России. Сроки и стоимость доставки в отдаленные регионы уточняйте у менеджера.</p>
</div>

<div class="delivery-notes">
    <h3>Важная информация</h3>
    <ul>
        <li>Заказы обрабатываются в рабочие дни с 9:00 до 18:00</li>
        <li>При получении заказа проверяйте комплектацию</li>
        <li>Курьер свяжется с вами за 1-2 часа до доставки</li>
    </ul>
</div>
HTML;
    }

    /**
     * Возвращает контент для страницы Оплата
     */
    private function getPaymentContent()
    {
        return <<<HTML
<h2>Способы оплаты</h2>

<div class="payment-methods">
    <h3>Онлайн-оплата</h3>
    
    <div class="payment-method">
        <h4>Банковские карты</h4>
        <p>Visa, MasterCard, Мир</p>
        <p>Безопасная оплата через защищенное соединение</p>
    </div>
    
    <div class="payment-method">
        <h4>Электронные кошельки</h4>
        <p>ЮMoney, QIWI, WebMoney</p>
    </div>
    
    <div class="payment-method">
        <h4>СБП (Система быстрых платежей)</h4>
        <p>Оплата по QR-коду через мобильное приложение банка</p>
    </div>
</div>

<div class="payment-methods">
    <h3>Офлайн-оплата</h3>
    
    <div class="payment-method">
        <h4>Наличными при получении</h4>
        <p>Оплата наличными курьеру или в пункте выдачи</p>
    </div>
    
    <div class="payment-method">
        <h4>Банковский перевод</h4>
        <p>Оплата по счету для юридических лиц</p>
    </div>
</div>

<div class="payment-security">
    <h3>Безопасность платежей</h3>
    <p>Все онлайн-платежи защищены SSL-шифрованием и соответствуют стандартам безопасности PCI DSS.</p>
</div>
HTML;
    }

    /**
     * Возвращает контент для страницы Гарантия
     */
    private function getWarrantyContent()
    {
        return <<<HTML
<h2>Гарантийные обязательства</h2>

<div class="warranty-info">
    <h3>Сроки гарантии</h3>
    <p>На всю технику предоставляется гарантия от 12 до 36 месяцев в зависимости от категории товара.</p>
    
    <ul>
        <li>Смартфоны и планшеты: 12 месяцев</li>
        <li>Ноутбуки и компьютеры: 24 месяца</li>
        <li>Бытовая техника: 24-36 месяцев</li>
        <li>Аксессуары: 6 месяцев</li>
    </ul>
</div>

<div class="warranty-terms">
    <h3>Условия гарантии</h3>
    <p>Гарантия распространяется на недостатки товара, возникшие по вине производителя.</p>
    
    <h4>Гарантия не распространяется:</h4>
    <ul>
        <li>На механические повреждения</li>
        <li>На повреждения от неправильной эксплуатации</li>
        <li>На естественный износ</li>
        <li>На повреждения от попадания жидкости</li>
    </ul>
</div>

<div class="warranty-service">
    <h3>Гарантийное обслуживание</h3>
    <p>Для обращения по гарантии свяжитесь с нашей службой поддержки или обратитесь в авторизованный сервисный центр.</p>
</div>
HTML;
    }

    /**
     * Возвращает контент для страницы Возврат
     */
    private function getRefundContent()
    {
        return <<<HTML
<h2>Условия возврата и обмена</h2>

<div class="return-policy">
    <h3>Сроки возврата</h3>
    <p>Вы можете вернуть или обменить товар в течение 14 дней с момента получения заказа.</p>
</div>

<div class="return-conditions">
    <h3>Условия возврата</h3>
    
    <h4>Товар надлежащего качества</h4>
    <p>Возврат возможен если:</p>
    <ul>
        <li>Товар не был в употреблении</li>
        <li>Сохранен товарный вид</li>
        <li>Сохранены фабричные ярлыки и упаковка</li>
        <li>Имеются все комплектующие</li>
    </ul>
    
    <h4>Товар ненадлежащего качества</h4>
    <p>Возврат осуществляется в случае обнаружения брака или неисправности.</p>
</div>

<div class="return-process">
    <h3>Процедура возврата</h3>
    <ol>
        <li>Свяжитесь с нашей службой поддержки</li>
        <li>Заполните заявление на возврат</li>
        <li>Отправьте товар нам</li>
        <li>Получите денежные средства после проверки товара</li>
    </ol>
</div>
HTML;
    }

    /**
     * Возвращает контент для страницы О компании
     */
    private function getAboutContent()
    {
        return <<<HTML
<h2>О нашей компании</h2>

<div class="about-content">
    <p>Мы - современный интернет-магазин электроники и техники, работающий на рынке с 2010 года.</p>
    
    <h3>Наша миссия</h3>
    <p>Сделать современные технологии доступными для каждого, предоставляя качественные товары по лучшим ценам.</p>
    
    <h3>Наши ценности</h3>
    <ul>
        <li>Качество продукции и обслуживания</li>
        <li>Честность и прозрачность</li>
        <li>Забота о клиентах</li>
        <li>Постоянное развитие</li>
    </ul>
</div>
HTML;
    }

    /**
     * Возвращает контент для страницы Контакты
     */
    private function getContactsContent()
    {
        return <<<HTML
<h2>Контактная информация</h2>

<div class="contact-info">
    <div class="contact-item">
        <h3>Телефоны</h3>
        <p>+7 (800) 123-45-67 - Бесплатный по России</p>
        <p>+7 (495) 123-45-67 - Москва</p>
    </div>
    
    <div class="contact-item">
        <h3>Email</h3>
        <p>info@example.com - Общие вопросы</p>
        <p>support@example.com - Техническая поддержка</p>
    </div>
    
    <div class="contact-item">
        <h3>Адрес</h3>
        <p>г. Москва, ул. Примерная, д. 123</p>
        <p>БЦ "Примерный", этаж 5</p>
    </div>
    
    <div class="contact-item">
        <h3>Часы работы</h3>
        <p>Понедельник - Пятница: 9:00 - 18:00</p>
        <p>Суббота: 10:00 - 16:00</p>
        <p>Воскресенье: выходной</p>
    </div>
</div>

<div class="contact-form-note">
    <h3>Форма обратной связи</h3>
    <p>Используйте форму обратной связи на сайте для быстрого ответа на ваш вопрос.</p>
</div>
HTML;
    }
}
