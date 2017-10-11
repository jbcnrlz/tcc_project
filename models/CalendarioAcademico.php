<?php

namespace app\models;

use app\behaviors\LoggableBehavior;

/**
 * This is the model class for table "calendario_academico".
 *
 * @property integer $id
 * @property string $title
 * @property string $body
 * @property string $footer
 * @property integer $badge
 * @property string $date
 * @property string $classname
 * @property integer $ocorrencias
 * @property string $curso_id
 *
 * @property Curso $curso
 */
class CalendarioAcademico extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    
    public $eventos;
    public $recorrencias;
    
    public static function tableName()
    {
        return 'calendario_academico';
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
            [['body'], 'string'],
            [['badge', 'recorrencias'], 'integer'],
            [['date', 'curso_id'], 'required'],
            [['date'], 'safe'],
            [['title'], 'string', 'max' => 80],
            [['footer'], 'string', 'max' => 200],
            [['classname'], 'string', 'max' => 20],
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
            'title' => 'Título',
            'body' => 'Mensagem',
            'footer' => 'Rodapé',
            'badge' => 'Importante',
            'date' => 'Data',
            'classname' => 'Legenda',
            'recorrencias' => 'Recorrências',
            'curso_id' => 'Curso',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurso()
    {
        return $this->hasOne(Curso::className(), ['id' => 'curso_id']);
    }

                                                                            }
