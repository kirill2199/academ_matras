<?php

namespace frontend\modules\Shop\controllers;

use frontend\modules\Product\models\ProductSearch;
use yii\web\Controller;

/**
 * Default controller for the `Shop` module
 */
class DefaultController extends Controller
{
     /**
     * Lists all Product models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
