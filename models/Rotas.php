<?php

namespace app\models;

use app\behaviors\LoggableBehavior;

/**
 * This is the model class for table "rotas".
 *
 * @property string $name
 * @property string $alias
 * @property string $type
 * @property integer $status
 * @property integer $ordem
 */
class Rotas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rotas';
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
            [['name', 'alias', 'type'], 'required'],
            [['status', 'ordem'], 'integer'],
            [['name', 'alias', 'type'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'alias' => 'Alias',
            'type' => 'Type',
            'status' => 'Status',
            'ordem' => 'Ordem',
        ];
    }

                                            }
