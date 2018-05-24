<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use \rmrevin\yii\fontawesome\FA;
use yii\widgets\LinkPager;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $post \app\models\Post*/
/* @var $pages \yii\data\Pagination*/

$this->title = 'Статьи';
$this->params['breadcrumbs'][] = "Admin";
?>
<div class="post-index">

    <h1>Админка для Викульки</h1>
    <?php Pjax::begin(); ?>
    <br>
    <p>
        <?= Html::a('СОЗДАТЬ НОВЫЙ ПОСТ', ['create'], ['class' => 'btn-lg btn-success']) ?>
    </p>
    <br>

    <div class="row mini-search">
        <div class="col-md-12">
            <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
        </div>
    </div>

    <?php $posts = $dataProvider->getModels();?>
    <?php foreach ($posts as $post):?>

    <div class="row post-preview-row">
        <div class="col-md-5 post-preview-photo">
        <?= Html::a(Html::img($post->getLinkMainThumbnail()), '/admin/view?id=' . $post->id);?>
        </div>
        <div class="col-md-4">
            <div>
                <h3>
                    <div class="post-preview-title">
                       <?= Html::a($post->short_title, '/admin/view?id=' . $post->id); ?>
                    </div>
                </h3>
                <div><?= $post->description; ?></div>
            </div>
            <div>
<!--                <?//= $post->postTags?>-->
            </div>
            <br>
            <div>
                <?=FA::icon(FA::_EYE)?>
                <?=$post->views?>
            </div>
        </div>
        <div class="col-md-3 post-preview-icon">
            <div class="pull-right"><?= Html::a(FA::icon(FA::_ARROW_RIGHT)->size(FA::SIZE_2X), '/admin/view?id=' . $post->id)?></div>
            <br>
            <br>
            <div class="pull-right"><?= Html::a('Редактировать', ['update?id=' . $post->id], ['class' => 'btn btn-primary custom-button'])?></div>
            <br>
            <br>
            <div class="pull-right">
                <?=Html::a('Удалить', ['delete', 'id' => $post->id], [
                    'class' => 'btn btn-danger custom-button',
                    'data' => [
                        'confirm' => 'Вы уверены?! Данный пост будет удален безвозвратно!!!',
                        'method' => 'post',
                    ],
                ]) ?>
            </div>
        </div>
    </div>

    <?php endforeach;?>
    <?=LinkPager::widget([
        'pagination' => $pages,
         ]);?>
    <?php Pjax::end(); ?>
</div>
