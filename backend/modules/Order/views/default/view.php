<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Order $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="order-view">

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
            'user_id',
            'number',
            'status',
            'payment_status',
            'payment_method',
            'delivery_method',
            'delivery_price',
            'customer_name',
            'customer_last_name',
            'customer_email:email',
            'customer_phone',
            'delivery_address:ntext',
            'delivery_city',
            'delivery_region',
            'delivery_country',
            'delivery_postcode',
            'subtotal',
            'tax_amount',
            'discount_amount',
            'total',
            'currency',
            'exchange_rate',
            'customer_comment:ntext',
            'admin_comment:ntext',
            'created_at',
            'updated_at',
            'paid_at',
            'completed_at',
            'cancelled_at',
            'ip_address',
            'user_agent:ntext',
            'tracking_number',
            'weight_total',
            'source',
            'referrer',
            'utm_source',
            'utm_medium',
            'utm_campaign',
            'utm_term',
            'utm_content',
            'manager_id',
            'priority',
            'estimated_delivery_date',
            'actual_delivery_date',
            'refund_amount',
            'refund_reason:ntext',
            'cancellation_reason:ntext',
            'version',
            'is_deleted',
        ],
    ]) ?>

</div>
