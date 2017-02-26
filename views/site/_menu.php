<?=
yii\widgets\Menu::widget([
    'items' => $category,
    'submenuTemplate' => "\n<ul>\n{items}\n</ul>\n",
    'linkTemplate' => ' <a href = "{url}">{label}</a > ',
    'activateParents' => true,
    'options' => ['class' => 'list-unstyled'],
    //'itemOptions' => ['class' => 'sub_menu'],
]);
