<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = "Ocorreu um erro! :(  ";
?>
<div class="site-error">

    <div class="col-md-6">
        
   
    <h1 class="text-center"><img src="/imagem/erro_icon.png" alt="Error"/></h1>
     </div>
 <div class="col-md-6">
     <br><br><br>
    <div class="alert alert-danger text-center">
        <?= nl2br(Html::encode($message)) ?>
    </div>
     <div class="text-center">O erro acima ocorreu enquanto o servidor Web estava processando sua solicitação.<br><br>
         Entre em contato conosco se você acha que isso é um erro de servidor.<br>
         <strong>Obrigado!</strong></div>
     
 </div>
    
    

</div>
