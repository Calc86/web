<?php
/* @var $this ZoneController */
/* @var $model Zone */

$this->breadcrumbs=array(
	'Zones'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Zone', 'url'=>array('index')),
	array('label'=>'Create Zone', 'url'=>array('create')),
	array('label'=>'Update Zone', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Zone', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Zone', 'url'=>array('admin')),
);
?>

<h1>View Zone #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'user_id',
		'name',
	),
)); ?>
