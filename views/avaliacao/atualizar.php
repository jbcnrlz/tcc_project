<?php

$this->title = "Atualizar "."Avaliação da Apresentação";
$this->params['breadcrumbs'][] = ['label' => 'Avaliação da Apresentação', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->apresentacao_id, 'url' => ['visualizar', 'id' => $model->id, 'apresentacao_id' => $model->apresentacao_id]];
$this->params['breadcrumbs'][] = "Atualizar";
?>
<div class="avaliacao-atualizar">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
