<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "prixod_goods".
 *
 * @property int $id
 * @property int $prixod_id
 * @property int $goods_id
 * @property int $currency_id
 * @property float $amount
 * @property float|null $cost
 * @property float|null $cost_usd
 * @property int|null $rasxod_goods_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Currency $currency
 * @property Goods $goods
 * @property Prixod $prixod
 * @property RasxodGoods $rasxodGoods
 * @property RasxodGoods $rasxodedGoods
 */
class PrixodGoods extends MyModel
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_RETURN = 'return';

    public $rasxod_id;
    public $summa;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'prixod_goods';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['prixod_id', 'goods_id', 'currency_id', 'cost', 'amount'], 'required'],
            [['prixod_id', 'goods_id', 'currency_id', 'rasxod_id', 'rasxod_goods_id'], 'integer'],
            [['amount', 'cost', 'cost_usd', 'summa'], 'number'],
            [['rasxod_id', 'rasxod_goods_id'], 'required', 'on' => self::SCENARIO_RETURN],
            [['currency_id'], 'exist', 'skipOnError' => true, 'targetClass' => Currency::class, 'targetAttribute' => ['currency_id' => 'id']],
            [['goods_id'], 'exist', 'skipOnError' => true, 'targetClass' => Goods::class, 'targetAttribute' => ['goods_id' => 'id']],
            [['prixod_id'], 'exist', 'skipOnError' => true, 'targetClass' => Prixod::class, 'targetAttribute' => ['prixod_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'prixod_id' => 'Приход',
            'rasxod_id' => 'Расход',
            'rasxod_goods_id' => 'Товар',
            'currency_id' => 'Валюта',
            'goods_id' => 'Товар',
            'amount' => 'Количество',
            'cost' => 'Цена',
            'cost_usd' => 'Цена (Usd)',
            'summa' => 'Сумма',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Currency]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCurrency()
    {
        return $this->hasOne(Currency::class, ['id' => 'currency_id']);
    }

    /**
     * Gets query for [[Goods]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGoods()
    {
        return $this->hasOne(Goods::class, ['id' => 'goods_id']);
    }

    /**
     * Gets query for [[Prixod]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPrixod()
    {
        return $this->hasOne(Prixod::class, ['id' => 'prixod_id']);
    }

    /**
     * Gets query for [[RasxodGoods]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRasxodGoods()
    {
        return $this->hasMany(RasxodGoods::class, ['prixod_goods_id' => 'id']);
    }

    public function getRasxodedGoods()
    {
        return $this->hasOne(RasxodGoods::class, ['id' => 'rasxod_goods_id']);
    }

    public static function getRasxodedAmount($rasxod_goods_id)
    {
        return self::find()
            ->where(['rasxod_goods_id' => $rasxod_goods_id])
            ->sum('amount');
    }
}
