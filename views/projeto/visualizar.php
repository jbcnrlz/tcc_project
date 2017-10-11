<?php
use app\components\Mimin;
use kartik\alert\AlertBlock;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Pjax;


echo AlertBlock::widget([
'useSessionFlash' => true,
'type' => AlertBlock::TYPE_GROWL,
'delay' => 0,

]);



$this->title = "Projeto";
$this->params['breadcrumbs'][] = ['label' => 'Projetos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->tema;


?>

              
<div class="projeto-index">
 
                    
    <div class="box">      
        <div class="box-body">
            <div class="row" style="padding-top: 10px;">
                <section class="col-md-4 capa-projeto">
                    
                    <div class="info-box">
                        <img src="/imagem/cabecalho-relatorio.png" alt="" class="img-responsive" style="margin: 0 auto;"/>
                        <h2 class="titulo-curso-capa">TECNOLOGIA EM ANÁLISE E DESENVOLVIMENTO DE SISTEMAS</h2>
                        <p class="autor-capa"><?=$model->matriculaRa->estudante->nome?></p>
                        <h3 class="titulo-capa"><?=$model->tema?></h3>
                        <p class="data-capa">Garça<br><?= date("Y") ?></p>
                    </div>
                    
                  
                </section>
                 <section class="col-md-8 info-projeto">
                     <div class="col-md-12">
                    <div class="box-header with-border">
                        <h3>Dados do Projeto<?=  Html::a('<i class="glyphicon glyphicon-pencil"></i> Editar dados do Projeto',"/".Yii::$app->controller->id.'/atualizar?id='.$model->id,['class' => 'btn btn-warning isDisabled pull-right','disabled'=>!Mimin::checkRoute($this->context->id.'/atualizar')]); ?>
                 
                  </div>
                         <?php $etapa_projeto = $model->matriculaRa->etapa_projeto; ?>
                    <?=DetailView::widget([
                        'model' => $model,
                        'options'=>['class'=>'table detail-view'],
                        'attributes' => [
                            'tema',
                              [
                                'label'=>'Aluno',
                                'format'=>'html',
                                'captionOptions'=>['width'=>150],
                                'value'=>$model->matriculaRa->estudante->nome
                            ],
                             
                             [
                                'attribute'=>'Etapa',
                                'captionOptions'=>['width'=>150],
                                'value'=>$model->matriculaRa->nomeEtapa
                            ],
                           
                              
                             [
                                'label'=>($model->orientador != "" && $model->orientador->sexo=="M")?"Orientador":"Orientadora",
                                'captionOptions'=>['width'=>150],
                                'visible'=>($model->orientador == '')?false:true,
                                'value'=>($model->orientador != "")? $model->orientador->nome:''
                            ],
                             [
                                'label'=>'Sug. Orientador',
                                'format'=>'raw',
                                'captionOptions'=>['width'=>150],
                                'visible'=>($model->orientadorSugestao == '')?false:true,
                                'value'=>($model->orientadorSugestao == '')?'':$model->orientadorSugestao->nome."&nbsp<div class='label label-warning' style='font-weight:normal'>Aguardando aceitação...</div>"
                            ],
                       
                            'resumo:html',
                            'palavra_chave',// description attribute in HTML
                            'dta_cadastro:datetime', // creation date formatted as datetime
                            'dta_atualizacao:datetime', // creation date formatted as datetime
                        ],
                    ]);
                       
                    ?>
                     
                </section>
                 
            </div>
                     <br>
                     
                     <?php if (!Yii::$app->user->can('Aluno') && Mimin::checkRoute($this->context->id.'/relatorioparcial') && $model->orientador != "") { ?>
                     <div class="row">
                <div class="col-md-12">
                    <div class="box-header with-border">
                        <h3 class="box-title">Relátorios Parciais </h3>
                        <div class="pull-right" style="margin-left: 30px;">
                            <?php if($aptoDefesa->apto == 1){
                                    echo '<i class="glyphicon glyphicon-check"></i>'; 
                                }else{
                                    echo '<i class="glyphicon glyphicon-unchecked"></i>';
                                }
                                ?>
                            
                            Apto para Defesa do Projeto</div>
                        <div class="pull-right ">
                            <?php if($aptoQualificacao->apto == 1){
                                         echo '<i class="glyphicon glyphicon-check"></i>'; 
                                }else{
                                    echo '<i class="glyphicon glyphicon-unchecked"></i>';
                                }
                                
                                ?>
                            Apto para Qualificação</div>
                       
                  </div>
                    
                 
                    <div class="col-md-6">
                        
                        <?php if(Yii::$app->params['qtde-relatorio'] == 2): ?>
                        <table class="table">
                <tbody><tr>
                  <th style="width: 10px"></th>
                  <th style="width: 10px">#</th>
                  <th>Etapa de Qualificação</th>
                  <th class="text-center" style="width: 60px">Nota</th>
                  <th style="width: 90px"></th>
                </tr>
                <?php 
                $media=0;
                $fase1ok=0;
                $countrelok=1;
                
                foreach($relatoriosQualificacao as $relq):?>
                <tr>
                    <td>
                      <?php if($relq->status == 0){
                        echo '<i class="glyphicon glyphicon-unchecked"></i>';
                      }else{
                        echo '<i class="glyphicon glyphicon-check"></i>'; 
                        $fase1ok=1;
                        $countrelok++;
                      }
                       ?>
                  </td>
                  <td><?=$relq->fase ?>.</td>
                  <td><?=$relq->projeto->matriculaRa->getNomeEtapa($relq->etapa_projeto); ?></td>
                  <td class="text-center">
                          <?php echo $relq->nota;
                                $media += $relq->nota;
                          ?></td>
                  <td class="text-right">
                      <?php if($etapa_projeto == 2 || Yii::$app->user->can('Super Administrador')): ?>
                      <?php if(strip_tags($relq->descricao)!= ""): ?>
                      <i class="glyphicon glyphicon-align-justify" style="margin-top:3px;float: left"></i>
                      <?php endif;?>
                      <?php if($relq->fase==2 && $fase1ok==1): ?>
                             <a href="/projeto/relatorioparcial?id=<?=$relq->id?>" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-pencil"></i></a>
                             <?php if(Mimin::checkRoute($this->context->id.'/relatorio-parciais-imp')):?>
                             <a href="/projeto/relatorio-parciais-imp?id=<?=$relq->id?>" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-print"></i></a>
                                <?php endif; ?>
 <?php endif;?>   
                     <?php if($relq->fase==1): ?>
                             <a href="/projeto/relatorioparcial?id=<?=$relq->id?>" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-pencil"></i></a>
                          <?php if(Mimin::checkRoute($this->context->id.'/relatorio-parciais-imp')):?>
                             <a href="/projeto/relatorio-parciais-imp?id=<?=$relq->id?>" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-print"></i></a>
                                <?php endif; ?>              <?php endif;?> 
                      <?php endif; ?> 
                   
                  </td>
                  
                </tr>
                <?php endforeach;?>
                 <tr style="background: #ffc">
                      <td></td>
                     <td colspan="2">Média</td>
                     <td class="text-center"><?php echo number_format(($media/2), 2, '.', ''); ?></td>
                     <td></td>
                
                </tr>
                
              </tbody></table>
                        
                       <?php else: ?>
                        
                        <table class="table">
                <tbody><tr>
                  <th style="width: 10px"></th>
                  <th style="width: 10px">#</th>
                  <th>Etapa de Qualificação</th>
                  <th class="text-center" style="width: 60px">Nota</th>
                  <th style="width: 90px"></th>
                </tr>
                <?php 
                $media=0;
                $fase1ok=0;
                $countrelok=1;
                $qtde = 1;   
                foreach($relatoriosQualificacao as $relq):
                    if($qtde > Yii::$app->params['qtde-relatorio'] ):
                        break;
                    else:
                        $qtde++;
                     endif;
                ?>
               
                <tr>
                    <td>
                      <?php if($relq->status == 0){
                        echo '<i class="glyphicon glyphicon-unchecked"></i>';
                      }else{
                        echo '<i class="glyphicon glyphicon-check"></i>'; 
                        $fase1ok=1;
                        $countrelok++;
                      }
                    
                       ?>
                  </td>
                  <td><?=$relq->fase ?>.</td>
                  <td><?=$relq->projeto->matriculaRa->getNomeEtapa($relq->etapa_projeto); ?></td>
                  <td class="text-center">
                          <?php echo $relq->nota;
                                $media += $relq->nota;
                          ?></td>
                  
                  <td class="text-right">
                      <?php
                     
                      if($etapa_projeto == 2 || Yii::$app->user->can('Super Administrador')): ?>
                       <?php if(strip_tags($relq->descricao)!= ""): ?>
                      <i class="glyphicon glyphicon-align-justify" style="margin-top:3px;float: left;"></i>
                      <?php endif;?>
                       <a href="/projeto/relatorioparcial?id=<?=$relq->id?>" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-pencil"></i></a>
                       <?php if(Mimin::checkRoute($this->context->id.'/relatorio-parciais-imp')):?>
                             <a href="/projeto/relatorio-parciais-imp?id=<?=$relq->id?>" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-print"></i></a>
                        <?php endif; ?>

                   <?php endif; ?>
                             
                  </td>
                  
                  
                </tr>
                <?php endforeach;?>
                 <tr style="background: #ffc">
                      <td></td>
                     <td colspan="2">Média</td>
                     <td class="text-center"><?php echo number_format($media, 2, '.', ''); ?></td>
                     <td></td>
                
                </tr>
                
              </tbody></table>
                        
                        <?php endif; ?>
                        
                    </div>
                    
                    
                    <div class="col-md-6">
                        <?php if(Yii::$app->params['qtde-relatorio'] == 2): ?>
                        
                        <table class="table">
                <tbody><tr>
                  <th style="width: 10px"></th>
                  <th style="width: 10px">#</th>
                  <th>Etapa de Defesa</th>
                  <th class="text-center" style="width: 60px">Nota</th>
                  <th style="width: 90px"></th>
                </tr>
                <?php 
                $media=0;
                $fase1ok=0;
                foreach($relatoriosDefesa as $relq):?>
                <tr>
                    <td>
                      <?php if($relq->status == 0){
                        echo '<i class="glyphicon glyphicon-unchecked"></i>';
                        
                      }else{
                        echo '<i class="glyphicon glyphicon-check"></i>'; 
                          $fase1ok=1;
                      }
                       ?>
                  </td>
                  <td><?=$relq->fase ?>.</td>
                  <td><?=$relq->projeto->matriculaRa->getNomeEtapa($relq->etapa_projeto); ?></td>
                  <td class="text-center">
                          <?php echo $relq->nota;
                                $media += $relq->nota;
                          ?></td>
                  <td class="text-right">
                      <?php if($etapa_projeto == 3 || Yii::$app->user->can('Super Administrador')): ?>
                       <?php if(strip_tags($relq->descricao)!= ""): ?>
                      <i class="glyphicon glyphicon-align-justify" style="margin-top:3px;float: left;"></i>
                      <?php endif;?>
                    <?php if($relq->fase==2 && $fase1ok==1): ?>
                             <a href="/projeto/relatorioparcial?id=<?=$relq->id?>" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-pencil"></i></a>
                       <?php if(Mimin::checkRoute($this->context->id.'/relatorio-parciais-imp')):?>
                             <a href="/projeto/relatorio-parciais-imp?id=<?=$relq->id?>" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-print"></i></a>
                                <?php endif; ?>
 <?php endif;?>   
                     <?php if($relq->fase==1 && $countrelok > 2): ?>
                             <a href="/projeto/relatorioparcial?id=<?=$relq->id?>" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-pencil"></i></a>
                             <?php if(Mimin::checkRoute($this->context->id.'/relatorio-parciais-imp')):?>
                             <a href="/projeto/relatorio-parciais-imp?id=<?=$relq->id?>" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-print"></i></a>
                                <?php endif; ?>
                                 <?php endif;?> 
                             <?php endif;?> 
                  </td>
                  
                </tr>
                <?php endforeach;?>
                 <tr style="background: #ffc">
                      <td></td>
                     <td colspan="2">Média</td>
                     <td class="text-center"><?php echo number_format(($media/2), 2, '.', ''); ?></td>
                     <td></td>
                
                </tr>
                
              </tbody></table>
                        
                        <?php else: ?>
                        
                        <table class="table">
                <tbody><tr>
                  <th style="width: 10px"></th>
                  <th style="width: 10px">#</th>
                  <th>Etapa de Defesa</th>
                  <th class="text-center" style="width: 60px">Nota</th>
                  <th style="width: 90px"></th>
                </tr>
                <?php 
                 
                 $qtde = 1;   
                foreach($relatoriosDefesa as $relq):
                    if($qtde > Yii::$app->params['qtde-relatorio'] ):
                        break;
                    else:
                        $qtde++;
                     endif;?>
                <tr>
                    <td>
                      <?php if($relq->status == 0){
                        echo '<i class="glyphicon glyphicon-unchecked"></i>';
                        
                      }else{
                        echo '<i class="glyphicon glyphicon-check"></i>'; 
                          $fase1ok=1;
                      }
                       ?>
                  </td>
                  <td><?=$relq->fase ?>.</td>
                  <td><?=$relq->projeto->matriculaRa->getNomeEtapa($relq->etapa_projeto); ?></td>
                  <td class="text-center">
                          <?php echo $relq->nota;
                                $nota2 = $relq->nota;
                          ?></td>
                  <td class="text-right">
                       <?php
                      
                       if($etapa_projeto == 3 || Yii::$app->user->can('Super Administrador')): ?>
                       <?php if(strip_tags($relq->descricao)!= ""): ?>
                      <i class="glyphicon glyphicon-align-justify" style="margin-top:3px;float: left;"></i>
                      <?php endif;?>
                       <a href="/projeto/relatorioparcial?id=<?=$relq->id?>" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-pencil"></i></a>
                       <?php if(Mimin::checkRoute($this->context->id.'/relatorio-parciais-imp')):?>
                             <a href="/projeto/relatorio-parciais-imp?id=<?=$relq->id?>" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-print"></i></a>
                        <?php endif; ?>
                             <?php endif; ?>

                   
                             
                  </td>
                  
                </tr>
                <?php endforeach;?>
                 <tr style="background: #ffc">
                      <td></td>
                     <td colspan="2">Média</td>
                     <td class="text-center"><?php echo $nota2; ?></td>
                     <td></td>
                
                </tr>
                
              </tbody></table>
                        
                        
                        <?php endif; ?>
                      
                        
                    </div>
                </div>
                     </div>
                     <?php }?>
                      <br> 
            <div class="row">
                <div class="col-md-12">
                    <div class="box-header with-border">
                    <h3 class="box-title">Protocolos de Arquivos</h3>
                    <?php
                    if($habilitaProtocolo && count($dtaProtocolo) > 0 && Mimin::checkRoute($this->context->id.'/protocolar')):
                    ?>
                    <div class="pull-right">
                        <strong>Tipo de arquivo permitido:</strong> DOC e DOCX.
                    </div>
                    <?php
                        endif;
                    ?>
                  </div>
                  
                     <br />
                     <?php
                 
                     if($habilitaProtocolo && count($dtaProtocolo) > 0 && Mimin::checkRoute($this->context->id.'/protocolar-arquivo')):
 echo limion\jqueryfileupload\JQueryFileUpload::widget([
        'url' => ['projeto/protocolar-arquivo', 'idp' => $model->id], // your route for saving images,
        'appearance'=>'plus', // available values: 'ui','plus' or 'basic'
        'name' => 'ArquivosProjeto[arquivo]',
        'options' => ['accept' => '.doc,.docx', 'class'=>'pull-right'],
        'clientOptions' => [
            'maxFileSize' => 2000000,
            'dataType' => 'json',
            'acceptFileTypes'=>new yii\web\JsExpression('/(\.|\/)(doc|docx)$/i'),
            'autoUpload'=>true
        ],
        'clientEvents' => [
            'done'=> "function (e, data) {
                 $.pjax.reload({container: '#gridDataProtocolo',async:false});
                 $('.fileupload-buttonbar').delay(1000).fadeToggle();
            }",
            'progressall'=> "function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress .progress-bar').css(
                    'width',
                    progress + '%'
                );
            }"
        ]
    ]);?>       <?php if(strip_tags($dtaProtocolo->observacao) != ""): ?>
                    
                <div class="alert col-md-12 text-center" style="background-color:#ffc;">
                   <?php echo $dtaProtocolo->observacao; ?>
                </div>
         
                <?php
                    endif;
                endif;
                ?>
                     <?php
                    
                     bigpaulie\fancybox\FancyBoxAsset::register($this);
                     
                     $this->registerJs('$(".word").fancybox({
                                 "type": "iframe"
                            });');
                     ?>
              
    <?php Pjax::begin(['id' => 'gridDataProtocolo','options'=>[
                'enablePushState' => false,
                'timeout'=>true,
            ]]);
                        
                        
     echo GridView::widget([
        'dataProvider' => $protocolosProvider,
        'emptyText'=>'<div class="text-center">Não existe nenhum protocolo deste Projeto!</div>',
        'columns' => [
            [
                    'attribute' => 'registro_protocolo',
                    'headerOptions'=>['class'=>'text-center'],
                    'contentOptions'=>['class'=>'kv-align-middle text-center'],
                    'width'=>''],
            [
                    'attribute' => 'tema',
                    'contentOptions'=>['class'=>'kv-align-middle'],
                    'value'=>function($data){
                        return $data->tema;
                    },
                    'width'=>''],
                            [
                    'contentOptions'=>['class'=>'kv-align-middle'],
                    'attribute' => 'etapa_projeto',
                    'value'=>function($data){
                        return $data->nomeEtapa;
                    },
                    'width'=>'230px'],
                            [
                    'attribute' => 'dta_cadastro',
                    'contentOptions'=>['class'=>'kv-align-middle'],
                    'value'=>function($data){
                        $date = new DateTime($data->dta_cadastro);
                        return $date->format('d/m/Y')." às ".$date->format('H:i');
                    },
                    'width'=>'150px'],
                                    [
                    'attribute' => 'arquivo',
                    'headerOptions'=>['class'=>'text-center'],
                    'contentOptions'=>['class'=>'text-center kv-align-middle'],
                    'format'=>'raw',
                    'value'=>function($data){   
                        $url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST'];
                        if (stripos($data->arquivo, "http") !== false) {
                                $url = '';
                        }
                        return "<a href='//docs.google.com/gview?url=".$url.$data->arquivo."&embedded=true' target='_blank' data-pjax='0' class='word btn btn-sm btn-default'><i class='fa fa-eye'></i> Visualizar Arquivo</a><a href='".$url.$data->arquivo."' target='_blank' data-pjax='0' class='btn btn-sm btn-warning' download style='margin-left:10px;'><i class='fa fa-download'></i></a>";
                    },
                    'width'=>'210px'],
                    [
                        'label'=>'',
                        'format'=>'raw',
                        'value'=>function($data){
                            
                            if($data->podeDeletar && Mimin::checkRoute($this->context->id.'/protocolo-arquivo-deletar')){
                                return "<a href='/projeto/protocolo-arquivo-deletar?id=".$data->id."&idp=".$_GET['id']."' class='btn btn-danger btn-sm' style='margin-top:5px;'><i class='glyphicon glyphicon-trash'></i></a>";    
                            }else{
                                if(Mimin::checkRoute($this->context->id.'/protocolo-deletar') && !Yii::$app->user->can('Aluno')){
                                     return "<a href='/projeto/protocolo-arquivo-deletar?id=".$data->id."&idp=".$_GET['id']."' class='btn btn-danger btn-sm' style='margin-top:5px;'><i class='glyphicon glyphicon-trash'></i></a>";    
                                }else{
                                    return "";
                                }
                            }
                            
                            
                            
                        }
                    ]
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
                    </div>
                </div>
            <div class="row" style="padding: 20px;">
                <div class="alert col-md-12 text-center" style="background-color:#ffc;">
                    O arquivo enviado só podem ser deletados nos <strong>15 minutos subsequentes</strong> à de seu envio.
                </div>
            </div>  
                      
        </div>
    </div> <!--end box -->

</div>
                    


