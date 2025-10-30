<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 * @property int|null $parent_id
 * @property string|null $image
 * @property int|null $sort_order
 * @property int|null $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Category[] $categories
 * @property Characteristic[] $characteristics
 * @property MenuItem[] $menuItems
 * @property Category $parent
 * @property Product[] $products
 */
class Category extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description', 'meta_title', 'meta_description', 'meta_keywords', 'parent_id', 'image'], 'default', 'value' => null],
            [['sort_order'], 'default', 'value' => 0],
            [['status'], 'default', 'value' => 1],
            [['name', 'slug'], 'required'],
            [['description'], 'string'],
            [['parent_id', 'sort_order', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'slug', 'meta_title'], 'string', 'max' => 255],
            [['meta_description', 'meta_keywords', 'image'], 'string', 'max' => 500],
            [['slug'], 'unique'],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'slug' => 'Slug',
            'description' => 'Description',
            'meta_title' => 'Meta Title',
            'meta_description' => 'Meta Description',
            'meta_keywords' => 'Meta Keywords',
            'parent_id' => 'Parent ID',
            'image' => 'Image',
            'sort_order' => 'Sort Order',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Categories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::class, ['parent_id' => 'id']);
    }

    /**
     * Gets query for [[Characteristics]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCharacteristics()
    {
        return $this->hasMany(Characteristic::class, ['category_id' => 'id']);
    }

    /**
     * Gets query for [[MenuItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMenuItems()
    {
        return $this->hasMany(MenuItem::class, ['category_id' => 'id']);
    }

    /**
     * Gets query for [[Parent]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Category::class, ['id' => 'parent_id']);
    }

    /**
     * Gets query for [[Products]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::class, ['category_id' => 'id']);
    }

    /**
     * Получает меню категорий в виде HTML
     */
    public static function getCategoryMenu()
    {
        $categories = self::find()
            ->where(['status' => 1])
            ->andWhere(['parent_id' => null]) // Используем поле parent_id из таблицы category
            ->orderBy(['sort_order' => SORT_ASC, 'name' => SORT_ASC])
            ->all();

        return self::renderCategoryMenu($categories);
    }

    /**
     * Рендерит меню категорий в HTML
     */
    private static function renderCategoryMenu($categories)
    {
        if (empty($categories)) {
            return '';
        }

        $html = '<ul class="category-list">';

        foreach ($categories as $category) {
            $hasChildren = self::find()
                ->where(['parent_id' => $category->id, 'status' => 1])
                ->exists();

            $url = self::getCategoryUrl($category);

            $html .= '<li class="category-list-item">';
            $html .= '<a href="' . $url . '">';
            $html .= '<div class="dropdown-item">';
            $html .= '<div class="dropdown-list-item">';

            // Изображение категории
            $html .= '<span class="dropdown-img">';
            if ($category->image) {
                $html .= '<img src="' . htmlspecialchars($category->getImageUrl()) . '" alt="' . htmlspecialchars($category->name) . '">';
            } else {
                $html .= '<img src="/images/placeholder-category.jpg" alt="' . htmlspecialchars($category->name) . '">';
            }
            $html .= '</span>';

            // Название категории
            $html .= '<span class="dropdown-text">';
            $html .= htmlspecialchars($category->name);
            $html .= '</span>';

            $html .= '</div>'; // .dropdown-list-item

            // Иконка стрелки если есть подкатегории
            if ($hasChildren) {
                $html .= '<div class="drop-down-list-icon">';
                $html .= '<span>';
                $html .= '<svg width="6" height="9" viewBox="0 0 6 9" fill="none" xmlns="http://www.w3.org/2000/svg">';
                $html .= '<rect x="1.5" y="0.818359" width="5.78538" height="1.28564" transform="rotate(45 1.5 0.818359)" fill="#1D1D1D"></rect>';
                $html .= '<rect x="5.58984" y="4.90918" width="5.78538" height="1.28564" transform="rotate(135 5.58984 4.90918)" fill="#1D1D1D"></rect>';
                $html .= '</svg>';
                $html .= '</span>';
                $html .= '</div>'; // .drop-down-list-icon
            }

            $html .= '</div>'; // .dropdown-item
            $html .= '</a>';

            // Рекурсивно рендерим подкатегории если есть
            if ($hasChildren) {
                $childCategories = self::find()
                    ->where(['parent_id' => $category->id, 'status' => 1])
                    ->orderBy(['sort_order' => SORT_ASC, 'name' => SORT_ASC])
                    ->all();
                $html .= self::renderSubCategoryMenu($childCategories);
            }

            $html .= '</li>'; // .category-list-item
        }

        $html .= '</ul>'; // .category-list

        return $html;
    }

    /**
     * Рендерит подменю категорий
     */
    private static function renderSubCategoryMenu($categories)
    {
        if (empty($categories)) {
            return '';
        }

        $html = '<ul class="category-sub-menu">';

        foreach ($categories as $category) {
            $hasChildren = self::find()
                ->where(['parent_id' => $category->id, 'status' => 1])
                ->exists();

            $url = self::getCategoryUrl($category);

            $html .= '<li class="category-sub-item">';
            $html .= '<a href="' . $url . '">';
            $html .= '<div class="dropdown-list-item">';

            // Изображение подкатегории
            $html .= '<span class="dropdown-img">';
            if ($category->image) {
                $html .= '<img src="' . htmlspecialchars($category->getImageUrl()) . '" alt="' . htmlspecialchars($category->name) . '">';
            } else {
                $html .= '<img src="/images/placeholder-category.jpg" alt="' . htmlspecialchars($category->name) . '">';
            }
            $html .= '</span>';

            // Название подкатегории
            $html .= '<span class="dropdown-text">';
            $html .= htmlspecialchars($category->name);
            $html .= '</span>';

            $html .= '</div>'; // .dropdown-list-item

            // Иконка стрелки если есть вложенные подкатегории
            if ($hasChildren) {
                $html .= '<div class="drop-down-list-icon">';
                $html .= '<span>';
                $html .= '<svg width="6" height="9" viewBox="0 0 6 9" fill="none" xmlns="http://www.w3.org/2000/svg">';
                $html .= '<rect x="1.5" y="0.818359" width="5.78538" height="1.28564" transform="rotate(45 1.5 0.818359)" fill="#1D1D1D"></rect>';
                $html .= '<rect x="5.58984" y="4.90918" width="5.78538" height="1.28564" transform="rotate(135 5.58984 4.90918)" fill="#1D1D1D"></rect>';
                $html .= '</svg>';
                $html .= '</span>';
                $html .= '</div>'; // .drop-down-list-icon
            }

            $html .= '</a>';

            // Рекурсивно рендерим вложенные подкатегории
            if ($hasChildren) {
                $childCategories = self::find()
                    ->where(['parent_id' => $category->id, 'status' => 1])
                    ->orderBy(['sort_order' => SORT_ASC, 'name' => SORT_ASC])
                    ->all();
                $html .= self::renderSubCategoryMenu($childCategories);
            }

            $html .= '</li>'; // .category-sub-item
        }

        $html .= '</ul>'; // .category-sub-menu

        return $html;
    }

    /**
     * Генерирует URL для категории
     */
    private static function getCategoryUrl($category)
    {
        return Yii::$app->urlManager->createUrl(['/product/category', 'slug' => $category->slug]);
    }

    /**
     * Получает URL изображения категории
     */
    public function getImageUrl()
    {
        if ($this->image) {
            return Yii::getAlias('@web/uploads/categories/') . $this->image;
        }
        return Yii::getAlias('@web/images/placeholder-category.jpg');
    }
}
