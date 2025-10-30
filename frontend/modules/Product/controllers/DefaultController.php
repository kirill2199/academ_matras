<?php

namespace frontend\modules\Product\controllers;

use common\models\Product;
use frontend\modules\Product\models\ProductSearch;
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
        $productArray['rating'] = self::renderRatingStars($productArray['rating']);
        $productArray['category_name'] = $model->category->name;
        $productArray['filter'] = Product::getUniqueSizesByCategory($model->category_id);
        return $this->render('index', [
            'productArray' => $productArray
        ]);
    }
    /**
     * Генерирует SVG звезды рейтинга
     * @param float $rating Рейтинг от 0 до 5
     * @return string HTML код с звездами
     */
    private function renderRatingStars($rating)
    {
        $fullStars = floor($rating); // Целые звезды
        $hasHalfStar = ($rating - $fullStars) >= 0.5; // Половина звезды
        $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0); // Пустые звезды

        $starsHtml = '';

        // Полные звезды
        for ($i = 0; $i < $fullStars; $i++) {
            $starsHtml .= '<svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M7.5 0L9.18386 5.18237H14.6329L10.2245 8.38525L11.9084 13.5676L7.5 10.3647L3.09161 13.5676L4.77547 8.38525L0.367076 5.18237H5.81614L7.5 0Z" fill="#FFA800"></path>
        </svg>';
        }

        // Половина звезды
        if ($hasHalfStar) {
            $starsHtml .= '<svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M7.5 0L9.18386 5.18237H14.6329L10.2245 8.38525L11.9084 13.5676L7.5 10.3647L3.09161 13.5676L4.77547 8.38525L0.367076 5.18237H5.81614L7.5 0Z" fill="#FFA800" fill-opacity="0.5"></path>
        </svg>';
        }

        // Пустые звезды
        for ($i = 0; $i < $emptyStars; $i++) {
            $starsHtml .= '<svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M7.5 0L9.18386 5.18237H14.6329L10.2245 8.38525L11.9084 13.5676L7.5 10.3647L3.09161 13.5676L4.77547 8.38525L0.367076 5.18237H5.81614L7.5 0Z" fill="#E0E0E0"></path>
        </svg>';
        }

        return $starsHtml;
    }
}
