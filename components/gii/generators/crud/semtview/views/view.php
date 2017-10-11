<?php

use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/**
 * @var yii\web\View $this
 * @var yii\gii\generators\crud\Generator $generator
 */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;
use branchonline\lightbox\Lightbox;
use kartik\alert\AlertBlock;



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
  

    <?= "<?= " ?>DetailView::widget([
            'model' => $model,
            'condensed'=>false,
            'hover'=>true,
            'mode'=>Yii::$app->request->get('edit')=='t' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
            'buttons1'=>'{update}',
            'panel'=>[
            'heading'=>'#'.$model->id,
            'type'=>DetailView::TYPE_DEFAULT,
        ],
        'attributes' => [
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
        'deleteOptions'=>[
            'url'=>['delete', 'id' => $model-><?=$generator->getTableSchema()->primaryKey[0]?>],
            'data'=>[
                'confirm'=>Yii::t('app', 'Deseja Realmente deletar o Registro?'),
                'method'=>'post',
            ],
        ],
        'enableEditMode'=>true,
    ]) ?>

</div>
