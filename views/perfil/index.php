<?php

use app\components\Mimin;
use kartik\alert\AlertBlock;
use kartik\detail\DetailView;
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
$this->title = "Seu Perfil";
$this->params['breadcrumbs'][] = ['label' => 'Perfil', 'url' => ['index']];
$this->params['breadcrumbs'][] =  Yii::$app->user->identity->nome;;

?>
       
<div class="alunos-model-view">

<div class="box margin-top20">

		<div class="box-body">
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
                                    
                                    <button type="button" class="btn btn-warning col-md-12" data-toggle="modal" data-target="#modal-crop">
                                        <i class="glyphicon glyphicon-picture"></i> Editar Foto
                                   </button>
                                    <br><br>
                                     <?=  Html::a('<i class="glyphicon glyphicon-pencil"></i> Editar Perfil',"/".Yii::$app->controller->id."/atualizar",['class' => 'btn btn-warning isDisabled col-md-12','disabled'=>!Mimin::checkRoute($this->context->id.'/atualizar')]); ?>
           
                                   
                                </div>
                                <br>
                                
                            </div>
                        </div>
                        <div class="col-md-10">
                            
                            
                             <?= DetailView::widget([
            'model' => $model,
            'condensed'=>false,
            'hover'=>true,
            'mode'=>DetailView::MODE_VIEW,
            'buttons1'=>false,
            'fadeDelay'=>1,
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
            ['attribute'=>'lattes', 'displayOnly'=>true, 'visible'=>($model->tipo == 'Professor')],
            ['attribute'=>'pesquisa', 'displayOnly'=>true,'format'=>'raw', 'visible'=>($model->tipo == 'Professor')],
            ['attribute'=>'username', 'displayOnly'=>true],
            ['attribute'=>'email', 'displayOnly'=>true],
      
          
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
                    <?php if($model->tipo == 'Estudante'){ ?>
                    <div class="row">
                        <div class="col-md-12">
                            <?= $this->render('/matricula/_matriculas',['matriculaProvider'=>$matriculaProvider]); ?>
                        </div>
                    </div>
                    <?php } ?>
              

</div>
 </div></div>
                   
    
                 

<!-- Modal -->

         <?= $this->render('_cropfoto', [
		'model' => $modelcrop,
                'fotoAtual' => $model->foto
	]) ?>
      