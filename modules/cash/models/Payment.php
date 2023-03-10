<?php

namespace app\modules\cash\models;

use app\models\Client;
use app\models\Currency;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "payment".
 *
 * @property int $id
 * @property string $date
 * @property float $summa
 * @property float|null $summa_usd
 * @property int $currency_id
 * @property int $client_id
 * @property int $payment_type_id
 * @property int $reason_id
 * @property string|null $comment
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Client $client
 * @property Currency $currency
 * @property PaymentReason $reason
 */
class Payment extends ActiveRecord
{
    public const PAYMENT_TYPES = [
        1 => 'Наличные',
        2 => 'Безналичный расчет',
        3 => 'Кредит',
    ];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payment';
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
            [['date', 'summa', 'currency_id', 'client_id', 'payment_type_id', 'reason_id', 'created_at', 'updated_at'], 'required'],
            [['date'], 'safe'],
            [['summa', 'summa_usd'], 'number'],
            [['currency_id', 'client_id', 'payment_type_id', 'reason_id', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['comment'], 'string', 'max' => 255],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Client::class, 'targetAttribute' => ['client_id' => 'id']],
            [['currency_id'], 'exist', 'skipOnError' => true, 'targetClass' => Currency::class, 'targetAttribute' => ['currency_id' => 'id']],
            [['reason_id'], 'exist', 'skipOnError' => true, 'targetClass' => PaymentReason::class, 'targetAttribute' => ['reason_id' => 'id']],
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
            'summa' => 'Сумма',
            'summa_usd' => 'Сумма в USD',
            'currency_id' => 'Валюта',
            'client_id' => 'Клиент',
            'payment_type_id' => 'Тип платежа',
            'reason_id' => 'Причина',
            'comment' => 'Комментарий',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Client]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Client::class, ['id' => 'client_id']);
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
     * Gets query for [[Reason]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReason()
    {
        return $this->hasOne(PaymentReason::class, ['id' => 'reason_id']);
    }
}
