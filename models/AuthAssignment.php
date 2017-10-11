<?php

namespace app\models;
use app\behaviors\LoggableBehavior;

/**
 * This is the model class for table "auth_assignment".
 *
 * @property string $item_name
 * @property string $user_id
 * @property integer $created_at
 *
 * @property AuthItem $itemName
 */
class AuthAssignment extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
    
         public function behaviors()
	{
		return [
                    [
                        'class' => LoggableBehavior::className(),
                    ],
		];
	}
        
        
	public static function tableName()
	{
		return 'autorizacao_atribuicoes';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['item_name', 'user_id'], 'required'],
			[['created_at'], 'integer'],
			//[['item_name', 'user_id'], 'string', 'max' => 64]
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'item_name' => 'Permissão',
			'user_id' => 'Usuário',
			'created_at' => 'Data Cadastro',
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getItemName()
	{
		return $this->hasOne(AuthItem::className(), ['name' => 'item_name']);
	}
}
