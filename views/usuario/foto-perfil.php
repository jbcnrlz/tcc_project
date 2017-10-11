<?php

$this->title = 'Foto do Perfil';
$this->params['breadcrumbs'][] = ['label' => 'Usuários', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Dados Usuário', 'url' => ['visualizar', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Foto do Perfil';
?>
<div class="user-update">

	<?= $this->render('_cropfoto', [
		'model' => $model,
	]) ?>

</div>
