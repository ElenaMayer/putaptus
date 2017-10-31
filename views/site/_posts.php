<?php foreach ($posts as $post):?>

<div class="col-md-6">
    <article class="post list-post post-grid">
        <div class="post-thumb">
            <a href="/post/<?= $post->id?>"><img src="../<?= $post->image?>" alt="<?= $post->title?>"></a>
            <a href="/post/<?= $post->id?>" class="post-thumb-overlay text-center">
                <div class="text-uppercase text-center"><i class="fa fa-search"></i></div>
            </a>
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
    </article>
</div>
<?php endforeach;?>
<!--pagination-->
<!--<div class="post-pagination text-center">-->
<!--    <ul class="pagination">-->
<!--        <li class="active"><a href="#">1</a></li>-->
<!--        <li><a href="#">2</a></li>-->
<!--        <li><a href="#">3</a></li>-->
<!--        <li><a href="#">Next</a></li>-->
<!--    </ul>-->
<!--</div>-->