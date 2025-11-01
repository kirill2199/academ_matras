<?php

namespace backend\modules\Order\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Order;

/**
 * OrderSearch represents the model behind the search form of `common\models\Order`.
 */
class OrderSearch extends Order
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'status', 'payment_status', 'manager_id', 'priority', 'version', 'is_deleted'], 'integer'],
            [['number', 'payment_method', 'delivery_method', 'customer_name', 'customer_last_name', 'customer_email', 'customer_phone', 'delivery_address', 'delivery_city', 'delivery_region', 'delivery_country', 'delivery_postcode', 'currency', 'customer_comment', 'admin_comment', 'created_at', 'updated_at', 'paid_at', 'completed_at', 'cancelled_at', 'ip_address', 'user_agent', 'tracking_number', 'source', 'referrer', 'utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content', 'estimated_delivery_date', 'actual_delivery_date', 'refund_reason', 'cancellation_reason'], 'safe'],
            [['delivery_price', 'subtotal', 'tax_amount', 'discount_amount', 'total', 'exchange_rate', 'weight_total', 'refund_amount'], 'number'],
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
        $query = Order::find();

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
            'user_id' => $this->user_id,
            'status' => $this->status,
            'payment_status' => $this->payment_status,
            'delivery_price' => $this->delivery_price,
            'subtotal' => $this->subtotal,
            'tax_amount' => $this->tax_amount,
            'discount_amount' => $this->discount_amount,
            'total' => $this->total,
            'exchange_rate' => $this->exchange_rate,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'paid_at' => $this->paid_at,
            'completed_at' => $this->completed_at,
            'cancelled_at' => $this->cancelled_at,
            'weight_total' => $this->weight_total,
            'manager_id' => $this->manager_id,
            'priority' => $this->priority,
            'estimated_delivery_date' => $this->estimated_delivery_date,
            'actual_delivery_date' => $this->actual_delivery_date,
            'refund_amount' => $this->refund_amount,
            'version' => $this->version,
            'is_deleted' => $this->is_deleted,
        ]);

        $query->andFilterWhere(['like', 'number', $this->number])
            ->andFilterWhere(['like', 'payment_method', $this->payment_method])
            ->andFilterWhere(['like', 'delivery_method', $this->delivery_method])
            ->andFilterWhere(['like', 'customer_name', $this->customer_name])
            ->andFilterWhere(['like', 'customer_last_name', $this->customer_last_name])
            ->andFilterWhere(['like', 'customer_email', $this->customer_email])
            ->andFilterWhere(['like', 'customer_phone', $this->customer_phone])
            ->andFilterWhere(['like', 'delivery_address', $this->delivery_address])
            ->andFilterWhere(['like', 'delivery_city', $this->delivery_city])
            ->andFilterWhere(['like', 'delivery_region', $this->delivery_region])
            ->andFilterWhere(['like', 'delivery_country', $this->delivery_country])
            ->andFilterWhere(['like', 'delivery_postcode', $this->delivery_postcode])
            ->andFilterWhere(['like', 'currency', $this->currency])
            ->andFilterWhere(['like', 'customer_comment', $this->customer_comment])
            ->andFilterWhere(['like', 'admin_comment', $this->admin_comment])
            ->andFilterWhere(['like', 'ip_address', $this->ip_address])
            ->andFilterWhere(['like', 'user_agent', $this->user_agent])
            ->andFilterWhere(['like', 'tracking_number', $this->tracking_number])
            ->andFilterWhere(['like', 'source', $this->source])
            ->andFilterWhere(['like', 'referrer', $this->referrer])
            ->andFilterWhere(['like', 'utm_source', $this->utm_source])
            ->andFilterWhere(['like', 'utm_medium', $this->utm_medium])
            ->andFilterWhere(['like', 'utm_campaign', $this->utm_campaign])
            ->andFilterWhere(['like', 'utm_term', $this->utm_term])
            ->andFilterWhere(['like', 'utm_content', $this->utm_content])
            ->andFilterWhere(['like', 'refund_reason', $this->refund_reason])
            ->andFilterWhere(['like', 'cancellation_reason', $this->cancellation_reason]);

        return $dataProvider;
    }
}
