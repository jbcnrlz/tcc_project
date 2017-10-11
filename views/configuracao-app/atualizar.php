<?php

$this->title = "Atualizar "."Configuração da Aplicação";
$this->params['breadcrumbs'][] = ['label' => 'Configuração da Aplicação', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nome, 'url' => ['visualizar', 'id' => $model->id]];
$this->params['breadcrumbs'][] = "Atualizar";
?>
<div class="configuracao-app-atualizar">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
