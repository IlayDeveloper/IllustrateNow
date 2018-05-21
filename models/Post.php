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
 * @property int $status_id
 * @property int $views
 * @property string $created_at
 * @property string $updated_at
 *
 * @property PostTags[] $postTags
 */
class Post extends ActiveRecord
{
    const PICTURE_ROOT_PATH_MAIN = DIRECTORY_SEPARATOR . 'assets' .
                                    DIRECTORY_SEPARATOR . 'pictures' .
                                    DIRECTORY_SEPARATOR . 'posts' .
                                    DIRECTORY_SEPARATOR . 'main';
    const PICTURE_ROOT_PATH_THUMBNAILS = DIRECTORY_SEPARATOR . 'assets' .
                                            DIRECTORY_SEPARATOR . 'pictures' .
                                            DIRECTORY_SEPARATOR . 'posts' .
                                            DIRECTORY_SEPARATOR . 'thumbnails';

    const STATUS_MEGA = 1;
    const STATUS_USUAL = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'posts';
    }

    public static function getMegaPost()
    {
        return static::findOne(['status_id' => static::STATUS_MEGA]);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'value' => function () {
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
        return $this->hasMany(PostTag::class, ['post_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostStatus()
    {
        return $this->hasOne(PostStatus::class, ['status_id' => 'id']);
    }

    /**
     * @return string
     */
    public function getLinkMainPicture()
    {
        $path = static::PICTURE_ROOT_PATH_MAIN . DIRECTORY_SEPARATOR . $this->main_picture;
        return $path;
    }

    public function createThumbnail()
    {
        $image = new \Zebra_Image();
        $image->auto_handle_exif_orientation = false;
        $image->target_path = static::PICTURE_ROOT_PATH_MAIN . DIRECTORY_SEPARATOR . $this->main_picture;
        $name = uniqid();
        $image->target_path = static::PICTURE_ROOT_PATH_THUMBNAILS . DIRECTORY_SEPARATOR . $name . 'jpg';

        if (!$image->resize(100, 100, ZEBRA_IMAGE_CROP_CENTER)) {

            // if there was an error, let's see what the error is about
            switch ($image->error) {

                case 1:
                    echo 'Source file could not be found!';
                    break;
                case 2:
                    echo 'Source file is not readable!';
                    break;
                case 3:
                    echo 'Could not write target file!';
                    break;
                case 4:
                    echo 'Unsupported source file format!';
                    break;
                case 5:
                    echo 'Unsupported target file format!';
                    break;
                case 6:
                    echo 'GD library version does not support target file format!';
                    break;
                case 7:
                    echo 'GD library is not installed!';
                    break;
                case 8:
                    echo '"chmod" command is disabled via configuration!';
                    break;
                case 9:
                    echo '"exif_read_data" function is not available';
                    break;

            }
        }
    }
}