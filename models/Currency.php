<?php

namespace app\models;

use app\components\ItemsTrait;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "currency".
 *
 * @property int $id
 * @property string $name
 * @property string|null $code
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property CurrencyRates[] $currencyRates
 * @property PrixodGoods[] $prixodGoods
 * @property RasxodGoods[] $rasxodGoods
 */
class Currency extends MyModel
{
    use ItemsTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'currency';
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
            [['name'], 'required'],
            [['status'], 'integer'],
            [['name', 'code'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'code' => 'Код валюты',
            'status' => 'Статус',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[CurrencyRates]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCurrencyRates()
    {
        return $this->hasMany(CurrencyRates::class, ['code' => 'code']);
    }

    /**
     * Gets query for [[PrixodGoods]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPrixodGoods()
    {
        return $this->hasMany(PrixodGoods::class, ['currency_id' => 'id']);
    }

    /**
     * Gets query for [[RasxodGoods]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRasxodGoods()
    {
        return $this->hasMany(RasxodGoods::class, ['currency_id' => 'id']);
    }
}
