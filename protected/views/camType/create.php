<?php
/* @var $this CamTypeController */
/* @var $model CamType */

$this->breadcrumbs=array(
	'Cam Types'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CamType', 'url'=>array('index')),
	array('label'=>'Manage CamType', 'url'=>array('admin')),
);
?>

<h1>Create CamType</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>