<?php

use yii\db\Schema;
use yii\db\Migration;

class m230211_162144_history extends Migration
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
            '{{%history}}',
            [
                'id'=> Schema::TYPE_PK,
                'order_id'=> Schema::TYPE_INTEGER." NOT NULL",
                'user_id'=> Schema::TYPE_INTEGER." NOT NULL",
                'action'=> Schema::TYPE_TEXT." NOT NULL",
                'date'=> Schema::TYPE_DATETIME." NOT NULL DEFAULT CURRENT_TIMESTAMP",
            ],$tableOptions
        );
        $this->createIndex('order_id','{{%history}}',['order_id'],false);
        $this->createIndex('user_id','{{%history}}',['user_id'],false);

    }

    public function safeDown()
    {
        $this->dropIndex('order_id', '{{%history}}');
        $this->dropIndex('user_id', '{{%history}}');
        $this->dropTable('{{%history}}');
    }
}
