<?php
// Подключаем класс для работы с разметкой
use yii\helpers\Html;
//  Подключаем класс для работы c массивами
use yii\helpers\ArrayHelper;
// Подключаем класс для работы с формами
use yii\bootstrap\ActiveForm;
?>

<div class="row">
    <?php
    // Открываем форму
    $form = ActiveForm::begin(); ?>
        <?=
        // Добавляем поле заголовка Поста
        $form->field($model, 'title')->label(Yii::t('app', 'Title'));
        ?>
        <?=
        // Добавляем поле для Категорий
        $form->field($model, 'cat_id')->dropDownList(ArrayHelper::map($category, 'id', 'name'))->label(Yii::t('app', 'Category'));
        ?>
        <?=
        // Добавляем поле для Содержания
        $form->field($model, 'content')->textArea(['rows' => 3, 'cols' => 5])->label(Yii::t('app', 'Content'));
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
