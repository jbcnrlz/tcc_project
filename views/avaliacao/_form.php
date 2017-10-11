<?php

use bajadev\ckeditor\CKEditor;
use kartik\builder\Form;
use kartik\widgets\ActiveForm;
use yii\helpers\Html;


?>
<div class="avaliacao-form margin-top20">

	<div class="box box-default padding-botton20">
             <?php     $form = ActiveForm::begin([
    'type' => ActiveForm::TYPE_HORIZONTAL,
    'fieldConfig' => [
        'template' => "{label}\n<div class='col-md-10'>{input}</div>\n<div class='col-md-offset-2 col-md-10'>{error}</div>",
        'labelOptions'=> ['class'=>'control-label col-md-2'],
    ],
    'options' => ['enctype' => 'multipart/form-data']
    ]);?>

        
		<div class="box-body">

    <div class="row">
        <div class="col-lg-12 form-stylo margin-top20">
                   
            <?= $form->field($model, 'num_questao',['template' => "{label}
<div class='col-md-10'>{input}</div>
{hint}
{error}"])->textInput() ?>


            <?= $form->field($model, 'apresentacao_id',['template' => "{label}
<div class='col-md-10'>{input}</div>
{hint}
{error}"])->textInput() ?>


            <?= $form->field($model, 'questao')->textarea(['rows' => 6]) ?>


            <?= $form->field($model, 'orientador_nota',['template' => "{label}
<div class='col-md-10'>{input}</div>
{hint}
{error}"])->textInput(['maxlength' => 2]) ?>


            <?= $form->field($model, 'convidado_primario_nota',['template' => "{label}
<div class='col-md-10'>{input}</div>
{hint}
{error}"])->textInput(['maxlength' => 2]) ?>


            <?= $form->field($model, 'convidado_secundario_nota',['template' => "{label}
<div class='col-md-10'>{input}</div>
{hint}
{error}"])->textInput(['maxlength' => 2]) ?>

            
            
        </div>

    </div>
 
    </div>

       


               <div class="footer footer-view">
    <div class="row">
        <div class="col-md-10 col-md-offset-2">
                         <?=  Html::submitButton($model->isNewRecord ? '<i class="glyphicon glyphicon glyphicon-ok"></i> Salvar' : '<i class="glyphicon glyphicon glyphicon-ok"></i> Atualizar', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']); ?>
                <?= Html::a('<i class="fa fa-ban"></i> Cancelar','javascript:;', ['class' => 'btn btn-default', 'id'=>'cancelar']) ?>
      
        </div>
        </div>
    </div> <?php ActiveForm::end(); ?>
                </div></div>
