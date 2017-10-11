<?php

namespace app\controllers;

use app\models\AuthItem;
use app\models\AuthItemSearch;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;


class PermissaoController extends Controller
{
       public $layout = 'admin';
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
				],
			],
		];
	}


	public function actionIndex()
	{
		$searchModel = new AuthItemSearch([
			'type' => 1
		]);
		$dataProvider = $searchModel->search(['AuthItemSearch'=>['name'=>Yii::$app->getRequest()->getQueryParam('p')]]);

		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}


	public function actionVisualizar($id)
	{
		$model = $this->findModel($id);

		return $this->render('visualizar', [
			'model' => $model,
		]);
	}


	public function actionCadastrar()
	{
		$model = new AuthItem();
               
              
                if ($model->load(Yii::$app->request->post())) {
                      
			$auth = Yii::$app->authManager;
			$admin = $auth->createRole($model->name);
			$auth->add($admin);                      
                      	$model->save();
                        $desq = AuthItem::findOne($model->name);
                        $desq->description = $_POST['AuthItem']['description'];
                        $desq->save();
                        
                        Yii::$app->session->setFlash('success', 'Registro cadastrado com sucesso!');
			return $this->redirect(['visualizar', 'id' => $model->name]);
		} else {
			return $this->render('cadastrar', [
				'model' => $model,
			]);
		}
	}


	public function actionAtualizar($id)
	{
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post())) {
			$auth = Yii::$app->authManager;
			$admin = $auth->createRole($model->name);
			$auth->update($model->name, $admin);
			$model->save();
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
            if($id === "Aluno" || $id === "Professor" || $id === "Super Administrador"){
                 Yii::$app->session->setFlash('error', 'Este nivel de permissão não pode ser excluido!');
                 return $this->redirect(['index']);
            }else{
                $post = Yii::$app->request->post();
                if (Yii::$app->request->isAjax && isset($post['custom_param'])) {
                    $model = $this->findModel($id);
                    $auth = Yii::$app->authManager;
                    $admin = $auth->createRole($model->name);
                    $auth->remove($admin);
                    Yii::$app->session->setFlash('success', 'Registro apagado com sucesso!  ');
                    echo Json::encode([
                        'success' => true,
                    ]);
                    return;
                } else{
                    $model = $this->findModel($id);
                    $auth = Yii::$app->authManager;
                    $admin = $auth->createRole($model->name);
                    $auth->remove($admin);
                    return $this->redirect(['index']);
                }
            }
            
	}


	protected function findModel($id)
	{
		if (($model = AuthItem::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('Página solicitada não existe!');
		}
	}

	public function actionPermission($roleName, $permissionName)
	{
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$auth = Yii::$app->authManager;
		$roleExist = $auth->getRole($roleName);
		$msg = 'no exec';
		if ($roleExist) {
			$role = $auth->createRole($roleName);
			$permissionExist = $auth->getPermission($permissionName);
			if ($permissionExist) {
				$permission = $auth->createPermission($permissionName);
			} else {
				$permission = $auth->createPermission($permissionName);
				$auth->add($permission);
			}

			if ($auth->hasChild($role, $permission)) {
				$auth->removeChild($role, $permission);
				//$auth->remove($permission);
				$msg = 'Permissão Removida';
			} else {
				$auth->addChild($role, $permission);
				$msg = 'Permissão Adicionada';
			}
		}

		return ['data' => $msg];
	}
}
