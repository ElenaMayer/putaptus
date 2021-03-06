<?php

/* @var $this yii\web\View */

$this->title = Yii::$app->params['title'];
?>
<div class="row">
    <div class="col-md-8">
        <?= $this->render('_posts', [
            'posts' => $posts,
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