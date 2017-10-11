<?php

use kartik\alert\AlertBlock;
use kartik\builder\Form;
use kartik\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Contato';
    $this->params['breadcrumbs'][] = $this->title;
    echo AlertBlock::widget([
'useSessionFlash' => true,
'type' => AlertBlock::TYPE_GROWL,
'delay' => 0,

]);
?>
<div class="site-about">
    <h1>Contato</h1>
    <br></div>
<p>Utilize este formulário para entrar em contato, esclarecer dúvidas, ressaltar algum problema ou oferecer sugestões. <br>Sua mensagem será respondida o mais breve.</p>
     <br> <br> <br>
<div class="row">
    <div class="col-md-12 form-stylo">   
        <?php     $form = ActiveForm::begin([
    'type' => ActiveForm::TYPE_HORIZONTAL,
    'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_SMALL]   
    ]);?>
               <div class="col-lg-12">
                   
            <?= $form->field($model, 'nome',['template' => "{label}
<div class='col-md-8'>{input}</div>
{hint}
{error}"])->textInput(['maxlength' => 80]) ?>


            <?= $form->field($model, 'email',['template' => "{label}
<div class='col-md-8'>{input}</div>
{hint}
{error}"])->textInput(['maxlength' => 80]) ?>


             <?= $form->field($model, 'telefone',['template' => "{label}
<div class='col-md-4'>{input}</div>
{hint}
{error}",'options'=>['class'=>'form-group input-data']])->widget(\yii\widgets\MaskedInput::className(), [
                'mask' => ['(99)-9999-9999','(99)-99999-9999'],
            ]) ?>
                   
                      <?= $form->field($model, 'celular',['template' => "{label}
<div class='col-md-4'>{input}</div>
{hint}
{error}", 'options'=>['class'=>'form-group input-data']])->widget(\yii\widgets\MaskedInput::className(), [
                'mask' => ['(99)-9999-9999','(99)-99999-9999'],
            ]) ?>
                   



            <?= $form->field($model, 'assunto',['template' => "{label}
<div class='col-md-8'>{input}</div>
{hint}
{error}"])->textInput(['maxlength' => 200]) ?>

<?= $form->field($model, "descricao",['template' => "{label}
<div class='col-md-8'>{input}</div>
{hint}
{error}"])->textarea(["rows"=>4]); ?>
                   
                   <?= $form->field($model, 'captcha',['template' => "{label}
<div class='col-md-4'>{input}</div>
{hint}
{error}"])->widget(\yii\captcha\Captcha::classname()) ?>
                   
                   <div class="form-group">

<div class="col-sm-9 col-sm-offset-3"> <?= Html::submitButton('Enviar', ['class' => 'btn btn-warning']) ?> </div>

</div>
               
                
      
         <?php ActiveForm::end(); ?>
                   <br><br>
    </div>
</div>

</div>
