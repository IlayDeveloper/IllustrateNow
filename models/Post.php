<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use \yii\db\ActiveRecord;
use yii\web\UploadedFile;

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
    const PICTURE_ROOT_PATH_MAIN = 'assets' .
                                    DIRECTORY_SEPARATOR . 'pictures' .
                                    DIRECTORY_SEPARATOR . 'posts' .
                                    DIRECTORY_SEPARATOR . 'main';
    const PICTURE_ROOT_PATH_THUMBNAILS = 'assets' .
                                            DIRECTORY_SEPARATOR . 'pictures' .
                                            DIRECTORY_SEPARATOR . 'posts' .
                                            DIRECTORY_SEPARATOR . 'thumbnails';


    const STATUS_MEGA = 1;
    const STATUS_USUAL = 2;

    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'posts';
    }

    public function scenarios()
    {
        return [
            static::SCENARIO_CREATE => [
                'title', 'short_title',
                'description', 'content',
                'main_picture', 'status_id'
            ],
            static::SCENARIO_UPDATE => [
                'title', 'short_title',
                'description', 'content',
                'main_picture', 'status_id'
            ]
        ];
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
            [['title', 'short_title', 'description', 'content'], 'required'],
            [['title', ], 'string', 'max' => 255],
            [['short_title'], 'string', 'max' => 64],
            [['description'], 'string', 'max' => 256],
            [['content'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'short_title' => 'Короткий заголовок',
            'description' => 'Описание',
            'content' => 'Контент',
            'main_picture' => 'Главная картинка',
            'status_id' => 'Статус поста',
            'views' => 'Просмотры',
            'created_at' => 'Создан',
            'updated_at' => 'Обновлен',
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
    public function getPictures()
    {
        return $this->hasMany(PostPicture::class, ['post_id' => 'id']);
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
        $path = DIRECTORY_SEPARATOR .
            static::PICTURE_ROOT_PATH_MAIN .
            DIRECTORY_SEPARATOR .
            substr($this->main_picture, 0, -4) .
            DIRECTORY_SEPARATOR .
            $this->main_picture;
        return $path;
    }

    /**
     * @return string
     */
    public function getLinkMainThumbnail()
    {
        $path = DIRECTORY_SEPARATOR . static::PICTURE_ROOT_PATH_THUMBNAILS . DIRECTORY_SEPARATOR . $this->main_picture;
        return $path;
    }

    /**
     * @return bool
     */
    public function deleteAllPicture()
    {
        $directory = substr($this->main_picture, 0, -4);
        $path = static::PICTURE_ROOT_PATH_MAIN . DIRECTORY_SEPARATOR . $directory;
        $files = scandir($path);

        foreach ($files as $file){
            if( is_file($path . DIRECTORY_SEPARATOR . $file) ){
                unlink($path . DIRECTORY_SEPARATOR . $file);
            }
        }

        if( rmdir($path) &&
            unlink(static::PICTURE_ROOT_PATH_THUMBNAILS . DIRECTORY_SEPARATOR . $this->main_picture)
        ){
            return true;
        }
        return false;
    }

}
