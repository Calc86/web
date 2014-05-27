<?php

class SiteController extends Controller
{
    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha'=>array(
                'class'=>'CCaptchaAction',
                'backColor'=>0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page'=>array(
                'class'=>'CViewAction',
            ),
        );
    }

    private function loadMain(){
        $criteria = new CDbCriteria();
        //$criteria->limit = 1;
        $criteria->order = 'dtc DESC';

        $blocks = array(
            //'main_block',
            'main_col1',
            'main_col2',
            'main_col3',
            'main_about',
            'main_contact',
        );

        $main = array();

        foreach($blocks as $block){
            $c = clone $criteria;
            $c->addCondition("alias='$block'");
            $main[$block] = Pages::model()->find($c);
        }

        return $main;
    }

    public function actionAbout(){
        $this->render('alias',array(
            'main'=>$this->loadMain(),
            'alias'=>'main_about'
        ));
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex()
    {
		$this->render('index',array(
            'main'=>$this->loadMain(),
        ));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		/*$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));*/
        $this->render('alias',array(
            'main'=>$this->loadMain(),
            'alias'=>'main_contact'
        ));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
        /** @var CWebApplication $app */
        $app = Yii::app();

		$model = new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			$app->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect($app->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
        /** @var CWebApplication $app */
        $app = Yii::app();
		$app->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

    public function actionRoles(){
        /** @var CWebApplication $app */
        $app = Yii::app();

        if($app->user->checkAccess('installRoles'))
            throw new CHttpException(403,'Forbidden');

        $auth = $app->authManager;
        /* @var $auth PhpAuthManager */

        $auth->clearAll();

        $bizRule = 'return Yii::app()->user->id == $params["user"]->id;';
        $auth->createOperation('createUser','создание пользователя');
        $auth->createOperation('viewUser','просмотр пользователя');
        $task = $auth->createTask('viewOwnUser','просмотр своего пользователя',$bizRule);
        $task->addChild('viewUser');
        $auth->createOperation('updateUser','изменение пользователя');
        $auth->createOperation('updateOwnUser','изменение своего пользователя');
        $auth->createOperation('deleteUser','удаление пользователя');
        $auth->createOperation('changeRole','изменение роли пользователя');
        $auth->createOperation('installRoles','Запуск установщика правил пользователей');


        $role = $auth->createRole('guest');

        $role = $auth->createRole('user');
        $role->addChild('viewOwnUser');
        $role->addChild('updateOwnUser');

        $role = $auth->createRole('moderator');
        $role->addChild('user');
        $role->addChild('viewUser');
        $role->addChild('updateUser');

        $role = $auth->createRole('admin');
        $role->addChild('moderator');
        $role->addChild('createUser');
        $role->addChild('changeRole');
        $role->addChild('deleteUser');
        $role->addChild('installRoles');

        $auth->save();

        $this->render('roles');
    }
}