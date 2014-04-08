<?php
/* @var $this CamTypeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Cam Types',
);

$this->menu=array(
	array('label'=>'Create CamType', 'url'=>array('create')),
	array('label'=>'Manage CamType', 'url'=>array('admin')),
);
?>

<h1>Cam Types</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
