<?php

namespace app\models;

use app\behaviors\LoggableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "protocolos".
 *
 * @property integer $id
 * @property integer $numero
 * @property integer $ano
 * @property string $descricao
 * @property integer $projeto_id
 * @property string $dta_protocolo
 * @property string $dta_cadastro
 * @property string $dta_atualizacao
 *
 * @property Projeto $projeto
 */
class Protocolos extends \yii\db\ActiveRecord
{
    
 
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
    public static function tableName()
    {
        return 'protocolos';
    }
    
  

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['numero', 'ano', 'descricao', 'projeto_id', 'dta_protocolo'], 'required'],
            [['numero', 'ano', 'projeto_id', 'classificacao'], 'integer'],
            [['dta_protocolo', 'dta_cadastro', 'dta_atualizacao'], 'safe'],
            [['descricao'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'numero' => 'Número',
            'ano' => 'Ano',
            'classificacao' => 'Classificação',
            'descricao' => 'Descrição',
            'projeto_id' => 'Projeto',
            'dta_protocolo' => 'Data do Protocolo',
            'dta_cadastro' => 'Data Cadastro',
            'dta_atualizacao' => 'Data Atualização',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjeto()
    {
        return $this->hasOne(Projeto::className(), ['id' => 'projeto_id']);
    }

    public function getClassificacoes(){
        return [
            '1' => 'Vínculo com Orientador', 
            '2' => 'Projeto de Qualificação', 
            '3' => 'Projeto de Defesa', 
            '4' => 'Ata de Defesa',
         ];
    }
   
    }
