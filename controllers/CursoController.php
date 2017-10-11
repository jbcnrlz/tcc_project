<?php

namespace app\controllers;

use app\models\Curso;
use app\models\CursoProcura;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;


class CursoController extends Controller
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

        
        $procurarModel = new CursoProcura();
       $dataProvider = $procurarModel->search(['CursoProcura'=>['search'=>Yii::$app->getRequest()->getQueryParam('p')]]);
       
         if(Yii::$app->request->post('hasEditable')){
           $idReg = $_POST['editableKey'];
           $model = Curso::findOne($idReg);
           $out = Json::encode(['output'=>'','message'=>'']);
           $postado = current($_POST['Curso']);
           $post['Curso'] = $postado;
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
        $model = new Curso();

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
                    Yii::$app->session->setFlash('success', 'Cursos apagados com sucesso!  ');
                    echo 1;
                }elseif (Yii::$app->request->isAjax && isset($post['custom_param'])) {
                    if ($this->findModel($id)->delete()) {
                         Yii::$app->session->setFlash('success', 'Curso atualizado com sucesso!  ');
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
                    Yii::$app->session->setFlash('success', 'Curso atualizado com sucesso!  ');
                    return $this->redirect(['index']);
                }      
            }         
        }



    protected function findModel($id)
    {
                if (($model = Curso::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Sua requisição não existe.');
        }
    }
    
  
    public function actionExportar(){
        //permitir exportação de relatórios
    }
}
