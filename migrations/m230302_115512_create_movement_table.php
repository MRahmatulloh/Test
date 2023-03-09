<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%movement}}`.
 */
class m230302_115512_create_movement_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%movement}}', [
            'id' => $this->primaryKey(),
            'date' => $this->date()->notNull(),
            'number' => $this->string(255)->notNull(),
            'sender_id' => $this->integer()->notNull(),
            'recipient_id' => $this->integer()->notNull(),
            'prixod_id' => $this->integer()->null(),
            'rasxod_id' => $this->integer()->null(),
            'status' => $this->integer()->defaultValue(1),
            'warehouse_id' => $this->integer()->notNull(),
            'comment' => $this->string(255),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('FK_movement_sender', 'movement', 'sender_id',
            'client', 'id');

        $this->createIndex('movement-sender_idx', 'movement', 'sender_id');

        $this->addForeignKey('FK_movement_recipient', 'movement', 'recipient_id',
            'client', 'id');

        $this->createIndex('movement-recipient_idx', 'movement', 'recipient_id');

        $this->addForeignKey('FK_movement_prixod', 'movement', 'prixod_id',
            'prixod', 'id');

        $this->createIndex('movement-prixod_idx', 'movement', 'prixod_id');

        $this->addForeignKey('FK_movement_rasxod', 'movement', 'rasxod_id',
            'rasxod', 'id');

        $this->createIndex('movement-rasxod_idx', 'movement', 'rasxod_id');

        $this->addForeignKey('FK_movement_warehouse', 'movement', 'warehouse_id',
            'warehouse', 'id');

        $this->createIndex('movement-warehouse_idx', 'movement', 'warehouse_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%movement}}');
    }
}
