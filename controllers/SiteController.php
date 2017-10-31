<?php

namespace app\controllers;

use amilna\blog\models\Category;
use amilna\blog\models\Post;
use amilna\blog\models\Comment;
use app\models\Subscription;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\sphinx\Query;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $posts = new Post;
        $tags = $posts->getTags();
        $posts = $posts::find()->where(['status' => 1])->orderBy(['time'=>SORT_DESC])->limit(5)->all();
        $categories = Category::find()->all();
        return $this->render('index', [
                'posts' => $posts,
                'categories' => $categories,
                'tags' => $tags,
            ]
        );
    }

    /**
     * Displays category page.
     *
     * @return string
     */
    public function actionCategory($id)
    {
        $posts = new Post;
        $tags = $posts->getTags();
        $posts = $posts::find()->where(['status' => 1])->orderBy(['time'=>SORT_DESC])->limit(5)->all();
        $categories = Category::find()->all();

        $category = Category::findOne($id);
        return $this->render('category', [
                'posts' => $posts,
                'categories' => $categories,
                'tags' => $tags,
                'category' => $category,
                'postByCategory' => $category->activePosts,
            ]
        );
    }

    /**
     * Displays tag page.
     *
     * @return string
     */
    public function actionTag($tag)
    {
        $posts = new Post;
        $tags = $posts->getTags();
        $posts = $posts::find()->where(['status' => 1])->orderBy(['time'=>SORT_DESC])->limit(5)->all();
        $categories = Category::find()->all();

        $postsByTag = Post::find()->where(['status' => 1])->andFilterWhere(['like', 'tags', $tag])
            ->all();
        return $this->render('tag', [
                'posts' => $posts,
                'categories' => $categories,
                'tags' => $tags,
                'postsByTag' => $postsByTag,
                'tag' => $tag,
            ]
        );
    }

    /**
     * Displays post page.
     *
     * @return string
     */
    public function actionPost($id)
    {
        $posts = new Post;
        $tags = $posts->getTags();
        $posts = $posts::find()->where(['status' => 1])->orderBy(['time'=>SORT_DESC])->limit(5)->all();
        $categories = Category::find()->all();

        $post = Post::findOne($id);
        return $this->render('post', [
                'posts' => $posts,
                'categories' => $categories,
                'tags' => $tags,
                'post' => $post,
            ]
        );
    }

    //ajax
    public function actionAddcomment()
    {
        $model = new Comment();
        $model->time = date("Y-m-d H:i:s");
        $model->author_id = Yii::$app->user->id;

        if (Yii::$app->request->post())
        {
            $post = Yii::$app->request->post();
            if (isset($post['post_id']))
            {
                $post_id = $post['post_id'];
                $model->post_id = $post_id;
            }

            if (isset($post['comment']))
            {
                $model->comment = $post['comment'];
            }

            if (isset($post['parent_id']) && $post['parent_id'] != 0)
            {
                $model->parent_id = $post['parent_id'];
            }
            $transaction = Yii::$app->db->beginTransaction();
            try {

                if ($model->save()) {
                    $post = Post::findOne($post_id);
                    $transaction->commit();
                    echo $this->renderAjax('_comments', [
                        'comments' => $post->comments,
                        'new_comment' => $model
                    ]);
                } else {
                    $transaction->rollBack();
                }
            } catch (Exception $e) {
                $transaction->rollBack();
            }
        }
    }

    //ajax
    public function actionAddsubscription()
    {
        if (Yii::$app->request->post())
        {
            $post = Yii::$app->request->post();
            if (isset($post['email']))
            {
                $email = $post['email'];
                $model = Subscription::findOne(['email'=>$email]);
                if ($model){
                    echo "Вы уже подписаны на обновления!";
                } else {
                    $model = new Subscription();
                    $model->time = date("Y-m-d H:i:s");
                    $model->email = $email;
                    if(!Yii::$app->user->isGuest)
                        $model->user_id = Yii::$app->user->id;

                    $transaction = Yii::$app->db->beginTransaction();
                    try {
                        if ($model->save()) {
                            $transaction->commit();
                            echo "Спасибо! Вы подписаны на обновления!";
                        } else {
                            $transaction->rollBack();
                        }
                    } catch (Exception $e) {
                        $transaction->rollBack();
                    }
                }
            }
        }
    }

    public function actionSearch(){

        $q = Yii::$app->sphinx->escapeMatchValue($_GET['s']);
        $sql = "SELECT id, image, time_ts, SNIPPET(title, :q) as _title, SNIPPET(description, :q) AS _description, SNIPPET(content, :q) AS _content FROM shopsgidindex WHERE MATCH(:q)";
        $rows = Yii::$app->sphinx->createCommand($sql)
            ->bindValue('q', $q)
            ->queryAll();

        $snippets = [];
        foreach ($rows as $row) {
            $snippets[$row['id']] = ['title' => $row['_title'], 'description' => $row['_description'], 'content' => $row['_content'], 'time' => $row['time_ts'], 'image' => $row['image']];
        }

//        print_r($snippets);die();

//        $query = new Query();
//        $rows = $query->from('shopsgidindex')
//            ->match($_GET['s'])
//            ->all();
//        print_r($rows);die();

        $posts = new Post;
        $tags = $posts->getTags();
        $posts = $posts::find()->where(['status' => 1])->orderBy(['time'=>SORT_DESC])->limit(5)->all();
        $categories = Category::find()->all();

        return $this->render('search', [
                'posts' => $posts,
                'categories' => $categories,
                'tags' => $tags,
                'snippets' => $snippets,
            ]
        );
    }

    public static function getTimeString($time){
        $res = date("d ", $time);
        $month = date("n", $time);
        switch ($month){
            case 1: $res.='января';break;
            case 2: $res.='февраля';break;
            case 3: $res.='марта';break;
            case 4: $res.='апреля';break;
            case 5: $res.='мая';break;
            case 6: $res.='июня';break;
            case 7: $res.='июля';break;
            case 8: $res.='августа';break;
            case 9: $res.='сентября';break;
            case 10: $res.='октября';break;
            case 11: $res.='ноября';break;
            case 12: $res.='декабря';break;
        }
        $res .= date(" Y", $time);
        return $res;
    }
}
