<div id="relatorio">
    <img src="/imagem/cabecalho-relatorio.PNG" alt="" class="img-responsive" />
    <div class="row text-center titulo">
        <p>FACULDADE DE TECNOLOGIA DE GARÇA<br>
            CURSO DE TECNOLOGIA EM <?=$model->projeto->matriculaRa->curso->nome; ?><br>
        QUALIFICAÇÃO DO PROJETO DE GRADUAÇÃO</p>
    </div>
    <br>
    <br>
    <div class="row">
        <p><strong><?=($model->projeto->matriculaRa->estudante->sexo == "F")?'Aluna':'Aluno'; ?>: </strong><?=$model->projeto->matriculaRa->estudante->nome; ?></p>
        <p><strong>Data: </strong><?=Yii::$app->formatter->asDate($model->dta_apresentacao,'medium'); ?></p>
        <p><strong>Título do Projeto de Graduação: </strong><?=$model->projeto->tema; ?></p>
        <p><strong>Professor Orientador: </strong><?=$model->orientador->nome; ?></p>
        <p><strong>Professor Convidado: </strong><?=$model->convidadoPrimario->nome; ?></p>
    </div>
    <br>
    <br>
    <div class="row">
        <p>Tabela de Nota de Qualificação do Projeto de Graduação</p>
        <?php
            $notaOrientador = $model->avaliacaos[0]->orientador_nota;
            $notaConvidado = $model->avaliacaos[0]->convidado_primario_nota;
            $media = number_format((($notaOrientador+$notaConvidado)/2), 2, '.', '');
        ?>
        <table class="tabelaRel">
            <thead>
                <tr>
                    <th>Banca</th>
                    <th>Nota</th>
                    <th>Media Final</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td width="400">Professor Orientador</td>
                    <td class="nota"><?=$notaOrientador; ?></td>
                    <td class="nota" rowspan="2"><?=$media; ?></td>
                </tr>
                <tr>
                    <td>Professor Convidado</td>
                    <td class="nota"><?=$notaConvidado; ?></td>             
                </tr>
            </tbody>
        </table>
    </div>
    <br><br><br>
    <div class="row col-md-6 pull-right text-right">
        <span class="linha">__________________________________________</span><br>
        <?=$model->orientador->nome; ?><br>
        Prof. Orientador
    </div>
    
    <div class="clearfix"></div>
    <br><br><br>
     <div class="row col-md-6 pull-right text-right">
       <span class="linha">__________________________________________</span><br>
        <?=$model->convidadoPrimario->nome; ?><br>
        Prof. Convidado
    </div>
    <br><br><br>
     
</div>

