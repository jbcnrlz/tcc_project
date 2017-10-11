<?php

use kartik\alert\AlertBlock;


echo AlertBlock::widget([
            'useSessionFlash' => true,
            'type' => AlertBlock::TYPE_GROWL,
            'delay' => 0,
    
        ]);



$this->title = "Cadastrar "."Avaliação da Apresentação";
$this->params['breadcrumbs'][] = ['label' => 'Avaliação da Apresentação', 'url' => ['index']];
$this->params['breadcrumbs'][] = "Cadastrar";
?>
<div class="avaliacao-cadastrar">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
