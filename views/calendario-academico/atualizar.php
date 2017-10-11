<?php

$this->title = "Atualizar "."Calendário Acadêmico";
$this->params['breadcrumbs'][] = ['label' => 'Calendário Acadêmico', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['visualizar', 'id' => $model->id]];
$this->params['breadcrumbs'][] = "Atualizar";
?>
<div class="calendario-academico-atualizar">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
