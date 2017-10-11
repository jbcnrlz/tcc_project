<?php

use kartik\alert\AlertBlock;
use yii\helpers\Html;


echo AlertBlock::widget([
    'useSessionFlash' => true,
    'type' => AlertBlock::TYPE_GROWL,
    'delay' => 0,
]);



$this->title = "Banca de Apresentação";
$this->params['breadcrumbs'][] = Html::decode($this->title);
?>


<div class="apresentacao-index">
  
    <div class="box">      
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                     
                    
                            <?= $this->render('_gridBanca',['modelBanca'=>$modelBanca]); ?>
                       
                </div>

            </div>


        </div>

    </div> <!--end box -->

</div>

