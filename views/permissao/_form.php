<?php

use kartik\widgets\ActiveForm;
use yii\helpers\Html;

?>

<div class="permissao-model-form margin-top20">

    <div class="box box-default padding-botton20">

    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]); ?>
        <div class="box-body">

            <div class="row">
                <div class="col-lg-12 form-stylo margin-top20">
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

  
    <?= $form->field($model, 'description')->textarea(['rows' => 6, 'onkeydown'=>"if(event.keyCode == 13) return false;"]) ?>

                   
                     <div class="footer footer-view">
                        <div class="row">
                            <div class="col-md-10 col-md-offset-2">
                                <?=  Html::submitButton($model->isNewRecord ? '<i class="glyphicon glyphicon glyphicon-ok"></i> Salvar' : '<i class="glyphicon glyphicon glyphicon-ok"></i> Atualizar', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']); ?>
                                <?= Html::a('<i class="fa fa-ban"></i> Cancelar','javascript:;', ['class' => 'btn btn-default', 'id'=>'cancelar']) ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php ActiveForm::end(); ?>

</div>
    </div>

