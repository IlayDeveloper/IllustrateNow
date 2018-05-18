<?php

use yii\db\Migration;

/**
 * Handles the creation of table `post_tags`.
 */
class m180518_141649_create_post_tags_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('post_tags', [
            'id' => $this->primaryKey(),
            'post_id' => $this->integer(),
            'tag_id' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-post_tags-post_id',
            'post_tags',
            'post_id',
            'posts',
            'id',
            'CASCADE',
            'RESTRICT'
        );

        $this->addForeignKey(
            'fk-post_tags-tag_id',
            'post_tags',
            'tag_id',
            'tags',
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
        $this->dropTable('post_tags');
    }
}
