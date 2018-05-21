<?php

namespace app\models;

use \yii\db\ActiveRecord;

/**
 * This is the model class for table "post_tags".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 *
 */
class PostTag extends ActiveRecord
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
        return $this->hasOne(Posts::className(), ['id' => 'post_id']);
    }
}

