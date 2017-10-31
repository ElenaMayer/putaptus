<?php

/* @var $this yii\web\View */

$this->title = Yii::$app->params['title'].' - '.$category->title;
?>
<div class="row">
    <div class="col-md-8">
        <div class="archive-title">Категория <span class="archive-name"><?= $category->description ?></span></div>
        <?= $this->render('_posts', [
            'posts' => $postByCategory,
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