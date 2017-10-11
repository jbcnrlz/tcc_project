<?php

namespace app\models;

use app\behaviors\LoggableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "mural_recados".
 *
 * @property integer $id
 * @property string $titulo
 * @property string $recado
 * @property integer $status
 * @property string $departamento
 * @property string $dta_cadastro
 * @property string $dta_termino_visualizacao
 * @property string $dta_notificacao
 * @property string $curso_id
 *
 * @property Curso $curso
 */
class MuralRecados extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mural_recados';
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
            [['titulo', 'recado', 'status', 'departamento', 'termo', 'dta_termino_visualizacao', 'dta_notificacao', 'curso_id'], 'required'],
            [['recado'], 'string'],
            [['status','termo', 'usuario_id'], 'integer'],
            [['dta_cadastro', 'dta_termino_visualizacao', 'dta_notificacao'], 'safe'],
            [['titulo'], 'string', 'max' => 100],
            [['departamento'], 'string', 'max' => 30],
            [['curso_id'], 'string', 'max' => 4]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'titulo' => 'Título',
            'termo'=>'Termo',
            'recado' => 'Recado',
            'status' => 'Status',
            'departamento' => 'Departamento',
            'dta_cadastro' => 'Dta Cadastro',
            'dta_termino_visualizacao' => 'Término',
            'dta_notificacao' => 'Notificação',
            'curso_id' => 'Curso',
            'usuario_id' => 'Cadastrado Por',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurso()
    {
        return $this->hasOne(Curso::className(), ['id' => 'curso_id']);
    }
    
    public function getUsuario(){
        return $this->hasOne(Usuario::className(),['id'=>'usuario_id']);
    }

                                                                            }
