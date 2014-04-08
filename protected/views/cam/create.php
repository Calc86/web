<?php
/* @var $this CamController */
/* @var $model Cam */

$this->breadcrumbs=array(
	'Cams'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Cam', 'url'=>array('index')),
	array('label'=>'Manage Cam', 'url'=>array('admin')),
);
?>

<h1>Добавление камеры</h1>
На данном этапе необходимо придумать краткое название камеры и выбрать зону в которой она находится<br>
    <br>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>