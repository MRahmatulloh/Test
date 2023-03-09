<?php

namespace app\models;

use app\components\NumberGenerationTrait;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Exception;

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
 * @property int $warehouse_id
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
 * @property Warehouse $warehouse
 */
class Movement extends MyModel
{
    use NumberGenerationTrait;

    public const STATUS_ALL = [
        self::STATUS_NEW => 'Новый',
        self::STATUS_ACCEPTED => 'Принят',
        self::STATUS_REJECTED => 'Отклонен',
    ];

    const STATUS_NEW = 1;
    const STATUS_ACCEPTED = 2;
    const STATUS_REJECTED = 3;

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
            [['date', 'number', 'sender_id', 'recipient_id', 'warehouse_id'], 'required'],
            [['date'], 'safe'],
            [['sender_id', 'recipient_id', 'prixod_id', 'rasxod_id', 'status', 'created_by',
                'updated_by', 'created_at', 'updated_at', 'warehouse_id'], 'integer'],
            [['number', 'comment'], 'string', 'max' => 255],
            ['recipient_id', 'checkSameClient'],
            [['prixod_id'], 'exist', 'skipOnError' => true, 'targetClass' => Prixod::class, 'targetAttribute' => ['prixod_id' => 'id']],
            [['rasxod_id'], 'exist', 'skipOnError' => true, 'targetClass' => Rasxod::class, 'targetAttribute' => ['rasxod_id' => 'id']],
            [['recipient_id'], 'exist', 'skipOnError' => true, 'targetClass' => Client::class, 'targetAttribute' => ['recipient_id' => 'id']],
            [['sender_id'], 'exist', 'skipOnError' => true, 'targetClass' => Client::class, 'targetAttribute' => ['sender_id' => 'id']],
            [['warehouse_id'], 'exist', 'skipOnError' => true, 'targetClass' => Warehouse::class, 'targetAttribute' => ['warehouse_id' => 'id']],
        ];
    }

    public function checkSameClient()
    {
        if ($this->sender_id == $this->recipient_id) {
            $this->addError('recipient_id', Yii::t('app', 'Невозможно выполнить эту операцию между одним и тем же клиентом'));

            return false;
        }
        return true;
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
            'sender_id' => 'Отправитель',
            'recipient_id' => 'Получатель',
            'prixod_id' => 'Приход',
            'rasxod_id' => 'Расход',
            'status' => 'Статус',
            'comment' => 'Комментарий',
            'warehouse_id' => 'Склад',
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

    /**
     * Gets query for [[Warehouse]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWarehouse()
    {
        return $this->hasOne(Warehouse::class, ['id' => 'warehouse_id']);
    }

    /**
     * @throws Exception
     */
    public function accept()
    {
        $transaction = Yii::$app->db->beginTransaction();

        try {
            $movementGoods = $this->movementGoods;
            if (empty($movementGoods)) {
                throw new \Exception('Нет товаров для перемещения');
            }

            $prixod = new Prixod();
            $prixod->date = date('Y-m-d');
            $prixod->number = $prixod->getNumber('create', 'PM');
            $prixod->client_id = $this->sender_id;
            $prixod->comment = $this->comment;
            $prixod->status = 1;
            $prixod->type = Prixod::TYPE_MOVEMENT;
            $prixod->warehouse_id = $this->warehouse_id;
            $prixod->created_by = Yii::$app->user->identity->id;
            $prixod->save();

            if (!$prixod->save()) {
                throw new \Exception('Ошибка при сохранении прихода' . implode('<br>', $prixod->errors));
            }

            $rasxod = new Rasxod();
            $rasxod->date = date('Y-m-d');
            $rasxod->number = $rasxod->getNumber('create', 'RM');
            $rasxod->client_id = $this->recipient_id;
            $rasxod->comment = $this->comment;
            $rasxod->status = 1;
            $rasxod->type = Rasxod::TYPE_MOVEMENT;
            $rasxod->warehouse_id = $this->warehouse_id;
            $rasxod->created_by = Yii::$app->user->identity->id;
            $rasxod->save();

            if (!$rasxod->save()) {
                throw new \Exception('Ошибка при сохранении расхода' . implode('<br>', $rasxod->errors));
            }


            foreach ($movementGoods as $movementGood) {
                $rasxod_goods = $movementGood->rasxodGoods;
                $used = PrixodGoods::getRasxodedAmount($movementGood->rasxod_goods_id) ?? 0;
                $free = $rasxod_goods->amount - $used;

                if (($free - $movementGood->amount) < 0) {
                    throw new \Exception('Недостаточно товара на складе: ' . $movementGood->goods->name);
                }

                $prixodGoods = new PrixodGoods();
                $prixodGoods->prixod_id = $prixod->id;
                $prixodGoods->goods_id = $movementGood->goods_id;
                $prixodGoods->amount = $movementGood->amount;
                $prixodGoods->cost = $movementGood->cost_return;
                $prixodGoods->currency_id = $rasxod_goods->currency_id;
                $prixodGoods->rasxod_goods_id = $movementGood->rasxod_goods_id;

                if (!$prixodGoods->save()) {
                    throw new \Exception('Ошибка при сохранении товара прихода:  ' . $movementGood->goods->name . implode('<br>', $prixodGoods->errors));
                }

                $rasxodGoods = new RasxodGoods();
                $rasxodGoods->rasxod_id = $rasxod->id;
                $rasxodGoods->prixod_id = $prixod->id;
                $rasxodGoods->goods_id = $movementGood->goods_id;
                $rasxodGoods->amount = $movementGood->amount;
                $rasxodGoods->cost = $movementGood->cost;
                $rasxodGoods->currency_id = $movementGood->currency_id;
                $rasxodGoods->prixod_goods_id = $prixodGoods->id;

                if (!$rasxodGoods->save()) {
                    throw new \Exception('Ошибка при сохранении товара расхода:  ' . $movementGood->goods->name . implode('<br>', $rasxodGoods->errors));
                }
            }

            $this->status = self::STATUS_ACCEPTED;
            $this->prixod_id = $prixod->id;
            $this->rasxod_id = $rasxod->id;
            $this->updated_by = Yii::$app->user->identity->id;
            $this->save();

            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    /**
     * @throws Exception
     */
    public function delete()
    {
        $transaction = Yii::$app->db->beginTransaction();

        try {
            $rasxod = $this->rasxod_id;
            $this->rasxod_id = null;
            $this->save(false);

            if ($rasxod && !RasxodGoods::deleteAll(['rasxod_id' => $rasxod])) {
                throw new \Exception('Ошибка при удалении товаров расхода');
            }

            if ($rasxod && !Rasxod::deleteAll(['id' => $rasxod])) {
                throw new \Exception('Ошибка при удалении расхода');
            }

            $prixod = $this->prixod_id;
            $this->prixod_id = null;
            $this->save(false);

            if ($prixod && !PrixodGoods::deleteAll(['prixod_id' => $prixod])) {
                throw new \Exception('Ошибка при удалении товаров прихода');
            }

            if ($prixod && !Prixod::deleteAll(['id' => $prixod])) {
                throw new \Exception('Ошибка при удалении прихода');
            }

            if (!MovementGoods::deleteAll(['movement_id' => $this->id])) {
                throw new \Exception('Ошибка при удалении товаров перемещения');
            }

            if (!parent::delete()) {
                throw new \Exception('Ошибка при удалении перемещения');
            }

            $transaction->commit();
            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }
}
