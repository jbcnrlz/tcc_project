<?php

/* @var $this yii\web\View */

$this->title = "Material de Apoio";
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
    .lista-material a{
        text-decoration: none;
        display: block;
    }
</style>
<div class="lista-material">
    <h1>Material de Apoio</h1>
    <br>
    <?=$model->valor ?>

    
</div>
