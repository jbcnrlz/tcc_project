 <?php

 use dlds\summernote\SummernoteWidget;
 use kartik\datecontrol\DateControl;
 use kartik\widgets\ActiveForm;
 use kartik\widgets\SwitchInput;
 use yii\helpers\Html;


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
   
              <?= $form->field($model, 'tipo',['template' => "{label}\n<div class='col-md-5'>{input}</div>\n{hint}\n{error}"])->dropDownList([
                    'Aluno' => 'Aluno', 
                    'Professor' => 'Professor', 
                    'Secretário' => 'Secretário',
                    'Coordenador' => 'Coordenador',
                    'Diretor' => 'Diretor',
                    'Estágiario(a)' => 'Estágiario',
                    'Agente Técnico' => 'Agente Técnico',
                    'Assistente' => 'Assistente',
                    'Outros' => 'Outros',
                    ], ['prompt'=>''] ); ?>
                <?= $form->field($model, 'nome',['template' => "{label}\n<div class='col-md-10'>{input}</div>\n{hint}\n{error}"])->textInput(['maxlength' => true, 'autocomplete'=>'off']) ?>
                <?= $form->field($model, 'cpf',['template' => "{label}\n<div class='col-md-5'>{input}</div>\n{hint}\n{error}"])->textInput(['class'=>'cpf-mask']) ?>
                <?= $form->field($model, 'sexo')->radioList(['M'=>'Masculino','F'=>' Feminino'],['inline'=>true]); ?>

                            
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
            <?php
                $this->registerJs(
                    "
                    if($('#usuario-tipo').val() == 'Aluno'){
                        
                           $('.field-usuario-dta_expiracao').show();
                        $('.field-usuario-lattes').hide();
                        $('.field-usuario-pesquisa').hide();
                       
                    }else if($('#usuario-tipo').val() == 'Professor'){
                      
                        $('.field-usuario-dta_expiracao').hide();
                         $('.field-usuario-lattes').show();
                        $('.field-usuario-pesquisa').show()
                     
                    }else{
                       
                        $('.field-usuario-lattes').hide();
                        $('.field-usuario-pesquisa').hide();
                        $('.field-usuario-dta_expiracao').hide();
                    }
                    
                     $('#usuario-tipo').change(function(){
                        switch($(this).val()){
                            case 'Aluno':
                              
                               $('.field-usuario-dta_expiracao').show();
                               $('.field-usuario-lattes').hide();
                               $('.field-usuario-pesquisa').hide();
                               break;
                            case 'Professor':
                              
                                $('.field-usuario-dta_expiracao').hide();
                                $('.field-usuario-lattes').show();
                                $('.field-usuario-pesquisa').show();
                                 break;
                            default:
                                 $('.field-usuario-dta_expiracao').hide();
                                
                                 $('.field-usuario-lattes').hide();
                                 $('.field-usuario-pesquisa').hide();
                                  break;
                        }
                     });
                     
                    ",
                    \yii\web\View::POS_READY,
                    'manipular-campos'
                    
                  );
            
            ?>

                
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
               
 <?php //echo $form->field($model, 'old_password',['template' => "{label}\n<div class='col-md-5'>{input}</div>\n{hint}\n{error}"])->passwordInput() ?>
		<?= $form->field($model, 'new_password',['template' => "{label}\n<div class='col-md-5'>{input}</div>\n{hint}\n{error}"])->passwordInput() ?>
		<?= $form->field($model, 'repeat_password',['template' => "{label}\n<div class='col-md-5'>{input}</div>\n{hint}\n{error}"])->passwordInput() ?>
		
	<?php }else{ ?>
            <?= $form->field($model, 'password_hash',['template' => "{label}\n<div class='col-md-5'>{input}</div>\n{hint}\n{error}"])->passwordInput(['autocomplete'=>'off']); ?>
        <?php  } ?>
                
                
                
                
                
           
                 
             
             

            <?php
            echo $form->field($model, 'dta_expiracao',['template' => "{label}\n<div class='col-md-5'>{input}</div>\n{hint}\n{error}"])->widget(DateControl::classname(), [
                'type'=>DateControl::FORMAT_DATE,
                'ajaxConversion'=>false,
                'widgetOptions' => [
                    'pluginOptions' => [
                        'autoclose' => true,
                        'startDate'=> '0d',
                        'todayHighlight' => true
                    ]
                ]
            ]);
            if($model->isNewRecord){
               echo $form->field($model, 'status',['options'=>['class'=>'not-icheck']])->widget(SwitchInput::classname(), [
		'pluginOptions' => [
			'onText' => 'Ativo',
			'offText' => 'Inativo',
                         'onColor' => 'success',
                        'offColor' => 'danger',
                        ]
                ]);
            }else{
                if($model->status == 2){
                   echo  $form->field($model, 'status',['options'=>['class'=>'not-icheck']])->widget(SwitchInput::classname(), [
                    'pluginOptions' => [
                            'onText' => 'Ativo',
                            'offText' => 'Pendente',
                             'onColor' => 'success',
                            'offColor' => 'info',
                            ]
                    ]);
                }else{
                   echo  $form->field($model, 'status',['options'=>['class'=>'not-icheck']])->widget(SwitchInput::classname(), [
                    'pluginOptions' => [
                            'onText' => 'Ativo',
                            'offText' => 'Inativo',
                             'onColor' => 'success',
                            'offColor' => 'danger',
                            ]
                    ]);
                }
                
            }
            
            
                    
                    
                    ?>
                
                
            
        </div>

    </div>
 
    </div>

       


               <div class="footer footer-view">
    <div class="row">
        <div class="col-md-10 col-md-offset-2">
           
                         <?=  Html::submitButton($model->isNewRecord ? '<i class="glyphicon glyphicon glyphicon-ok"></i> Salvar' : '<i class="glyphicon glyphicon glyphicon-ok"></i> Atualizar', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']); ?>
                <?= Html::a('<i class="fa fa-ban"></i> Cancelar','javascript:;', ['class' => 'btn btn-default','back-url'=>'index', 'id'=>'cancelar']) ?>
      
        </div>
        </div>
    </div> <?php ActiveForm::end(); ?>
                </div></div>
