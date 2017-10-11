<?php

namespace app\models;

use app\behaviors\LoggableBehavior;

/**
 * This is the model class for table "avaliacao".
 *
 * @property integer $id
 * @property integer $num_questao
 * @property string $orientador_nota
 * @property string $convidado_primario_nota
 * @property string $convidado_secundario_nota
 * @property integer $apresentacao_id
 *
 * @property Apresentacao $apresentacao
 */
class Avaliacao extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'avaliacao';
    }
    
    public function behaviors()
    {
       
        return [
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
            [['num_questao', 'apresentacao_id'], 'required'],
            [['orientador_nota', 'convidado_primario_nota', 'convidado_secundario_nota'], 'required','on'=>'avaliarEtapa3','message'=>'Nota não pode ficar em branco'],
            [['orientador_nota', 'convidado_primario_nota'], 'required', 'on'=>'avaliarEtapa2','message'=>'Nota não pode ficar em branco'],
            [['id', 'num_questao', 'apresentacao_id'], 'integer'],
            [['orientador_nota', 'convidado_primario_nota', 'convidado_secundario_nota'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'num_questao' => 'Num Questao',
            'orientador_nota' => 'Orientador Nota',
            'convidado_primario_nota' => 'Convidado Primario Nota',
            'convidado_secundario_nota' => 'Convidado Secundario Nota',
            'apresentacao_id' => 'Apresentacao ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApresentacao()
    {
        return $this->hasOne(Apresentacao::className(), ['id' => 'apresentacao_id']);
    }

                                                            }
