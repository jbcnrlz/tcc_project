<?php

namespace app\models;

use app\behaviors\LoggableBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "protocolo".
 *
 * @property integer $id
 * @property string $tema
 * @property string $arquivo
 * @property string $dta_cadastro
 * @property integer $projeto_id
 * @property integer $etapa_projeto
 *
 * @property Projeto $projeto
 */
class ArquivosProjeto extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'arquivos_projeto';
    }
    
    public function behaviors()
    {
       
        return [
            [
                 'class'=> TimestampBehavior::className(),
                 'createdAtAttribute'=>'dta_cadastro',
                 'updatedAtAttribute'=>false,
                 'value' => function() { 
                        return date('Y-m-d H:i:s');
                  },
            ],
            [
                'class' => LoggableBehavior::className(),
                
            ],
        
                          
        
            
        ];
    }
    
  

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['projeto_id', 'etapa_projeto'], 'required'],
            [['dta_cadastro'], 'safe'],
            [['projeto_id', 'etapa_projeto'], 'integer'],
            [['tema', 'arquivo', 'registro_protocolo'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'registro_protocolo'=>'ID',
            'tema' => 'Tema',
            'arquivo' => 'Arquivo',
            'dta_cadastro' => 'Data Envio',
            'projeto_id' => 'Projeto ID',
            'etapa_projeto' => 'Etapa Projeto',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    
    public function getPodeDeletar(){
        if(Yii::$app->user->identity->tipo == "Aluno"):
         $dataAtual = date("Y-m-d H:i:s");
         $tempo = date("Y-m-d H:i:s",strtotime("$this->dta_cadastro + 15 minutes"));
         if($tempo > $dataAtual){
            return true;    
          }else{
            return false;
         }
        endif;
        return true;
    }
    public function getProjeto()
    {
        return $this->hasOne(Projeto::className(), ['id' => 'projeto_id']);
    }
    
    public function getEtapas(){
        return ['1' => 'Projeto de Pesquisa', '2' => 'Trabalho de Graduação I', '3' => 'Trabalho de Graduação II', '4' => 'Graduado'];
    }
    
    public function getNomeEtapa(){
        return $this->etapa_projeto = $this->etapas[$this->etapa_projeto];
    }

  }
