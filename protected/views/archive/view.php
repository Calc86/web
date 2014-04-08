<?php
/* @var $this ArchiveController */
/* @var $model Archive */

$this->breadcrumbs=array(
	'Archives'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Archive', 'url'=>array('index')),
	array('label'=>'Create Archive', 'url'=>array('create')),
	array('label'=>'Update Archive', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Archive', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Archive', 'url'=>array('admin')),
);
?>

<h1>View Archive #<?php echo $model->id; ?></h1>


<?php

$frame = new VideoFrame();

//echo $frame->view($model->file);
//http://10.154.28.208/rec/1/2014-03-16/17_22_47_UID_1__CID_9_rec.avi
if($model->pathMp4()){
    echo $frame->view($this->createUrl('stream',array('id'=>$model->id)));
}
else{
    if(!$model->pathAvi()){
        echo 'Файл не найден';
    }
    else{
        echo 'Поток не является h264, можно только скачать';
    }
}

echo CHtml::link("Скачать",$this->createUrl("file",array('id'=>$model->id)));

?>


<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'cam_id',
		'type',
		'date_start',
		'date_end',
		'date_rebuild',
		'time_rebuild',
		'rebuilded',
		'watched',
		'file',
	),
)); ?>
