<?php

use app\components\Mimin;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

$faseTitulo = "";
if (isset($_GET['ApresentacaoProcurar']['etapa_projeto'])):
    $fase = $_GET['ApresentacaoProcurar']['etapa_projeto'];
    if ($fase == 2) {
        $faseTitulo = "para Qualificação do Projeto";
    }if ($fase == 3) {
        $faseTitulo = "para Defesa do Projeto";
    } else {
        $faseTitulo = "Geral";
    }
endif;
?>
<?php

Pjax::begin(['id' => 'gridApresentacao', 'options' => [
        'enablePushState' => false,
        'timeout' => false,
]]);
echo GridView::widget([
    'dataProvider' => $modelBanca->searchBanca(Yii::$app->request->queryParams),
    'columns' => [
            [
            'attribute' => 'etapa_projeto',
            'hiddenFromExport' => true,
            'value' => function($data) {
                return $data->projeto->matriculaRa->getNomeEtapa($data->etapa_projeto);
            },
            'width' => ''],
            [
            'attribute' => 'projeto_id',
            'format' => 'html',
            'value' => function($data) {
                $html = ($data->projeto->matriculaRa->estudante->sexo == "F") ? "<strong>Aluna: </strong>" : "<strong>Aluno: </strong>" . $data->projeto->matriculaRa->estudante->nome;
                $html .= "<br><strong>Tema:</strong> " . $data->projeto->tema;
                return $html;
            },
            'width' => ''],
            [
            'label' => 'Data/Local',
            'format' => 'html',
            'width' => '',
            'value' => function($data) {
                $html = "<strong>Data:</strong> " . Yii::$app->formatter->asDate($data->dta_apresentacao);
                $html .= "<br><strong>Local:</strong> " . $data->local;
                $html .= "<br><strong>Horário:</strong> " . Yii::$app->formatter->asTime($data->horario, 'short');
                return $html;
            },
        ],
            [
            'label' => 'Banca',
            'format' => 'html',
            'value' => function($data) {
                $html = "<strong>Orientador:</strong> " . $data->orientador->nome;
                $html .= "<br><strong>Convidado:</strong> " . $data->convidadoPrimario->nome;
                $html .= ($data->convidado_secundario_id != "") ? "<br><strong>Convidado:</strong> " . $data->convidadoSecundario->nome : "";

                return $html;
            },
            'width' => ''],
            [
            'attribute' => 'status',
            'contentOptions' => ['class' => 'kv-align-middle text-center'],
            'format' => 'raw',
            'value' => function($data) {
                if ($data->status == 0) {
                    return "<span class='glyphicon glyphicon-remove text-danger size-icone'></span>";
                } else if ($data->status == 1) {
                    return "<span class='glyphicon glyphicon-time text-success size-icone'></span>";
                } else {
                    return "<span class='glyphicon glyphicon-ok text-info size-icone'></span>";
                }
            }
        ],
            [
            'class' => 'kartik\grid\ActionColumn',
            'template' => '{avaliar}{visualizarAvaliacao}{print}{projeto}',
            'dropdown' => false,
            'vAlign' => 'middle',
            'width' => '210px',
            'buttons' => [
                 'projeto' => function ($url, $model) {
                      
                    if($model->convidado_primario_id == Yii::$app->user->id || $model->convidado_secundario_id == Yii::$app->user->id):
                                $arq = \app\models\ArquivosProjeto::find()->where(['projeto_id'=>$model->projeto_id, 'etapa_projeto'=>$model->etapa_projeto])->one();
                               
                    $url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST'].$arq->arquivo;
                    
                    return "<a href='//docs.google.com/gview?url=".$url."&embedded=true' target='_blank' data-pjax='0' class='word btn btn-sm btn-default'><i class='fa fa-eye'></i> Visualizar Arquivo</a><a href='".$url."' target='_blank' data-pjax='0' class='btn btn-sm btn-warning' download style='margin-left:10px;'><i class='fa fa-download'></i></a>";

                       
                    endif;
                },
                        
                'avaliar' => function ($url, $model) {
                      
                    if($model->orientador_id == Yii::$app->user->id):
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span> '.($model->status==1?' Avaliar':' Editar'), ['avaliar?id=' . $model->id], [
                                'title' => ($model->status==1?' Avaliar':' Editar Avaliação'),
                                'data-toggle' => 'tooltip',
                                'disabled' => !Mimin::checkRoute($this->context->id . '/avaliar'),
                                'class' => 'btn btn-sm btn-warning isDisabled',
                                'data' => [
                                    'method' => 'post',
                                ]
                    ]);
                    endif;
                },
               'visualizarAvaliacao' => function ($url, $model) {
                    if($model->status == 2)
                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['visualizar-avaliacao?id=' . $model->id], [
                                'title' => 'Visualizar',
                                'data-toggle' => 'tooltip',
                                'disabled' => !Mimin::checkRoute($this->context->id . '/visualizar-avaliacao'),
                                'class' => 'btn btn-sm btn-primary isDisabled',
                                'data' => [
                                    'method' => 'post',
                                ]
                    ]);
                },
                        
                'print' => function ($url, $model) {
                     if($model->status == 2)
                    return Html::a('<span class="glyphicon glyphicon glyphicon-print"></span>', ['relatorio-avaliacao?id=' . $model->id], [
                                'title' => 'Relatório da Avaliação',
                                'data-toggle' => 'tooltip',
                                'disabled' => !Mimin::checkRoute($this->context->id . '/relatorio-avaliacao'),
                                'class' => 'btn btn-sm btn-default isDisabled',
                                'data' => [
                                    'method' => 'post',
                                ]
                    ]);
                },
            ],
            
            'urlCreator' => function ($action, $model, $key, $index) {
                if ($action === 'view') {
                    $url = '/' . Yii::$app->controller->id . '/visualizar?id=' . $model['id'];
                    return $url;
                }
                if ($action === 'update') {
                    $url = '/' . Yii::$app->controller->id . '/atualizar?id=' . $model['id'];
                    return $url;
                }
            }
        ],
    ],
    'resizableColumns' => true,
    'persistResize' => false,
    'resizeStorageKey' => Yii::$app->user->id . '-' . date("m"),
    'responsive' => true,
    'hover' => true,
    'condensed' => true,
    'floatHeader' => false,
    'responsiveWrap' => true,
    'panelTemplate' => ' {panelBefore}{items}{summary}<div class="text-center">{pager}</div>',
    'pjax' => true,
    'export' => (Mimin::checkRoute($this->context->id . '/exportar')) ? '' : false,
    'pjaxSettings' => [
        'loadingCssClass' => 'loadingGrid',
        'options' => [
            'enablePushState' => false,
            'timeout' => false,
        ],
    ],
    'toolbar' => [
            ['content' =>
            Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['/' . Yii::$app->controller->id . '/' . Yii::$app->controller->action->id, 'r' => true], ['data-pjax' => 1, 'class' => 'btn btn-default', 'title' => 'Atualizar']) . ' '
        ],
        '{toggleData}',
        '{export}',
    ],
    'panel' => [
        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> ' . Html::encode($this->title) . ' </h3>',
        'type' => 'info',
        'before' => "<span class='pull-left' style='font-size:20px; color:#C21D16; font-weight:400'>:: Lista de Projetos Agendados</span>" . $this->render('_filtrar', ['model' => $modelBanca, 'tab' => 'agendado']), 'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['banca'], ['class' => 'btn btn-info']),
        'showFooter' => false
    ],
    'exportConfig' => [
        GridView::PDF => [
            'label' => 'PDF',
            'icon' => ' fa fa-file-pdf-o',
            'iconOptions' => ['class' => 'text-danger'],
            'showHeader' => true,
            'showPageSummary' => true,
            'showFooter' => true,
            'showCaption' => true,
            'filename' => Yii::$app->controller->id . '-registros-pdf',
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
                '.logopdf{text-align:center;}' .
                '.kv-align-left{text-align:left;}' .
                '.kv-align-right{text-align:right;}' .
                '.kv-align-top{vertical-align:top!important;}' .
                '.kv-align-bottom{vertical-align:bottom!important;}' .
                '.kv-align-middle{vertical-align:middle!important;}' .
                '.kv-page-summary{border-top:4px double #ddd;font-weight: bold;}' .
                '.kv-table-footer{border-top:4px double; #ddd;font-weight: bold;}' .
                '.kv-table-caption{font-size:1.5em;padding:8px;border:1px solid #ddd;border-bottom:none;}',
                'methods' => [
                    'SetHeader' => false, //[Yii::$app->params['headerPdf']]
                    'SetFooter' => [date("d/m/Y h:i") . '||{PAGENO}'],
                ],
                'options' => [
                    'title' => Html::decode($this->title),
                    'subject' => Html::decode($this->title) . " " . $faseTitulo,
                    'keywords' => 'pdf',
                ],
                'contentBefore' => "<div class='text-center'><img src='/imagem/cabecalho-relatorio.png'><h4>Lista de " . Html::decode($this->title) . " " . $faseTitulo . "</h4></div>", //Yii::$app->params['headerBottomPdf'],
                'contentAfter' => "", //Yii::$app->params['contentAfter']
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
            'filename' => Yii::$app->controller->id . '-registros-xls',
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
            'filename' => Yii::$app->controller->id . '-registros-txt',
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
            'filename' => Yii::$app->controller->id . '-registros-csv',
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
Pjax::end();
?>