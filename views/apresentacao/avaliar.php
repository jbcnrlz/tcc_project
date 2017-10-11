<?php

use kartik\alert\AlertBlock;
use kartik\builder\Form;
use kartik\widgets\ActiveForm;
use yii\helpers\Html;

echo AlertBlock::widget([
    'useSessionFlash' => true,
    'type' => AlertBlock::TYPE_GROWL,
    'delay' => 0,
]);



$this->title = "Avaliar Apresentação";
$this->params['breadcrumbs'][] = Html::decode($this->title);
?>


<div class="apresentacao-index">

    <div class="box">      
        <div class="box-body">
            <div class="row">
                <div class="col-md-12 form-stylo">
                    <?php
                    $form = ActiveForm::begin([
                                'type' => ActiveForm::TYPE_HORIZONTAL,
                                'formConfig' => [
                                     'labelSpan' => 4,
                                ],
                                'options' => ['enctype' => 'multipart/form-data']
                    ]);
                    ?>
                    <?php if($apresentacao->etapa_projeto == 2):?>
                    <div class="box-header with-border">
                        <i class="fa fa-edit"></i>
                        <h3 class="box-title">Nota de Qualificação do Projeto de Graduação</h3>
                       

                    </div>
                    <br>
                    
                     <?= $form->field($avaliarQ1, 'orientador_nota',['template' => "{label}
<div class='col-md-3'>{input}</div>
{hint}
{error}"])->textInput(['maxlength' => 4,'class'=>'nota'])->label($apresentacao->orientador->nome) ?>
                        
                        <?= $form->field($avaliarQ1, 'convidado_primario_nota',['template' => "{label}
<div class='col-md-3'>{input}</div>
{hint}
{error}"])->textInput(['maxlength' => 4,'class'=>'nota'])->label($apresentacao->convidadoPrimario->nome) ?>
                    
                    <?php endif; ?>
                    
                     <?php if($apresentacao->etapa_projeto == 3):?>
                    <div class="box-header with-border">
                        <i class="fa fa-edit"></i>
                        <h3 class="box-title">Nota de Avaliação do Projeto(Prático e/ou Conceitual)</h3>
                    </div>
                     <br>
                     
                 
                        <?= $form->field($avaliar[0], '[0]orientador_nota',['template' => "{label}
<div class='col-md-3'>{input}</div>
{hint}
{error}"])->textInput(['maxlength' => 4,'class'=>'nota'])->label($apresentacao->orientador->nome) ?>
                        
                        <?= $form->field($avaliar[0], '[0]convidado_primario_nota',['template' => "{label}
<div class='col-md-3'>{input}</div>
{hint}
{error}"])->textInput(['maxlength' => 4,'class'=>'nota'])->label($apresentacao->convidadoPrimario->nome) ?>
                    
                       <?= $form->field($avaliar[0], '[0]convidado_secundario_nota',['template' => "{label}
<div class='col-md-3'>{input}</div>
{hint}
{error}"])->textInput(['maxlength' => 4,'class'=>'nota'])->label($apresentacao->convidadoSecundario->nome) ?>
                    <br>
                    
                    <div class="box-header with-border">
                        <i class="fa fa-edit"></i>
                        <h3 class="box-title">Nota de Avaliação da Apresentação Oral</h3>
                    </div>
                    <br>
                    
                        <?= $form->field($avaliar[1], '[1]orientador_nota',['template' => "{label}
<div class='col-md-3'>{input}</div>
{hint}
{error}"])->textInput(['maxlength' => 4,'class'=>'nota'])->label($apresentacao->orientador->nome) ?>
                        
                        <?= $form->field($avaliar[1], '[1]convidado_primario_nota',['template' => "{label}
<div class='col-md-3'>{input}</div>
{hint}
{error}"])->textInput(['maxlength' => 4,'class'=>'nota'])->label($apresentacao->convidadoPrimario->nome) ?>
                    
                    <?= $form->field($avaliar[1], '[1]convidado_secundario_nota',['template' => "{label}
<div class='col-md-3'>{input}</div>
{hint}
{error}"])->textInput(['maxlength' => 4,'class'=>'nota'])->label($apresentacao->convidadoSecundario->nome) ?>
                    
                    
                    <?php endif; ?>



                    <div class="footer footer-view">
                        <div class="row">
                            <div class="col-md-8 col-md-offset-4">
                                <?= Html::submitButton('<i class="glyphi$modelcon glyphicon glyphicon-ok"></i> Salvar', ['class' => 'btn btn-warning']); ?>&nbsp;
<?= Html::a('<i class="fa fa-ban"></i> Cancelar', 'javascript:;', ['back-url' => 'banca', 'class' => 'btn btn-default', 'id' => 'cancelar']) ?>

                            </div>
                        </div>
                    </div> <?php ActiveForm::end(); ?>

                </div>

            </div>


        </div>

    </div> <!--end box -->

</div>

