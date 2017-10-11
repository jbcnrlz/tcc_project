<?php
use kartik\alert\AlertBlock;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

echo AlertBlock::widget([
'useSessionFlash' => true,
'type' => AlertBlock::TYPE_GROWL,
'delay' => 0,

]);
$this->title = "Home";
?>
<section>
    <h2 class="titulo">
        Software de Controle e Gerenciamento de Trabalho de Conclusão de Curso

   </h2>
</section>
   <div class="row">
       <section class="col-md-8 col-md-offset-2">
        <div id="painel-login">
      <div class="panel panel-login">
        <div class="panel-body">
          <div class="row">
            <div class="col-lg-12">
              <!--<form id="login-form" action="#" method="post" role="form" style="display: block;">-->
                       <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'options'=>['style'=>($formActive =='login')? "display: block;" : "display: none;"],
        'fieldConfig' => [
            'template' => "<div class=\"col-lg-12\">{input}</div>\n<div class=\"col-lg-12\">{error}</div>",
   
        ],
    ]); 
                     ?>
                <div class="form-stylo">
             
 <h2>ACESSAR</h2>
        <?= $form->field($login, 'username')->textInput(['placeholder' => "E-mail ou Nome de Usuário",'autofocus' => true])->label(false) ?>

        <?= $form->field($login, 'password')->passwordInput(['placeholder' => "Senha"])->label(false) ?>
<div class='col-xs-10 col-md-6 form-group pull-left checkbox'>
        <?= $form->field($login, 'rememberMe')->checkbox([
            'template' => "{input}{label}",
        ]) ?></div>
                  
               
 <div class="col-xs-12 col-md-6 form-group pull-right" style="padding-right: 45px;">  
                   <?= Html::submitButton('Entrar', ['class' => 'form-control btn btn-default', 'name' => 'login-button']) ?>
                </div>

 <div class="col-xs-12 col-md-12" style="padding-left: 30px;">
       <a href="/recuperar-senha">Esqueci minha senha</a>
 </div>

                   </div>
             <?php ActiveForm::end(); ?>
              <?php $form = ActiveForm::begin([
                 'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'id' => 'cadastro-form',
        'layout' => 'horizontal',
        'options'=>['style'=>($formActive =='cadastro')? "display: block;" : "display: none;"],
        'fieldConfig' => [
            'template' => "<div class=\"col-lg-12\">{input}</div>\n<div class=\"col-lg-12\">{error}</div>",
   
        ],
    ]); 
                     ?>
             
               <div class="form-stylo">
             
 <h2>CADASTRO</h2>
        <?= $form->errorSummary($cadastro); ?>
        <?= $form->errorSummary($matricula); ?>
        <?= $form->field($cadastro, 'nome')->textInput(['placeholder' => "Nome Completo",'autofocus' => true])->label(false) ?>
        <?= $form->field($cadastro, 'email')->textInput(['placeholder' => "E-mail"])->label(false) ?>
        <?= $form->field($matricula, 'ra')->textInput(['placeholder' => "Registro Acadêmico (RA)"])->label(false) ?>  
        <?= $form->field($cadastro, 'cpf')->textInput(['placeholder' => "CPF",'class'=>'col-xs-12 col-md-12 cpf-mask'])->label(false) ?>  
        <?= $form->field($cadastro, 'sexo')->inline()->radioList(['M'=>'Masculino','F'=>' Feminino'])->label(false); ?>
 <div class='col-xs-12 col-md-8 form-group pull-left checkbox'>
        <?= $form->field($cadastro, 'confirmacao')->checkbox([
            'template' => "{input}{label}",
        ]) ?></div>
 <div class="col-xs-12 col-md-5 form-group pull-right" style="padding-right: 40px;">  
                   <?= Html::submitButton('Cadastrar', ['class' => 'form-control btn btn-default', 'name' => 'login-button']) ?>
                </div>

                 
               
               </div>
             <?php ActiveForm::end(); ?>
            </div>
          </div>
            <BR>
        </div>
        <div class="panel-heading">
          <div class="row">
            <div class="col-xs-6 tabs">
              <a href="#" class="<?= ($formActive =='login')? "active" : "" ?>" id="login-form-link"><div class="login">ACESSAR</div></a>
            </div>
            <div class="col-xs-6 tabs">
              <a href="#" class="<?= ($formActive =='cadastro')? "active" : "" ?>" id="cadastro-form-link"><div class="register">CADASTRE-SE</div></a>
            </div>
          </div>
        </div>
      </div>
        </div>
    </section>
  </div>



