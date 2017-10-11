<?php
use yii\helpers\Html;


app\assets\AdminAssets::register($this);

    $directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
    ?>
    <?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
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
    <body class="skin-red sidebar-mini fixed">
    <script>
    (function () {
      if (Boolean(sessionStorage.getItem('sidebar-toggle-collapsed'))) {
        var body = document.getElementsByTagName('body')[0];
        body.className = body.className + ' sidebar-collapse';
      }
    })();
    
    
    </script>
    <?php
    echo uran1980\yii\widgets\pace\Pace::widget([
        'color' => 'white',
        'theme' => 'flash',
        'paceOptions' => [
            'ajax'      => true,
            'document'  => true,
        ],
    ]);
    ?>
    <?php $this->beginBody() ?>
    <div class="wrapper">

        <?= $this->render(
            'header.php',
            ['directoryAsset' => $directoryAsset]
        ) ?>

        <?= $this->render(
            'left.php',
            ['directoryAsset' => $directoryAsset]
        )
        ?>

        <?= $this->render(
            'content.php',
            ['content' => $content, 'directoryAsset' => $directoryAsset]
        ) ?>

    </div>

    <?php $this->endBody() ?>
    </body>
    </html>
    <?php $this->endPage() ?>

