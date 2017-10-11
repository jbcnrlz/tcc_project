<?php
namespace app\controllers;

use app\models\Mensagem;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class MensagemController extends Controller
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
           $query = Mensagem::find()->indexBy('id')->joinWith('remetente r');
           $query->andFilterWhere(['=','destinatario_id',Yii::$app->user->id]);
           $query->andFilterWhere(['=','mensagem.status',1]);
           $query->andFilterWhere(['=','r.status',1]);
           $query->andFilterWhere(['like','assunto',Yii::$app->getRequest()->getQueryParam('p')]);
           $query->andFilterWhere(['like','mensagem',Yii::$app->getRequest()->getQueryParam('p')]);
           
           $dataProvider = new ActiveDataProvider([
               'query'=>$query,
               'sort'=>[
                   'defaultOrder' => ['dta_atualizacao'=>SORT_DESC],
               ],
               'pagination'=>[
                   'pageSize'=>20
               ]
           ]);
        		
		
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
	
	public function actionEnviado()
    {
                  
           $query = Mensagem::find()->indexBy('id')->joinWith('destinatario d');
           $query->andFilterWhere(['=','remetente_id',Yii::$app->user->id]);
           $query->andFilterWhere(['=','mensagem.status',1]);
           $query->andFilterWhere(['=','d.status',1]);
           $query->andFilterWhere(['like','assunto',Yii::$app->getRequest()->getQueryParam('p')]);
           $query->andFilterWhere(['like','mensagem',Yii::$app->getRequest()->getQueryParam('p')]);
           
           $dataProvider = new ActiveDataProvider([
               'query'=>$query,
               'sort'=>[
                   'defaultOrder' => ['dta_atualizacao'=>SORT_DESC],
               ],
               'pagination'=>[
                   'pageSize'=>20
               ]
           ]);
        		
		
        return $this->render('enviado', [
            'dataProvider' => $dataProvider,
        ]);
    }
	
   
    public function actionVisualizar($id)
    {
		$model = $this->findModel($id);
		if($model->destinatario_id==Yii::$app->user->id){
			$model->lido = true;
			$model->save();
		}
        return $this->render('visualizar', [
            'model' => $model,
        ]);
    }

   
    public function actionNovaMensagem()
    {
      
      
        $model = new Mensagem([
			'status' => 1
		]);

        if ($model->load(Yii::$app->request->post())) {
            
			$model->remetente_id = Yii::$app->user->id;	
			$receivers = $model->destinatario_id;
			if(count($receivers)>1){
                           
				$receivers = $model->destinatario_id;
				foreach($receivers as $receiver){
					$model2 = new Mensagem();
					$model2->attributes = $model->attributes;
					$model2->destinatario_id = $receiver;
					if($model2->save()){
                                             return $this->redirect(['index']);
                                        };
				}
			}else{
                          
                            if($model->save()){
                                 return $this->redirect(['index']);
                            };
			}
           
        } else {
            return $this->render('novaMensagem', [
                'model' => $model,
            ]);
        }
    }

   
 


    protected function findModel($id)
    {
        if (($model = Mensagem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	
	
}