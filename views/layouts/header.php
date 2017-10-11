<?php
use app\components\Mimin;
use app\models\AuditLog;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">APP</span><span class="logo-lg">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="javascript:;" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                  <i class="fa fa-dedent" style="font-size: 20px;"></i>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">
                <li>
                    <a href="javascript:;"id="btnFullscreen">
                        <i class="glyphicon glyphicon-fullscreen"></i>
                    </a>
                </li>

                 <?php
                    if((Yii::$app->user->identity->tipo == "Professor" && Yii::$app->user->can("Professor")) || (Yii::$app->user->identity->tipo == "Aluno" && Yii::$app->user->can("Aluno"))):
                      
                        $mensagem = \app\models\Mensagem::find()->where(['destinatario_id'=>Yii::$app->user->id, 'lido'=>0])->all();
        
                 
?>
                <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="glyphicon glyphicon-envelope"></i>
                        <span class="label label-warning"><?=count($mensagem); ?></span>
                    </a>
                  
                    <ul class="dropdown-menu">
                        <li class="header">Você tem <strong><?=count($mensagem); ?></strong> Mensagens</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <?php
                                    foreach($mensagem as $data):
                                ?>
                                <li><!-- start message -->
                                    <a href="#">
                                        <div class="pull-left">
                                            <?php
                                                echo Html::img('/upload/avatarPerfil/'.(($data->remetente->foto != '')?'/'.$data->remetente->foto:'SemImagem.jpg'),['class'=>'user-image pull-left','width'=>'50','height'=>'50']);
                                            ?>
                                        </div>
                                        <h4>
                                            <?=$data->remetente->nome ?>
                                            
                                        </h4>
                                        <p><?=$data->mensagem ?></p>
                                    </a>
                                </li>
                                <?php
                                    endforeach;
                                ?>
                                
                            </ul>
                        </li>
                        <li class="footer"><a href="/mensagem">Todas as Mensagens</a></li>
                    </ul>
                </li>
                <?php
                    endif;
                ?>
                 <?php
                    
                     if(Yii::$app->user->can("Super Administrador") || Mimin::checkRoute('/usuario/atualizar')):
                     $aluno = app\models\Usuario::find()->where(['status' =>  2,'tipo'=>"Aluno"])->all();
                 ?>
                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="glyphicon glyphicon-bell"></i>
                        <span class="label label-warning"><?=count($aluno); ?></span>
                    </a>
                    <ul class="dropdown-menu" style="width: 300px;">
                        <li class="header"><?='<strong>'.count($aluno).'</strong>'.' alunos aguardando sua ativação'; ?></li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <?php 
                                 $num = 0;
                                    foreach($aluno as $alu):
                                ?>
                                <li>
                                    <a href="/usuario/visualizar?id=<?=$alu->id ?>">
                                        <i class="fa fa-user-circle text-yellow"></i> <?=$alu->nome?>
                                        
                                    </a>
                                </li>
                                <?php
                                     $num++;
                                     if($num >= 5)
                                         break;
                                     
                                      endforeach;
                                ?>
                            </ul>
                        </li>
                        <li class="footer"><a href="/usuario">Visualizar Todos</a></li>
                    </ul>
                </li>
                <?php
                    endif;
                ?>
                <?php
                   
                        if(Yii::$app->user->can("Professor") || Mimin::checkRoute('/projeto/projeto-designado')):
                     $designados = app\models\Projeto::find()->innerJoinWith(['matriculaRa','arquivosProjetos'])->where(['and',
                    [
                        'orientador_sugestao_id'=> Yii::$app->user->id,
                        'matricula.etapa_projeto'=>1,
                        'arquivos_projeto.etapa_projeto'=>1,
                        'projeto.status'=>1
                    ]
                    ])->all();
                 ?>
                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="glyphicon glyphicon-duplicate"></i>
                        <span class="label label-warning"><?=count($designados); ?></span>
                    </a>
                    <ul class="dropdown-menu" style="width: 300px;">
                        <li class="header"><?='<strong>'.count($designados).'</strong>'.' projetos aguardando sua aceitação'; ?></li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <?php 
                                 $num = 0;
                                    foreach($designados as $des):
                                ?>
                                <li>
                                    <a href="/projeto/projeto-designado">
                                        <i class="fa fa-file text-yellow"></i> <?=$des->tema?><br>
                                        <small class="pull-right"><?=$des->matriculaRa->estudante->nome?></small>
                                        
                                    </a>
                                </li>
                               
                                <?php
                                     $num++;
                                     if($num >= 5)
                                         break;
                                     
                                      endforeach;
                                ?>
                            </ul>
                        </li>
                        <li class="footer"><a href="/projeto/projeto-designado">Visualizar Todos</a></li>
                    </ul>
                </li>
                <?php
                    endif;
                ?>

                <li class="dropdown user user-menu notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                          <?= Html::img('/upload/avatarPerfil/'.((Yii::$app->user->identity->foto != '')?Yii::$app->user->identity->foto:'SemImagem.jpg'),['class'=>'user-image']); ?>
                                 
                       
                        <span class="hidden-xs"><?= Yii::$app->user->identity->nome; ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <?php if(Yii::$app->user->identity->tipo == "Aluno"): 
                             $ra = Yii::$app->user->identity->matriculasAtiva->ra;
                             if($ra != ""){
                                 $projeto = \app\models\Projeto::find()->where(['matricula_ra'=>$ra])->one();
                                 if(count($projeto)>0){
                                     if($projeto->orientador_id != ""){
                           ?>
                        
                        <li class="header" style="font-size: 12px;"><?=($projeto->orientador->sexo=="M")?"Orientador":"Orientadora" ?><br>
                            <?=$projeto->orientador->nome?></li>
                        
                            <?php 
                                          
                                     }
                                 }
                             }
                             
                        
                            endif; ?>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <li>
                                    <a href="/perfil">
                                        <i class="glyphicon glyphicon-user text-danger"></i> Meu Perfil
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.sigacentropaulasouza.com.br/aluno" target="_blank">
                                        <i class="glyphicon glyphicon-education text-danger"></i> SIGA
                                    </a>
                                </li>
                                <li>
                                    <a href="http://www.fatecgarca.edu.br/" target="_blank">
                                        <i class="glyphicon glyphicon-new-window text-danger"></i> FATEC
                                    </a>
                                </li>
                                <li>
                                   <?= Html::a(
                                    '<i class="glyphicon glyphicon-log-out text-danger"></i> Sair',
                                    ['/site/logout']
                                   
                                ) ?>
                                </li>
                            </ul>
                        </li>
                        <?php
                           setlocale(LC_ALL, NULL);
                           setlocale(LC_ALL, 'pt_BR');
                            $reg = AuditLog::find()->where(['acao'=>'acessou'])->orderBy(['id' => SORT_DESC])->offset(1)->one();
                            if(count($reg)==0){
                                $reg = AuditLog::find()->where(['acao'=>'acessou'])->orderBy(['id' => SORT_DESC])->one();
                            }
                           
                           
                           
                           ?> 
                        <?php if(!count($reg)==0):?>
                        <li class="footer"><a href="#"><strong class="text-danger">Último Acesso</strong><br> <?= utf8_encode(strftime('%d de %B de %Y &agrave;s %H:%M', strtotime($reg->data))); ?></a></li>
                        <?php endif; ?> 
                    </ul>
                    
                </li>

                <!-- User Account: style can be found in dropdown.less -->
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="glyphicon glyphicon-option-vertical"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</header>
