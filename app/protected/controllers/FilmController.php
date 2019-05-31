<?php

class FilmController extends Controller
{
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
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
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

        return array(
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
            'actions' => array('create','update', 'index','view', 'delete'),
            'users' => array('@'),
        ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
            'actions' => array('admin'),
            'expression' => $isAdmin,
        ),
            array('deny',  // deny all users
            'users' => array('*'),
        ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new Film();

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Film'])) {
            $model->attributes = $_POST['Film'];
            $model->user_id = Yii::app()->user->getId();
            if ($model->save()) {
                $this->redirect(array('view','id' => $model->id));
            }
        }

        $this->render('create', ['model' => $model]);
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if (isset($_POST['Film'])) {
            $model->attributes = $_POST['Film'];
            if ($model->save()) {
                $this->redirect(array('view','id' => $model->id));
            }
        }

        $this->render('update', ['model' => $model]);
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();
        $this->redirect(Yii::app()->user->returnUrl);
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
        $pages->pageSize = 2;
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
