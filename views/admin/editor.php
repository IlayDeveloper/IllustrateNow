<?php

use yii\helpers\Html;
use \app\models\Post;
use \app\components\StandartIcons;

/* @var $this yii\web\View */
/* @var $model app\models\Post */
?>
    <div id="editor">
<!--        Стандартные тэги-->
        <div  class="row editor-row">
            <div class="col-md-6">
                <?=Html::button('Описание', ['class' => 'btn btn-success', 'id' =>'desc'])?>
            </div>
             <div class="col-md-6 post-description text-center">
                 <div class="fat-border">
                     Пример пример
                 </div>
            </div>
        </div>

        <div  class="row editor-row">
            <div class="col-md-6">
                <?=Html::button('Под картинкой', ['class' => 'btn btn-success', 'id' =>'und-picture'])?>
            </div>
            <div class="col-md-6 post-under-picture text-center">
                Пример пример
            </div>
        </div>

        <div  class="row editor-row">
            <div class="col-md-6">
                <?=Html::button('Подчеркнутый', ['class' => 'btn btn-success', 'id' => 'underline'])?>
            </div>
            <div class="col-md-6 post-underline text-center">
                Пример пример
            </div>
        </div>

        <div  class="row editor-row">
            <div class="col-md-6">
                <?=Html::button('Внимание', ['class' => 'btn btn-success', 'id' => 'warning'])?>
            </div>
            <div class="col-md-6 post-warning text-center">
                Пример пример
            </div>
        </div>

        <div  class="row editor-row">
            <div class="col-md-5">
                <?=Html::button('Заголовок', ['class' => 'btn btn-success', 'id' => 'title'])?>
            </div>
            <div class="col-md-7 post-title text-center">
                Пример пример
            </div>
        </div>

        <div  class="row editor-row">
            <div class="col-md-5">
                <?=Html::button('Описание карт.', ['class' => 'btn btn-success', 'id' => 'desc-picture'])?>
            </div>
            <div class="col-md-7 post-desc-picture text-center">
                Пример пример
            </div>
        </div>

        <div  class="row editor-row">
            <div class="col-md-5">
                <?=Html::button('Текстовые тэги', ['class' => 'btn btn-success', 'id' => 'text-tag'])?>
            </div>
            <span class="col-md-7 post-text-tag text-center">
                Пример пример
            </span>
        </div>

        <div  class="row editor-row">
            <div class="col-md-12">
                <?=Html::button('Таблица', ['class' => 'btn btn-success', 'id' => 'table'])?>
            </div>

            <div class="post-table">
                <div class="row">
                    <div class="col-md-7">
                        <div class="row post-table-title"></div>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-4">
                        <div class="row post-table-title"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-7">
                        <div class="row post-table-usual">Пример строки</div>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-4">
                        <div class="row post-table-usual">Пример строки</div>
                    </div>
                </div>
            </div>
        </div>

<!--        Стандартные иконки-->
        <div  class="row editor-row">
            <hr>
            <div class="col-md-12">
                <?php foreach (StandartIcons::ICONS as $key):?>
                    <?=Html::img( StandartIcons::getLinkIcon($key), ['class'=> 'editor-icons','id' => 'icon-'.$key ])?>
                <?php endforeach;?>
            </div>
        </div>
    </div>

