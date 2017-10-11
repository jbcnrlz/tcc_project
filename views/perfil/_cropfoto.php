<?php

use bupy7\cropbox\Cropbox;
use kartik\builder\Form;
use kartik\widgets\ActiveForm;

?>
<div class="modal fade" id="modal-crop" tabindex="-1" role="dialog" aria-labelledby="EditarFoto">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        
        <h4 class="modal-title" id="myModalLabel">Editar Foto</h4>
      </div>
 <?php     $form = ActiveForm::begin([
                  'options' => ['enctype' => 'multipart/form-data'],
                      'type' => ActiveForm::TYPE_VERTICAL,
                 'fieldConfig' => [
        'template' => "<div class='col-md-12'>{label}{input}{error}</div>",
      
    ],
       
    ]);?>

             

        
             
            <?php
       
                   $arquivo = Yii::getAlias('@app/upload/avatarPerfil/').$fotoAtual;
         
                if(file_exists($arquivo) && $fotoAtual != ""){
                          $arquivoCrop = '/upload/avatarPerfil/'.$fotoAtual;

                    }else{
                          $arquivoCrop = '/upload/avatarPerfil/SemImagem.jpg';
                 }
                    ?>
                 
                       <?= $form->field($model, 'foto',['template' => "<div class='col-md-12'>{input}</div>\n{hint}\n{error}"])->label(false)->widget(Cropbox::className(), [
                'attributeCropInfo' => 'crop_info',
                'pluginOptions'=>[
        
                    'imageOptions'=>[
                        'class'=> 'img-thumbnail',
                        'style'=> 'margin-right: 5px; margin-bottom: 5px'
                    ],
            
                   'variants'=> [
                    [
                        'width'=> 200,
                        'height'=> 200,
                        'minWidth'=> 200,
                        'minHeight'=> 200,
                        'maxWidth'=> 200,
                        'maxHeight'=> 200
                    ],
                 
                   
                    ],
                ],
                  'previewImagesUrl' => [$arquivoCrop],
                  'pathToView'=>'@app/views/widgets/views/field-crop'

                     
            ]); ?>
             
      
        <?php ActiveForm::end(); ?>
        <div class="clearfix"></div>
</div></div></div>
       