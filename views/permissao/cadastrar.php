<?php


$this->title = 'Cadastrar Permissão';
$this->params['breadcrumbs'][] = ['label' => 'Permissão', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
