<?php

namespace app\models;

use app\components\NumberGenerationTrait;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "rasxod".
 *
 * @property int $id
 * @property string $date
 * @property string|null $payment_date
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

    const TYPES_ALL = [
        1 => '100% тўлов',
        2 => 'Предоплата',
        3 => 'Рассрочка',
        4 => 'Перемещение',
    ];

    public const TYPE_FULL_PAYMENT = 1;
    public const TYPE_PREPAYMENT = 2;
    public const TYPE_CREDIT = 3;
    public const TYPE_MOVEMENT = 4;

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
            [['date', 'payment_date'], 'safe'],
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
            'payment_date' => 'Дата оплаты',
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

    public static function selectListNonEmpty(int $warehouse_id = null, int $client_id)
    {
        $params = [];
        $sql = '
            SELECT
                r.id,
                r.number
            FROM rasxod_goods rg
            LEFT JOIN rasxod r ON r.id = rg.rasxod_id
            LEFT JOIN
            (
                SELECT 
                    rasxod_goods_id AS id,
                    SUM(amount) AS amount
                FROM prixod_goods
                GROUP BY 
                    prixod_goods.rasxod_goods_id
            ) used ON used.id = rg.id
            
            WHERE (rg.amount - IFNULL(used.amount, 0)) > 0 and r.type <> 4 ';

        if ($warehouse_id){
            $sql .= ' and r.warehouse_id = :warehouse_id ';
            $params = array_merge($params, [':warehouse_id' => $warehouse_id]);
        }

        $sql .= '
                    and r.client_id = :client_id         
        ';

        if ($client_id){
            $params = array_merge($params, [':client_id' => $client_id]);

        }

        return ArrayHelper::map(self::findBySql($sql)->params($params)
            ->asArray()->all(), 'id', 'number');
    }
}
