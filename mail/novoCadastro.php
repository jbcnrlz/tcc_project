<?php
use yii\helpers\Html;

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['usuario']);

?>

<h1 class="titulo-email">Novas Solicitaçãos de Cadastros</h1>
<br>
<p>Existem novo(s) de cadastro(s) no sistema <a href="<?php echo $_SERVER['HTTP_HOST'] ?>"><strong><?= Yii::$app->name ?></strong></a>.</p>
<p>Por favor verifique o mais breve possivel.</p>
<p><?= Html::a('Verificar', $resetLink,['class'=>'btn btn-primary']) ?></p>

<p>Att,</p>

<p><?php echo Yii::$app->params['instituicao'] ?></p>
<p>
 <?= Yii::$app->formatter->asDatetime(strtotime(date('Y-m-d H:i')), 'full'); ?>

             