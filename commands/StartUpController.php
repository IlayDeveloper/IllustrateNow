<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\Post;
use app\models\Role;
use app\models\User;
use Faker\Factory;
use Faker\Generator;
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
     * @var Generator
     */
    private $faker;

    /**
     * This command echoes what you have entered as the message.
     */
    public function actionIndex()
    {
        $this->faker = (new Factory())->create();
        $this->generateRoles();
        $this->generateAdmin();
//        $this->generatePosts();
    }

    public function actionClearing()
    {
//        User::deleteAll();
        Role::deleteAll();
        Post::deleteAll();
//        Yii::$app->db->createCommand('ALTER TABLE `users` AUTO_INCREMENT = 1')->execute();
        Yii::$app->db->createCommand('ALTER TABLE `roles` AUTO_INCREMENT = 1')->execute();
        Yii::$app->db->createCommand('ALTER TABLE `posts` AUTO_INCREMENT = 1')->execute();
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

    private function generatePosts($amount = 10)
    {
        for($i=0; $i < $amount; $i++){
            $post = new Post();
            $post->title = $this->faker->sentence(20);
            $post->short_title = $this->faker->sentence(3);
            $post->description = $this->faker->sentence(25);
            $post->content = $this->faker->text(255);
            $post->main_picture = 'example.png';
            $post->views = $this->faker->numberBetween(0, 1000);
            $post->save(false);
        }
    }

    private function generateTags()
    {
        //
    }
}
