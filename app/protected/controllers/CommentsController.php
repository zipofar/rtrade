<?php

class CommentsController extends Controller
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
        $model = new Comment();

        if (isset($_POST['Comment'])) {
            $model->attributes = $_POST['Comment'];
            $model->user_id = Yii::app()->user->getId();
            if ($model->save()) {
                $this->redirect(['site/view', 'id' => $_POST['Comment']['film_id']]);
            }
        }

        $this->redirect(['site/index']);
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['Comment']))
        {
            $model->attributes = $_POST['Comment'];
            if($model->save())
                $this->redirect(array('view','id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            //$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            $this->redirect(['comments/index']);

        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $userId = Yii::app()->user->getId();
        $criteria = new CDbCriteria();
        $criteria->condition = 't.user_id=:userId';
        $criteria->params = [':userId' => $userId];
        $criteria->with = 'film';

        $dataProvider = new CActiveDataProvider('Comment', [
            'criteria' => $criteria,
            'pagination' => ['pageSize' => 2],
        ]);
        $comments = $dataProvider->getData();
        $pages = $dataProvider->getPagination();
        $this->render('index', ['comments' => $comments, 'pages' => $pages]);
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Comment('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Comments']))
            $model->attributes = $_GET['Comments'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Comments the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Comment::model()->findByPk($id);
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
        /*
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
         */
    }

    /**
     * Performs the AJAX validation.
     * @param Comments $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='comments-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
