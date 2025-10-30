<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "menu".
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property MenuItem[] $menuItems
 */
class Menu extends \yii\db\ActiveRecord
{

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'menu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 1],
            [['name', 'slug'], 'required'],
            [['description'], 'string'],
            [['status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'slug'], 'string', 'max' => 255],
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
            'name' => 'Name',
            'slug' => 'Slug',
            'description' => 'Description',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[MenuItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMenuItems()
    {
        return $this->hasMany(MenuItem::class, ['menu_id' => 'id']);
    }

    /**
     * Получает пункты основного меню в виде HTML
     */
    public static function getMainMenuItems()
    {
        $menu = self::find()
            ->where(['slug' => 'main-menu', 'status' => 1])
            ->one();

        if (!$menu) {
            return '';
        }

        $items = MenuItem::find()
            ->where([
                'menu_id' => $menu->id,
                'status' => 1,
                'parent_id' => null
            ])
            ->orderBy(['sort_order' => SORT_ASC])
            ->all();

        return self::renderMenuItems($items);
    }

    /**
     * Рендерит пункты меню в HTML
     */
    private static function renderMenuItems($items, $level = 0)
    {
        if (empty($items)) {
            return '';
        }

        $html = $level === 0 ? '<ul class="menu-list">' : '<ul class="header-sub-menu">';

        foreach ($items as $item) {
            $hasChildren = self::hasChildren($item->id);
            $url = self::getItemUrl($item);

            $html .= '<li>';
            $html .= '<a href="' . $url . '">';
            $html .= '<span class="list-text">' . htmlspecialchars($item->title) . '</span>';
            $html .= '</a>';

            // Рекурсивно рендерим дочерние элементы
            if ($hasChildren) {
                $children = self::getChildItems($item->id);
                $html .= self::renderMenuItems($children, $level + 1);
            }

            $html .= '</li>';
        }

        $html .= '</ul>';

        return $html;
    }

    /**
     * Проверяет есть ли дочерние элементы
     */
    private static function hasChildren($parentId)
    {
        return MenuItem::find()
            ->where(['parent_id' => $parentId, 'status' => 1])
            ->exists();
    }

    /**
     * Получает дочерние элементы
     */
    private static function getChildItems($parentId)
    {
        return MenuItem::find()
            ->where(['parent_id' => $parentId, 'status' => 1])
            ->orderBy(['sort_order' => SORT_ASC])
            ->all();
    }

    /**
     * Генерирует URL для пункта меню
     */
    private static function getItemUrl($item)
    {
        if (!empty($item->url)) {
            return $item->url;
        }

        if (!empty($item->route)) {
            // Если route начинается с /, это абсолютный путь
            if (strpos($item->route, '/') === 0) {
                return $item->route;
            }

            // Парсим параметры если есть
            $params = [];
            if (!empty($item->params)) {
                $params = json_decode($item->params, true) ?: [];
            }

            return Yii::$app->urlManager->createUrl(array_merge([$item->route], $params));
        }

        return '#';
    }

    /**
     * Получает пользовательское меню в виде HTML
     */
    public static function getUserMenu()
    {
        $menu = self::find()
            ->where(['slug' => 'user-menu', 'status' => 1])
            ->one();

        if (!$menu) {
            return self::getDefaultUserMenu();
        }

        // Получаем корневые пункты меню
        $items = MenuItem::find()
            ->where([
                'menu_id' => $menu->id,
                'status' => 1,
                'parent_id' => null
            ])
            ->orderBy(['sort_order' => SORT_ASC])
            ->all();

        return self::renderUserMenu($items);
    }

    /**
     * Рендерит пользовательское меню в HTML
     */
    private static function renderUserMenu($items)
    {
        if (empty($items)) {
            return self::getDefaultUserMenu();
        }

        $html = '<div class="header-profile">';

        foreach ($items as $item) {
            // Проверяем условия отображения пункта меню
            if (!self::shouldDisplayItem($item)) {
                continue;
            }

            $url = self::getItemUrl($item);

            $html .= '<a href="' . $url . '">';
            $html .= '<span>' . htmlspecialchars($item->title) . '</span>';
            $html .= '</a>';
        }

        $html .= '</div>';

        return $html;
    }

    /**
     * Проверяет нужно ли отображать пункт меню
     */
    private static function shouldDisplayItem($item)
    {
        $user = Yii::$app->user;

        // Проверяем условия видимости из params (если есть)
        if (!empty($item->params)) {
            $params = json_decode($item->params, true);
            if ($params) {
                // Проверка на авторизацию
                if (isset($params['guestOnly']) && $params['guestOnly'] && !$user->isGuest) {
                    return false;
                }
                if (isset($params['authOnly']) && $params['authOnly'] && $user->isGuest) {
                    return false;
                }

                // Проверка ролей
                if (isset($params['roles']) && !$user->isGuest) {
                    $hasRole = false;
                    foreach ($params['roles'] as $role) {
                        if ($user->can($role)) {
                            $hasRole = true;
                            break;
                        }
                    }
                    if (!$hasRole) {
                        return false;
                    }
                }
            }
        }

        return true;
    }

    /**
     * Дефолтное пользовательское меню если нет в базе
     */
    private static function getDefaultUserMenu()
    {
        $user = Yii::$app->user;

        if ($user->isGuest) {
            return '
                <div class="header-profile">
                    <a href="/site/login"><span>Login</span></a>
                    <a href="/site/signup"><span>Register</span></a>
                    <a href="/site/help"><span>Support</span></a>
                </div>
            ';
        } else {
            return '
                <div class="header-profile">
                    <a href="/user/profile"><span>Account</span></a>
                    <a href="/order/track"><span>Track Order</span></a>
                    <a href="/site/help"><span>Support</span></a>
                    <a href="/site/logout" data-method="post"><span>Logout</span></a>
                </div>
            ';
        }
    }

    /**
     * Получает динамическое пользовательское меню (автоматически меняется в зависимости от авторизации)
     */
    public static function getDynamicUserMenu()
    {
        $user = Yii::$app->user;

        if ($user->isGuest) {
            return '
                <div class="header-profile">
                    <a href="/site/login"><span>Login</span></a>
                    <a href="/site/signup"><span>Register</span></a>
                    <a href="/site/help"><span>Support</span></a>
                </div>
            ';
        } else {
            $username = $user->identity->username ?? 'User';
            return '
                <div class="header-profile">
                    <a href="/user/profile"><span>My Account</span></a>
                    <a href="/order/history"><span>My Orders</span></a>
                    <a href="/wishlist"><span>Wishlist</span></a>
                    <a href="/order/track"><span>Track Order</span></a>
                    <a href="/site/help"><span>Support</span></a>
                    <a href="/site/logout" data-method="post"><span>Logout (' . htmlspecialchars($username) . ')</span></a>
                </div>
            ';
        }
    }
    /**
     * Получает меню в подвале в виде HTML
     */
    public static function getFooterMenu()
    {
        $menu = self::find()
            ->where(['slug' => 'footer-menu', 'status' => 1])
            ->one();

        if (!$menu) {
            return self::getDefaultFooterMenu();
        }

        // Получаем корневые пункты меню
        $items = MenuItem::find()
            ->where([
                'menu_id' => $menu->id,
                'status' => 1,
                'parent_id' => null
            ])
            ->orderBy(['sort_order' => SORT_ASC])
            ->all();

        return self::renderFooterMenu($items);
    }

    /**
     * Рендерит меню в подвале в HTML
     */
    private static function renderFooterMenu($items)
    {
        if (empty($items)) {
            return self::getDefaultFooterMenu();
        }

        $html = '';

        foreach ($items as $item) {
            $hasChildren = MenuItem::find()
                ->where(['parent_id' => $item->id, 'status' => 1])
                ->exists();

            $html .= '<div class="col-lg-3 col-sm-6">';
            $html .= '<div class="about-us">';
            
            // Заголовок раздела
            $html .= '<h4 class="footer-heading footer-title">';
            $html .= htmlspecialchars($item->title);
            $html .= '</h4>';
            
            // Ссылки раздела
            $html .= '<div class="footer-link about-link">';
            $html .= '<ul>';

            if ($hasChildren) {
                $children = MenuItem::find()
                    ->where(['parent_id' => $item->id, 'status' => 1])
                    ->orderBy(['sort_order' => SORT_ASC])
                    ->all();
                
                foreach ($children as $child) {
                    $url = self::getItemUrl($child);
                    $html .= '<li><a href="' . $url . '">' . htmlspecialchars($child->title) . '</a></li>';
                }
            } else {
                // Если нет подпунктов, показываем сам пункт как ссылку
                $url = self::getItemUrl($item);
                $html .= '<li><a href="' . $url . '">' . htmlspecialchars($item->title) . '</a></li>';
            }

            $html .= '</ul>';
            $html .= '</div>'; // .footer-link.about-link
            $html .= '</div>'; // .about-us
            $html .= '</div>'; // .col-lg-3.col-sm-6
        }

        return $html;
    }


    /**
     * Дефолтное меню в подвале если нет в базе
     */
    private static function getDefaultFooterMenu()
    {
        return '
            <div class="col-lg-3 col-sm-6">
                <div class="about-us">
                    <h4 class="footer-heading footer-title">
                        About Us
                    </h4>
                    <div class="footer-link about-link">
                        <ul>
                            <li><a href="/site/about">Our Story</a></li>
                            <li><a href="/site/careers">Work With Us</a></li>
                            <li><a href="/site/news">Corporate News</a></li>
                            <li><a href="/site/investors">Investors</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="about-us">
                    <h4 class="footer-heading footer-title">
                        Customer Service
                    </h4>
                    <div class="footer-link about-link">
                        <ul>
                            <li><a href="/site/contact">Contact Us</a></li>
                            <li><a href="/site/shipping">Shipping Info</a></li>
                            <li><a href="/site/returns">Returns</a></li>
                            <li><a href="/site/faq">FAQ</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="about-us">
                    <h4 class="footer-heading footer-title">
                        Quick Links
                    </h4>
                    <div class="footer-link about-link">
                        <ul>
                            <li><a href="/product/sale">Special Offers</a></li>
                            <li><a href="/product/new">New Arrivals</a></li>
                            <li><a href="/product/bestsellers">Bestsellers</a></li>
                            <li><a href="/site/sitemap">Site Map</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="about-us">
                    <h4 class="footer-heading footer-title">
                        Policies
                    </h4>
                    <div class="footer-link about-link">
                        <ul>
                            <li><a href="/site/privacy">Privacy Policy</a></li>
                            <li><a href="/site/terms">Terms of Use</a></li>
                            <li><a href="/site/security">Security</a></li>
                            <li><a href="/site/accessibility">Accessibility</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        ';
    }

    /**
     * Получает меню в подвале по конкретному slug
     */
    public static function getFooterMenuBySlug($slug)
    {
        $menu = self::find()
            ->where(['slug' => $slug, 'status' => 1])
            ->one();

        if (!$menu) {
            return '';
        }

        $items = MenuItem::find()
            ->where([
                'menu_id' => $menu->id,
                'status' => 1,
                'parent_id' => null
            ])
            ->orderBy(['sort_order' => SORT_ASC])
            ->all();

        $html = '<div class="col-lg-3 col-sm-6">';
        $html .= '<div class="about-us">';
        $html .= '<h4 class="footer-heading footer-title">' . htmlspecialchars($menu->name) . '</h4>';
        $html .= '<div class="footer-link about-link">';
        $html .= '<ul>';

        foreach ($items as $item) {
            $url = self::getItemUrl($item);
            $html .= '<li><a href="' . $url . '">' . htmlspecialchars($item->title) . '</a></li>';
        }

        $html .= '</ul>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';

        return $html;
    }
}
