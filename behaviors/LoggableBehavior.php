<?php
/**
 * @package    yiisoft\yii2
 * @subpackage ignitevision\yii2-auditlog
 * @author     Nikola Haralamov <nikola@ignitevision.bg>
 * @since      2.0.6
 */

namespace app\behaviors;

use app\models\AuditLog;
use DateTime;
use Yii;
use yii\base\Application;
use yii\base\Behavior;
use yii\db\BaseActiveRecord;

class LoggableBehavior extends Behavior {
 
	
        
        const ACTION_FIND = 'Procurar';
	const ACTION_INSERT = 'Cadastrar';
	const ACTION_UPDATE = 'Atualizar';
	const ACTION_DELETE = 'Excluir';

	public $ignoredAttributes = [];
	public $ignorePrimaryKey = false;
	public $ignorePrimaryKeyForActions = [];
        public $action;
       
       
	public $dateTimeFormat = 'Y-m-d H:i:s';

	private static $_oldAttributes;
	private static $_newAttributes;

	public function events() {
		return [
			BaseActiveRecord::EVENT_AFTER_FIND => 'afterFind',
			BaseActiveRecord::EVENT_AFTER_INSERT => 'afterInsert',
			BaseActiveRecord::EVENT_BEFORE_UPDATE => 'beforeUpdate',
			BaseActiveRecord::EVENT_AFTER_UPDATE => 'afterUpdate',
			BaseActiveRecord::EVENT_BEFORE_DELETE => 'beforeDelete',
		];
	}
        
        public function getAcao(){
            if(Yii::$app->session->get('logAcao')){
                $this->action = Yii::$app->session->get('logAcao');
                Yii::$app->session->destroy('logAcao');
                return true;
            }else{
                return false;
            }
        }

	public function afterFind() {
	}

	public function afterInsert() {
		$auditLog = new AuditLog;
		$dateTime = new DateTime;
		$this->setNewAttributes($this->owner->attributes);
		$newAttributes = $this->getNewAttributes();

		if ($this->ignorePrimaryKey == true && is_array($this->ignorePrimaryKeyForActions)) {

			if (empty($this->ignorePrimaryKeyForActions)) {
				if (is_array($this->owner->tableSchema->primaryKey) && array_key_exists(0, $this->owner->tableSchema->primaryKey)) {
					unset($newAttributes[$this->owner->tableSchema->primaryKey[0]]);
				}
			} elseif (in_array(self::ACTION_INSERT, $this->ignorePrimaryKeyForActions)) {
				if (is_array($this->owner->tableSchema->primaryKey) && array_key_exists(0, $this->owner->tableSchema->primaryKey)) {
					unset($newAttributes[$this->owner->tableSchema->primaryKey[0]]);
				}
			}
		}

		foreach ($this->ignoredAttributes as $ignoredAttribute)
			if (array_key_exists($ignoredAttribute, $newAttributes)) unset($newAttributes[$ignoredAttribute]);

		$classNamePath = explode('\\', $this->owner->className());
		$auditLog->model = end($classNamePath);
                $auditLog->acao = $this->getAcao() ? $this->action : self::ACTION_INSERT;
		$auditLog->antigo = null;
		$auditLog->novo = json_encode($newAttributes);
		$auditLog->ip = $this->getClientIPAddress();
		$auditLog->data = $dateTime->format($this->dateTimeFormat);
		$auditLog->user_id = $this->getUserId();

		if ($auditLog->save()) $this->normalizeNewAttributes();
	}

	public function beforeUpdate() {
		$this->normalizeOldAttributes();
		$this->setOldAttributes($this->owner->getOldAttributes());
	}

