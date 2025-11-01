<?php

namespace backend\modules\Characteristic\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Characteristic;

/**
 * CharacteristicSearch represents the model behind the search form of `common\models\Characteristic`.
 */
class CharacteristicSearch extends Characteristic
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'sort_order', 'required', 'category_id', 'filterable'], 'integer'],
            [['name', 'type', 'unit', 'variants', 'created_at', 'updated_at'], 'safe'],
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
        $query = Characteristic::find();

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
            'sort_order' => $this->sort_order,
            'required' => $this->required,
            'category_id' => $this->category_id,
            'filterable' => $this->filterable,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'unit', $this->unit])
            ->andFilterWhere(['like', 'variants', $this->variants]);

        return $dataProvider;
    }
}
