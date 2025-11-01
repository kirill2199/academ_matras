<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\modules\Order\models\OrderSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="order-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'number') ?>

    <?= $form->field($model, 'status') ?>

    <?= $form->field($model, 'payment_status') ?>

    <?php // echo $form->field($model, 'payment_method') ?>

    <?php // echo $form->field($model, 'delivery_method') ?>

    <?php // echo $form->field($model, 'delivery_price') ?>

    <?php // echo $form->field($model, 'customer_name') ?>

    <?php // echo $form->field($model, 'customer_last_name') ?>

    <?php // echo $form->field($model, 'customer_email') ?>

    <?php // echo $form->field($model, 'customer_phone') ?>

    <?php // echo $form->field($model, 'delivery_address') ?>

    <?php // echo $form->field($model, 'delivery_city') ?>

    <?php // echo $form->field($model, 'delivery_region') ?>

    <?php // echo $form->field($model, 'delivery_country') ?>

    <?php // echo $form->field($model, 'delivery_postcode') ?>

    <?php // echo $form->field($model, 'subtotal') ?>

    <?php // echo $form->field($model, 'tax_amount') ?>

    <?php // echo $form->field($model, 'discount_amount') ?>

    <?php // echo $form->field($model, 'total') ?>

    <?php // echo $form->field($model, 'currency') ?>

    <?php // echo $form->field($model, 'exchange_rate') ?>

    <?php // echo $form->field($model, 'customer_comment') ?>

    <?php // echo $form->field($model, 'admin_comment') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'paid_at') ?>

    <?php // echo $form->field($model, 'completed_at') ?>

    <?php // echo $form->field($model, 'cancelled_at') ?>

    <?php // echo $form->field($model, 'ip_address') ?>

    <?php // echo $form->field($model, 'user_agent') ?>

    <?php // echo $form->field($model, 'tracking_number') ?>

    <?php // echo $form->field($model, 'weight_total') ?>

    <?php // echo $form->field($model, 'source') ?>

    <?php // echo $form->field($model, 'referrer') ?>

    <?php // echo $form->field($model, 'utm_source') ?>

    <?php // echo $form->field($model, 'utm_medium') ?>

    <?php // echo $form->field($model, 'utm_campaign') ?>

    <?php // echo $form->field($model, 'utm_term') ?>

    <?php // echo $form->field($model, 'utm_content') ?>

    <?php // echo $form->field($model, 'manager_id') ?>

    <?php // echo $form->field($model, 'priority') ?>

    <?php // echo $form->field($model, 'estimated_delivery_date') ?>

    <?php // echo $form->field($model, 'actual_delivery_date') ?>

    <?php // echo $form->field($model, 'refund_amount') ?>

    <?php // echo $form->field($model, 'refund_reason') ?>

    <?php // echo $form->field($model, 'cancellation_reason') ?>

    <?php // echo $form->field($model, 'version') ?>

    <?php // echo $form->field($model, 'is_deleted') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
