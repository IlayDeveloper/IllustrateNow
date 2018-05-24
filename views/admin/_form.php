<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \app\models\Post;

/* @var $this yii\web\View */
/* @var $model app\models\forms\PostForm */
/* @var $form yii\widgets\ActiveForm */
/* @var $post app\models\Post*/
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(
        ['options' => ['enctype' => 'multipart/form-data']]
    ); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'short_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textarea() ?>

    <?= $form->field($model, 'status_id')->dropDownList([
        Post::STATUS_USUAL => 'Обычный пост',
        Post::STATUS_MEGA => 'Мега пост'
    ]) ?>

    <?= $form->field($model, 'main_picture')->fileInput() ?>

    <?php if($model->scenario === Post::SCENARIO_UPDATE):?>
        <?= Html::img($post->getLinkMainThumbnail()) ?>
        <?= $form->field($model, 'views',
            ['inputOptions' => [
                'disabled' => '',
                'class' => 'form-control'
            ]])->textInput();
        ?>

        <?= $form->field($model, 'created_at',
            ['inputOptions' => [
                'disabled' => '',
                'class' => 'form-control'
            ]])->textInput();
        ?>

        <?= $form->field($model, 'updated_at',
            ['inputOptions' => [
                'disabled' => '',
                'class' => 'form-control'
            ]])->textInput();
        ?>
    <?php endif ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        <?php if($model->scenario === Post::SCENARIO_UPDATE):?>
            <?= Html::a('Отмена', '/admin/view?id=' . $model->id, ['class' => 'btn btn-danger']) ?>
        <?php else: ?>
            <?= Html::a('Отмена', '/admin', ['class' => 'btn btn-danger']) ?>
        <?php endif ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
