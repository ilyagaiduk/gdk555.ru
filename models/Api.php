<?php


namespace app\models;
use Yii;
use yii\db\ActiveRecord;

class Api extends ActiveRecord
{
    public function getApi($event, $name, $email, $operation, $id, $token) {
        //Проверка токена
        if($token) {
            $token = Token::find()->select(['token'])->where(['token' => $token])->one();
            //Если токен не найден в базе данных, возвращаем False
            if(!$token) {
                $message = False;
                return $message;
            }
            //Если токен найден в базе данных
            else{
                //Выполнение операции Добавить пользователя
                if($operation === "add") {
                    if ($email) {
                        $getEmail = Members::find()->select(['email'])->where(['email' => $email])->one();
                        if($getEmail->email) {
                            $message = "Пользователь с таким email существует";
                            return $message;
                        }
                        else {
                            $sql = "INSERT INTO members (`fullname`, `id_event`, `email`) VALUES ('$name', '$event', '$email')";
                            Yii::$app->db->createCommand($sql)->execute();
                            //Отправляем уведомление на почту
                            Yii::$app->mailer->compose()
                                ->setFrom('from@domain.com')
                                ->setTo('to@domain.com')
                                ->setSubject('Тема сообщения')
                                ->setTextBody('Текст сообщения')
                                ->setHtmlBody('<b>текст сообщения в формате HTML</b>')
                                ->send();
                            $massAddUser = [];
                            $massAddUser[] = "Участник $name добавлен";
                            return $massAddUser;
                        }
                    }
                }
                //Выполнение операции Обновить данные
                    elseif($operation === "update"){

                        $massUpdateUser = ["fullname" => $name, "id_event" =>$event, "email" =>$email];
                        $massKey = [];
                        $massValue = [];
                        foreach($massUpdateUser as $key=>$value){
                        if($value) {
                            $massKey[] = $key;
                            $massValue[] = "\"{$value}\"";
                        }
                        else{
                            //Если значение не заполнено, удаляем его из массива
                            unset($massUpdateUser[$key]);
                        }
                        }
                        $count = count($massKey);
                        //Формируем запросы на обновление данных
                        for($x = 0; $x<= $count; $x++){
                            $keyMass =$massKey[$x];
                            $valueMass = $massValue[$x];
                            $sql = "UPDATE members SET ".$keyMass." = ".$valueMass." WHERE id = ".$id;
                            Yii::$app->db->createCommand($sql)->execute();


                        }
                        return $massKey;




                    }
                //Выполнение операции Удалить пользователя
                elseif($operation === "delete") {
                    $sql = "DELETE FROM members WHERE id = $id";
                    Yii::$app->db->createCommand($sql)->execute();
                    return "Участник с id $id удален";
                }
                //Фильтрация пользователей по мероприятию
                elseif($operation === "filtr") {
                    $filtrMember = Members::find()->select(['fullname'])->where(['id_event' => $event])->orderBy('fullname')->all();
                    $event = Events::find()->select(['event'])->where(['id' => $event])->one();
                    $massEvent = [];
                    foreach($filtrMember as $key) {
                        $massEvent[] = $key->fullname;
                    }
                    $members = implode(", ", $massEvent);
                    return "Участники события {$event->event}: {$members}";
                }
                    else{
                        $message = False;
                        return $message;
                    }

                }
            }
//Если токен неверный - возвращаем сообщение об ошибке
        else {
            $message = False;
            return $message;
        }

    }


}