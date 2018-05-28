<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Post */

$this->title = $model->short_title;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-view">
    <div class ="post-main-picture">
        <?= Html::img($model->getLinkMainPicture(), ['class' => 'img-responsive'])?>
        <h1><?=$this->title ?></h1>
    </div>
    <div class="post-main-content">
        <?= $model->content ?>
    </div>
</div>
