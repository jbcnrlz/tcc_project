<?php
use app\components\Mimin;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

?>
 <?php
                    
                     bigpaulie\fancybox\FancyBoxAsset::register($this);
                     
                     $this->registerJs('$(".word").fancybox({
                                 "type": "iframe"
                            });');
                     ?>
 <?php Pjax::begin(['id' => 'gridDataPendente','options'=>[
                'enablePushState' => false,
                'timeout'=>false,
            ]]);
     echo GridView::widget([
        'dataProvider' => $modelProjetosAprovados->searchProjetosAprovados(Yii::$app->request->queryParams),
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
                       return "<strong>Tema: </strong> ".$data->tema."<br><strong>Resumo: </strong>".$data->resumo."<br><strong>Palavra Chave: </strong>".$data->palavra_chave
                               ."<br><strong class='text-info'>Orientador: </strong>"
                               .$data->orientador->nome;     
                    },
                    
                    
                    'width'=>''],
        
            

            [
                'class' => 'kartik\grid\ActionColumn',
                'template'=>'{agendar}{visualizar}',
                 'dropdown' => false,
                 'vAlign' => 'middle',
                 'width' => '200px',
                 'buttons'=>[
    'visualizar' => function ($url, $model) {
                            $arq = \app\models\ArquivosProjeto::find()->where(['projeto_id'=>$model->id, 'etapa_projeto'=>$model->matriculaRa->etapa_projeto])->one();
                   
               $url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST'].$arq->arquivo;
    return "<a href='//docs.google.com/gview?url=".$url."&embedded=true' target='_blank' data-pjax='0' class='word btn btn-sm btn-default'><i class='fa fa-eye'></i> Visualizar Arquivo</a>";

                                                                      },

                
                        
                 'agendar' => function ($url, $model) {
    return Html::a('<span class="fa fa-calendar"></span>', ['cadastrar?id='.$model->id], [
                                                                      'title' => 'Agendar',
                                                                      'data-toggle' => 'tooltip',
                                                                      'disabled'=>!Mimin::checkRoute($this->context->id.'/visualizar'),
                                                                      'class'=>'btn btn-sm btn-info isDisabled',
                                                                     'data-pjax' => '0',
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
                            ['content'=> 
                                        Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['/'.Yii::$app->controller->id,'r'=>true], ['data-pjax' => 1, 'class' => 'btn btn-default', 'title' => 'Atualizar']). ' '
                            ],
                             '{toggleData}',
                            '{export}',

                            ],

        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
            'type'=>'info',
            'before'=>"<span class='pull-left' style='font-size:20px; color:#C21D16; font-weight:400'>:: Lista de Projetos Aprovados para Agendar</span>".$this->render('_filtrar',['model'=>$modelProjetosAprovados,'tab'=>'pendente']),                                                                                                                                                          'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
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


