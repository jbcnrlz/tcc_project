<?php

use kartik\alert\AlertBlock;


echo AlertBlock::widget([
            'useSessionFlash' => true,
            'type' => AlertBlock::TYPE_GROWL,
            'delay' => 0,
    
        ]);



$this->title = "Cadastrar "."Agenda para Protocolar";
$this->params['breadcrumbs'][] = ['label' => 'Agenda para Protocolar', 'url' => ['index']];
$this->params['breadcrumbs'][] = "Cadastrar";
?>
<div class="dta-protocolar-cadastrar">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
