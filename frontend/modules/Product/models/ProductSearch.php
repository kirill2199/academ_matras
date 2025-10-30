<?php

namespace frontend\modules\Product\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Product;

/**
 * ProductSearch represents the model behind the search form of `common\models\Product`.
 */
class ProductSearch extends Product
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'description_id', 'short_description_id', 'quantity', 'reserved_quantity', 'category_id', 'warranty', 'status', 'in_stock', 'is_new', 'is_featured', 'is_sale', 'reviews_count', 'views_count', 'sales_count', 'min_order_quantity', 'max_order_quantity', 'step_order_quantity'], 'integer'],
            [['name', 'slug', 'sku', 'currency', 'main_image', 'images', 'brand', 'model', 'country', 'manufacturer', 'barcode', 'seo_title', 'seo_description', 'seo_keywords', 'created_at', 'updated_at', 'published_at'], 'safe'],
            [['price', 'old_price', 'purchase_price', 'weight', 'length', 'width', 'height', 'volume', 'rating'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @param string|null $formName Form name to be used into `->load()` method.
     *
     * @return ActiveDataProvider
     */
    public function search($params, $slug=null, $formName = null)
    {
        $query = Product::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'description_id' => $this->description_id,
            'short_description_id' => $this->short_description_id,
            'price' => $this->price,
            'old_price' => $this->old_price,
            'purchase_price' => $this->purchase_price,
            'quantity' => $this->quantity,
            'reserved_quantity' => $this->reserved_quantity,
            'weight' => $this->weight,
            'length' => $this->length,
            'width' => $this->width,
            'height' => $this->height,
            'volume' => $this->volume,
            'category_id' => $this->category_id,
            'warranty' => $this->warranty,
            'status' => $this->status,
            'in_stock' => $this->in_stock,
            'is_new' => $this->is_new,
            'is_featured' => $this->is_featured,
            'is_sale' => $this->is_sale,
            'rating' => $this->rating,
            'reviews_count' => $this->reviews_count,
            'views_count' => $this->views_count,
            'sales_count' => $this->sales_count,
            'min_order_quantity' => $this->min_order_quantity,
            'max_order_quantity' => $this->max_order_quantity,
            'step_order_quantity' => $this->step_order_quantity,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'published_at' => $this->published_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'slug', $slug])
            ->andFilterWhere(['like', 'sku', $this->sku])
            ->andFilterWhere(['like', 'currency', $this->currency])
            ->andFilterWhere(['like', 'main_image', $this->main_image])
            ->andFilterWhere(['like', 'images', $this->images])
            ->andFilterWhere(['like', 'brand', $this->brand])
            ->andFilterWhere(['like', 'model', $this->model])
            ->andFilterWhere(['like', 'country', $this->country])
            ->andFilterWhere(['like', 'manufacturer', $this->manufacturer])
            ->andFilterWhere(['like', 'barcode', $this->barcode])
            ->andFilterWhere(['like', 'seo_title', $this->seo_title])
            ->andFilterWhere(['like', 'seo_description', $this->seo_description])
            ->andFilterWhere(['like', 'seo_keywords', $this->seo_keywords]);

        return $dataProvider;
    }
}
