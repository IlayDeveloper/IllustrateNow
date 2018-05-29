<?php
use \yii\helpers\Html;
use rmrevin\yii\fontawesome\FA;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $megaPost \app\models\Post*/

$this->title = 'IllustrateNow';
?>
<?php Pjax::begin(['timeout' => 5000 ]); ?>
<div class="site-index">

    <div class="body-content">
        <div class="face-mega-post">
            <?=Html::a(Html::img( $megaPost->getLinkMainPicture(), ['class' => 'img-responsive']), '/post/view?id=' . $megaPost->id) ?>
            <div id="mega-title">
                <?=Html::a('<h1>' . $megaPost->short_title . '</h1>', '/post/view?id=' . $megaPost->id)?>
                <p class="post-text-indent"><?=$megaPost->description?></p>
            </div>
        </div>

        <?php $posts = $dataProvider->getModels();?>
        <?php foreach ($posts as $post):?>

            <div class="row post-preview-row">
                <div class="col-md-5 post-preview-photo">
                    <?= Html::a(Html::img($post->getLinkMainThumbnail(), ['class' => 'img-responsive']), '/post/view?id=' . $post->id);?>
                </div>
                <div class="col-md-6">
                    <div>
                        <h3>
                            <div class="post-preview-title">
                                <?= Html::a($post->short_title, '/post/view?id=' . $post->id); ?>
                            </div>
                        </h3>
                        <div><?= $post->description; ?></div>
                    </div>
                    <div>
                        <!--                <?//= $post->postTags?>-->
                    </div>
                    <div>
                        <?=FA::icon(FA::_EYE)?>
                        <?=$post->views?>
                    </div>
                </div>
                <div class="col-md-1 post-preview-icon">
                    <?= Html::a(FA::icon(FA::_ARROW_RIGHT)->size(FA::SIZE_2X)->pullRight(), '/post/view?id=' . $post->id)?>
                </div>
            </div>

        <?php endforeach;?>
        <?=LinkPager::widget([
            'pagination' => $pages,
        ]);?>
    <?php Pjax::end(); ?>
    </div>


</div>
