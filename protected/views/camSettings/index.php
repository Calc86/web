<?php
/* @var $this CamSettingsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Cam Settings',
);

$this->menu=array(
	array('label'=>'Create CamSettings', 'url'=>array('create')),
	array('label'=>'Manage CamSettings', 'url'=>array('admin')),
);
?>

<h1>Cam Settings</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
