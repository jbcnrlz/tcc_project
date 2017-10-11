<?php

use kartik\alert\AlertBlock;
use kartik\builder\Form;
use kartik\widgets\ActiveForm;
use vova07\imperavi\Widget;
use yii\helpers\Html;
use yii\helpers\Url;


echo AlertBlock::widget([
            'useSessionFlash' => true,
            'type' => AlertBlock::TYPE_GROWL,
            'delay' => 0,
    
        ]);



$this->title = "Editar "."Página Material de Apoio";
$this->params['breadcrumbs'][] = ['label' => 'Configuração da Aplicação', 'url' => ['index']];
$this->params['breadcrumbs'][] = "Cadastrar";
?>
<div class="configuracao-app-cadastrar">

<div class="configuracao-app-form margin-top20">

	<div class="box box-default padding-botton20">
             <?php     $form = ActiveForm::begin([
    'type' => ActiveForm::TYPE_HORIZONTAL,
    'options' => ['enctype' => 'multipart/form-data']
    ]);?>

        
		<div class="box-body">

    <div class="row">
        <div class="col-lg-12 form-stylo margin-top20">
                   
           <?php
           
         

    echo $form->field($model, 'valor')->widget(Widget::className(), [
        
    'settings' => [
        'lang' => 'pt_br',
        'minHeight' => 500,
        'fileUpload' => Url::to(['/configuracao-app/file-upload']),
        'fileManagerJson' => Url::to(['/configuracao-app/files-get']),
        'imageUpload' => Url::to(['/configuracao-app/image-upload']),
        'plugins' => [
            'properties',
            'filemanager',
            'fullscreen',
            
            ]
        ]
    ])->label('Descrição');

               ?>

            
            
        </div>

    </div>
 
    </div>

       


               <div class="footer footer-view">
    <div class="row">
        <div class="col-md-10 col-md-offset-2">
                         <?=  Html::submitButton($model->isNewRecord ? '<i class="glyphicon glyphicon glyphicon-ok"></i> Salvar' : '<i class="glyphicon glyphicon glyphicon-ok"></i> Atualizar', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']); ?>
                <?= Html::a('<i class="fa fa-ban"></i> Cancelar','javascript:;', ['class' => 'btn btn-default', 'id'=>'cancelar']) ?>
      
        </div>
        </div>
    </div> <?php ActiveForm::end(); ?>
                </div></div>


</div>
