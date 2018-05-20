<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use \yii\db\ActiveRecord;

/**
 * This is the model class for table "posts".
 *
 * @property int $id
 * @property string $title
 * @property string $short_title
 * @property string $description
 * @property string $content
 * @property string $main_picture
 * @property int $views
 * @property string $created_at
 * @property string $updated_at
 *
 * @property PostTags[] $postTags
 */
class Post extends ActiveRecord
{
    const PICTURE_ROOT_PATH = DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'pictures' . DIRECTORY_SEPARATOR .'posts';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'posts';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'value' => function ($model) {
                    return date('Y-m-d H:i:s');
                },
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'short_title', 'description'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'content'], 'string', 'max' => 255],
            [['short_title'], 'string', 'max' => 64],
            [['description'], 'string', 'max' => 256],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'short_title' => 'Short Title',
            'description' => 'Description',
            'content' => 'Content',
            'views' => 'Views',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostTags()
    {
        return $this->hasMany(PostTags::className(), ['post_id' => 'id']);
    }

    /**
     * @return string
     */
    public function getLinkMainPicture()
    {
        $path = static::PICTURE_ROOT_PATH . DIRECTORY_SEPARATOR . $this->main_picture;
        return $path;
    }
}
