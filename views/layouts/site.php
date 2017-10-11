<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\SiteAsset;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;

SiteAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?=Html::encode(($this->title == '')?Yii::$app->name:Yii::$app->name." :: ".$this->title) ?></title>
    <link rel="apple-touch-icon-precomposed" sizes="152x152" href="/imagem/icon/book-stack---pile-de-livres-152-171409.png">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="/imagem/icon/book-stack---pile-de-livres-144-171409.png">
        <link rel="apple-touch-icon-precomposed" sizes="120x120" href="/imagem/icon/book-stack---pile-de-livres-120-171409.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/imagem/icon/book-stack---pile-de-livres-114-171409.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/imagem/icon/book-stack---pile-de-livres-72-171409.png">
        <link rel="apple-touch-icon-precomposed" href="/imagem/icon/book-stack---pile-de-livres-57-171409.png">
        <link rel="icon" href="/imagem/icon/book-stack---pile-de-livres-32-171409.png" sizes="32x32">
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>


    <?php
    NavBar::begin([
        'brandLabel' => 'Software TCC',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'Corpo Docente', 'url' => ['/site/corpo-docente']],
            ['label' => 'Materiais de Apoio', 'url' => ['/site/material']],
            ['label' => 'Contato', 'url' => ['/site/contato']],

        ],
    ]);
    NavBar::end();
    ?>

    <div class="container main">
 
        <?= $content ?>
        <br>
    </div>


<footer class="footer">
    <div class="container">
      
        <img src="/imagem/logo-fatec-p.png" height="40" class="pull-left" alt="Fatec Garça" />
        <p class="pull-left"><?= Yii::$app->params['footerPage']; ?></p>
        <img src="/imagem/logo-saopaulo-p.png" height="40" class="pull-right" alt="Governo do Estado de São Paulo" />
        <img src="/imagem/logo-cps-p.png" height="40" class="pull-right" alt="Centro Paula Souza" />
       
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
