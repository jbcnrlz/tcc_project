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



$this->title = "Usuários";
$this->params['breadcrumbs'][] = Html::decode($this->title);
?>


<div class="alunos-model-index">
 
    <div class="box">      
        <div class="box-body">
    <?php Pjax::begin(['id' => 'gridData','options'=>[
                'enablePushState' => false,
                'timeout'=>false,
            ]]);
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
               'label' => '',
               'attribute'=>'foto',
              
               'format'=>'raw',
               'options' => [
					'width' => '20px',
                                    
				],
               'value'=>function($data){
                    return Html::img('/upload/avatarPerfil/'.(($data->foto != '')?$data->foto:'SemImagem.jpg'),['class'=>'user-image','width'=>'50','height'=>'50']);
               }
           ],
                        
                         ['attribute'=>'nome',
                           
                           'contentOptions'=>['class'=>'kv-align-middle']
                            
                            ],
			
			 ['attribute'=>'email',
                           'contentOptions'=>['class'=>'kv-align-middle']
                            
                            ],
			[
				'attribute' => 'roles',
                                'label'=>'Permissões',
				'format' => 'raw',
                             'contentOptions'=>['class'=>'kv-align-middle'],
				'value' => function ($data) {
					$roles = [];
					foreach ($data->roles as $role) {
						$roles[] = $role->item_name;
					}
					return Html::a(implode(', ', $roles), ['visualizar', 'id' => $data->id]);
				}
			],
           [
             'attribute'=>'status',
             'contentOptions'=>['class'=>'kv-align-middle text-center'],
             'format'=>'raw',
             'value'=>function($data){
                       if($data->status == 0){
                         return "<span class='glyphicon glyphicon-ban text-danger size-icone' data-toggle='tooltip' data-original-title='Cancelado'></span>";
                       }else if($data->status == 1){
                           return "<span class='glyphicon glyphicon-ok text-success size-icone' data-toggle='tooltip' data-original-title='Ativado'></span>"; 
                       }else{
                           return "<span class='glyphicon glyphicon-time text-info size-icone' data-toggle='tooltip' data-original-title='Aguardando Ativação'></span>"; 
                       }
             }
            
            ],
             [
				'attribute' => 'dta_cadastro',
                            ///      'format' => ['date', 'php:d M Y H:i:s'],
                    'contentOptions'=>['class'=>'kv-align-middle'],
				'format' => ['date'],
				'options' => [
					'width' => '120px',
				],
			],
			

            [
                'class' => 'kartik\grid\ActionColumn',
                'template'=>'{view}{update}{del}',
                 'dropdown' => false,
                 'vAlign' => 'middle',
                  'width' => '110px',
                'viewOptions' => ['disabled'=>!Mimin::checkRoute($this->context->id.'/visualizar'),'class'=>'btn btn-xs btn-default isDisabled','title' => 'Visualizar', 'data-toggle' => 'tooltip'],
                'updateOptions' => ['disabled'=>!Mimin::checkRoute($this->context->id.'/atualizar'),'class'=>'btn btn-xs btn-warning isDisabled','title' => 'Editar', 'data-toggle' => 'tooltip'],
                'buttons'=>[
    'view' => function ($url, $model) {
    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['visualizar?id='.$model->id], [
                                                                      'title' => 'Visualizar',
                                                                      'data-toggle' => 'tooltip',
                                                                      'disabled'=>!Mimin::checkRoute($this->context->id.'/visualizar'),
                                                                      'class'=>'btn btn-xs btn-default isDisabled',
                                                                      'data'=>[
                                                                      'method'=>'post',
                                                                      ]
                                                                      ]);

                                                                      },

                                                                      'update' => function ($url, $model) {
                                                                      return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['atualizar?id=' . $model->id], [
                                                                                                                                      'title' => 'Atualizar',
                                                                                                                                      'data-toggle' => 'tooltip',
                                                                                                                                      'disabled' => !Mimin::checkRoute($this->context->id . '/atualizar'),
                                                                                                                                      'class' => 'btn btn-xs btn-warning isDisabled',
                                                                                                                                      'data' => [
                                                                                                                                      'method' => 'post',
                                                                                                                                      ]
                                                                                                                                      ]);

                                                                                                                                      },
                'del' => function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id'=>$model->id], [
                       'title' => 'Excluir',
                       'data-toggle' => 'tooltip',
                      'data-pjax' => '0',
                     'data-id' => $model->id,
                      'disabled'=>!Mimin::checkRoute($this->context->id.'/delete'),
                      'class'=>'btn btn-xs btn-danger delete-conf isDisabled',
                      'data-method'=>'post'
                    ]);
                },
                ],
               'urlCreator' => function ($action, $model, $key, $index) {
                        if ($action === 'view') {
                           $url = '/'.Yii::$app->controller->id.'/visualizar?id='.$model['id'];
                           return $url;
                        }
                        if($action === 'update') {
                           $url = '/'.Yii::$app->controller->id.'/atualizar?id='.$model['id'];
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
        'panelTemplate'=>' {panelBefore}{items}{summary}<div class="text-center">{pager}</div>',
        'pjax'=>true,
       'export'=>(Mimin::checkRoute($this->context->id.'/exportar'))?'':false,
        'pjaxSettings'=>[

             'loadingCssClass'=>'loadingGrid',
             'options'=>[
                  'enablePushState' => false,
                  'timeout'=>false,
            ],
        ],
          'toolbar'=> [
        ['content'=> 
                    Html::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'button', 'title' => 'Deletar Selecionados ' . $this->title, 'disabled'=>!Mimin::checkRoute($this->context->id.'/delete'), 'class' => 'btn btn-danger', 'id' => 'deleteSelected']) . ' ' .
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['/'.Yii::$app->controller->id,'r'=>true], ['data-pjax' => 1, 'class' => 'btn btn-default', 'title' => 'Atualizar']). ' '
        ],
         '{toggleData}',
        '{export}',

        ],

        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
            'type'=>'info',
            'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> Adicionar', ['cadastrar'], ['data-pjax' => 0,'class' => 'btn btn-warning isDisabled','disabled'=>!Mimin::checkRoute($this->context->id.'/cadastrar')]),                                                                                                                                                          'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
            'showFooter'=>false
        ],
    'exportConfig'=> [

        GridView::PDF => [
            'label' => 'PDF',
            'icon' => ' fa fa-file-pdf-o',
            'iconOptions' => ['class' => 'text-danger'],
            'showHeader' => true,
            'showPageSummary' => true,
            'showFooter' => true,
            'showCaption' => true,
            'filename' => Yii::$app->controller->id.'-registros-pdf',
            'alertMsg' => 'O arquivo de exportação PDF será gerado para download.',
            'options' => ['title' => 'Portable Document Format'],
            'mime' => 'application/pdf',
            'config' => [
            'mode' => 'c',
            'format' => 'A4-L',
            'destination' => 'D',
            'marginTop' => 20,
            'marginBottom' => 20,
            'cssInline' => '.kv-wrap{padding:20px;}' .
            '.kv-align-center{text-align:center;}' .
            '.logopdf{text-align:center;}'.
            '.kv-align-left{text-align:left;}' .
            '.kv-align-right{text-align:right;}' .
            '.kv-align-top{vertical-align:top!important;}' .
            '.kv-align-bottom{vertical-align:bottom!important;}' .
            '.kv-align-middle{vertical-align:middle!important;}' .
            '.kv-page-summary{border-top:4px double #ddd;font-weight: bold;}' .
            '.kv-table-footer{border-top:4px double; #ddd;font-weight: bold;}' .
            '.kv-table-caption{font-size:1.5em;padding:8px;border:1px solid #ddd;border-bottom:none;}',
            'methods' => [
            'SetHeader' => false,//[Yii::$app->params['headerPdf']]
            'SetFooter' => [date("d/m/Y h:i").'||{PAGENO}'],
            ],
            'options' => [
            'title' => Html::decode($this->title),
            'subject' => 'Lista de '.Html::decode($this->title),
            'keywords' => 'pdf',
            ],
            'contentBefore'=>"<div class='text-center'><img src='/imagem/cabecalho-relatorio.png'><h4>Lista de ".Html::decode($this->title)."</h4></div>",//Yii::$app->params['headerBottomPdf'],
            'contentAfter'=>"",//Yii::$app->params['contentAfter']
            ]
        ],
        GridView::EXCEL => [
            'label' => 'Excel',
            'icon' => ' fa fa-file-excel-o',
            'iconOptions' => ['class' => 'text-success'],
            'showHeader' => true,
            'showPageSummary' => true,
            'showFooter' => true,
            'showCaption' => true,
            'filename' => Yii::$app->controller->id.'-registros-xls',
            'alertMsg' => 'O arquivo de exportação EXCEL será gerado para download.',
            'options' => ['title' => 'Microsoft Excel'],
            'mime' => 'application/vnd.ms-excel',
            'config' => [
            'worksheet' => 'Folha de trabalho de exportação',
            'cssFile' => ''
            ]
        ],

        GridView::TEXT => [
            'label' => 'Texto',
            'icon' => ' fa fa-file-text-o',
            'iconOptions' => ['class' => 'text-muted'],
            'showHeader' => true,
            'showPageSummary' => true,
            'showFooter' => true,
            'showCaption' => true,
            'filename' => Yii::$app->controller->id.'-registros-txt',
            'alertMsg' => 'O arquivo de exportação TEXTO será gerado para download.',
            'options' => ['title' => 'Texto delimitado por tabulação'],
            'mime' => 'text/plain',
            'config' => [
            'colDelimiter' => "\t",
            'rowDelimiter' => "\r\n",
            ]
        ],

        GridView::CSV => [
            'label' => 'CSV',
            'icon' => ' fa fa-file-code-o',
            'iconOptions' => ['class' => 'text-primary'],
            'showHeader' => true,
            'showPageSummary' => true,
            'showFooter' => true,
            'showCaption' => true,
            'filename' => Yii::$app->controller->id.'-registros-csv',
            'alertMsg' => 'O arquivo de exportação CSV será gerado para download.',
            'options' => ['title' => 'Comma Separated Values'],
            'mime' => 'application/csv',
            'config' => [
            'colDelimiter' => ",",
            'rowDelimiter' => "\r\n",
            ]
        ],

    ],
    ]);
    Pjax::end(); ?>
    </div>

    </div> <!--end box -->

</div>



