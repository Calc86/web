<?php

class CamController extends Controller
{
    const SES_PLUGIN = 'plugin';
    const SES_SOURCE = 'src';

    /* GET parameters */
    const GET_ID = 'id';
    const GET_TYPE = 'type';

    const CAM_ID = 'cam_id';

    const DEFAULT_VIEW = 'live';

    const PLUGIN_VLC = 'vlc_web_plugin';
    const PLUGIN_DEFAULT = self::PLUGIN_VLC;
    const PLUGIN_MJPEG_IMG = 'mjpeg_img';


	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='//layouts/column2columns';
    public $layout='//layouts/column2';

    public $cr_zones;

    public function init(){

        Helper::useLkTheme();

        $cr_zones = new CDbCriteria();
        /** @var CWebApplication $app */
        $app = Yii::app();
        $cr_zones->addCondition(array('user_id'=>$app->user->id));
        $cr_zones->addCondition(array('user_id'=>0),'OR');
    }

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
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','live','archive','balans','settings','news','snap','ajax', 'secure'),
				//'users'=>array('@'),
                'roles' => array('user'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				//'users'=>array('@'),
                'roles' => array('user'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

    public function actionSnap($id)
    {
        /*$id = Helper::getSesVar(__CLASS__, self::CAM_ID);*/
        $cam = Cam::model()->findByPk($id);
        if($cam != null)
            $this->render('snap', array('cam' => $cam));
        else
            throw new CHttpException(403, "Access denied");
    }

    public function actionAjax($id,$type){
        /** @var Cam $model */
        $model = Cam::model()->findByPk($id);
        $model->setScenario($type);
        echo $model->getScenario().' ';

        switch($type){
            case Cam::LIVE:
                $model->live = ($model->live) ? 0 : 1;
                $model->save();
                break;
            case Cam::RECORD:
                $model->rec = ($model->rec) ? 0 : 1;
                $model->save();
                break;
            case Cam::MOTION:
                $model->mtn = ($model->mtn) ? 0 : 1;
                $model->save();
                break;
        }
        echo $type.' done';
    }

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$cam = Cam::model();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Cam']))
		{
			$cam->attributes=$_POST['Cam'];
			if($cam->save())
				//$this->redirect(array('view','id'=>$model->id));
                $this->redirect(array(self::DEFAULT_VIEW));
		}

		$this->render('create',array(
			'model'=>$cam,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Cam']))
		{
			$model->attributes=$_POST['Cam'];
			if($model->save())
				//$this->redirect(array('view','id'=>$model->id));
                $this->redirect(array(self::DEFAULT_VIEW));
		}

		$this->render('update',array(
			'model'=>$model,
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
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Cam('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Cam']))
			$model->attributes=$_GET['Cam'];

		$this->render('admin',array(
			'model'=>$model,
		));
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

    /**
     * @return int
     */
    private function getFirstCamID(){
        $cam = new Cam('search');
        $cam->user_id = WebYii::app()->user->id;
        $data = $cam->search();
        if($data->itemCount > 0) return $data->data[0]->id;

        return 0;
    }

    /**
     * Проверяет, есть ли у этого пользователя такой ID
     * @param $camID
     * @return int
     */
    private function validateCamID($camID){
        if(Cam::model()->findByPk($camID) != null)
            return $camID;
        else
            return 0;
        // может тут вызывать 403?
    }

    public function actionLive($id = 0, $src = '', $plugin = '')
    {
        //if($id) $id = $this->validateCamID($id);
        if(!$id) $id = $this->getFirstCamID();

        if($plugin == '') $plugin = Helper::getSesVar(__CLASS__, self::SES_PLUGIN, self::PLUGIN_DEFAULT);
        Helper::setSesVar(__CLASS__, self::SES_PLUGIN, $plugin);

        if($src == '') $src = Helper::getSesVar(__CLASS__, self::SES_SOURCE, Cam::SOURCE_DEFAULT);
        Helper::setSesVar(__CLASS__, self::SES_SOURCE, $src);

        if($plugin == self::PLUGIN_MJPEG_IMG) $src = Cam::SOURCE_MOTION;

        /** @var Cam $cam */
        $cam = Cam::model('Cam')->findByPk($id);

        $frame = '';

        $frameName = 'frames/'.$plugin;
        if(!$this->getViewFile($frameName)){
            $frame = '';
        }
        else{
            if($cam != null)
                $frame = $this->renderPartial('frames/'.$plugin, array('source' => $cam->getVideoSource($src)), true);
        }

        $params = array('cam'=>$cam, 'src'=>$src, 'plugin'=>$plugin, 'frame' => $frame);
        $this->render('live/main', $params);
    }

    public function actionSecure(){
        $this->render('secure');
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Cam the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Cam::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Cam $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='cam-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
