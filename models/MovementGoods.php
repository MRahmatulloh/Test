<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "movement_goods".
 *
 * @property int $id
 * @property int $movement_id
 * @property int $goods_id
 * @property int $currency_id
 * @property int $rasxod_goods_id
 * @property float $amount
 * @property float|null $cost
 * @property float|null $cost_usd
 * @property int|null $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Currency $currency
 * @property Goods $goods
 * @property Movement $movement
 * @property RasxodGoods $rasxodGoods
 */
class MovementGoods extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'movement_goods';
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
            [['movement_id', 'goods_id', 'currency_id', 'rasxod_goods_id', 'amount'], 'required'],
            [['movement_id', 'goods_id', 'currency_id', 'rasxod_goods_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['amount', 'cost', 'cost_usd'], 'number'],
            [['currency_id'], 'exist', 'skipOnError' => true, 'targetClass' => Currency::class, 'targetAttribute' => ['currency_id' => 'id']],
            [['goods_id'], 'exist', 'skipOnError' => true, 'targetClass' => Goods::class, 'targetAttribute' => ['goods_id' => 'id']],
            [['movement_id'], 'exist', 'skipOnError' => true, 'targetClass' => Movement::class, 'targetAttribute' => ['movement_id' => 'id']],
            [['rasxod_goods_id'], 'exist', 'skipOnError' => true, 'targetClass' => RasxodGoods::class, 'targetAttribute' => ['rasxod_goods_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'movement_id' => 'Movement ID',
            'rasxod_goods_id' => 'Товар',
            'currency_id' => 'Валюта',
            'goods_id' => 'Товар',
            'amount' => 'Количество',
            'cost' => 'Цена',
            'cost_usd' => 'Цена (Usd)',
            'status' => 'Status',
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
     * Gets query for [[Movement]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMovement()
    {
        return $this->hasOne(Movement::class, ['id' => 'movement_id']);
    }

    /**
     * Gets query for [[RasxodGoods]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRasxodGoods()
    {
        return $this->hasOne(RasxodGoods::class, ['id' => 'rasxod_goods_id']);
    }
}
