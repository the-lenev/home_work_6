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

    // Добавляем связь с таблицей Тегов
    public function getTagPost() {
        return $this->hasMany(TagPost::className(),['post_id' => 'id']);
    }

    // Список тэгов, закреплённых за постом.
    protected $tags = [];

    // Устанавливаем тэги поста
    public function setTags($tagsId) {
        $this->tags = (array) $tagsId;
    }

    // Получаем массив id тегов
    public function getTags() {
        return ArrayHelper::getColumn(
            $this->getTagPost()->all(), 'tag_id'
        );
    }

    // После сохранения данных (событие) в модели поста обновляем данные в связующей таблице
    public function afterSave($insert, $changedAttributes) {
        // Удаляем все записи тегов у обновленного поста
        TagPost::deleteAll(['post_id' => $this->id]);
        // Промежуточный массив тегов
        $values = [];
        // Для всех записей из массива тегов
        foreach ($this->tags as $id) {
            // Добавляем в массив id поста (ключ) и id тега (значение)
            $values[] = [$this->id, $id];
        }
        // Добавляем запись в БД
        self::getDb()
            // Создаем запрос
            ->createCommand()
            // В связующую таблицу TagPost, в соответствующие столбцы, добавляем значения массива
            ->batchInsert(TagPost::tableName(), ['post_id', 'tag_id'], $values)
            // Выход
            ->execute();
        // Устанавливаем событие у родительсого класса
        parent::afterSave($insert, $changedAttributes);
    }
}
