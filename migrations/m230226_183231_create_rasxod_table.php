<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%rasxod}}`.
 */
class m230226_183231_create_rasxod_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%rasxod}}', [
            'id' => $this->primaryKey(),
            'date' => $this->date()->notNull(),
            'number' => $this->string(255)->notNull(),
            'client_id' => $this->integer()->notNull(),
            'warehouse_id' => $this->integer()->notNull(),
            'comment' => $this->string(255),
            'type' => $this->integer()->notNull(),
            'status' => $this->integer()->defaultValue(1),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('FK_rasxod_client', 'rasxod', 'client_id',
            'client', 'id');

        $this->createIndex('rasxod-client_idx', 'rasxod', 'client_id');

        $this->addForeignKey('FK_rasxod_warehouse', 'rasxod', 'warehouse_id',
            'warehouse', 'id');

        $this->createIndex('rasxod-warehouse_idx', 'rasxod', 'warehouse_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%rasxod}}');
    }
}
