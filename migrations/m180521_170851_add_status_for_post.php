<?php

use yii\db\Migration;

/**
 * Class m180521_170851_add_status_for_post
 */
class m180521_170851_add_status_for_post extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('post_status', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'description' => $this->string(),
        ]);

        $this->addColumn('posts', 'status_id', $this->integer()->after('main_picture'));

        $this->addForeignKey(
            'fk-posts-status_id',
            'posts',
            'status_id',
            'post_status',
            'id',
            'CASCADE',
            'RESTRICT'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180521_170851_add_status_for_post cannot be reverted.\n";

        return false;
    }
}
