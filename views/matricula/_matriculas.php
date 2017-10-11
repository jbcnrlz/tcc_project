<?php
use app\components\Mimin;
use kartik\grid\GridView;
use lo\widgets\modal\ModalAjax;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

?>
<div class="box-header with-border">
              <i class="fa fa-mortar-board"></i>
              <h3 class="box-title">Cursos Matriculados</h3>
<?php  if(Yii::$app->controller->id == 'perfil'): ?>

              
</div>

<?php Pjax::begin(['id' => 'gridDataMatricula','options'=>[
                'enablePushState' => false,
                'timeout'=>true,
            ]]);
     echo GridView::widget([
        'dataProvider' => $matriculaProvider,
        'emptyText'=>'<div class="text-center">Nenhuma matrícula cadastrada para este estudante</div>',
        'columns' => [
            [
                    'attribute' => 'ra',
                    'headerOptions'=>['class'=>'text-center'],
                    'contentOptions'=>['class'=>'kv-align-middle text-center'],
                    'width'=>''],
            [
                    'attribute' => 'curso_id',
                    'value'=>function($data){
                        return $data->curso->nome;
                    },
                    'width'=>''],
                    [
                    'attribute' => 'periodo',
                    'headerOptions'=>['class'=>'text-center'],
                    'contentOptions'=>['class'=>'kv-align-middle text-center'],
                    'width'=>''],
                            
                                            [
                    'attribute' => 'etapa_projeto',
                    'value'=>function($data){
                        return $data->nomeetapa;    
                    },
                    'headerOptions'=>['class'=>'text-center'],
                    'contentOptions'=>['class'=>'kv-align-middle text-center'],
                    'width'=>''],
                            
                              [
                    'attribute' => 'termo',
                    'value'=>function($data){
                        return $data->nometermo;    
                    },
                    'headerOptions'=>['class'=>'text-center'],
                    'contentOptions'=>['class'=>'kv-align-middle text-center'],
                    'width'=>''],
                            

         
       
         
       
           ['class' => '\kartik\grid\BooleanColumn',
             'attribute'=>'status',
             'trueLabel' => 'Ativo', 
             'falseLabel' => 'Inativo'
            
            ],

            
          ],

        'resizableColumns'=>false,
        'persistResize'=>false,
        'resizeStorageKey'=>Yii::$app->user->id . '-' . date("m"),
        'responsive'=>false,
        'hover'=>true,
        'condensed'=>true,
        'floatHeader'=>false,
        'responsiveWrap'=>true,
        'panelTemplate'=>'{items}',
        'pjax'=>false,
       'export'=>false,
        
          'toolbar'=> [
        
         '{toggleData}',
        '{export}',

        ],

        'panel' => [
             'showFooter'=>false
        ],
    
   
    ]);
    Pjax::end(); ?>
<div class="alert alert-warning text-center" style="line-height: 30px;"><i class="fa fa-info-circle fa-2x pull-left"></i>Caso tenha alguma divergência nos dados da <strong>matrícula</strong>, pedimos que comunique a <strong>secretária educacional</strong> para efetuar a atualização.</div>

<?php else: ?>


              <?php
                          
                         
                          
                            echo ModalAjax::widget([
                                'id' => 'novaMatricula',
                                'header' => 'Cadastrar Matrícula',
                                'toggleButton' => [
                                    'label' => '<i class="glyphicon glyphicon-plus"></i> Matrícula',
                                    'class' => 'btn btn-warning pull-right',
                                    'disabled'=>!Mimin::checkRoute('/matricula/cadastrar'),
                                ],
                                'url' => Url::to(['/matricula/cadastrar','id'=>$_GET['id']]), // Ajax view with form to load
                                'ajaxSubmit' => true, // Submit the contained form as ajax, true by default
                                'options' => ['class' => 'header-primary'],
                                'autoClose' => true,
                                'pjaxContainer' => '#gridDataMatricula',

                            ]);
                          
                          ?>
</div>

