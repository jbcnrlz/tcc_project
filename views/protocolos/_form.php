<?php

use bajadev\ckeditor\CKEditor;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\Html;
use yii\web\JsExpression;

$url = \yii\helpers\Url::to(['listar-projetos']);


$temaProjeto = empty($model->projeto_id) ? '' : app\models\Projeto::findOne($model->projeto_id)->tema;


?>
<div class="protocolos-form margin-top20">

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
            
            <?php 
                if(count(@$projeto)>0):
            ?>
                <div class="form-group field-protocolos-projeto-id required has-error">
                   <label class="control-label col-md-2" for="protocolos-numero">Projeto</label>
                   <div class="col-md-10"><div class="col-md-10">
                        <input type="text" readonly="readonly" id="protocolos-projeto-tema" class="form-control" name="projeto-tema" value="<?=$projeto->tema?>" maxlength="255" aria-required="true" aria-invalid="true">
                        <input type="hidden" id="protocolos-projeto-id" class="form-control" name="Protocolos[projeto_id]" value="<?=$projeto->id?>" maxlength="255" aria-required="true" aria-invalid="true"></div></div>
                          <div class="col-md-offset-2 col-md-10"></div>
                        <div class="col-md-offset-2 col-md-10"><div class="help-block"></div></div>
                </div>
            <?php
            
            else:
                
            
            
            echo $form->field($model, 'projeto_id')->widget(Select2::classname(), [
                    'initValueText' => $temaProjeto, 
                    
                    'options' => ['placeholder' => 'Procurar Projeto...'],
                'pluginOptions' => [
                    'language' => 'pt_br',
                    'allowClear' => true,
                    'minimumInputLength' => 3,
                    'language' => [
                        'errorLoading' => new JsExpression("function () { return 'Aguardando resultados...'; }"),                        
                        'inputTooShort' => new JsExpression("function () { return 'Digite 3 caracteres ou mais...'; }"),
                    ],
                    'ajax' => [
                        'url' => $url,
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                    ],
                    'formatInputTooShort' => new JsExpression('function() {return false;}'),
                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                    'templateResult' => new JsExpression('function(projeto) { return projeto.text; }'),
                    'templateSelection' => new JsExpression('function (projeto) { return projeto.text; }'),
                ],
                ]);
            
            endif;
            ?>
                           
             <?php
             echo $form->field($model, 'dta_protocolo',['template' => "{label}\n<div class='col-md-5'>{input}</div>\n{hint}\n{error}"])->widget(DateControl::classname(), [
                'type'=>DateControl::FORMAT_DATE,
                'ajaxConversion'=>false,
                'widgetOptions' => [
                    'pluginOptions' => [
                        'autoclose' => true,
                        'startDate'=> '0d',
                        'todayHighlight' => false
                    ]
                ]
            ]);
            ?>
            
            <?= $form->field($model, 'numero',['template' => "{label}
<div class='col-md-2'>{input}</div>
{hint}
{error}"])->textInput(['maxlength' => 255]) ?>

            <?php
                $ano = [];
                for($i = date("Y");$i >= (date("Y")-10);$i--){
                    $ano["$i"] = $i;
                }                
            
            ?>
          <?= $form->field($model, 'ano',['template' => "{label}\n<div class='col-md-2'>{input}</div>\n{hint}\n{error}"])->dropDownList($ano, ['prompt'=>''] ); ?>
            
            
 
          <?= $form->field($model, 'classificacao',['template' => "{label}\n<div class='col-md-5'>{input}</div>\n{hint}\n{error}"])->dropDownList($model->classificacoes, ['prompt' => '']); ?>
      

            <?= $form->field($model, 'descricao',['template' => "{label}
<div class='col-md-10'>{input}</div>
{hint}
{error}"])->textInput(['maxlength' => 255,'placeholder'=>'Descreva a assunto deste Protocolo']) ?>


           
            
            
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


</div>