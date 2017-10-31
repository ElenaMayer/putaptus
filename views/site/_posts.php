<?php
use yii\widgets\LinkPager;
?>

<?php foreach ($posts as $post):?>
    <article class="post list-post">
        <div class="media">
            <div class="media-left">
                <div class="post-thumb">
                    <a href="/post/<?= $post->id?>"><img src="../<?= $post->image?>" alt="<?= $post->title?>"></a>
                    <a href="/post/<?= $post->id?>" class="post-thumb-overlay text-center">
                        <div class="text-uppercase text-center"><i class="fa fa-search"></i></div>
                    </a>
                </div>
            </div>
            <div class="post-content">
                <div class="post-header">
                    <h2>
                        <a href="/post/<?= $post->id?>"><?= $post->title?></a>
                        <span class="pull-right"><?= $post->getTimeString() ?></span>
                    </h2>
                </div>
                <div class="entry-content">
                    <p><?= $post->description?></p>
                    <div class="continue-reading text-uppercase">
                        <a href="/post/<?= $post->id?>" class="more-link text-center">Подробнее</a>
                    </div>
                </div>
            </div>
        </div>
    </article>
<?php endforeach;?>


<div class="post-pagination text-center">
    <?php echo LinkPager::widget([
        'pagination' => $pages,
    ]); ?>
</div>