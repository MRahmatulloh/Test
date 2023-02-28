<?php

namespace app\models;

use app\components\NumberGenerationTrait;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "rasxod".
 *
 * @property int $id
 * @property string $date
 * @property string $number
 * @property int $client_id
 * @property int $warehouse_id
 * @property string|null $comment
 * @property int $type
 * @property int|null $status
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Client $client
 * @property RasxodGoods[] $rasxodGoods
 * @property Warehouse $warehouse
 */
class Rasxod extends MyModel
{
    use NumberGenerationTrait;
    const TYPES = [
        1 => '100% тўлов',
        2 => 'Предоплата',
        3 => 'Рассрочка',
    ];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rasxod';
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
            [['date', 'number', 'client_id', 'warehouse_id', 'type'], 'required'],
            [['date'], 'safe'],
            [['client_id', 'warehouse_id', 'type', 'status', 'created_by', 'updated_by'], 'integer'],
            [['number', 'comment'], 'string', 'max' => 255],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Client::class, 'targetAttribute' => ['client_id' => 'id']],
            [['warehouse_id'], 'exist', 'skipOnError' => true, 'targetClass' => Warehouse::class, 'targetAttribute' => ['warehouse_id' => 'id']],
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
            'number' => 'Номер',
            'client_id' => 'Клиент',
            'warehouse_id' => 'Склад',
            'comment' => 'Комментария',
            'type' => 'Тип',
            'status' => 'Статус',
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
     * Gets query for [[RasxodGoods]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRasxodGoods()
    {
        return $this->hasMany(RasxodGoods::class, ['rasxod_id' => 'id']);
    }

    /**
     * Gets query for [[Warehouse]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWarehouse()
    {
        return $this->hasOne(Warehouse::class, ['id' => 'warehouse_id']);
    }
}
