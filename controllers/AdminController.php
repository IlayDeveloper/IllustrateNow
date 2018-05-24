<?php

namespace app\controllers;

use app\models\forms\PostForm;
use app\models\Role;
use app\models\User;
use Yii;
use app\models\Post;
use app\models\search\PostSearch;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * AdminController implements the CRUD actions for Post model.
 */
class AdminController extends Controller
{
    public $layout = 'admin_main';
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->checkAdmin();
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $pages = $dataProvider->getPagination();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'pages' => $pages
        ]);
    }

    /**
     * Displays a single Post model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $this->checkAdmin();
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->checkAdmin();
        $model = new PostForm();
        $model->scenario = PostForm::SCENARIO_CREATE;
        if(Yii::$app->request->post()){
            $model->load(Yii::$app->request->post());
            $model->main_picture = UploadedFile::getInstance($model, 'main_picture');
            if ($model->validate() && $post = $model->addNewPost()) {
                return $this->redirect(['view', 'id' => $post->id]);
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $this->checkAdmin();
        $model = new PostForm();
        $model->scenario = PostForm::SCENARIO_UPDATE;
        $post = $this->findModel($id);
        if(Yii::$app->request->post()){
            $model->load(Yii::$app->request->post());
            $model->main_picture = UploadedFile::getInstance($model, 'main_picture');
            if ($model->validate() && $post = $model->updatePost($post)) {
                return $this->redirect(['view', 'id' => $post->id]);
            }
        }
        $model->attributes = $post->getAttributes();

        return $this->render('update', [
            'model' => $model,
            'post' => $post,
        ]);
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->checkAdmin();
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @return bool|\yii\web\Response
     */
    protected function checkAdmin()
    {
        $user = Yii::$app->user->getIdentity();
        if (! $user instanceof User || $user->role_id !== Role::ROLE_ADMIN){
            return $this->goHome();
        }
        return true;
    }
}
