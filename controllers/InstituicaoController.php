<?php

namespace app\controllers;

use app\models\Instituicao;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;


/**
 * InstituicaoController implements the CRUD actions for Instituicao model.
 */
class InstituicaoController extends Controller
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

   
    /**
     * Displays a single Instituicao model.
     * @param string $id
     * @return mixed
     */
    public function actionIndex()
    {
          
        $model = $this->findModel();
   
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->render('view', [
                'model' => $this->findModel(),
            ]);
         }else{
             return $this->render('view', [
                'model' => $this->findModel(),
            ]);
         }
    }


    public function actionAtualizar($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Registo atualizado com sucesso!  ');
            return $this->redirect('index');
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }


    protected function findModel()
    {
        $id = Instituicao::find()->all();
        if (($model = Instituicao::findOne($id[0]->id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Sua requisição não existe.');
        }
    }
    
  
   
}
