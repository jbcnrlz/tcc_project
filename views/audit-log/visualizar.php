<?php

use app\components\Mimin;
use kartik\alert\AlertBlock;
use kartik\datecontrol\DateControl;
use kartik\detail\DetailView;
use kdn\yii2\JsonEditor;
use yii\helpers\Html;

echo AlertBlock::widget([
            'useSessionFlash' => true,
            'type' => AlertBlock::TYPE_GROWL,
            'delay' => 0,
    
        ]);

/**
 * @var yii\web\View $this
 * @var app\models\AuditLog $model
 */
$this->title = "Visualizar "."Log de Atividades";
$this->params['breadcrumbs'][] = ['label' => 'Log de Atividades', 'url' => ['index']];
$this->params['breadcrumbs'][] = "Visualizar";

?>
<div class="audit-log-view">

<div class="box margin-top20">

		<div class="box-body">
           

    <?= DetailView::widget([
            'model' => $model,
            'condensed'=>false,
            'hover'=>true,
           
        'attributes' => [
            //['attribute'=>'id', 'displayOnly'=>true] exemplo para não editar
            ['attribute'=>'id',
              'value'=>"#".$model->id
                ],
            'model',
            'acao',
            [
                'attribute'=>'novo',
                'format'=> 'raw',
                'value'=> JsonEditor::widget(
                            [
                                'clientOptions' => ['mode' => 'view'],
                                'expandAll' => ['tree'],
                                'containerOptions' => ['style' => null],
                                'name' => 'viewer',
                                'value' => $model->novo,
                            ]
                        ),
            ],
            [
                'attribute'=>'antigo',
                'format'=> 'raw',
                'value'=> JsonEditor::widget(
                            [
                                'clientOptions' => ['mode' => 'view'],
                                'expandAll' => ['tree'],
                                'containerOptions' => ['style' => null],
                                'name' => 'viewer',
                                'value' => $model->antigo,
                            ]
                        ),
            ],
            
          
            'ip',
            [
                'attribute'=>'data',
                'format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A'],
                'type'=>DetailView::INPUT_WIDGET,
                'widgetOptions'=> [
                    'class'=>DateControl::classname(),
                    'type'=>DateControl::FORMAT_DATETIME
                ]
            ],
            [
                'attribute'=>'user_id',
                'value'=>$model->user->nome
                
            ],
        ],

        'enableEditMode'=>false,
    ]) ?>
    <div class="footer footer-view">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <?=  Html::a('<i class="glyphicon glyphicon-th-list"></i> Lista',"/".Yii::$app->controller->id,['class' => 'btn btn-default isDisabled','disabled'=>!Mimin::checkRoute($this->context->id.'/index')]); ?>
             <?=  Html::a('<i class="glyphicon glyphicon-plus"></i> Adicionar Novo',"/".Yii::$app->controller->id."/cadastrar",['class' => 'btn btn-warning isDisabled','disabled'=>!Mimin::checkRoute($this->context->id.'/cadastrar')]); ?>
             <?=  Html::a('<i class="glyphicon glyphicon-pencil"></i> Editar',"/".Yii::$app->controller->id."/atualizar?id=".$model->id,['class' => 'btn btn-warning isDisabled','disabled'=>!Mimin::checkRoute($this->context->id.'/atualizar'),'data' => [
            'method' => 'post',
            ]]); ?>
      
        </div>
        </div>
    </div> 

</div>
 </div></div>
