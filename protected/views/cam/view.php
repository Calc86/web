<?php
/* @var $this CamController */
/* @var $model Cam */

$this->breadcrumbs=array(
	'Cams'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Cam', 'url'=>array('index')),
	array('label'=>'Create Cam', 'url'=>array('create')),
	array('label'=>'Update Cam', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Cam', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Cam', 'url'=>array('admin')),
);
?>

<h1>View Cam #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'zone_id',
		'user_id',
		'name',
		'order',
	),
)); ?>
