<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "pricelist".
 *
 * @property int $id
 * @property string $date
 * @property int $goods_id
 * @property float $price_credit
 * @property float $price_full
 * @property float $price_transfer
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 *
 * @property Goods $goods
 */
class Pricelist extends MyModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pricelist';
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
            [['date', 'goods_id', 'price_credit', 'price_full'], 'required'],
            [['date'], 'safe'],
            [['goods_id', 'created_by', 'updated_by'], 'integer'],
            [['price_credit', 'price_full', 'price_transfer'], 'number'],
            [['goods_id'], 'exist', 'skipOnError' => true, 'targetClass' => Goods::class, 'targetAttribute' => ['goods_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Дата',
            'goods_id' => 'Товар',
            'price_credit' => 'Цена в рассрочку',
            'price_full' => 'Цена в наличку',
            'price_transfer' => 'Цена в перечисления',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
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
}
