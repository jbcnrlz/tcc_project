<?php
/**
 * @package    yiisoft\yii2
 * @subpackage ignitevision\yii2-auditlog
 * @author     Nikola Haralamov <nikola@ignitevision.bg>
 * @since      2.0.6
 */

use yii\db\Migration;

class m150813_090217_create_auditlog_table extends Migration {

	CONST TABLE_NAME = 'auditlog';

	public function up() {
		$this->createTable(self::TABLE_NAME, [
			'id' => $this->primaryKey(),
			'model' => $this->string()->notNull(),
			'action' => $this->string()->notNull(),
			'old' => $this->text(),
			'new' => $this->text(),
			'ip' => $this->string(),
			'at' => $this->datetime(),
			'by' => $this->integer(),
		]);
	}

	public function down() {
		$this->dropTable(self::TABLE_NAME);
	}

	public function safeUp() {
		$this->up();
	}

	public function safeDown() {
		$this->down();
	}
}
