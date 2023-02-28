<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%prixod}}`.
 */
class m230226_183209_create_prixod_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%prixod}}', [
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

        $this->addForeignKey('FK_prixod_client', 'prixod', 'client_id',
            'client', 'id');

        $this->createIndex('prixod-client_idx', 'prixod', 'client_id');

        $this->addForeignKey('FK_prixod_warehouse', 'prixod', 'warehouse_id',
            'warehouse', 'id');

        $this->createIndex('prixod-warehouse_idx', 'prixod', 'warehouse_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%prixod}}');
    }
}
