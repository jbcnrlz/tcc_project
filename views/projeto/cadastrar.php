<?php

use kartik\alert\AlertBlock;


echo AlertBlock::widget([
            'useSessionFlash' => true,
            'type' => AlertBlock::TYPE_GROWL,
            'delay' => 0,
    
        ]);



$this->title = "Cadastrar "."Projetos";
$this->params['breadcrumbs'][] = ['label' => 'Projetos', 'url' => ['index']];
$this->params['breadcrumbs'][] = "Cadastrar";
?>
<div class="projeto-cadastrar">

    <?= $this->render('_form', [
        'model' => $model,
         'professores'=> $professores,
    ]) ?>

</div>
