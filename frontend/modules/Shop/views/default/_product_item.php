<?php
use yii\helpers\Html;
use yii\helpers\Url;

/** @var $model \app\models\Product */
?>

<div class="product-wrapper aos-init aos-animate" data-aos="fade-up">
    <div class="product-img">
        <?= Html::img(
            $model->main_image ?: '/images/placeholder.jpg',
            [
                'alt' => $model->name,
                'class' => 'img-fluid'
            ]
        ) ?>

    </div>
    <div class="product-info">
        <div class="ratings">
            <?= $this->render('_rating_stars', ['rating' => $model->rating]) ?>
        </div>
        <div class="product-description">
            <a href="<?= Url::to(['/shop-product/default/index', 'slug' => $model->slug]) ?>" class="product-details">
                <?= Html::encode($model->name) ?>
            </a>
            <div class="price">
                <?php if ($model->old_price && $model->old_price > $model->price): ?>
                    <span class="price-cut">$<?= number_format($model->old_price, 2) ?></span>
                <?php endif; ?>
                <span class="new-price">$<?= number_format($model->price, 2) ?></span>
            </div>
        </div>
    </div>
    <div class="product-cart-btn">
        <a href="<?= Url::to(['/cart/add', 'id' => $model->id]) ?>" class="product-btn add-to-cart-btn" data-product-id="<?= $model->id ?>">
            Add To Cart
        </a>
    </div>
</div>