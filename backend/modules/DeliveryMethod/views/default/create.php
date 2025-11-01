<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\DeliveryMethod $model */

$this->title = 'Create Delivery Method';
$this->params['breadcrumbs'][] = ['label' => 'Delivery Methods', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="delivery-method-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
