<?php

use yii\db\ActiveRecordInterface;
use yii\helpers\StringHelper;


$controllerClass = StringHelper::basename($generator->controllerClass);
$modelClass = StringHelper::basename($generator->modelClass);
$searchModelClass = StringHelper::basename($generator->searchModelClass);
if ($modelClass === $searchModelClass) {
    $searchModelAlias = $searchModelClass . 'Procurar';
}

/* @var $class ActiveRecordInterface */
$class = $generator->modelClass;
$pks = $class::primaryKey();
$urlParams = $generator->generateUrlParams();
$actionParams = $generator->generateActionParams();
$actionParamComments = $generator->generateActionParamComments();

echo "<?php\n";
?>

namespace <?= StringHelper::dirname(ltrim($generator->controllerClass, '\\')) ?>;

use Yii;
use <?= ltrim($generator->modelClass, '\\') ?>;
<?php if (!empty($generator->searchModelClass)): ?>
use <?= ltrim($generator->searchModelClass, '\\') . (isset($searchModelAlias) ? " as $searchModelAlias" : "") ?>;
<?php else: ?>
use yii\data\ActiveDataProvider;
<?php endif; ?>
<?php
$num=0;
foreach ($generator->getColumnNames() as $attribute) {
   $attr[]=$attribute; 
   if($attribute == 'image' || $attribute == 'arquivo'){
       $num=1;
   }
}
if($num){
    $loadfile = 'loadWithFiles';
} else {
    $loadfile = 'load';
}
?>
use <?= ltrim($generator->baseControllerClass, '\\') ?>;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;


class <?= $controllerClass ?> extends <?= StringHelper::basename($generator->baseControllerClass) . "\n" ?>
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

        
<?php if (!empty($generator->searchModelClass)): ?>
        $procurarModel = new <?= isset($searchModelAlias) ? $searchModelAlias : $searchModelClass ?>();
       $dataProvider = $procurarModel->search(['<?= isset($searchModelAlias) ? $searchModelAlias : $searchModelClass ?>'=>['search'=>Yii::$app->getRequest()->getQueryParam('p')]]);
       
         if(Yii::$app->request->post('hasEditable')){
           $idReg = $_POST['editableKey'];
           $model = <?= $modelClass ?>::findOne($idReg);
           $out = Json::encode(['output'=>'','message'=>'']);
           $postado = current($_POST['<?= $modelClass ?>']);
           $post['<?= $modelClass ?>'] = $postado;
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
<?php else: ?>
        $dataProvider = new ActiveDataProvider([
            'query' => <?= $modelClass ?>::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
<?php endif; ?>
    }


    public function actionVisualizar(<?= $actionParams ?>)
    {
        $model = $this->findModel(<?= $actionParams ?>);
 
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
             return $this->render('visualizar', [
                'model' => $this->findModel(<?= $actionParams ?>),
            ]);
        } else {
            return $this->render('visualizar', [
                'model' => $this->findModel(<?= $actionParams ?>),
            ]);
        }
        
        
    }


    public function actionCadastrar()
    {
        $model = new <?= $modelClass ?>();

        if ($model-><?=$loadfile;?>(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Registro cadastrado com sucesso!  ');
              $this->redirect(Yii::$app->request->referrer);
            return $this->redirect(['visualizar', 'id' => $model->id]);

        } else {
            return $this->render('cadastrar', [
                'model' => $model,
            ]);
        }
    }


    public function actionAtualizar(<?= $actionParams ?>)
    {
        $model = $this->findModel(<?= $actionParams ?>);

        if ($model-><?=$loadfile;?>(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Registro atualizado com sucesso!  ');
            return $this->redirect(['visualizar', <?= $urlParams ?>]);
        } else {
            return $this->render('atualizar', [
                'model' => $model,
            ]);
        }
    }

    public function actionDelete(<?= $actionParams ?>)
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
                    Yii::$app->session->setFlash('success', 'Rotas apagadas com sucesso!  ');
                    echo 1;
                }elseif (Yii::$app->request->isAjax && isset($post['custom_param'])) {
                    if ($this->findModel(<?= $actionParams ?>)->delete()) {
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
                    $this->findModel(<?= $actionParams ?>)->delete();
                    Yii::$app->session->setFlash('success', 'Rotas atualizada com sucesso!  ');
                    return $this->redirect(['index']);
                }      
            }         
        }



    protected function findModel(<?= $actionParams ?>)
    {
        <?php
        if (count($pks) === 1) {
            $condition = '$id';
        } else {
            $condition = [];
            foreach ($pks as $pk) {
                $condition[] = "'$pk' => \$$pk";
            }
            $condition = '[' . implode(', ', $condition) . ']';
        }
        ?>
        if (($model = <?= $modelClass ?>::findOne(<?= $condition ?>)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Sua requisição não existe.');
        }
    }
    
  
    public function actionExportar(){
        //permitir exportação de relatórios
    }
}
