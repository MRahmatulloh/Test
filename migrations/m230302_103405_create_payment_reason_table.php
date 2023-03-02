<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%payment_reason}}`.
 */
class m230302_103405_create_payment_reason_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%payment_reason}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255),
            'type_id' => $this->integer()->notNull(),
            'created_by' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%payment_reason}}');
    }
}
