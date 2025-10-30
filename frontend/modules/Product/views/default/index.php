<?php

use yii\widgets\ListView;
use yii\widgets\Pjax;
use yii\helpers\Html;

?>
<section class="product product-sidebar footer-padding">
    <div class="container">
        <div class="row g-5">
           <?= $this->render('_search', ['model' => $searchModel])?>
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