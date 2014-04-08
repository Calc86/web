<?php
/* @var $this CamVendorController */
/* @var $model CamVendor */

$this->breadcrumbs=array(
	'Cam Vendors'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CamVendor', 'url'=>array('index')),
	array('label'=>'Create CamVendor', 'url'=>array('create')),
	array('label'=>'View CamVendor', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CamVendor', 'url'=>array('admin')),
);
?>

<h1>Update CamVendor <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>