<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\modules\DeliveryMethod\models\DeliveryMethodSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="delivery-method-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'code') ?>

    <?= $form->field($model, 'description') ?>

    <?= $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'free_from') ?>

    <?php // echo $form->field($model, 'calculation_type') ?>

    <?php // echo $form->field($model, 'min_days') ?>

    <?php // echo $form->field($model, 'max_days') ?>

    <?php // echo $form->field($model, 'cutoff_time') ?>

    <?php // echo $form->field($model, 'min_weight') ?>

    <?php // echo $form->field($model, 'max_weight') ?>

    <?php // echo $form->field($model, 'available_countries') ?>

    <?php // echo $form->field($model, 'excluded_countries') ?>

    <?php // echo $form->field($model, 'available_regions') ?>

    <?php // echo $form->field($model, 'available_cities') ?>

    <?php // echo $form->field($model, 'is_active') ?>

    <?php // echo $form->field($model, 'is_self_delivery') ?>

    <?php // echo $form->field($model, 'needs_address') ?>

    <?php // echo $form->field($model, 'sort_order') ?>

    <?php // echo $form->field($model, 'group') ?>

    <?php // echo $form->field($model, 'handler_class') ?>

    <?php // echo $form->field($model, 'tracking_url') ?>

    <?php // echo $form->field($model, 'config') ?>

    <?php // echo $form->field($model, 'insurance_available') ?>

    <?php // echo $form->field($model, 'insurance_rate') ?>

    <?php // echo $form->field($model, 'packaging_fee') ?>

    <?php // echo $form->field($model, 'icon') ?>

    <?php // echo $form->field($model, 'color') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
