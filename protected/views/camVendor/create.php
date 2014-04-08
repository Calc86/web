<?php
/* @var $this CamVendorController */
/* @var $model CamVendor */

$this->breadcrumbs=array(
	'Cam Vendors'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CamVendor', 'url'=>array('index')),
	array('label'=>'Manage CamVendor', 'url'=>array('admin')),
);
?>

<h1>Create CamVendor</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>