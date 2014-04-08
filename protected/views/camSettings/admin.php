<?php
/* @var $this CamSettingsController */
/* @var $model CamSettings */

$this->breadcrumbs=array(
	'Cam Settings'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List CamSettings', 'url'=>array('index')),
	array('label'=>'Create CamSettings', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#cam-settings-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Cam Settings</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'cam-settings-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'cam_id',
		'live_auth',
		'live_user',
		'live_pass',
		'live_proto',
		/*
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
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
