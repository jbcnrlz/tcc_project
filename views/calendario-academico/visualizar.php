<?php

use app\components\Mimin;
use kartik\alert\AlertBlock;
use kartik\datecontrol\DateControl;
use kartik\detail\DetailView;
use yii\helpers\Html;


echo AlertBlock::widget([
            'useSessionFlash' => true,
            'type' => AlertBlock::TYPE_GROWL,
            'delay' => 0,
    
        ]);

/**
 * @var yii\web\View $this
 * @var app\models\CalendarioAcademico $model
 */
$this->title = "Visualizar "."Calendário Acadêmico";
$this->params['breadcrumbs'][] = ['label' => 'Calendário Acadêmico', 'url' => ['index']];
$this->params['breadcrumbs'][] = "Visualizar";

?>
<div class="calendario-academico-view">

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
            
            'fadeDelay'=>1,
            
        'attributes' => [
            //['attribute'=>'id', 'displayOnly'=>true] exemplo para não editar
            'curso_id',
            'title',
            'body:html',
            'footer',
            [
                'attribute'=>'date',
                'format'=>['date',(isset(Yii::$app->modules['datecontrol']['displaySettings']['date'])) ? Yii::$app->modules['datecontrol']['displaySettings']['date'] : 'd-m-Y'],
                'type'=>DetailView::INPUT_WIDGET,
                'widgetOptions'=> [
                    'class'=>DateControl::classname(),
                    'type'=>DateControl::FORMAT_DATE
                ]
            ],            
            'recorrencias',
            [
               'attribute'=>'badge', 
               'format'=>'raw',
               'value'=>$model->badge ? '<span class="label label-success">Sim</span>' : '<span class="label label-danger">Não</span>',
               'type'=>DetailView::INPUT_SWITCH,
               'widgetOptions' => [
                   'pluginOptions' => [
                       'size' => 'mini',
                       'onText' => 'Sim',
                       'offText' => 'Não',
                   ]
               ],
               ],
           
        ],

        'enableEditMode'=>false,
    ]) ?>
    <div class="footer footer-view">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <?=  Html::a('<i class="glyphicon glyphicon-th-list"></i> Lista',"/".Yii::$app->controller->id,['class' => 'btn btn-default isDisabled','disabled'=>!Mimin::checkRoute($this->context->id.'/index')]); ?>
             <?=  Html::a('<i class="glyphicon glyphicon-plus"></i> Adicionar Novo',"/".Yii::$app->controller->id."/cadastrar",['class' => 'btn btn-warning isDisabled','disabled'=>!Mimin::checkRoute($this->context->id.'/cadastrar')]); ?>
             <?=  Html::a('<i class="glyphicon glyphicon-pencil"></i> Editar',"/".Yii::$app->controller->id."/atualizar?id=".$model->id,['class' => 'btn btn-warning isDisabled','disabled'=>!Mimin::checkRoute($this->context->id.'/atualizar'),'data' => [
            'method' => 'post',
            ]]); ?>
      
        </div>
        </div>
    </div> 

</div>
 </div></div>