	public function afterUpdate() {
		$auditLog = new AuditLog;
		$dateTime = new DateTime;
		$oldAttributes = $this->getOldAttributes();
		$this->setNewAttributes($this->owner->attributes);
		$newAttributes = $this->getNewAttributes();

		if ($this->ignorePrimaryKey == true && is_array($this->ignorePrimaryKeyForActions)) {
			if (empty($this->ignorePrimaryKeyForActions)) {
				if (is_array($this->owner->tableSchema->primaryKey) && array_key_exists(0, $this->owner->tableSchema->primaryKey)) {
					unset($oldAttributes[$this->owner->tableSchema->primaryKey[0]]);
					unset($newAttributes[$this->owner->tableSchema->primaryKey[0]]);
				}
			} elseif (in_array(self::ACTION_UPDATE, $this->ignorePrimaryKeyForActions)) {
				if (is_array($this->owner->tableSchema->primaryKey) && array_key_exists(0, $this->owner->tableSchema->primaryKey)) {
					unset($oldAttributes[$this->owner->tableSchema->primaryKey[0]]);
					unset($newAttributes[$this->owner->tableSchema->primaryKey[0]]);
				}
			}
		}

		foreach ($this->ignoredAttributes as $ignoredAttribute) {
			if (array_key_exists($ignoredAttribute, $oldAttributes)) unset($oldAttributes[$ignoredAttribute]);
			if (array_key_exists($ignoredAttribute, $newAttributes)) unset($newAttributes[$ignoredAttribute]);
		}

		$classNamePath = explode('\\', $this->owner->className());
		$auditLog->model = end($classNamePath);
                $auditLog->acao = $this->getAcao() ? $this->action : self::ACTION_UPDATE;
                $auditLog->antigo = json_encode($oldAttributes);
		$auditLog->novo = json_encode($newAttributes);
		$auditLog->ip = $this->getClientIPAddress();
		$auditLog->data = $dateTime->format($this->dateTimeFormat);
		$auditLog->user_id = $this->getUserId();

		if ($auditLog->save()) {
			$this->normalizeNewAttributes();
			$this->normalizeOldAttributes();
		}
	}

	public function beforeDelete() {
		$auditLog = new AuditLog;
		$dateTime = new DateTime;
		$this->setOldAttributes($this->owner->attributes);
		$oldAttributes = $this->getOldAttributes();
                $newAttributes = $this->getNewAttributes();

		if ($this->ignorePrimaryKey == true && is_array($this->ignorePrimaryKeyForActions)) {
			if (empty($this->ignorePrimaryKeyForActions)) {
				if (is_array($this->owner->tableSchema->primaryKey) && array_key_exists(0, $this->owner->tableSchema->primaryKey)) {
					unset($newAttributes[$this->owner->tableSchema->primaryKey[0]]);
				}
			} elseif (in_array(self::ACTION_DELETE, $this->ignorePrimaryKeyForActions)) {
				if (is_array($this->owner->tableSchema->primaryKey) && array_key_exists(0, $this->owner->tableSchema->primaryKey)) {
					unset($newAttributes[$this->owner->tableSchema->primaryKey[0]]);
				}
			}
		}

		foreach ($this->ignoredAttributes as $ignoredAttribute)
			if (array_key_exists($ignoredAttribute, $oldAttributes)) unset($oldAttributes[$ignoredAttribute]);

		$classNamePath = explode('\\', $this->owner->className());
		$auditLog->model = end($classNamePath);
                $auditLog->acao = $this->getAcao() ? $this->action : self::ACTION_DELETE;
                $auditLog->antigo = json_encode($oldAttributes);
		$auditLog->novo = null;
		$auditLog->ip = $this->getClientIPAddress();
		$auditLog->data = $dateTime->format($this->dateTimeFormat);
		$auditLog->user_id = $this->getUserId();

		if ($auditLog->save()) $this->normalizeOldAttributes();
	}

	public function getClientIPAddress() {
		$ipAddress = null;
		if (isset($_SERVER['HTTP_CLIENT_IP'])) $ipAddress = $_SERVER['HTTP_CLIENT_IP'];
		elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) $ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		elseif (isset($_SERVER['HTTP_X_FORWARDED'])) $ipAddress = $_SERVER['HTTP_X_FORWARDED'];
		elseif (isset($_SERVER['HTTP_FORWARDED_FOR'])) $ipAddress = $_SERVER['HTTP_FORWARDED_FOR'];
		elseif (isset($_SERVER['HTTP_FORWARDED'])) $ipAddress = $_SERVER['HTTP_FORWARDED'];
		elseif (isset($_SERVER['REMOTE_ADDR'])) $ipAddress = $_SERVER['REMOTE_ADDR'];
		return $ipAddress;
	}

	public function getUserId() {
		return (Yii::$app instanceof Application && Yii::$app->user) ? Yii::$app->user->id : null;
	}

	public function getNewAttributes() {
		return self::$_newAttributes;
	}

	public function setNewAttributes($attributes) {
		self::$_newAttributes = $attributes;
	}

	public function normalizeNewAttributes() {
		self::$_newAttributes = null;
	}

	public function getOldAttributes() {
		return self::$_oldAttributes;
	}

	public function setOldAttributes($attributes) {
		self::$_oldAttributes = $attributes;
	}

	public function normalizeOldAttributes() {
		self::$_oldAttributes = null;
	}
}