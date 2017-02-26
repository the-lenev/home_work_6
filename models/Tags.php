<?php

namespace app\models;
use Yii;

class Tags extends \yii\db\ActiveRecord {

    public static function tableName() {
        return 'tags';
    }

    public function rules() {
        return [
            [['title'], 'required'],
            [['title'], 'integer'],
        ];
    }

    public function attributeLabels(){
        return [
            'id' => 'ID',
            'title' => 'Title',
        ];
    }

    public function getTagPosts() {
        return $this->hasMany(TagPost::className(), ['tag_id' => 'id']);
    }

    public function getTag($id) {
        if (($model = Tags::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested post does not exist.');
        }
    }
}
