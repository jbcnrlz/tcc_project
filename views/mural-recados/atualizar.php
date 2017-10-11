<?php

$this->title = "Atualizar "."Mural de Recados";
$this->params['breadcrumbs'][] = ['label' => 'Mural de Recados', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->titulo, 'url' => ['visualizar', 'id' => $model->id]];
$this->params['breadcrumbs'][] = "Atualizar";
?>
<div class="mural-recados-atualizar">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
