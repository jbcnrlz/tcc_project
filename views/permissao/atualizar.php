<?php


$this->title = 'Atualizar Permissão: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Permissão', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['visualizar', 'id' => $model->name]];
$this->params['breadcrumbs'][] = 'Atualizar';
?>
<div class="auth-item-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
