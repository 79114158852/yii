<?php

use yii\db\Schema;
use yii\db\Migration;

class m230211_162148_products extends Migration
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
            '{{%products}}',
            [
                'id'=> Schema::TYPE_PK,
                'name'=> Schema::TYPE_STRING."(255) NOT NULL",
            ],$tableOptions
        );
        $this->createIndex('name','{{%products}}',['name'],true);

    }

    public function safeDown()
    {
        $this->dropIndex('name', '{{%products}}');
        $this->dropTable('{{%products}}');
    }
}
