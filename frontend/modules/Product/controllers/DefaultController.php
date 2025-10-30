<?php

namespace frontend\modules\Product\controllers;

use common\models\Product;
use common\models\Review;
use frontend\modules\Product\models\ProductSearch;
use frontend\helpers\ShopHelpers;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DefaultController implements the CRUD actions for Product model.
 */
class DefaultController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Product models.
     *
     * @param string $slug
     * @return string
     */
    public function actionIndex($slug = null)
    {
        $model = Product::findOne(['slug' => $slug]);
        if (!$model) {
            throw new NotFoundHttpException();

        }
        $productArray = $model->toArray();
        $productArray['images'] = explode(',', $productArray['images']);
        if ($model->description_id) {
            $productArray['description'] = $model->description->description;
            $productArray['short_description'] = $model->description->short_description;
        }
        $productArray['rating'] = ShopHelpers::renderRatingStars($productArray['rating']);
        $productArray['category_name'] = $model->category->name;
        $productArray['filter'] = Product::getUniqueSizesByCategory($model->category_id);
        $productArray['reviews'] = Review::getReviewsByIdsString($model->reviews);
        $productArray['attributeLabels'] = $model->attributeLabels();
        return $this->render('index', [
            'productArray' => $productArray
        ]);
    }
    
}
