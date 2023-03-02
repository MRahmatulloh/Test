<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%expense}}`.
 */
class m230302_104749_create_expense_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%expense}}', [
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

        $this->addForeignKey('FK_expense_client', 'expense', 'client_id',
            'client', 'id');

        $this->createIndex('expense-client_idx', 'expense', 'client_id');

        $this->addForeignKey('FK_expense_currency', 'expense', 'currency_id',
            'currency', 'id');

        $this->createIndex('expense-currency_idx', 'expense', 'currency_id');

        $this->addForeignKey('FK_expense_reason', 'expense', 'reason_id',
            'payment_reason', 'id');

        $this->createIndex('expense-reason_idx', 'expense', 'reason_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%expense}}');
    }
}
