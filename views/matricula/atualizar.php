<?php

$this->title = "Atualizar "."Matriculas";
$this->params['breadcrumbs'][] = ['label' => 'Matriculas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ano, 'url' => ['visualizar', 'id' => $model->ra]];
$this->params['breadcrumbs'][] = "Atualizar";
?>
<div class="matricula-atualizar">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
