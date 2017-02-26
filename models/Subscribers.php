<?php

namespace app\models;
use Yii;

class Subscribers extends \yii\db\ActiveRecord {

    public static function tableName() {
        return 'subscribers';
    }

    public function rules() {
        return [
            [['name', 'email'], 'required'],
            [['name'], 'string', 'max' => 50],
            [['email'], 'email'],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
        ];
    }
}
