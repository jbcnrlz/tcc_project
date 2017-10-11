<?php

$this->title = "Atualizar "."Cursos";
$this->params['breadcrumbs'][] = ['label' => 'Cursos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nome_abreviado, 'url' => ['visualizar', 'id' => $model->id]];
$this->params['breadcrumbs'][] = "Atualizar";
?>
<div class="curso-atualizar">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
