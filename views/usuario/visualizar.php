<?php

use app\components\Mimin;
use kartik\alert\AlertBlock;
use kartik\detail\DetailView;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\Html;


echo AlertBlock::widget([
            'useSessionFlash' => true,
            'type' => AlertBlock::TYPE_GROWL,
            'delay' => 0,
    
        ]);

/**
 * @var yii\web\View $this
 * @var app\models\AlunosModel $model
 */
$this->title = "Visualizar";
$this->params['breadcrumbs'][] = ['label' => 'Usuários', 'url' => ['index']];
$this->params['breadcrumbs'][] = "Visualizar";

?>
<div class="row">
    <div class="col-lg-12">
     <?php
        if($model->notificacao != 0){
     ?>
    <?=  Html::a('<i class="glyphicon glyphicon-send"></i> Enviar Notificação de Ativação',"/".Yii::$app->controller->id."/enviar-notificacao?id=".$model->id,['id'=>'enviarNotificacao','autocomplete'=>'off','class' => 'btn btn-info isDisabled pull-right','data-loading-text'=>'<i class="glyphicon glyphicon-send"></i> Aguarde Enviando...','disabled'=>!Mimin::checkRoute($this->context->id.'/enviar-notificacao')]); ?>
    
    
   <?php
        }
   ?></div>
</div>
        
<div class="alunos-model-view">

<div class="box margin-top20">

		<div class="box-body">
            <?php             $button1 = null;
            
            if(Mimin::checkRoute($this->context->id.'/delete')){
                $button1 =  $button1.'{delete}';
            }

            ?>
                    <div class="row">
                        <div class="col-md-2">
              
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <?= Html::img('/upload/avatarPerfil/'.(($model->foto != '')?$model->foto:'SemImagem.jpg'),['class'=>'img-thumbnail']); ?>
                                 
                                </div>
                             
                            </div>
                            <br />
                            <div class="row">
                                <div class="col-md-12 text-center">
                                 
                                </div>
                                <br>
                                
                            </div>
                        </div>
                        <div class="col-md-10">
        
               <?php
                            if($model->status==0){
                                $status = "<span class='label label-danger size-label'>Bloqueado</span>";
                            }else if($model->status ==1) {
                                $status = "<span class='label label-success size-label'>Ativo</span>";
                            }else{
                                $status = "<span class='label label-info size-label'>Pendente</span>";
                            }
                            
                            
                            ?>
                             <?= DetailView::widget([
            'model' => $model,
            'condensed'=>false,
            'hover'=>true,
             'panel'=>[
            'heading'=>'Dados do Usuário',
            'type'=>DetailView::TYPE_DEFAULT,
        ],
        
        'attributes' => [
            ['attribute'=>'id', 'displayOnly'=>true],
            [ 'attribute'=>'tipo',
              'format' => 'raw',
              'value'=> $model->tipo
            ],
            ['attribute'=>'nome', 'displayOnly'=>true],
            ['attribute'=>'cpf', 'displayOnly'=>true],
            [
                    'attribute' => 'sexo',
                    'value'=> ($model->sexo == 'M')?'Masculino':'Feminino',
                    'width'=>''],
            ['attribute'=>'lattes', 'displayOnly'=>true, 'visible'=>($model->tipo == 'Professor(a)')],
            ['attribute'=>'pesquisa', 'displayOnly'=>true,'format'=>'raw', 'visible'=>($model->tipo == 'Professor(a)')],
            ['attribute'=>'username', 'displayOnly'=>true],
            ['attribute'=>'email', 'displayOnly'=>true],
      
          
            [
               'attribute'=>'status', 
               'format'=>'raw',
                'value'=>$status,
      
//                
//               'value'=>($model->status == 0)? '<span class="label label-danger size-label">Bloqueado</span>':($model->status == 1)? '<span class="label label-success size-label">Ativo</span>' : '<span class="label label-info size-label">Pendente</span>',
//               
               ],
                             [
                                 'attribute'=>'dta_expiracao',
                                 'format'=>'raw',
                                 'displayOnly'=>true,
                                 'visible'=>($model->tipo == 'Estudante'),                                 
                                 'value'=>($model->dta_expiracao < date('Y-m-d'))? "<span class='label label-danger size-label'>".Yii::$app->formatter->asDate($model->dta_expiracao)."</span>":"<span class='label label-success size-label'>".Yii::$app->formatter->asDate($model->dta_expiracao)."</span>",
                             ],
            [
                 'attribute'=>'dta_cadastro', 
                 'format'=>'date',
                'displayOnly'=>true,
                 'type'=>DetailView::INPUT_DATE,
             ],    
         
             [
                 'attribute'=>'dta_atualizacao', 
                 'format'=>'date',
                 'displayOnly'=>true,
                 'type'=>DetailView::INPUT_DATE,
                 ],
             
             
            
        ],

        'enableEditMode'=>false,
    ]) ?>
              
                            
                            
                        </div>
                    </div>
                    <?php if($model->tipo == 'Aluno'){ ?>
                    <div class="row">
                        <div class="col-md-12">
                            <?= $this->render('/matricula/_matriculas',['matriculaProvider'=>$matriculaProvider]); ?>
                        </div>
                    </div>
                    <?php } ?>
              

</div>
 </div></div>
<?php     $form = ActiveForm::begin([
    'type' => ActiveForm::TYPE_HORIZONTAL,
    'formConfig' => ['labelSpan' => 0, 'deviceSize' => ActiveForm::SIZE_SMALL]
    ]);?>      
            
          <div class="box box-solid">
            <div class="box-header with-border">
              <i class="fa fa-lock"></i>

              <h3 class="box-title">Permissões do Usuário</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="col-md-9">
               <?php
                    echo $form->field($authAssignment, 'item_name')->widget(Select2::classname(), [
                      'data' => $authItems,
                      'language' => 'pt',
                      'options' => [                    
                        'placeholder' => 'Selecione a Permissão ...',
                      ],
                      'pluginOptions' => [
                        'allowClear' => true,
                        'multiple' => true,
                      ],
                    ])->label(false); ?>
                    </div>
                <div class="col-md-2">
                      <?=  Html::submitButton($model->isNewRecord ? '<i class="glyphicon glyphicon glyphicon-lock"></i> Salvar' : '<i class="glyphicon glyphicon glyphicon-lock"></i> Atualizar Permissão', ['class' => $model->isNewRecord ? 'btn btn-danger' : 'btn btn-danger']); ?>
          
                </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
          
                     
                   
    <div class="footer footer-view">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
             
            <?=  Html::a('<i class="glyphicon glyphicon-th-list"></i> Lista',"/".Yii::$app->controller->id,['class' => 'btn btn-default isDisabled','disabled'=>!Mimin::checkRoute($this->context->id.'/index')]); ?>
             <?=  Html::a('<i class="glyphicon glyphicon-plus"></i> Adicionar Novo',"/".Yii::$app->controller->id."/cadastrar",['class' => 'btn btn-warning isDisabled','disabled'=>!Mimin::checkRoute($this->context->id.'/cadastrar')]); ?>
             <?=  Html::a('<i class="glyphicon glyphicon-pencil"></i> Editar Cadastro',"/".Yii::$app->controller->id."/atualizar?id=".$model->id,['class' => 'btn btn-warning isDisabled','disabled'=>!Mimin::checkRoute($this->context->id.'/atualizar')]); ?>
           
        </div>
        </div>
    </div> 
                    <?php ActiveForm::end(); ?>

