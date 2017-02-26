<?php

namespace app\models;
use Yii;
// Подключаем класс для создания ссылок
use yii\helpers\Url;

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
        // получаем все категории
        $cats = Category::find()->asArray()->all();
        // Если массив пуст, то возвращаем null
        if (!$cats) {
            return null;
        }
        // Массив категорий, где индексы равны id родительской категории
        $parent_cat = [];
        // Для всех категорий
        foreach ($cats as $cat) {
            // Создаем ключ равный родительсой категории
            $key = $cat['parent_id'];
            // Если ключ не определен, значит это корневая категория
            if ($key == NULL)  {
                $key = 0;
            }
            // Если элемента с таким родителем еще нет, то присваиваем ему значения пустого массива
            if (empty($parent_cat[$key])) {
                $parent_cat[$key] = [];
            }
            // Добавляем категорию в элемент массива, соответствующий её родителю
            $parent_cat[$key][] = $cat;
        }

        // $view_cat - лямда функция для реурсивного создания вложенных массивов категорий
        $view_cat =
        function ($parent_cat, $parent_id = 0) use ( & $view_cat) {
            // Если элемент массива пустой, то преращыем выполнение функции
            if (empty($parent_cat[$parent_id])) {
                return;
            }
            // Временный массив для хранения текущих значений
            $cat = [];
            // Для всех элементов массива текущей родительской категории формируем массив для предстовления
            foreach ($parent_cat[$parent_id] as $row) {
                $cat[] = [
                    // Устанавливаем значения метки
                    'label' => $row['name'],
                    // URL
                    'url' => Url::to(['', 'cat' => $row['id']]),
                    // Вызываем функцию создания массива для представления и передаем в не текущий id категории
                    // Если категория является родительской, то рекурсивно в неё вставиться оформленные массивы подкатегорий
                    'items' => $view_cat($parent_cat, $row['id'])
                ];
            }
            return $cat;
        };
        // В функцию передаем отсортированный массив категорий
        // И возвращаем полученный для представления массив
        return $view_cat($parent_cat);
    }
}
