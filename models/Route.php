<?php

namespace app\models;
use app\behaviors\LoggableBehavior;

/**
 * This is the model class for table "route".
 *
 * @property string $name
 * @property string $alias
 * @property string $type
 */
class Route extends \yii\db\ActiveRecord
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
			[['name', 'alias'], 'required'],
			[['name', 'alias', 'type'], 'string', 'max' => 64],
			[['status','ordem'], 'integer'],
                    
                
		];
	}

     
        /**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'name' => 'Rotas',
			'alias' => 'Descrição',
			'type' => 'Seção',
                        'rule_name' => 'Regras',
			'status' => 'Status',
                    
		];
	}
}
