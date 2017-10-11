<?php

namespace app\models;

use app\behaviors\LoggableBehavior;

/**
 * This is the model class for table "configuracao_app".
 *
 * @property integer $id
 * @property string $descricao
 * @property string $nome
 * @property string $valor
 */
class ConfiguracaoApp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'configuracao';
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
            [['nome'], 'required'],
            [['valor'], 'string'],
            [['descricao'], 'string', 'max' => 80],
            [['nome'], 'string', 'max' => 45],
            [['nome'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'descricao' => 'Descrição',
            'nome' => 'Nome',
            'valor' => 'Valor',
        ];
    }

                                    }
