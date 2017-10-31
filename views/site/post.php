<?php

/* @var $this yii\web\View */

$this->title = Yii::$app->params['title']. ' - '.$post->title;
?>
<div class="row">
    <div class="col-md-8">
        <!-- start post -->
        <article class="post single-post">
            <div class="post-content">
                <div class="post-header">
                    <h2><?= $post->title ?> <span class="pull-right"><?= $post->getTimeString() ?></span></h2>
                </div>
                <div class="entry-content">
                    <p><strong><?= $post->description ?></strong></p>
                    <?= $post->content ?>
                </div>
                <div class="post-tag">
                    <?php foreach ($post->getTags() as $tag):?>
                        <a href="/tag/<?= $tag ?>"><?= $tag ?></a>
                    <?php endforeach;?>
                </div>
                <div class="single-post-meta">
                    <ul class="meta-profile pull-left">
                        <?php foreach ($post->blogCatPos as $blogCatPos):?>
                            <li><a href="/category/<?= $blogCatPos->category_id ?>"><i class="fa fa-folder-open"></i><?= $blogCatPos->category->description ?></a></li>
                        <?php endforeach;?>
                    </ul>
                    <ul class="meta-social pull-right">
                        <li class="s-vk"><a href="<?= Yii::$app->params['linkVk'] ?>"><i class="fa fa-vk"></i></a></li>
                        <li class="s-odnoklassniki"><a href="<?= Yii::$app->params['linkOk'] ?>"><i class="fa fa-odnoklassniki"></i></a></li>
                        <li class="s-facebook"><a href="<?= Yii::$app->params['linkFb'] ?>"><i class="fa fa-facebook"></i></a></li>
                        <li class="s-heart"><a href=""><i class="fa fa-heart"></i></a></li>
                    </ul>
                </div>
            </div>
        </article>
        <!-- end post -->
        <div id="comment-area" class="comment-area">
            <?php if(!Yii::$app->user->isGuest):?>
                <div class="leave-comment main-comment" id="<?= $post->id ?>"><!--leave comment-->
                    <h3 class="reply-heading">Оставить комментарий</h3>
                    <form class="form-horizontal contact-form" role="form" method="post" action="#">
                        <div class="form-group">
                            <div class="col-md-12">
                                <textarea id="comment-field" class="form-control" rows="2" name="message" placeholder="Введите текст сообщения"></textarea>
                            </div>
                        </div>
                        <button id="send-comment" type="button" class="btn send-btn">Комментировать</button>
                    </form>
                    <p class="email-alert" style="display: none">Введите сообщение.</p>
                </div>
            <?php else:?>
                <div class="auth-to-leave-comment"><a href="/user/login?returnUrl=<?= $_SERVER['REQUEST_URI'] ?>#comment-area" class="text-danger">Авторизуйтесь</a>, чтобы оставлять комментарии</div>
            <?php endif;?>
            <div id="comment-data">
                <?= $this->render('_comments', [
                    'comments' => $post->comments,
                ]); ?>
            </div>
        </div>
    </div>
    <?= $this->render('_sidebar', [
        'posts' => $posts,
        'categories' => $categories,
        'tags' => $tags,
    ]); ?>
</div>