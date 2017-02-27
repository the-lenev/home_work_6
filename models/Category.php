<?php

namespace app\models;
use Yii;
// Подключаем класс для создания ссылок
use yii\helpers\Url;
use yii\helpers\VarDumper;

class Category extends \yii\db\ActiveRecord {

    public static function tableName() {
        return 'category';
    }

    public function rules() {
        return [
            [['parent_id', 'name'], 'required'],
            [['parent_id'], 'integer'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent',
            'name' => 'Name',
        ];
    }

    // Добавляем связь с таблицей Постов
    public function getPost() {
        return $this->hasMany(Post::className(),['cat_id' => 'id']);
    }

    // Генерируем структуру каталогов для представления
    public static function getStructure() {

        // Получаем все категории в виде массива. В качестве идентификаторов используем id категории
        $cats = Category::find()->indexBy('id')->asArray()->all();
        // Добавлем в массив необходимые в виджете элементы
        foreach ($cats as $key => &$cat) {
            $cat['label'] = $cat['name'];
            unset($cat['name']);
            $cat['url'] = Url::to(['', 'cat' => $cat['id']]);
        }
        // Создаем дерево категорий
        $tree = [];
        // Для всех категорий
        foreach ($cats as $id => &$cat) {
            // Если родительская категория равна 0 (корневая), то
            if ($cat['parent_id'] == 0) {
                // Присвой элементу массива дерева массив текущей категории
                $tree[$id] = &$cat;
            } else {
                // Иначе добавь в родительскую категорию элемент items, содержащий массив дочерней категории
                $cats[$cat['parent_id']]['items'][$cat['id']] = &$cat;
            }
        }
        return $tree;
    }
}
