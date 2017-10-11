<?php

use app\components\Mimin;
use kartik\alert\AlertBlock;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

echo AlertBlock::widget([
            'useSessionFlash' => true,
            'type' => AlertBlock::TYPE_GROWL,
            'delay' => 0,
    
        ]);

/**
 * @var yii\web\View $this
 * @var app\models\Protocolos $model
 */
$this->title = "Visualizar "."Protocolos ";


?>
<div class="protocolos-view">

<div class="box margin-top20">
    
    <h2 class="text-center"><?php     
    echo $projeto->tema
    ?></h2>

		<div class="box-body">
            <?php Pjax::begin(['id' => 'gridData','options'=>[
                'enablePushState' => false,
                'timeout'=>false,
            ]]);
     echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
           [
                    'label' => 'Nº Protocolo',
                    'contentOptions'=>['style'=>'text-align:center'],
                    'value'=>function($data){
                        return $data->numero."/".$data->ano;
                    },
                    'width'=>'140px'],

         [
                    'attribute' => 'projeto_id',
                    'value'=>function($data){
                        return $data->projeto->tema;
                    },
                    'width'=>''],
         
        
         [
                    'attribute' => 'descricao',
                    'width'=>''],
            ['attribute'=>'dta_protocolo',
                'headerOptions'=>['style'=>'text-align:center'],
                'contentOptions'=>['style'=>'text-align:center'],
                'width'=>'50px','format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['date'])) ? Yii::$app->modules['datecontrol']['displaySettings']['date'] : 'd-m-Y H:i:s A']],

            
          ],

        'resizableColumns'=>true,
        'persistResize'=>false,
        'resizeStorageKey'=>Yii::$app->user->id . '-' . date("m"),
        'responsive'=>true,
        'hover'=>true,
        'condensed'=>true,
        'floatHeader'=>false,
        'responsiveWrap'=>true,
        'panelTemplate'=>'{items}',
        'pjax'=>true,
       'export'=>false,
        'pjaxSettings'=>[

             'loadingCssClass'=>'loadingGrid',
             'options'=>[
                  'enablePushState' => false,
                  'timeout'=>false,
            ],
        ],
          'toolbar'=> [
        ['content'=> false   ],
         '{toggleData}',
        '{export}',

        ],

        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
            'type'=>'info',
            'before'=>false,                                                                                                                                                          'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
            'showFooter'=>false
        ],
   
    ]);
    Pjax::end(); ?>
      
                    <?php
                    echo Html::a('<i class="glyphicon glyphicon-plus"></i> Adicionar Protocolo', ['cadastrar','idp'=>$projeto->id], ['data-pjax' => 0,'class' => 'btn btn-warning isDisabled pull-right','disabled'=>!Mimin::checkRoute('protocolos/cadastrar')]);
                    ?>

</div>
 </div></div>
