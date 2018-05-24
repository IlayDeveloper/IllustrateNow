<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use rmrevin\yii\fontawesome\FA;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-default navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'СТАТЬИ', 'url' => ['/post']],
            ['label' => 'ОБУЧЕНИЕ', 'url' => ['#']],
            ['label' => 'ТЕСТЫ', 'url' => ['#']],
            ['label' => 'ТОП 10', 'url' => ['#']],
            ['label' => 'ФРИЛАНС', 'url' => ['#']],
            Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->login . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            ),
             '<form class="navbar-form navbar-left" role="search">
                 <div class="form-group">
                    <input type="text" class="form-control" placeholder="Поиск">
                 </div>
                 <button type="submit" class="btn btn-default btn-link">'. FA::icon(FA::_SEARCH) . '</button>
             </form>'
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <div class="row">
            <div class="col-md-8">
                <?= $content ?>
            </div>
            <div class="col-md-4">
                Реклама
             </div>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="container content">
        <div class="row">
            <div class="col-md-6">
                <div class="footer-tags">
                    tags tags tags <br>
                    tags tags tags <br>
                    tags tags tags <br>
                </div>
                <div class="footer-society">
                    <div class="row">
                        <div class="col-md-5"><?=Html::a(Yii::$app->name . '.ru', '/')?></div>
                        <div class="col-md-1"><?=Html::a(FA::icon(FA::_FACEBOOK), '#')?></div>
                        <div class="col-md-1"><?=Html::a(FA::icon(FA::_VK), '#')?></div>
                        <div class="col-md-1"><?=Html::a(FA::icon(FA::_TWITTER), '#')?></div>
                        <div class="col-md-4"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div>&copy; Vorona <?= date('Y') ?></div>
                <div>Копирование материалов запрещено</div>
            </div>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
