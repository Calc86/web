<?php

class CamController extends Controller
{

    public function init(){
        Yii::app()->theme = 'lk';
    }

	public function actionArchive()
	{
		$this->render('archive');
	}

	public function actionBalans()
	{
		$this->render('balans');
	}

	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionNews()
	{
		$this->render('news');
	}

	public function actionRecord()
	{
		$this->render('record');
	}

	public function actionSettings()
	{
		$this->render('settings');
	}

    public function actionLive()
    {
        $this->render('live');
    }

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}