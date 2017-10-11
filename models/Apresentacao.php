<?php

namespace app\models;

use app\behaviors\LoggableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "apresentacao".
 *
 * @property integer $id
 * @property string $dta_apresentacao
 * @property string $periodo
 * @property string $horario
 * @property string $local
 * @property string $dta_versao_final
 * @property integer $resultado_aprovacao
 * @property string $dta_cadastro
 * @property integer $status
 * @property integer $orientador_id
 * @property integer $convidado_primario_id
 * @property integer $convidado_secundario_id
 * @property integer $etapa_projeto
 * @property integer $projeto_id
 * @property string $curso_id
 *
 * @property Curso $curso
 * @property Projeto $projeto
 * @property Usuario $orientador
 * @property Usuario $convidadoSecundario
 * @property Usuario $convidadoPrimario
 * @property Avaliacao[] $avaliacaos
 * @property RegistroAta[] $registroAtas
 */
class Apresentacao extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
     public static function tableName()
    {
        return 'apresentacao';
    }
    
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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dta_apresentacao', 'periodo', 'horario', 'local', 'orientador_id', 'convidado_primario_id', 'etapa_projeto', 'projeto_id', 'curso_id'], 'required'],
            [['dta_apresentacao', 'horario', 'dta_versao_final', 'dta_cadastro'], 'safe'],
            [['resultado_aprovacao', 'status', 'orientador_id', 'convidado_primario_id', 'convidado_secundario_id', 'etapa_projeto', 'projeto_id'], 'integer'],
            ['orientador_id', 'validacaoOrientador','on'=>'cadastrar'],
            [['dta_versao_final','resultado_aprovacao'],'required', 'on'=>'avaliacaoFinal'],
            ['convidado_primario_id', 'validacaoConvidadoPrimario','on'=>'cadastrar'],
            ['convidado_secundario_id', 'validacaoConvidadoSecundario','on'=>'cadastrar'],
            [['periodo'], 'string', 'max' => 45],
            [['local'], 'string', 'max' => 255],
            [['curso_id'], 'string', 'max' => 4]
        ];
    }
    
    
    public function validacaoOrientador($attribute){
        if(Apresentacao::find()->where(['and',['orientador_id'=>$this->orientador_id,'dta_apresentacao'=>$this->dta_apresentacao,'horario'=>$this->horario]])->exists()){
                 $this->addError($attribute,'Este professor já tem uma banca neste dia e horário.');
                 return false;
             }else{
                 return true;
        }
       
    }
     public function validacaoConvidadoPrimario($attribute){
        if(Apresentacao::find()->where(['and',['convidado_primario_id'=>$this->convidado_primario_id,'dta_apresentacao'=>$this->dta_apresentacao,'horario'=>$this->horario]])->exists()){
                 $this->addError($attribute,'Este professor já tem uma banca neste dia e horário.');
                 return false;
             }else{
                 return true;
        }
       
    }
     public function validacaoConvidadoSecundario($attribute){
        if(Apresentacao::find()->where(['and',['convidado_secundario_id'=>$this->convidado_secundario_id,'dta_apresentacao'=>$this->dta_apresentacao,'horario'=>$this->horario]])->exists()){
                 $this->addError($attribute,'Este professor já tem uma banca neste dia e horário.');
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
            'dta_apresentacao' => 'Data Apresentação',
            'periodo' => 'Periodo',
            'horario' => 'Horário',
            'local' => 'Local',
            'dta_versao_final' => 'Data Versão Final',
            'resultado_aprovacao' => 'Resultado Aprovação',
            'dta_cadastro' => 'Data Cadastro',
            'status' => 'Status',
            'orientador_id' => 'Orientador',
            'convidado_primario_id' => 'Professor Convidado',
            'convidado_secundario_id' => 'Professor Convidado',
            'etapa_projeto' => 'Etapa Projeto',
            'projeto_id' => 'Projeto',
            'curso_id' => 'Curso',
        ];
    }
    
    public function getLocais(){
        return ['Sala 1' => 'Sala 1', 'Sala 2' => 'Sala 2', 'Sala 3' => 'Sala 3', 'Auditório' => 'Auditório'];
    }
    
     public function getOpcaoAprovacao(){
        return ['1' => 'Aprovado sem restrições', 
                '2' => 'Aprovado mediante confecção das alterações no trabalho, conforme solicitado pela banca',
                '3' => 'Reprovado'];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurso()
    {
        return $this->hasOne(Curso::className(), ['id' => 'curso_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjeto()
    {
        return $this->hasOne(Projeto::className(), ['id' => 'projeto_id']);
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
    public function getConvidadoSecundario()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'convidado_secundario_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConvidadoPrimario()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'convidado_primario_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAvaliacaos()
    {
        return $this->hasMany(Avaliacao::className(), ['apresentacao_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegistroAtas()
    {
        return $this->hasMany(RegistroAta::className(), ['apresentacao_id' => 'id']);
    }

                                                                                                                            }
