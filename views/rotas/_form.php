<?php
use kartik\widgets\ActiveForm;
use kartik\widgets\SwitchInput;
use yii\helpers\Html;


?>
<div class="alunos-model-form margin-top20">

	<div class="box box-default padding-botton20">
             <?php     $form = ActiveForm::begin([
    'type' => ActiveForm::TYPE_HORIZONTAL,
    'options' => ['enctype' => 'multipart/form-data']
    ]);?>

        
		<div class="box-body">

    <div class="row">
        <div class="col-lg-12 form-stylo margin-top20">
                   
  
  <?= $form->field($model, 'type')->textInput(['maxlength' => true]) ?>
            
    <?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            
            
    <?= $form->field($model, 'status',['options'=>['class'=>'not-icheck']])->widget(SwitchInput::classname(), [
                'pluginOptions' => [
  			'onText' => 'Ativo',
  			'offText' => 'Inativo',
                        'onColor' => 'success',
                        'offColor' => 'danger',
  		]
  	]) ?>

            
            
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
