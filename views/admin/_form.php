<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \app\models\Post;
use \app\models\forms\PostForm;
use \rmrevin\yii\fontawesome\FA;

/* @var $this yii\web\View */
/* @var $model app\models\forms\PostForm */
/* @var $form yii\widgets\ActiveForm */
/* @var $post app\models\Post*/
/* @var $p  \app\models\PostPicture*/
?>
<div class="post-form">

    <?php $form = ActiveForm::begin(
        ['options' => ['enctype' => 'multipart/form-data']]
    ); ?>

    <?php if($model->scenario == PostForm::SCENARIO_UPDATE):?>
        <?= $form->field($post, 'id')->hiddenInput()->label(false); ?>
    <?php endif ?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'short_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textarea(['class' => 'hidden']) ?>
    <div id="codeEditor" class="codeEditor">

    </div>
    <?=Html::button(FA::icon(FA::_EXPAND), ['class' => 'btn btn-info', 'id' =>'btn-toggle'])?>

    <?=Html::button('Предпросмотр', ['class' => 'btn btn-success', 'id' =>'preview-btn'])?>
    <div id="editor-preview" class="post-view">
        <?= $model->content?>
    </div>

    <hr>
    <?php if($model->scenario == PostForm::SCENARIO_UPDATE):?>
        <?= $form->field($model, 'pictures')->fileInput() ?>
        <div class="form-pictures">
            <?php $pictures = $post->getPictures()->all();
            foreach ($pictures as $p):?>
                <?=Html::img($p->getLinkPicture(), ['id' =>$p->id ,'class' => 'post-pictures']);?>
            <?php endforeach ?>
        </div>
    <?php endif ?>
    <?=Html::button('Добавить', ['class' => 'btn btn-success hidden', 'id' =>'pictures-btn-add'])?>
    <?=Html::button('Удалить', ['class' => 'btn btn-danger hidden', 'id' =>'pictures-btn-del'])?>
    <hr>

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
            <?= Html::a('Отмена', '/admin/view?id=' . $post->id, ['class' => 'btn btn-danger']) ?>
        <?php else: ?>
            <?= Html::a('Отмена', '/admin', ['class' => 'btn btn-danger']) ?>
        <?php endif ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
