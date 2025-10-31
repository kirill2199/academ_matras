<?php

use common\models\Product;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var backend\modules\Product\models\ProductSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Product', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'name',
            'slug',
            // 'sku',   
            // 'description_id',
            //'short_description_id',
            'price',
            'old_price',
            //'purchase_price',
            //'currency',
            'quantity',
            //'reserved_quantity',
            'weight',
            'length',
            'width',
            'height',
            //'volume',
            //'main_image',
            //'images:ntext',
            //'category_id',
            'brand',
            //'model',
            //'warranty',
            //'country',
            //'manufacturer',
            //'barcode',
            //'seo_title',
            //'seo_description',
            //'seo_keywords',
            //'status',
            //'in_stock',
            //'is_new',
            //'is_featured',
            //'is_sale',
            //'rating',
            //'reviews_count',
            //'views_count',
            //'sales_count',
            //'min_order_quantity',
            //'max_order_quantity',
            //'step_order_quantity',
            'created_at',
            'updated_at',
            //'published_at',
            //'reviews:ntext',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Product $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
