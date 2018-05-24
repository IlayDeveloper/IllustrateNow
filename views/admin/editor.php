<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use \app\models\Post;

/* @var $this yii\web\View */
/* @var $model app\models\Post */
?>


    <div id="editor">
        <div  class="row editor-row">
            <div class="col-md-6">
                <?=Html::button('Описание', ['class' => 'tag1 btn btn-success', 'id' =>'desc'])?>
            </div>
             <div class="col-md-6 post-description text-center">
                 <div class="fat-border">
                     Пример пример
                 </div>
            </div>
        </div>

        <div  class="row editor-row">
            <div class="col-md-6">
                <?=Html::button('Под картинкой', ['class' => 'tag1 btn btn-success', 'id' =>'und-picture'])?>
            </div>

            <div class="col-md-6 post-under-picture text-center">
                Пример пример
            </div>
        </div>

        <div  class="row editor-row">
            <div class="col-md-6">
                <?=Html::button('Подчеркнутый', ['class' => 'tag1 btn btn-success'])?>
            </div>

            <div class="col-md-6 post-underline text-center">
                Пример пример
            </div>
        </div>

        <div  class="row editor-row">
            <div class="col-md-6">
                <?=Html::button('Внимание', ['class' => 'tag1 btn btn-success'])?>
            </div>

            <div class="col-md-6 post-warning text-center">
                Пример пример
            </div>
        </div>

        <div  class="row editor-row">
            <div class="col-md-5">
                <?=Html::button('Заголовок', ['class' => 'tag1 btn btn-success'])?>
            </div>

            <div class="col-md-7 post-title text-center">
                Пример пример
            </div>
        </div>

    </div>

