<?php

use hscstudio\helpers\assets\LiveStampJsAsset;
use yii\bootstrap\Nav;
use yii\grid\GridView;
use yii\helpers\Html;

$LiveStampJsAsset = LiveStampJsAsset::register($this);

$this->title = 'Mensagem';
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = 'Caixa de Entrada';
?>
<div class="mensagem-index">
<div class="row margin-top20">
	<div class="col-md-3">
		<div class="panel-default box">                    
		<div class="panel-body box-body">
                    <div class="row">
                        <div class="col-md-12">
                             <?= Html::a('Nova Mensagem', ['nova-mensagem'], ['class' => 'btn btn-warning col-md-12']) ?>
                        </div>             
                    </div>
                    <br>
               
            <?php
                 $label='';
                $count = \app\models\Mensagem::find()->where(['destinatario_id'=>Yii::$app->user->id, 'lido'=>0])->count();
                if($count > 0){
                    $label = '<span class="label label-warning pull-right text-weight-normal">'.$count.'</span>';
                }
		$menuItems = [
			['encode'=>false,'label' => '<i class="fa fa-inbox"></i> Entrada '.$label, 'url' => ['index'],'active' => true],
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
			<h3 class="panel-title box-title">Entrada</h3>
                        <div class="pull-right">
                            <i class="fa fa-envelope-o"></i> &nbsp;Visualizado&nbsp;&nbsp; <i class="fa fa-envelope"></i>&nbsp;Não Visualizado
                        </div>
		</div>
		<div class="panel-body box-body">


		<?= GridView::widget([
			'dataProvider' => $dataProvider,
		'layout'=>"{items}\n{summary}\n{pager}",
			'columns' => [
			
				[
					'header' => '#',
					'attribute' => 'lido',
					'format' => 'html',
					'value'=>function($data){
						if($data->lido==1){
							return Html::tag('i','',['class'=>'fa fa-envelope-o']);
						} 
						else{
							return Html::tag('i','',['class'=>'fa fa-envelope']);
						}
					}
				],
				[
					'attribute' => 'remetente_id',
                                        'format'=>'raw',
					'value' => function($data){
						return Html::img('/upload/avatarPerfil/'.(($data->remetente->foto != '')?'/'.$data->remetente->foto:'SemImagem.jpg'),['class'=>'user-image pull-left','width'=>'50','height'=>'50']).$data->remetente->nome;
						
					}
				],
				[
					'attribute' => 'assunto',                                  
					'format' => 'html',
					'value' => function($data){
						return Html::a(
							'<strong>'.$data->assunto.'</strong><br>'.
							substr(strip_tags($data->mensagem),0,20).'...',
							['visualizar','id'=>$data->id]
						);
					}
				],
			
				[
					'attribute' => 'dta_atualizacao',                                     
					'format' => 'raw',
                                        'contentOptions' => ['style' => 'width:170px;'],
					'value' => function($data){
						return '<span data-livestamp="'.$data->dta_atualizacao.'"></span>';
					}
				],
                                      
                                 

				
			],
		]); ?>
		</div>
		</div>
	</div>
</div>
</div>
