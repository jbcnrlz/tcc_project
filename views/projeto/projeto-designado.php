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



$this->title = "Projetos Designados";
$this->params['breadcrumbs'][] = Html::decode($this->title);
?>


<div class="projeto-designado">
    
    
    <div class="box">      
        <div class="box-body">
         <?php
                    
                     bigpaulie\fancybox\FancyBoxAsset::register($this);
                     
                     $this->registerJs('$(".word").fancybox({
                                 "type": "iframe"
                            });');
                     ?>
            
    <?php Pjax::begin(['id' => 'gridData','options'=>[
                'enablePushState' => false,
                'timeout'=>false,
            ]]);
     echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
         

                 
             [       'label'=>'Curso',                  
                     'value'=> function($data){
                        return $data->matriculaRa->curso->nome_abreviado;
                     },
                    'width'=>''],
             [
                    'attribute' => 'Aluno',
                    'format'=>'raw',
                    'value'=>function($model){

                        return $model->matriculaRa->estudante->nome."<br><span style='font-size:12px;color:#666'>RA.: ".$model->matricula_ra."</span>";
                          },
                    'width'=>''],
         [  
                    'label'=>'Sobre o Projeto',
                    'format'=>'raw',
                    'attribute' => 'resumo',
                    'value'=>function($data){
                       return "<strong>Tema: </strong> ".$data->tema."<br><strong>Resumo: </strong>".$data->resumo."<br><strong>Palavra Chave: </strong>".$data->palavra_chave;     
                    },
                    
                    
                    'width'=>''],
        
            

            [
                'class' => 'kartik\grid\ActionColumn',
                'template'=>'{visualizar}{aceitar}{recusar}',
                 'dropdown' => false,
                 'vAlign' => 'middle',
                 'width' => '400px',
                 'buttons'=>[
    'visualizar' => function ($url, $model) {
               $url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST'].$model->arquivoProjetoPesquisa->arquivo;
    return "<a href='//docs.google.com/gview?url=".$url."&embedded=true' target='_blank' data-pjax='0' class='word btn btn-sm btn-default'><i class='fa fa-eye'></i> Visualizar Arquivo</a><a href='".$url."' target='_blank' data-pjax='0' class='btn btn-sm btn-warning' download style='margin-left:10px;'><i class='fa fa-download'></i></a>";

                                                                      },

                'aceitar' => function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-ok"></span> Aceitar', ['projeto-designado'], [
                       'title' => 'Aceitar',
                       'data-toggle' => 'tooltip',
                      'data-pjax' => '0',
                       'data-id' => $model->id,
                         'data-acao' =>'aceitar',
                        'data-tema' => $model->tema,
                         'class'=>'btn btn-sm btn-primary designado-conf',
                      'data-method'=>'post'
                    ]);
                },
                        
                        'recusar' => function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-remove"></span> Recusar', ['projeto-designado'], [
                       'title' => 'Recusar',
                       'data-toggle' => 'tooltip',
                      'data-pjax' => '0',
                      'data-id' => $model->id,
                         'data-acao' =>'recusar',
                        'data-tema' => $model->tema,
                      'class'=>'btn btn-sm btn-danger designado-conf',
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
       'export'=>(Mimin::checkRoute($this->context->id.'/exportar'))?'':false,
        'pjaxSettings'=>[

             'loadingCssClass'=>'loadingGrid',
             'options'=>[
                  'enablePushState' => false,
                  'timeout'=>false,
            ],
        ],
          'toolbar'=> [
              
        ['content'=> ' '
        ],
        
        '{export}',

        ],

        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
            'type'=>'info',
            'before'=>"",                                                                                                                                                          'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
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
            'marginTop' =>10,
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

