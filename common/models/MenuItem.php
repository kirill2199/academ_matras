<?php

namespace common\models;

use Yii;
use common\models\Category;

/**
 * This is the model class for table "menu_item".
 *
 * @property int $id
 * @property int $menu_id
 * @property int|null $parent_id
 * @property string $title
 * @property string|null $url
 * @property string|null $route
 * @property string|null $params
 * @property string|null $icon
 * @property string|null $target
 * @property string|null $rel
 * @property string|null $css_class
 * @property string|null $description
 * @property int|null $sort_order
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 * @property int|null $category_id
 * @property string|null $item_type
 *
 * @property Category $category
 * @property Menu $menu
 * @property MenuItem[] $menuItems
 * @property MenuItem $parent
 */
class MenuItem extends \yii\db\ActiveRecord
{

    const TYPE_CUSTOM = 'custom';
    const TYPE_CATEGORY = 'category';
    const TYPE_PAGE = 'page';
    const TYPE_PRODUCT = 'product';
    const TYPE_URL = 'url';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'menu_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'url', 'route', 'params', 'icon', 'rel', 'css_class', 'description', 'category_id'], 'default', 'value' => null],
            [['target'], 'default', 'value' => '_self'],
            [['sort_order'], 'default', 'value' => 0],
            [['status'], 'default', 'value' => 1],
            [['item_type'], 'default', 'value' => 'custom'],
            [['menu_id', 'title'], 'required'],
            [['menu_id', 'parent_id', 'sort_order', 'status', 'category_id'], 'integer'],
            [['params', 'description'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'route'], 'string', 'max' => 255],
            [['url'], 'string', 'max' => 500],
            [['icon', 'rel', 'css_class'], 'string', 'max' => 100],
            [['target'], 'string', 'max' => 20],
            [['item_type'], 'string', 'max' => 50],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            [['menu_id'], 'exist', 'skipOnError' => true, 'targetClass' => Menu::class, 'targetAttribute' => ['menu_id' => 'id']],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => MenuItem::class, 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'menu_id' => 'Menu ID',
            'parent_id' => 'Parent ID',
            'title' => 'Title',
            'url' => 'Url',
            'route' => 'Route',
            'params' => 'Params',
            'icon' => 'Icon',
            'target' => 'Target',
            'rel' => 'Rel',
            'css_class' => 'Css Class',
            'description' => 'Description',
            'sort_order' => 'Sort Order',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'category_id' => 'Category ID',
            'item_type' => 'Item Type',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[Menu]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMenu()
    {
        return $this->hasOne(Menu::class, ['id' => 'menu_id']);
    }

    /**
     * Gets query for [[MenuItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMenuItems()
    {
        return $this->hasMany(MenuItem::class, ['parent_id' => 'id']);
    }

    /**
     * Gets query for [[Parent]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(MenuItem::class, ['id' => 'parent_id']);
    }

}
