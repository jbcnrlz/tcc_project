<?php

namespace app\controllers;

use app\models\Protocolos;
use app\models\ProtocolosProcurar;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use kartik\mpdf\Pdf;


class ProtocolosController extends Controller
{
    public $layout = "admin";
    public function behaviors()
    {
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
                    'delete' => ['post'],
                    'delete-all' =>['post','get']
                ],
            ],
        ];
    }


    public function actionIndex()
    {
        if(Yii::$app->request->post('filtro')){
            
           $num = explode("/", $_POST['filtro']['numero']);
           $query = Protocolos::find()->indexBy('id')
                   ->innerJoin('projeto', 'projeto.id=protocolos.projeto_id')
                   ->innerJoin('matricula','matricula.ra=projeto.matricula_ra');
           $query->andFilterWhere(['=','protocolos.classificacao',$_POST['filtro']['classificacao']]);
           $query->andFilterWhere(['=','matricula.curso_id',$_POST['filtro']['curso']]);
           $query->andFilterWhere(['>=', 'dta_protocolo', implode('-', array_reverse(explode('/', $_POST['filtro']['dta_inicial'])))])
                  ->andFilterWhere(['<=', 'dta_protocolo', implode('-', array_reverse(explode('/', $_POST['filtro']['dta_final'])))]);
            $query->andFilterWhere(['=','protocolos.numero',$num[0]]);
            if(isset($num[1]))
            $query->andFilterWhere(['=','protocolos.ano',$num[1]]);
//         echo  $query->createCommand()->getRawSql();
          
           $dataProvider = new ActiveDataProvider([
               'query'=>$query,
               'pagination'=>[
                   'pageSize'=>40
               ]
           ]);
           
        }else{
              $procurarModel = new ProtocolosProcurar();
              $dataProvider = $procurarModel->search(['ProtocolosProcurar'=>['search'=>Yii::$app->getRequest()->getQueryParam('p')]]);
         }
        
        
         if(Yii::$app->request->post('hasEditable')){
           $idReg = $_POST['editableKey'];
           $model = Protocolos::findOne($idReg);
           $out = Json::encode(['output'=>'','message'=>'']);
           $postado = current($_POST['Protocolos']);
           $post['Protocolos'] = $postado;
           if($model->load($post)){
               $model->save();
               $output= '';
           }
           echo $out;
           return;
       }
       
       
       
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionVisualizarProtocolos($id)
    {
       $provider = new ActiveDataProvider([
                    'query' => Protocolos::find()->where(['projeto_id'=>$id]),
                    'sort'=>['defaultOrder'=>['dta_protocolo'=>SORT_DESC]],                     
                    'pagination' => [
                        'pageSize' => 10,
                        
                    ],
                ]);
 
         return $this->renderAjax('visualizar', [
                'dataProvider' => $provider,
                'projeto'=> \app\models\Projeto::findOne($id)
            ]);
        
        
        
    }
    
    public function actionListarProjetos($q = null, $id = null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query;
            $query->select('id, tema AS text')
                ->from('projeto')
                ->where(['like', 'tema', $q])
                ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        }
        elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => \app\models\Projeto::find($id)->tema];
        }
        return $out;
    }


    public function actionCadastrar($idp=null)
    {
      
        $model = new Protocolos();

       
        if ($model->load(Yii::$app->request->post())) {
            $model->dta_protocolo = date("Y-m-d H:i:s");
            if($model->save()){
                Yii::$app->session->setFlash('success', 'Registro cadastrado com sucesso!  ');
                $this->redirect(Yii::$app->request->referrer);
                return $this->redirect(['index']);
            }
            

        } else {
            $projeto = null;
            if($idp !== null){
                $projeto = \app\models\Projeto::findOne($idp);
            }
            return $this->render('cadastrar', [
                'model' => $model,
                'projeto'=>$projeto
               
            ]);
        }
    }


    public function actionAtualizar($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Registro atualizado com sucesso!  ');
            return $this->redirect(['index']);
        } else {
            return $this->render('atualizar', [
                'model' => $model,
            ]);
        }
    }

    public function actionDelete($id)
        {
            $request = Yii::$app->request;
            if ($request->validateCsrfToken()) {
               if (Yii::$app->request->post('pk')) {
                    $pk = Yii::$app->request->post('pk');
                    $explode = explode(",", $pk);
                    if ($explode)
                        foreach ($explode as $v) {
                            if($v)
                            $this->findModel($v)->delete();
                        }
                    Yii::$app->session->setFlash('success', 'Protocolo deletado com sucesso!  ');
                    echo 1;
                }elseif (Yii::$app->request->isAjax && isset($post['custom_param'])) {
                    if ($this->findModel($id)->delete()) {
                         Yii::$app->session->setFlash('success', 'Protocolo deletado com sucesso!  ');
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
                    Yii::$app->session->setFlash('success', 'Protocolo atualizado com sucesso!  ');
                    return $this->redirect(['index']);
                }      
            }         
        }

    public function actionImprimirProtocolo($id){
        $model = Protocolos::findOne($id);
        $marginTop = 10;
        $marginLeft = 20;
        $marginRight = 20;
        if($model->classificacao == 1){
            $content = $this->renderPartial('_rel-protocoloVinculoOrientador',['model'=>$model]);
            
        }else if($model->classificacao == 2){
           $content = $this->renderPartial('_rel-protocoloQualificacao',['model'=>$model]);
        
        }else if($model->classificacao == 3){
           $content = $this->renderPartial('_rel-protocoloDefesa',['model'=>$model]);
        }else if($model->classificacao == 4){
           $content = $this->renderPartial('_rel-protocoloAta',['model'=>$model]);
           $marginTop = 20;
           $marginLeft = 30;
           $marginRight = 30;
        }
        
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
            'marginTop'=>$marginTop,
            'marginLeft'=>$marginLeft,
            'marginRight'=>$marginRight,
            'content' => $content,  
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            'cssInline' => '.row{margin-top:10px}'
            .'p{text-align:justify}'
            . '{display:none}'            
            . '.container{padding-top:20px;background:#fff;z-index:9999}'
            . '.assinatura{margin-top:70px;}'
            . '.conteudo-atividade{height:500px; text-align:justify}'
            . '.tabelaRel{
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
                    text-align: left;
                    vertical-align:top;
                }

                .tabelaRel{
                     width: 100%;
                }', 
            
             // set mPDF properties on the fly
            'options' => ['title' => 'Relatório de Protocolo'],
             // call mPDF methods on the fly
            'methods' => [ 
                'SetHeader'=>false, 
                'SetFooter'=>false,
            ]
        ]);
    Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
    $headers = Yii::$app->response->headers;
    $headers->add('Content-Type', 'application/pdf');
        // return the pdf output as per the destination setting
        return $pdf->render(); 
    }

    protected function findModel($id)
    {
                if (($model = Protocolos::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Sua requisição não existe.');
        }
    }
    
  
    public function actionExportar(){
        //permitir exportação de relatórios
    }
}
