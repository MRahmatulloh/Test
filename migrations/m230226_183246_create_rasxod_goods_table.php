<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%rasxod_goods}}`.
 */
class m230226_183246_create_rasxod_goods_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%rasxod_goods}}', [
            'id' => $this->primaryKey(),
            'rasxod_id' => $this->integer()->notNull(),
            'goods_id' => $this->integer()->notNull(),
            'currency_id' => $this->integer()->notNull(),
            'prixod_goods_id' => $this->integer()->notNull(),
            'amount' => $this->double(4)->notNull(),
            'cost' => $this->double(4),
            'cost_usd' => $this->double(4),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('FK_rasxod_rasxod_goods', 'rasxod_goods', 'rasxod_id',
            'rasxod', 'id');

        $this->createIndex('rasxod-rasxod_goods_idx', 'rasxod_goods', 'rasxod_id');

        $this->addForeignKey('FK_goods_rasxod_goods', 'rasxod_goods', 'goods_id',
            'goods', 'id');

        $this->createIndex('goods-rasxod_goods_idx', 'rasxod_goods', 'goods_id');

        $this->addForeignKey('FK_currency_rasxod_goods', 'rasxod_goods', 'currency_id',
            'currency', 'id');

        $this->createIndex('currency-rasxod_goods_idx', 'rasxod_goods', 'currency_id');

        $this->addForeignKey('FK_prixod_goods_rasxod_goods', 'rasxod_goods', 'prixod_goods_id',
            'prixod_goods', 'id');

        $this->createIndex('prixod_goods-rasxod_goods_idx', 'rasxod_goods', 'prixod_goods_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%rasxod_goods}}');
    }
}
