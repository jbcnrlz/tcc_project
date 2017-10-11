<?php
/* @var $this yii\web\View */

$this->title = 'Corpo Docente';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1>Corpo Docente</h1>
    <br></div>
<div class="row">
    <div class="col-md-12">   
        <?php foreach ($professores as $prof): ?>
        <div class="media">
            <div class="media-left"> 
                <a href="#">
                    <img alt="64x64" class="media-object img-circle" src="/upload/avatarPerfil/<?=($prof->foto!= '')?$prof->foto:"SemImagem.jpg"; ?>" data-holder-rendered="true" style="width: 120px; height: 120px; margin-right: 20px;">
                </a> 
            </div> 
            <div class="media-body">
                <h4 class="media-heading" style="font-weight: 600"><?=$prof->nome ?></h4>
                <h5 style="font-weight: 600; color:#3A5461">Linha de Pesquisa:</h5>
                <?=$prof->pesquisa ?>
                <a href="<?=$prof->lattes ?>" class="btn btn-warning" target="_blank">Curriculo Lattes</a>
        </div>
            <br>
        <?php endforeach;?>
        </div> <br><br>
    </div>
</div>

</div>
