<?php

use yii\db\Schema;
use yii\db\Migration;

class m230211_162149_Relations extends Migration
{

    public function init()
    {
       $this->db = 'db';
       parent::init();
    }

    public function safeUp()
    {
        $this->addForeignKey('fk_history_order_id',
            '{{%history}}','order_id',
            '{{%orders}}','id',
            'CASCADE','CASCADE'
         );
        $this->addForeignKey('fk_history_user_id',
            '{{%history}}','user_id',
            '{{%users}}','id',
            'CASCADE','CASCADE'
         );
        $this->addForeignKey('fk_orders_status_id',
            '{{%orders}}','status_id',
            '{{%order_status}}','id',
            'CASCADE','CASCADE'
         );
        $this->addForeignKey('fk_orders_product_id',
            '{{%orders}}','product_id',
            '{{%products}}','id',
            'CASCADE','CASCADE'
         );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_history_order_id', '{{%history}}');
        $this->dropForeignKey('fk_history_user_id', '{{%history}}');
        $this->dropForeignKey('fk_orders_status_id', '{{%orders}}');
        $this->dropForeignKey('fk_orders_product_id', '{{%orders}}');
    }
}
