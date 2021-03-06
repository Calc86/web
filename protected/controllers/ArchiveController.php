<?php

class ArchiveController extends Controller
{
    const GET_CAM_ID = 'cam_id';
    const GET_MONTH = 'month';
    const GET_YEAR = 'year';
    const GET_DAY = 'day';

    public function init(){
        Helper::useLkTheme();
    }

	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2logo';

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
				'actions'=>array('cal','index','view','file','stream'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('admin','create','update'),
				'users'=>array('@'),
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
			'model'=> $this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Archive;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Archive']))
		{
			$model->attributes=$_POST['Archive'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
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

		if(isset($_POST['Archive']))
		{
			$model->attributes=$_POST['Archive'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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
     * @param $camID
     * @return Cam|null
     */
    private function getCamSoft($camID){
        $cam = Cam::model()->findByPk($camID);
        return $cam;
    }

    /**
     * @param $camID
     * @return Cam
     * @throws CHttpException
     */
    private function getCamHard($camID){
        $cam = $this->getCamSoft($camID);
        if($cam == null) throw new CHttpException(403, "Access denied");
        return $cam;
    }

    /**
     * @param $cam
     * @param $month
     * @param $year
     * @return CDbCriteria
     */
    private function getCalendarCriteria($cam, $month, $year){

        $start = mktime(0, 0, 0, $month,   1, $year);
        $end =   mktime(0, 0, 0, $month+1, 1, $year);

        $criteria = new CDbCriteria();
        $criteria->distinct = true;
        $criteria->select = new CDbExpression("DATE_FORMAT(FROM_UNIXTIME(date_start),'%e') as day");
        $criteria->addCondition("cam_id=$cam->id");
        $criteria->addBetweenCondition('date_start', $start, $end);
        $criteria->addCondition("rebuilded='yes'");
        return $criteria;
    }

    public function actionCal($cam_id, $month = 0, $year = 0)
    {
        $cam = $this->getCamHard($cam_id);

        $month = (int) $month;
        $year = (int) $year;

        if(!is_numeric($year)  || !$year) $year = (int) date('Y');
        if(!is_numeric($month) || !$month) $month = (int) date('m');

        $dataProvider=new CActiveDataProvider('Archive',
            array(
                'criteria'=>$this->getCalendarCriteria($cam, $month, $year),
                'pagination'=>false
            )
        );

        //список дней для которых есть архивы
        $days = array();
        foreach($dataProvider->getData() as $archive){
            $days[$archive->day] = 1;
        }

        $this->render('cal',array(
            'dataProvider'=>$dataProvider,
            'cam'=>$cam,
            'year'=>$year,
            'month'=>$month,
            'days'=>$days,
        ));
    }

	/**
	 * Lists all models.
	 */
	public function actionIndex($cam_id, $year, $month, $day)
	{
        $cam = $this->getCamHard($cam_id);

        $archive=new Archive('search');
        $archive->unsetAttributes();  // clear any default values
        $archive->cam_id = $cam->id;

        //параметры поиска, через ajax-get
        if(isset($_GET['Archive']))
            $archive->attributes=$_GET['Archive'];

        $this->render('index/main',array(
            'cam' => $cam,
            'archive' => $archive,
            'year' => $year,
            'month' => $month,
            'day' => $day,
        ));
	}

    public function getFile($path){
        $file = str_replace('/home/vlc/vlc','',$path);
        $file = str_replace('/home/vlc/web','',$path);
        return $file;
    }

    public function getUrl($id){
        $model = $this->loadModel($id);
        $file = $model->pathMp4();
        if(!$file) $file = $model->pathAvi();
        $file = str_replace('/home/vlc/vlc','',$file);
        $file = str_replace('/home/vlc/web','',$file);
        $file = str_replace('/home/vlc/vlc','',$file);
        $file = str_replace('/home/vlc/dvr','',$file);
        $file = str_replace('/home/vlc/mount','',$file);

        //$file = str_replace('.mp4','',$file);
        //return $file;
        return MyConfig::getNginxArchiveUrl($file);
    }

    public function getDownloadUrl($id){
        $model = $this->loadModel($id);
        $file = $model->pathMp4();
        if(!$file) $file = $model->pathAvi();
        $size = filesize($file);
        $file = str_replace('/home/vlc/vlc','',$file);
        $file = str_replace('/home/vlc/web','',$file);

        //return $file;
        $id = "$file&size=$size&name=".basename($file);
        return MyConfig::getNginxArchiveUrl($id, 1);
    }

    //Пусть пока будет обычным скачиванем файликов
    public function actionFile($id){
        /*$this->render('file',array(
            'model'=>$this->loadModel($id),
        ));*/

        $model = $this->loadModel($id);
        /*$mp4 = realpath($model->file.'.mp4');
        if(!$mp4){
            $cmd = "ffmpeg -fflags +genpts -i {$model->file}.avi -codec copy {$model->file}.mp4 >> /dev/null";
            exec($cmd);
        }*/

        // todo: перенести логику на сторону модели
        $file = $model->pathMp4();
        if(!$file) $file = $model->pathAvi();


        //echo filesize($file);
        //exit();
        if ($file) {
            // сбрасываем буфер вывода PHP, чтобы избежать переполнения памяти выделенной под скрипт
            // если этого не сделать файл будет читаться в память полностью!
            if (ob_get_level()) {
                ob_end_clean();
            }

            // заставляем браузер показать окно сохранения файла
            //header('Content-Description: File Transfer');
            //echo $this->getUrl($id);
            header('X-Accel-Redirect: ' .  $this->getUrl($id));
            header('Content-Type: application/octet-stream');
            //header('Content-Type: video/mp4');
            header('Content-Disposition: attachment; filename=' . basename($file));
            /*header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));*/
            // читаем файл и отправляем его пользователю
            //header("Location: ".$this->getUrl($id));
            //readfile($file);
            //exit;
        }
        else
        {
            echo 'Файл не найден';
        }
    }

	/**
	 * Manages all models.
	 */
	/*public function actionAdmin()
	{
		$model=new Archive('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Archive']))
			$model->attributes=$_GET['Archive'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}*/

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Archive the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
        /** @var Archive $model */
		$model=Archive::model()->findByPk($id);
		if($model === null)
			throw new CHttpException(404,'The requested page does not exist.');
        $this->getCamHard($model->cam_id);

		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Archive $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='archive-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
