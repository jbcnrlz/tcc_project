<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

echo "<?php\n";
?>

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\widgets\FileInput;
use kartik\widgets\SwitchInput;
use bajadev\ckeditor\CKEditor;
use kartik\widgets\DatePicker;



?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form margin-top20">

	<div class="box box-default padding-botton20">
             <?= "<?php " ?>
    $form = ActiveForm::begin([
    'type' => ActiveForm::TYPE_HORIZONTAL,
    'fieldConfig' => [
        'template' => "{label}\n<div class='col-md-10'>{input}</div>\n<div class='col-md-offset-2 col-md-10'>{error}</div>",
        'labelOptions'=> ['class'=>'control-label col-md-2'],
    ],
    'options' => ['enctype' => 'multipart/form-data']
    ]);?>

    <?php // echo $form->errorSummary($model); ?>
    
		<div class="box-body">

    <div class="row">
        <div class="col-lg-12 form-stylo margin-top20">
        <?php
        $fields = [];
        $num = 1;
        $count = $generator->getColumnNames();
        $exception = $generator->exceptionsArray;
        foreach ($generator->getColumnNames() as $attribute) {
            $column = $generator->getTableSchema()->columns[$attribute];
            $type = $generator->getTableSchema()->columns[$attribute]->type;
                   
            if (in_array($attribute, $safeAttributes)) {
                
                if ($attribute == 'status' && !in_array($attribute, $exception)) {
                     $ordem[$attribute] = "<?php
                    echo \$form->field(\$model, 'status',['options'=>['class'=>'form-group input-status']])->dropdownlist(['0'=>'Inativo','1'=>'Ativo']);
                    ?>";
               }elseif ($attribute == 'image' && !in_array($attribute, $exception)) {
                  $ordem[$attribute] =  '<?php
                    $plugins = ["options"=>["accept"=>"image/*"]];
                    if ($model->image) {
                        $plugins = [
                                "options"=>["accept"=>"image/*"],
                                "pluginOptions" => ["initialPreview" => [kartik\helpers\Html::img($model->thumbnailTrue, ["class" => "file-preview-image"])]]
                                ];
                     }
                    echo $form->field($model, "image")->widget(FileInput::classname(),$plugins);
                    ?>';
                 } elseif($attribute == 'descricao' && !in_array($attribute, $exception)) {
                    if($generator->editor){
                         $ordem[$attribute] =   '<?= $form->field($model, "descricao")->widget(CKEditor::className(), [
                            "editorOptions" => [
                                "preset" => "basic",           
                                "inline" => false,
                                "filebrowserBrowseUrl" => "browse-images",
                                "filebrowserUploadUrl" => "upload-images",
                                "extraPlugins" => "imageuploader,youtube",
                            ]
                        ]);?>';
                    }else{
                        $ordem[$attribute] =  '<?= $form->field($model, "descricao")->textarea(["rows"=>4]); ?>';
                    }
                   
                }elseif ($type=='date' && !in_array($attribute, $exception)){
                    $ordem[$attribute] =   '<?=
                    $form->field($model, "'.$attribute.'")->widget(DatePicker::classname(), [
                    "options" => ["placeholder" => "Entre com a Data ..."],
                    "pluginOptions" => [
                        "autoclose" => true,
                        "format" => "yyyy-mm-dd"
                    ]
                ])
                 ?>';
                } else {
                    if(!in_array($attribute, $exception))
                       $ordem[$attribute] =  "\n            <?= " . $generator->generateActiveField($attribute) . " ?>\n";
                }
                
            }
            $num++;
        }
        ?>
           <?php
           
           foreach ($generator->ordemFormArray as $cp){
                foreach($ordem as $chave => $campo){
                    if($cp == $chave){
                       echo $campo ."\n";
                }
             }
             
           }
           
           ?>
            
            
        </div>

    </div>
 
    </div>

       


               <div class="footer footer-view">
    <div class="row">
        <div class="col-md-10 col-md-offset-2">
                         <?= "<?= " ?> Html::submitButton($model->isNewRecord ? '<i class="glyphicon glyphicon glyphicon-ok"></i> Salvar' : '<i class="glyphicon glyphicon glyphicon-ok"></i> Atualizar', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']); ?>
        <?= "        <?= " ?>Html::a('<i class="fa fa-ban"></i> Cancelar','javascript:;', ['class' => 'btn btn-default', 'id'=>'cancelar']) ?>
      
        </div>
        </div>
    </div> <?= "<?php " ?>ActiveForm::end(); ?>
                </div></div>
