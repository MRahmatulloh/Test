<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "currency_rates".
 *
 * @property int $id
 * @property int $code
 * @property float $rate
 * @property string $date
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Currency $currency
 */
class CurrencyRates extends MyModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'currency_rates';
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
            [['code', 'rate', 'date'], 'required'],
            [['code', 'created_at', 'updated_at'], 'integer'],
            [['rate'], 'number'],
            [['date', 'myPageSize'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Код валюты',
            'rate' => 'Значение',
            'date' => 'Дата',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getCurrency()
    {
        return $this->hasOne(Currency::className(), ['code' => 'code']);
    }

    public static function last($date, $currency_code)
    {
        $date = Yii::$app->formatter->asDate($date, 'php:Y-m-d');
        if ($currency_code == 860)
            return 1;

        return self::find()
            ->where(['<=', 'date', $date])
            ->andWhere(['code' => $currency_code])
            ->orderBy(['date' => SORT_DESC])
            ->indexBy('id')
            ->one();
    }

    public static function getSummaUsd($date, $currency_id, $amount)
    {
        $currency = Currency::findOne($currency_id);
        $date = Yii::$app->formatter->asDate($date, 'php:Y-m-d');
        $usd_rate = self::last($date, 840);

        if ($currency->code == 860)
            return $amount / $usd_rate->rate;
        else {
            $given_curr_rate = self::find()
                ->where(['<=', 'date', $date])
                ->andWhere(['code' => $currency->code])
                ->orderBy(['date' => SORT_DESC])
                ->one();

            return ($amount * ($given_curr_rate->rate ?? 1)) / ($usd_rate->rate ?? 1);
        }
    }

    public static function getChartData(){
        return self::find()
            ->select(['date', 'rate'])
            ->where(['code' => 840])
            ->andWhere(['>=', 'date', date('Y-m-01')])
            ->andWhere(['<=', 'date', date('Y-m-d')])
            ->orderBy(['date' => SORT_ASC])
            ->asArray()
            ->all();
    }
}
