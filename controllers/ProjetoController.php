<?php

namespace app\controllers;
use app\models\ArquivosProjeto;
use app\models\DtaProtocolar;
use app\models\Projeto;
use app\models\ProjetoProcura;
use app\models\RelatoriosParciais;
use app\models\Usuario;
use kartik\mpdf\Pdf;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class ProjetoController extends Controller
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

    public function beforeAction($action) {
        if($action->id == "index" || $action->id == "projeto-protocolado")
            $this->enableCsrfValidation = false;
            return parent::beforeAction($action);
    }

    public function actionIndex()
    {

       if(Yii::$app->request->post('filtro')){
           $query = Projeto::find()->innerJoinWith('matriculaRa');
           
           $query->andFilterWhere(['=','matricula.etapa_projeto',$_POST['filtro']['etapa']]);
           $query->andFilterWhere(['=','matricula.curso_id',$_POST['filtro']['curso']]);
           $query->andFilterWhere(['=','matricula.periodo',$_POST['filtro']['periodo']]);
           $query->andFilterWhere(['=','projeto.status',$_POST['filtro']['status']]);
           $query->andWhere(['not', ['orientador_id'=>null]]);
           $dataProvider = new ActiveDataProvider([
               'query'=>$query,
               'pagination'=>[
                   'pageSize'=>40
               ]
           ]);
           
        }else{
            $procurarModel = new ProjetoProcura();
            $dataProvider = $procurarModel->search(['ProjetoProcura'=>['search'=>Yii::$app->getRequest()->getQueryParam('p')]]);
        }
       
         if(Yii::$app->request->post('hasEditable')){
           $idReg = $_POST['editableKey'];
           $model = Projeto::findOne($idReg);
           $out = Json::encode(['output'=>'','message'=>'']);
           $postado = current($_POST['Projeto']);
           $post['Projeto'] = $postado;
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
    }
    
    public function actionMeuProjeto(){
      
      if(Yii::$app->user->identity->tipo == "Aluno"): 
            $model = Projeto::find()->innerJoinWith('matriculaRa')->where(['and',['matricula_ra'=>Yii::$app->user->identity->matriculasAtiva->ra,'projeto.status'=>1]])->one();
       
      
   
      if(count($model) > 0){           
                return $this->redirect(['/projeto/meu-projeto/'.$model->id.'/visualizar']);
            }else{
                return $this->redirect(['/projeto/meu-projeto/cadastrar']);
            }
       else:
           return $this->redirect(['/']);
       endif;
        
    }
    
    
    public function actionProjetoDesignado(){
        
        if(Yii::$app->request->isAjax && Yii::$app->request->post()){
            $id = Yii::$app->request->post('id');
            $acao = Yii::$app->request->post('acao');
            $model = Projeto::findOne($id);
            if($acao == 'aceitar'){                   
                $model->orientador_id = Yii::$app->user->id;
                $model->orientador_sugestao_id = null;
                if($model->save()){
                    
                     Yii::$app->session->setFlash('success', 'Projeto <strong>aceito</strong> com sucesso!');
                     return $this->redirect(['projeto-designado']);
                    echo 1;
                }
            }else if($acao == 'recusar'){
                $model->orientador_id = null;
                $model->orientador_sugestao_id = null;
                if($model->save()){
                      Yii::$app->session->setFlash('success', 'Projeto <strong>recusado</strong> com sucesso!');
                     return $this->redirect(['projeto-designado']);
                    echo 1;
                }
            }
          
        }
        
        $query = Projeto::find()->innerJoinWith(['matriculaRa','arquivosProjetos']);
        $query->andFilterWhere(['=','matricula.etapa_projeto',1]);
        $query->andFilterWhere(['=','projeto.status',1]);
        $query->andFilterWhere(['=','arquivos_projeto.etapa_projeto',1]);
        $query->andFilterWhere(['=','orientador_sugestao_id',Yii::$app->user->id]);
       
         $dataProvider = new ActiveDataProvider([
               'query'=>$query,
               'pagination'=>[
                   'pageSize'=>40
               ]
        ]);    
         
        return $this->render('projeto-designado', [
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionProjetoOrientando(){
        $query = Projeto::find()->innerJoinWith(['matriculaRa']);
        $query->andFilterWhere(['=','orientador_id',Yii::$app->user->id]);
        if(Yii::$app->request->post('filtro')){    
           $query->andFilterWhere(['=','matricula.etapa_projeto',$_POST['filtro']['etapa']]);
           $query->andFilterWhere(['=','matricula.curso_id',$_POST['filtro']['curso']]);
           $query->andFilterWhere(['=','matricula.periodo',$_POST['filtro']['periodo']]);
           $query->andFilterWhere(['=','projeto.status',$_POST['filtro']['status']]);       
         
                            
        }
         $dataProvider = new ActiveDataProvider([
               'query'=>$query,
               'pagination'=>[
                   'pageSize'=>40
               ]
        ]);    
         
        return $this->render('projeto-orientando', [
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionProjetoProtocolado(){
        
        $query = Projeto::find()->innerJoinWith(['matriculaRa','arquivosProjetos']);
        $query->andFilterWhere(['=','matricula.etapa_projeto',1]);
        $query->andFilterWhere(['=','projeto.status',1]);
        $query->andFilterWhere(['=','arquivos_projeto.etapa_projeto',1]);
  
        $query->andWhere(['IS','orientador_id',null]);
        
       
        if(Yii::$app->request->post('filtro')){        
           $query->andFilterWhere(['=','matricula.curso_id',$_POST['filtro']['curso']]);
           $query->andFilterWhere(['=','matricula.periodo',$_POST['filtro']['periodo']]);

                            
        }
         $dataProvider = new ActiveDataProvider([
               'query'=>$query,
               'pagination'=>[
                   'pageSize'=>40
               ]
        ]);    
         
        return $this->render('projeto-protocolado', [
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionVisualizar($id)
    {
        $model = $this->findModel($id);
               
        $habilitaProtocolo = false;
        
        $datahoje = date("Y-m-d");
        
        $dtaProtocolo = DtaProtocolar::find()->where("('{$datahoje}' BETWEEN dta_inicio AND dta_termino) "
        . "AND curso_id = '{$model->matriculaRa->curso_id}'  "
        . "AND etapa_projeto = {$model->matriculaRa->etapa_projeto}")->one();
        
        if(count($dtaProtocolo)==0){
            $dtaProtocolo = DtaProtocolar::find()->where("('{$datahoje}' BETWEEN dta_inicio AND dta_termino) "
            . "AND curso_id = '{$model->matriculaRa->curso_id}'  "
            . "AND etapa_projeto = {$model->matriculaRa->etapa_projeto} "
            . "AND matricula_ra = '{$model->matricula_ra}'")->one();
        }
        
             
     
       
        $regProtocolo = ArquivosProjeto::find()->andWhere(['projeto_id'=>$id,'etapa_projeto'=>$model->matriculaRa->etapa_projeto])->all();
        if(count($regProtocolo)==0){
            $habilitaProtocolo = true;
        }
        $protocolosProvider = new ActiveDataProvider([
                    'query'=> ArquivosProjeto::find()->where(['projeto_id'=>$id]),
                    'pagination'=>['pageSize'=>10],
                    'sort'=>[
                        'defaultOrder'=>[
                            'etapa_projeto'=>SORT_ASC,
                        ],                        
                    ]
                ]);
        
        $relatoriosQualificacao = RelatoriosParciais::find()->where(['and',['projeto_id'=>$id,'etapa_projeto'=>2]])->orderBy('fase ASC')->all();
        $relatoriosDefesa = RelatoriosParciais::find()->where(['and',['projeto_id'=>$id,'etapa_projeto'=>3]])->orderBy('fase ASC')->all();
        if(Yii::$app->params['qtde-relatorio'] == 2):
               $aptoQualificacao = RelatoriosParciais::find()->where(['and',['projeto_id'=>$id,'etapa_projeto'=>2, 'fase'=>2]])->one();
               $aptoDefesa = RelatoriosParciais::find()->where(['and',['projeto_id'=>$id,'etapa_projeto'=>3, 'fase'=>2]])->one();
         else:
              $aptoQualificacao = RelatoriosParciais::find()->where(['and',['projeto_id'=>$id,'etapa_projeto'=>2, 'fase'=>1]])->one();
              $aptoDefesa = RelatoriosParciais::find()->where(['and',['projeto_id'=>$id,'etapa_projeto'=>3, 'fase'=>1]])->one();
            endif;
        
         return $this->render('visualizar', [
                'model' => $this->findModel($id),
                'protocolosProvider'=>$protocolosProvider,
                'habilitaProtocolo'=>$habilitaProtocolo,
                'relatoriosQualificacao'=>$relatoriosQualificacao,
                'relatoriosDefesa'=>$relatoriosDefesa,
                'aptoQualificacao'=>$aptoQualificacao,
                'aptoDefesa'=>$aptoDefesa,
                'dtaProtocolo'=>$dtaProtocolo
            ]);
        
        
        
    }
    
    public function actionRelatorioparcial($id){

        $model = RelatoriosParciais::findOne($id);
        
        if($model->load(Yii::$app->request->post())){
            if($model->projeto->orientador_id == Yii::$app->user->id){
                if ($model->validate()) { 
                    if($model->fase == 2){
                         $rel1 = RelatoriosParciais::find()->where(['and',['fase'=>1,'etapa_projeto'=>$model->etapa_projeto,'projeto_id'=>$model->projeto_id]])->one();
                         $media = ($rel1->nota + $model->nota)/2;
                         if($media >= 6){
                            $model->apto = 1;
                         }else{
                            $model->apto = 0;
                         }
                    }
                    $model->descricao = str_replace("===quebra-pagina===","<pagebreak />",$model->descricao);
                    $model->dataCadastro = date("Y-m-d H:i:s");           
                    $model->save(false);
                    Yii::$app->session->setFlash('success', 'Relatório atualizado com sucesso!  '); 
                    return $this->redirect(['visualizar', 'id' => $model->projeto_id]); 
                }
            }else{
                 Yii::$app->session->setFlash('error', 'Você não tem permissão para atualizar este Relatório!<br>'
                         . 'Somente o orientador(a) é permitido.');
            }
            
        } 
        $model->descricao = str_replace("<pagebreak />","===quebra-pagina===",$model->descricao);
        return $this->render('relatorioparcial', [ 
                'model' => $model, 
        ]); 
        
    }
    
    public function actionRelatorioParciaisImp($id){
        $model = RelatoriosParciais::findOne($id);
        $rel1 = RelatoriosParciais::find()->where(['and',['fase'=>1,'etapa_projeto'=>$model->etapa_projeto,'projeto_id'=>$model->projeto_id]])->one();
                  
//        return $this->renderPartial('_relatorioParcialPrint',['model'=>$model]);
        $content = $this->renderPartial('_relatorioParcialPrint',['model'=>$model,'nota1'=>$rel1->nota]);
        
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE, 
            // A4 paper format
            'format' => Pdf::FORMAT_A4, 
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT, 
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER, 
            // your html content input
            'marginTop'=>40,
            'content' => $content,  
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            'cssInline' => '.row{margin-top:10px}'
            . '{display:none}'            
            . '.container{padding-top:20px;background:#fff;z-index:9999}'
            . '.assinatura{margin-top:70px;}'
            . '.conteudo-atividade{height:500px; text-align:justify}', 
             // set mPDF properties on the fly
            'options' => ['title' => 'Relatório Parcial'],
             // call mPDF methods on the fly
            'methods' => [ 
                'SetHeader'=>'<div class="text-center"><img src="/imagem/cabecalho-relatorio.png" border="0"></div>', 
                'SetFooter'=>[$model->projeto->matriculaRa->getNomeEtapa($model->etapa_projeto).'|'.date("d/m/Y").'|{PAGENO}/{nb}'],
            ]
        ]);

        // return the pdf output as per the destination setting
        return $pdf->render(); 
    }


    public function actionCadastrar()
    {
        $model = new Projeto();
        $professores = ArrayHelper::map(
                Usuario::find()->where([
                    'tipo'=>'Professor'
                    ])->asArray()->all(),
                'id', 'nome');
        
        $model->scenario =  'cadastrar';
        
        if(Yii::$app->user->identity->tipo == "Aluno"){
           $matricula = \app\models\Matricula::find()->where(['status'=>1,'estudante_id'=>Yii::$app->user->identity->id])->one();
           $model->matricula_ra = $matricula->ra; 
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            
            $relatorio = new RelatoriosParciais;
            $relatorio->etapa_projeto = 2;
            $relatorio->fase=1;
            $relatorio->projeto_id=$model->id;
            $relatorio->dataCadastro=date('Y-m-d H:i:s');
            $relatorio->save();
             
                    $relatorio = new RelatoriosParciais;
                    $relatorio->etapa_projeto = 2;
                    $relatorio->fase=2;
                    $relatorio->projeto_id=$model->id;
                    $relatorio->dataCadastro=date('Y-m-d H:i:s');
                    $relatorio->save();  
             
 
            $relatorio = new RelatoriosParciais;
            $relatorio->etapa_projeto = 3;
            $relatorio->fase=1;
            $relatorio->projeto_id=$model->id;
            $relatorio->dataCadastro=date('Y-m-d H:i:s');
            $relatorio->save();
               
                        $relatorio = new RelatoriosParciais;
                        $relatorio->etapa_projeto = 3;
                        $relatorio->fase=2;
                        $relatorio->projeto_id=$model->id;
                        $relatorio->dataCadastro=date('Y-m-d H:i:s');
                        $relatorio->save();

               
            
            Yii::$app->session->setFlash('success', 'Registro cadastrado com sucesso!  ');
              $this->redirect(Yii::$app->request->referrer);
              if(Yii::$app->user->identity->tipo == "Aluno"){
                  return $this->redirect(['meu-projeto']);
              }else{
                  return $this->redirect(['visualizar', 'id' => $model->id]);
              }
              

        } else {
            
            return $this->render('cadastrar', [
                'model' => $model,
                'professores'=>$professores
            ]);
            
        }
    }

    public function actionProtocoloArquivoDeletar(){
        $model = ArquivosProjeto::findOne($_GET['id']);
        $arquivo = '@app'.$model->arquivo;
        $arquivo = Yii::getAlias($arquivo);
       
        if($model->podeDeletar){
            if($model->delete()){         
                unlink($arquivo);
                Yii::$app->session->setFlash('success', 'Arquivo deletado com sucesso!'); 
               return $this->redirect(['visualizar', 'id' => $_GET['idp']]);
            }else{
                Yii::$app->session->setFlash('error', 'Erro ao deletadar o arquivo!');  
                 return $this->redirect(['visualizar', 'id' =>  $_GET['idp']]);
            }
        }else{
            Yii::$app->session->setFlash('error', 'Fora do tempo para deletar o arquivo!');   
            return $this->redirect(['visualizar', 'id' =>  $_GET['idp']]);
        }        
    }
    
    public function actionProtocolarArquivo($idp){
        $protocolo = new ArquivosProjeto();
              
        $projeto = Projeto::findOne($idp);
                
        $arquivoFile = UploadedFile::getInstance($protocolo, 'arquivo');

        $directory = Yii::getAlias('@app/upload/trabalhosProtocolados'). DIRECTORY_SEPARATOR . $projeto->matricula_ra . DIRECTORY_SEPARATOR;
        if (!is_dir($directory)) {
            FileHelper::createDirectory($directory);
        }

        if ($arquivoFile) {
            $uid = strtoupper(substr(uniqid(NULL, true),0,14));
            $fileName = $uid.'.'. $arquivoFile->extension;
            $filePath = $directory . $fileName;
            if ($arquivoFile->saveAs($filePath)) {
                $path = '/upload/trabalhosProtocolados/' .$projeto->matricula_ra . '/' . $fileName;
                $protocolo->registro_protocolo = $uid;
                $protocolo->tema = $projeto->tema;
                $protocolo->arquivo = $path;
                $protocolo->projeto_id = $projeto->id;
                $protocolo->etapa_projeto = $projeto->matriculaRa->etapa_projeto;
                $protocolo->save(false);
                return Json::encode([
                    'files' => [
                        [
                            'name' => $fileName,
                            'size' => $arquivoFile->size,
                            'url' => $path,
                            'thumbnailUrl' => $path,
                            'deleteUrl' => 'image-delete?name=' . $fileName,
                            'deleteType' => 'POST',
                        ],
                    ],
                ]);
            }
        }else{
            echo $arquivoFile;
        }

        return '';
    }

    public function actionAtualizar($id)
    {
        $model = $this->findModel($id);
        $professores = ArrayHelper::map(
                Usuario::find()->where([
                    'tipo'=>'Professor'
                    ])->asArray()->all(),
                'id', 'nome');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Registro atualizado com sucesso!  ');
            return $this->redirect(['visualizar', 'id' => $model->id]);
        } else {
            return $this->render('atualizar', [
                'model' => $model,
                'professores'=>$professores
            ]);
        }
    }

    public function actionDelete($id)
        {
            $request = Yii::$app->request;
            if ($request->validateCsrfToken()) {
                
               $rel = RelatoriosParciais::find()->where(['projeto_id'=>$id])->all();
               foreach ($rel as $r){
                   if(strip_tags($r->descricao)!=""){
                       Yii::$app->session->setFlash('error', 'Não é possivel apagar o projeto.<br>Existe um relatório preenchido!');
                       return $this->redirect(['index']);
                   }
               }
                
               if (Yii::$app->request->post('pk')) {
                    $pk = Yii::$app->request->post('pk');
                    $explode = explode(",", $pk);
                    if ($explode)
                        foreach ($explode as $v) {
                            if($v)
                            $this->findModel($v)->delete();
                        }
                    Yii::$app->session->setFlash('success', 'Projeto apagado com sucesso!');
                    echo 1;
                }elseif (Yii::$app->request->isAjax && isset($post['custom_param'])) {
                    if ($this->findModel($id)->delete()) {
                         Yii::$app->session->setFlash('success', 'Projeto apagado com sucesso!');
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
                    Yii::$app->session->setFlash('success', 'Projeto apagado com sucesso!');
                    return $this->redirect(['index']);
                }   
                
                
                
            }         
        }



    protected function findModel($id)
    {
        
        if (($model = Projeto::findOne($id)) !== null) {
            if(Yii::$app->user->identity->tipo=="Aluno"){
                if(!($model->matriculaRa->estudante->id == Yii::$app->user->id)){
                    throw new \yii\web\ForbiddenHttpException('Você não tem permissão de realizar esta operação');
                }
             }
            return $model;
        } else {
            if(Yii::$app->user->identity->tipo=="Aluno"){
                throw new \yii\web\ForbiddenHttpException('Você não tem permissão de realizar esta operação');
            }else{
                throw new NotFoundHttpException('Sua requisição não existe.');
            }
            
        }
    }
    
  
    public function actionExportar(){
        //permitir exportação de relatórios
    }
}
