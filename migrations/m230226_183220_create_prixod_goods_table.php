<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%prixod_goods}}`.
 */
class m230226_183220_create_prixod_goods_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%prixod_goods}}', [
            'id' => $this->primaryKey(),
            'prixod_id' => $this->integer()->notNull(),
            'goods_id' => $this->integer()->notNull(),
            'currency_id' => $this->integer()->notNull(),
            'amount' => $this->double(4)->notNull(),
            'cost' => $this->double(4),
            'cost_usd' => $this->double(4),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('FK_prixod_prixod_goods', 'prixod_goods', 'prixod_id',
            'prixod', 'id');

        $this->createIndex('prixod-prixod_goods_idx', 'prixod_goods', 'prixod_id');

        $this->addForeignKey('FK_goods_prixod_goods', 'prixod_goods', 'goods_id',
            'goods', 'id');

        $this->createIndex('goods-prixod_goods_idx', 'prixod_goods', 'goods_id');

        $this->addForeignKey('FK_currency_prixod_goods', 'prixod_goods', 'currency_id',
            'currency', 'id');

        $this->createIndex('currency-prixod_goods_idx', 'prixod_goods', 'currency_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%prixod_goods}}');
    }
}
