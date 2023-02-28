<?php


namespace app\components;

use yii\helpers\ArrayHelper;

trait ItemsTrait
{
    /**
     * @return array
     */
    public static function selectList($condition = [])
    {
        return ArrayHelper::map(
            self::find()
                ->andWhere($condition)
                ->indexBy('id')
                ->orderBy(['name' => SORT_ASC])
                ->asArray()
                ->all()
            , 'id', 'name');
    }

    public static function selectListByCode($condition = [])
    {
        return ArrayHelper::map(
            self::find()
                ->andWhere($condition)
                ->indexBy('id')
                ->orderBy(['name' => SORT_ASC])
                ->asArray()
                ->all()
            , 'code', 'name');
    }
}
