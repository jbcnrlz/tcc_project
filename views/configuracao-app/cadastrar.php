<?php

use kartik\alert\AlertBlock;


echo AlertBlock::widget([
            'useSessionFlash' => true,
            'type' => AlertBlock::TYPE_GROWL,
            'delay' => 0,
    
        ]);



$this->title = "Cadastrar "."Configuração da Aplicação";
$this->params['breadcrumbs'][] = ['label' => 'Configuração da Aplicação', 'url' => ['index']];
$this->params['breadcrumbs'][] = "Cadastrar";
?>
<div class="configuracao-app-cadastrar">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
