<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MovementGoods;

/**
 * MovementGoodsSearch represents the model behind the search form of `app\models\MovementGoods`.
 */
class MovementGoodsSearch extends MovementGoods
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'movement_id', 'goods_id', 'currency_id', 'rasxod_goods_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['amount', 'cost', 'cost_return'], 'number'],
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
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = MovementGoods::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'movement_id' => $this->movement_id,
            'goods_id' => $this->goods_id,
            'currency_id' => $this->currency_id,
            'rasxod_goods_id' => $this->rasxod_goods_id,
            'amount' => $this->amount,
            'cost' => $this->cost,
            'cost_return' => $this->cost_return,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        return $dataProvider;
    }
}
