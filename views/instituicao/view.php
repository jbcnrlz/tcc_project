<?php

use app\components\Mimin;
use kartik\alert\AlertBlock;
use kartik\detail\DetailView;


echo AlertBlock::widget([
            'useSessionFlash' => true,
            'type' => AlertBlock::TYPE_GROWL,
            'delay' => 0,
    
        ]);

/**
 * @var yii\web\View $this
 * @var app\models\Instituicao $model
 */
$this->title = "Visualizar "."Instituição";
$this->params['breadcrumbs'][] = ['label' => 'Instituição', 'url' => ['index']];
$this->params['breadcrumbs'][] = "Visualizar";

?>
<div class="curso-view">

<div class="box margin-top20">

		<div class="box-body">
  

    <?= DetailView::widget([
            'model' => $model,
            'condensed'=>false,
            'hover'=>true,
            'mode'=>Yii::$app->request->get('edit')=='t' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
            'buttons1'=>'{update}',
            'panel'=>[
            'heading'=>$model->abreviado,
            'type'=>DetailView::TYPE_DEFAULT,
        ],
        'attributes' => [
            'id',
            'nome',
            'abreviado',
            'email',
            'cep',
            'rua',
            'numero',
            'complemento',
            'bairro',
            'cidade',
            'estado',
            'telefone_principal',
            'telefone_secundario',
        ],
        'deleteOptions'=>[
            'url'=>['delete', 'id' => $model->id],
            'data'=>[
                'confirm'=>Yii::t('app', 'Deseja Realmente deletar o Registro?'),
                'method'=>'post',
            ],
        ],
        'enableEditMode'=>Mimin::checkRoute($this->context->id.'/atualizar'),
    ]) ?>

</div>
</div></div>
