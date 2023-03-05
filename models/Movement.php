<?php

namespace app\models;

use app\components\NumberGenerationTrait;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "movement".
 *
 * @property int $id
 * @property string $date
 * @property string $number
 * @property int $sender_id
 * @property int $recipient_id
 * @property int|null $prixod_id
 * @property int|null $rasxod_id
 * @property int|null $status
 * @property string|null $comment
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int $created_at
 * @property int $updated_at
 *
 * @property MovementGoods[] $movementGoods
 * @property Prixod $prixod
 * @property Rasxod $rasxod
 * @property Client $recipient
 * @property Client $sender
 */
class Movement extends ActiveRecord
{
    use NumberGenerationTrait;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'movement';
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
            [['date', 'number', 'sender_id', 'recipient_id'], 'required'],
            [['date'], 'safe'],
            [['sender_id', 'recipient_id', 'prixod_id', 'rasxod_id', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['number', 'comment'], 'string', 'max' => 255],
            [['prixod_id'], 'exist', 'skipOnError' => true, 'targetClass' => Prixod::class, 'targetAttribute' => ['prixod_id' => 'id']],
            [['rasxod_id'], 'exist', 'skipOnError' => true, 'targetClass' => Rasxod::class, 'targetAttribute' => ['rasxod_id' => 'id']],
            [['recipient_id'], 'exist', 'skipOnError' => true, 'targetClass' => Client::class, 'targetAttribute' => ['recipient_id' => 'id']],
            [['sender_id'], 'exist', 'skipOnError' => true, 'targetClass' => Client::class, 'targetAttribute' => ['sender_id' => 'id']],
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
            'number' => 'Number',
            'sender_id' => 'Sender ID',
            'recipient_id' => 'Recipient ID',
            'prixod_id' => 'Prixod ID',
            'rasxod_id' => 'Rasxod ID',
            'status' => 'Status',
            'comment' => 'Comment',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[MovementGoods]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMovementGoods()
    {
        return $this->hasMany(MovementGoods::class, ['movement_id' => 'id']);
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
     * Gets query for [[Rasxod]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRasxod()
    {
        return $this->hasOne(Rasxod::class, ['id' => 'rasxod_id']);
    }

    /**
     * Gets query for [[Recipient]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRecipient()
    {
        return $this->hasOne(Client::class, ['id' => 'recipient_id']);
    }

    /**
     * Gets query for [[Sender]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSender()
    {
        return $this->hasOne(Client::class, ['id' => 'sender_id']);
    }
}
