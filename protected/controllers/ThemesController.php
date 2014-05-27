<?php

class ThemesController extends Controller
{
	public function actionLk()
	{
        /** @var CWebApplication $app */
        $app = Yii::app();
        $app->theme = 'lk';
		$this->render('lk');
	}

	public function actionMain()
	{
        /** @var CWebApplication $app */
        $app = Yii::app();
        $app->theme = 'main';
		$this->render('main');
	}

    public function actionMain1()
    {
        /** @var CWebApplication $app */
        $app = Yii::app();
        $app->theme = 'main';
        $this->render('main1');
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