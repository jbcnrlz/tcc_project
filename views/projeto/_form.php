<?php

use bajadev\ckeditor\CKEditor;
use kartik\builder\Form;
use kartik\select2\Select2;
use kartik\widgets\ActiveForm;
use yii\helpers\Html;


?>

<script>
  
    </script>
<div class="projeto-form margin-top20">

	<div class="box box-default padding-botton20">
             <?php     $form = ActiveForm::begin([
    'type' => ActiveForm::TYPE_HORIZONTAL,
    'fieldConfig' => [
        'template' => "{label}\n<div class='col-md-10'>{input}</div>\n<div class='col-md-offset-2 col-md-10'>{error}</div>",
        'labelOptions'=> ['class'=>'control-label col-md-2'],
    ],
    'options' => ['enctype' => 'multipart/form-data']
    ]);?>

            <?php echo $form->errorSummary($model); ?>
        
		<div class="box-body">

    <div class="row">
        <div class="col-lg-12 form-stylo margin-top20">
                           
            
            <?= $form->field($model, 'tema',['template' => "{label}
<div class='col-md-10'>{input}</div>
{hint}
{error}"])->textInput(['maxlength' => 255]) ?>

<?php if (!Yii::$app->user->can('Aluno')): ?>            
            <?= $form->field($model, 'matricula_ra',['template' => "{label}
<div class='col-md-4'>{input}</div>
{hint}
{error}"])->textInput(['maxlength' => 14, 'class'=>'somente-numero']); ?>
 
<?=$form->field($model, 'orientador_id')->widget(Select2::classname(), [
    'data' => $professores,
    'options' => ['placeholder' => 'Selecione o Orientador ...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);?>
  <?php endif ?>            

            
        <?=$form->field($model, 'orientador_sugestao_id')->widget(Select2::classname(), [
    'data' => $professores,
    'options' => ['placeholder' => 'Selecione sua sugestão de Orientador ...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);?>


           

            <?= $form->field($model, 'palavra_chave',['template' => "{label}
<div class='col-md-10'>{input}</div>
{hint}
{error}"])->textInput(['maxlength' => 255,'placeholder'=>'Separe as palavras chaves por vírgulas. Ex.: tecnologia,movel...']) ?>


            <?= $form->field($model, 'resumo')->textarea(['rows' => 6,'placeholder'=>'Fale um  pouco do projeto...']) ?>

         <?php if (!Yii::$app->user->can('Aluno')): ?> 
<?=$form->field($model, 'status',['template' => "{label}
<div class='col-md-4'>{input}</div>
{hint}
{error}",'options'=>['class'=>'form-group input-status']])->dropdownlist(['1'=>'Em Processo','2'=>'Concluido', '3'=>'Cancelado']);
        

?><?php endif ?> 
            
            
        </div>

    </div>
 
    </div>

       


               <div class="footer footer-view">
    <div class="row">
        <div class="col-md-10 col-md-offset-2">
                         <?=  Html::submitButton($model->isNewRecord ? '<i class="glyphicon glyphicon glyphicon-ok"></i> Salvar' : '<i class="glyphicon glyphicon glyphicon-ok"></i> Atualizar', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']); ?>
           
                       <?= Html::a('<i class="fa fa-ban"></i> Cancelar','javascript:;', ['class' => 'btn btn-default','back-url'=>'/projeto/meu-projeto', 'id'=>'cancelar']) ?>
    
    
    
        </div>
    </div> <?php ActiveForm::end(); ?>
                </div></div>
