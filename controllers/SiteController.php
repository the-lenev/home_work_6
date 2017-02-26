<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;
// Подключаем модели
use app\models\Post;
use app\models\Category;
use app\models\Comment;

class SiteController extends Controller {

    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    // Отображение списка задач
    public function actionIndex($cat = null) {
        // Если получена категория, то
        if (!$cat == null) {
            // Получаем записи указанной категории
            $model = Post::find()->where(['cat_id' => $cat])->all();
        } else {
            // Иначе получаем все записи из таблицы
            $model = Post::find()->all();
        }
        // Отображаем шаблон и передаем в него данные из моделей
        return $this->render('index', [
            'model' => $model,
            'category' => Category::getStructure(),
        ]);
    }

    // Добавление задачи в список
    public function actionCreate() {
        // Создаем новую запись в таблице
        $model = new Post();
        // Если есть данные переданные через $_POST, они загружены в модель и сохранены б БД, то...
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // Переходим на просмотр списка постов
            return $this->redirect(['index']);
        } else {
            // Иначе отображаем шаблон добавления задачи и загружаем в него данные из модели (поля новой записи)
            return $this->render('create', [
                'model' => $model,
                // Передаем список категорий
                'category' => Category::find()->asArray()->all(),
            ]);
        }
    }

    // Редактирование задачи
    public function actionUpdate($id = null) {
        // Находим запись по ключу
        $model = $this->findModel($id);
        // Если есть данные переданные через $_POST, они загружены в модель и сохранены б БД, то...
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // Переходим на шаблон index
            return $this->redirect(['index']);
        } else {
            // Иначе отображаем шаблон редактирования задачи и загружаем в него данные из моделей
            return $this->render('update', [
                'model' => $model,
                // Передаем список категорий
                'category' => Category::find()->asArray()->all(),
            ]);
        }
    }

    // Удаление задачи
    public function actionDelete($id = null) {
        // Находим запись по ключу и удалаем её
        $this->findModel($id)->delete();
        // Переходим на шаблон index
        return $this->redirect(['index']);
    }

    // Просмотр задачи
    public function actionView($id = null) {
        // Создаем комментарий
        $comment = new Comment();
        // Устанавливаем значение поля post_id для связи с таблицей постов
        $comment->post_id = $id;
        // Если есть данные переданные через $_POST, они загружены в модель и сохранены б БД, то...
        if ($comment->load(Yii::$app->request->post()) && $comment->save()) {
            // Переходим на страницу, с которой пришел запрос
            return $this->redirect(Yii::$app->request->referrer);
        } else {
            // Иначе отображаем шаблон добавления задачи и загружаем в него данные из моделей
            return $this->render('view', [
                'model' => $this->findModel($id),
                'comment' => $comment,
            ]);
        }
    }

    // Удаление Комментария
    public function actionDelete_comment($id = null) {
        // Находим запись по ключу
        if (($model = Comment::findOne($id)) !== null) {
            // Удалаем её
            $model->delete();
            // Переходим на страницу с которой пришел запрос
            return $this->redirect(Yii::$app->request->referrer);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModel($id) {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
