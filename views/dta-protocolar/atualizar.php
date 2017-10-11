<?php

$this->title = "Atualizar "."Agenda para Protocolar";
$this->params['breadcrumbs'][] = ['label' => 'Agenda para Protocolar', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->etapa_projeto, 'url' => ['visualizar', 'id' => $model->id]];
$this->params['breadcrumbs'][] = "Atualizar";
?>
<div class="dta-protocolar-atualizar">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
