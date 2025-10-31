<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Product $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="product-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'slug',
            'sku',
            'description_id',
            'short_description_id',
            'price',
            'old_price',
            'purchase_price',
            'currency',
            'quantity',
            'reserved_quantity',
            'weight',
            'length',
            'width',
            'height',
            'volume',
            'main_image',
            'images:ntext',
            'category_id',
            'brand',
            'model',
            'warranty',
            'country',
            'manufacturer',
            'barcode',
            'seo_title',
            'seo_description',
            'seo_keywords',
            'status',
            'in_stock',
            'is_new',
            'is_featured',
            'is_sale',
            'rating',
            'reviews_count',
            'views_count',
            'sales_count',
            'min_order_quantity',
            'max_order_quantity',
            'step_order_quantity',
            'created_at',
            'updated_at',
            'published_at',
            'reviews:ntext',
        ],
    ]) ?>

</div>
