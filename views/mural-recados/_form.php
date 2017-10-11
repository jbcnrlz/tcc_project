<?php

use dlds\summernote\SummernoteWidget;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use kartik\widgets\SwitchInput;
use yii\helpers\Html;


?>
<div class="mural-recados-form margin-top20">

	<div class="box box-default padding-botton20">
             <?php     $form = ActiveForm::begin([
                      'type' => ActiveForm::TYPE_HORIZONTAL,
       
              'fieldConfig' => [
        'template' => "{label}\n<div class='col-md-10'>{input}</div>\n<div class='col-md-offset-2 col-md-10'>{error}</div>",
        'labelOptions'=> ['class'=>'control-label col-md-2'],
    ],
                 'options'=>[
                     'autocomplete'=>'off']
    ]);
             
             
           ?>

        
		<div class="box-body">

    <div class="row">
        <div class="col-lg-12 form-stylo margin-top20">
                   
             <?= $form->field($model, 'departamento',['template' => "{label}\n<div class='col-md-5'>{input}</div>\n{hint}\n{error}"])->dropDownList([
                    'Secretária' => 'Secretária',
                    'Coordenação' => 'Coordenação',
                    'Direção' => 'Direção',
                ], ['prompt'=>''] ); ?>
            
              
            
            <?= $form->field($model, 'curso_id',['template' => "{label}\n<div class='col-md-6'>{input}</div>\n{hint}\n{error}"])->dropDownList(\yii\helpers\ArrayHelper::map(app\models\Curso::find()->all()   ,'id','nome'), ['prompt'=>''] ); ?>

<?= $form->field($model, 'termo',['template' => "{label}\n<div class='col-md-3'>{input}</div>\n{hint}\n{error}"])->dropDownList([
                    '4' => '4º Termo',
                    '5' => '5º Termo',
                    '6' => '6º Termo',
                ], ['prompt'=>''] ); ?>

            <?= $form->field($model, 'titulo',['template' => "{label}
<div class='col-md-10'>{input}</div>
{hint}
{error}"])->textInput(['maxlength' => 100]) ?>
            
            <?php
             echo $form->field($model, 'dta_notificacao',['template' => "{label}\n<div class='col-md-5'>{input}</div>\n{hint}\n{error}"])->widget(DateControl::classname(), [
                'type'=>DateControl::FORMAT_DATE,
                'ajaxConversion'=>false,
                'widgetOptions' => [
                    'pluginOptions' => [
                        'autoclose' => true,
                        'startDate'=> '0d',
                        'todayHighlight' => true
                    ]
                ]
            ]);
            ?>

             <?php
             echo $form->field($model, 'dta_termino_visualizacao',['template' => "{label}\n<div class='col-md-5'>{input}</div>\n{hint}\n{error}"])->widget(DateControl::classname(), [
                'type'=>DateControl::FORMAT_DATE,
                'ajaxConversion'=>false,
                'widgetOptions' => [
                    'pluginOptions' => [
                        'autoclose' => true,
                        'startDate'=> '0d',
                        'todayHighlight' => true
                    ]
                ]
            ]);
            ?>


           <?= $form->field($model, 'recado')->widget(SummernoteWidget::className(), [
                   'clientOptions' => [
                            'height'=>200,
                            'lang' =>"pt-BR",
                       'toolbar'=> [
            
                            ['style', ['bold', 'italic', 'underline', 'clear']],
                            ['font', ['strikethrough', 'superscript', 'subscript']],
                            ['para', ['ul', 'ol', 'paragraph']],
                          ]
                          
                    ]
                ]) ?>
                <?php
                  echo  $form->field($model, 'status',['options'=>['class'=>'not-icheck']])->widget(SwitchInput::classname(), [
                                    'pluginOptions' => [
                                            'onText' => 'Ativo',
                                            'offText' => 'Inativo',
                                             'onColor' => 'success',
                                            'offColor' => 'danger',
                                            ]
                                    ]); ?>
            
        </div>

    </div>
 
    </div>

       


               <div class="footer footer-view">
    <div class="row">
        <div class="col-md-10 col-md-offset-2">
                         <?=  Html::submitButton($model->isNewRecord ? '<i class="glyphicon glyphicon glyphicon-ok"></i> Salvar' : '<i class="glyphicon glyphicon glyphicon-ok"></i> Atualizar', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']); ?>
                <?= Html::a('<i class="fa fa-ban"></i> Cancelar','javascript:;', ['class' => 'btn btn-default','back-url'=>'index', 'id'=>'cancelar']) ?>
      
        </div>
        </div>
    </div> <?php ActiveForm::end(); ?>
                </div></div>
