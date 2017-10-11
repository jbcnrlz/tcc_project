<?php
use yii\helpers\Html;

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['/redefinir-senha', 'token' => $user->password_reset_token]);
?>

<h1 class="titulo-email">Cadastro Atualizado com Sucesso!</h1>
<br>
<br>
<p>Olá <strong><?= Html::encode($user->nome) ?>,</strong></p>
<p>Seu cadastro para uso do sistema <a href="<?php echo $_SERVER['HTTP_HOST'] ?>"><strong><?= Yii::$app->name ?></strong></a>, foi ativado com sucesso!
<p>Lembrando que seu cadastro expira em <strong style="color:#C21D16"><?= Yii::$app->formatter->asDate($user->dta_expiracao); ?></strong>, após esta data você terá
    que solicitar a renovação entrando em contato com a <strong>secretária educacional</strong>.</p>
<p>Caso tenha dúvidas entre em contato conosco.</p>

<p>Atenciosamente,</p>

<p><?php echo Yii::$app->params['instituicao'] ?></p>

<p><strong style="color:#C21D16">PS.: Lembre-se sempre de seguir as datas de entregas/envio de projetos.</strong></p>
