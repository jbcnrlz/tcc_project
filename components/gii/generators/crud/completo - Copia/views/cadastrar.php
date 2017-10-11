<?php

use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;


echo "<?php\n";
?>

use yii\helpers\Html;
use kartik\alert\AlertBlock;



echo AlertBlock::widget([
            'useSessionFlash' => true,
            'type' => AlertBlock::TYPE_GROWL,
            'delay' => 0,
    
        ]);



$this->title = "Cadastrar "."<?= $generator->tituloCrud; ?>";
$this->params['breadcrumbs'][] = ['label' => '<?= Html::decode($generator->tituloCrud) ?>', 'url' => ['index']];
$this->params['breadcrumbs'][] = "Cadastrar";
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-cadastrar">

    <?= "<?= " ?>$this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
