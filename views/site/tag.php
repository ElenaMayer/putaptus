<?php

/* @var $this yii\web\View */

$this->title = Yii::$app->params['title'].' - '.$tag;
?>
<div class="row">
    <div class="col-md-8">
        <div class="archive-title">Статьи по тэгу <span class="archive-name"><?= $tag ?></span></div>
        <?= $this->render('_posts', [
            'posts' => $postsByTag,
            'pages' => $pages,
        ]); ?>
    </div>
    <?= $this->render('_sidebar', [
            'lastPosts' => $lastPosts,
            'popularPosts' => $popularPosts,
            'categories' => $categories,
            'tags' => $tags,
        ]); ?>
</div>