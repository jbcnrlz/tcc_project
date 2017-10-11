<?php

namespace app\models;

use app\behaviors\LoggableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "mensagem".
 *
 * @property integer $id
 * @property integer $destinatario_id
 * @property integer $remetente_id
 * @property integer $projeto_id
 * @property string $assunto
 * @property string $mensagem
 * @property integer $prioridade
 * @property integer $lido
 * @property integer $status
 * @property string $dta_cadastro
 * @property string $dta_atualizacao
 *
 * @property Projeto $projeto
 * @property Usuario $destinatario
 * @property Usuario $remetente
 */
class Mensagem extends \yii\db\ActiveRecord
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
        return 'mensagem';
    }
    
  

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['destinatario_id', 'remetente_id', 'assunto', 'mensagem'], 'required'],
            [['destinatario_id', 'remetente_id',  'prioridade', 'lido', 'status'], 'integer'],
            [['mensagem'], 'string'],
            [['dta_cadastro', 'dta_atualizacao'], 'safe'],
            [['assunto'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'destinatario_id' => 'Para',
            'remetente_id' => 'De',
           'assunto' => 'Assunto',
            'mensagem' => 'Mensagem',
            'prioridade' => 'Prioridade',
            'lido' => 'Lido',
            'status' => 'Status',
            'dta_cadastro' => 'Cadastro',
            'dta_atualizacao' => 'Data',
        ];
    }

   
   
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDestinatario()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'destinatario_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRemetente()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'remetente_id']);
    }

                                                                                            }
