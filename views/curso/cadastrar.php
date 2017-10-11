<?php

use kartik\alert\AlertBlock;


echo AlertBlock::widget([
            'useSessionFlash' => true,
            'type' => AlertBlock::TYPE_GROWL,
            'delay' => 0,
    
        ]);



$this->title = "Cadastrar "."Cursos";
$this->params['breadcrumbs'][] = ['label' => 'Cursos', 'url' => ['index']];
$this->params['breadcrumbs'][] = "Cadastrar";
?>
<div class="curso-cadastrar">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
