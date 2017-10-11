<?php

use bajadev\ckeditor\CKEditor;
use kartik\builder\Form;
use kartik\widgets\ActiveForm;
use yii\helpers\Html;


?>
<div class="configuracao-app-form margin-top20">

	<div class="box box-default padding-botton20">
             <?php     $form = ActiveForm::begin([
    'type' => ActiveForm::TYPE_HORIZONTAL,
    'options' => ['enctype' => 'multipart/form-data']
    ]);?>

        
		<div class="box-body">

    <div class="row">
        <div class="col-lg-12 form-stylo margin-top20">
                   
            <?= $form->field($model, 'nome')->textInput(['maxlength' => 45]) ?>

            <?= $form->field($model, "descricao")->textInput(); ?>

           <?= $form->field($model, 'valor')->textarea(['rows'=>'2']); ?>

            
            
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
