<?php

use yii\db\Schema;
use yii\db\Migration;

class m230211_162146_order_status extends Migration
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
            '{{%order_status}}',
            [
                'id'=> Schema::TYPE_PK,
                'name'=> Schema::TYPE_STRING."(255) NOT NULL",
            ],$tableOptions
        );
        $this->createIndex('name','{{%order_status}}',['name'],true);

    }

    public function safeDown()
    {
        $this->dropIndex('name', '{{%order_status}}');
        $this->dropTable('{{%order_status}}');
    }
}
