<?php

use kartik\alert\AlertBlock;


echo AlertBlock::widget([
            'useSessionFlash' => true,
            'type' => AlertBlock::TYPE_GROWL,
            'delay' => 0,
    
        ]);



$this->title = "Cadastrar "."Protocolos ";
$this->params['breadcrumbs'][] = ['label' => 'Protocolos ', 'url' => ['index']];
$this->params['breadcrumbs'][] = "Cadastrar";
?>
<div class="protocolos-cadastrar">

    <?= $this->render('_form', [
        'model' => $model,
        'projeto'=>$projeto
        
    ]) ?>

</div>
