<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%currency_rates}}`.
 */
class m230226_181600_create_currency_rates_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%currency_rates}}', [
            'id' => $this->primaryKey(),
            'code' => $this->integer()->notNull(),
            'rate' => $this->double(4)->notNull(),
            'date' => $this->date()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%currency_rates}}');
    }
}
