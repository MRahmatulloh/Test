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
    public $from;
    public $to;
    public $warehouse_id;
    public $client_name;
    public $client_id;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'movement_id', 'goods_id', 'currency_id', 'rasxod_goods_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['amount', 'cost', 'cost_return'], 'number'],
            [['client_name'], 'string'],
            [['from', 'to', 'myPageSize'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'from' => 'Дата с',
            'to' => 'По',
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
        $query = MovementGoods::find()
            ->joinWith(['movement m'])
            ->orderBy(['m.date' => SORT_DESC, 'm.id' => SORT_DESC]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->to)
            $this->to = date('Y-m-d');
        if (!$this->from)
            $this->from = date('Y-m-01');

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andWhere(['>=', 'm.date', dateBase($this->from)])
            ->andWhere(['<=', 'm.date', dateBase($this->to)]);

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

        $dataProvider->pagination->pageSize = $this->myPageSize ?? 20;
        return $dataProvider;
    }
}
