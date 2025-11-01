<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Order $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="order-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'payment_status')->textInput() ?>

    <?= $form->field($model, 'payment_method')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'delivery_method')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'delivery_price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'customer_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'customer_last_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'customer_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'customer_phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'delivery_address')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'delivery_city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'delivery_region')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'delivery_country')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'delivery_postcode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'subtotal')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tax_amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'discount_amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'total')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'currency')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'exchange_rate')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'customer_comment')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'admin_comment')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'paid_at')->textInput() ?>

    <?= $form->field($model, 'completed_at')->textInput() ?>

    <?= $form->field($model, 'cancelled_at')->textInput() ?>

    <?= $form->field($model, 'ip_address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user_agent')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'tracking_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'weight_total')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'source')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'referrer')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'utm_source')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'utm_medium')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'utm_campaign')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'utm_term')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'utm_content')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'manager_id')->textInput() ?>

    <?= $form->field($model, 'priority')->textInput() ?>

    <?= $form->field($model, 'estimated_delivery_date')->textInput() ?>

    <?= $form->field($model, 'actual_delivery_date')->textInput() ?>

    <?= $form->field($model, 'refund_amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'refund_reason')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'cancellation_reason')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'version')->textInput() ?>

    <?= $form->field($model, 'is_deleted')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
