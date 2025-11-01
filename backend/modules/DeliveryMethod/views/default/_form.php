<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\DeliveryMethod $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="delivery-method-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'free_from')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'calculation_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'min_days')->textInput() ?>

    <?= $form->field($model, 'max_days')->textInput() ?>

    <?= $form->field($model, 'cutoff_time')->textInput() ?>

    <?= $form->field($model, 'min_weight')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'max_weight')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'available_countries')->textInput() ?>

    <?= $form->field($model, 'excluded_countries')->textInput() ?>

    <?= $form->field($model, 'available_regions')->textInput() ?>

    <?= $form->field($model, 'available_cities')->textInput() ?>

    <?= $form->field($model, 'is_active')->textInput() ?>

    <?= $form->field($model, 'is_self_delivery')->textInput() ?>

    <?= $form->field($model, 'needs_address')->textInput() ?>

    <?= $form->field($model, 'sort_order')->textInput() ?>

    <?= $form->field($model, 'group')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'handler_class')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tracking_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'config')->textInput() ?>

    <?= $form->field($model, 'insurance_available')->textInput() ?>

    <?= $form->field($model, 'insurance_rate')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'packaging_fee')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'icon')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'color')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
