<?php

class FilmController extends Controller
{
	public function actionIndex()
	{
        $films = Film::model()->findAll();
		$this->render('index', ['films' => $films]);
	}

    public function actionShow($id)
    {
        $film = Film::model()->findByPk($id);
		$this->render('show', ['film' => $film]);
    }
}
