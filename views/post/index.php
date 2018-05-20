<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $post \app\models\Post*/

$this->title = 'Статьи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

<!--    <p>-->
<!--        <?= Html::a('Create Post', ['create'], ['class' => 'btn btn-success']) ?>-->
<!--    </p>-->

    <?php $posts = $dataProvider->getModels();?>
    <?php foreach ($posts as $post):?>

    <div class="row post-preview-row">
        <div class="col-md-5 post-preview-photo">
        <?= Html::a(Html::img($post->getLinkMainPicture()), 'post/view?id=' . $post->id);?>
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
            <div>
<!--                <?//= $post->postTags?>-->
            </div>
            <div>
                Просмотров <?= $post->views?>
            </div>
        </div>
        <div class="col-md-1">
<!--   ссылка на картинку         --><?//= Html::img()?>
        </div>
    </div>

    <?php endforeach;?>
    <?php Pjax::end(); ?>
</div>
