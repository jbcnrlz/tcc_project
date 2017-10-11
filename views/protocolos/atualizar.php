<?php

$this->title = "Atualizar "."Protocolos ";
$this->params['breadcrumbs'][] = ['label' => 'Protocolos ', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->numero."-".$model->ano, 'url' => ['visualizar', 'id' => $model->id]];
$this->params['breadcrumbs'][] = "Atualizar";
?>
<div class="protocolos-atualizar">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
