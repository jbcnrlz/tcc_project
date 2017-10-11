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


$this->title = "Permissões";
$this->params['breadcrumbs'][] = Html::decode($this->title);
$btnRota = (Mimin::checkRoute('/rotas/'))? Html::a('<i class="fa fa-sitemap"></i> Rotas', ['/rotas/'], ['data-pjax' => 0,'class' => 'btn btn-default']):'';
?>

<div class="alunos-model-index margin-top20">

    <div class="box">
        <div class="box-body">
            <?php Pjax::begin(['id' => 'gridData']);
            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'class' => '\kartik\grid\CheckboxColumn',
                        'checkboxOptions' => [
                            'class' => 'simple'

                        ],
                        //'pageSummary' => true,
                        'rowSelectedClass' => GridView::TYPE_DANGER,
                    ],

                    [
                        'attribute' => 'name',
                         
                        'width'=>'300px'],
                     [
                        'attribute' => 'description',
                        'width'=>''],
                    [
                        'class' => 'kartik\grid\ActionColumn',
                        'template'=>'{permissao}{update}{del}',
                        'dropdown' => false,
                        'vAlign' => 'middle',
                        'width' => '110px',
                        'visibleButtons' => [
//                                 'permissao' => function ($model, $key, $index) {
//                                    return ($model->name === "Aluno" || $model->name === "Professor" || $model->name === "Super Administrador") ? false : true;
//                                 },
                                 'update' => function ($model, $key, $index) {
                                    return ($model->name === "Aluno" || $model->name === "Professor" || $model->name === "Super Administrador") ? false : true;
                                 },
                                 'del' => function ($model, $key, $index) {
                                    return ($model->name === "Aluno" || $model->name === "Professor" || $model->name === "Super Administrador") ? false : true;
                                 }
                            ],
                            'buttons'=>[
                                'del' => function ($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id'=>$model->name], [
                                        'title' => 'Excluir',
                                        'data-toggle' => 'tooltip',
                                        'data-pjax' => '0',
                                        'data-id' => $model->name,
                                        'class'=>'btn btn-xs btn-danger delete-conf',
                                        'data-method'=>'post',
                                       
                                    ]);
                                },
                                        
                                'permissao' => function ($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-lock"></span>', ['visualizar', 'id'=>$model->name], [
                                        'title' => 'Permissões',
                                        'data-toggle' => 'tooltip',
                                        'data-pjax' => '0',
                                        'data-id' => $model->name,
                                        'class'=>'btn btn-xs btn-default',
                                        'data-method'=>'post'
                                    ]);
                                },
                            ],


                        'viewOptions' => ['class'=>'btn btn-xs btn-default','title' => 'Visualizar', 'data-toggle' => 'tooltip'],
                        'updateOptions' => ['class'=>'btn btn-xs btn-warning','title' => 'Editar', 'data-toggle' => 'tooltip'],
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
                        Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['/'.Yii::$app->controller->id,'r'=>true], ['data-pjax' => 1, 'class' => 'btn btn-default', 'title' => 'Atualizar']).' '.$btnRota
                    ],
                    '{toggleData}',


                ],

                'panel' => [
                    'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
                    'type'=>'info',
                    'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> Adicionar', ['cadastrar'], ['data-pjax' => 0,'class' => 'btn btn-warning']),                                                                                                                                                          'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
                    'showFooter'=>false
                ],

            ]);
            Pjax::end(); ?>
        </div>

    </div> <!--end box -->

</div>


