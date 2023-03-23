<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%pricelist}}`.
 */
class m230323_094727_create_pricelist_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%pricelist}}', [
            'id' => $this->primaryKey(),
            'date' => $this->date()->notNull(),
            'goods_id' => $this->integer()->notNull(),
            'price_credit' => $this->decimal(10,2)->notNull(),
            'price_full' => $this->decimal(10,2)->notNull(),
            'price_transfer' => $this->decimal(10,2)->notNull(),
            'created_at' => $this->integer()->null(),
            'updated_at' => $this->integer()->null(),
            'created_by' => $this->integer()->null(),
            'updated_by' => $this->integer()->null()
        ]);
        
        $this->createIndex('idx-pricelist-goods_id', '{{%pricelist}}', ['goods_id']);
        $this->addForeignKey('fk-pricelist-goods_id', '{{%pricelist}}', ['goods_id'], '{{%goods}}', ['id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%pricelist}}');
    }
}
