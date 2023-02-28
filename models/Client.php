<?php

namespace app\models;

use app\components\ItemsTrait;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "client".
 *
 * @property int $id
 * @property string $name
 * @property string|null $address
 * @property string|null $tel
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Prixod[] $prixods
 * @property Rasxod[] $rasxods
 */
class Client extends MyModel
{
    use ItemsTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'client';
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
            [['name', 'address', 'tel'], 'string', 'max' => 255],
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
            'tel' => 'Телефон',
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
        return $this->hasMany(Prixod::class, ['client_id' => 'id']);
    }

    /**
     * Gets query for [[Rasxods]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRasxods()
    {
        return $this->hasMany(Rasxod::class, ['client_id' => 'id']);
    }
}
