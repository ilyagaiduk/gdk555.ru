<?php


namespace app\models;


use yii\db\ActiveRecord;

class Members extends ActiveRecord
{
    public function getMembers() {
        $members = Members::find()->select(['name'])->all();
        return $members;
    }
}