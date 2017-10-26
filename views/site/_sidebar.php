<div class="col-md-4">
    <!-- start sidebar -->
    <div class="sidebar">
        <aside class="widget"><!-- start single widget -->
            <h3 class="widget-title text-uppercase">Популярные посты</h3>
            <?php foreach ($posts as $post):?>
                <div class="thumb-latest-posts">
                    <div class="media">
                        <div class="media-left">
                            <a href="/post/<?= $post->id?>" class="popular-img"><img src="../<?=$post->image?>" alt="<?=$post->image?>">
                                <div class="p-overlay"></div>
                            </a>
                        </div>
                        <div class="p-content">
                            <h3><a href="/post/<?= $post->id?>"><?=$post->title?></a></h3>
                            <span class="p-date"><?= $post->getTimeString() ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach;?>
        </aside><!-- end single widget -->

        <aside class="widget widget_vk">
            <script type="text/javascript" src="//vk.com/js/api/openapi.js?150"></script>
            <!-- VK Widget -->
            <div id="vk_groups"></div>
            <script type="text/javascript">
                VK.Widgets.Group("vk_groups", {mode: 3, width: "auto", height: "400"}, <?= Yii::$app->params['groupIdVk']?>);
            </script>
        </aside>
        <aside class="widget widget-tag"><!-- start single widget -->
            <h3 class="widget-title text-uppercase">Облако тэгов</h3>
            <?php foreach ($tags as $tag):?>
                <a href="/tag/<?= $tag->tags ?>"><?= $tag->tags ?></a>
            <?php endforeach;?>
        </aside><!-- end single widget -->
        <aside class="widget news-letter"><!-- start single widget -->
            <h3 class="widget-title text-uppercase">Подписка на обновления</h3>
            <p>Подпишись на обновления и узнай первым о новых статьях, обзорах и инструкциях.</p>
            <form id="subscribe-form" action="#">
                <input type="email" id="subscribe-email" placeholder="Ваш e-mail" required>
                <input type="submit" value="Подписаться" class="text-uppercase text-center btn btn-subscribe">
            </form>
        </aside><!-- end single widget -->
        <aside class="widget p-post-widget">
            <h3 class="widget-title text-uppercase">Последние посты</h3>
            <?php foreach ($posts as $post):?>
                <div class="popular-post">
                    <a href="/post/<?= $post->id?>" class="popular-img"><img src="../<?=$post->image?>" alt="<?=$post->title?>">
                        <div class="p-overlay"></div>
                    </a>
                    <div class="p-content">
                        <a href="/post/<?= $post->id?>"><?=$post->title?></a>
                        <span class="p-date"><?= $post->getTimeString() ?></span>
                    </div>
                </div>
            <?php endforeach;?>
        </aside>
        <aside class="widget"><!-- start single widget -->
            <div class="social-share">
                <h3 class="widget-title text-uppercase">Мы в соцсетях</h3>
                <ul class="">
                    <li><a class="s-vk" href="<?= Yii::$app->params['linkVk'] ?>"><i class="fa fa-vk"></i></a></li>
                    <li><a class="s-odnoklassniki" href="<?= Yii::$app->params['linkOk'] ?>"><i class="fa fa-odnoklassniki"></i></a></li>
                    <li><a class="s-facebook" href="<?= Yii::$app->params['linkFb'] ?>"><i class="fa fa-facebook"></i></a></li>
                    <li><a class="s-youtube" href="<?= Yii::$app->params['linkYt'] ?>"><i class="fa fa-youtube-play"></i></a></li>
                </ul>
            </div>
        </aside><!-- end single widget -->
        <aside class="widget category-post-no"><!-- start single widget -->
            <h3 class="widget-title text-uppercase">Категории</h3>
            <ul>
                <?php foreach ($categories as $category):?>
                    <li>
                        <a href="/category/<?= $category->id ?>"><?= $category->description ?></a>
                        <span class="post-count pull-right"> <?= count($category->activePosts);?> </span>
                    </li>
                <?php endforeach;?>
            </ul>
        </aside><!-- end single widget -->
    </div>
    <!-- end sidebar -->
</div>