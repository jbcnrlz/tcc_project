<div id="relatorio">
    <div class="row">
    <p>ATA Nº <?=$model->numero."/".$model->ano; ?></p>
    </div>
    <br>
    <br>
    <br>
     
    <div class="row">
        <p>ATA DE DEFESA DO PROJETO DE GRADUAÇÃO DO CURSO DE  <?=mb_strtoupper($model->projeto->matriculaRa->curso->nome,'UTF-8'); ?>, 
            APRESENTADO <?=mb_strtoupper(($model->projeto->matriculaRa->estudante->sexo == "F")?'PELA':'PELO','UTF-8'); ?> <?=mb_strtoupper(($model->projeto->matriculaRa->estudante->sexo == "F")?'ALUNA':'ALUNO','UTF-8'); ?> <?=strtoupper($model->projeto->matriculaRa->estudante->nome); ?>. </p>
              
        <?php
            $apresentacao = \app\models\Apresentacao::find()->where(['projeto_id'=>$model->projeto_id,'status'=>2,'etapa_projeto'=>4])->one();  
                       
            $notaOrientador = $apresentacao->avaliacaos[0]->orientador_nota;
            $notaConvidadoPrimario = $apresentacao->avaliacaos[0]->convidado_primario_nota;
            $notaConvidadoSecundario = $apresentacao->avaliacaos[0]->convidado_secundario_nota;
            $mediaA = number_format((($notaConvidadoPrimario+$notaConvidadoSecundario+$notaOrientador)/3), 2, '.', '');
            $notaOrientador = $apresentacao->avaliacaos[1]->orientador_nota;
            $notaConvidadoPrimario = $apresentacao->avaliacaos[1]->convidado_primario_nota;
            $notaConvidadoSecundario = $apresentacao->avaliacaos[1]->convidado_secundario_nota;
            $mediaB = number_format((($notaConvidadoPrimario+$notaConvidadoSecundario+$notaOrientador)/3), 2, '.', '');
          
            $relatorios = \app\models\RelatoriosParciais::find()->where(['projeto_id'=>$apresentacao->projeto->id,'apto'=>1])->all();
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
            $mediaGeral = number_format(((($mediaA*4)+($mediaB*2)+($mediaC*4))/10), 2, '.', '');
        ?>
        <p>Aos <?=Yii::$app->formatter->asDate($apresentacao->dta_apresentacao,'long') ?>, às <?=Yii::$app->formatter->asTime($apresentacao->horario,'short') ?>, em sessão pública, realizou-se na sala <?=$apresentacao->local ?> da 
           Faculdade de Tecnologia de Garça “Deputado Julio Julinho Marcondes de Moura” 
           a defesa do Projeto de Graduação “<?=$model->projeto->tema; ?>”, de autoria <?=($model->projeto->matriculaRa->estudante->sexo == "F")?'da aluna':'do aluno'; ?> <?=$model->projeto->matriculaRa->estudante->nome; ?>. A Banca Examinadora iniciou 
           suas atividades submetendo <?=$model->projeto->tema; ?>”, de autoria <?=($model->projeto->matriculaRa->estudante->sexo == "F")?'a aluna':'o aluno'; ?> à forma regimental de defesa do Projeto de Graduação. Terminado o exame, a
           Banca procedeu ao julgamento e atribuiu a média <?=$mediaGeral?>, considerando <?=($model->projeto->matriculaRa->estudante->sexo == "F")?'a aluna':'o aluno'; ?> <?=$model->projeto->matriculaRa->estudante->nome; ?>.</p>

        <p>Desta forma, considera-se <?=$model->projeto->tema; ?> o referido Projeto de Graduação. Encerradas as atividades, foi lavrada a presente ata, que vai
            assinada pelos membros da Banca Examinadora.</p>
        <br>
        <br>   
        <br>
        <br>
        
        <p style="text-align: right">Garça, <?=Yii::$app->formatter->asDate($apresentacao->dta_apresentacao,'long') ?></p>
        <br>
        <br>
        <div class="row">
                <br>
               
            <div class="col-xs-7 margin-left-none">
                <p><?=$apresentacao->orientador->nome; ?> (Orientador)</p>
                <p><?=$apresentacao->convidadoPrimario->nome; ?> (Convidado)</p>
                <p><?=$apresentacao->convidadoSecundario->nome; ?> (Convidado)</p>

            </div>
            <div class="col-xs-3 margin-left-none pull-right text-right">
                    <p><span class="linha">____________________</span></p>
                 <p><span class="linha">____________________</span></p>
                 <p><span class="linha">____________________</span></p>     
            </div> 
            </div>
    </div>
    
     
</div>

