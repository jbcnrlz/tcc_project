<?php

use bupy7\cropbox\Cropbox;
use yii\helpers\Html;

?>

       <div id="<?= $this->context->id; ?>" class="cropbox">
      <div class="modal-body" style="height: 330px !important;">

    <div class="alert alert-info"></div>
    <div class="workarea-cropbox">
        <div class="bg-cropbox">
            <img class="image-cropbox">
            <div class="membrane-cropbox"></div>
        </div>
        <div class="frame-cropbox">
            <div class="resize-cropbox"></div>
        </div>
    </div>
    
  
    

   
            <?php 
            if (!empty($this->context->originalImageUrl)) {
                ?>
     <div class="cropped text-center">
        <p><?php
                echo Html::a(
                    '<i class="glyphicon glyphicon-eye-open"></i> ' . Cropbox::t('Show original'), 
                    $this->context->originalImageUrl, 
                    [
                        'target' => '_blank',
                        'class' => 'btn btn-info',
                    ]
                );
                ?>
                </p>
         </div>
     <?php
            } 
                  ?>
        
        <?php
        if (!empty($this->context->previewImagesUrl)) {
            ?>
    <div class="cropped text-center">
        <?php
    
            foreach ($this->context->previewImagesUrl as $url) {
                if (!empty($url)) {
                    echo Html::img($url, ['class' => 'img-thumbnail']);
                }
            }
            ?>
    </div>
    <?php
        }
        ?>
   
    <?= Html::activeHiddenInput($this->context->model, $this->context->attributeCropInfo); ?>
</div>

     <div class="modal-footer">
         <a tabindex="0"
   class="btn btn-warning pull-left" 
   role="button" 
   data-html="true" 
   data-toggle="popover" 
   data-trigger="focus" 
   data-placement="top" 
   title="Instruções:" 
   data-content="Faça a escolha da <strong>imagem</strong> e selecione a <strong>área de corte</strong>.<br>Para <strong>reduzir o tamanho</strong> da imagem para enquadrar na <strong>marca de corte</strong>, leve o cursor até a área cinza transparente e utilize o <strong>Scroll do Mouse </strong><br>Após este processo de seleção, clique em <strong>Cortar</strong> e depois em <strong>Salvar</strong>.
           <br>Só será permitido <strong>arquivos JPG</strong>."><i class="glyphicon glyphicon-question-sign"></i></a>
         
        <span class="btn btn-primary btn-file">
        <?= '<i class="glyphicon glyphicon-folder-open"></i> Abrir Foto'
             
            . Html::activeFileInput($this->context->model, $this->context->attribute, $this->context->options); ?>
        </span>
        <?= Html::button('<i class="glyphicon glyphicon-scissors"></i> ' . Cropbox::t('Crop'), [
            'class' => 'btn btn-warning btn-crop',
        ]); ?>
     
           <?=  Html::submitButton('<i class="glyphicon glyphicon glyphicon-ok"></i> Salvar',  ['class' =>  'btn btn-warning btn-salvar-crop', 'disabled'=>true]); ?>
       
        <?= Html::a('<i class="fa fa-ban"></i> Cancelar','javascript:;', ['class' => 'btn btn-default btn-reset', 'data-dismiss'=>"modal", 'id'=>'cancelarmodal']) ?>
      
     </div>  </div>  

<?php
    $this->registerJs(
            "
              $('.btn-crop').on('click',function(){
                 $('.btn-salvar-crop').removeAttr('disabled');
              });
              
               ");
    

?>