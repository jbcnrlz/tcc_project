<?php

namespace app\models;
use app\behaviors\LoggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;


/**
 * This is the model class for table "projeto".
 *
 * @property integer $id
 * @property string $protocolo
 * @property string $tema
 * @property string $palavra_chave
 * @property string $resumo
 * @property string $dta_cadastro
 * @property string $dta_atualizacao
 * @property integer $status
 * @property string $matricula_ra
 * @property integer $orientador_id
 * @property integer $orientador_sugestao_id
 *
 * @property Apresentacao[] $apresentacaos
 * @property Mensagem[] $mensagems
 * @property Matricula $matriculaRa
 * @property Usuario $orientador
 * @property Usuario $orientadorSugestao
 * @property Protocolo[] $protocolos
 * @property RelatorioParcial[] $relatorioParcials
 * @property Tarefas[] $tarefas
 */
class Projeto extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    
    public function behaviors()
    {
       
        return [
            [
                 'class'=> TimestampBehavior::className(),
                 'createdAtAttribute'=>'dta_cadastro',
                 'updatedAtAttribute'=>'dta_atualizacao',
                 'value' => function() { 
                        return date('Y-m-d H:i:s');
                  },
            ],
            [
                'class' => LoggableBehavior::className(),
                
            ],
        
                          
        
            
        ];
    }
    
    public static function tableName()
    {
        return 'projeto';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tema', 'palavra_chave', 'resumo', 'matricula_ra'], 'required'],
            [['resumo'], 'string'],
            [['dta_cadastro', 'dta_atualizacao'], 'safe'],
            [['status', 'matricula_ra','orientador_id', 'orientador_sugestao_id'], 'integer'],
            [['tema', 'palavra_chave'], 'string', 'max' => 255],
            [['matricula_ra'], 'string', 'max' => 14],
            ['matricula_ra', 'exist', 'targetClass' =>  Matricula::className(),'targetAttribute' => ['matricula_ra' => 'ra']],
            ['matricula_ra', 'validacao_ra','on'=>'cadastrar'],
            [['orientador_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['orientador_id' => 'id']],
            [['orientador_sugestao_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['orientador_sugestao_id' => 'id']],
        ];
    }
    
    public function validacao_ra($attribute){
        if(Projeto::find()->where(['and',['matricula_ra'=>$this->matricula_ra,'status'=>1]])->exists()){
                 $this->addError($attribute,'RA não perminitido, pois já existe um projeto em processo!');
                 return false;
             }else{
                 return true;
        }
       
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tema' => 'Tema',
            'palavra_chave' => 'Palavra Chave',
            'resumo' => 'Resumo',
            'dta_cadastro' => 'Data Cadastro',
            'dta_atualizacao' => 'Data Atualização',
            'status' => 'Status',
            'matricula_ra' => 'RA',
            'orientador_id' => 'Orientador',
            'orientador_sugestao_id' => 'Sugestão Orientador',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApresentacaos()
    {
        return $this->hasMany(Apresentacao::className(), ['projeto_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMensagems()
    {
        return $this->hasMany(Mensagem::className(), ['projeto_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMatriculaRa()
    {
        return $this->hasOne(Matricula::className(), ['ra' => 'matricula_ra']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrientador()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'orientador_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrientadorSugestao()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'orientador_sugestao_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArquivosProjetos()
    {
        return $this->hasMany(ArquivosProjeto::className(), ['projeto_id' => 'id']);
    }
    
    public function getProtocolos()
    {
        return $this->hasMany(Protocolos::className(), ['projeto_id' => 'id']);
    }
    
    
  

    
     public function getArquivoProjetoPesquisa()
    {
        return $this->hasOne(ArquivosProjeto::className(), ['projeto_id' => 'id'])->andOnCondition(['etapa_projeto'=>1]);
    }
    
  
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelatorioParcials()
    {
        return $this->hasMany(RelatoriosParciais::className(), ['projeto_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTarefas()
    {
        return $this->hasMany(Tarefas::className(), ['projeto_id' => 'id']);
    }
}
