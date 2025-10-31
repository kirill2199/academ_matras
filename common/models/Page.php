<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "page".
 *
 * @property int $id
 * @property string $title Заголовок страницы
 * @property string $slug URL-адрес страницы
 * @property string $content Содержимое страницы
 * @property string|null $excerpt Краткое описание
 * @property string|null $meta_title Meta title
 * @property string|null $meta_description Meta description
 * @property string|null $meta_keywords Meta keywords
 * @property string|null $template Шаблон страницы
 * @property int|null $sort_order Порядок сортировки
 * @property int|null $is_published Опубликована
 * @property int|null $show_in_menu Показывать в меню
 * @property int|null $menu_order Порядок в меню
 * @property string|null $type Тип страницы
 * @property int|null $parent_id Родительская страница
 * @property string|null $featured_image Главное изображение
 * @property string|null $image_alt Alt текст изображения
 * @property string|null $canonical_url Канонический URL
 * @property string|null $robots Robots meta
 * @property string|null $og_image Open Graph изображение
 * @property string|null $access_level Уровень доступа
 * @property int|null $is_featured Рекомендуемая
 * @property string|null $published_at Дата публикации
 * @property string $created_at
 * @property string $updated_at
 * @property int|null $created_by Автор
 * @property int|null $updated_by Редактор
 * @property string|null $language Язык
 * @property int|null $views_count Количество просмотров
 */
class Page extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'page';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['excerpt', 'meta_title', 'meta_description', 'meta_keywords', 'featured_image', 'image_alt', 'canonical_url', 'og_image', 'published_at', 'created_by', 'updated_by'], 'default', 'value' => null],
            [['template'], 'default', 'value' => 'default'],
            [['views_count'], 'default', 'value' => 0],
            [['show_in_menu'], 'default', 'value' => 1],
            [['type'], 'default', 'value' => 'page'],
            [['robots'], 'default', 'value' => 'index, follow'],
            [['access_level'], 'default', 'value' => 'public'],
            [['language'], 'default', 'value' => 'ru'],
            [['title', 'slug', 'content'], 'required'],
            [['content', 'excerpt', 'meta_description'], 'string'],
            [['sort_order', 'is_published', 'show_in_menu', 'menu_order', 'parent_id', 'is_featured', 'created_by', 'updated_by', 'views_count'], 'integer'],
            [['published_at', 'created_at', 'updated_at'], 'safe'],
            [['title', 'slug', 'meta_title', 'image_alt'], 'string', 'max' => 255],
            [['meta_keywords', 'featured_image', 'canonical_url', 'og_image'], 'string', 'max' => 500],
            [['template', 'robots'], 'string', 'max' => 100],
            [['type'], 'string', 'max' => 50],
            [['access_level'], 'string', 'max' => 20],
            [['language'], 'string', 'max' => 10],
            [['slug'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'slug' => 'Slug',
            'content' => 'Content',
            'excerpt' => 'Excerpt',
            'meta_title' => 'Meta Title',
            'meta_description' => 'Meta Description',
            'meta_keywords' => 'Meta Keywords',
            'template' => 'Template',
            'sort_order' => 'Sort Order',
            'is_published' => 'Is Published',
            'show_in_menu' => 'Show In Menu',
            'menu_order' => 'Menu Order',
            'type' => 'Type',
            'parent_id' => 'Parent ID',
            'featured_image' => 'Featured Image',
            'image_alt' => 'Image Alt',
            'canonical_url' => 'Canonical Url',
            'robots' => 'Robots',
            'og_image' => 'Og Image',
            'access_level' => 'Access Level',
            'is_featured' => 'Is Featured',
            'published_at' => 'Published At',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'language' => 'Language',
            'views_count' => 'Views Count',
        ];
    }

}
