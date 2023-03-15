<?php

namespace app\modules\cash\models\search;

use app\models\MyModel;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;

class CashSearch extends MyModel
{
    public $client_id;
    public $client_name;
    public $from;
    public $to;
    public $myPageSize;
    public $currency_id;
    public $payment_type_id;
    public $reason_id;

    public function rules()
    {
        return [
            [['from', 'to'], 'required'],
            [['client_id', 'currency_id', 'payment_type_id', 'reason_id'], 'integer'],
            [['from', 'to', 'myPageSize', 'client_name'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'to' => 'По',
            'from' => 'С',
            'summa_usd' => 'Сумма в USD',
            'currency_id' => 'Валюта',
            'client_id' => 'Клиент',
            'client_name' => 'Клиент',
            'payment_type_id' => 'Тип платежа',
            'reason_id' => 'Цель платежа',
            'comment' => 'Комментарий'
        ];
    }

    public function search($params)
    {
        $this->load($params);
        $params = [];

        $sql = "
            select
                t.*,
                c.name as client_name,
                cu.name as currency_name,
                cu.code as currency_code
            from
                (
                    select p.*, 'payment' as type
                    from payment p 
                    where p.date between :from and :to
                    
                    union all
                    
                    select e.*, 'expense' as type
                    from expense e 
                    where e.date between :from and :to               
                ) 
            as t 
            left join client c on c.id = t.client_id
            left join currency cu on cu.id = t.currency_id
            where 1=1
        ";

        if ($this->client_id) {
            $sql .= " and t.client_id = :client_id";
            $params[':client_id'] = $this->client_id;
        }

        if ($this->client_name) {
            $sql .= " and c.name like :client_name";
            $params[':client_name'] = "%{$this->client_name}%";
        }

        if ($this->currency_id) {
            $sql .= " and t.currency_id = :currency_id";
            $params[':currency_id'] = $this->currency_id;
        }

        if ($this->payment_type_id) {
            $sql .= " and t.payment_type_id = :payment_type_id";
            $params[':payment_type_id'] = $this->payment_type_id;
        }

        if ($this->reason_id) {
            $sql .= " and t.reason_id = :reason_id";
            $params[':reason_id'] = $this->reason_id;
        }

        $sql .= " order by t.date desc";

        $params[':from'] = dateBase($this->from);
        $params[':to'] = dateBase($this->to);

        return new SqlDataProvider([
            'sql' => $sql,
            'params' => $params,
            'pagination' => [
                'pageSize' => $this->myPageSize,
            ],
        ]);
    }

}
