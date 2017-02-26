<?php

namespace app\models;
use Yii;
use Yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

class Post extends \yii\db\ActiveRecord {

    public static function tableName() {
        return 'post';
    }

    public function rules() {
        return [
            [['title', 'cat_id', 'content'], 'required'],
            [['content'], 'string'],
            [['title'], 'string', 'max' => 50],
            [['cat_id'], 'integer'],
            [['publish_date', 'tags'], 'safe'],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => 'ID',
            'title' => Yii::t('app','Title'),
            'cat_id' => Yii::t('app','Category'),
            'content' => Yii::t('app','Content'),
        ];
    }

    // Добавляем связь с таблицей Категорий
    public function getCategory() {
        return $this->hasOne(Category::className(),['id' => 'cat_id']);
    }

    // Добавляем связь с таблицей Комментариев
    public function getComment() {
        return $this->hasMany(Comment::className(),['post_id' => 'id']);
    }
}
