<?php

namespace app\models;

use app\components\ItemsTrait;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "goods".
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property int|null $category_id
 * @property string $img
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Category $category
 * @property PrixodGoods[] $prixodGoods
 * @property RasxodGoods[] $rasxodGoods
 */
class Goods extends MyModel
{
    public $file;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'goods';
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
            [['name', 'code', 'category_id'], 'required'],
            [['category_id', 'status'], 'integer'],
            [['name', 'code', 'img'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['code'], 'unique'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            [['file'], 'file', 'extensions' => 'png, jpg, jpeg, bmp', 'maxFiles' => 1, 'maxSize' => 8 * 1024 * 1024]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'code' => 'Артикул',
            'category_id' => 'Категория',
            'img' => 'Фото',
            'status' => 'Статус',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[PrixodGoods]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPrixodGoods()
    {
        return $this->hasMany(PrixodGoods::class, ['goods_id' => 'id']);
    }

    /**
     * Gets query for [[RasxodGoods]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRasxodGoods()
    {
        return $this->hasMany(RasxodGoods::class, ['goods_id' => 'id']);
    }

    public static function selectList($condition = [])
    {
        return ArrayHelper::map(self::find()->andWhere($condition)->orderBy(['name' => SORT_ASC])->indexBy('id')->asArray()->all(), 'id',
            function ($model) {
                return $model['code'] . ' - ' . $model['name'];
            });
    }
}
