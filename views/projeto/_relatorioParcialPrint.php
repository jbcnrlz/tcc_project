<?php
Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
Yii::$app->response->headers->add('Content-Type', 'application/pdf');
?>

<div class="container">
   <div class="row">
        <div class="col-xs-7"><strong>Curso:</strong> <?=$model->projeto->matriculaRa->curso->nome ?></div>
        <div class="col-xs-3"><strong>Termo:</strong> <?=$model->projeto->matriculaRa->termo."º - ".$model->projeto->matriculaRa->periodo ?></div>
    </div>
   
    <div class="row">
        
        <div class="col-xs-12"><strong><?=($model->projeto->orientador->sexo=="M")?"Orientador":"Orientadora" ?>: </strong><?=$model->projeto->orientador->nome ?></div>
    </div>
      <div class="row">
        <div class="col-xs-12"><strong>Nome: </strong><?=$model->projeto->matriculaRa->estudante->nome ?></div>
    </div>
      <div class="row">
        <div class="col-xs-12"><strong>TCC: </strong><?=$model->projeto->tema ?></div>
    </div>

      <div class="row">
           <?php if(Yii::$app->params['qtde-relatorio'] == 2): ?>
                <div class="col-xs-12"><strong>Relatório Parcial <?=(($model->fase==1)?"I":"II") ?></strong></div>
          <?php else: ?>
                <div class="col-xs-12"><strong>Relatório Parcial</strong></div>
          <?php endif; ?>
    </div>
    <div class="row">
        <div class="col-xs-12"><strong>Atividade Desenvolvidas:</strong></div>
    </div>
       <div class="row conteudo-atividade">
        <div class="col-xs-12"><?=$model->descricao ?></div>
    </div>
      <?php if(Yii::$app->params['qtde-relatorio'] == 2): ?>
        <?php if($model->fase==1): ?>
        <div class="row assinatura">
            <div class="col-xs-5">Nota Relatório Parcial I: <?=$model->nota ?></div>
            <div class="col-xs-5 text-center pull-right"><?=$model->projeto->orientador->nome ?><br><?=($model->projeto->orientador->sexo=="M")?"Orientador":"Orientadora" ?></div>
        </div>
        <?php else:?>
     
            <?php if($model->etapa_projeto == 2): ?>
            <div class="col-xs-5">Nota Relatório Parcial I: <?=$nota1 ?></div>
            <div class="col-xs-5">Nota Relatório Parcial II: <?=$model->nota ?></div>
            <div class="col-xs-12" style="margin-top: 10px;">
                O Aluno está Apto para a Qualificação do Projeto de Graduação (TCC)?&nbsp;&nbsp;
                (<?=((($nota1+$model->nota)/2)>=6)?"X":"&nbsp;&nbsp;"?>)&nbsp;Sim &nbsp;&nbsp; (<?=((($nota1+$model->nota)/2)<6)?"X":"&nbsp;&nbsp;"?>)&nbsp; Não
            </div>
            <?php else:?>
               <div class="col-xs-5">Nota Relatório Parcial I: <?=$nota1 ?></div>
               <div class="col-xs-5">Nota Relatório Parcial II: <?=$model->nota ?></div>
               <div class="col-xs-12" style="margin-top: 10px;">
                   O Aluno está Apto para a Defesa do Projeto de Graduação (TCC)?&nbsp;&nbsp;
                   (<?=((($nota1+$model->nota)/2)>=6)?"X":"&nbsp;&nbsp;"?>)&nbsp;Sim &nbsp;&nbsp; (<?=((($nota1+$model->nota)/2)<6)?"X":"&nbsp;&nbsp;"?>)&nbsp; Não
               </div>
           <?php endif; ?>
               <?php endif; ?>
        <?php else: ?>
            <?php if($model->etapa_projeto == 2): ?>
            <div class="col-xs-5">Nota Relatório Parcial: <?=$model->nota ?></div>
          
            <div class="col-xs-12" style="margin-top: 10px;">
                O Aluno está Apto para a Qualificação do Projeto de Graduação (TCC)?&nbsp;&nbsp;
                (<?=(($model->nota)>=6)?"X":"&nbsp;&nbsp;"?>)&nbsp;Sim &nbsp;&nbsp; (<?=(($model->nota)<6)?"X":"&nbsp;&nbsp;"?>)&nbsp; Não
            </div>
            <?php else:?>
               <div class="col-xs-5">Nota Relatório Parcial: <?=$model->nota ?></div>
        
               <div class="col-xs-12" style="margin-top: 10px;">
                   O Aluno está Apto para a Defesa do Projeto de Graduação (TCC)?&nbsp;&nbsp;
                   (<?=(($model->nota)>=6)?"X":"&nbsp;&nbsp;"?>)&nbsp;Sim &nbsp;&nbsp; (<?=(($model->nota)<6)?"X":"&nbsp;&nbsp;"?>)&nbsp; Não
              </div>
           <?php endif; ?>
    
        <?php endif; ?>
        
        <br><br><br>
        <div class="col-xs-5 text-center pull-right"><?=$model->projeto->orientador->nome ?><br><?=($model->projeto->orientador->sexo=="M")?"Orientador":"Orientadora" ?></div>
  
   
</div>
