<?php

/**
 * This is the model class for table "tbl_user".
 *
 * The followings are the available columns in table 'tbl_user':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 */
class Film extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_films';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
        return [
            ['name, description', 'required'],
            ['name', 'length', 'max' => 128],
        ];
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
        return [
            'author' => [self::BELONGS_TO, 'User', 'user_id'],
        ];
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
