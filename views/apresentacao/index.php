<?php

use kartik\alert\AlertBlock;
use yii\helpers\Html;


echo AlertBlock::widget([
    'useSessionFlash' => true,
    'type' => AlertBlock::TYPE_GROWL,
    'delay' => 0,
]);



$this->title = "Agenda de Apresentação";
$this->params['breadcrumbs'][] = Html::decode($this->title);
?>


<div class="apresentacao-index">
  
    <div class="box">      
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                     
                    <ul class="nav nav-tabs" role="tablist" id="navtab-container">
                        <li role="menu" class="<?=(@$_GET['tab']=="agendado" || !isset($_GET['tab']))?'active':''; ?>"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-calendar"></i> Projetos Agendados</a></li>
                        <li role="menu" class="<?=(@$_GET['tab']=="pendente")?'active':''; ?>"><a href="#pendente" aria-controls="profile" role="tab" data-toggle="tab"><i class="fa fa-calendar-o"></i> Projetos Pendentes Para Agendamento</a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane <?=(@$_GET['tab']=="agendado" || !isset($_GET['tab']))?'active':''; ?>" id="home">
                            <?= $this->render('_gridApresentacao',['modelApresentacao'=>$modelApresentacao]); ?>
                        </div>
                        <div role="tabpanel" class="tab-pane <?=(@$_GET['tab']=="pendente")?'active':''; ?>" id="pendente">
                            <?= $this->render('_gridProjetosAprovados',['modelProjetosAprovados'=>$modelProjetosAprovados]); ?>
            
                        </div>
                    </div>
                </div>

            </div>


        </div>

    </div> <!--end box -->

</div>

