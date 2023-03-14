<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RasxodGoods;

/**
 * RasxodGoodsSearch represents the model behind the search form of `app\models\RasxodGoods`.
 */
class RasxodGoodsSearch extends RasxodGoods
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
            [['id', 'rasxod_id', 'goods_id', 'currency_id', 'prixod_goods_id'], 'integer'],
            [['amount', 'cost', 'cost_usd'], 'number'],
            [['client_name'], 'string'],
            [['from', 'to', 'myPageSize'], 'safe']
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

    public function attributeLabels()
    {
        return [
            'from' => 'Дата с',
            'to' => 'По',
            'client_name' => 'Клиент'
        ];
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
        $query = RasxodGoods::find()
            ->joinWith(['rasxod r', 'rasxod.client c'])
            ->orderBy(['r.date' => SORT_DESC, 'r.id' => SORT_DESC]);

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

        $query->andFilterWhere([
            'id' => $this->id,
            'rasxod_id' => $this->rasxod_id,
            'goods_id' => $this->goods_id,
            'currency_id' => $this->currency_id,
            'prixod_goods_id' => $this->prixod_goods_id,
            'amount' => $this->amount,
            'cost' => $this->cost,
            'cost_usd' => $this->cost_usd,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'c.name', $this->client_name]);

        $dataProvider->pagination->pageSize = $this->myPageSize ?? 20;
        return $dataProvider;
    }
    
        public function searchByGoods($params)
    {
        $query = RasxodGoods::find()
            ->joinWith(['rasxod r', 'rasxod.client c'])
            ->orderBy(['r.date' => SORT_DESC, 'r.id' => SORT_DESC]);

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
        // grid filtering conditions
        $query->andWhere(['>=', 'r.date', dateBase($this->from)])
            ->andWhere(['<=', 'r.date', dateBase($this->to)]);

        $query->andFilterWhere([
            'id' => $this->id,
            'rasxod_id' => $this->rasxod_id,
            'goods_id' => $this->goods_id,
            'currency_id' => $this->currency_id,
            'prixod_goods_id' => $this->prixod_goods_id,
            'amount' => $this->amount,
            'cost' => $this->cost,
            'cost_usd' => $this->cost_usd,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'c.name', $this->client_name]);

        $dataProvider->pagination->pageSize = $this->myPageSize ?? 20;
        return $dataProvider;
    }
}
