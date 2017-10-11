<?php

namespace app\controllers;

use app\models\AuthAssignment;
use app\models\AuthItem;
use app\models\CropImagem;
use app\models\Matricula;
use app\models\Usuario;
use app\models\UsuarioProcurar;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class UsuarioController extends Controller
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
		$searchModel = new UsuarioProcurar();
		$dataProvider = $searchModel->search(['UsuarioProcurar'=>['search'=>Yii::$app->getRequest()->getQueryParam('p')]]);

		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

        
        public function actionEnviarNotificacao($id){
                    $model = $this->findModel($id);
                    
                    if($model->notificacao == 1){
                        if (!Usuario::isPasswordResetTokenValid($model->password_reset_token)) {
                            $model->generatePasswordResetToken();
                        }
                        Yii::$app->session->set('logAcao', 'Notificação Novo Cadastro');

                        if ($model->save()) {
                   
                        if(Yii::$app
                                    ->mailer
                                    ->compose(
                                        ['html' => 'ativacaoCadastro'],
                                        ['user' => $model]
                                    )
                                    ->setFrom([Yii::$app->params['e-mail-contato'] => \Yii::$app->name])
                                    ->setTo([$model->email=>$model->nome])
                                    ->setSubject('Ativação do Cadastro :: '.Yii::$app->params['instituicao'])
                                    ->send()){
                                        Yii::$app->session->setFlash('success', 'Notificação para o Estudante foi enviada com sucesso!');
                                        $model->notificacao = 0;
                                        $model->save(false);
                                    }
                         else {
                            Yii::$app->session->setFlash('error', 'Erro ao enviar a notificação para o estudante');
                         }        
                    }else{
                        Yii::$app->session->setFlash('error', 'Erro ao gerar o token de segurança'); 
                    }
                    
                    
                }else{
                    if(Yii::$app
                                    ->mailer
                                    ->compose(
                                        ['html' => 'atualizacaoCadastro'],
                                        ['user' => $model]
                                    )
                                    ->setFrom([Yii::$app->params['e-mail-contato'] => \Yii::$app->name])
                                    ->setTo([$model->email=>$model->nome])
                                    ->setSubject('Atualização do Cadastro :: '.Yii::$app->params['instituicao'])
                                    ->send()){
                                        Yii::$app->session->setFlash('success', 'Notificação para o Estudante foi enviada com sucesso!');
                                        $model->notificacao = 0;
                                        $model->save(false);
                                    }
                }
                return $this->redirect(['visualizar', 'id' => $model->id]);
                    
                        
            
        }

	public function actionVisualizar($id)
	{
                $model = $this->findModel($id);  
                $matriculaProvider = new ActiveDataProvider([
                    'query'=> Matricula::find()->where(['estudante_id'=>$id]),
                    'pagination'=>['pageSize'=>10],
                    'sort'=>[
                        'defaultOrder'=>[
                            'status'=>SORT_DESC,
                        ],                        
                    ]
                ]);
		
		$authAssignments = AuthAssignment::find()->where([
			'user_id' => $model->id,
		])->column();

		$authItems = ArrayHelper::map(
			AuthItem::find()->where([
				'type' => 1,
			])->asArray()->all(),
			'name', 'name');

		$authAssignment = new AuthAssignment([
			'user_id' => $model->id,
		]);

		if ($authAssignment->load(Yii::$app->request->post())) {
                      	AuthAssignment::deleteAll(['user_id' => $model->id]);
                       
                                                
			if (is_array($authAssignment->item_name)) {
				foreach ($authAssignment->item_name as $item) {
            				     $authAssignment2 = new AuthAssignment([
							'user_id' => $model->id,
						]);
						$authAssignment2->item_name = $item;
						$authAssignment2->created_at = time();
						$authAssignment2->save();

						$authAssignments = AuthAssignment::find()->where([
							'user_id' => $model->id,
						])->column();
				
				}
			}
			Yii::$app->session->setFlash('success', 'Permissões Atualizadas com sucesso!');
                       
		}
                $authAssignment->item_name = $authAssignments;
                
                $modelcrop = CropImagem::findOne($id);
                if ($modelcrop->load(Yii::$app->request->post()))
                {                         
                         $modelcrop->foto = \yii\web\UploadedFile::getInstance($modelcrop, 'foto');
                         if($modelcrop->foto->tempName != ""){
                             $this->refresh();
                             if ($modelcrop->save()) {
                                   @unlink(Yii::getAlias("@app/upload/avatarPerfil/".$model->foto.".jpg"));
                                   $model->foto = $modelcrop->nomeFoto.".jpg";
                                   $model->save(false);
                                   $this->refresh();
                                   Yii::$app->session->setFlash('success', 'Foto do perfil atualizada com sucesso!');
                                   return $this->redirect(['visualizar', 'id' => $model->id]);
                            }
                         }else{
                             Yii::$app->getSession()->setFlash('error','Imagem não foi salva, siga as instruções abaixo');
//                           
                         }                

                }
               
               
		return $this->render('visualizar', [
			'model' => $model,
                         'matriculaProvider'=>$matriculaProvider,
			'authAssignment' => $authAssignment,
			'authItems' => $authItems,
                        'modelcrop' => $modelcrop
		]);
               
	}

        public function actionExportar(){
            
        }

	public function actionCadastrar()
	{
		$model = new Usuario();

		if ($model->load(Yii::$app->request->post())) {
                     $password = $model->password_hash;
                     $model->setPassword($password);
                     $model->generateAuthKey();
                     if($model->save()){
                        Yii::$app->session->setFlash('success', 'Usuário cadastrado com sucesso!');
                        return $this->redirect(['visualizar', 'id' => $model->id]); 
                     }else{
                       Yii::$app->session->setFlash('error', 'Erro ao cadastrar o usuário!');
                       $model->password_hash = $password;
                       
                     }
		} 
		
                return $this->render('cadastrar', [
			'model' => $model,
		]);
		
	}


	public function actionAtualizar($id)
	{
		$model = $this->findModel($id);
                
                $oldStatus = $model->status;
                $oldDtaExpiracao = $model->dta_expiracao;

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
                        
                        if($oldStatus == 2){
                           $model->notificacao = 1;
                           $model->save(false);
                        }else if($oldStatus == 0 && $model->status == 1){
                           $model->notificacao = 2;
                           $model->save(false);                          
                        }else if($oldStatus == 1 && $model->status == 1 && $oldDtaExpiracao < $model->dta_expiracao){
                           $model->notificacao = 2;
                           $model->save(false);
                        }
                    
                        if($model->tipo == 'Aluno'){
                            $model->lattes = "";
                            $model->pesquisa = "";
                        }else if($model->tipo == 'Professor'){
                            if(isset($model->ra))
                                $model->ra = "";
                        }
			if (!empty($model->new_password)) {
			    $model->setPassword($model->new_password);
			}
			$model->status = $model->status;
			if ($model->save()) {
                             if(Yii::$app->session->get('notificacao')){
			         Yii::$app->session->setFlash('success', 'Usuário atualizado com sucesso!<br><strong>Lembre-se de Enviar a Notificação para o Estudante</strong>');
                             }else{
                                 Yii::$app->session->setFlash('success', 'Usuário atualizado com sucesso!');
                             }
                            return $this->redirect(['visualizar', 'id' => $model->id]);
			} else {
			    Yii::$app->session->setFlash('error', 'Erro ao atualizar o usuário!');
                            return $this->redirect(['atualizar', 'id' => $model->id]);
			}
			
		} else {
			$model->status = $model->status;
			return $this->render('atualizar', [
				'model' => $model,
			]);
		}
	}


	public function actionDelete($id)
	{
                try{
                $request = Yii::$app->request;
                $post = $request->post();
                if ($request->validateCsrfToken()) {
                   if (Yii::$app->request->post('pk')) {
                        $pk = Yii::$app->request->post('pk');
                        $explode = explode(",", $pk);
                        if ($explode)
                            foreach ($explode as $v) {
                                if($v){
                                    $model = $this->findModel($v);
                                    if($model->delete()){
                                        $authAssignments = AuthAssignment::find()->where([
                                                'user_id' => $model->id,
                                        ])->all();
                                        foreach ($authAssignments as $authAssignment) {
                                                $authAssignment->delete();
                                        }
                                        Yii::$app->session->setFlash('success', 'Usuário excluido com sucesso!');
                                    }
                                }
                            }
                        Yii::$app->session->setFlash('success', 'Usuários apagados com sucesso!  ');
                        echo 1;
                    }elseif (Yii::$app->request->isAjax && isset($post['custom_param'])) {
                        $model = $this->findModel($id);
                        if($model->delete()){
                            $authAssignments = AuthAssignment::find()->where([
                                    'user_id' => $model->id,
                            ])->all();
                            foreach ($authAssignments as $authAssignment) {
                                    $authAssignment->delete();
                            }
                            Yii::$app->session->setFlash('success', 'Usuário excluido com sucesso!');
                        }
                     
                        echo Json::encode([
                                'success' => true,
                         ]);
                         return;
                    } elseif (Yii::$app->request->post() || Yii::$app->request->isAjax) {
                        $model = $this->findModel($id);
                        if($model->delete()){
                            $authAssignments = AuthAssignment::find()->where([
                                'user_id' => $model->id,
                            ])->all();
                            foreach ($authAssignments as $authAssignment) {
                                    $authAssignment->delete();
                            }
                            Yii::$app->session->setFlash('success', 'Usuário excluido com sucesso!');
                        }
                         echo Json::encode([
                                'success' => true,
                         ]);
                        return $this->redirect(['index']);
                    }      
                }  
                }catch(yii\db\IntegrityException $e){
                    Yii::$app->session->setFlash('error','Existe registros relacionados a este usuário então o mesmo não pode ser excluido. <br>Recomendamos que apenas o <strong>Desative</strong>');
                    return $this->redirect(['index']);
                }
            
	
	}

	protected function findModel($id)
	{
		if (($model = Usuario::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('A página solicitada não existe!');
		}
	}
}
