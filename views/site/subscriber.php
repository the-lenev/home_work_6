<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Add subscriber');
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>

<div class="row">
    <?php
    // Открываем форму
    $form = ActiveForm::begin(); ?>
        <?=
        // Добавляем поле, соответствующее полю 'text' в таблице и устанавливаем его описание (метку)
        $form->field($model, 'name')->label(Yii::t('app', 'Name'));
        ?>
        <?=
        // Добавляем поле для Категорий
        $form->field($model, 'email')->label(Yii::t('app', 'Email'));
        ?>
        <div class="form-group">
            <?=
            // Добавляем кнопку отправки формы
            // В зависимости от типа записи (новая/редактирование) меняем её описание и цвет
            Html::submitButton($model->isNewRecord ? Yii::t('app', 'Add') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'])
            ?>
        </div>

    <?php
    // Закрываем форму
    ActiveForm::end(); ?>
</div>
