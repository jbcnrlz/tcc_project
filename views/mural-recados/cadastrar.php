<?php

use kartik\alert\AlertBlock;


echo AlertBlock::widget([
            'useSessionFlash' => true,
            'type' => AlertBlock::TYPE_GROWL,
            'delay' => 0,
    
        ]);



$this->title = "Cadastrar "."Mural de Recados";
$this->params['breadcrumbs'][] = ['label' => 'Mural de Recados', 'url' => ['index']];
$this->params['breadcrumbs'][] = "Cadastrar";
?>
<div class="mural-recados-cadastrar">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
