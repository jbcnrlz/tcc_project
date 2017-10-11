<?php
use kartik\widgets\ActiveForm;
use yii\helpers\Html;

?>
<div id="relatorio" style="font-size:13px;">
    <img src="/imagem/cabecalho-relatorio.PNG" alt="" class="img-responsive" />
    <div class="row text-center titulo">
        <p style="font-size:14px;">CURSO DE TECNOLOGIA EM <?=$model->projeto->matriculaRa->curso->nome; ?><br>
            APRESENTAÇÃO DO PROJETO DE GRADUÇÃO<br>
            (TRABALHO DE CONCLUSÃO DE CURSO)
        </p>
    </div>
    <br>
    
    <div class="row">
        <p><strong><?=($model->projeto->matriculaRa->estudante->sexo == "F")?'Aluna':'Aluno'; ?>: </strong><?=$model->projeto->matriculaRa->estudante->nome; ?></p>
         <p><strong>Título do Projeto de Graduação: </strong><?=$model->projeto->tema; ?></p>
        <p><strong>Professor Orientador: </strong><?=$model->orientador->nome; ?></p>
     </div>
    <br>
    
    <div class="row">
        <p><strong>Avaliação da Banca</strong></p>
        <p>1. Tabela para avaliação do projeto (Prático e/ou Conceitual)</p>
        <?php
            $notaOrientador = $model->avaliacaos[0]->orientador_nota;
            $notaConvidadoPrimario = $model->avaliacaos[0]->convidado_primario_nota;
            $notaConvidadoSecundario = $model->avaliacaos[0]->convidado_secundario_nota;
            $mediaA = number_format((($notaConvidadoPrimario+$notaConvidadoSecundario+$notaOrientador)/3), 2, '.', '');
        ?>
        <table class="tabelaRel">
            <thead>
                <tr>
                    <th style="border:none;"></th>
                    <th>Professor Convidado</th>
                    <th>Professor Convidado</th>
                    <th>Orientador</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td width="400" class="text-right">Nota do Projeto</td>
                    <td class="nota"><?=$notaConvidadoPrimario; ?></td>
                    <td class="nota"><?=$notaConvidadoSecundario; ?></td>
                    <td class="nota"><?=$notaOrientador; ?></td>
                </tr>
                <tr>
                    <td class="text-right">Media do Projeto (<strong>A</strong>)</td>
                    <td colspan="3" class="nota"><strong><?=$mediaA; ?></strong></td>             
                </tr>
            </tbody>
        </table>
    </div>
    <div class="row">
        <br>
        <p>2. Tabela para avaliação da Apresentação Oral</p>
        <?php
            $notaOrientador = $model->avaliacaos[1]->orientador_nota;
            $notaConvidadoPrimario = $model->avaliacaos[1]->convidado_primario_nota;
            $notaConvidadoSecundario = $model->avaliacaos[1]->convidado_secundario_nota;
            $mediaB = number_format((($notaConvidadoPrimario+$notaConvidadoSecundario+$notaOrientador)/3), 2, '.', '');
        ?>
        <table class="tabelaRel">
            <thead>
                <tr>
                    <th style="border:none;"></th>
                    <th>Professor Convidado</th>
                    <th>Professor Convidado</th>
                    <th>Orientador</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td width="400" class="text-right">Nota do Projeto</td>
                    <td class="nota"><?=$notaConvidadoPrimario; ?></td>
                    <td class="nota"><?=$notaConvidadoSecundario; ?></td>
                    <td class="nota"><?=$notaOrientador; ?></td>
                </tr>
                <tr>
                    <td class="text-right">Media do Projeto (<strong>B</strong>)</td>
                    <td colspan="3" class="nota"><strong><?=$mediaB; ?></strong></td>             
                </tr>
            </tbody>
        </table>
    </div>
    <div class="row">
        <br>
        <?php
            $relatorios = \app\models\RelatoriosParciais::find()->where(['projeto_id'=>$model->projeto_id,'apto'=>1])->all();
            $cont = 0;
            $nota = 0;
            if(Yii::$app->params['qtde-relatorio'] == 2):
                foreach ($relatorios as $rel){
                    $cont++;
                    $nota = $nota + $rel->nota;

                }
            else:
                foreach ($relatorios as $rel){                  
                    if($rel->fase == 1){
                        $cont++;
                        $nota = $nota + $rel->nota;
                    }                  
                }                
            endif;
            $mediaC = number_format(($nota/$cont), 2, '.', '');
        ?>
        <p>3. Média do aluno atribuída pelo professor orientador nos Relatórios Parciais (<strong>C</strong>): <strong><?=$mediaC; ?></strong></p>
    </div>
    <div class="row">
        <br>
        <p>4. Tabela de Cálculo da Média Final</p>
        <table class="tabelaRel">
            <thead>
                <tr>                   
                    <th>Cálculo da Média Final</th>
                    <th>Média</th>
                </tr>
            </thead>
            <tbody>
                <tr>                    
                    <td class="text-center"><strong>(A * 4 + B * 2 + C * 4) / 10</strong></td>
                    <td class="text-center"><strong><?php $mediaGeral = number_format(((($mediaA*4)+($mediaB*2)+($mediaC*4))/10), 2, '.', '');
                        echo $mediaGeral;
                    ?></strong></td>
                </tr>               
            </tbody>
        </table>
    </div>
    <div class="row">
        <br>
        <p><strong>Banca</strong></p>
        
            
        
    <div class="col-xs-7 margin-left-none">
        <p><strong>Professor Orientador: </strong><?=$model->orientador->nome; ?></p>
        <p><strong>Professor Convidado: </strong><?=$model->convidadoPrimario->nome; ?></p>
        <p><strong>Professor Convidado: </strong><?=$model->convidadoSecundario->nome; ?></p>
       
    </div>
    <div class="col-xs-4 margin-left-none pull-right text-right">
            <p><span class="linha">___________________________</span></p>
         <p><span class="linha">___________________________</span></p>
         <p><span class="linha">___________________________</span></p>     
    </div> 
    </div>
    <?php if(Yii::$app->controller->action->id == "visualizar-avaliacao"): ?>
    <br>
    <div class="row form-stylo">
      <div class="box-header with-border">
                        <i class="fa fa-legal"></i>
                        <h3 class="box-title">Definição Final da Avaliação</h3>
                       

                    </div>   
    
    <?php     $form = ActiveForm::begin(['action'=>['/apresentacao/avaliacao-final','id'=>$model->id],
    'type' => ActiveForm::TYPE_INLINE,
      'formConfig' => [
                                     'labelSpan' => 2,
          ],]);?><br>
     <?= $form->field($model, 'resultado_aprovacao',['template' => "{label}
<div class='col-md-12'>{input}</div>
{hint}
{error}"])->radioList($model->opcaoAprovacao,['prompt' => ''])->label(false) ?>

                    <br>    <br> 
                    <label><strong>Data da entrega da versão final do Projeto:</strong></label><br><br>
 <?= $form->field($model, 'dta_versao_final',['template' => "{label}
<div class='col-md-5'>{input}</div>
{hint}
{error}"])->textInput() ?>
    
                     <?=  Html::submitButton('<i class="glyphicon glyphicon glyphicon-ok"></i> Salvar', ['class' => 'btn btn-warning']); ?>
    <?php ActiveForm::end(); ?>
                    <br>    <br> 
    </div>
    <?php else: ?>
    <div class="row">
        <br>
        <p><strong>Média: <?=$mediaGeral;?></strong></p>
        <p>(<?=($model->resultado_aprovacao==1)?' X ':'&nbsp;&nbsp;&nbsp;&nbsp;' ?>) Aprovado sem restrições</p>
        <p>(<?=($model->resultado_aprovacao==2)?' X ':'&nbsp;&nbsp;&nbsp;&nbsp;' ?>) Aprovado mediante confecção das alterações no trabalho, conforme solicidado pela banca</p>
        <p>(<?=($model->resultado_aprovacao==3)?' X ':'&nbsp;&nbsp;&nbsp;&nbsp;' ?>) Reprovado</p>
    </div>
    <div class="row">
        Data da entrega da versão final: <strong><?=$model->dta_versao_final; ?></strong>
    </div>    
     <?php endif; ?>
    <div class="clearfix"></div>
    <div class="row">
        <br>
         <p><strong>Ciente:</strong></p>
         <div class="text-center" style="width: 250px; float: left; margin-left: 70px">
        <span class="linha">_____________________________</span><br>
        <?=$model->projeto->matriculaRa->estudante->nome; ?><br>
       <?=($model->projeto->matriculaRa->estudante->sexo == "F")?'Aluna':'Aluno'; ?>
    </div>
        
     <div class="text-center"  style="width: 250px; float: left; margin-left: 50px">
       <span class="linha">_____________________________</span><br>
        <?=$model->orientador->nome; ?><br>
        Prof. Orientador
    </div>
         
   
    </div>
</div>

