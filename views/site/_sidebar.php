<div class="col-md-4">
    <!-- start sidebar -->
    <div class="sidebar">

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

        <aside class="widget"><!-- start single widget -->
            <h3 class="widget-title text-uppercase">Популярные посты</h3>
            <?php foreach ($popularPosts as $pPost):?>
                <div class="thumb-latest-posts">
                    <div class="media">
                        <div class="media-left">
                            <a href="/post/<?= $pPost->id?>" class="popular-img"><img src="../<?=$pPost->image?>" alt="<?=$pPost->image?>">
                                <div class="p-overlay"></div>
                            </a>
                        </div>
                        <div class="p-content">
                            <h3><a href="/post/<?= $pPost->id?>"><?=$pPost->title?></a></h3>
                            <span class="p-date"><?= $pPost->getTimeString() ?></span>
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
                <a href="/tag/<?= $tag ?>"><?= $tag ?></a>
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
        <aside class="widget p-post-widget">
            <h3 class="widget-title text-uppercase">Последние посты</h3>
            <?php foreach ($lastPosts as $lPost):?>
                <div class="popular-post">
                    <a href="/post/<?= $lPost->id?>" class="popular-img"><img src="../<?=$lPost->image?>" alt="<?=$lPost->title?>">
                        <div class="p-overlay"></div>
                    </a>
                    <div class="p-content">
                        <a href="/post/<?= $lPost->id?>"><?=$lPost->title?></a>
                        <span class="p-date"><?= $lPost->getTimeString() ?></span>
                    </div>
                </div>
            <?php endforeach;?>
        </aside>
    </div>
    <!-- end sidebar -->
</div>