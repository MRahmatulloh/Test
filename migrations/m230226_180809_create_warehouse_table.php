<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%warehouse}}`.
 */
class m230226_180809_create_warehouse_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%warehouse}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull()->unique(),
            'address' => $this->string(255),
            'status' => $this->integer()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->insert('{{%warehouse}}', [
            'name' => 'Warehouse Test',
            'address' => 'Warehouse address',
            'created_at' => time(),
            'updated_at' => time(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%warehouse}}');
    }
}
