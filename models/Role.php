<?php

namespace app\models;

use yii\db\ActiveRecord;
/**
 * Role model
 *
 * @property string $id
 * @property string $name
 * @property string $description
 *
 */

class Role extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'roles';
    }

    public static function findByName($name)
    {
       return static::findOne(['name' => $name]);
    }

    public function getUsers()
    {
        return $this->hasOne(User::class, ['id' => 'role_id']);
    }
}
