<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$matricula = new app\models\Matricula();
$curso = yii\helpers\ArrayHelper::map(\app\models\Curso::find()->all(),'id','nome');
$periodo = $matricula->periodos;


$form = ActiveForm::begin(['method' => 'get', 'action' => Url::to([Yii::$app->controller->action->id,'tab'=>$tab]),]);
?>

<div class="clearfix"></div>
<div class="filtro form-stylo" style="margin-right:10px;">

<?php if(Yii::$app->controller->action->id == "banca"): ?>
    <?= $form->field($model, 'etapa_projeto', ['template' => '<div class="col-md-3" style="padding-left:0px">{label}{input}</div>'])->dropDownList($matricula->etapasApresentacao,['prompt'=>''])->label('Etapa do Projeto'); ?>
    <?= $form->field($model, 'curso_id', ['template' => '<div class="col-md-4" style="padding-left:0px">{label}{input}</div>'])->dropDownList($curso,['prompt'=>''])->label('Curso') ?>
    <?= $form->field($model, 'periodo', ['template' => '<div class="col-md-2" style="padding-left:0px">{label}{input}</div>'])->dropDownList($periodo,['prompt'=>''])->label('Apresentação')  ?>
    <?= $form->field($model, 'status', ['template' => '<div class="col-md-2" style="padding-left:0px">{label}{input}</div>'])->dropDownList(['1'=>'Pendente','2'=>'Concluída'],['prompt'=>''])->label('Avaliação')  ?>

<?php else: ?>
    <?= $form->field($model, 'etapa_projeto', ['template' => '<div class="col-md-3" style="padding-left:0px">{label}{input}</div>'])->dropDownList($matricula->etapasApresentacao,['prompt'=>''])->label('Etapa do Projeto'); ?>
    <?= $form->field($model, 'curso_id', ['template' => '<div class="col-md-5" style="padding-left:0px">{label}{input}</div>'])->dropDownList($curso,['prompt'=>''])->label('Curso') ?>
    <?= $form->field($model, 'periodo', ['template' => '<div class="col-md-3" style="padding-left:0px">{label}{input}</div>'])->dropDownList($periodo,['prompt'=>''])->label('Período do Curso')  ?>


<?php endif; ?>

  <div class="col-md-1" style="padding-left:0px">
      <button type="submit" class="btn btn-default " style="margin-top:27px;"><i class="glyphicon glyphicon-filter"></i>&nbspFiltrar</button>
  </div>


</div>
<?php
ActiveForm::end();
?>