<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Search';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?=
    // Создаем виджет Сетки
    GridView::widget([
        // Передаем экземпляр поставщика данных
        'dataProvider' => $dataProvider,
        // Передаем модель
        'filterModel' => $searchModel,
        // Настраиваем отображение столбцов
        'columns' => [
            // Выводим счетчик строк
            ['class' => 'yii\grid\SerialColumn'],
            // Заголовок
            'title',
            // Содержание
            'content:ntext',
            // Отображаем действия с записями
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