<?php Pjax::begin(['id' => 'gridDataMatricula','options'=>[
                'enablePushState' => false,
                'timeout'=>true,
            ]]);
     echo GridView::widget([
        'dataProvider' => $matriculaProvider,
        'emptyText'=>'<div class="text-center">Nenhuma matrícula cadastrada para este estudante</div>',
        'columns' => [
            [
                    'attribute' => 'ra',
                    'headerOptions'=>['class'=>'text-center'],
                    'contentOptions'=>['class'=>'kv-align-middle text-center'],
                    'width'=>''],
            [
                    'attribute' => 'curso_id',
                    'value'=>function($data){
                        return $data->curso->nome;
                    },
                    'width'=>''],
                    [
                    'attribute' => 'periodo',
                    'headerOptions'=>['class'=>'text-center'],
                    'contentOptions'=>['class'=>'kv-align-middle text-center'],
                    'width'=>''],
                            
                                            [
                    'attribute' => 'etapa_projeto',
                    'value'=>function($data){
                        return $data->nomeetapa;    
                    },
                    'headerOptions'=>['class'=>'text-center'],
                    'contentOptions'=>['class'=>'kv-align-middle text-center'],
                    'width'=>''],
                            
                              [
                    'attribute' => 'termo',
                    'value'=>function($data){
                        return $data->nometermo;    
                    },
                    'headerOptions'=>['class'=>'text-center'],
                    'contentOptions'=>['class'=>'kv-align-middle text-center'],
                    'width'=>''],
                            

         
       
         
       
           ['class' => '\kartik\grid\BooleanColumn',
             'attribute'=>'status',
             'trueLabel' => 'Ativo', 
             'falseLabel' => 'Inativo'
            
            ],

            [
                'class' => 'kartik\grid\ActionColumn',
                'template'=>'{update}{del}',
                 'dropdown' => false,
                 'vAlign' => 'middle',
                  'width' => '100px',
                 'buttons'=>[    
                'update'=> function($url, $model){
                  
                       return ModalAjax::widget([
                                'id' => $model->ra,
                                'header' => 'Editar Matrícula',
                                'toggleButton' => [
                                    'label' => '<span class="glyphicon glyphicon-pencil"></span>',
                                    'class' => 'btn btn-warning btn-xs isDisabled',
                                    'disabled'=>!Mimin::checkRoute('/matricula/atualizar'),
                                ],
                                'url' => Url::to(['/matricula/atualizar','id'=>$model->ra]), // Ajax view with form to load
                                'ajaxSubmit' => true, // Submit the contained form as ajax, true by default

                                'options' => ['class' => 'header-primary'],
                                'autoClose' => true,
                                'pjaxContainer' => '#gridDataMatricula',

                            ]);
                },
                'del' => function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-trash"></span>', false, [
                       'title' => 'Excluir',
                       'data-toggle' => 'tooltip',
                       'data-pjax' => 1,
                       'delete-url' => '/matricula/delete?id='.$model->ra,
                       'pjax-container' => 'gridDataMatricula',
                       'delete-msg-reg' => "<strong><br>".$model->ra." - ".$model->curso->nome."</strong>",
                      'data-id' => $model->ra,
                      'disabled'=>!Mimin::checkRoute('/matricula/delete'),
                      'class'=>'btn btn-xs btn-danger ajaxDelete isDisabled',
                      'data-method'=>'post'
                    ]);
                },
                ],
                        
               'urlCreator' => function ($action, $model, $key, $index) {
                      
                        if($action === 'update') {
                           $url = '/matricula/atualizar?ra='.$model['ra'];
                           return $url;
                        }

                }
               
            ],
          ],

        'resizableColumns'=>false,
        'persistResize'=>false,
        'resizeStorageKey'=>Yii::$app->user->id . '-' . date("m"),
        'responsive'=>false,
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
        
         '{toggleData}',
        '{export}',

        ],

        'panel' => [
             'showFooter'=>false
        ],
    
   
    ]);
    Pjax::end(); ?>

<?php endif; ?>

