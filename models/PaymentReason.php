<?php

namespace app\models;

use Yii;

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
 */
class PaymentReason extends MyModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payment_reason';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type_id', 'created_at', 'updated_at'], 'required'],
            [['type_id', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'type_id' => 'Type ID',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
