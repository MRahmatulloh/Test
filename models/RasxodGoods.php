<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "rasxod_goods".
 *
 * @property int $id
 * @property int $rasxod_id
 * @property int $goods_id
 * @property int $currency_id
 * @property int $prixod_goods_id
 * @property float $amount
 * @property float|null $cost
 * @property float|null $cost_usd
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Currency $currency
 * @property Goods $goods
 * @property PrixodGoods $prixodGoods
 * @property Rasxod $rasxod
 */
class RasxodGoods extends MyModel
{
    public $prixod_id;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rasxod_goods';
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
            [['rasxod_id', 'goods_id', 'currency_id', 'prixod_goods_id', 'amount'], 'required'],
            [['rasxod_id', 'goods_id', 'currency_id', 'prixod_goods_id', 'prixod_id'], 'integer'],
            [['amount', 'cost', 'cost_usd', 'summa'], 'number'],
            [['currency_id'], 'exist', 'skipOnError' => true, 'targetClass' => Currency::class, 'targetAttribute' => ['currency_id' => 'id']],
            [['goods_id'], 'exist', 'skipOnError' => true, 'targetClass' => Goods::class, 'targetAttribute' => ['goods_id' => 'id']],
            [['prixod_goods_id'], 'exist', 'skipOnError' => true, 'targetClass' => PrixodGoods::class, 'targetAttribute' => ['prixod_goods_id' => 'id']],
            [['rasxod_id'], 'exist', 'skipOnError' => true, 'targetClass' => Rasxod::class, 'targetAttribute' => ['rasxod_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'rasxod_id' => 'Расход',
            'goods_id' => 'Товар',
            'amount' => 'Количество',
            'cost' => 'Цена',
            'cost_usd' => 'Цена (Usd)',
            'currency_id' => 'Валюта',
            'summa' => 'Сумма',
            'prixod_goods_id' => 'Товар',
            'prixod_id' => 'Партия',
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
     * Gets query for [[PrixodGoods]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPrixodGoods()
    {
        return $this->hasOne(PrixodGoods::class, ['id' => 'prixod_goods_id']);
    }

    /**
     * Gets query for [[Rasxod]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRasxod()
    {
        return $this->hasOne(Rasxod::class, ['id' => 'rasxod_id']);
    }

    public static function getPrixodedAmount($prixod_goods_id)
    {
        return self::find()
            ->where(['prixod_goods_id' => $prixod_goods_id])
            ->sum('amount');
    }
}
