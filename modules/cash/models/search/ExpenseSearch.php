<?php

namespace app\modules\cash\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\cash\models\Expense;

/**
 * ExpenseSearch represents the model behind the search form of `app\modules\cash\models\Expense`.
 */
class ExpenseSearch extends Expense
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'currency_id', 'client_id', 'payment_type_id', 'reason_id', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['date', 'comment'], 'safe'],
            [['summa', 'summa_usd'], 'number'],
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
        $query = Expense::find();

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
            'summa' => $this->summa,
            'summa_usd' => $this->summa_usd,
            'currency_id' => $this->currency_id,
            'client_id' => $this->client_id,
            'payment_type_id' => $this->payment_type_id,
            'reason_id' => $this->reason_id,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
