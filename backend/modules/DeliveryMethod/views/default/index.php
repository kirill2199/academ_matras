<?php

use common\models\DeliveryMethod;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var backend\modules\DeliveryMethod\models\DeliveryMethodSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Delivery Methods';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="delivery-method-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Delivery Method', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'code',
            'description:ntext',
            'price',
            //'free_from',
            //'calculation_type',
            //'min_days',
            //'max_days',
            //'cutoff_time',
            //'min_weight',
            //'max_weight',
            //'available_countries',
            //'excluded_countries',
            //'available_regions',
            //'available_cities',
            //'is_active',
            //'is_self_delivery',
            //'needs_address',
            //'sort_order',
            //'group',
            //'handler_class',
            //'tracking_url:url',
            //'config',
            //'insurance_available',
            //'insurance_rate',
            //'packaging_fee',
            //'icon',
            //'color',
            //'created_at',
            //'updated_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, DeliveryMethod $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
