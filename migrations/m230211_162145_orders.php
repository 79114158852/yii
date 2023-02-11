<?php

use yii\db\Schema;
use yii\db\Migration;

class m230211_162145_orders extends Migration
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
            '{{%orders}}',
            [
                'id'=> Schema::TYPE_PK,
                'customer'=> Schema::TYPE_STRING."(255) NOT NULL",
                'title'=> Schema::TYPE_TEXT." NULL DEFAULT NULL",
                'product_id'=> Schema::TYPE_INTEGER." NOT NULL",
                'phone'=> Schema::TYPE_STRING."(15) NOT NULL",
                'status_id'=> Schema::TYPE_INTEGER." NULL DEFAULT NULL",
                'price'=> Schema::TYPE_DOUBLE."(15, 2) NOT NULL DEFAULT 0",
                'description'=> Schema::TYPE_TEXT." NULL DEFAULT NULL",
                'created_at'=> Schema::TYPE_DATETIME." NOT NULL DEFAULT CURRENT_TIMESTAMP",
            ],$tableOptions
        );
        $this->createIndex('status_id','{{%orders}}',['status_id'],false);
        $this->createIndex('product_id','{{%orders}}',['product_id'],false);

    }

    public function safeDown()
    {
        $this->dropIndex('status_id', '{{%orders}}');
        $this->dropIndex('product_id', '{{%orders}}');
        $this->dropTable('{{%orders}}');
    }
}
