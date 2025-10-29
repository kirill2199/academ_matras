<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/swiper10-bundle.min.css',
        'css/bootstrap-5.3.2.min.css',
        "css/nouislider.min.css",
        "css/aos-3.0.0.css",
        "css/style.css",
    ];
    public $js = [
        "/js/jquery_3.7.1.min.js",
        "/js/bootstrap_5.3.2.bundle.min.js",
        "/js/nouislider.min.js",
        "/js/aos-3.0.0.js",
        "/js/swiper10-bundle.min.js",
        "/js/shopus.js",
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',

    ];
}
