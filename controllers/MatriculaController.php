<?php

namespace app\controllers;

use app\models\Matricula;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;


class MatriculaController extends Controller
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


    public function actionCadastrar()
    {
        $model = new Matricula();
        
        if ($model->load(Yii::$app->request->post())) {
            $model->instituicao_id = substr($model->ra, 0,3);
            $model->curso_id = substr($model->ra, 3,3);
            $model->ano =substr($model->ra, 6,2);
            $model->semestre = substr($model->ra, 8,1);
            $model->estudante_id = Yii::$app->request->get('id');
            if($model->status == 1){
                Matricula::updateAll(['status' => 0],['estudante_id'=>$model->estudante_id]);
            }
            if ($model->save()) {             
                if (Yii::$app->request->isAjax) {
                    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    return ['success' => true];
                }
                return $this->redirect(['/usuario']);             
            }
        }

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('cadastrar', [
                'model' => $model,
            ]);
        } else {
            return $this->render('cadastrar', [
                'model' => $model,
            ]);
        }

       
    }


    public function actionAtualizar($id)
    {
        $model = $this->findModel($id);
        $oldRa = $model->ra;
      
        if ($model->load(Yii::$app->request->post())) {
            if($oldRa != $model->ra){
                $model->instituicao_id = substr($model->ra, 0,3);
                $model->curso_id = substr($model->ra, 3,3);
                $model->ano =substr($model->ra, 6,2);
                $model->semestre = substr($model->ra, 8,1);
            }
            if ($model->save()) {   
                    if($model->status == 1){
                          Matricula::updateAll(['status' => 0],['estudante_id'=>$model->estudante_id]);
                          $model->status = 1;
                          $model->save();
                    }                    
                    if (Yii::$app->request->isAjax) {
                        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                        return ['success' => true];
                    }
                    return $this->redirect(['/usuario']);             
            }else{
                 if (Yii::$app->request->isAjax) {
                return $this->renderAjax('atualizar', [
                    'model' => $model,
                ]);
            } else {
                return $this->render('atualizar', [
                    'model' => $model,
                ]);
            }
         }
            
            
        } else {
            if (Yii::$app->request->isAjax) {
                return $this->renderAjax('atualizar', [
                    'model' => $model,
                ]);
            } else {
                return $this->render('atualizar', [
                    'model' => $model,
                ]);
            }
        }
    }

    public function actionDelete($id)
        {
            
            $this->findModel($id)->delete();
            Yii::$app->session->setFlash('success', 'Matricula deletada com sucesso!');
                   
        }



    protected function findModel($id)
    {
                if (($model = Matricula::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Sua requisição não existe.');
        }
    }
    
  
}
