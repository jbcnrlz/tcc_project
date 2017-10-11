<?php
use yii\helpers\Html;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */
/* @var $content string main view render result */
?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset ?>" />
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
 <?php $this->beginBody() ?>
    <style type="text/css">
        .btn-primary {
            color: #fff;
            background-color: #1668B9;
            border-color: #2e6da4;
        }

        .btn {
            display: inline-block;
            padding: 6px 12px;
            margin-bottom: 0;
            font-size: 14px;
            font-weight: 400;
            line-height: 1.42857143;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            -ms-touch-action: manipulation;
            touch-action: manipulation;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            background-image: none;
            border: 1px solid transparent;
            border-radius: 4px;
        }
       
         
        body{
            background: #fefdfc;
            font-family: verdana, arial, helvetica;
            color:#283337;
            line-height: 18px;
         }
         a{
             text-decoration:none;
         }
         .tb-body{
             padding: 20px;
             color:#4D6269 !important;
         }
         
        
         h1{
             font-size: 18px;
             text-align: center;
         }
         h2{
             font-size: 14px;
         }
         
       
        table{
            margin: 0 auto;
               border-radius: 3px;
            background: #fff;
            border-top: 3px solid #d2d6de;
            margin-bottom: 20px;
          
            box-shadow: 0 1px 1px rgba(0,0,0,0.1);
            
        }
    p{
         font-family: Verdana,Arial, Times, serif;
         font-size: 12px;
    }  
</style>
<table id="email" width="600" border="0" cellpadding="5" cellspacing="0">
    <tr>
        <td>
            <img src="<?php echo Yii::$app->params['header-email'] ?>" alt="F<?php echo Yii::$app->params['instituicao'] ?>"/>
        </td>
    </tr>    
     <tr>
         <td class="tb-body">
    
    <?= $content ?>
               
    </td>
    </tr>
     <tr>
         <td><a href="<?php echo Yii::$app->params['website-instituicao'] ?>" target="_blank"><img src="<?php echo Yii::$app->params['footer-email'] ?>" alt="<?php echo Yii::$app->params['instituicao'] ?>"/></a></td>
    </tr>
</table>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
