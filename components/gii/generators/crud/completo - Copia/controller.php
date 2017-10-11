<?php
/**
 * This is the template for generating a CRUD controller class file.
 */
use yii\db\ActiveRecordInterface;
use yii\helpers\StringHelper;


/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$controllerClass = StringHelper::basename($generator->controllerClass);
$modelClass = StringHelper::basename($generator->modelClass);
$searchModelClass = StringHelper::basename($generator->searchModelClass);
if ($modelClass === $searchModelClass) {
    $searchModelAlias = $searchModelClass . 'Search';
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
   if($attribute == 'image'){
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
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use app\components\gii\models\LogUpload;
use app\components\gii\components\Util;
use yii\helpers\Json;
use common\models\User;
use common\components\AccessRule;
use yii\filters\AccessControl;


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
                ],
            ],
        ];
    }


    public function actionIndex()
    {
        $grid = 'grid-'.self::className();
        $reset = Yii::$app->getRequest()->getQueryParam('p_reset');
        if ($reset) {
            \Yii::$app->session->set($grid, "");
        } else {
            $rememberUrl = Yii::$app->session->get($grid);
            $current = Url::current();
            if ($rememberUrl != $current && $rememberUrl) {
                Yii::$app->session->set($grid, "");
                $this->redirect($rememberUrl);
            }
            if (Yii::$app->getRequest()->getQueryParam('_pjax')) {
                \Yii::$app->session->set($grid, "");
                \Yii::$app->session->set($grid, Url::current());
            }
        }
        
<?php if (!empty($generator->searchModelClass)): ?>
        $searchModel = new <?= isset($searchModelAlias) ? $searchModelAlias : $searchModelClass ?>();
       $dataProvider = $searchModel->search(['<?= isset($searchModelAlias) ? $searchModelAlias : $searchModelClass ?>'=>['search'=>Yii::$app->request->get('p')]]);
       
         if(Yii::$app->request->post('hasEditable')){
            if(Yii::$app->user->identity->role == 20){
               return $this->redirect('/admin/site/acesso-negado');
           }
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
            'searchModel' => $searchModel,
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


    public function actionView(<?= $actionParams ?>)
    {
        $model = $this->findModel(<?= $actionParams ?>);
 
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
             return $this->render('view', [
                'model' => $this->findModel(<?= $actionParams ?>),
            ]);
        } else {
            return $this->render('view', [
                'model' => $this->findModel(<?= $actionParams ?>),
            ]);
        }
        
        
    }


    public function actionCreate()
    {
        $model = new <?= $modelClass ?>();

        if ($model-><?=$loadfile;?>(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Registro criado com sucesso!  ');
            return $this->redirect(['view', <?= $urlParams ?>]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }


    public function actionUpdate(<?= $actionParams ?>)
    {
        $model = $this->findModel(<?= $actionParams ?>);

        if ($model-><?=$loadfile;?>(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Registo atualizado com sucesso!  ');
            return $this->redirect(['view', <?= $urlParams ?>]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }


    public function actionDelete(<?= $actionParams ?>)
    {
        $this->findModel(<?= $actionParams ?>)->delete();
        Yii::$app->session->setFlash('success', 'Resgistro apagado com sucesso!  ');

        return $this->redirect(['index']);
    }

    /**
     * Finds the <?= $modelClass ?> model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return <?=                   $modelClass ?> the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
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
    
  
    public function actionDeleteAll() {
        $pk = Yii::$app->request->post('pk'); // Array or selected records primary keys
        $explode = explode(",", $pk);
        if ($explode)
            foreach ($explode as $v) {
                if($v)
                $this->findModel($v)->delete();
            }
        Yii::$app->session->setFlash('success', 'Resgistros apagados com sucesso!  ');
        echo 1;
    }
}
