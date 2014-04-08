<?php
/* @var $this CamTypeController */
/* @var $model CamType */

$this->breadcrumbs=array(
	'Cam Types'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List CamType', 'url'=>array('index')),
	array('label'=>'Create CamType', 'url'=>array('create')),
	array('label'=>'Update CamType', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CamType', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CamType', 'url'=>array('admin')),
);
?>

<h1>View CamType #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'vendor_id',
		'name',
		'live_auth',
		'live_user',
		'live_pass',
		'live_proto',
		'live_port',
		'live_path',
		'live_width',
		'live_height',
		'live_audio',
		'stop_auth',
		'stop_user',
		'stop_pass',
		'stop_proto',
		'stop_port',
		'stop_path',
		'ispy_url',
		'comment',
	),
)); ?>
