<?php

use bajadev\ckeditor\CKEditor;
use dlds\summernote\SummernoteWidget;
use kartik\alert\AlertBlock;
use kartik\builder\Form;
use kartik\widgets\ActiveForm;
use yii\helpers\Html;


echo AlertBlock::widget([
            'useSessionFlash' => true,
            'type' => AlertBlock::TYPE_GROWL,
            'delay' => 0,
    
        ]);



$this->title = "Relatório Parcial ".(($model->fase==1)?"I":"II");
$this->params['breadcrumbs'][] = ['label' => 'Projetos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->projeto->tema, 'url' => ['visualizar','id'=>$model->projeto_id]];
$this->params['breadcrumbs'][] = "Relatório Parcial ".(($model->fase==1)?"I":"II");
$this->params['breadcrumbs'][] = "Atualizar";
?>
<div class="relatorios-parciais-cadastrar">

   <div class="relatorios-parciais-form margin-top20">
   
    <div class="box box-default padding-botton20">
        <div class="col-lg-12">
             <div class="box-header with-border">
                 <h4>Dados do Projeto</h4>
                 
                  </div>

          <div class="table-responsive">
            <table class="table">
              <tbody><tr>
                <th style="width:10%">Tema</th>
                <td><?=$model->projeto->tema ?></td>
              </tr>
              <tr>
                <th>Aluno</th>
                <td><?=$model->projeto->matriculaRa->estudante->nome ?></td>
              </tr>
              <tr>
                <th><?=($model->projeto->orientador->sexo=="M")?"Orientador":"Orientadora" ?></th>
                <td><?=$model->projeto->orientador->nome ?></td>
              </tr>
              <tr>
                <th>Curso</th>
                <td><?=$model->projeto->matriculaRa->curso->nome ?></td>
              </tr>
              <tr>
                <th>Termo</th>
                <td><?=$model->projeto->matriculaRa->termo."º - ".$model->projeto->matriculaRa->periodo." (".$model->projeto->matriculaRa->getNomeEtapa($model->etapa_projeto).")" ?></td>
              </tr>
            </tbody></table>
          </div>
        </div>

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
               <?= $form->field($model, 'nota',['template' => "{label}
<div class='col-md-2'>{input}</div>
{hint}
{error}"])->textInput(['maxlength' => 4,'class'=>'nota']) ?>
            
            <?php if(Yii::$app->params['qtde-relatorio'] == 1): ?>
                 <?php if($model->etapa_projeto == 2): ?>
                        <?= $form->field($model, 'apto')->checkbox(['label'=>'&nbspApto para Qualificação do Projeto','labelOptions'=>['style'=>'margin-left:15px;']])->label(false); ?>
                  <?php else: ?>
                        <?= $form->field($model, 'apto')->checkbox(['label'=>'&nbspApto para Defesa do Projeto','labelOptions'=>['style'=>'margin-left:15px;']])->label(false); ?>
                
                 <?php endif; ?>
                 <?php endif; ?>
               <?php if(Yii::$app->params['qtde-relatorio'] == 2): ?>
                <?php if($model->fase == 2): ?>
                    <?php if($model->etapa_projeto == 2): ?>
                        <?= $form->field($model, 'apto')->checkbox(['label'=>'&nbspApto para Qualificação do Projeto','labelOptions'=>['style'=>'margin-left:15px;']])->label(false); ?>
                  <?php else: ?>
                        <?= $form->field($model, 'apto')->checkbox(['label'=>'&nbspApto para Defesa do Projeto','labelOptions'=>['style'=>'margin-left:15px;']])->label(false); ?>
                
                 <?php endif; ?>             <?php endif; ?>
                <?php endif; ?>
                   <?= $form->field($model, 'descricao')->widget(SummernoteWidget::className(), [
                   'clientOptions' => [
                            'height'=>400,
                            'lang' =>"pt-BR",
                       'toolbar'=> [
            
                            ['style', ['bold', 'italic', 'underline', 'clear']],
                            ['font', ['strikethrough', 'superscript', 'subscript']],
                            ['para', ['ul', 'ol', 'paragraph']],
                            
                          ],
                       
    
  
                          
                    ]
                ]) ?>
            <div class="col-md-offset-2 col-md-8 text-center" style="padding-left: 20px; color:#666">
                Para inserir quebra de página no relatório utilize o comando:<strong> ===quebra-pagina===</strong>
            </div>
            <br>  <br>  <br>
            
        
<?= $form->field($model, 'status')->checkbox(['label'=>'&nbspFinalizar Relatório','labelOptions'=>['style'=>'margin-left:15px;']])->label(false); ?>
  
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

</div>