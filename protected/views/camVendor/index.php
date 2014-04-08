<?php
/* @var $this CamVendorController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Cam Vendors',
);

$this->menu=array(
	array('label'=>'Create CamVendor', 'url'=>array('create')),
	array('label'=>'Manage CamVendor', 'url'=>array('admin')),
);
?>

<h1>Cam Vendors</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
