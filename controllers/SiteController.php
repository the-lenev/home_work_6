<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;
// Подключаем модели
use app\models\Post;

class SiteController extends Controller {

    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    // Отображение списка задач
    public function actionIndex() {

        $model = Post::find()->all();
        // Отображаем шаблон и передаем в него данные из моделей
        return $this->render('index', [
            'model' => $model,
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
    
        // отображаем шаблон добавления задачи и загружаем в него данные из моделей
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    protected function findModel($id) {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}