<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Post;

class SearchPost extends Post {

    public function rules() {
        return [
            [['id', 'cat_id'], 'integer'],
            [['title', 'content'], 'safe'],
        ];
    }

    public function scenarios() {
        return Model::scenarios();
    }

    // функция поиска
    public function search($params) {

        // Создаем экземпляр для запроса
        $query = Post::find();

        // Создаем объект ActiveDataProvider
        // И добавляем в него сформированный запрос
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // Загружаем параметры в модель
        $this->load($params);

        // Проверяем их
        if (!$this->validate()) {
            // Если не хотим выводить ошибки, то можно расскоментировать следующую строку
            // $query->where('0=1');
            return $dataProvider;
        }

        // Добавляем условие поиска на совпадение id
        $query->andFilterWhere([
            'id' => $this->id,
            'cat_id' => $this->cat_id,
        ]);

        // Добавляем условие поиска на содержание искомого слова в соответствующих полях
        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'content', $this->content]);

        // Возвращаем данные 
        return $dataProvider;
    }
}
