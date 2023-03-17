<?php

namespace app\modules\cash\models;

use app\components\ItemsTrait;
use app\models\MyModel;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "payment_reason".
 *
 * @property int $id
 * @property string|null $name
 * @property int $type_id
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Expense[] $expenses
 * @property Payment[] $payments
 */
class PaymentReason extends MyModel
{
    use ItemsTrait;

    public const TYPES = [
        1 => 'Приход',
        2 => 'Расход',
    ];

    public const TYPE_INCOME = 1;
    public const TYPE_EXPENSE = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payment_reason';
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
            [['type_id'], 'required'],
            [['type_id', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
//            [['name'], 'unique'],
            [['type_id'], 'in', 'range' => array_keys(self::TYPES)],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
            'type_id' => 'Тип',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Expenses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExpenses()
    {
        return $this->hasMany(Expense::class, ['reason_id' => 'id']);
    }

    /**
     * Gets query for [[Payments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPayments()
    {
        return $this->hasMany(Payment::class, ['reason_id' => 'id']);
    }
}
