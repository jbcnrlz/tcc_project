<?php

use kartik\builder\Form;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;


?>

<?php $form = ActiveForm::begin([
    'options' => [
        'id' => 'create-matricula-form'
    ],
    'layout' => 'horizontal',
    'fieldConfig' => [
        'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
        'horizontalCssClasses' => [
            'label' => 'col-sm-4',
            'offset' => 'col-sm-offset-4',
            'wrapper' => 'col-sm-8',
            'error' => '',
            'hint' => '',
        ],
    ],


]);

?>


<div class="row" style="margin: 20px;">
    <div class="col-lg-12 form-stylo margin-top20">
        <?= $form->field($model, 'ra')->textInput(['class'=>'somente-numero','maxlength' => 14]) ?>
        <?= $form->field($model, 'termo')->dropDownList($model->termos, ['prompt' => '']); ?>
        <?= $form->field($model, 'periodo')->dropDownList($model->periodos, ['prompt' => '']); ?>
        <?= $form->field($model, 'etapa_projeto')->dropDownList($model->etapas, ['prompt' => '']); ?>
        <?= $form->field($model, 'status')->checkbox(['class' => 'bootstrap-checkbox', 'data-on-color' => 'success', 'data-on-text' => 'Ativo', 'data-off-text' => 'Inativo'])->label(false); ?>


        <?php
        $this->registerJs("$('.bootstrap-checkbox').bootstrapSwitch();");

        ?>
    </div>

</div>


<div class="modal-footer">
    <div class="col-md-10 col-md-offset-2">
        <?= Html::submitButton($model->isNewRecord ? '<i class="glyphicon glyphicon glyphicon-ok"></i> Salvar' : '<i class="glyphicon glyphicon glyphicon-ok"></i> Atualizar', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']); ?>
        <?= Html::a('<i class="fa fa-ban"></i> Cancelar', 'javascript:;', ['class' => 'btn btn-default', 'data-dismiss' => 'modal', 'aria-hidden' => true]) ?>

    </div>
</div>
<?php ActiveForm::end(); ?>
              
