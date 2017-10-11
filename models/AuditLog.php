<?php


namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "auditlog".
 *
 * @property integer $id
 * @property string $model
 * @property string $acao
 * @property string $antigo
 * @property string $novo
 * @property string $ip
 * @property string $data
 * @property string $user_id
 */
class AuditLog extends ActiveRecord {

	public static function tableName() {
		return 'auditlog';
	}

	public function rules() {
		return [
			[['model', 'acao'], 'required'],
			[['antigo', 'novo', 'ip'], 'string'],
			[['data', 'user_id'], 'safe'],
			[['model', 'acao', 'ip'], 'string', 'max' => 255],
		];
	}

	public function attributeLabels() {
		return [
			'id' => 'Identificação',
			'model' => 'Model',
			'acao' => 'Ação',
			'antigo' => 'Cadastro Antigo',
			'novo' => 'Cadastrado',
			'ip' => 'Endereço IP',
			'data' => 'Data',
			'user_id' => 'Responsável',
		];
	}
        
        public function getUser() 
            { 
                return $this->hasOne(Usuario::className(), ['id' => 'user_id']);
            } 
        
       
}
