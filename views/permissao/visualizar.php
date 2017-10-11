<?php

use app\models\Route;
use kartik\alert\AlertBlock;
use kartik\detail\DetailView;
use yii\helpers\Html;
use yii\helpers\Url;


echo AlertBlock::widget([
    'useSessionFlash' => true,
    'type' => AlertBlock::TYPE_GROWL,
    'delay' => 0,

]);

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Permissão', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="auth-item-view">

    <div class="box margin-top20">

    <div class="box-body">


    <?= DetailView::widget([
        'model' => $model,
        'hover'=>true,
        
        'mode'=>Yii::$app->request->get('edit')=='t' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
        'buttons1'=>'{delete}',
        
        'fadeDelay'=>1,
        'updateOptions'=>['label'=>'<button type="button" class="kv-action-btn kv-btn-update" title="" data-toggle="tooltip" data-container="body" data-original-title="Edição Rápida"><i class="glyphicon glyphicon-pencil"></i></button>'],
        'panel'=>[
            'heading'=>'#'.$model->name,
            'type'=>DetailView::TYPE_DEFAULT,
        ],

        'attributes' => [
            'name',
        
            'description:ntext',
        
            [
              'attribute' => 'created_at',
              'value' => Yii::$app->formatter->asDate($model->created_at, 'long'),
            ],
            [
              'attribute' => 'updated_at',
              'value' => Yii::$app->getFormatter()->asDateTime($model->updated_at),
            ],
        ],
        'enableEditMode'=>false,
    ]) ?>

    <?php
   
   $types = Route::find()->select('type')->distinct()->where(['status' => 1])->all();
    echo "<table id='permissionTable' class='table table-striped table-hover table-bordered'>";
    echo "<tr class='text-danger titulo-permissao'>";
      echo "<th width='190'>Tipo</th>";
      echo "<th width='80' class='permissao-all'>Todas</th>";
      echo "<th  colspan='1' class='permissao-all'>Selecione as Permissões</th>";
        echo "</tr>";
    $auth = Yii::$app->authManager;
    $permissions = $auth->getPermissionsByRole($model->name);	
   $p = 0;
    foreach ($types as $type) {
      echo "<tr>";
          $teste = $type->type != null? $type->type:"";  
          echo "<th class='permissao-tipo'>" . $teste. "</th>";
        $p++;
      echo "<td class='permissao-all permissao-tipo'>";
      $aliass = Route::find()->where([
        'status' => 1,
        'type' => $type->type,
      ])->orderBy('ordem')->all();
      $i = '0';
      foreach ($aliass as $alias) {
        if($i < 1){
             if($type->type != null):  
              echo "<div class='row'>";
            echo "<label class='label-block'>";
            $can = array_key_exists($alias->name,$permissions);
            $checked = false;
            if($can) $checked = true;
            echo Html::checkbox($type->type.'_'.$alias->alias,$checked,[
              'title' => $alias->name,
              'class' => 'checkboxPermission',
            ]).' '.$alias->alias;
            echo "</label> <small style='color: #688590'>Todas</small>";
              echo "</div>";
          endif;
        }
        $i++;
      }
        echo "</td><td>";
        $i = '1';
        foreach ($aliass as $alias) {
            if($i > 1){
                echo "<div class='row'>";
                echo "<label class='label-block' style='width:300px !important'>";
                $can = array_key_exists($alias->name,$permissions);
                $checked = false;
                if($can) $checked = true;
                echo Html::checkbox($type->type.'_'.$alias->alias,$checked,[
                        'title' => $alias->name,
                        'class' => 'checkboxPermission',
                    ]).' '.$alias->alias;
                echo "</label>";
                 echo "</div>";
               
            }
            $i++;
            
        }
      echo "</td>";
      echo "</tr>";
    }
    //echo "</tbody>";
    echo "</table>";
    ?>
        <div class="footer footer-view">
            <div class="row">
                <div class="col-md-10 col-md-offset-2">
                    <?=  Html::a('<i class="glyphicon glyphicon-th-list"></i> Lista',"/".Yii::$app->controller->id,['class' => 'btn btn-default']); ?>
                    <?= Html::a('<i class="glyphicon glyphicon-ok"></i> Editar', ['atualizar', 'id' => $model->name], ['class' => 'btn btn-warning']) ?>
                       </div>
            </div>
        </div>
    </div>
    </div>


</div>
<?php
$this->registerJs('
    $(\'.checkboxPermission\').on(\'ifChanged\', function(event){if(!this.changed) {this.changed=true;setPermission($(this).attr("title"));
    } else {this.changed=false;setPermission($(this).attr("title"));}$(\'.select-on-check-all\').iCheck(\'update\');});function setPermission(permissionName){$.post( "'.Url::to(['permission','roleName'=>$model->name]).'&permissionName="+permissionName, function( data ) {});
  }');

$this->registerCss('
    .label-block{
        display:block;
        width:100px;
        float:left;
        overflow:hidden;
        font-weight: normal;
        font-size:80%;
        border-right:1px solid #ddd;
        margin-right:5px;
    }

    table#permissionTable tbody tr td, table#permissionTable tbody tr th{
        padding: 0px 5px !important;
    }
');