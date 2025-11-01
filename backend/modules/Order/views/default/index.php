<?php

use common\models\Order;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var backend\modules\Order\models\OrderSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Order', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
            'number',
            'status',
            'payment_status',
            //'payment_method',
            //'delivery_method',
            //'delivery_price',
            //'customer_name',
            //'customer_last_name',
            //'customer_email:email',
            //'customer_phone',
            //'delivery_address:ntext',
            //'delivery_city',
            //'delivery_region',
            //'delivery_country',
            //'delivery_postcode',
            //'subtotal',
            //'tax_amount',
            //'discount_amount',
            //'total',
            //'currency',
            //'exchange_rate',
            //'customer_comment:ntext',
            //'admin_comment:ntext',
            //'created_at',
            //'updated_at',
            //'paid_at',
            //'completed_at',
            //'cancelled_at',
            //'ip_address',
            //'user_agent:ntext',
            //'tracking_number',
            //'weight_total',
            //'source',
            //'referrer',
            //'utm_source',
            //'utm_medium',
            //'utm_campaign',
            //'utm_term',
            //'utm_content',
            //'manager_id',
            //'priority',
            //'estimated_delivery_date',
            //'actual_delivery_date',
            //'refund_amount',
            //'refund_reason:ntext',
            //'cancellation_reason:ntext',
            //'version',
            //'is_deleted',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Order $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
