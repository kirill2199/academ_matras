<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\models\Page;

/**
 * PageController handles static pages
 */
class PageController extends Controller
{
    /**
     * Displays page by slug
     * @param string $slug
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($slug)
    {
        $model = $this->findModelBySlug($slug);
        
        // Увеличиваем счетчик просмотров
        $model->updateCounters(['views_count' => 1]);
        
        // Устанавливаем мета-теги
        $this->setMetaTags($model);
        
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the Page model based on its slug
     * @param string $slug
     * @return Page the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModelBySlug($slug)
    {
        $model = Page::find()
            ->where(['slug' => $slug])
            ->andWhere(['is_published' => true])
            ->andWhere(['<=', 'published_at', new \yii\db\Expression('CURRENT_TIMESTAMP')])
            ->one();

        if ($model !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запрашиваемая страница не существует.');
    }

    /**
     * Sets meta tags for the page
     * @param Page $model
     */
    protected function setMetaTags($model)
    {
        $view = Yii::$app->view;
        
        // Title
        if ($model->meta_title) {
            $view->title = $model->meta_title;
        } else {
            $view->title = $model->title;
        }
        
        // Meta description
        if ($model->meta_description) {
            $view->registerMetaTag([
                'name' => 'description',
                'content' => $model->meta_description
            ], 'description');
        } elseif ($model->excerpt) {
            $view->registerMetaTag([
                'name' => 'description',
                'content' => $model->excerpt
            ], 'description');
        }
        
        // Meta keywords
        if ($model->meta_keywords) {
            $view->registerMetaTag([
                'name' => 'keywords',
                'content' => $model->meta_keywords
            ], 'keywords');
        }
        
        // Robots
        if ($model->robots) {
            $view->registerMetaTag([
                'name' => 'robots',
                'content' => $model->robots
            ], 'robots');
        }
        
        // Canonical URL
        if ($model->canonical_url) {
            $view->registerLinkTag([
                'rel' => 'canonical',
                'href' => $model->canonical_url
            ]);
        } else {
            // Автоматический canonical на текущую страницу
            $view->registerLinkTag([
                'rel' => 'canonical',
                'href' => Yii::$app->request->absoluteUrl
            ]);
        }
        
        // Open Graph tags
        $this->setOpenGraphTags($model);
    }

    /**
     * Sets Open Graph meta tags for social sharing
     * @param Page $model
     */
    protected function setOpenGraphTags($model)
    {
        $view = Yii::$app->view;
        $absoluteUrl = Yii::$app->request->absoluteUrl;
        
        // OG Title
        $view->registerMetaTag([
            'property' => 'og:title',
            'content' => $model->meta_title ?: $model->title
        ], 'og:title');
        
        // OG Description
        $ogDescription = $model->meta_description ?: $model->excerpt ?: strip_tags($model->content);
        $ogDescription = mb_substr($ogDescription, 0, 200);
        $view->registerMetaTag([
            'property' => 'og:description',
            'content' => $ogDescription
        ], 'og:description');
        
        // OG URL
        $view->registerMetaTag([
            'property' => 'og:url',
            'content' => $absoluteUrl
        ], 'og:url');
        
        // OG Type
        $view->registerMetaTag([
            'property' => 'og:type',
            'content' => 'article'
        ], 'og:type');
        
        // OG Image
        $ogImage = $model->og_image ?: $model->featured_image;
        if ($ogImage) {
            if (strpos($ogImage, 'http') !== 0) {
                $ogImage = Yii::$app->request->hostInfo . $ogImage;
            }
            $view->registerMetaTag([
                'property' => 'og:image',
                'content' => $ogImage
            ], 'og:image');
            
            if ($model->image_alt) {
                $view->registerMetaTag([
                    'property' => 'og:image:alt',
                    'content' => $model->image_alt
                ], 'og:image:alt');
            }
        }
        
        // OG Site Name
        $view->registerMetaTag([
            'property' => 'og:site_name',
            'content' => Yii::$app->name
        ], 'og:site_name');
    }
}