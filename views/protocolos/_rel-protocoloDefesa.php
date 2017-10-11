<div id="relatorio">
    <p class="text-center"><img src="/imagem/cabecalho-relatorio.PNG" alt="" class="img-responsive" /></p>
    <div class="row text-center titulo">
        <h4 class="text-center"><strong>APRESENTAÇÃO DE DEFESA DO PROJETO DE GRADUÇÃO</strong></h4>
    </div>
    <div class="row">
        <table class="tabelaRel">
            <thead>
                <tr>
                    <th colspan="3" style="border:none;"></th>                  
                    <td colspan="2" style="line-height: 25px;">
                        Protocolo da Secretaria
                        <br>
                        <p><strong>Nº.:</strong> <?=$model->numero."/".$model->ano; ?></p>
                        <p><strong>Data.:</strong> <?=Yii::$app->formatter->asDate($model->dta_protocolo) ?></p>
                        <p><strong>Ass.:</strong> ____________________</p>
                    </td>
                    
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td width="200">R.A.: <?=$model->projeto->matriculaRa->ra ?></td>
                    <td colspan="3" width="300">Nome: <?=$model->projeto->matriculaRa->estudante->nome ?><br></td>
                    <td>Turno: <?=$model->projeto->matriculaRa->periodo ?></td>
                </tr>
                <tr>
                    <td colspan="5">
                        E-mail: <?=$model->projeto->matriculaRa->estudante->email ?><br>
                    </td>
                </tr>
                <tr>
                    <td colspan="5" valign="top" style="height:100px;">
                        Tema: <?=mb_strtoupper($model->projeto->tema,'UTF-8'); ?><br>
                        
                    </td>
                </tr>
            </tbody>
        </table>
         </div>
    <div class="row text-justify" style="text-indent: 50px;">
            <br>
        <p>Por meio deste documento, estabelece-se e oficializa-se VÍNCULO DE ORIENTAÇÃO DE PROJETO DE GRADUAÇÃO (PG) 	entre o professor e aluno supra relacionados.</p>
        <p>Este documento deve estar devidamente assinado por ambas as partes e só servirá aos fins acadêmicos legais a partir de seu protocolo na Diretoria Acadêmica da FATEC Garça.</p>
        <p>O aluno, que hora contrata a orientação do professor, atesta ciência de que seu PG só poderá estar em banca de avaliação <strong>após cumprimento de todos os requisitos solicitados para a execução do Projeto de Graduação.</strong></p>
        </div>
    <div class="row">
         <p style="text-align: right">Garça, <?=Yii::$app->formatter->asDate($model->dta_protocolo,'long') ?></p>
    </div>
    
     <div class="row">
       
       
        <table class="tabelaRel">
            <tr>
                <td colspan="3" width="350" style="border:none; text-align: center">
                    ____________________________________<br>
                   Assinatura Orientando
                   <br>
                   <br>
                   <br>
                   <br>
                      ____________________________________<br>
                   Assinatura Orientador
                   
                </td>                  
                    <td colspan="2">
                        Assinatura da Coordenação do Curso
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                         <br>
                        <br>
                        <br>
                    </td>
                    
                </tr>
          
        </table>
         </div>
      <br>
                        <br>
                        
    <div class="row">
        <table class="tabelaRel">
            <tr>
                <td>
                    <strong>Orientador:</strong> <?=@$model->projeto->orientador->nome; ?> 
                </td>                  
                   
                    
              </tr>
          
        </table>
         </div>
        
       
   
     
</div>

