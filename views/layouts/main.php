<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>


<!-- pre-loader -->
<div id="st-preloader">
    <div class="st-preloader-circle"></div>
</div>
<div class="header-top">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="header-top-left social-icons">
                    <a href="<?= Yii::$app->params['linkVk'] ?>"><i class="fa fa-vk"></i></a>
                    <a href="<?= Yii::$app->params['linkOk'] ?>"><i class="fa fa-odnoklassniki"></i></a>
                    <a href="<?= Yii::$app->params['linkFb'] ?>"><i class="fa fa-facebook"></i></a>
                    <a href="<?= Yii::$app->params['linkYt'] ?>"><i class="fa fa-youtube-play"></i></a>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="header-top-right fix">
                    <div class="header-links">
                        <ul>
                            <li>
                                <?php if(Yii::$app->user->isGuest):?>
                                    <a href="/user/login?returnUrl=<?= $_SERVER['REQUEST_URI'] ?>">Войти</a>
                                <?php else:?>
                                    <?php echo (Html::beginForm(['/user/security/logout'], 'post')

                                    . Html::submitButton(
                                        'Выйти',
                                        ['class' => 'btn btn-link logout']
                                    )
                                    . Html::endForm()); ?>
                                <?php endif;?>
                            </li>
                        </ul>
                    </div>
                    <?php if(!Yii::$app->user->isGuest):?>
                        <div class="top-profile">
                            <a href="/user/profile/show?id=<?= Yii::$app->user->id ?>" class="sactive"><i class="fa fa-user"></i></a>
                        </div>
                    <?php endif;?>
                    <div class="top-search">
                        <a href="#" class="sactive"><i class="fa fa-search"></i></a>
                    </div>
                </div>

                <div class="show-search">
                    <form method="get" id="search-form" action="/search">
                        <input type="text" placeholder="Найти..." name="s" >
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- header -->
<header class="header">
    <div class="logo text-center">
        <h1><a href="/"> <img src="/images/logo.png?4" alt="Textual"></a></h1>
        <p>Лучший канал для детей!</p>
    </div>
</header>
<!-- start main menu -->
<div class="wrap">
    <nav class="navbar main-menu">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#myNavbar"
                        aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div id="myNavbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li class="<?php if (strpos(Yii::$app->request->pathInfo, 'category/7')!==false):?>active<?php endif;?>"><a href="/category/7">Развивающие мультики</a></li>
                    <li class="<?php if (strpos(Yii::$app->request->pathInfo, 'category/1')!==false):?>active<?php endif;?>"><a href="/category/1">Щенячий патруль</a></li>
                    <li class="<?php if (strpos(Yii::$app->request->pathInfo, 'category/9')!==false):?>active<?php endif;?>"><a href="/category/9">Герои в масках</a></li>
                    <li class="<?php if (strpos(Yii::$app->request->pathInfo, 'category/2')!==false):?>active<?php endif;?>"><a href="/category/2">Робокар Поли</a></li>
                    <li class="<?php if (strpos(Yii::$app->request->pathInfo, 'category/5')!==false):?>active<?php endif;?>"><a href="/category/5">Сюрпризы в пластилине</a></li>
                    <li class="<?php if (strpos(Yii::$app->request->pathInfo, 'category/4')!==false):?>active<?php endif;?>"><a href="/category/4">Учим цвета</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="main-content">
        <div class="container">
            <?= $content ?>
        </div>
    </div>
</div>

<!-- start footer area -->
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="copyright-area">
                    <div class="copy-text pull-left">
                        <p>Copyright © <?= date('Y');?> by <?php echo Yii::$app->params['domain']; ?>. Developed by <a href="<?php echo Yii::$app->params['developerSite']; ?>"><?php echo Yii::$app->params['developer']; ?></a>.</p>
                    </div>
                    <div class="pull-right social-share footer-social-icon">
                        <span>Мы в соцсетях: </span>
                        <ul class="">
                            <li><a class="s-vk" href="<?= Yii::$app->params['linkVk'] ?>"><i class="fa fa-vk"></i></a></li>
                            <li><a class="s-odnoklassniki" href="<?= Yii::$app->params['linkOk'] ?>"><i class="fa fa-odnoklassniki"></i></a></li>
                            <li><a class="s-facebook" href="<?= Yii::$app->params['linkFb'] ?>"><i class="fa fa-facebook"></i></a></li>
                            <li><a class="s-youtube" href="<?= Yii::$app->params['linkYt'] ?>"><i class="fa fa-youtube-play"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- end footer area -->
<?= $this->render('../site/_metrika'); ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
