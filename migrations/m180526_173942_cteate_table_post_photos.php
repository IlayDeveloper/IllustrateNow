<?php

use yii\db\Migration;

/**
 * Class m180526_173942_cteate_table_post_photos
 */
class m180526_173942_cteate_table_post_photos extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('post_pictures', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'post_id' => $this->integer()
        ]);

        $this->addForeignKey(
            'fk-posts-id',
            'post_pictures',
            'post_id',
            'posts',
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
        echo "m180526_173942_cteate_table_post_photos cannot be reverted.\n";

        return false;
    }

}
