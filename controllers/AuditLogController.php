<?php

namespace app\controllers;

use app\models\AuditLog;
use app\models\AuditLogProcurar;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;


class AuditLogController extends Controller
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

        
        $procurarModel = new AuditLogProcurar();
       $dataProvider = $procurarModel->search(['AuditLogProcurar'=>['search'=>Yii::$app->getRequest()->getQueryParam('p')]]);
       
              
       
       
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionVisualizar($id)
    {
        $model = $this->findModel($id);
     
        if(Yii::$app->user->can("Super Administrador")){
            return $this->render('visualizar', [
                'model' => $this->findModel($id),
        
            ]); 
        }
    
        if($model->user_id == \Yii::$app->user->id){
            return $this->render('visualizar', [
                'model' => $this->findModel($id),
        
            ]); 
        }else{
            throw new NotFoundHttpException('Você não tem permissão para efetuar esta operação.'); 
        }
        
        
        
        
        
        
    }



    protected function findModel($id)
    {
                if (($model = AuditLog::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Sua requisição não existe.');
        }
    }
    
  
    public function actionExportar(){
        //permitir exportação de relatórios
    }
}
