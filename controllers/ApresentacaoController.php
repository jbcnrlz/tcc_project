<?php

namespace app\controllers;

use app\models\Apresentacao;
use app\models\ApresentacaoProcurar;
use app\models\Avaliacao;
use app\models\Projeto;
use app\models\ProjetoProcura;
use kartik\mpdf\Pdf;
use Yii;
use yii\base\Model;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ApresentacaoController extends Controller {

    public $layout = "admin";

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                        [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'avaliar' => ['post'],
                    'delete' => ['post'],
                    'delete-all' => ['post', 'get']
                ],
            ],
        ];
    }

    public function actionIndex() {


        $modelApresentacao = new ApresentacaoProcurar();
        $modelProjetosAprovados = new ProjetoProcura();
        return $this->render('index', [
                    'modelApresentacao' => $modelApresentacao,
                    'modelProjetosAprovados' => $modelProjetosAprovados
        ]);
    }

    public function actionBanca() {
        $modelBanca = new ApresentacaoProcurar();
        return $this->render('banca', [
                    'modelBanca' => $modelBanca
        ]);
    }
    
    public function actionAvaliacaoFinal($id){
        $apresentacao = Apresentacao::findOne($id);
        
        $apresentacao->setScenario('avaliacaoFinal');
        $apresentacao->status = 2;
        if ($apresentacao->load(Yii::$app->request->post()) && $apresentacao->save()) {
              Yii::$app->session->setFlash('success', 'Avaliação salva com sucesso!');
              return $this->redirect(['visualizar-avaliacao', 'id' => $id]);
        }else{
             Yii::$app->session->setFlash('error', 'Houve um erro ao salvar a avaliação.!<br>Todos os campos são obrigatórios');
              return $this->redirect(['visualizar-avaliacao', 'id' => $id]);
        }
      
        
        return $this->redirect(['visualizar-avaliacao', 'id' => $id]);
        
    }

    public function actionAvaliar($id) {
        $apresentacao = Apresentacao::findOne($id);
        if ($apresentacao->orientador_id == \Yii::$app->user->id):
            $avaliarQ1 = null;
           
            if ($apresentacao->etapa_projeto == 2) {
                $avaliarQ1 = Avaliacao::find()->where(['apresentacao_id' => $id, 'num_questao' => 1])->one();
                $avaliarQ1->setScenario('avaliarEtapa2');
                if ($avaliarQ1->load(Yii::$app->request->post()) && $avaliarQ1->validate()) {
                    $apresentacao->status = 2;
                    $apresentacao->save();
                    $avaliarQ1->save();

                    return $this->redirect(['visualizar-avaliacao', 'id' => $id]);
                }
                return $this->render('avaliar', ['apresentacao' => $apresentacao, 'avaliarQ1' => $avaliarQ1]);
            } else if ($apresentacao->etapa_projeto == 3) {
                $avaliar = Avaliacao::find()->where(['apresentacao_id' => $id])->all();
                
                 if (Model::loadMultiple($avaliar, Yii::$app->request->post()) && Model::validateMultiple($avaliar)) {
                    foreach ($avaliar as $av) {
                        $av->setScenario('avaliarEtapa3');
                        if(!$av->save())
                           return $this->render('avaliar', ['apresentacao' => $apresentacao, 'avaliar' => $avaliar]);                           
                       
                    }
                    return $this->redirect(['visualizar-avaliacao', 'id' => $id]);
                }
                 return $this->render('avaliar', ['apresentacao' => $apresentacao, 'avaliar' => $avaliar]);
            } else {
                throw new NotFoundHttpException('Não foi possivel carregar a avaliação, "etapa do projeto" inconcistente.');
            }
           
        else:
            throw new NotFoundHttpException('Somente o orientador pode realizar a avaliação');

        endif;
    }

    public function actionRelatorioAvaliacao($id) {
        $apresentacao = Apresentacao::findOne($id);
        if ($apresentacao->orientador_id == \Yii::$app->user->id || 
            $apresentacao->convidado_primario_id == \Yii::$app->user->id ||
             $apresentacao->convidado_secundario_id == \Yii::$app->user->id  ){
            $model = Apresentacao::findOne($id);
            if ($apresentacao->etapa_projeto == 2) {
                $content = $this->renderPartial('_relatorioQualificacao', ['model' => $model]);
                $nome = 'Qualificação - '.$apresentacao->projeto->matriculaRa->estudante->nome;
                $margin = 15;
                $css = '#relatorio{
                width: 800px;
                margin: auto;
                font-size: 16px;
                }
                .titulo{
                  text-transform: uppercase;
                }
                .tabelaRel{
                    border-collapse: collapse;
                }
                .tabelaRel tr td,   .tabelaRel tr th{
                    border:1px solid #000;
                    padding: 10px;
                }
                .linha{
                   color:#ccc

                }
                .tabelaRel th{
                    text-align: center;        
                }

                .tabelaRel{
                     width: 100%;
                }

                .nota{
                    text-align: center;
                    vertical-align: middle;
                }';
                $pdf = new Pdf([
                // set to use core fonts only
                'mode' => Pdf::MODE_CORE,
                // A4 paper format
                'format' => Pdf::FORMAT_A4,
                // portrait orientation
                'orientation' => Pdf::ORIENT_PORTRAIT,
                // stream to browser inline
                'destination' => Pdf::DEST_BROWSER,
                // your html content input
                'marginTop' => $margin,
                'marginBottom' => 0,
                'content' => $content,
                'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
                'cssInline' => $css,
                
                'filename'=>$nome,
                // set mPDF properties on the fly
                'options' => ['title' => 'Relatório de Avaliação da Apresentação'],
                // call mPDF methods on the fly
                'methods' => [
                    'SetHeader' => false,
                    'SetFooter' => ['|www.fatecgarca.com.br|'],
                ]
            ]);
                return $pdf->render();
            }else  if ($apresentacao->etapa_projeto == 3) {
                 $content = $this->renderPartial('_relatorioDefesa', ['model' => $model]);
                $margin = 5;
                $nome = 'Defesa - '.$apresentacao->projeto->matriculaRa->estudante->nome;
               
                $css = '#relatorio{
                width: 800px;
                margin: auto;
                font-size: 16px;
                }
                .titulo{
                  text-transform: uppercase;
                }
                .tabelaRel{
                    border-collapse: collapse;
                }
                .tabelaRel tr td,   .tabelaRel tr th{
                    border:1px solid #000;
                    padding: 9px;
                }
                .linha{
                   color:#ccc

                }
                .tabelaRel th{
                    text-align: center;        
                }
                p{
                    padding:0px;
                    margin:0px;
                }
                
                .margin-left-none{
                 padding-left:0px;
                }

                .tabelaRel{
                     width: 100%;
                }

                .nota{
                    text-align: center;
                    vertical-align: middle;
                }';
                
                $pdf = new Pdf([
                // set to use core fonts only
                'mode' => Pdf::MODE_CORE,
                // A4 paper format
                'format' => Pdf::FORMAT_A4,
                // portrait orientation
                'orientation' => Pdf::ORIENT_PORTRAIT,
                // stream to browser inline
                'destination' => Pdf::DEST_BROWSER,
                // your html content input
                'marginTop' => $margin,
                'marginBottom' => 0,
                'content' => $content,
                'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
                'cssInline' => $css,
                
                'filename'=>$nome,
                // set mPDF properties on the fly
                'options' => ['title' => 'Relatório de Avaliação da Apresentação'],
                // call mPDF methods on the fly
                'methods' => [
                    'SetHeader' => false,
                    'SetFooter' => ['|www.fatecgarca.com.br|'],
                ]
            ]);
                        return $pdf->render();
            }
             }else{
            throw new NotFoundHttpException('Somente o orientador pode realizar a avaliação');

             }
    }

    public function actionVisualizarAvaliacao($id) {
        $apresentacao = Apresentacao::findOne($id);
          if ($apresentacao->orientador_id == \Yii::$app->user->id || 
            $apresentacao->convidado_primario_id == \Yii::$app->user->id ||
             $apresentacao->convidado_secundario_id == \Yii::$app->user->id  ):
        
            if($apresentacao->dta_versao_final =="")
                $apresentacao->dta_versao_final = \Yii::$app->params['dta-versao-final'];
            return $this->render('visualizarAvaliacao', ['apresentacao' => $apresentacao]);
        else:
            throw new NotFoundHttpException('Somente o orientador pode realizar a avaliação');

        endif;
    }

    public function actionVisualizar($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->render('visualizar', [
                        'model' => $this->findModel($id),
            ]);
        } else {
            return $this->render('visualizar', [
                        'model' => $this->findModel($id),
            ]);
        }
    }

    public function actionCadastrar($id) {
        $model = new Apresentacao();
        $projeto = Projeto::findOne($id);

        $model->projeto_id = $projeto->id;
        $model->etapa_projeto = $projeto->matriculaRa->etapa_projeto;
        $model->orientador_id = $projeto->orientador_id;
        $model->curso_id = $projeto->matriculaRa->curso_id;

        $model->setScenario('cadastrar');

        if ($model->load(Yii::$app->request->post())) {
            if (strtotime($model->horario) > strtotime("7:00")) {
                $model->periodo = "Matutino";
            }
            if (strtotime($model->horario) > strtotime("12:00")) {
                $model->periodo = "Vespertino";
            }
            if (strtotime($model->horario) > strtotime("18:00") && strtotime($model->horario) < strtotime("23:00")) {
                $model->periodo = "Noturno";
            }

            if ($model->save()) {

                if ($model->etapa_projeto == 2) {
                    $avaliacao = new Avaliacao();
                    $avaliacao->num_questao = 1;
                    $avaliacao->apresentacao_id = $model->id;
                    $avaliacao->save();
                }
                if ($model->etapa_projeto == 3) {
                    $avaliacao = new Avaliacao();
                    $avaliacao->num_questao = 1;
                    $avaliacao->apresentacao_id = $model->id;
                    $avaliacao->save();
                    $avaliacao = new Avaliacao();
                    $avaliacao->num_questao = 2;
                    $avaliacao->apresentacao_id = $model->id;
                    $avaliacao->save();
                }
                Yii::$app->session->setFlash('success', 'Registro cadastrado com sucesso!  ');
                $this->redirect(Yii::$app->request->referrer);
                return $this->redirect(['visualizar', 'id' => $model->id]);
            } else {

                return $this->render('cadastrar', [
                            'model' => $model,
                            'projeto' => $projeto
                ]);
            }
        } else {
            $model->dta_versao_final = Yii::$app->params['dta-versao-final'];
            return $this->render('cadastrar', [
                        'model' => $model,
                        'projeto' => $projeto
            ]);
        }
    }

    public function actionAtualizar($id) {
        $model = $this->findModel($id);

        $projeto = Projeto::findOne($model->projeto_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Registro atualizado com sucesso!  ');
            return $this->redirect(['visualizar', 'id' => $model->id]);
        } else {
            $model->dta_versao_final = Yii::$app->params['dta-versao-final'];
            return $this->render('atualizar', [
                        'model' => $model,
                        'projeto' => $projeto
            ]);
        }
    }

    public function actionDelete($id) {
        $request = Yii::$app->request;
        if ($request->validateCsrfToken()) {
            if (Yii::$app->request->post('pk')) {
                $pk = Yii::$app->request->post('pk');
                $explode = explode(",", $pk);
                if ($explode)
                    foreach ($explode as $v) {
                        if ($v)
                            $this->findModel($v)->delete();
                    }
                Yii::$app->session->setFlash('success', 'Apresentação apagadas com sucesso!  ');
                echo 1;
            }elseif (Yii::$app->request->isAjax && isset($post['custom_param'])) {
                if ($this->findModel($id)->delete()) {
                    Yii::$app->session->setFlash('success', 'Apresentação atualizada com sucesso!  ');
                    echo Json::encode([
                        'success' => true,
                    ]);
                } else {
                    echo Json::encode([
                        'success' => false,
                    ]);
                }
                return;
            } elseif (Yii::$app->request->post() || Yii::$app->request->isAjax) {
                $this->findModel($id)->delete();
                Yii::$app->session->setFlash('success', 'Apresentação atualizada com sucesso!  ');
                return $this->redirect(['index']);
            }
        }
    }

    protected function findModel($id) {
        if (($model = Apresentacao::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Sua requisição não existe.');
        }
    }

    public function actionExportar() {
        //permitir exportação de relatórios
    }

}
