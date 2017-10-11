<?php

namespace app\controllers;

use app\models\AuditLog;
use app\models\AuthAssignment;
use app\models\ContactForm;
use app\models\LoginForm;
use app\models\Matricula;
use app\models\PasswordResetRequestForm;
use app\models\ResetPasswordForm;
use app\models\Usuario;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class SiteController extends Controller
{

    public $layout = 'site';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout','index-admin'],
                'rules' => [
                    [
                        'actions' => ['logout','index-admin'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],

        ];
    }


    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'foreColor'=>'12721430',
                'testLimit'=> 2,
            ],
        ];
    }

    
    public function actionCalendarioEventos(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
         $matricula = Matricula::find()->where(['estudante_id'=>Yii::$app->user->id,'status'=>1])->one();
        if(\Yii::$app->user->identity->tipo == "Aluno"):
           
            $eventos = \app\models\CalendarioAcademico::find()->select(['count(*) as eventos, date, title, body, footer, badge, curso_id'])->where(['curso_id'=>$matricula->curso_id])->groupBy(['date'])->orderBy('date ASC')->all();
        else:
            $eventos = \app\models\CalendarioAcademico::find()->select(['count(*) as eventos, date, title, body, footer, badge, curso_id'])->groupBy(['date'])->orderBy('date ASC')->all();
        endif;
       
        
        foreach ($eventos as $ev){
              
            if($ev->eventos == 1){
                
                 $items[]  = ["date"=>$ev->date,"badge"=>$ev->badge==1?true:false,"title"=>$ev->title,"body"=>$ev->body.'<small class="pull-right">'.$ev->curso->nome.'</small><br>', "footer"=>"<span class='pull-left small'>".Yii::$app->formatter->asDate($ev->date, 'full')."</span>".$ev->footer];
     
            }else{
                if(\Yii::$app->user->identity->tipo == "Aluno"):
                  $agenda = \app\models\CalendarioAcademico::find()->where(['date'=>$ev->date,'curso_id'=>$matricula->curso_id])->all();
                else:
                  $agenda = \app\models\CalendarioAcademico::find()->where(['date'=>$ev->date])->all();   
                endif;
                $body = "";
                foreach ($agenda as $ag){                    
                    $body .= $ag->body;
                    $body .= '<small class="pull-right">'.$ag->curso->nome.'</small>';
                    $body .= "<hr>";                     
                }
                $items[]  = ["date"=>$agenda[0]->date,"badge"=>$agenda[0]->badge==1?true:false,"title"=>"Eventos do dia","body"=>$body, "footer"=>"<span class='pull-left small'>".Yii::$app->formatter->asDate($ag->date, 'full')."</span>Fiquem atento com as datas!"];

            }
            
        }
        
     
        
       
        return $items;
    }
    
    
    public function actionIndex()
    {
        $formActive = 'login';
        if(!Yii::$app->user->isGuest){
            $this->layout = 'admin';
            return $this->render('index-admin');          
        }else{
            $login = new LoginForm();
            $cadastro = new Usuario();
            $matricula = new Matricula();
            $cadastro->scenario = 'cadastro-estudante';
            if ($login->load(\Yii::$app->request->post())) {
                
                $user = Usuario::find()->where("email='{$login->username}' OR username='{$login->username}'")->one();
               
                if(count($user)>0){
                     $matriculado = false;
                     foreach ($user->matriculas as $mt){
                            if($mt->status == 1){
                                $matriculado = true;
                            }
                     }
                    if($user->dta_expiracao >= date("Y-m-d") || $user->tipo == 'Professor'){
                         if($user->status == Usuario::STATUS_BLOCKED){
                                Yii::$app->getSession()->setFlash('error','<strong>Usuário não encontrado!</strong>,<br>Verifique os dados informados!'); 
                                $formActive = 'login';
                           }else if($user->status == Usuario::STATUS_PENDING){
                                 Yii::$app->getSession()->setFlash('warning','<strong>Usuário aguardando liberação!</strong>,<br>Seu cadastro ainda não foi verificado pela secretária educacional. <br>Por favor aguarde!'); 
                                $formActive = 'login';
                           }else if(!$matriculado && $user->tipo == 'Aluno'){
                                 Yii::$app->getSession()->setFlash('warning','<strong>Sua Matrícula do Curso não esta Ativa!</strong>,<br>Entre em contato com a secretária educacional.'); 
                                $formActive = 'login';
                           }else{
                               if($login->login()){
                                   $audit = new AuditLog();
                                   $audit->model = "Login";
                                   $audit->acao = "Acessou";
                                   $ip = new \app\behaviors\LoggableBehavior();
                                   $audit->ip = $ip->getClientIPAddress();
                                   $audit->data = date('Y-m-d H:i:s');
                                   $audit->user_id = Yii::$app->user->id;
                                   $audit->save();
                                   return $this->goBack(); 
                               }else{
                                     Yii::$app->getSession()->setFlash('error','Verifique os dados de Usuário e Senha'); 
                                     $formActive = 'login';
                               }; 
                         }  
                    }else{
                         Yii::$app->getSession()->setFlash('warning','Seu cadastro precisa ser <strong>Renovado</strong>, entre em contato com a <strong>Secretária Educacional</strong>'); 
                         $formActive = 'login';
                    }
                                     
                }else{
                    Yii::$app->getSession()->setFlash('error','<strong>Usuário não encontrado!</strong>,<br>Verifique os dados informados!'); 
                    $formActive = 'login';
                }        
                                            
            }                
            if($cadastro->load(Yii::$app->request->post()) && $matricula->load(Yii::$app->request->post())){
                 $cadastro->tipo = 'Aluno';
                 $cadastro->status = 2;
                 $cadastro->dta_expiracao = date('Y-m-d', strtotime("+ 1 day"));
                 $cadastro->username = trim($matricula->ra);
                 $cadastro->setPassword(md5(time()));
                 $cadastro->generateAuthKey();
                 $matricula->instituicao_id = substr($matricula->ra, 0,3);
                 $matricula->curso_id = substr($matricula->ra, 3,3);
                 $matricula->ano =substr($matricula->ra, 6,2);
                 $matricula->semestre = substr($matricula->ra, 8,1);
                 $matricula->termo = 4;
                 
                 switch (substr($matricula->ra, 9,1)){
                     case 1:
                         $matricula->periodo ='Matutino';
                         break;
                     case 2:
                         $matricula->periodo ='Vespertino';
                         break;
                     case 3:
                         $matricula->periodo ='Noturno';
                         break;
                     case 4:
                         $matricula->periodo ='EAD';
                         break;
                     default:
                         $matricula->periodo ='Matutino';
                         break;
                 }
               
                 $matricula->etapa_projeto = 1;
                 
                 if($cadastro->validate() && $matricula->validate()){
                    if($cadastro->confirmacao == true){                        
                        $cadastro->save(false);
                        $matricula->estudante_id = $cadastro->id;
                        $matricula->save(false);
                        $authAssignment2 = new AuthAssignment([
							'user_id' => $cadastro->id,
						]);
						$authAssignment2->item_name = "Aluno";
						$authAssignment2->created_at = time();
						$authAssignment2->save();
                        @Yii::$app
                                        ->mailer
                                        ->compose(
                                            ['html' => 'novoCadastro'],
                                            ['user' => $cadastro,'matricula'=>$matricula]
                                        )
                                        ->setFrom([$cadastro->email => \Yii::$app->name])
                                        ->setTo(Yii::$app->params['e-mail-contato-cadastro'])
                                        ->setSubject('Nova Solicitação de Cadastro :: '.Yii::$app->params['instituicao'])
                                        ->send();

                              return $this->render('confirmacao',[
                                  'cadastro'=>$cadastro,
                                  'matricula'=>$matricula
                                  
                              ]);
                           
                    }else{
                        Yii::$app->getSession()->setFlash('error','Por favor você precisa concordar que as informações estão corretas!');
                        $formActive = 'cadastro';
                    }
                }else{
                     Yii::$app->getSession()->setFlash('error','Verifique os dados informados');
                     $formActive = 'cadastro';
                }                     
             }

            return $this->render('index',[
                'login'=>$login,
                'cadastro'=>$cadastro,
                'formActive'=>$formActive,
                'matricula' => $matricula

            ]);
        }
    }
    
 
    
    public function actionCorpoDocente(){
        $professores = Usuario::find()->where(['tipo'=>'Professor','status'=>1])->all();
        return $this->render('corpo-docente',['professores'=>$professores]);
    }
    
    public function actionMaterial(){
        $model = \app\models\ConfiguracaoApp::findOne(15);
        return $this->render('material', ['model'=>$model]);
    }
    
    
    public function actionContato()
    {
        $model= new \app\models\Contato();
         if ($model->load(Yii::$app->request->post())) {
             if (Yii::$app->mailer->compose('contatoForm-html', ['contatoForm' => $model])
                    ->setFrom(Yii::$app->params['e-mail-contato'])
                    ->setTo($model->email)
                    ->setSubject($model->assunto)
                    ->send()){     
                Yii::$app->session->setFlash('success', 'Sua mensagem foi enviada com sucesso, aguarde que logo entraremos em contato!');
            } else {
                Yii::$app->session->setFlash('error', 'Houve um erro no envio do E-mail.');
            }

            return $this->refresh();
        } else {
            return $this->render('contato',
                [ 'model'=>$model]
            );
        }
        
       
    }
    


    public function actionLogout()
    {
        $model = new AuditLog();
        $model->model = "Login";
        $model->acao = "Saiu";
        $ip = new \app\behaviors\LoggableBehavior();
        $model->ip = $ip->getClientIPAddress();
        $model->data = date('Y-m-d H:i:s');
        $model->user_id = Yii::$app->user->id;
        $model->save();
        Yii::$app->user->logout();
            
        return $this->goHome();
    }
    
    public function actionRecuperarSenha()
    {
        //$this->layout = '//main-login';
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Senha redefinida com sucesso!!!<br>Verifique se o seu e-mail para obter mais instruções.');
                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Desculpe, mas não foi possível recuper a senha para este e-mail. <br><strong>Cadastro bloqueado!</strong>');
            }
        }
        Yii::$app->user->logout();
        return $this->render('recuperar-senha', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionRedefinirSenha($token)
    {
       //$this->layout = '//main-login';
       try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
            
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'Sua nova senha foi salva com sucesso!');

            return $this->goHome();
        }
        Yii::$app->user->logout();

        return $this->render('redefinir-senha', [
            'model' => $model,
        ]);
    }

    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            return $this->render('error', ['exception' => $exception]);
        }
    }


}
