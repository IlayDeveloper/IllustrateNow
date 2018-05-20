<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\Role;
use app\models\User;
use yii\console\Controller;
use \Yii;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class StartUpController extends Controller
{
    public $admin = [
        'login' => 'Victoriya@mail.ru',
        'name' => 'Vika',
        'password' => '123',
    ];

    public $roles = [
        '1' => 'admin',
        '2' => 'user',
    ];

    /**
     * This command echoes what you have entered as the message.
     */
    public function actionIndex()
    {
        $this->generateRoles();
        $this->generateAdmin();
    }

    public function actionClearing()
    {
        User::deleteAll();
        Role::deleteAll();
        Yii::$app->db->createCommand('ALTER TABLE `users` AUTO_INCREMENT = 1')->execute();
        Yii::$app->db->createCommand('ALTER TABLE `roles` AUTO_INCREMENT = 1')->execute();
    }

    private function generateAdmin()
    {
        if (! User::findByUsername($this->admin['login'])){
            $user = new User();
            $user->login = $this->admin['login'];
            $user->name = $this->admin['name'];
            $user->role_id = array_search('admin', $this->roles);
            $user->setPassword($this->admin['password']);
            $user->generateAuthKey();
            $user->save();
        }
    }

    private function generateRoles()
    {
        foreach ($this->roles as $name){
            if (! Role::findByName($name)){
                $role = new Role();
                $role->name = $name;
                $role->description = '';
                $role->save(false);
            }
        }
    }
}
