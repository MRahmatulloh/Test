<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Pricelist;

/**
 * PricelistSearch represents the model behind the search form of `app\models\Pricelist`.
 */
class PricelistSearch extends Pricelist
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'goods_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['date', 'myPageSize'], 'safe'],
            [['price_credit', 'price_full', 'price_transfer'], 'number'],
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
        $query = Pricelist::find()
            ->orderBy('date DESC, id DESC');

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
            'date' => $this->date,
            'goods_id' => $this->goods_id,
            'price_credit' => $this->price_credit,
            'price_full' => $this->price_full,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $dataProvider->pagination->pageSize = $this->myPageSize ?? 20;
        return $dataProvider;
    }

    public function searchCustom($params)
    {
        $query = Pricelist::find()
            ->leftJoin('
                        ( 
                            select id, goods_id, date, price_credit, price_full, price_transfer
                            from (select row_number() over (partition by goods_id order by date DESC, id DESC) rownum, pricelist.*
                                  from pricelist) dt
                            where rownum = 1
                        ) as lp',
                'lp.id = pricelist.id'
            )
            ->where('pricelist.id = lp.id')
            ->orderBy('pricelist.date DESC, pricelist.id DESC');

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
//            'pricelist.id' => 'lp.id',
            'date' => $this->date,
            'pricelist.goods_id' => $this->goods_id,
            'price_credit' => $this->price_credit,
            'price_full' => $this->price_full,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $dataProvider->pagination->pageSize = $this->myPageSize ?? 20;
        return $dataProvider;
    }
}
