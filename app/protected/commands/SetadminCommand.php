<?php

class SetadminCommand extends CConsoleCommand
{
    const ADMIN = 'admin';

    public function actionIndex($id)
    {
        $conn = Yii::app()->db;
        $conn->active = true;

        $command = $conn
            ->createCommand()
            ->update('tbl_users', ['role' => self::ADMIN], 'id=:user_id', ['user_id' => $id]);
    }
}
