<?php
use dlds\summernote\SummernoteWidget;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="mailbox-form form-stylo">
	<?php $form = ActiveForm::begin();
            echo $form->errorSummary($model);
            ?>
	<?php
        if(isset($_GET['r'])){
            $mensagem = \app\models\Mensagem::findOne($_GET['r']);
            $model->assunto = 'Re: '.$mensagem->assunto;
            $model->destinatario_id = $mensagem->remetente_id;
            $model->mensagem = "<br><br><hr /><strong>Enviado: </strong>".Yii::$app->formatter->asDatetime($mensagem->dta_cadastro, 'php:l, d F Y h:i')."<br><strong>Assunto: </strong>".$mensagem->assunto."<br><br>".$mensagem->mensagem;
        }
        if(Yii::$app->user->identity->tipo == "Professor"): 
            $projeto = \app\models\Projeto::find()->where(['orientador_id'=> Yii::$app->user->id,'status'=>1])->all();
            $users=[];
            foreach ($projeto as $proj):
                $users[$proj->matriculaRa->estudante->id] = $proj->matriculaRa->estudante->nome;            
            endforeach;      
             if(isset($_GET['r'])){
                   echo '<div class="form-group">';
                    echo '<label class="control-label">Aluno</label>';
                    echo '<input type="text" name="destinatario-nome" readonly="readonly" id="destinatario_nome" class="form-control" value="'.$mensagem->remetente->nome.'">';
                    echo '<input type="hidden" name="Mensagem[destinatario_id]" id="destinatario_id" class="form-control" value="'.$mensagem->remetente_id.'">';
                    echo '</div>';
             }else{
                    echo '<div class="form-group">';
                    echo '<label class="control-label">Para</label>';
                    echo Select2::widget([
                            'name' => 'destinatario_id',
                            'data' => $users,
                            'options' => [
                                    'placeholder' => 'Selecione o destinatário...',
                                    'multiple' => true
                            ],
                    ]);
                    echo '</div>';
             }
          
        else:
             $projeto = \app\models\Projeto::find()->innerJoinWith('matriculaRa')->where(['and',['matricula_ra'=>Yii::$app->user->identity->matriculasAtiva->ra,'projeto.status'=>1]])->one();
             if(count($projeto->orientador) > 0){            
                 echo '<div class="form-group">';
                 echo '<label class="control-label">Orientador</label>';
                 echo '<input type="text" name="destinatario-nome" readonly="readonly" id="destinatario_nome" class="form-control" value="'.$projeto->orientador->nome.'">';
                 echo '<input type="hidden" name="Mensagem[destinatario_id]" id="destinatario_id" class="form-control" value="'.$projeto->orientador->id.'">';
                 echo '</div>';
             }else{
                 echo '<div class="alert alert-warning text-center">Você não possue projeto cadastrado</div>';
                 
             }          
        endif;
	?>
	<?= $form->field($model, 'assunto')->textInput(['maxlength' => 255]) ?>
	<?= $form->field($model, 'mensagem')->widget(SummernoteWidget::className(), [
                   'clientOptions' => [
                            'height'=>400,
                            'lang' =>"pt-BR",
                       'toolbar'=> [
            
                            ['style', ['bold', 'italic', 'underline', 'clear']],
                            ['font', ['strikethrough', 'superscript', 'subscript']],
                            ['para', ['ul', 'ol', 'paragraph']],
                            
                          ],
                       
    
  
                          
                    ]
                ]) ?>	
    
     
	
    <br>
        
	<div class="form-group">
		<?= Html::submitButton($model->isNewRecord ? 'Enviar' : 'Atualizar', ['class' => $model->isNewRecord ? 'btn btn-warning col-md-12' : 'btn btn-warning col-md-12']) ?>
	</div>
	<?php ActiveForm::end(); ?>
</div>
