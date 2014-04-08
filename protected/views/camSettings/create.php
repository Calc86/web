<?php
/* @var $this CamSettingsController */
/* @var $model CamSettings */

$this->breadcrumbs=array(
	'Cam Settings'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CamSettings', 'url'=>array('index')),
	array('label'=>'Manage CamSettings', 'url'=>array('admin')),
);
?>

<h1>Create CamSettings</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>