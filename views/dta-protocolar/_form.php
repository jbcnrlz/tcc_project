<?php
use app\models\Curso;
use app\models\Matricula;
use bajadev\ckeditor\CKEditor;
use dlds\summernote\SummernoteWidget;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

?>
<div class="dta-protocolar-form margin-top20">

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
                   
            <?= $form->field($model, 'curso_id',['template' => "{label}
<div class='col-md-6'>{input}</div>
{hint}
{error}"])->dropDownList(ArrayHelper::map(Curso::find()->where(['status'=>1])->all(),'id','nome'),['prompt' => '']) ?>


             <?= $form->field($model, 'etapa_projeto',['template' => "{label}
<div class='col-md-5'>{input}</div>
{hint}
{error}"])->dropDownList(Matricula::getEtapas(), ['prompt' => '']); ?>

           
<?=
                    $form->field($model, 'dta_inicio',['template' => "{label}\n<div class='col-md-5'>{input}</div>\n{hint}\n{error}"])->widget(DateControl::classname(), [
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
<?=
                     $form->field($model, 'dta_termino',['template' => "{label}\n<div class='col-md-5'>{input}</div>\n{hint}\n{error}"])->widget(DateControl::classname(), [
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

            <?= $form->field($model, 'observacao')->widget(SummernoteWidget::className(), [
                   'clientOptions' => [
                            'height'=>100,
                            'lang' =>"pt-BR",
                       'toolbar'=> [
            
                            ['style', ['bold', 'italic', 'underline', 'clear']],
                            ['font', ['strikethrough', 'superscript', 'subscript']],
                            ['para', ['ul', 'ol', 'paragraph']],
                          ]
                          
                    ]
                ]) ?>
              <div class="col-md-12 text-center" style="padding-left: 20px; color:#666">
                Caso este cadastro esteja relacionado com um Aluno em questão, digite o RA do mesmo, senão deixe o campo em branco
              </div><br><br>
              <?= $form->field($model, 'matricula_ra',['template' => "{label}
<div class='col-md-5'>{input}</div>
{hint}
{error}"])->textInput(['maxlength' => 45,'class'=>'somente-numero']) ?>

            
            
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
