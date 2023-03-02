<?php

namespace app\models\search;

use yii\base\Model;

/**
 * This is the model class for filtering any purposes.
 *
 * @property string $from
 * @property string $to
 * @property int $category_id
 * @property int $goods_id
 * @property int $warehouse_id
 * @property int $client_id
 * @property int $currency_id
 */

class Filter extends Model
{
    public $from;
    public $to;
    public $goods_id;
    public $warehouse_id;
    public $client_id;
    public $currency_id;

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'prixod_id' => 'Приход',
            'currency_id' => 'Валюта',
            'goods_id' => 'Товар',
            'amount' => 'Количество',
            'cost' => 'Цена',
            'cost_usd' => 'Цена (Usd)',
            'summa' => 'Сумма',
            'from' => 'Дата с',
            'to' => 'По',
        ];
    }
}