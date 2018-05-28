<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;
use \yii\db\ActiveRecord;

/**
 * This is the model class for table "post_pictures".
 *
 * @property int $id
 * @property string $name
 * @property int $post_id
 *
 * @property Posts $post
 */
class PostPicture extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post_pictures';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['post_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Post::className(), 'targetAttribute' => ['post_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'post_id' => 'Post ID',
        ];
    }

    /**
     * @param $pictures
     * @param $post_id
     * @var $p PostPicture
     * @return null|static
     */
    public function uploadPictures($pictures, $post_id)
    {
        $post = Post::findOne(['id' => $post_id]);
        $path = Post::PICTURE_ROOT_PATH_MAIN . DIRECTORY_SEPARATOR . substr($post->main_picture, 0, -4);
        foreach ($pictures as $picture){
            $name = uniqid() . '.' . $picture->getExtension();
            if( $picture->saveAs($path . DIRECTORY_SEPARATOR . $name) ){
               $postPicture = new static(['name' => $name, 'post_id' => $post_id]);
               $postPicture->save();
            }
        }
        $pictures = $post->getPictures()->all();
        $links = [];
        foreach ($pictures as $p){
            $links[] = ['link' => $p->getLinkPicture(), 'id' => $p->id];
        }
        return $links;
    }

    /**
     * @return bool|false|int
     */
    public function deletePicture(){
        $path = substr($this->getLinkPicture(), 1);
        if ( unlink($path) ){
            return $this->delete();
        } else{
            return false;
        }
    }

    /**
     * @return string
     */
    public function getLinkPicture()
    {
        $post = $this->getPost()->one();
        $path = DIRECTORY_SEPARATOR . Post::PICTURE_ROOT_PATH_MAIN .
            DIRECTORY_SEPARATOR .
            substr($post->main_picture, 0 ,-4) .
            DIRECTORY_SEPARATOR .
            $this->name;
        return $path;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::class, ['id' => 'post_id']);
    }
}
