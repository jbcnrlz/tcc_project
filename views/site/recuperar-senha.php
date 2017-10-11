<?php
use kartik\alert\AlertBlock;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

echo AlertBlock::widget([
'useSessionFlash' => true,
'type' => AlertBlock::TYPE_GROWL,
'delay' => 0,

]);

$this->title = "Recuperar sua Senha";
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
            <div class="row" style="padding:0px 30px 30px 30px;">
              <div class="col-md-12  form-stylo">
                  <h2>Esqueceu sua senha? <br><span style="font-size: 14px; padding-top: 15px; display: block">Não tem problema nós te ajudamos a recuperar.</span></h2>
                 <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>            
          

                <?= $form->field($model, 'email') ->label(false)->textInput(['placeholder' => 'Digite o seu E-mail','autofocus' => true]) ?>

                <div class="form-group">
                    <?= Html::submitButton('Recuperar', ['class' => 'btn btn-default']) ?>
                </div>

            <?php ActiveForm::end(); ?>
              </div>
             
          </div>
        </div>
      </div>
        </div>
       </section>
   </div>

