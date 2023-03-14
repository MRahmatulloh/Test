<?php

namespace app\models;

use app\components\NumberGenerationTrait;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "prixod".
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
 * @property PrixodGoods[] $prixodGoods
 * @property Warehouse $warehouse
 */
class Prixod extends MyModel
{
    use NumberGenerationTrait;
    const TYPES = [
        1 => 'Внутренний рынок',
        2 => 'Импорт',
        3 => 'Возврат',
        4 => 'Перемещение'
    ];
    const TYPES_CREATE = [
        1 => 'Внутренний рынок',
        2 => 'Импорт'
    ];

    public const TYPE_INTERNAL = 1;
    public const TYPE_IMPORT = 2;
    public const TYPE_RETURN = 3;
    public const TYPE_MOVEMENT = 4;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'prixod';
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
            [['date', 'myPageSize'], 'safe'],
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
     * Gets query for [[PrixodGoods]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPrixodGoods()
    {
        return $this->hasMany(PrixodGoods::class, ['prixod_id' => 'id']);
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

    public static function selectListNonEmpty(int $warehouse_id)
    {
        return ArrayHelper::map(self::findBySql('
            SELECT
                p.id,
                p.number
            FROM prixod_goods pg
            LEFT JOIN prixod p ON p.id = pg.prixod_id
            LEFT JOIN
            (
                SELECT 
                    prixod_goods_id AS id,
                    SUM(amount) AS amount
                FROM rasxod_goods
                GROUP BY 
                    rasxod_goods.prixod_goods_id
            ) used ON used.id = pg.id
            
            WHERE (pg.amount - IFNULL(used.amount, 0)) > 0 
                    and p.warehouse_id = :warehouse_id
        ')->params([':warehouse_id' => $warehouse_id])->asArray()->all(), 'id', 'number');
    }
}
