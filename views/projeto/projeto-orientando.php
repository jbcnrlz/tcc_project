<?php
use app\components\Mimin;
use kartik\alert\AlertBlock;
use kartik\grid\GridView;
use lo\widgets\modal\ModalAjax;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;


echo AlertBlock::widget([
'useSessionFlash' => true,
'type' => AlertBlock::TYPE_GROWL,
'delay' => 0,

]);



$this->title = "Projetos Orientando";
$this->params['breadcrumbs'][] = Html::decode($this->title);
?>


<div class="projeto-orientando">
    
    
    <div class="box">      
        <div class="box-body">
           <?php
       $matricula = new app\models\Matricula();
           $curso = \app\models\Curso::find()->all();
           $listaEtapa = $matricula->etapas;
           $optionEtapa = '<option value=""></option>';
           foreach ($listaEtapa as $key => $valor){
               $selected = (@$_POST['filtro']['etapa']==$key)?'selected':'';
               $optionEtapa .=  '<option value="'.$key.'" '.$selected.'>'.$valor.'</option>';
           }
           $listaPeriodo = $matricula->periodos;
           $optionPeriodo = '<option value=""></option>';
           foreach ($listaPeriodo as $key => $valor){
               $selected = (@$_POST['filtro']['periodo']==$key)?'selected':'';
               $optionPeriodo .=  '<option value="'.$key.'" '.$selected.'>'.$valor.'</option>';
           }
           $optionCurso = '<option value=""></option>';
           foreach ($curso as $cur){
               $selected = (@$_POST['filtro']['curso']==$cur->id)?'selected':'';
               $optionCurso .=  '<option value="'.$cur->id.'" '.$selected.'>'.$cur->nome.'</option>';
           }
           $listaStatus = ['1'=>'Em Processo','2'=>'Concluido','3'=>'Cancelado'];
           $optionStatus = '<option value=""></option>';
            foreach ($listaStatus as $key => $valor){
               $selected = (@$_POST['filtro']['status']==$key)?'selected':'';
               $optionStatus .=  '<option value="'.$key.'" '.$selected.'>'.$valor.'</option>';
           }
           
           
           
$botaoFiltro = '
                 <div class="clear-fix"></div>
                 <div class="filtro" style="margin-right:10px; margin-top:60px;">
                 
                <form name="filtroGrid" action="/projeto/projeto-orientando" class="form-stylo" method="post">
                <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
            <div class="col-md-3" style="padding-left:0px">
            <label>Etapa do Projeto</label>
        <select id="filtro-etapa" class="form-control" name="filtro[etapa]" aria-required="true" aria-invalid="true">
                   '.$optionEtapa.'
                    </select></div><div class="col-md-4" style="padding-left:0px">
                    <label>Curso</label>
        <select id="filtro-curso" class="form-control" name="filtro[curso]" aria-required="true" aria-invalid="true">
                    '.$optionCurso.'
        </select></div>
        <div class="col-md-2" style="padding-left:0px">
        <label>Período</label>
        <select id="filtro-periodo" class="form-control" name="filtro[periodo]" aria-required="true" aria-invalid="true">
                   '.$optionPeriodo.'
        </select></div>
        <div class="col-md-2" style="padding-left:0px">
        <label>Status</label>
        <select id="filtro-status" class="form-control" name="filtro[status]" aria-required="true" aria-invalid="true">
                    '.$optionStatus.'              
        </select></div>
                    <div class="col-md-1" style="padding-left:0px">
                    
       <button type="submit" class="btn btn-default " style="margin-top:27px;"><i class="glyphicon glyphicon-filter"></i>&nbspFiltrar</button>
                    </div>
       </form></div>'; ?>
            
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
                    'label' => 'Protocolos',
                    'format'=>'raw',
                    'value'=>function($data){
                          return ModalAjax::widget([
                                'id' => $data->id,
                                'size'=>'modal-lg',
                                'header' => 'Protocolos do Projeto',
                                'toggleButton' => [
                                    'label' => '<span class="glyphicon glyphicon-tags"></span>&nbsp&nbsp&nbsp'.count($data->protocolos),
                                    'class' => 'btn btn-default btn-xs isDisabled',
                                    'disabled'=>!Mimin::checkRoute('/protocolos/visualizar-protocolos'),
                                ],
                                'url' => Url::to(['/protocolos/visualizar-protocolos','id'=>$data->id]), // Ajax view with form to load
                                'ajaxSubmit' => 0, // Submit the contained form as ajax, true by default
                                'options' => ['class' => 'header-primary'],
                                'autoClose' => true
                              

                            ]);
                          
                        
                    },
                    'width'=>'100px'],
            
             [       'label'=>'Curso',                  
                     'value'=> function($data){
                        return $data->matriculaRa->curso->nome_abreviado;
                     },
                    'width'=>'150px'],
            [
                    'attribute' => 'Aluno',
                    'format'=>'raw',
                    'value'=>function($model){

                        return $model->matriculaRa->estudante->nome."<br><span style='font-size:12px;color:#666'>RA.: ".$model->matricula_ra."</span>";
                          },
                    'width'=>''],
         [
                    'attribute' => 'tema',
                    'width'=>''],
        
         
           

            [
                'class' => 'kartik\grid\ActionColumn',
                'template'=>'{view}{update}{del}',
                 'dropdown' => false,
                 'vAlign' => 'middle',
                  'width' => '120px',
                'viewOptions' => ['disabled'=>!Mimin::checkRoute($this->context->id.'/visualizar'),'class'=>'btn btn-xs btn-default isDisabled','title' => 'Visualizar', 'data-toggle' => 'tooltip'],
                'updateOptions' => ['disabled'=>!Mimin::checkRoute($this->context->id.'/visualizar'),'class'=>'btn btn-xs btn-warning isDisabled','title' => 'Editar', 'data-toggle' => 'tooltip'],
                'buttons'=>[
    'view' => function ($url, $model) {
    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['visualizar?id='.$model->id], [
                                                                      'title' => 'Visualizar',
                                                                      'data-toggle' => 'tooltip',
                                                                      'disabled'=>!Mimin::checkRoute($this->context->id.'/visualizar'),
                                                                      'class'=>'btn btn-xs btn-default isDisabled',
                                                                      'data-pjax' => '0',
                                                                      ]);

                                                                      },

                                                                      'update' => function ($url, $model) {
                                                                      return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['atualizar?id=' . $model->id], [
                                                                                                                                      'title' => 'Atualizar',
                                                                                                                                      'data-toggle' => 'tooltip',
                                                                                                                                     
                                                                                                                                      'disabled' => !Mimin::checkRoute($this->context->id . '/atualizar'),
                                                                                                                                      'class' => 'btn btn-xs btn-warning isDisabled',
                                                                                                                                      
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
                   Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['/'.Yii::$app->controller->id.'/projeto-orientando','r'=>true], ['data-pjax' => 1, 'class' => 'btn btn-default', 'title' => 'Atualizar']). ' '
        ],
         '{toggleData}',
        '{export}',

        ],

        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
            'type'=>'info',
            'before'=>$botaoFiltro,                                                                                                                                                          'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
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

