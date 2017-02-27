<?php
// Подключаем класс для работы с разметкой
use yii\helpers\Html;
// Подключаем класс для создания ссылок
use yii\helpers\Url;
// Подключаем класс для работы с формами
use yii\bootstrap\ActiveForm;

use yii\helpers\VarDumper;

// Устанавливаем title
$this->title = Yii::t('app', 'View article');
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
        <div class='list-group-item clearfix'>
            <label>Категория: </label>
            <?= $model->category->name ?>
        </div>
        <div class='list-group-item clearfix'>
            <label>Тэги: </label>
            <?php foreach($model->getTagPost()->all() as $post) : ?>
            <?= $post->getTag()->one()->title ?>
            <?php endforeach; ?>
        </div>
        <div class="comments-form">
            <h3><?= Yii::t('app', 'Add comment')?></h3>
            <?php
            // Открываем форму для добавления комментария
            $form = ActiveForm::begin(); ?>
                <?=
                // Добавляем поле 'Комментарий' и устанавливаем его описание (метку)
                $form->field($comment, 'text')->textArea(['rows' => 3, 'cols' => 5])->label(false);
                ?>
                <div class="form-group">
                    <?=
                    // Добавляем кнопку отправки формы
                    Html::submitButton(Yii::t('app', 'Add'), ['class' => 'btn btn-success'])
                    ?>
                </div>
            <?php
            // Закрываем форму
            ActiveForm::end(); ?>
        </div>

        <?php
        // Если есть Комментарии, то выводим их
        if ($comments = $model->comment) {?>
            <h3><?= Yii::t('app', 'Comments')?></h3>
            <?php foreach($comments as $com) {?>
                <div class='list-group-item clearfix'>
                    <div class="col-sm-11">
                        <p><?= $com['text']?></p>
                    </div>
                    <div class="col-sm-1">
                        <a href="<?= Url::to(['site/delete_comment', 'id' => $com['id']])?>">
                            <span class="glyphicon glyphicon-trash">
                        </a>
                    </div>
                </div>
            <?php }?>
        <?php }?>
</div>
