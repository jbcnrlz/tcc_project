<?php

use kartik\alert\AlertBlock;


echo AlertBlock::widget([
            'useSessionFlash' => true,
            'type' => AlertBlock::TYPE_GROWL,
            'delay' => 0,
    
        ]);



$this->title = "Cadastrar "."Agenda de Apresentação";
$this->params['breadcrumbs'][] = ['label' => 'Agenda de Apresentação', 'url' => ['index']];
$this->params['breadcrumbs'][] = "Cadastrar";
?>
<div class="apresentacao-cadastrar">

    <?= $this->render('_form', [
        'model' => $model,
        'projeto'=> $projeto
    ]) ?>

</div>
