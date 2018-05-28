<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $post app\models\Post */
/* @var $model \app\models\forms\PostForm */

$this->title = 'Редактирование поста: "' . $model->short_title . '"';
$this->params['breadcrumbs'][] = ['label' => 'Admin', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->short_title, 'url' => ['view', 'id' => $post->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="post-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'post' => $post,
    ]) ?>

</div>
