<?php

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var yii\gii\generators\crud\Generator $generator
 */
echo $form->field($generator, 'modelClass');
echo $form->field($generator, 'searchModelClass');
echo $form->field($generator, 'controllerClass');
//echo $form->field($generator, 'baseControllerClass');
//echo $form->field($generator, 'moduleID');
echo $form->field($generator, 'indexWidgetType')->dropDownList([
    'grid' => 'GridView',
    'list' => 'ListView',
]);


//echo $form->field($generator, 'messageCategory');
echo $form->field($generator, 'tituloCrud');
echo $form->field($generator, 'campos');
echo $form->field($generator, 'campoEditavel');
//echo $form->field($generator, 'camponot');
echo $form->field($generator, 'exceptions');
echo $form->field($generator, 'ordemForm')->textarea(['rows'=>4]);
echo $form->field($generator, 'editor')->checkbox();
?>

<?php

$this->registerJs("$(document).on('blur','#generator-modelclass',function(){
    $.ajax({
     type: 'GET',
    data:({class : $('#generator-modelclass').val()}),
       url: '/admin/site/campos-tabela',
       success: function(data) {
          $('#generator-ordemform').val(data);
       }
    });
});
");


?>

<?php

 

