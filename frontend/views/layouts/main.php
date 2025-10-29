<?php

/** @var \yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
       <meta charset="utf-8">
    <link rel="icon" href="/images/homepage-one/icon.png">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body data-aos-easing="ease" data-aos-duration="400" data-aos-delay="0">
<?php $this->beginBody() ?>

<?= $this->render('header/header')?>

 <?= $content ?>

<?= $this->render('footer/footer')?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
