<?php

namespace app\models;

use Yii;

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
 * @property int $type_id
 * @property string|null $comment
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Client $client
 * @property Currency $currency
 */
class Payment extends MyModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'summa', 'currency_id', 'client_id', 'payment_type_id', 'type_id', 'created_at', 'updated_at'], 'required'],
            [['date'], 'safe'],
            [['summa', 'summa_usd'], 'number'],
            [['currency_id', 'client_id', 'payment_type_id', 'type_id', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['comment'], 'string', 'max' => 255],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Client::class, 'targetAttribute' => ['client_id' => 'id']],
            [['currency_id'], 'exist', 'skipOnError' => true, 'targetClass' => Currency::class, 'targetAttribute' => ['currency_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
            'summa' => 'Summa',
            'summa_usd' => 'Summa Usd',
            'currency_id' => 'Currency ID',
            'client_id' => 'Client ID',
            'payment_type_id' => 'Payment Type ID',
            'type_id' => 'Type ID',
            'comment' => 'Comment',
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
}
