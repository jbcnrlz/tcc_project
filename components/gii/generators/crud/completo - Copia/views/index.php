<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;


$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

echo "<?php\n";


?>
use kartik\editable\Editable;
use yii\helpers\Html;
use <?= $generator->indexWidgetType === 'grid' ? "kartik\\grid\\GridView" : "yii\\widgets\\ListView" ?>;
use yii\widgets\Pjax;
use kartik\alert\AlertBlock;



echo AlertBlock::widget([
            'useSessionFlash' => true,
            'type' => AlertBlock::TYPE_GROWL,
            'delay' => 0,
    
        ]);

$this->title = "<?= $generator->tituloCrud; ?>";
$this->params['breadcrumbs'][] = Html::decode($this->title);
?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-index">
 
    <div class="box">      
        <div class="box-body">
<?php if ($generator->indexWidgetType === 'grid'): ?>
    <?= "<?php Pjax::begin(['id' => 'gridData']); echo " ?>GridView::widget([
        'dataProvider' => $dataProvider,
        <?= !empty($generator->searchModelClass) ? "///'filterModel' => \$buscarModel,\n        'columns' => [\n" : "'columns' => [\n"; ?>
         
           [
            'class' => '\kartik\grid\CheckboxColumn',
            'checkboxOptions' => [
                'class' => 'simple'
                'data-toggle'=>'checkbox',
            ],
            //'pageSummary' => true,
            'rowSelectedClass' => GridView::TYPE_SUCCESS,
            ],

<?php
$count = 0;
if (($tableSchema = $generator->getTableSchema()) === false) {
    foreach ($generator->getColumnNames() as $name) {
        if (++$count < 6) {
            echo "            '" . $name . "',\n";
        } else {
            echo "            // '" . $name . "',\n";
        }
    }
} else {
    foreach ($tableSchema->columns as $column) {
        $format = $generator->generateColumnFormat($column);
    
        if($column->type === 'date'){
            $columnDisplay[$column->name] = "            ['attribute'=>'$column->name', 'width'=>'','format'=>['date',(isset(Yii::\$app->modules['datecontrol']['displaySettings']['date'])) ? Yii::\$app->modules['datecontrol']['displaySettings']['date'] : 'd-m-Y']],";
        }elseif($column->type === 'time'){
            $columnDisplay[$column->name] = "            ['attribute'=>'$column->name', 'width'=>'','format'=>['time',(isset(Yii::\$app->modules['datecontrol']['displaySettings']['time'])) ? Yii::\$app->modules['datecontrol']['displaySettings']['time'] : 'H:i:s A']],";
        }elseif($column->type === 'datetime' || $column->type === 'timestamp'){
            $columnDisplay[$column->name] = "            ['attribute'=>'$column->name', 'width'=>'','format'=>['datetime',(isset(Yii::\$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::\$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']],";
        }elseif($column->name == 'status'){            
            $columnDisplay[$column->name] = "           ['class' => '\kartik\grid\BooleanColumn',
             'attribute'=>'status',
             'trueLabel' => 'Ativo', 
             'falseLabel' => 'Inativo'
            
            ],";
         }elseif($column->name == 'role'){            
            $columnDisplay[$column->name] = " ['class' => 'kartik\grid\DataColumn']";
      
        
        }elseif(($k = array_search($column->name, $generator->campoEditavelArray)) !== FALSE){ 
                $columnDisplay[$column->name] = "                   [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => '$column->name',
                'width'=>'',
                'pageSummary' => true,
                'readonly' => false,
                'content' => function(\$data){return '<div class=\"text_content\">'.htmlentities(\$data->$column->name).'</div>';},
                'editableOptions' => [
                    'inputType' => Editable::INPUT_TEXT,
                    'asPopover' => true,
                    
                ],
            ], ";
        
        
        }else{
            $columnDisplay[$column->name] = "         [
                    'attribute' => '$column->name',
                    'width'=>''],";
        };
    }
        foreach ($generator->camposArray as $cp){
           foreach($columnDisplay as $chave => $campo){
               if($cp == $chave){
                  echo $campo ."\n";
           }
        }

        }
}
?>

            [
                'class' => 'kartik\grid\ActionColumn',
                 'dropdown' => false,
                 'vAlign' => 'middle',
                  'width' => '100px',
                'viewOptions' => ['class'=>'btn btn-xs btn-default','title' => 'view', 'data-toggle' => 'tooltip', 'url'=>'visualizar', 'title'=>'Visualizar'],
                'updateOptions' => ['class'=>'btn btn-xs btn-primary','title' => 'update', 'data-toggle' => 'tooltip',  'url'=>'atualizar', 'title'=>'Atualizar'],

                'deleteOptions' => ['class'=>'btn btn-xs btn-danger','title' => 'delete', 'data-toggle' => 'tooltip',  'title'=>'Deletar'],
  
               
            ],
          
        ],
        'resizableColumns'=>true,
        'persistResize'=>true,
        'resizeStorageKey'=>Yii::$app->user->id . '-' . date("m"),
        'responsive'=>true,
        'hover'=>true,
        'condensed'=>true,
        'floatHeader'=>false,
        'responsiveWrap'=>true,
        'panelTemplate'=>' {panelBefore}{items}{summary}<div class="text-center">{pager}</div>',
        'pjax'=>true,
        'pjaxSettings'=>[
            'loadingCssClass'=>true,
        ],
          'toolbar'=> [
        ['content'=> 
                    Html::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'button', 'title' => 'Deletar Selecionados ' . $this->title, 'class' => 'btn btn-danger', 'id' => 'deleteSelected']) . ' ' .
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>/index','p_reset'=>true], ['data-pjax' => 1, 'class' => 'btn btn-default', 'title' => 'Atualizar']). ' '
        ],
         '{toggleData}',
        '{export}',
       
    ],

        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
            'type'=>'info',
            'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> Adicionar', ['create'], ['data-pjax' => 0,'class' => 'btn btn-success']),                                                                                                                                                          'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
            'showFooter'=>false
        ],
    ]); Pjax::end(); ?>
<?php else: ?>
    <?= "<?= " ?>ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            return Html::a($model->tituloSite, ['view', <?= $urlParams ?>]);
        },
    ]) ?>
<?php endif; ?>
    </div>

    </div> <!--end box -->

</div>

<?php echo "<?php \n";?>
$this->registerJs('$(document).on("click","#deleteSelected",function(){
var array = "";
$(".simple").each(function(index){
    if($(this).prop("checked")){
        array += $(this).val()+",";
    }
})
if(array==""){
bootbox.alert("Nenhum registro selecionado?");
} else {
    bootbox.confirm("Tem certeza que deseja deletar os registros selecionados?",function(result) {
    if(result){   
    $.ajax({
            type:"POST",
            url:"'.Yii::$app->urlManager->createUrl(['<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>/delete-all']).'",
            data :{pk:array},
            success:function(){
                location.href="";
            }
        });
        };
    });
}
});');?>