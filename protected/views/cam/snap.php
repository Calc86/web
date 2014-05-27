<?php

/* @var $this Controller
 * @var $id Cam
 */

/** @var CWebApplication $app */
$app = Yii::app();
$app->theme = 'blank';

$this->layout = 'blank';


//Yii::app()->session['cam_id'] = $id;
//$frame = new CamFrame($cs);
$frame = new CamFrame(new CamSettings());
echo $frame->live('m_snap', 'snap');

//echo file_get_contents("http://localhost/".$url);

//<img id="snap" src="<?=$url;">
