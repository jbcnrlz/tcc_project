<?php

use kartik\alert\AlertBlock;


echo AlertBlock::widget([
            'useSessionFlash' => true,
            'type' => AlertBlock::TYPE_GROWL,
            'delay' => 0,
    
        ]);



$this->title = "Cadastrar "."Matriculas";
$this->params['breadcrumbs'][] = ['label' => 'Matriculas', 'url' => ['index']];
$this->params['breadcrumbs'][] = "Cadastrar";
?>
<div class="matricula-cadastrar">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
