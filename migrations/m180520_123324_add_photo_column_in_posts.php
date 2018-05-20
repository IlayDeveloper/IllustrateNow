<?php

use yii\db\Migration;

/**
 * Class m180520_123324_add_photo_column_in_posts
 */
class m180520_123324_add_photo_column_in_posts extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('posts', 'main_picture', $this->string()->after('content'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180520_123324_add_photo_column_in_posts cannot be reverted.\n";

        return false;
    }
}
