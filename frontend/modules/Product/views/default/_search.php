<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var frontend\modules\Product\models\ProductSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="col-lg-3">
    <div class="sidebar aos-init aos-animate" data-aos="fade-right">
        <div class="sidebar-section">
            <div class="sidebar-wrapper">
                <h5 class="wrapper-heading">Product Categories</h5>
                <div class="sidebar-item">
                    <?php $form = ActiveForm::begin([
                        'action' => ['index'],
                        'method' => 'get',
                        'options' => [
                            'data-pjax' => 1
                        ],
                    ]); ?>
                    <?php foreach (['weight', 'length', 'height'] as $nameCol): ?>
                        <ul class="sidebar-list">
                            <li>

                                <?php echo $form->field($model, $nameCol)->dropDownList(
                                    [100 => 100, 200 => 200],
                                    [
                                        'id' => $nameCol,
                                        'name' => $nameCol
                                    ]
                                )->label($nameCol, [
                                            'for' => $nameCol
                                        ]) ?>
                            </li>
                            <ul>
                            <?php endforeach ?>

                            <div class="form-group">
                                <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
                                <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
                            </div>

                            <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>