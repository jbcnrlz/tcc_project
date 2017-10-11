<?php

$this->title = "Atualizar "."Projetos";
$this->params['breadcrumbs'][] = ['label' => 'Projetos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->tema, 'url' => ['visualizar', 'id' => $model->id]];
$this->params['breadcrumbs'][] = "Atualizar";
?>
<div class="projeto-atualizar">

    <?= $this->render('_form', [
        'model' => $model,
        'professores'=>$professores
    ]) ?>

</div>
