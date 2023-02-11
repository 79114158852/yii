<?php

use yii\db\Schema;
use yii\db\Migration;

class m230211_162147_users extends Migration
{

    public function init()
    {
        $this->db = 'db';
        parent::init();
    }

    public function safeUp()
    {
        $tableOptions = 'ENGINE=InnoDB';

        $this->createTable(
            '{{%users}}',
            [
                'id'=> Schema::TYPE_PK,
                'role'=> Schema::TYPE_STRING."(10) NULL DEFAULT NULL",
                'email'=> Schema::TYPE_STRING."(255) NOT NULL",
                'password'=> Schema::TYPE_STRING."(255) NOT NULL",
                'auth_key'=> Schema::TYPE_CHAR."(32) NULL DEFAULT NULL",
                'username'=> Schema::TYPE_STRING."(255) NOT NULL",
                'active'=> Schema::TYPE_TINYINT."(1) NOT NULL DEFAULT 1",
                'created_at'=> Schema::TYPE_DATETIME." NOT NULL DEFAULT CURRENT_TIMESTAMP",
                'updated_at'=> Schema::TYPE_DATETIME." NULL DEFAULT NULL",
            ],$tableOptions
        );
        $this->createIndex('email','{{%users}}',['email'],true);

    }

    public function safeDown()
    {
        $this->dropIndex('email', '{{%users}}');
        $this->dropTable('{{%users}}');
    }
}
