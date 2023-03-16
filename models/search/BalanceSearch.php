<?php

namespace app\models\search;

use app\models\MyModel;

/**
 * CurrencySearch represents the model behind the search form of `app\models\Currency`.
 */
class BalanceSearch extends MyModel
{
    public $goods_id;
    public $goods_code;
    public $goods_name;
    public $in_amount;
    public $out_amount;
    public $warehouse_id;
    public $warehouse_name;
    public $ostatok;
    public $myPageSize;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['goods_id', 'warehouse_id'], 'integer'],
            [['in_amount', 'out_amount', 'ostatok'], 'number'],
            [['goods_name', 'warehouse_name', 'goods_code', 'myPageSize'], 'safe'],
        ];
    }

}
