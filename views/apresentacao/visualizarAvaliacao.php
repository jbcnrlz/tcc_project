<?php

use kartik\alert\AlertBlock;
use yii\helpers\Html;


echo AlertBlock::widget([
    'useSessionFlash' => true,
    'type' => AlertBlock::TYPE_GROWL,
    'delay' => 0,
]);



$this->title = "Relatório da Avaliação";
$this->params['breadcrumbs'][] = Html::decode($this->title);
?>


<div class="apresentacao-index">
  
    <div class="box">      
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <?php if($apresentacao->etapa_projeto ==2): ?>
                    <?php if($apresentacao->status == 2): ?>
                      
                            <a href="/apresentacao/relatorio-avaliacao?id=<?=$apresentacao->id?>" class="btn btn-warning pull-right"><i class="glyphicon glyphicon-print"></i> Imprimir</a>
                        
                        
                    <?php endif; ?>
                    <?php   if ($apresentacao->orientador_id == \Yii::$app->user->id): ?>
                      <a class="btn btn-xm btn-warning pull-right" style="margin-right: 20px;" href="/apresentacao/avaliar?id=<?=$apresentacao->id?>" title="" data-toggle="tooltip" data-method="post" data-original-title=" Editar Avaliação"><span class="glyphicon glyphicon-pencil"></span>  Editar Notas</a>
                    <?php endif; ?>
                        <?= $this->render('_relatorioQualificacao',['model'=>$apresentacao]) ?>
                    <div class="clearfix"></div>
                            <br> <br>
                    <?php endif; ?>
                    
                     <?php if($apresentacao->etapa_projeto ==3): ?>
                           <?php if($apresentacao->status == 2): ?>
                      
                            <a href="/apresentacao/relatorio-avaliacao?id=<?=$apresentacao->id?>" class="btn btn-warning pull-right"><i class="glyphicon glyphicon-print"></i> Imprimir</a>
                        
                        
                    <?php endif; ?>
                     <?php   if ($apresentacao->orientador_id == \Yii::$app->user->id): ?>
                      <a class="btn btn-xm btn-warning pull-right" style="margin-right: 20px;" href="/apresentacao/avaliar?id=<?=$apresentacao->id?>" title="" data-toggle="tooltip" data-method="post" data-original-title=" Editar Avaliação"><span class="glyphicon glyphicon-pencil"></span>  Editar Notas</a>
                    <?php endif; ?>
                       <?= $this->render('_relatorioDefesa',['model'=>$apresentacao]) ?>
                            <div class="clearfix"></div>
                            <br> <br>
                    <?php endif; ?>
                    
                </div>

            </div>


        </div>

    </div> <!--end box -->

</div>

