<?php
use app\components\Mimin;

?>


<aside class="main-sidebar">

    <section class="sidebar">
        <?php

            $orientando = app\models\Projeto::find()->where(['orientador_id'=> Yii::$app->user->id,'status'=>1])->count();
            
            $designados = app\models\Projeto::find()->innerJoinWith(['matriculaRa','arquivosProjetos'])->where(['and',
                [
                    'orientador_sugestao_id'=> Yii::$app->user->id,
                    'matricula.etapa_projeto'=>1,
                    'arquivos_projeto.etapa_projeto'=>1,
                    'projeto.status'=>1
                ]
                ])->count();
            
         
            
            
            $mensagem = \app\models\Mensagem::find()->where(['destinatario_id'=>Yii::$app->user->id, 'lido'=>0])->count();
            $labelMensagem = ''; 
            if($mensagem > 0){
                    $labelMensagem = '<span class="pull-right-container"><span class="label label-primary pull-right">'.$mensagem.'</span></span>';
             }
             $labelorientando = ''; 
            if($orientando > 0){
                    $labelorientando = '<span class="pull-right-container"><span class="label label-primary pull-right">'.$orientando.'</span></span>';
             }
             $labeldesignados = ''; 
            if($designados > 0){
                    $labeldesignados = '<span class="pull-right-container"><span class="label label-primary pull-right">'.$designados.'</span></span>';
             }
             
              $menuItems = [
                    ['label' => 'Projeto Acadêmico', 'options' => ['class' => 'header']],
                  
                    (Yii::$app->user->can("Aluno"))?['label' => '<span>Meu Projeto</span>', 'icon' => 'fa fa-tag', 'url' => ['/projeto/meu-projeto'],'encode'=>false]:'',
                         ['label' => '<span>Projetos</span>', 'icon' => 'fa fa-tags', 'url' => ['/projeto/index'],'encode'=>false],
                         ['label' => '<span>Sem Orientador</span>', 'icon' => 'fa fa-hourglass-half', 'url' => ['/projeto/projeto-protocolado'],'encode'=>false],
                         ['label' => '<span>Orientando</span>'.$labelorientando, 'icon' => 'fa fa-users', 'url' => ['/projeto/projeto-orientando'], 'encode'=>false],
                         ['label' => '<span>Designados</span>'.$labeldesignados, 'icon' => 'fa fa-user-plus', 'url' => ['/projeto/projeto-designado'], 'encode'=>false],
                         ['label' => '<span>Mensagens</span>'.$labelMensagem, 'icon' => 'fa fa-inbox', 'url' => ['/mensagem/index'],'encode'=>false],
            
                    (!Yii::$app->user->can("Aluno") && (
                            (Mimin::checkRoute('/apresentacao/banca')) ||
                     (Mimin::checkRoute('/apresentacao/index')) ||
                     (Mimin::checkRoute('/calendario-academico/index')) ||
                     (Mimin::checkRoute('/mural-recados/index')) ||
                     (Mimin::checkRoute('/dta-protocolar/index')) 
                     
                            ))?['label' => 'Cadastros', 'options' => ['class' => 'header']]:'',
                    ['label' => '<span>Banca</span>', 'icon' => 'fa fa-legal', 'url' => ['/apresentacao/banca'],'encode'=>false],
                    ['label' => '<span>Apresentação</span>', 'icon' => 'fa fa-slideshare', 'url' => ['/apresentacao/index'],'encode'=>false],
                    ['label' => '<span>Calendário Acadêmico</span>', 'icon' => 'fa fa-calendar', 'url' => ['/calendario-academico/index'],'encode'=>false],
                    ['label' => '<span>Mural de Recados</span>', 'icon' => 'fa fa-newspaper-o', 'url' => ['/mural-recados/index'],'encode'=>false],
                    ['label' => '<span>Agendar Protocolos</span>', 'icon' => 'fa fa-clock-o', 'url' => ['/dta-protocolar/index'],'encode'=>false],
                    ['label' => '<span>Protocolos</span>', 'icon' => 'fa fa-tags', 'url' => ['/protocolos/index'],'encode'=>false],
                
              
                    (!Yii::$app->user->can("Aluno") && ( 
                     (Mimin::checkRoute('/usuario/index')) ||
                     (Mimin::checkRoute('/curso/index')) ||
                     (Mimin::checkRoute('/configuracao-app/index')) ||
                     (Mimin::checkRoute('/instituicao/index')) ||
                     (Mimin::checkRoute('/permissao/index')) ||
                      (Mimin::checkRoute('/audit-log/index')))
                  )?['label' => 'Configuração', 'options' => ['class' => 'header']]:'',                   
                    ['label' => '<span>Usuários</span>', 'icon' => 'fa fa-user', 'url' => ['/usuario/index'],'encode'=>false],
                    ['label' => '<span>Cursos</span>', 'icon' => 'fa  fa-graduation-cap', 'url' => ['/curso/index'],'encode'=>false],
                    ['label' => '<span>Configurações</span>', 'icon' => 'fa fa-gears', 'url' => ['/configuracao-app/index'],'encode'=>false],
                    ['label' => '<span>Instituição</span>', 'icon' => 'fa fa-institution', 'url' => ['/instituicao/index'],'encode'=>false],
                    ['label' => '<span>Permissões</span>', 'icon' => 'fa fa-unlock-alt', 'url' => ['/permissao/index'],'encode'=>false],
                    ['label' => '<span>Auditoria Log</span>', 'icon' => 'fa fa-exclamation-circle', 'url' => ['/audit-log/index'],'encode'=>false],
                   ];
              
               
//             
            
          $menuItems = Mimin::filterMenu($menuItems);

        ?>
        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => $menuItems
            ]
        ) ?>

    </section>

</aside>
