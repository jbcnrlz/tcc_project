<?php


$this->title = 'Atualizar Rotas: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Rotas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['visualizar', 'id' => $model->name]];
$this->params['breadcrumbs'][] = 'Atualizar';
?>
<div class="route-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
