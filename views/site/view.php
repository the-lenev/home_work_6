<?php
// Подключаем класс для работы с разметкой
use yii\helpers\Html;
// Подключаем класс для создания ссылок
use yii\helpers\Url;
// Подключаем класс для работы с формами
use yii\bootstrap\ActiveForm;

// Устанавливаем title
$this->title = Yii::t('app', 'View post');
// Добавляем title в дорогу (хлебные крошки)
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Отображыем title -->
<h1><?= Html::encode($this->title) ?></h1>
<?php
// Для указнной записи выводим значения полей, в соответствующие места разметки
?>
<div class='list-group-item clearfix'>
    <div class="col-sm-10">
        <?= $model['title']?>
    </div>
    <div class="col-sm-1">
        <a href="<?= Url::to(['site/update', 'id' => $model['id']])?>">
            <span class="glyphicon glyphicon-pencil"></span>
        </a>
    </div>
    <div class="col-sm-1">
        <a href="<?= Url::to(['site/delete', 'id' => $model['id']])?>">
            <span class="glyphicon glyphicon-trash">
        </a>
    </div>
</div>
