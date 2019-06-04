<?php

class CommentsController extends Controller
{
    const PER_PAGE = 2;

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
            [
                'allow',
                'actions' => ['create','update', 'index','view', 'delete'],
                'users' => ['@'],
            ],
            [
                'allow',
                'actions' => ['admin'],
                'expression' => $isAdmin,
            ],
            [
                'deny',
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
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if (isset($_POST['Comment'])) {
            $model->attributes = $_POST['Comment'];
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
        $this->loadModel($id)->delete();

        if (!isset($_GET['ajax'])) {
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
            'pagination' => ['pageSize' => self::PER_PAGE],
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
        if (isset($_GET['Comments'])) {
            $model->attributes = $_GET['Comments'];
        }

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
    }

    /**
     * Performs the AJAX validation.
     * @param Comments $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'comments-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
