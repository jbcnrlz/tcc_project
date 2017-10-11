<?php
use yii\helpers\Html;

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['/redefinir-senha', 'token' => $user->password_reset_token]);
?>
<h1 class="titulo-email">Redefinir Senha</h1>
<br>
<p>Olá <strong><?= Html::encode($user->nome) ?>,</strong></p>
<p>Você está recebendo este e-mail porque você ou alguém solicitou uma redefinição de senha
   para sua conta no site <a href="<?php echo $_SERVER['HTTP_HOST'] ?>"><?php echo $_SERVER['HTTP_HOST'] ?></a></p>
<p>Você pode seguramente ignorar esta mensagem se você não solicitou esta redefinição de senha.</p>
<p>Caso tenha solicitado utilize o link abaixo para redefinir sua senha:</p>
<p><?= Html::a('Redefinir Senha', $resetLink,['class'=>'btn btn-primary']) ?></p>

<p>Atenciosamente,</p>

<p><?php echo Yii::$app->params['instituicao'] ?></p>
             