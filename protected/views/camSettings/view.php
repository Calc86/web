<?php
/* @var $this CamSettingsController */
/* @var $model CamSettings */

$this->breadcrumbs=array(
	'Cam Settings'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List CamSettings', 'url'=>array('index')),
	array('label'=>'Create CamSettings', 'url'=>array('create')),
	array('label'=>'Update CamSettings', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CamSettings', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CamSettings', 'url'=>array('admin')),
);
?>

<h1>View CamSettings #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'cam_id',
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
		'stop_width',
		'stop_height',
	),
)); ?>
