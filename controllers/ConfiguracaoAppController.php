<?php

namespace app\controllers;

use app\models\ConfiguracaoApp;
use app\models\ConfiguracaoAppProcurar;
use vova07\imperavi\actions\GetAction;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;


class ConfiguracaoAppController extends Controller
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
    
    
    public function actions()
    {
        $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
        return [
            'images-get' => [
                'class' => 'vova07\imperavi\actions\GetAction',
                'url' => $actual_link."/upload/imagens/", 
                'path' => '@app/upload/imagens', 
                'type' => GetAction::TYPE_IMAGES,
            ],
            'image-upload' => [
                'class' => 'vova07\imperavi\actions\UploadAction',
                'url' => $actual_link."/upload/imagens/", 
                'path' => '@app/upload/imagens'
            ],
            'files-get' => [
                'class' => 'vova07\imperavi\actions\GetAction',
                'url' => $actual_link."/upload/arquivosApoio/",
                'path' => '@app/upload/arquivosApoio/', 
                'type' => GetAction::TYPE_FILES,
            ],
            'file-upload' => [
                'class' => 'vova07\imperavi\actions\UploadAction',
                'url' => $actual_link."/upload/arquivosApoio/",
                'path' => '@app/upload/arquivosApoio/', 
                'uploadOnlyImage' => false, 
            ],
        ];
    }
    
    public function actionMaterialApoio(){
        
        $model = $this->findModel(15);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Registro atualizado com sucesso!  ');
            return $this->redirect(['index']);
        } else {
            return $this->render('materialApoio', [
                'model' => $model,
            ]);
        }
        
    }

    public function actionIndex()
    {

        
       $procurarModel = new ConfiguracaoAppProcurar();
       $dataProvider = $procurarModel->search(['ConfiguracaoAppProcurar'=>['search'=>Yii::$app->getRequest()->getQueryParam('p')]]);
       
         if(Yii::$app->request->post('hasEditable')){
           $idReg = $_POST['editableKey'];
           $model = ConfiguracaoApp::findOne($idReg);
           $out = Json::encode(['output'=>'','message'=>'']);
           $postado = current($_POST['ConfiguracaoApp']);
           $post['ConfiguracaoApp'] = $postado;
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


    public function actionCadastrar()
    {
        $model = new ConfiguracaoApp();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Registro cadastrado com sucesso!  ');
              $this->redirect(Yii::$app->request->referrer);
            return $this->redirect(['index']);

        } else {
            return $this->render('cadastrar', [
                'model' => $model,
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

    

    protected function findModel($id)
    {
                if (($model = ConfiguracaoApp::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Sua requisição não existe.');
        }
    }
    
  
    public function actionExportar(){
        //permitir exportação de relatórios
    }
}
