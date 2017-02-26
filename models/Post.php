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

    // Отправка сообщения на почту
    public function sendEmail() {

        if ($this->validate()) {
            // Получаем записи всех подписчиков из БД
            $subscribers = Subscribers::find()->asArray()->all();
            // Формируем текст сообщения
            $mess = Html::a($this->title, Url::to(['@web/site/view', 'id' => $this->id], true));
            // Для всех отправляем сообщение
            foreach ($subscribers as $subscriber) {
                // Cоздаем экземпляр почтового сообщения
                Yii::$app->mailer->compose()
                    // Почту "От кого" берем из параметров конфига
                    ->setFrom(Yii::$app->params['adminEmail'])
                    // Отправляем на адрес, указанный в базе подписчиков
                    ->setTo($subscriber['email'])
                    // Тему берем из названия поста
                    ->setSubject($this->title)
                    // В тело письма вставляем ссылку на новый пост
                    ->setHtmlBody($mess)
                    // Отправляем сообщение
                    ->send();
            }
            return true;
        }
        return false;
    }
}
