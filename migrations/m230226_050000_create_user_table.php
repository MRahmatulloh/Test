<?php

use yii\db\Migration;
use mdm\admin\components\Configs;

class m230226_050000_create_user_table extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $userTable = Configs::instance()->userTable;
        $db = Configs::userDb();

        // Check if the table exists
        if ($db->schema->getTableSchema($userTable, true) === null) {
            $this->createTable($userTable, [
                'id' => $this->primaryKey(),
                'username' => $this->string(32)->notNull(),
                'warehouse_id' => $this->integer()->defaultValue(null),
                'fio' => $this->string(255),
                'auth_key' => $this->string(32)->notNull(),
                'password_hash' => $this->string()->notNull(),
                'password_reset_token' => $this->string(),
                'email' => $this->string(100)->defaultValue(null),
                'status' => $this->integer()->defaultValue(10),
                'created_at' => $this->integer()->notNull(),
                'updated_at' => $this->integer()->notNull(),
                ], $tableOptions);

            $this->insert(\app\models\User::tableName(), [
                'username' => 'admin',
                'warehouse_id' => null,
                'fio' => 'Admin Adminbekov',
                'auth_key' => 'HQCX5LwhWLXhNfpdEHOHnnXW0JW8_492',
                'password_hash' => '$2y$13$rR0huvHXZmW6U9TNjiz83eSgaiJFFPSDnJeVjq1suTam5tjc43wBu',
                'password_reset_token' => null,
                'email' => 'admin@test.corp',
                'status' => 10,
                'created_at' => time(),
                'updated_at' => time(),
            ]);
        }
    }

    public function down()
    {
        $userTable = Configs::instance()->userTable;
        $db = Configs::userDb();
        if ($db->schema->getTableSchema($userTable, true) !== null) {
            $this->dropTable($userTable);
        }
    }
}
