<?php

namespace app\models;
use Yii;

class TagPost extends \yii\db\ActiveRecord {

    public static function tableName() {
        return 'tag_post';
    }

    public function rules() {
        return [
            [['tag_id', 'post_id'], 'required'],
            [['tag_id', 'post_id'], 'integer'],
        ];
    }

    public function attributeLabels() {
        return [
            'post_id' => 'Post ID',
            'tag_id' => 'Tag ID',
        ];
    }

    public function getPost() {
        return $this->hasOne(Post::className(), ['id' => 'post_id']);
    }

    public function getTag() {
        return $this->hasOne(Tags::className(), ['id' => 'tag_id']);
    }
}
