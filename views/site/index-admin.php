<?php

use kartik\alert\AlertBlock;
use yii\grid\GridView;

echo AlertBlock::widget([
    'useSessionFlash' => true,
    'type' => AlertBlock::TYPE_GROWL,
    'delay' => 0,
]);




$this->title = "Home";


$this->params['breadcrumbs'][] = "Olá, " . Yii::$app->user->identity->nome;
?>


<div class="alunos-model-index">

    <div class="box">      
        <div class="box-body">

            <section class="content">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                      <?php if(Yii::$app->user->identity->foto == "") :?>
                    <div class="col-lg-12 col-xs-12 alert alert-danger text-center">
                        Atualize seu perfil adicionando uma foto. Assim ficará mais fácil sua identificação. <br>
                        <a href="/perfil" class="btn btn-danger btn-sm" style="text-decoration: none;">Atualizar Perfil</a>
                    </div>
                    <?php endif; ?>
                    <?php if(Yii::$app->user->can("Aluno")) :?>
                       <?php 
                                    $model = \app\models\Projeto::find()->innerJoinWith('matriculaRa')->where(['and',['matricula_ra'=>Yii::$app->user->identity->matriculasAtiva->ra,'projeto.status'=>1]])->one();
                                    if(count($model)>0){
                                      $apresentacao = \app\models\Apresentacao::find()->where(['projeto_id'=>$model->id,'status'=>1,'etapa_projeto'=>$model->matriculaRa->etapa_projeto])->one();  
                                      if(count($apresentacao)>0){                            
                                ?>   
                    <div class="col-lg-12 col-xs-12">
                        <!-- small box -->
                        <div class="small-box bg-gray-light">
                            <i class="glyphicon glyphicon-calendar" style="position: absolute; color: #fff; font-size: 200px; right: 0px; top: 50px;"></i>
                            <div class="inner">
                                                 
                                <h4><strong style="color:#D33724">Sua Apresentação da <?php echo ($model->matriculaRa->etapa_projeto == 2)?"Qualificação":"Defesa"; ?></strong></h4>
                                <p><strong>Orientando: </strong> <?=$apresentacao->orientador->nome ?></p>
                                <p><strong>Data: </strong><?=Yii::$app->formatter->asDate($apresentacao->dta_apresentacao,'medium') ?></p>
                                <p><strong>Local: </strong><?=$apresentacao->local ?></p>
                                <p><strong>Horário: </strong><?=Yii::$app->formatter->asTime($apresentacao->horario,'short') ?></p>
                                <h5><strong>Professores Convidados:</strong></h5>
                                 <p><?=$apresentacao->convidadoPrimario->nome ?></p>
                                 <p><?=@$apresentacao->convidadoSecundario->nome ?></p>
                                 
                                
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                        </div>
                    </div>
                    <?php
                                         }
                                    }
                                
                                ?>
                    <?php endif; ?>
                    
                    <?php if(Yii::$app->user->can("Professor")) :?>
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box btn-default">
                            <div class="inner">
                                
                               
                                <h3><?= app\models\Projeto::find()->where(['status'=>1, 'orientador_id'=> Yii::$app->user->id])->count(); ?></h3>

                                <p>Orientando</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="/projeto/projeto-orientando" class="small-box-footer" style="color:#003333">Mais Detalhes <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box btn-default">
                            <div class="inner">
                                <h3><?= app\models\Apresentacao::find()->where(
                                        "(orientador_id = ".Yii::$app->user->id." OR ".
                                        "convidado_primario_id = ".Yii::$app->user->id." OR ".
                                        "convidado_secundario_id = ".Yii::$app->user->id.") AND status = 1"
                                        )->count(); ?></h3>

                                <p>Banca</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="/apresentacao/banca" class="small-box-footer" style="color:#003333">Mais Detalhes <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                     <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box btn-default">
                            <div class="inner">
                                <h3><?=app\models\Projeto::find()->innerJoinWith(['matriculaRa','arquivosProjetos'])->where(['and',
                [
                    'orientador_sugestao_id'=> Yii::$app->user->id,
                    'matricula.etapa_projeto'=>1,
                    'arquivos_projeto.etapa_projeto'=>1,
                    'projeto.status'=>1
                ]
                ])->count(); ?></h3>

                                <p>Designado</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="/projeto/projeto-designado" class="small-box-footer" style="color:#003333">Mais Detalhes <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                     <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box btn-default">
                            <div class="inner">
                                <h3><?=\app\models\Mensagem::find()->where(['destinatario_id'=>Yii::$app->user->id, 'lido'=>0])->count() ?></h3>

                                <p>Mensagem</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="/mensagem" class="small-box-footer" style="color:#003333">Mais Detalhes <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <?php endif; ?>
                    <!-- ./col -->
                </div>
                <br>
                <div class="row">
                    <!-- Left col -->
                    <section class="col-lg-7">
                        <!-- Custom tabs (Charts with tabs)-->
                        <div class="nav-tabs-custom">
                            <!-- Tabs within a box -->
                            <ul class="nav nav-tabs pull-right ui-sortable-handle">

                                <li class="pull-left header"><i class="fa fa-newspaper-o"></i> Mural de Recados</li>
                            </ul>
                            <div class="tab-content no-padding">
                                  <?php
                                  $muralrecado = new app\models\MuralRecadosProcurar();
                                 \yii\widgets\Pjax::begin();
                                  echo GridView::widget([
                                        'dataProvider' => $muralrecado->searchMuralHome(),
                                        'layout'=>'{items}<div class="text-center">{pager}</div>',
                                        'columns' => [
                                          ['attribute'=>'titulo',
                                            'format'=>'html',
                                            'value'=>function($data){
                                                return $data->titulo."<br><small style='color:#888;'>".$data->curso->nome_abreviado."</small>";
                                            }
                                              ],
                                          ['attribute'=>'recado',
                                            'format'=>'html',
                                            'value'=>function($data){
                                                return $data->recado."<small style='color:#f00; float:right'>".$data->departamento."</small>";
                                            }
                                              ]
                                        ],
                                    ]);
                                    \yii\widgets\Pjax::end();
                                              
                                                      ?>
                               
                            </div>
                        </div>
                        <!-- /.nav-tabs-custom -->

                    </section>
                    <!-- /.Left col -->
                    <!-- right col (We are only adding the ID to make the widgets sortable)-->
                    <section class="col-lg-5 connectedSortable ui-sortable">



                        <!-- Calendar -->
                        <div class="box box-solid btn-warning">
                            <div class="box-header ">
                                <i class="fa fa-calendar" style="color:#fff"></i>

                                <h3 class="box-title" style="color:#fff">Calendário Acadêmico</h3>

                            </div>              
                        </div>
                        <?= app\views\widgets\calendario\Calendario::widget(); ?>
                    </section>

                </div>


            </section>

        </div>

    </div> <!--end box -->

</div>



