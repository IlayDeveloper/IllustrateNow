<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use \app\models\Post;

/* @var $this yii\web\View */
/* @var $model app\models\Post */

$this->title = $model->short_title;
$this->params['breadcrumbs'][] = ['label' => 'Admin', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены?! Данный пост будет удален безвозратно!!!',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'short_title',
            'description',
            'content',
            [
                'attribute' => 'main_picture',
                'format' => 'raw',
                'value' => Html::img($model->getLinkMainPicture()),
            ],
            [
                'attribute' => 'status_id',
                'value' => $model->status_id == Post::STATUS_MEGA?'Мега пост':'Обычный пост',
            ],
            'views',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
