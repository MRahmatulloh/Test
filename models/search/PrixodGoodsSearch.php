<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PrixodGoods;
/**
 * This is the model class for filtering any purposes.
 *
 * @property string $from
 * @property string $to
 * @property int $category_id
 * @property int $warehouse_id
 * @property int $client_id
 */
/**
 * PrixodGoodsSearch represents the model behind the search form of `app\models\PrixodGoods`.
 */
class PrixodGoodsSearch extends PrixodGoods
{
    public $from;
    public $to;
    public $warehouse_id;
    public $client_id;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'prixod_id', 'goods_id', 'currency_id', 'warehouse_id',
                'client_id'], 'integer'],
            [['amount', 'cost', 'cost_usd'], 'number'],
            [['from', 'to'], 'safe']
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
        $query = PrixodGoods::find()
            ->joinWith('prixod p');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

//        prd($this);

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
        $query->andWhere(['>=', 'p.date',  dateBase($this->from)])
            ->andWhere(['<=', 'p.date',  dateBase($this->to)]);

        $query->andFilterWhere([
            'prixod_id' => $this->prixod_id,
            'goods_id' => $this->goods_id,
            'currency_id' => $this->currency_id,
            'amount' => $this->amount,
            'cost' => $this->cost,
            'cost_usd' => $this->cost_usd,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);
//        prd($query->createCommand()->getRawSql());

        return $dataProvider;
    }
}
