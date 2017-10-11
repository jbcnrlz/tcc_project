<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;
use app\models\CropImagem;
use app\models\Matricula;
use app\models\Usuario;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

/**
 * Description of Perfil
 *
 * @author Edson
 */
class PerfilController extends Controller {
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
        
        public function actionIndex(){
            
            $model = Usuario::findOne(Yii::$app->user->id);
            $matriculaProvider = new ActiveDataProvider([
                    'query'=> Matricula::find()->where(['estudante_id'=>Yii::$app->user->id]),
                    'pagination'=>['pageSize'=>10],
                    'sort'=>[
                        'defaultOrder'=>[
                            'status'=>SORT_DESC,
                        ],                        
                    ]
                ]);
                $modelcrop = CropImagem::findOne(Yii::$app->user->id);
                if ($modelcrop->load(Yii::$app->request->post()))
                {                         
                         $modelcrop->foto = \yii\web\UploadedFile::getInstance($modelcrop, 'foto');
                         if($modelcrop->foto->tempName != ""){
                             $this->refresh();
                             if ($modelcrop->save()) {
                                  @unlink(Yii::getAlias("@app/upload/avatarPerfil/".$model->foto));
                                   $model->foto = $modelcrop->nomeFoto.".jpg";
                                   $model->save(false);
                                   $this->refresh();
                                   Yii::$app->session->setFlash('success', 'Foto do perfil atualizada com sucesso!');
                                   return $this->redirect(['/perfil']);
                            }
                         }else{
                               Yii::$app->session->setFlash('error','Imagem não foi salva, siga as instruções abaixo');
                    

                         }                

                }
            return $this->render('index',[
                'model'=>$model,
                'modelcrop' => $modelcrop,
                'matriculaProvider'=>$matriculaProvider
            ]);
            
        }
        
        public function actionAtualizar(){
            $model = Usuario::findOne(Yii::$app->user->id);
            
            if($model->load(Yii::$app->request->post()) && $model->validate()){
                    if(!empty($model->new_password)){   
                         if(!empty($model->old_password)){ 
                            if(!$model->validatePassword($model->old_password)){
                                Yii::$app->session->setFlash('error','Erro ao salvar os dados<br><strong>Verifique os campos Obrigatórios</strong>');
                                $model->addError('old_password', 'Senha Atual não confere');
                                return $this->render('atualizar',[
                                    'model'=>$model
                                ]);
                            }
                          }else{
                                $model->addError('old_password', 'Digite a senha atual');
                                return $this->render('atualizar',[
                                      'model'=>$model
                                 ]);
                          }
                          $model->setPassword($model->new_password);
                                         
                     }
                     if($model->save()){
                        Yii::$app->session->setFlash('success','Seus dados foram salvo com sucesso!');
                        return $this->redirect(['/perfil']);
                     }else{
                        Yii::$app->session->setFlash('error','Erro ao salvar os dados<br><strong>Verifique os campos Obrigatórios</strong>');
                    }
                   
                    
            }                      
                       
            
            return $this->render('atualizar',[
                'model'=>$model
            ]);
        }
    
}
