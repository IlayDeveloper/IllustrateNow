<?php

namespace app\models;

use \yii\db\ActiveRecord;

/**
 * This is the model class for table "post_tags".
 *
 * @property int $id
 * @property int $post_id
 * @property int $tag_id
 *
 */
class PostTags extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post_tags';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasOne(Post::class, ['id' => 'post_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasOne(Tag::class, ['id' => 'tag_id']);
    }
}

