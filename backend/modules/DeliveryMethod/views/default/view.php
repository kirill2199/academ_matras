<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\DeliveryMethod $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Delivery Methods', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="delivery-method-view">

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
            'code',
            'description:ntext',
            'price',
            'free_from',
            'calculation_type',
            'min_days',
            'max_days',
            'cutoff_time',
            'min_weight',
            'max_weight',
            'available_countries',
            'excluded_countries',
            'available_regions',
            'available_cities',
            'is_active',
            'is_self_delivery',
            'needs_address',
            'sort_order',
            'group',
            'handler_class',
            'tracking_url:url',
            'config',
            'insurance_available',
            'insurance_rate',
            'packaging_fee',
            'icon',
            'color',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
