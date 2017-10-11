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


/**
 * <?= $controllerClass ?> implements the CRUD actions for <?= $modelClass ?> model.
 */
class <?= $controllerClass ?> extends <?= StringHelper::basename($generator->baseControllerClass) . "\n" ?>
{


    public function behaviors()
    {
        return [
        'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index','view'],
                        'roles' => [
                            User::ROLE_COLABORADOR,  
                            User::ROLE_USUARIO,
                            User::ROLE_ADMIN,
                            User::ROLE_SUPERADMIN
                        ],
                    ],
              
                    [
                        'allow' => true,
                        'actions' => ['update'],
                         'roles' => [
                            User::ROLE_USUARIO,
                            User::ROLE_ADMIN,
                            User::ROLE_SUPERADMIN
                        ],
                    ],
             
                    [
                        'allow' => true,
                        'roles' => [
                            User::ROLE_SUPERADMIN
                        ],
                    ],
                ],
                'denyCallback' => function($rule, $action) {
                   return $action->controller->redirect('/admin/site/acesso-negado');
                   throw new ForbiddenHttpException("Forbidden access");
                },
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

   
    /**
     * Displays a single <?= $modelClass ?> model.
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return mixed
     */
    public function actionIndex()
    {
        if(!isset($_GET['id'])){
           $id = 1;
        }
        $model = $this->findModel($id);
         if(Yii::$app->user->identity->role == 20 && $model->load(Yii::$app->request->post()) ){
            return $this->redirect('/admin/site/acesso-negado');
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
         }else{
             return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
         }
    }


    public function actionUpdate(<?= $actionParams ?>)
    {
        $model = $this->findModel(<?= $actionParams ?>);

        if ($model-><?=$loadfile;?>(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Registo atualizado com sucesso!  ');
            return $this->redirect('index');
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
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
    
  
   
}
