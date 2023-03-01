<?php

use yii\db\Migration;

/**
 * Class m230226_145408_rbac_init_admin
 */
class m230226_145408_rbac_init_admin extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $admin_role = Yii::$app->authManager->createRole('Administrator');
        $admin_role->description = 'Role for system administrators';
        Yii::$app->authManager->add($admin_role);

        $admin_permit = Yii::$app->authManager->createPermission('Administrator permission');
        $admin_permit->description = 'Permission for system administrators';
        Yii::$app->authManager->add($admin_permit);

        $all_route = Yii::$app->authManager->createPermission('/*');
        $all_route->description = 'Permission to all routes';
        Yii::$app->authManager->add($all_route);

        Yii::$app->authManager->addChild($admin_permit, $all_route);
        Yii::$app->authManager->addChild($admin_role, $admin_permit);

        Yii::$app->authManager->assign($admin_role, 1);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        Yii::$app->authManager->removeAll();
    }
}
