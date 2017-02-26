<?php
// Подключаем класс для работы с разметкой
use yii\helpers\Html;
// Подключаем класс для создания ссылок
use yii\helpers\Url;

// Устанавливаем title
$this->title = Yii::t('app', 'Articles list');
// Добавляем title в дорогу (хлебные крошки)
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>
<div class="row">
    <div class="col-sm-2">
        <?= $this->render('_menu', [
            'category' => $category,
        ])?>
    </div>
    <div class="col-sm-10">
        <div class="list-group">
        <?php
        // Для всех записей из таблицы выводим значения полей, в соответствующие места в разметке
        // Ссылки указывают на действия контроллера, которые нужно выполнить, и ключи записей, к которым их нужно применить
        foreach ($model as $post) {?>
            <div class='list-group-item clearfix'>
                <div class="col-sm-9">
                    <a href="<?= Url::to(['site/view', 'id' => $post['id']])?>">
                        <?= $post['title']?>
                    </a>
                </div>
                <div class="col-sm-1">
                    <a href="<?= Url::to(['site/view', 'id' => $post['id']])?>" title="<?= Yii::t('app', 'Show comment')?>">
                        <span class="glyphicon glyphicon-comment"></span>
                        <?php
                        if ($comments = $post->comment) {?>
                            <span><?= count($comments)?></span>
                        <?php }?>
                    </a>
                </div>
                <div class="col-sm-1">
                    <a href="<?= Url::to(['site/update', 'id' => $post['id']])?>">
                        <span class="glyphicon glyphicon-pencil"></span>
                    </a>
                </div>
                <div class="col-sm-1">
                    <a href="<?= Url::to(['site/delete', 'id' => $post['id']])?>">
                        <span class="glyphicon glyphicon-trash">
                    </a>
                </div>
            </div>
        <?php }?>
        </div>
        <div class="list-group">
            <a class="btn btn-success" href="<?= Url::to(['site/create'])?>">
                 <?= Yii::t('app', 'Add');?>
            </a>
        </div>
    </div>
</div>
