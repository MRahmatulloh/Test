<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%payment}}`.
 */
class m230302_104741_create_payment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%payment}}', [
            'id' => $this->primaryKey(),
            'date' => $this->date()->notNull(),
            'summa' => $this->double()->notNull(),
            'summa_usd' => $this->double(4),
            'currency_id' => $this->integer()->notNull(),
            'client_id' => $this->integer()->notNull(),
            'payment_type_id' => $this->integer()->notNull(),
            'reason_id' => $this->integer()->notNull(),
            'comment' => $this->string(255),
            'created_by' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('FK_payment_client', 'payment', 'client_id',
            'client', 'id');

        $this->createIndex('payment-client_idx', 'payment', 'client_id');

        $this->addForeignKey('FK_payment_currency', 'payment', 'currency_id',
            'currency', 'id');

        $this->createIndex('payment-currency_idx', 'payment', 'currency_id');

        $this->addForeignKey('FK_payment_reason', 'payment', 'reason_id',
            'payment_reason', 'id');

        $this->createIndex('payment-reason_idx', 'payment', 'reason_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%payment}}');
    }
}
