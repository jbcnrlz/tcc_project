<?php

use dlds\summernote\SummernoteWidget;
use kartik\alert\AlertBlock;
use kartik\widgets\ActiveForm;
use yii\helpers\Html;


echo AlertBlock::widget([
'useSessionFlash' => true,
'type' => AlertBlock::TYPE_GROWL,
'delay' => 0,

]);



?>
<div class="alunos-model-form margin-top20">

	<div class="box box-default padding-botton20">
             <?php     $form = ActiveForm::begin([
                      'type' => ActiveForm::TYPE_HORIZONTAL,
       
              'fieldConfig' => [
        'template' => "{label}\n<div class='col-md-10'>{input}</div>\n<div class='col-md-offset-2 col-md-10'>{error}</div>",
        'labelOptions'=> ['class'=>'control-label col-md-2'],
    ],
                 'options'=>[
                     'autocomplete'=>'off']
    ]);?>

        
		<div class="box-body">

    <div class="row">
        <div class="col-lg-12 form-stylo margin-top20">
             <div class="box-header with-border" style='margin-top:-20px;'>
              <h3 class="box-title">Dados do Usuário</h3>
            </div>
            <br>
   
              
                <?= $form->field($model, 'nome',['template' => "{label}\n<div class='col-md-10'>{input}</div>\n{hint}\n{error}"])->textInput(['maxlength' => true, 'autocomplete'=>'off']) ?>
                <?= $form->field($model, 'cpf',['template' => "{label}\n<div class='col-md-5'>{input}</div>\n{hint}\n{error}"])->textInput(['class'=>'cpf-mask']) ?>
                <?php if($model->tipo == "Estudante"): ?>
                <?= $form->field($model, 'ra',['template' => "{label}\n<div class='col-md-5'>{input}</div>\n{hint}\n{error}"])->textInput() ?>
                <?php endif; ?>
                <?php if($model->tipo == "Professor"): ?>
                <?= $form->field($model, 'lattes',['template' => "{label}\n<div class='col-md-10'>{input}</div>\n{hint}\n{error}"])->textInput() ?>
                  
               <?= $form->field($model, 'pesquisa')->widget(SummernoteWidget::className(), [
                   'clientOptions' => [
                            'height'=>200,
                            'lang' =>"pt-BR",
                       'toolbar'=> [
            
                            ['style', ['bold', 'italic', 'underline', 'clear']],
                            ['font', ['strikethrough', 'superscript', 'subscript']],
                            ['para', ['ul', 'ol', 'paragraph']],
                          ]
                          
                    ]
                ]) ?>
           
            <?php endif; ?>
                
            <div class="box-header with-border">
              <h3 class="box-title">Dados do Acesso</h3>
            </div>
            <br>
       
        <?= $form->field($model, 'username',['template' => "{label}\n<div class='col-md-5'>{input}</div>\n{hint}\n{error}"])->textInput(
[ 'class'=>'autocomp','maxlength' => true, 'autocomplete'=>'off']) ?>

	<?= $form->field($model, 'email',['template' => "{label}\n<div class='col-md-10'>{input}</div>\n{hint}\n{error}"])->textInput(['maxlength' => true, 'autocomplete'=>'off']) ?>
     

	<?php if (!$model->isNewRecord) { ?>
               <br>
            <div class="box-header with-border">
              <i class="fa fa-lock"></i>

              <h3 class="box-title">Alterar a Senha</h3>
            </div>
           
		<p>(*) Deixe em branco se caso não deseja alterar a senha</p>
                 <br>
		<div class="ui divider"></div>
               <?= $form->field($model, 'old_password',['template' => "{label}\n<div class='col-md-5'>{input}</div>\n{hint}\n{error}"])->passwordInput() ?>
		<?= $form->field($model, 'new_password',['template' => "{label}\n<div class='col-md-5'>{input}</div>\n{hint}\n{error}"])->passwordInput() ?>
		<?= $form->field($model, 'repeat_password',['template' => "{label}\n<div class='col-md-5'>{input}</div>\n{hint}\n{error}"])->passwordInput() ?>
		
	<?php }else{ ?>
            <?= $form->field($model, 'password_hash',['template' => "{label}\n<div class='col-md-5'>{input}</div>\n{hint}\n{error}"])->passwordInput(['autocomplete'=>'off']); ?>
        <?php  } ?>
                
                
                
                
                
           
                 
             
             

          
                
                
            
        </div>

    </div>
 
    </div>

       


               <div class="footer footer-view">
    <div class="row">
        <div class="col-md-10 col-md-offset-2">
           
                         <?=  Html::submitButton($model->isNewRecord ? '<i class="glyphicon glyphicon glyphicon-ok"></i> Salvar' : '<i class="glyphicon glyphicon glyphicon-ok"></i> Atualizar', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']); ?>
                <?= Html::a('<i class="fa fa-ban"></i> Cancelar','javascript:;', ['class' => 'btn btn-default', 'id'=>'cancelar']) ?>
      
        </div>
        </div>
    </div> <?php ActiveForm::end(); ?>
                </div></div>
