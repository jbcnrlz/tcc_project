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


$this->title = "Rotas";
$this->params['breadcrumbs'][] = Html::decode($this->title);
?>

<div class="alunos-model-index margin-top20">

    <div class="box">
        <div class="box-body">
            <?php Pjax::begin(['id' => 'gridData']);
            echo GridView::widget([
                'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
                'columns' => [
                    [
                        'class' => '\kartik\grid\CheckboxColumn',
                        'checkboxOptions' => [
                            'class' => 'simple'

                        ],
                        //'pageSummary' => true,
                        'rowSelectedClass' => GridView::TYPE_DANGER,
                    ],

                   
                        ['class' => 'kartik\grid\EditableColumn',
                            'attribute'=>'type',
                         'filter'=>false,   
                         ],
                    ['class' => 'kartik\grid\EditableColumn',
                        'attribute'=>'alias',
                         'filter'=>false,   
                         ],
                    [  'class' => 'kartik\grid\EditableColumn',
                        'attribute'=>'name',
                        
                         'filter'=>false,   
                         ],
		
			[
				'class' => '\kartik\grid\BooleanColumn',
                                'attribute'=>'status',
                                'trueLabel' => 'Ativo', 
                                'falseLabel' => 'Inativo',
				'filter' => [0 => 'Ativo', 1 => 'Inativo'],
				'format' => 'raw',
				'options' => [                                        
					'width' => '110px',
                                    ]   
				],
                                             [
                        'class' => 'kartik\grid\ActionColumn',
                        'template'=>'{view}{update}{del}',
                        'dropdown' => false,
                        'vAlign' => 'middle',
                        'width' => '110px',

                            'buttons'=>[
                                'del' => function ($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id'=>$model->name], [
                                        'title' => 'Excluir',
                                        'disabled'=>!Mimin::checkRoute($this->context->id.'/delete'),
                                        'data-toggle' => 'tooltip',
                                        'data-pjax' => '0',
                                        'data-id' => $model->name,
                                        'class'=>'btn btn-xs btn-danger delete-conf isDisabled',
                                        'data-method'=>'post'
                                    ]);
                                },
                            ],


                          'viewOptions' => ['disabled'=>!Mimin::checkRoute($this->context->id.'/visualizar'),'class'=>'btn btn-xs btn-default isDisabled','title' => 'Visualizar', 'data-toggle' => 'tooltip'],
                         'updateOptions' => ['disabled'=>!Mimin::checkRoute($this->context->id.'/atualizar'),'class'=>'btn btn-xs btn-warning isDisabled','title' => 'Editar', 'data-toggle' => 'tooltip'],
                        'urlCreator' => function ($action, $model, $key, $index) {
                            if ($action === 'view') {
                                $url = '/'.Yii::$app->controller->id.'/visualizar?id='.$model['name'];
                                return $url;
                            }
                            if($action === 'update') {
                                $url = '/'.Yii::$app->controller->id.'/atualizar?id='.$model['name'];
                                return $url;
                            }
                            if($action === 'delete') {
                                $url = '/'.Yii::$app->controller->id.'/delete?id='.$model['name'];
                                return $url;
                            }
                        }

                    ],
                ],

                'resizableColumns'=>true,
                'persistResize'=>false,
                'resizeStorageKey'=>Yii::$app->user->id . '-' . date("m"),
                'responsive'=>true,
                'hover'=>true,
                'condensed'=>true,
                'floatHeader'=>false,
                'responsiveWrap'=>true,
                'panelTemplate'=>' {panelBefore}{items}{summary}<div class="text-center">{pager}</div>',
                'pjax'=>true,
                'pjaxSettings'=>[

                    'loadingCssClass'=>'loadingGrid',
                    'enablePushState' => false,
                    'timeout'=>false,
                ],
                'toolbar'=> [
                    ['content'=>
                        Html::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'button', 'title' => 'Deletar Selecionados ' . $this->title, 'disabled'=>!Mimin::checkRoute($this->context->id.'/delete'), 'class' => 'btn btn-danger isDisabled', 'id' => 'deleteSelected']) . ' ' .
              
                        Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['/'.Yii::$app->controller->id,'r'=>true], ['data-pjax' => 1, 'class' => 'btn btn-default', 'title' => 'Atualizar']). ' '
                    ],
                    '{toggleData}',


                ],

                'panel' => [
                    'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
                    'type'=>'info',
                    'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> Adicionar', ['cadastrar'], ['disabled'=>!Mimin::checkRoute($this->context->id.'/cadastrar'),'data-pjax' => 0,'class' => 'btn btn-warning isDisabled'])."&nbsp".Html::a('<i class="glyphicon glyphicon-plus"></i> Gerar Rotas', ['generate'], ['disabled'=>!Mimin::checkRoute($this->context->id.'/generate'),'data-pjax' => 0,'class' => 'btn btn-default isDisabled']),                                                                                                                                                          'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
                    'showFooter'=>false
                ],

            ]);
            Pjax::end(); ?>
        </div>

    </div> <!--end box -->

</div>
