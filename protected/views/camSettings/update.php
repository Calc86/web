<?php
/* @var $this CamSettingsController */
/* @var $model CamSettings */

$this->breadcrumbs=array(
	'Cam Settings'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CamSettings', 'url'=>array('index')),
	array('label'=>'Create CamSettings', 'url'=>array('create')),
	array('label'=>'View CamSettings', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CamSettings', 'url'=>array('admin')),
);
?>

<h1>Update CamSettings <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>