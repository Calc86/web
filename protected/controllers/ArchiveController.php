<?php

class ArchiveController extends Controller
{
    public function init(){
        Yii::app()->theme = 'lk';
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
			'model'=>$this->loadModel($id),
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


    public function actionCal($cid,$m=0,$y=0)
    {
        //TODO: Сделать проверку на int и изменения значений
        if(!$y) $y = (int) date('Y');
        if(!$m) $m = (int) date('m');

        $start = mktime(0, 0, 0, $m, 1, $y);
        $end =   mktime(0, 0, 0, $m+1, 1, $y);

        $criteria = new CDbCriteria();
        $criteria->distinct = true;
        $criteria->select = new CDbExpression("DATE_FORMAT(FROM_UNIXTIME(date_start),'%e') as day");
        $criteria->addCondition("cam_id=$cid");
        $criteria->addBetweenCondition('date_start',$start,$end);
        $criteria->addCondition("rebuilded='yes'");

        $dataProvider=new CActiveDataProvider('Archive',
            array(
                'criteria'=>$criteria,
                'pagination'=>false
            )
        );

        $this->render('cal',array(
            'dataProvider'=>$dataProvider,
            'cid'=>$cid,
            'year'=>$y,
            'month'=>$m
        ));
    }

	/**
	 * Lists all models.
	 */
	public function actionIndex($cid,$y,$m,$d)
	{

        $model=new Archive('search');
        $model->unsetAttributes();  // clear any default values
        $model->cam_id = $cid;

        //параметры поиска
        if(isset($_GET['Archive']))
            $model->attributes=$_GET['Archive'];

        $this->render('index1',array(
            'model'=>$model,
            'y'=>$y,
            'm'=>$m,
            'd'=>$d,
        ));
        return;
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
        $file = str_replace('/home/vlc/vlc/rec','',$file);
        $file = str_replace('/home/vlc/web/rec','',$file);
        //return $file;
        return MyConfig::getNginxArchiveUrl($file);
    }

    public function getDownloadUrl($id){
        $model = $this->loadModel($id);
        $file = $model->pathMp4();
        if(!$file) $file = $model->pathAvi();
        $size = filesize($file);
        $file = str_replace('/home/vlc/vlc/rec','',$file);
        $file = str_replace('/home/vlc/web/rec','',$file);

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
	public function actionAdmin()
	{
		$model=new Archive('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Archive']))
			$model->attributes=$_GET['Archive'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Archive the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Archive::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
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
