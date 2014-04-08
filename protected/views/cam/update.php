<?php
/* @var $this CamController */
/* @var $model Cam */

$this->breadcrumbs=array(
	'Cams'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Cam', 'url'=>array('index')),
	array('label'=>'Create Cam', 'url'=>array('create')),
	array('label'=>'View Cam', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Cam', 'url'=>array('admin')),
);
?>

<h1>Update Cam <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>