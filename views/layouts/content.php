<?php
use dmstr\widgets\Alert;
use yii\widgets\Breadcrumbs;

?>
<div class="content-wrapper" id="conteudo-wrapper">
    <section class="box box-solid flat titulo-conteudo">
        <div class="row">
        <div class="col-md-8">
            <h1>
                <?php
                
                if ($this->title !== null) {
                    if(Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id == 'index'){
                        echo "Olá, ". Yii::$app->user->identity->nome;
                    }else{
                        echo \yii\helpers\Html::encode($this->title);
                    }
                       
                    
                } else {
                    echo \yii\helpers\Inflector::camel2words(
                        \yii\helpers\Inflector::id2camel($this->context->module->id)
                    );
                    echo ($this->context->module->id !== \Yii::$app->id) ? '<small>Modulos</small>' : '';
                } ?>

            </h1>
        </div>
        <?php if((Yii::$app->controller->action->id == 'index' || Yii::$app->controller->action->id == 'enviado') && 
                !(Yii::$app->controller->action->id == 'index' && Yii::$app->controller->id == 'site') && 
                !(Yii::$app->controller->id == 'perfil') && 
                !(Yii::$app->controller->id == 'instituicao')&& !(Yii::$app->controller->id == 'apresentacao')): ?>
        <div class="col-md-4 col-lg-4">
            <form action="/<?= Yii::$app->controller->id ?>" method="get" class="sidebar-form-p"  >
                <div class="input-group">
                    <input type="text" name="p" class="pesquisar" value="<?= Yii::$app->request->get('p') ?>" placeholder="Pesquisar...">
                    <span class="input-group-btn">
                <button type="submit" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
                </div>
            </form>


        </div>
            <?php endif; ?>
        </div>

    </section>
    <section class="bread">
        <?=
        Breadcrumbs::widget(
            [
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]
        ) ?>
    </section>

    <section class="content" id="conteudo">
        <?= Alert::widget() ?>

        <?= $content ?>

    </section>

</div>


<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Versão</b> <?= Yii::$app->version; ?>
    </div>
    <?php
        echo Yii::$app->params['footerPage'];
    ?>
</footer>

<!-- The Right Sidebar -->
<aside class="control-sidebar control-sidebar-light">
 <?php
    $log = \app\models\AuditLog::find()->where(['user_id'=> Yii::$app->user->id])->orderBy("data Desc")->limit(6)->all();
 ?>
    <ul class="list-unstyled list-group" style="margin: 10px;">
        <li style="margin-top: 20px; border-bottom: 1px solid #CCC"><h4><i class="glyphicon glyphicon-list"></i> Últimas Atividades</h4></li>
       <?php 
        foreach ($log as $lg):
       ?>
        <li style="margin-top: 10px; clear: both"><strong><?=$lg->model ?></strong>:: <?=$lg->acao ?><br><a href="/audit-log/visualizar?id=<?=$lg->id ?>" class="pull-right text-sm">Visualizar Atividade</a> <br>
            <small class="pull-right"><?=Yii::$app->formatter->asDate($lg->data,'long'); ?>&nbsp;<?=Yii::$app->formatter->asTime($lg->data,'short'); ?></small><br></li>
         
       <?php
  endforeach;
       ?>
                  <li style="margin-top: 10px; clear: both"><small>Estas são as 6 útimas atividades realizadas no sistema</small></li>
               
       
       
        
        
    </ul>
</aside>
<!-- The sidebar's background -->
<!-- This div must placed right after the sidebar for it to work-->
<div class="control-sidebar-bg"></div>