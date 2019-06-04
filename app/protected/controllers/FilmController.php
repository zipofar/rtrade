<?php

class FilmController extends Controller
{
    const PER_PAGE = 10;

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return [
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        ];
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        $isAdmin = function ($user, $rule) {
            return $user->getState('isAdmin');
        };

        return [
            ['allow', // allow authenticated user to perform 'create' and 'update' actions
            'actions' => ['create','update', 'index','view', 'delete'],
            'users' => ['@'],
            ],
            ['allow', // allow admin user to perform 'admin' and 'delete' actions
            'actions' => ['admin'],
            'expression' => $isAdmin,
            ],
            ['deny',  // deny all users
            'users' => ['*'],
            ],
        ];
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render('view', ['model' => $this->loadModel($id)]);
    }

    /**
     * Creates a new model.
     */
    public function actionCreate()
    {
        $model = new Film();

        if (isset($_POST['Film'])) {
            $model->attributes = $_POST['Film'];
            $model->user_id = Yii::app()->user->getId();
            if ($model->save()) {
                $this->redirect(['view','id' => $model->id]);
            }
        }

        $this->render('create', ['model' => $model]);
    }

    /**
     * Updates a particular model.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if (isset($_POST['Film'])) {
            $model->attributes = $_POST['Film'];
            if ($model->save()) {
                $this->redirect(['view','id' => $model->id]);
            }
        }

        $this->render('update', ['model' => $model]);
    }

    /**
     * Deletes a particular model.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $film = $this->loadModel($id);
        $comments = Comment::model()->findAll('film_id=:film_id', ['film_id' => $id]);
        foreach ($comments as $comment) {
            $comment->delete();
        }
        $this->loadModel($id)->delete();
        $this->redirect(['film/index']);
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $userId = Yii::app()->user->getId();

        $criteria = new CDbCriteria();
        $criteria->condition = 'user_id=:userId';
        $criteria->params = [':userId' => $userId];

        $count = Film::model()->count($criteria);

        $pages = new CPagination($count);
        $pages->pageSize = self::PER_PAGE;
        $pages->applyLimit($criteria);

        $films = Film::model()->findAll($criteria);
        $this->render('index', ['films' => $films, 'pages' => $pages]);
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Film('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Film'])) {
            $model->attributes = $_GET['Film'];
        }

        $this->render('admin', ['model' => $model]);
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Film the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Film::model()->findByPk($id);
        $userId = Yii::app()->user->getId();
        $userIsAdmin = Yii::app()->user->getState('isAdmin');
        $userIsOwnerThisRecord = $model->user_id === $userId;

        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }

        if ($userIsOwnerThisRecord || $userIsAdmin) {
            return $model;
        }

        throw new CHttpException(403, 'The requested page is forbidden.');
    }
}
