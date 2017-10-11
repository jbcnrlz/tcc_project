<?php

use hscstudio\helpers\assets\LiveStampJsAsset;
use yii\bootstrap\Nav;
use yii\helpers\Html;

$LiveStampJsAsset = LiveStampJsAsset::register($this);
/**
 * @var yii\web\View $this
 * @var hscstudio\startup\models\Mailbox $model
 */

$this->title = 'Visualizar';
$this->params['breadcrumbs'][] = ['label' => 'Mensagem', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mailbox-view">
<div class="row margin-top20">
	<div class="col-md-3">
		<div class="papanel-default box box-default">
		<div class="panel-body box-body">
	<div class="row">
                        <div class="col-md-12">
                             <?= Html::a('Nova Mensagem', ['nova-mensagem'], ['class' => 'btn btn-warning col-md-12']) ?>
                        </div>             
                    </div>
                    <br>
	<?php
		$menuItems = [
			['encode'=>false,'label' => '<i class="fa fa-inbox"></i> Entrada', 'url' => ['index']],
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
			<h3 class="panel-title box-title">Mensagem</h3>
                        <a href="/mensagem/nova-mensagem?r=<?=$model->id?>" class="pull-right btn btn-xs btn-default"><i class="fa fa-reply"></i>&nbsp;Responder</a>
		</div>
		<div class="panel-body box-body">
<div class="box-body no-padding">
              <div class="mailbox-read-info">
                <h3><?=$model->assunto ?></h3>
                <br>
                <h5><?php
                
                echo Html::img('/avatar'.(($model->remetente->foto != '')?'/'.$model->remetente->foto:''),['class'=>'user-image pull-left','width'=>'50','height'=>'50']);
                 echo $model->remetente->nome."<br><span class='small'>".$model->remetente->email."</span>";   
    ?> 
                    <span class="mailbox-read-time pull-right"><?=Yii::$app->formatter->asDatetime($model->dta_cadastro, 'php:l, d F Y h:i'); ?></span></h5>
                    <div class="clearfix"></div>
              </div>
           
              
              <div class="mailbox-read-message">
                <?=$model->mensagem ?>
              </div>
              <!-- /.mailbox-read-message -->
            </div>
		
		</div>
		</div>
	</div>
</div>
</div>
