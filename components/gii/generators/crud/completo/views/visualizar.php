<?php

use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;
use branchonline\lightbox\Lightbox;
use kartik\alert\AlertBlock;
use app\components\Mimin;


echo AlertBlock::widget([
            'useSessionFlash' => true,
            'type' => AlertBlock::TYPE_GROWL,
            'delay' => 0,
    
        ]);

/**
 * @var yii\web\View $this
 * @var <?= ltrim($generator->modelClass, '\\') ?> $model
 */
$this->title = "Visualizar "."<?= $generator->tituloCrud; ?>";
$this->params['breadcrumbs'][] = ['label' => '<?= Html::decode($generator->tituloCrud) ?>', 'url' => ['index']];
$this->params['breadcrumbs'][] = "Visualizar";

?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-view">

<div class="box margin-top20">

		<div class="box-body">
            <?= "<?php " ?>
            $button1 = null;
            if(Mimin::checkRoute($this->context->id.'/atualizar')){
                $button1 = '{update}';
            }
            if(Mimin::checkRoute($this->context->id.'/delete')){
                $button1 =  $button1.'{delete}';
            }

            ?>

    <?= "<?= " ?>DetailView::widget([
            'model' => $model,
            'condensed'=>false,
            'hover'=>true,
            'mode'=>Yii::$app->request->get('edit')=='t' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
            'buttons1'=>$button1,
            'fadeDelay'=>1,
            'deleteOptions'=>[
                'params' => ['custom_param'=>true],
                'url'=>['delete','id'=>$model->id],
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
            'heading'=>'#'.$model->id,
            'type'=>DetailView::TYPE_DEFAULT,
        ],
        'attributes' => [
            //['attribute'=>'id', 'displayOnly'=>true] exemplo para não editar
<?php
if (($tableSchema = $generator->getTableSchema()) === false) {
    foreach ($generator->getColumnNames() as $name) {
        echo "            '" . $name . "',\n";
    }
} else {
    foreach ($generator->getTableSchema()->columns as $column) {

        $format = $generator->generateColumnFormat($column);

        if($column->name === 'status'){
                 echo "             [
               'attribute'=>'status', 
               'format'=>'raw',
               'value'=>\$model->status ? '<span class=\"label label-success\">Ativo</span>' : '<span class=\"label label-danger\">Inativo</span>',
               'type'=>DetailView::INPUT_SWITCH,
               'widgetOptions' => [
                   'pluginOptions' => [
                       'size' => 'mini',
                       'onText' => 'Ativo',
                       'offText' => 'Inativo',
                   ]
               ],
               ],\n";
        }elseif($column->type === 'date'){
            echo "            [
                'attribute'=>'$column->name',
                'format'=>['date',(isset(Yii::\$app->modules['datecontrol']['displaySettings']['date'])) ? Yii::\$app->modules['datecontrol']['displaySettings']['date'] : 'd-m-Y'],
                'type'=>DetailView::INPUT_WIDGET,
                'widgetOptions'=> [
                    'class'=>DateControl::classname(),
                    'type'=>DateControl::FORMAT_DATE
                ]
            ],\n";

        }elseif($column->name === 'image'){
                echo "            [
                'attribute'=>'image',
                'format'=>'raw',
                'displayOnly'=>true,
                'value'=>(\$model->image)?
                            Lightbox::widget([
                        'files' => [
                            [
                                'thumb' => \$model->getThumbnailTrue(),
                                'original' => \$model->image,
                                'title' => 'Imagem',
                            ],
                        ],
                ]).\"<br>\". Html::a('Alterar Imagem',\"/admin/\".Yii::\$app->controller->id.\"/update?id=\".\$model->id,['class' => 'btn btn-default'])
                 : 
                  Html::a('Adicionar Imagem',\"/admin/\".Yii::\$app->controller->id.\"/update?id=\".\$model->id, ['class' => 'btn btn-default']) ],\n";
        }elseif($column->type === 'time'){
            echo "            [
                'attribute'=>'$column->name',
                'format'=>['time',(isset(Yii::\$app->modules['datecontrol']['displaySettings']['time'])) ? Yii::\$app->modules['datecontrol']['displaySettings']['time'] : 'H:i:s A'],
                'type'=>DetailView::INPUT_WIDGET,
                'widgetOptions'=> [
                    'class'=>DateControl::classname(),
                    'type'=>DateControl::FORMAT_TIME
                ]
            ],\n";
        }elseif($column->type === 'datetime' || $column->type === 'timestamp'){
            echo "            [
                'attribute'=>'$column->name',
                'format'=>['datetime',(isset(Yii::\$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::\$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A'],
                'type'=>DetailView::INPUT_WIDGET,
                'widgetOptions'=> [
                    'class'=>DateControl::classname(),
                    'type'=>DateControl::FORMAT_DATETIME
                ]
            ],\n";
        }else{
            echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        }
    }
}
?>
        ],

        'enableEditMode'=>true,
    ]) ?>
    <div class="footer footer-view">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <?= "<?= " ?> Html::a('<i class="glyphicon glyphicon-th-list"></i> Lista',"/".Yii::$app->controller->id,['class' => 'btn btn-default isDisabled','disabled'=>!Mimin::checkRoute($this->context->id.'/index')]); ?>
             <?= "<?= " ?> Html::a('<i class="glyphicon glyphicon-plus"></i> Adicionar Novo',"/".Yii::$app->controller->id."/cadastrar",['class' => 'btn btn-warning isDisabled','disabled'=>!Mimin::checkRoute($this->context->id.'/cadastrar')]); ?>
             <?= "<?= " ?> Html::a('<i class="glyphicon glyphicon-pencil"></i> Editar',"/".Yii::$app->controller->id."/atualizar?id=".$model->id,['class' => 'btn btn-warning isDisabled','disabled'=>!Mimin::checkRoute($this->context->id.'/atualizar'),'data' => [
            'method' => 'post',
            ]]); ?>
      
        </div>
        </div>
    </div> 

</div>
 </div></div>
