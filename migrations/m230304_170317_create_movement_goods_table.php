<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%movement_goods}}`.
 */
class m230304_170317_create_movement_goods_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%movement_goods}}', [
            'id' => $this->primaryKey(),
            'movement_id' => $this->integer()->notNull(),
            'goods_id' => $this->integer()->notNull(),
            'currency_id' => $this->integer()->notNull(),
            'rasxod_goods_id' => $this->integer()->notNull(),
            'amount' => $this->double(4)->notNull(),
            'cost' => $this->double(4),
            'cost_return' => $this->double(4),
            'status' => $this->integer()->defaultValue(1),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('FK_movement_movement_goods', 'movement_goods', 'movement_id',
            'movement', 'id');

        $this->createIndex('movement-movement_goods_idx', 'movement_goods', 'movement_id');

        $this->addForeignKey('FK_goods-movement_goods', 'movement_goods', 'goods_id',
            'goods', 'id');

        $this->createIndex('goods-movement_goods_idx', 'movement_goods', 'goods_id');

        $this->addForeignKey('FK_currency_movement_goods', 'movement_goods', 'currency_id',
            'currency', 'id');

        $this->createIndex('currency-movement_goods_idx', 'movement_goods', 'currency_id');

        $this->addForeignKey('FK_rasxod_goods_movement_goods', 'movement_goods', 'rasxod_goods_id',
            'rasxod_goods', 'id');

        $this->createIndex('rasxod_goods-movement_goods_idx', 'movement_goods', 'rasxod_goods_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%movement_goods}}');
    }
}
