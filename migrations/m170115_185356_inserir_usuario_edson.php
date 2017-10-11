<?php

use yii\db\Migration;

class m170115_185356_inserir_usuario_edson extends Migration
{
    public function up()
    {
        $date = new DateTime();
        $this->insert('{{%usuario}}',array(
            'username' => "edsonrb2008",
            'auth_key' => "ZrktnGOuj1RTRsT0SzH9uvROFTa8MHng",
            'password_hash' => '$2y$13$w7TLWSTWWR5yE08Q4R0V4ur3WS1mx.VpfU/fHfsKBLHFwkNEv6Xqi',
            'password_reset_token' => "",
            'email' => "edsonrb.2008@gmail.com",
            'status' => 10,
            'dta_cadastro' => $date->getTimestamp(),
            'dta_cadastro' => $date->getTimestamp(),
        ));
    }

    public function down()
    {
        echo "m170115_185356_inserir_usuario_edson cannot be reverted.\n";

        return false;
    }

}
