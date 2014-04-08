<?php
/* @var $this CamTypeController */
/* @var $model CamType */

$this->breadcrumbs=array(
	'Cam Types'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CamType', 'url'=>array('index')),
	array('label'=>'Create CamType', 'url'=>array('create')),
	array('label'=>'View CamType', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CamType', 'url'=>array('admin')),
);
?>

<h1>Update CamType <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>