<?php
/* @var $this CamVendorController */
/* @var $model CamVendor */

$this->breadcrumbs=array(
	'Cam Vendors'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List CamVendor', 'url'=>array('index')),
	array('label'=>'Create CamVendor', 'url'=>array('create')),
	array('label'=>'Update CamVendor', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CamVendor', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CamVendor', 'url'=>array('admin')),
);
?>

<h1>View CamVendor #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
	),
)); ?>
