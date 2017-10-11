<?php

use kartik\alert\AlertBlock;


echo AlertBlock::widget([
            'useSessionFlash' => true,
            'type' => AlertBlock::TYPE_GROWL,
            'delay' => 0,
    
        ]);



$this->title = "Cadastrar "."Calendário Acadêmico";
$this->params['breadcrumbs'][] = ['label' => 'Calendário Acadêmico', 'url' => ['index']];
$this->params['breadcrumbs'][] = "Cadastrar";
?>
<div class="calendario-academico-cadastrar">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
