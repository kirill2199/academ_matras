<?php

use common\models\Product;
use yii\helpers\Html;
use frontend\helpers\ShopHelpers;

// dd($productArray);
?>




<section class="product product-info">
    <div class="container">
        <div class="blog-bradcrum">
            <span><a href="/">Home</a></span>
            <span class="devider">/</span>
            <span><a href="/shop/default/index">Shop</a></span>
            <span class="devider">/</span>
            <span><a
                    href="/shop-product/default/index?slug=<?= $productArray["slug"] ?>"><?= $productArray['name'] ?></a></span>
        </div>
        <div class="product-info-section">
            <div class="row ">
                <div class="col-md-6">
                    <div class="product-info-img aos-init aos-animate" data-aos="fade-right">
                        <div class="swiper product-top swiper-initialized swiper-horizontal swiper-backface-hidden">
                            <div class="swiper-wrapper" id="swiper-wrapper-cf4adff28d1c4a08" aria-live="polite">
                                <?php foreach ($productArray['images'] as $index => $image): ?>
                                    <?= Html::tag(
                                        'div',
                                        Html::img($image, ['alt' => 'img']),
                                        [
                                            'class' => 'swiper-slide slider-top-img' .
                                                ($index === 0 ? ' swiper-slide-active' : '') .
                                                ($index === 1 ? ' swiper-slide-next' : ''),
                                            'role' => 'group',
                                            'aria-label' => ($index + 1) . ' / ' . count($productArray['images']),
                                            'data-swiper-slide-index' => $index,
                                            'style' => 'width: 537px; margin-right: 10px;'
                                        ]
                                    ) ?>
                                <?php endforeach; ?>
                            </div>
                            <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
                        </div>

                        <div
                            class="swiper product-bottom swiper-initialized swiper-horizontal swiper-backface-hidden swiper-thumbs">
                            <div class="swiper-wrapper" id="swiper-wrapper-1d91010349a8443387" aria-live="polite"
                                style="transform: translate3d(0px, 0px, 0px);">
                                <?php foreach ($productArray['images'] as $index => $image): ?>
                                    <?= Html::tag(
                                        'div',
                                        Html::img($image, ['alt' => 'img']),
                                        [
                                            'class' => 'swiper-slide slider-bottom-img swiper-slide-visible' .
                                                ($index === 0 ? ' swiper-slide-active swiper-slide-thumb-active' : '') .
                                                ($index === 1 ? ' swiper-slide-next' : ''),
                                            'role' => 'group',
                                            'aria-label' => ($index + 1) . ' / ' . count($productArray['images']),
                                            'data-swiper-slide-index' => $index,
                                            'style' => 'width: 127.25px; margin-right: 10px;'
                                        ]
                                    ) ?>
                                <?php endforeach; ?>
                            </div>
                            <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="product-info-content aos-init aos-animate" data-aos="fade-left">
                        <span class="wrapper-subtitle"><?= $productArray['brand'] ?></span>
                        <h5><?= $productArray['name'] ?>
                        </h5>
                        <div class="ratings">
                            <span>
                                <?= $productArray['rating'] ?>
                            </span>
                            <span class="text">Кол-во просмотров: <?= $productArray['views_count'] ?></span>
                        </div>
                        <div class="price">
                            <span class="price-cut"><?= $productArray['old_price'] ?></span>
                            <span class="new-price"><?= $productArray['price'] ?></span>
                        </div>
                        <div class="product-details">
                            <p class="category">Категория : <span
                                    class="inner-text"><?= $productArray['category_name'] ?></span></p>
                            <p class="sku">SKU : <span class="inner-text"><?= $productArray['sku'] ?></span></p>
                        </div>
                        <p class="content-paragraph"><?= $productArray['short_description'] ?></span></p>
                        <hr>
                        <div class="product-availability">
                            <span>Availabillity : </span>
                            <span class="inner-text">132 Products Available</span>
                        </div>
                        <div class="product-size">
                            <p class="size-title">Размер</p>
                            <div class="size-section">
                                <span class="size-text">Выбрать</span>
                                <div class="toggle-btn">
                                    <span class="toggle-btn2"></span>
                                    <span class="chevron">
                                        <svg width="11" height="7" viewBox="0 0 11 7" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M5.4 6.8L0 1.4L1.4 0L5.4 4L9.4 0L10.8 1.4L5.4 6.8Z" fill="#222222">
                                            </path>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                            <ul class="size-option">
                                <?php foreach ($productArray['filter'] as $key => $value): ?>
                                    <li class="option">
                                        <span class="option-measure"><?= (string) $value ?></span>
                                    </li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                        <div class="product-quantity">
                            <div class="quantity-wrapper">
                                <div class="quantity">
                                    <span class="minus">
                                        -
                                    </span>
                                    <span class="number">1</span>
                                    <span class="plus">
                                        +
                                    </span>
                                </div>
                                <div class="wishlist">
                                    <a href="/add-wish-list/?id=<?= $productArray['id'] ?>">
                                        <span>
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M17 1C14.9 1 13.1 2.1 12 3.7C10.9 2.1 9.1 1 7 1C3.7 1 1 3.7 1 7C1 13 12 22 12 22C12 22 23 13 23 7C23 3.7 20.3 1 17 1Z"
                                                    stroke="#797979" stroke-width="2" stroke-miterlimit="10"
                                                    stroke-linecap="square"></path>
                                            </svg>
                                        </span>
                                    </a>
                                </div>
                            </div>
                            <a href="/add-cart/?id=<?= $productArray['id'] ?>" class="shop-btn">
                                <span>
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M8.25357 3.32575C8.25357 4.00929 8.25193 4.69283 8.25467 5.37583C8.25576 5.68424 8.31536 5.74439 8.62431 5.74439C9.964 5.74603 11.3031 5.74275 12.6428 5.74603C13.2728 5.74767 13.7397 6.05663 13.9246 6.58104C14.2209 7.42098 13.614 8.24232 12.6762 8.25052C11.5919 8.25982 10.5075 8.25271 9.4232 8.25271C9.17714 8.25271 8.93107 8.25216 8.68501 8.25271C8.2913 8.2538 8.25412 8.29154 8.25412 8.69838C8.25357 10.0195 8.25686 11.3412 8.25248 12.6624C8.25029 13.2836 7.92603 13.7544 7.39891 13.9305C6.56448 14.2088 5.75848 13.6062 5.74863 12.6821C5.73824 11.7251 5.74645 10.7687 5.7459 9.81173C5.7459 9.41965 5.74754 9.02812 5.74535 8.63604C5.74371 8.30849 5.69012 8.2538 5.36204 8.25326C4.02235 8.25162 2.68321 8.25545 1.34352 8.25107C0.719613 8.24943 0.249902 7.93008 0.0710952 7.40348C-0.212153 6.57065 0.388245 5.75916 1.31017 5.74658C2.14843 5.73564 2.98669 5.74384 3.82495 5.74384C4.30779 5.74384 4.79062 5.74384 5.274 5.74384C5.72184 5.7433 5.7459 5.71869 5.7459 5.25716C5.7459 3.95406 5.74317 2.65096 5.74699 1.34786C5.74863 0.720643 6.0625 0.253102 6.58799 0.0704598C7.40875 -0.213893 8.21803 0.370671 8.25248 1.27349C8.25303 1.29154 8.25303 1.31013 8.25303 1.32817C8.25357 1.99531 8.25357 2.66026 8.25357 3.32575Z"
                                            fill="white"></path>
                                    </svg>
                                </span>
                                <span>Добавить в корзину</span>
                            </a>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="product product-description">
    <div class="container">
        <div class="product-detail-section">
            <nav>
                <div class="nav nav-tabs nav-item" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home"
                        type="button" role="tab" aria-controls="nav-home" aria-selected="true">Описание</button>
                    <button class="nav-link" id="nav-review-tab" data-bs-toggle="tab" data-bs-target="#nav-review"
                        type="button" role="tab" aria-controls="nav-review" aria-selected="false"
                        tabindex="-1">Отзывы</button>
                </div>
            </nav>
            <div class="tab-content tab-item" id="nav-tabContent">

                <div class="tab-pane fade show active aos-init aos-animate" id="nav-home" role="tabpanel"
                    aria-labelledby="nav-home-tab" tabindex="0" data-aos="fade-up">
                    <div class="product-intro-section">
                        <h5 class="intro-heading">Introduction</h5>
                        <p class="product-details">
                            <?= $productArray['description'] ?>
                        </p>
                    </div>
                    <div class="product-feature">
                        <h5 class="intro-heading">Features :</h5>
                        <ul>
                            <?php $arrayProver = ['weight', 'length', 'height', 'width'];
                            foreach ($productArray as $key => $value) {
                                if (in_array($key, $arrayProver)) {
                                    ?>
                                    <li>
                                        <p><?= $productArray['attributeLabels'][$key] ?> : <?= $value ?></p>
                                    </li>
                                <?php }
                            } ?>
                        </ul>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-review" role="tabpanel" aria-labelledby="nav-review-tab"
                    tabindex="0">
                    <div class="product-review-section aos-init aos-animate" data-aos="fade-up">
                        <h5 class="intro-heading">Reviews</h5>
                        <?php foreach ($productArray['reviews'] as $modelReview): ?>
                            <div class="review-wrapper">
                                <div class="wrapper">
                                    <div class="wrapper-aurthor">
                                        <div class="wrapper-info">
                                            <div class="aurthor-img">
                                                <img src="assets/images/homepage-one/aurthor-img-1.webp" alt="aurthor-img">
                                            </div>
                                            <div class="author-details">
                                                <h5><?= $modelReview->user_name ?></h5>
                                                <p><?= $modelReview->ip_address ?></p>
                                            </div>
                                        </div>
                                        <div class="ratings">

                                            <?= ShopHelpers::renderRatingStars($modelReview->rating) ?>

                                            <span>(<?= $modelReview->rating ?>)</span>
                                        </div>
                                    </div>
                                    <div class="wrapper-description">
                                        <p class="wrapper-details"><?= $modelReview->comment ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>