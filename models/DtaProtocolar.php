<?php

namespace app\models;

use app\behaviors\LoggableBehavior;

/**
 * This is the model class for table "dta_protocolar".
 *
 * @property integer $id
 * @property string $dta_inicio
 * @property string $dta_terminio
 * @property string $curso_id
 * @property string $matricula_ra
 * @property integer $etapa_projeto
 * @property string $observacao
 *
 * @property Curso $curso
 * @property Matricula $matriculaRa
 */
class DtaProtocolar extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dta_protocolar';
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
            [['dta_inicio', 'dta_termino', 'curso_id', 'etapa_projeto'], 'required'],
            [['dta_inicio', 'dta_termino'], 'safe'],
            [['dta_termino'],'compare','compareAttribute'=>'dta_inicio','operator'=>'>=','skipOnEmpty'=>true,
                'message'=>'{attribute} deve ser maior que {compareValue}'],
            [['etapa_projeto'], 'integer'],
            [['observacao'], 'string'],           
            [['curso_id'], 'string', 'max' => 4],
            [['matricula_ra'], 'string', 'max' => 14],
            ['matricula_ra', 'validacao_ra'],
    
        ];
    }
    
     public function validacao_ra($attribute){
        if(!Matricula::find()->where(['ra'=>$this->matricula_ra])->exists() && $this->matricula_ra != ""){
                 $this->addError($attribute,'RA não perminitido, pois o mesmo não existe!');
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
            'dta_inicio' => 'Data Início',
            'dta_termino' => 'Data Término',
            'curso_id' => 'Curso',
            'matricula_ra' => 'Matrícula RA',
            'etapa_projeto' => 'Etapa do Projeto',
            'observacao' => 'Observação',
        ];
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
    public function getMatriculaRa()
    {
        return $this->hasOne(Matricula::className(), ['ra' => 'matricula_ra']);
    }

                                                            }
