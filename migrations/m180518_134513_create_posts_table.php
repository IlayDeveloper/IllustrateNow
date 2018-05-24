<?php

use yii\db\Migration;

/**
 * Handles the creation of table `posts`.
 */
class m180518_134513_create_posts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('posts', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'short_title' => $this->string(64)->notNull(),
            'description' => $this->string(256)->notNull(),
            'content' => $this->text(),
            'views' => $this->integer(),
            'created_at' => $this->datetime(),
            'updated_at' => $this->datetime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('posts');
    }
}
