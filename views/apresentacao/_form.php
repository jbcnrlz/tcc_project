<?php

use bajadev\ckeditor\CKEditor;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use kartik\widgets\SwitchInput;
use kartik\widgets\TimePicker;
use yii\helpers\Html;

?>
<div class="apresentacao-form margin-top20">

    <div class="box box-default padding-botton20">
<?php
$form = ActiveForm::begin([
            'type' => ActiveForm::TYPE_HORIZONTAL,
            'fieldConfig' => [
                'template' => "{label}\n<div class='col-md-10'>{input}</div>\n<div class='col-md-offset-2 col-md-10'>{error}</div>",
                'labelOptions' => ['class' => 'control-label col-md-2'],
            ],
            'options' => ['enctype' => 'multipart/form-data']
        ]);
?>

        <?php
//                echo $form->errorSummary($model);
        ?>

        <div class="box-body">

            <div class="row">
                <div class="col-lg-12 form-stylo margin-top20">

                    <div class="form-group field-apresentacao-projeto_id required has-error">
                        <label class="control-label col-md-2" for="apresentacao-projeto_id">Projeto</label>
                        <div class="col-md-10"><div class="col-md-10"><input type="text" id="apresentacao-projeto_id" readonly="readonly" value="<?= $projeto->tema; ?>" class="form-control" name="nome-projeto" aria-required="true" aria-invalid="true"></div></div>
                        <div class="col-md-offset-2 col-md-10"></div>
                        <div class="col-md-offset-2 col-md-10"><div class="help-block"></div></div>
                    </div>

                    <?php
                    echo $form->field($model, 'dta_apresentacao', ['template' => "{label}\n<div class='col-md-4'>{input}</div>\n{hint}\n{error}"])->widget(DateControl::classname(), [
                        'type' => DateControl::FORMAT_DATE,
                        'ajaxConversion' => false,
                        'widgetOptions' => [
                            'pluginOptions' => [
                                'autoclose' => true,
                                'startDate' => '0d',
                                'todayHighlight' => true
                            ]
                        ]
                    ]);
                    ?>

                    <?= $form->field($model, 'local', ['template' => "{label}
<div class='col-md-4'>{input}</div>
{hint}
{error}"])->dropDownList($model->locais, ['prompt' => '']) ?>


                    <?=
                    $form->field($model, 'horario', ['template' => "{label}
<div class='col-md-4'>{input}</div>
{hint}
{error}"])->widget(TimePicker::classname(), [
                        'options' => [
                            'readonly' => true,
                        ],
                        'pluginOptions' => [
                            'showSeconds' => false,
                            'showMeridian' => false,
                        ]
                    ]);
                    ?>


                    <?= $form->field($model, 'orientador_id', ['template' => "{label}
<div class='col-md-6'>{input}</div>
{hint}
{error}"])->dropDownList(yii\helpers\ArrayHelper::map(app\models\Usuario::find()->where(['tipo' => 'Professor', 'status' => 1])->all(), 'id', 'nome'), ['prompt' => '', 'disabled' => true]) ?>

                    <?= $form->field($model, 'convidado_primario_id', ['template' => "{label}
<div class='col-md-6'>{input}</div>
{hint}
{error}"])->dropDownList(yii\helpers\ArrayHelper::map(app\models\Usuario::find()->where(['tipo' => 'Professor', 'status' => 1])->andWhere(['!=', 'id', $model->orientador_id])->all(), 'id', 'nome'), ['prompt' => '']) ?>

                    <?php
                    if ($model->etapa_projeto == 3):
                        ?>
                        <?= $form->field($model, 'convidado_secundario_id', ['template' => "{label}
<div class='col-md-6'>{input}</div>
{hint}
{error}"])->dropDownList(yii\helpers\ArrayHelper::map(app\models\Usuario::find()->where(['tipo' => 'Professor', 'status' => 1])->andWhere(['!=', 'id', $model->orientador_id])->all(), 'id', 'nome'), ['prompt' => '']) ?>

                        <?php
                    endif;
                    ?>
                    
                    <?php
                    echo $form->field($model, 'status', ['options' => ['class' => 'not-icheck']])->widget(SwitchInput::classname(), [
                        'pluginOptions' => [
                            'onText' => 'Ativo',
                            'offText' => 'Inativo',
                            'onColor' => 'success',
                            'offColor' => 'danger',
                        ]
                    ]);
                    ?>


                </div>

            </div>

        </div>




        <div class="footer footer-view">
            <div class="row">
                <div class="col-md-10 col-md-offset-2">
<?= Html::submitButton($model->isNewRecord ? '<i class="glyphicon glyphicon glyphicon-ok"></i> Salvar' : '<i class="glyphicon glyphicon glyphicon-ok"></i> Atualizar', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning','style'=>'margin-right:10px']); ?>
<?= Html::a('<i class="fa fa-ban"></i> Cancelar', 'javascript:;', ['back-url' => 'index', 'class' => 'btn btn-default', 'id' => 'cancelar']) ?>

                </div>
            </div>
        </div> <?php ActiveForm::end(); ?>
    </div></div>
