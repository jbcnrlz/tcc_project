<?php

use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;


$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

use yii\helpers\Html;
use kartik\alert\AlertBlock;



echo AlertBlock::widget([
            'useSessionFlash' => true,
            'type' => AlertBlock::TYPE_GROWL,
            'delay' => 0,
    
        ]);



$this->title = "Atualizar "."<?= $generator->tituloCrud; ?>";
$this->params['breadcrumbs'][] = ['label' => '<?= Html::decode($generator->tituloCrud) ?>', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model-><?= $generator->camposArray[1] ?>, 'url' => ['visualizar', <?= $urlParams ?>]];
$this->params['breadcrumbs'][] = "Atualizar";
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-atualizar">

    <?= "<?= " ?>$this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
