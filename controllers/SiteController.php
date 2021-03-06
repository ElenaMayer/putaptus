<?php

namespace app\controllers;

use amilna\blog\models\BlogCatPos;
use amilna\blog\models\Category;
use amilna\blog\models\Post;
use amilna\blog\models\Comment;
use app\models\Subscription;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\sphinx\Query;
use yii\data\Pagination;

class SiteController extends Controller
{

    public $lastPosts;
    public $popularPosts;
    public $tags;
    public $categories;

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

    public function beforeAction($action)
    {

        if (!parent::beforeAction($action)) {
            return false;
        }

        $post = new Post;
        $this->tags = $post->getTags();
        $this->lastPosts = $post::find()->where(['status' => 1])->orderBy(['time'=>SORT_DESC])->limit(5)->all();
        $this->popularPosts = $post::find()->where(['status' => 1, 'isfeatured' => 1])->orderBy(['time'=>SORT_DESC])->limit(5)->all();
        $this->categories = Category::find()->all();

        return true;
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

        $query = Post::find()->where(['status' => 1]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => Yii::$app->params['pageLimit']]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->orderBy(['time'=>SORT_DESC])
            ->all();

        return $this->render('index', [
                'posts' => $models,
                'lastPosts' => $this->lastPosts,
                'popularPosts' => $this->popularPosts,
                'categories' => $this->categories,
                'tags' => $this->tags,
                'pages' => $pages,
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
        $query = Post::find()
            ->joinWith('blogCatPos', false)
            ->where(['status' => 1, BlogCatPos::tableName().'.category_id' => $id, BlogCatPos::tableName().'.isdel' => 0]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => Yii::$app->params['pageLimit']]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->orderBy(['time'=>SORT_DESC])
            ->all();

        return $this->render('category', [
                'lastPosts' => $this->lastPosts,
                'popularPosts' => $this->popularPosts,
                'categories' => $this->categories,
                'tags' => $this->tags,
                'category' => Category::findOne($id),
                'postByCategory' => $models,
                'pages' => $pages,
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

        $query = Post::find()->where(['status' => 1])->andFilterWhere(['like', 'tags', $tag]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => Yii::$app->params['pageLimit']]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->orderBy(['time'=>SORT_DESC])
            ->all();

        return $this->render('tag', [
                'lastPosts' => $this->lastPosts,
                'popularPosts' => $this->popularPosts,
                'categories' => $this->categories,
                'tags' => $this->tags,
                'postsByTag' => $models,
                'tag' => $tag,
                'pages' => $pages,
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
        $post = Post::findOne($id);

        return $this->render('post', [
                'lastPosts' => $this->lastPosts,
                'popularPosts' => $this->popularPosts,
                'categories' => $this->categories,
                'tags' => $this->tags,
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

        return $this->render('search', [
                'lastPosts' => $this->lastPosts,
                'popularPosts' => $this->popularPosts,
                'categories' => $this->categories,
                'tags' => $this->tags,
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
