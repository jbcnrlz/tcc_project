<?php

use app\components\Mimin;
use kartik\alert\AlertBlock;
use kartik\detail\DetailView;
use yii\helpers\Html;


echo AlertBlock::widget([
            'useSessionFlash' => true,
            'type' => AlertBlock::TYPE_GROWL,
            'delay' => 0,
    
        ]);

/**
 * @var yii\web\View $this
 * @var app\models\AlunosModel $model
 */
$this->title = "Visualizar "."Rota";
$this->params['breadcrumbs'][] = ['label' => 'Rotas', 'url' => ['index']];
$this->params['breadcrumbs'][] = "Visualizar";

?>
<div class="alunos-model-view">

<div class="box margin-top20">

		<div class="box-body">
            <?php             $button1 = null;
            if(Mimin::checkRoute($this->context->id.'/atualizar')){
                $button1 = '{update}';
            }
            if(Mimin::checkRoute($this->context->id.'/delete')){
                $button1 =  $button1.'{delete}';
            }

            ?>

    <?= DetailView::widget([
            'model' => $model,
            'condensed'=>false,
            'hover'=>true,
            'mode'=>Yii::$app->request->get('edit')=='t' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
            'buttons1'=>$button1,
            'fadeDelay'=>1,
            'deleteOptions'=>[
                'params' => ['custom_param'=>true],
                'url'=>['delete','id'=>$model->name],
                'ajaxSettings' => ['success' => new \yii\web\JsExpression("
                    function(data) {
                            if (data.success) {
                                  window.location = 'index';
                              };
                              $.each(data.messages, function(key, msg) {
                              $('.kv-alert-container').append(self.alert(key, msg));
                              });
                             $('.kv-alert-container').hide().fadeIn('slow', function() {
                             $('.kv-detail-view').removeClass('kv-detail-loading');
                              self.initAlert();
                        });
                        }
                    "),
                ],
            ],
            'updateOptions'=>['label'=>'<button type="button" class="kv-action-btn kv-btn-update" title="" data-toggle="tooltip" data-container="body" data-original-title="Edição Rápida"><i class="glyphicon glyphicon-pencil"></i></button>'],
            'panel'=>[
            'heading'=>'#'.$model->name,
            'type'=>DetailView::TYPE_DEFAULT,
        ],
        'attributes' => [
            //['attribute'=>'id', 'displayOnly'=>true] exemplo para não editar
            
            'alias',
            'type',
            'name',
             [
               'attribute'=>'status', 
               'format'=>'raw',
               'value'=>$model->status ? '<span class="label label-success">Ativo</span>' : '<span class="label label-danger">Inativo</span>',
               'type'=>DetailView::INPUT_SWITCH,
               'widgetOptions' => [
                   'pluginOptions' => [
                       'size' => 'mini',
                       'onText' => 'Ativo',
                       'offText' => 'Inativo',
                   ]
               ],
               ],
        ],

        'enableEditMode'=>true,
    ]) ?>
    <div class="footer footer-view">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <?=  Html::a('<i class="glyphicon glyphicon-th-list"></i> Lista',"/".Yii::$app->controller->id,['class' => 'btn btn-default isDisabled','disabled'=>!Mimin::checkRoute($this->context->id.'/index')]); ?>
             <?=  Html::a('<i class="glyphicon glyphicon-plus"></i> Adicionar Novo',"/".Yii::$app->controller->id."/cadastrar",['class' => 'btn btn-warning isDisabled','disabled'=>!Mimin::checkRoute($this->context->id.'/cadastrar')]); ?>
             <?=  Html::a('<i class="glyphicon glyphicon-pencil"></i> Editar',"/".Yii::$app->controller->id."/atualizar?id=".$model->name,['class' => 'btn btn-warning isDisabled','disabled'=>!Mimin::checkRoute($this->context->id.'/atualizar'),'data' => [
            'method' => 'post',
            ]]); ?>
      
        </div>
        </div>
    </div> 

</div>
 </div></div>

