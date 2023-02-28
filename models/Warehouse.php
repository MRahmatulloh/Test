<?php

namespace app\models;

use app\components\ItemsTrait;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "warehouse".
 *
 * @property int $id
 * @property string $name
 * @property string|null $address
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Prixod[] $prixods
 * @property Rasxod[] $rasxods
 */
class Warehouse extends MyModel
{
    use ItemsTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'warehouse';
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
            [['name'], 'required'],
            [['status'], 'integer'],
            [['name', 'address'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'address' => 'Адрес',
            'status' => 'Статус',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Prixods]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPrixods()
    {
        return $this->hasMany(Prixod::class, ['warehouse_id' => 'id']);
    }

    /**
     * Gets query for [[Rasxods]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRasxods()
    {
        return $this->hasMany(Rasxod::class, ['warehouse_id' => 'id']);
    }
}
