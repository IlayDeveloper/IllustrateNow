<?php

use yii\db\Migration;

/**
 * Handles the creation of table `admin`.
 */
class m180518_134105_create_admin_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('admins', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'login' => $this->string()->notNull()->unique(),
            'password_hash' => $this->string()->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'created_at' => $this->datetime(),
            'updated_at' => $this->datetime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('admins');
    }
}
