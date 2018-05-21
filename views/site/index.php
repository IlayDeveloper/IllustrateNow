<?php

/* @var $this yii\web\View */
use \yii\helpers\Html;
/* @var $megaPost \app\models\Post*/
$this->title = 'IllustrateNow';
?>
<div class="site-index">

    <div class="body-content">
        <div class="mega-post">
            <?=Html::img( $megaPost->getLinkMainPicture())?>
        </div>
    </div>
</div>
