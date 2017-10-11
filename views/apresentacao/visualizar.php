<?php

use app\components\Mimin;
use kartik\alert\AlertBlock;
use kartik\datecontrol\DateControl;
use kartik\detail\DetailView;
use yii\helpers\Html;


echo AlertBlock::widget([
            'useSessionFlash' => true,
            'type' => AlertBlock::TYPE_GROWL,
            'delay' => 0,
    
        ]);

/**
 * @var yii\web\View $this
 * @var app\models\Apresentacao $model
 */
$this->title = "Visualizar "."Agenda de Apresentação";
$this->params['breadcrumbs'][] = ['label' => 'Agenda de Apresentação', 'url' => ['index']];
$this->params['breadcrumbs'][] = "Visualizar";

?>
<div class="apresentacao-view">

<div class="box margin-top20">

		<div class="box-body">
            <?php             $button1 = null;
            if(Mimin::checkRoute($this->context->id.'/atualizar')){
                $button1 = '{update}';
            }
            if(Mimin::checkRoute($this->context->id.'/delete')){
                $button1 =  $button1.'{delete}';
            }
            
            $etapa_projeto = $model->etapa_projeto;
            ?>

    <?= DetailView::widget([
            'model' => $model,
            'condensed'=>false,
            'hover'=>true,
            'mode'=>Yii::$app->request->get('edit')=='t' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
            'buttons1'=>$button1,
            'fadeDelay'=>1,
           
            'updateOptions'=>['label'=>'<button type="button" class="kv-action-btn kv-btn-update" title="" data-toggle="tooltip" data-container="body" data-original-title="Edição Rápida"><i class="glyphicon glyphicon-pencil"></i></button>'],
            
        'attributes' => [
             
              [
                'attribute'=>'etapa_projeto',
                
                'value'=>$model->projeto->matriculaRa->getNomeEtapa($model->etapa_projeto)
                
            ],
            [
                'attribute'=>'projeto_id',
                'value'=>$model->projeto->tema
                
            ],
            [
                'attribute'=>'curso_id',
                'value'=>$model->projeto->matriculaRa->curso->nome
                
            ],
            [
                'attribute'=>'dta_apresentacao',
                'format'=>['date',(isset(Yii::$app->modules['datecontrol']['displaySettings']['date'])) ? Yii::$app->modules['datecontrol']['displaySettings']['date'] : 'd-m-Y'],
                'type'=>DetailView::INPUT_WIDGET,
                'widgetOptions'=> [
                    'class'=>DateControl::classname(),
                    'type'=>DateControl::FORMAT_DATE
                ]
            ],
                'local',
            [
                'attribute'=>'horario',
                'value'=>Yii::$app->formatter->asTime($model->horario,'short')                
            ],
        
           
            
             
            [
                'attribute'=>'orientador_id',
                'value'=>$model->orientador->nome
                
            ],
            [
                'attribute'=>'convidado_primario_id',
                'value'=>$model->convidadoPrimario->nome
                
            ],
            [
                'attribute'=>'convidado_secundario_id',
                'value'=>($model->etapa_projeto == 3 && $model->convidado_secundario_id != "")? $model->convidadoSecundario->nome:'',
                'visible'=>($model->etapa_projeto == 3 && $model->convidado_secundario_id != "")?true:false
                
            ],
            [
                'attribute'=>'resultado_aprovacao',
                'value'=>($model->etapa_projeto == 3 && $model->resultado_aprovacao != "")? $model->opcaoAprovacao[$model->resultado_aprovacao]:'',
                'visible'=>($model->etapa_projeto == 3 && $model->resultado_aprovacao != "")?true:false
                
            ],
            [
                'attribute'=>'dta_versao_final',
             
                'visible'=>($model->etapa_projeto == 3 && $model->dta_versao_final!="")?true:false
                
            ],
           
           
            
            [
               'attribute'=>'status', 
               'format'=>'raw',
               'value'=>$model->status ? '<span class="label label-success">Ativo</span>' : '<span class="label label-danger">Inativo</span>',
               'type'=>DetailView::INPUT_SWITCH,
               'widgetOptions' => [
                   'pluginOptions' => [
                       'size' => 'mini',
                       'onText' => 'Ativo',
                       'offText' => 'Inativo',
                   ]
               ],
               ],
           
        ],

        'enableEditMode'=>false,
    ]) ?>
    <div class="footer footer-view">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <?=  Html::a('<i class="glyphicon glyphicon-th-list"></i> Lista',"/".Yii::$app->controller->id,['class' => 'btn btn-default isDisabled','disabled'=>!Mimin::checkRoute($this->context->id.'/index')]); ?>
             <?=  Html::a('<i class="glyphicon glyphicon-pencil"></i> Editar',"/".Yii::$app->controller->id."/atualizar?id=".$model->id,['class' => 'btn btn-warning isDisabled','disabled'=>!Mimin::checkRoute($this->context->id.'/atualizar'),'data' => [
            'method' => 'post',
            ]]); ?>
      
        </div>
        </div>
    </div> 

</div>
 </div></div>
