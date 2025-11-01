<?php

namespace backend\modules\DeliveryMethod\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\DeliveryMethod;

/**
 * DeliveryMethodSearch represents the model behind the search form of `common\models\DeliveryMethod`.
 */
class DeliveryMethodSearch extends DeliveryMethod
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'min_days', 'max_days', 'is_active', 'is_self_delivery', 'needs_address', 'sort_order', 'insurance_available'], 'integer'],
            [['name', 'code', 'description', 'calculation_type', 'cutoff_time', 'available_countries', 'excluded_countries', 'available_regions', 'available_cities', 'group', 'handler_class', 'tracking_url', 'config', 'icon', 'color', 'created_at', 'updated_at'], 'safe'],
            [['price', 'free_from', 'min_weight', 'max_weight', 'insurance_rate', 'packaging_fee'], 'number'],
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
    public function search($params, $formName = null)
    {
        $query = DeliveryMethod::find();

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
            'price' => $this->price,
            'free_from' => $this->free_from,
            'min_days' => $this->min_days,
            'max_days' => $this->max_days,
            'cutoff_time' => $this->cutoff_time,
            'min_weight' => $this->min_weight,
            'max_weight' => $this->max_weight,
            'is_active' => $this->is_active,
            'is_self_delivery' => $this->is_self_delivery,
            'needs_address' => $this->needs_address,
            'sort_order' => $this->sort_order,
            'insurance_available' => $this->insurance_available,
            'insurance_rate' => $this->insurance_rate,
            'packaging_fee' => $this->packaging_fee,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'calculation_type', $this->calculation_type])
            ->andFilterWhere(['like', 'available_countries', $this->available_countries])
            ->andFilterWhere(['like', 'excluded_countries', $this->excluded_countries])
            ->andFilterWhere(['like', 'available_regions', $this->available_regions])
            ->andFilterWhere(['like', 'available_cities', $this->available_cities])
            ->andFilterWhere(['like', 'group', $this->group])
            ->andFilterWhere(['like', 'handler_class', $this->handler_class])
            ->andFilterWhere(['like', 'tracking_url', $this->tracking_url])
            ->andFilterWhere(['like', 'config', $this->config])
            ->andFilterWhere(['like', 'icon', $this->icon])
            ->andFilterWhere(['like', 'color', $this->color]);

        return $dataProvider;
    }
}
