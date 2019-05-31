<?php

class FilmController extends Controller
{
    public function actionIndex()
    {
        $criteria = new CDbCriteria();
        $count = Film::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 2;
        $pages->applyLimit($criteria);
        $films = Film::model()->findAll($criteria);
        $this->render('index', ['films' => $films, 'pages' => $pages]);
    }

    public function actionShow($id)
    {
        $film = Film::model()->with('seeder', 'comments.author')->findByPk($id);
        $this->render('show', ['film' => $film]);
    }
}
