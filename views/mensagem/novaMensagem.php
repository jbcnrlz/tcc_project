<?php

use yii\bootstrap\Nav;
use yii\helpers\Html;

$this->title = 'Nova Mensagem';
$this->params['breadcrumbs'][] = ['label' => 'Mensagem', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mailbox-create">
<div class="row margin-top20">
	<div class="col-md-3">
		<div class="panel-default box box-default">
		<div class="panel-body box-body">
	<?php
		$menuItems = [
			['encode'=>false,'label' => '<i class="fa fa-inbox"></i> Entrada', 'url' => ['index'], 'active' => true],
			['encode'=>false,'label' => '<i class="fa fa-envelope"></i> Enviado', 'url' => ['enviado']],
    	];
		echo Nav::widget([
			'options' => ['class' => 'nav nav-pills nav-stacked'],
			'items' => $menuItems,
		]);
		?>
		</div>
		</div>
	</div>
	<div class="col-md-9">
		<div class="panel-default box box-default">
		<div class="panel-heading box-header with-border">
			<h3 class="panel-title box-title"><?= Html::encode($this->title) ?></h3>
		</div>
		<div class="panel-body box-body">
					
			<?= $this->render('_form', [
				'model' => $model,
			]) ?>
		</div>
		</div>
	</div>
</div>
</div>
