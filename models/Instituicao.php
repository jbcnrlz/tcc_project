<?php

namespace app\models;

use app\behaviors\LoggableBehavior;

/**
 * This is the model class for table "instituicao".
 *
 * @property string $id
 * @property string $nome
 * @property string $abreviado
 * @property string $cep
 * @property string $rua
 * @property string $numero
 * @property string $complemento
 * @property string $bairro
 * @property string $cidade
 * @property string $estado
 * @property string $telefone_principal
 * @property string $telefone_secundario
 *
 * @property Matricula[] $matriculas
 */
class instituicao extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'instituicao';
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
            [['id', 'nome', 'abreviado', 'cep', 'rua', 'numero', 'bairro', 'cidade', 'estado', 'telefone_principal'], 'required'],
            [['id'], 'string', 'max' => 4],
            [['nome'], 'string', 'max' => 255],
            [['email'], 'email'],
            [['abreviado', 'complemento', 'bairro'], 'string', 'max' => 100],
            [['cep'], 'string', 'max' => 12],
            [['rua'], 'string', 'max' => 200],
            [['numero'], 'string', 'max' => 10],
            [['cidade'], 'string', 'max' => 50],
            [['estado'], 'string', 'max' => 2],
            [['telefone_principal', 'telefone_secundario'], 'string', 'max' => 45]
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
            'abreviado' => 'Abreviado',
            'cep' => 'Cep',
            'rua' => 'Rua',
            'numero' => 'Número',
            'complemento' => 'Complemento',
            'bairro' => 'Bairro',
            'cidade' => 'Cidade',
            'estado' => 'Estado',
            'email'=> 'E-mail',
            'telefone_principal' => 'Telefone Principal',
            'telefone_secundario' => 'Telefone Secundário',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMatriculas()
    {
        return $this->hasMany(Matricula::className(), ['instituicao_id' => 'id']);
    }

                                                                                                    }
