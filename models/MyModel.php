<?php

namespace app\models;

use Yii;
use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;

class MyModel extends ActiveRecord
{
    public $myPageSize;
    /**
     * @throws InvalidConfigException
     */
    public function beforeSave($insert): bool
    {
        if (parent::beforeSave($insert)) {
            if (isset($this->date)) {
                $this->date = Yii::$app->formatter->asDate($this->date, 'php:Y-m-d');
            }
            if (isset($this->date1)) {
                $this->date1 = Yii::$app->formatter->asDate($this->date1, 'php:Y-m-d');
            }
            if (isset($this->date2)) {
                $this->date2 = Yii::$app->formatter->asDate($this->date2, 'php:Y-m-d');
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * @throws InvalidConfigException
     */
    public function afterFind()
    {
        parent::afterFind();
        if (isset($this->date)) {
            $this->date = Yii::$app->formatter->asDate($this->date, 'php:d.m.Y');
        }
        if (isset($this->date1)) {
            $this->date1 = Yii::$app->formatter->asDate($this->date1, 'php:Y-m-d');
        }
        if (isset($this->date2)) {
            $this->date2 = Yii::$app->formatter->asDate($this->date2, 'php:Y-m-d');
        }
    }
}