<?php


namespace app\models;


use yii\db\ActiveRecord;

class Token extends ActiveRecord
{
    public function getTokens() {
        $token = Token::find()->select(['token'])->all();
        return $token;
    }

}