<?php

namespace app\controllers;

use app\models\CalendarioAcademico;
use app\models\CalendarioAcademicoProcurar;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;


class CalendarioAcademicoController extends Controller
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

        
        $procurarModel = new CalendarioAcademicoProcurar();
       $dataProvider = $procurarModel->search(['CalendarioAcademicoProcurar'=>['search'=>Yii::$app->getRequest()->getQueryParam('p')]]);
       
         if(Yii::$app->request->post('hasEditable')){
           $idReg = $_POST['editableKey'];
           $model = CalendarioAcademico::findOne($idReg);
           $out = Json::encode(['output'=>'','message'=>'']);
           $postado = current($_POST['CalendarioAcademico']);
           $post['CalendarioAcademico'] = $postado;
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


    public function actionVisualizar($id)
    {
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


    public function actionCadastrar()
    {
        $model = new CalendarioAcademico();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if($model->recorrencias == '' || $model->recorrencias == 0){
                $model->save();
                Yii::$app->session->setFlash('success', 'Registro cadastrado com sucesso!  ');
                $this->redirect(Yii::$app->request->referrer);
                 return $this->redirect(['index']);
            }else{
                $count = $model->recorrencias;
                for($i=0;$i < $count ;$i++){
                    $data = new CalendarioAcademico();
                    $data->load(Yii::$app->request->post());
                    $data->date = date('Y-m-d', strtotime("+{$i} weekdays",strtotime($data->date))); 
                    $data->save(false);           
                    
                }
                $this->redirect(Yii::$app->request->referrer);
                return $this->redirect(['index']);
                
            }
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
            return $this->redirect(['visualizar', 'id' => $model->id]);
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
                    Yii::$app->session->setFlash('success', 'Registros apagadas com sucesso!  ');
                    echo 1;
                }elseif (Yii::$app->request->isAjax && isset($post['custom_param'])) {
                    if ($this->findModel($id)->delete()) {
                         Yii::$app->session->setFlash('success', 'Registro atualizada com sucesso!  ');
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
                    Yii::$app->session->setFlash('success', 'Registro atualizada com sucesso!  ');
                    return $this->redirect(['index']);
                }      
            }         
        }



    protected function findModel($id)
    {
                if (($model = CalendarioAcademico::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Sua requisição não existe.');
        }
    }
    
  
    public function actionExportar(){
        //permitir exportação de relatórios
    }
}
