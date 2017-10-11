<?php

$this->title = "Atualizar "."Agenda de Apresentação";
$this->params['breadcrumbs'][] = ['label' => 'Agenda de Apresentação', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->projeto_id, 'url' => ['visualizar', 'id' => $model->id]];
$this->params['breadcrumbs'][] = "Atualizar";
?>
<div class="apresentacao-atualizar">

    <?= $this->render('_form', [
        'model' => $model,
        'projeto'=>$projeto
    ]) ?>

</div>
