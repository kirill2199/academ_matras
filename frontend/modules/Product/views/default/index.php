<?php

use yii\widgets\ListView;
use yii\widgets\Pjax;
use yii\helpers\Html;

?>
<section class="product product-sidebar footer-padding">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-3">
                <div class="sidebar aos-init aos-animate" data-aos="fade-right">
                    <div class="sidebar-section">
                        <div class="sidebar-wrapper">
                            <h5 class="wrapper-heading">Product Categories</h5>
                            <div class="sidebar-item">
                                <ul class="sidebar-list">
                                    <li>
                                        <input type="checkbox" id="mobile" name="mobile">
                                        <label for="mobile">Mobile &amp; Laptops</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="bags" name="bags">
                                        <label for="bags">Bags</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="sweatshirt" name="sweatshirt">
                                        <label for="sweatshirt">Sweatshirt</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="boots" name="boots">
                                        <label for="boots">Boots</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="accessories" name="accessories">
                                        <label for="accessories">Accessories</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="sneakers" name="sneakers">
                                        <label for="sneakers">Sneakers</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="outerwear" name="outerwear">
                                        <label for="outerwear">Outerwear</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="activewear" name="activewear">
                                        <label for="activewear">Activewear</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="grooming" name="grooming">
                                        <label for="grooming">Grooming</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="cosmatics" name="cosmatics">
                                        <label for="cosmatics">Cosmetics</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="watch" name="watch">
                                        <label for="watch">Watch</label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <hr>
                        <div class="sidebar-wrapper sidebar-range">
                            <h5 class="wrapper-heading">Price Range</h5>
                            <div class="price-slide range-slider">
                                <div class="price">
                                    <div class="range-slider style-1">
                                        <div id="slider-tooltips"
                                            class="slider-range mb-3 noUi-target noUi-ltr noUi-horizontal noUi-txt-dir-ltr">
                                            <div class="noUi-base">
                                                <div class="noUi-connects">
                                                    <div class="noUi-connect"
                                                        style="transform: translate(10%, 0px) scale(0.765, 1);"></div>
                                                </div>
                                                <div class="noUi-origin"
                                                    style="transform: translate(-90%, 0px); z-index: 5;">
                                                    <div class="noUi-handle noUi-handle-lower" data-handle="0"
                                                        tabindex="0" role="slider" aria-orientation="horizontal"
                                                        aria-valuemin="0.0" aria-valuemax="346.0" aria-valuenow="40.0"
                                                        aria-valuetext="40">
                                                        <div class="noUi-touch-area"></div>
                                                    </div>
                                                </div>
                                                <div class="noUi-origin"
                                                    style="transform: translate(-13.5%, 0px); z-index: 4;">
                                                    <div class="noUi-handle noUi-handle-upper" data-handle="1"
                                                        tabindex="0" role="slider" aria-orientation="horizontal"
                                                        aria-valuemin="40.0" aria-valuemax="400.0" aria-valuenow="346.0"
                                                        aria-valuetext="346">
                                                        <div class="noUi-touch-area"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="example-val" id="slider-margin-value-min">Price: $40</span>
                                        <span>-</span>
                                        <span class="example-val" id="slider-margin-value-max">$346</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="sidebar-wrapper">
                            <h5 class="wrapper-heading">Brands</h5>
                            <div class="sidebar-item">
                                <ul class="sidebar-list">
                                    <li>
                                        <input type="checkbox" id="thread" name="thread">
                                        <label for="thread">Refined Threads
                                        </label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="ethereal" name="ethereal">
                                        <label for="ethereal">Ethereal Chic</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="yellow" name="yellow">
                                        <label for="yellow">Yellow</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="esctasy" name="esctasy">
                                        <label for="esctasy">Esctasy</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="urban" name="urban">
                                        <label for="urban">Urban Hive</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="velvet" name="velvet">
                                        <label for="velvet">Velvet Vista</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="boldly" name="boldly">
                                        <label for="boldly">Boldly Blue</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="minted" name="minted">
                                        <label for="minted">Minted Mode</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="ensemble" name="ensemble">
                                        <label for="ensemble">Eclectic Ensemble</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="attire" name="attire">
                                        <label for="attire">BraveAlchemy Attire</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="couture" name="couture">
                                        <label for="couture">Cascade Couture</label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <hr>
                        <div class="sidebar-wrapper">
                            <h5 class="wrapper-heading">Color</h5>
                            <div class="sidebar-item">
                                <ul class="sidebar-list">
                                    <li>
                                        <input type="checkbox" id="red" name="red">
                                        <label for="red">Red</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="blue" name="blue">
                                        <label for="blue">blue</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="navy" name="navy">
                                        <label for="navy">Navy</label>
                                    </li>

                                </ul>
                            </div>
                        </div>
                        <hr>
                        <div class="sidebar-wrapper">
                            <h5 class="wrapper-heading">Size</h5>
                            <div class="sidebar-item">
                                <ul class="sidebar-list">
                                    <li>
                                        <input type="checkbox" id="small" name="small">
                                        <label for="small">Small</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="medium" name="medium">
                                        <label for="medium">Medium</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="large" name="large">
                                        <label for="large">Large</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="xl" name="xl">
                                        <label for="xl">XL</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" id="2xl" name="2xl">
                                        <label for="2xl">2XL</label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="sidebar-shop-section">
                        <span class="wrapper-subtitle">TRENDY</span>
                        <h5 class="wrapper-heading">Best wireless Shoes</h5>
                        <a href="seller-sidebar.html" class="shop-btn deal-btn">Shop Now </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="product-sidebar-section aos-init aos-animate" data-aos="fade-up">
                    <div class="row g-5">
                        <div class="col-lg-12">
                            <div class="product-sorting-section">
                                <div class="result">
                                    <p>
                                        <?= Html::tag(
                                            'span',
                                            "Showing 1–16 of {$dataProvider->getTotalCount()} results"
                                        ) ?>
                                    </p>
                                </div>
                                <div class="product-sorting">
                                    <span class="product-sort">Sort by:</span>
                                    <div class="product-list">
                                        <span class="default">Default</span>
                                        <span>
                                            <svg width="10" height="6" viewBox="0 0 10 6" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path d="M1 1L5 5L9 1" stroke="#9A9A9A"></path>
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php Pjax::begin(['id' => 'product-list-pjax']); ?>

                        <?= ListView::widget([
                            'dataProvider' => $dataProvider,
                            'layout' => "{items}\n<div class='col-12'>{pager}</div>",
                            'options' => [
                                'class' => 'row g-4',
                                'tag' => 'div'
                            ],
                            'itemOptions' => [
                                'class' => 'col-lg-4 col-sm-6',
                                'tag' => 'div'
                            ],
                            'itemView' => '_product_item',
                            'pager' => [
                                'options' => ['class' => 'pagination justify-content-center mt-4'],
                                'linkOptions' => ['class' => 'page-link'],
                                'pageCssClass' => 'page-item',
                                'activePageCssClass' => 'active',
                                'prevPageCssClass' => 'page-item',
                                'nextPageCssClass' => 'page-item',
                                'prevPageLabel' => 'Previous',
                                'nextPageLabel' => 'Next',
                            ],
                            'emptyText' => '<div class="col-12 text-center"><p>No products found.</p></div>',
                            'emptyTextOptions' => ['class' => 'col-12']
                        ]); ?>

                        <?php Pjax::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>