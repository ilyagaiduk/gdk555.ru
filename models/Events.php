<?php


namespace app\models;


use yii\db\ActiveRecord;

class Events extends ActiveRecord
{
    public function getEvents() {
        $events = Events::find()->select(['event'])->all();
        return $events;
    }

}