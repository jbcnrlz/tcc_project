<?php

namespace app\controllers;

use app\components\Configs;
use app\models\Route;
use app\models\RouteSearch;
use Yii;
use yii\caching\TagDependency;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Inflector;
use yii\helpers\Json;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class RotasController extends Controller
{
	const CACHE_TAG = 'mdm.admin.route';
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
				],
			],
		];
	}


	public function actionIndex()
	{
		$searchModel = new RouteSearch([
			'status' => 1,
		]);
                
                if(Yii::$app->getRequest()->getQueryParam('p')){
                    $dataProvider = $searchModel->search(['RouteSearch'=>['search'=>Yii::$app->getRequest()->getQueryParam('p')]]);                   
                }else{
                    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);                     
                }
                 
                if(Yii::$app->request->post('hasEditable')){
                    $idReg = $_POST['editableKey'];
                    $model = Route::findOne($idReg);
                    $out = Json::encode(['output'=>'','message'=>'']);
                    $postado = current($_POST['Route']);
                    $post['Route'] = $postado;
                    if($model->load($post)){
                        $model->save();
                        $output= '';
                    }
                    echo $out;
                    return;
                }
		
		$dataProvider->getSort()->defaultOrder = [
			'type' => SORT_ASC,
		];
		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}


	public function actionVisualizar($id)
	{
                
		$model = $this->findModel($id);
                
 
                if ($model->load(Yii::$app->request->post()) && $model->save()) {
                    Yii::$app->session->setFlash('success', 'Rota atualizada com sucesso!  ');
                     return $this->redirect('visualizar?id='.$model->name.'');
                } else {
                    return $this->render('visualizar', [
                        'model' => $this->findModel($id),
                    ]);
                }
	}


	public function actionCadastrar()
	{
		$model = new Route();

		if ($model->load(Yii::$app->request->post())) {
			$model->save();
			return $this->redirect(Yii::$app->request->referrer);
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
			return $this->redirect(['visualizar', 'id' => $model->name]);
                        Yii::$app->session->setFlash('success', 'Rota atualizada com sucesso!  ');
		} else {
			return $this->render('atualizar', [
				'model' => $model,
			]);
		}
	}

        public function actionDelete($id)
        {
            $request = Yii::$app->request;
            $post = $request->post();
            if ($request->validateCsrfToken()) {
               if (Yii::$app->request->post('pk')) {
                    $pk = Yii::$app->request->post('pk');
                    $explode = explode(",", $pk);
                    if ($explode)
                        foreach ($explode as $v) {
                            if($v)
                            $this->findModel($v)->delete();
                        }
                    Yii::$app->session->setFlash('success', 'Rotas apagadas com sucesso!  ');
                    echo 1;
                }elseif (Yii::$app->request->isAjax && isset($post['custom_param'])) {
                    if ($this->findModel($id)->delete()) {
                         Yii::$app->session->setFlash('success', 'Rotas atualizada com sucesso!  ');
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
                    Yii::$app->session->setFlash('success', 'Rotas atualizada com sucesso!  ');
                    if(Yii::$app->getRequest()->getQueryParam('p')){
                          return $this->redirect(['/rotas?p='.Yii::$app->getRequest()->getQueryParam('p')]);
                    }
                    return $this->redirect(['index']);
                }      
            }         
        }




	public function actionGenerate()
	{
		$routes = $this->searchRoute('all');
		foreach ($routes as $route => $status) {
			if (!Route::findOne($route)) {
				$model = new Route();
				$model->name = $route;
				$pos = (strrpos($route, '/'));
				
                                switch (substr($route, $pos + 1, 64)){
                                     case '*':
                                        $action = '*';
                                        $ordem = 0;
                                        break;
                                     case 'index':
                                        $action = 'Listar';
                                        $ordem = 1;
                                        break;
                                     case 'cadastrar':
                                        $action = 'Cadastrar';
                                        $ordem = 2; 
                                        break;
                                    case 'visualizar':
                                        $action = 'Visualizar';
                                        $ordem = 2; 
                                        break;
                                    case 'atualizar':
                                        $action = 'Editar';
                                        $ordem = 3; 
                                        break;
                                    case 'delete':
                                        $action = 'Excluir';
                                        $ordem = 4;
                                        break;                           
                                    case 'exportar':
                                        $action = 'Relatórios';
                                        $ordem = 5;
                                        break;
                                    default:
                                        $action = substr($route, $pos + 1, 64);
                                        $ordem = 10;
                                        break;
                                }
                                $model->ordem = $ordem;
                                $model->type = ucfirst(substr($route, 1, $pos - 1));
				$model->alias = ucfirst($action);
				$model->save();
			}
		}
		Yii::$app->session->setFlash('success', 'Rotas Geradas com Sucesso!');
		return $this->redirect(['index']);
	}


	protected function findModel($id)
	{
		if (($model = Route::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('Página solicitada não existe!');
		}
	}


	public function searchRoute($target, $term = '', $refresh = '0')
	{
		if ($refresh == '1') {
			$this->invalidate();
		}
		$result = [];
		$manager = Yii::$app->getAuthManager();

		$exists = array_keys($manager->getPermissions());
		$routes = $this->getAppRoutes();
		if ($target == 'available') {
			foreach ($routes as $route) {
				if (in_array($route, $exists)) {
					continue;
				}
				if (empty($term) or strpos($route, $term) !== false) {
					$result[$route] = true;
				}
			}
		} else if ($target == 'all') {
			foreach ($routes as $route) {
				$available = 0;
				if (in_array($route, $exists)) {
					$available = 1;
				}
				if (empty($term) or strpos($route, $term) !== false) {
					$result[$route] = $available;
				}
			}
		} else {
			foreach ($exists as $name) {
				if ($name[0] !== '/') {
					continue;
				}
				if (empty($term) or strpos($name, $term) !== false) {
					$r = explode('&', $name);
					$result[$name] = !empty($r[0]) && in_array($r[0], $routes);
				}
			}
		}

		//Yii::$app->response->format = 'json';
		return $result;
	}


	public function getAppRoutes()
	{
		$key = __METHOD__;
		$cache = Configs::instance()->cache;
		if ($cache === null || ($result = $cache->get($key)) === false) {
			$result = [];
			$this->getRouteRecrusive(Yii::$app, $result);
			if ($cache !== null) {
				$cache->set($key, $result, Configs::instance()->cacheDuration, new TagDependency([
					'tags' => self::CACHE_TAG
				]));
			}
		}

		return $result;
	}

       

	private function getRouteRecrusive($module, &$result)
	{
		$token = "Obter rotas para '" . get_class($module) . "' com ID '" . $module->uniqueId . "'";
		Yii::beginProfile($token, __METHOD__);
		try {
			foreach ($module->getModules() as $id => $child) {
				if (($child = $module->getModule($id)) !== null) {
					$this->getRouteRecrusive($child, $result);
				}
			}

			foreach ($module->controllerMap as $id => $type) {
				$this->getControllerActions($type, $id, $module, $result);
			}

			$namespace = trim($module->controllerNamespace, '\\') . '\\';
			$this->getControllerFiles($module, $namespace, '', $result);
			$result[] = ($module->uniqueId === '' ? '' : '/' . $module->uniqueId) . '/*';
		} catch (\Exception $exc) {
			Yii::error($exc->getMessage(), __METHOD__);
		}
		Yii::endProfile($token, __METHOD__);
	}


	private function getControllerFiles($module, $namespace, $prefix, &$result)
	{
		$path = @Yii::getAlias('@' . str_replace('\\', '/', $namespace));
		$token = "Obter Controller de '$path'";
		Yii::beginProfile($token, __METHOD__);
		try {
			if (!is_dir($path)) {
				return;
			}
			foreach (scandir($path) as $file) {
				if ($file == '.' || $file == '..') {
					continue;
				}
				if (is_dir($path . '/' . $file)) {
					$this->getControllerFiles($module, $namespace . $file . '\\', $prefix . $file . '/', $result);
				} elseif (strcmp(substr($file, -14), 'Controller.php') === 0) {
					$id = Inflector::camel2id(substr(basename($file), 0, -14));
					$className = $namespace . Inflector::id2camel($id) . 'Controller';
					if (strpos($className, '-') === false && class_exists($className) && is_subclass_of($className, 'yii\base\Controller')) {
						$this->getControllerActions($className, $prefix . $id, $module, $result);
					}
				}
			}
		} catch (\Exception $exc) {
			Yii::error($exc->getMessage(), __METHOD__);
		}
		Yii::endProfile($token, __METHOD__);
	}


	private function getControllerActions($type, $id, $module, &$result)
	{
		$token = "Cadastrar controller com config=" . VarDumper::dumpAsString($type) . " e id='$id'";
		Yii::beginProfile($token, __METHOD__);
		try {
			/* @var $controller \yii\base\Controller */
			$controller = Yii::createObject($type, [$id, $module]);
			$this->getActionRoutes($controller, $result);
			$result[] = '/' . $controller->uniqueId . '/*';
		} catch (\Exception $exc) {
			Yii::error($exc->getMessage(), __METHOD__);
		}
		Yii::endProfile($token, __METHOD__);
	}


	private function getActionRoutes($controller, &$result)
	{
		$token = "Obter ação do controller '" . $controller->uniqueId . "'";
		Yii::beginProfile($token, __METHOD__);
		try {
			$prefix = '/' . $controller->uniqueId . '/';
			foreach ($controller->actions() as $id => $value) {
				$result[] = $prefix . $id;
			}
			$class = new \ReflectionClass($controller);
			foreach ($class->getMethods() as $method) {
				$name = $method->getName();
				if ($method->isPublic() && !$method->isStatic() && strpos($name, 'action') === 0 && $name !== 'actions') {
					$result[] = $prefix . Inflector::camel2id(substr($name, 6));
				}
			}
		} catch (\Exception $exc) {
			Yii::error($exc->getMessage(), __METHOD__);
		}
		Yii::endProfile($token, __METHOD__);
	}


	protected function invalidate()
	{
		if (Configs::instance()->cache !== null) {
			TagDependency::invalidate(Configs::instance()->cache, self::CACHE_TAG);
		}
	}


	protected function setDefaultRule()
	{
		if (Yii::$app->authManager->getRule(RouteRule::RULE_NAME) === null) {
			Yii::$app->authManager->add(Yii::createObject([
					'class' => RouteRule::className(),
					'name' => RouteRule::RULE_NAME]
			));
		}
	}
}
