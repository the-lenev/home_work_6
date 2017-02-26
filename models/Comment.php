<?php

namespace app\models;
use Yii;

class Comment extends \yii\db\ActiveRecord {

    public static function tableName() {
        return 'comment';
    }

    public function rules() {
        return [
            [['post_id', 'text'], 'required'],
            [['post_id'], 'integer'],
            [['text'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => 'ID',
            'post_id' => 'Id Articles',
            'taxt' => Yii::t('app','Comment'),
        ];
    }

    // Связь с таблицей Статьи
    public function getPost() {
        return $this->hasOne(Post::className(),['id' => 'post_id']);
    }
}
