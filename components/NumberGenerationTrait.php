<?php


namespace app\components;

trait NumberGenerationTrait
{
    /**
     * @return string
     */
    public function getNumber($case = 'create', $prefix = 'P')
    {

        $last_number = (self::find()->where(['date' => dateBase($this->date)])->orderBy(['id' => SORT_DESC])->one())->number ?? null;
        prd(self::find()->where(['date' => dateBase($this->date)])->orderBy(['id' => SORT_DESC])->one());
        $count = (int)substr($last_number, 1, 2);
        $count++;

        if ($case == 'update') {
            if (dateView($this->oldAttributes['date']) == dateView($this->date)) {
                return $this->number;
            }
        }

        return $prefix . str_pad($count, 2, '0', STR_PAD_LEFT) . '/' . date('dm', strtotime(dateBase($this->date)));
    }
}
