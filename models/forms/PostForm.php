<?php

namespace app\models\forms;

use app\models\Post;
use app\models\PostPicture;
use Yii;
use yii\base\Model;
use yii\helpers\Html;
use yii\web\UploadedFile;


class PostForm extends Model
{
    /**
     * @var integer
     */
    public $id;
    /**
     * @var string
     */
    public $title;
    /**
     * @var string
     */
    public $short_title;
    /**
     * @var string
     */
    public $description;
    /**
     * @var string
     */
    public $content;
    /**
     * @var UploadedFile[]
     */
    public $pictures;
    /**
     * @var UploadedFile
     */
    public $main_picture;
    /**
     * @var string
     */
    public $status_id;
    /**
     * @var int
     */
    public $views = 0;
    /**
     * @var string
     */
    public $created_at;
    /**
     * @var string
     */
    public $updated_at;

    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    const THUMBNAIL_HEIGHT = 200;
    const THUMBNAIL_WIDTH = 290;

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
                'main_picture', 'status_id',
                'views', 'updated_at',
                'created_at',
            ]
        ];
    }

    /**
     * @return array the validation rules.
     */

    public function rules()
    {
        return [
            [['title', 'short_title', 'description', 'content', 'status_id'], 'required'],
            [['short_title'], 'string', 'max' => 64],
            [['title'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 256],
            [['status_id' ,'id'], 'integer'],
            [['updated_at', 'created_at'], 'safe'],
            [['main_picture'], 'file', 'extensions' => ['png', 'jpg']],
            [['main_picture'], 'required', 'on' => static::SCENARIO_CREATE],
            [['pictures'], 'file', 'extensions' => ['png', 'jpg'], 'maxFiles' => 25],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'title' => 'Заголовок',
            'short_title' => 'Короткий заголовок',
            'description' => 'Описание',
            'content' => 'Контент',
            'pictures' => 'Картинки',
            'main_picture' => 'Главная картинка',
            'status_id' => 'Статус поста',
            'views' => 'Просмотры',
            'created_at' => 'Создан',
            'updated_at' => 'Обновлен',
        ];
    }

    /**
     * @return Post|bool
     */
    public function addNewPost()
    {
        $post = new Post($this->getAttributes(null, ['pictures']));
        $post->scenario = Post::SCENARIO_CREATE;
        if ($this->main_picture) {
            $post->main_picture = $this->uploadMainPicture();
        }
        if($post->save()){
            return $post;
        }
        return false;
    }

    /**
     * @param Post $post
     * @return Post|bool
     */
    public function updatePost(Post $post)
    {
        $post->title = $this->title;
        $post->short_title = $this->short_title;
        $post->description = $this->description;
        $post->content = $this->content;
        $post->status_id = $this->status_id;
        $post->scenario = Post::SCENARIO_UPDATE;
        if ($this->main_picture) {
            $post->main_picture = $this->changeMainPicture($post->main_picture);
        }
        $post->update();
        return $post;


    }

    /**
     * @return string|bool
     */
    public function uploadMainPicture()
    {
        $directoryName = uniqid();
        if( mkdir(Post::PICTURE_ROOT_PATH_MAIN . DIRECTORY_SEPARATOR . $directoryName) ){
            $fileName = $directoryName .  '.' . $this->main_picture->getExtension();
            $success = $this->main_picture->saveAs(
                Post::PICTURE_ROOT_PATH_MAIN .
                DIRECTORY_SEPARATOR .
                $directoryName .
                DIRECTORY_SEPARATOR .
                $fileName
            );
            if ($success){
                $this->createThumbnail($fileName);
                return $fileName;
            }
        }
        return false;
    }

    /**
     * @param string $oldFileName
     * @return bool
     */
    public function changeMainPicture($oldFileName)
    {
        unlink(
            Post::PICTURE_ROOT_PATH_MAIN .
            DIRECTORY_SEPARATOR .
            substr($oldFileName, 0, -4) .
            DIRECTORY_SEPARATOR .
            $oldFileName);
        unlink(Post::PICTURE_ROOT_PATH_THUMBNAILS . DIRECTORY_SEPARATOR . $oldFileName);

        $fileName = substr($oldFileName, 0, -4) .  '.' . $this->main_picture->getExtension();
        $success = $this->main_picture->saveAs(
            Post::PICTURE_ROOT_PATH_MAIN .
            DIRECTORY_SEPARATOR .
            substr($oldFileName, 0, -4) .
            DIRECTORY_SEPARATOR .
            $fileName
        );
        if ($success){
            $this->createThumbnail($fileName);
            return $fileName;
        }
        return false;
    }

    /**
     * @param string $name
     */
    protected function createThumbnail($name)
    {
        $image = new \Zebra_Image();
        $image->auto_handle_exif_orientation = false;
        $image->source_path = Post::PICTURE_ROOT_PATH_MAIN . DIRECTORY_SEPARATOR .
            substr($name, 0, -4) .
            DIRECTORY_SEPARATOR .
            $name;
        $image->target_path = Post::PICTURE_ROOT_PATH_THUMBNAILS . DIRECTORY_SEPARATOR . $name;

        if (!$image->resize(static::THUMBNAIL_WIDTH, static::THUMBNAIL_HEIGHT, ZEBRA_IMAGE_CROP_CENTER)) {

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
