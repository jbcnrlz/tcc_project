<?php

namespace app\models;
use app\behaviors\LoggableBehavior;

/**
 * This is the model class for table "curso".
 *
 * @property string $id
 * @property string $nome
 * @property string $nome_abreviado
 *
 * @property CalendarioAcademico[] $calendarioAcademicos
 * @property CursoRecado[] $cursoRecados
 * @property DtaProtocolar[] $dtaProtocolars
 * @property Matricula[] $matriculas
 */
class Curso extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'curso';
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
            [['id', 'nome','coordenador', 'nome_abreviado'], 'required'],
            [['id'], 'number'],
            [['nome'], 'string', 'max' => 100],
            [['nome_abreviado'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Código',
            'nome' => 'Nome',
            'coordenador'=>'Coordenador(a)',
            'nome_abreviado' => 'Abreviado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalendarioAcademicos()
    {
        return $this->hasMany(CalendarioAcademico::className(), ['curso_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCursoRecados()
    {
        return $this->hasMany(CursoRecado::className(), ['curso_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDtaProtocolars()
    {
        return $this->hasMany(DtaProtocolar::className(), ['curso_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMatriculas()
    {
        return $this->hasMany(Matricula::className(), ['curso_id' => 'id']);
    }

                            }
