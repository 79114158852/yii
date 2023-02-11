<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
/**
 * Инициализатор RBAC выполняется в консоли php yii my-rbac/init
 */
class RbacController extends Controller {

    public function actionInit() {

        $auth = Yii::$app->authManager;
        
        $auth->removeAll();
        
        $admin = $auth->createRole('admin');

        $manager = $auth->createRole('manager');
            
        $auth->add($admin);

        $auth->add($manager);
        
        $users = $auth->createPermission('users');

        $users->description = 'Пользователи';
        
        $orders = $auth->createPermission('orders');

        $orders->description = 'Заказы';

        $auth->add($users);

        $auth->add($orders);
        
        $auth->addChild($manager,$orders);

        $auth->addChild($admin, $manager);
        
        $auth->addChild($admin, $users);

        $auth->assign($admin, 1); 
        
        $auth->assign($manager, 2);
    }
}