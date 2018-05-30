<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use \rmrevin\yii\fontawesome\FA;
use \app\models\Tag;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $post \app\models\Post*/

$this->title = 'Статьи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?= Html::encode('Самые свежие посты') ?></h1>
    <?php Pjax::begin(); ?>
<!--    --><?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?php $posts = $dataProvider->getModels();?>
    <?php foreach ($posts as $post):?>

    <div class="row post-preview-row">
        <div class="col-md-5 post-preview-photo">
        <?= Html::a(Html::img($post->getLinkMainThumbnail()), 'post/view?id=' . $post->id);?>
        </div>
        <div class="col-md-6">
            <div>
                <h3>
                    <div class="post-preview-title">
                       <?= Html::a($post->short_title, 'post/view?id=' . $post->id); ?>
                    </div>
                </h3>
                <div><?= $post->description; ?></div>
            </div>
            <div class="form-tags">
                <?php $postTags = $post->getPostTags()->all();?>
                <?php foreach ($postTags as $postTag):?>
                    <?php $t = Tag::findOne(['id' => $postTag->tag_id]); ?>
                    <span id=<?=$t->id;?> class="post-tag"> <?= $t->name;?></span>
                <?php endforeach ?>
            </div>
            <div>
                 <?=FA::icon(FA::_EYE)?>
                 <?=$post->views?>
            </div>
        </div>
        <div class="col-md-1 post-preview-icon">
            <?= Html::a(FA::icon(FA::_ARROW_RIGHT)->size(FA::SIZE_2X)->pullRight(), '/post/view?id=' . $post->id)?>
        </div>
    </div>

    <?php endforeach;?>
    <?php Pjax::end(); ?>
</div>
