<?php


$this->title = 'Cadastrar Rotas';
$this->params['breadcrumbs'][] = ['label' => 'Rotas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="route-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
