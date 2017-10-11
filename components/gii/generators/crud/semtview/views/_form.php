<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

/* @var $model \yii\db\ActiveRecord */
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

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form">
 <?= "<?php " ?>
    $form = ActiveForm::begin([
    'type' => ActiveForm::TYPE_HORIZONTAL,
    'options' => ['enctype' => 'multipart/form-data']   // important, needed for file upload
    ]);?>
    
    <?php // echo $form->errorSummary($model); ?>
	<div class="box box-default">

		<div class="box-body">
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form">
    

   

    <div class="row">
        <div class="col-lg-12">
        <?php
        $fields = [];
        $num = 1;
        $count = $generator->getColumnNames();
        $exception = $generator->exceptionsArray;
        foreach ($generator->getColumnNames() as $attribute) {
            $column = $generator->getTableSchema()->columns[$attribute];
            $type = $generator->getTableSchema()->columns[$attribute]->type;
                   
            if (in_array($attribute, $safeAttributes)) {
                
                if ($attribute == 'role' && !in_array($attribute, $exception)) {
                     $ordem[$attribute] = "<?php
                    echo \$form->field(\$model, 'role',['options'=>['class'=>'form-group input-status']])->dropdownlist(['20'=>'Colaborador','30'=>'Usuário', '40'=>'Administrador','50'=>'Super Administrador']);
                    ?>";
                }elseif ($attribute == 'posicao' && !in_array($attribute, $exception)) {
                     $ordem[$attribute] = "<?php
                    echo \$form->field(\$model, 'posicao',['options'=>['class'=>'form-group input-status']])->dropdownlist(['1'=>'Topo','2'=>'Direita', '3'=>'Base', '3'=>'Esquerda']);
                    ?>";
                }elseif ($attribute == 'status' && !in_array($attribute, $exception)) {
                     $ordem[$attribute] = "<?php
                    echo \$form->field(\$model, 'status',['options'=>['class'=>'form-group input-status']])->dropdownlist(['0'=>'Inativo','1'=>'Ativo']);
                    ?>";
                }elseif ($attribute == 'manutencao' && !in_array($attribute, $exception)) {
                     $ordem[$attribute] = "<?php
                    echo \$form->field(\$model, 'manutencao',['options'=>['class'=>'form-group input-status']])->dropdownlist(['0'=>'Desativado','1'=>'Ativado']);
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
            $form->field($model, "release")->widget(DatePicker::classname(), [
                "options" => ["placeholder" => "Enter date ..."],
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

       

</div>
               <div class="footer footer-view">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
              <?= "        <?= " ?> Html::a('Cancelar','/admin/'.Yii::$app->controller->id, ['class'=>'btn btn-default']) ?>
        <?= "        <?= " ?>Html::submitButton($model->isNewRecord ? <?= $generator->generateString('Salvar') ?> : <?= $generator->generateString('Atualizar') ?>, ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
      
        </div>
        </div>
    </div> <?= "<?php " ?>ActiveForm::end(); ?>
                </div></div></div>
