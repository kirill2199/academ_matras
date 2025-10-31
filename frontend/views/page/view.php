<?php

use yii\helpers\Html;

/** @var $this \yii\web\View */
/** @var $model \common\models\Page */

$this->params['breadcrumbs'][] = $model->title;
?>

<article class="page-view">
    <div class="container">
        <?php if ($model->featured_image): ?>
            <div class="page-featured-image">
                <?= Html::img($model->featured_image, [
                    'alt' => $model->image_alt ?: $model->title,
                    'class' => 'img-fluid'
                ]) ?>
            </div>
        <?php endif; ?>
        
        <header class="page-header">
            <h1 class="page-title"><?= Html::encode($model->title) ?></h1>
            
            <?php if ($model->excerpt): ?>
                <div class="page-excerpt">
                    <?= Html::encode($model->excerpt) ?>
                </div>
            <?php endif; ?>
            
            <div class="page-meta">
                <?php if ($model->published_at): ?>
                    <time datetime="<?= Yii::$app->formatter->asDatetime($model->published_at, 'php:c') ?>">
                        <?= Yii::$app->formatter->asDate($model->published_at) ?>
                    </time>
                <?php endif; ?>
                
                <?php if ($model->views_count > 0): ?>
                    <span class="views-count">
                        <?= Yii::t('app', '{count} views', ['count' => $model->views_count]) ?>
                    </span>
                <?php endif; ?>
            </div>
        </header>
        
        <div class="page-content">
            <?= $model->content ?>
        </div>
        
        <?php if ($model->type === 'contact'): ?>
            <div class="page-contact-form">
                <h2>Форма обратной связи</h2>
                <?= $this->render('_contact_form') ?>
            </div>
        <?php endif; ?>
    </div>
</article>