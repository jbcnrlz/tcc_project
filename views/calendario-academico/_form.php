<?php

use dlds\summernote\SummernoteWidget;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use kartik\widgets\SwitchInput;
use yii\helpers\Html;


?>
<div class="calendario-academico-form margin-top20">

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
                   
                 <?= $form->field($model, 'curso_id',['template' => "{label}\n<div class='col-md-6'>{input}</div>\n{hint}\n{error}"])->dropDownList(\yii\helpers\ArrayHelper::map(app\models\Curso::find()->all()   ,'id','nome'), ['prompt'=>''] ); ?>

            <?= $form->field($model, 'title',['template' => "{label}
<div class='col-md-10'>{input}</div>
{hint}
{error}"])->textInput(['maxlength' => 80]) ?>


            <?= $form->field($model, 'body')->widget(SummernoteWidget::className(), [
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


            <?= $form->field($model, 'footer',['template' => "{label}
<div class='col-md-10'>{input}</div>
{hint}
{error}"])->textInput(['maxlength' => 200]) ?>

<?php
             echo $form->field($model, 'date',['template' => "{label}\n<div class='col-md-5'>{input}</div>\n{hint}\n{error}"])->widget(DateControl::classname(), [
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

            <?php if($model->isNewRecord):?>
            <?= $form->field($model, 'recorrencias',['template' => "{label}
<div class='col-md-2'>{input}</div>
{hint}
{error}"])->textInput(['placeholder'=>'dias']); ?>
            <?php endif; ?>

             <?php
                  echo  $form->field($model, 'badge',['options'=>['class'=>'not-icheck']])->widget(SwitchInput::classname(), [
                                    'pluginOptions' => [
                                            'onText' => 'Sim',
                                            'offText' => 'Não',
                                             'onColor' => 'success',
                                            'offColor' => 'danger',
                                            ]
                                    ]); ?>
            <div class="pull-left">Se marcar a data como importante, a mesma será marcada como na legenda dia 01 ficará: <div class="btn btn-default"><span class="label label-warning">01</span></div></div>



            
            
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
