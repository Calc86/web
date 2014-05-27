<?php
/* @var $this ArchiveController */
/* @var $model Archive */
/* @var int $d day */
/* @var int $m month */
/* @var int $y year */

$this->breadcrumbs=array(
	'Archives'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Archive', 'url'=>array('index')),
	array('label'=>'Create Archive', 'url'=>array('create')),
);

/** @var CWebApplication $app */
$app = Yii::app();
$app->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	/*$('#archive-list').yiiListView('update', {
		data: $(this).serialize()
	});*/
	$.fn.yiiListView.update('archive-list', {
        //this entire js section is taken from admin.php. w/only this line diff
        data: $(this).serialize()
    });
	return false;
});
");
?>

<h1>#<?php echo $model->cam_id.' '.$y.'-'.$m.'-'.$d; ?> <span id="range"><?=$model->h1?>-<?=$model->h2?></span> hours</h1>

<div class="search-form" style="">
<?php $this->renderPartial('_search1',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<div id="archive">
    <?php
    $this->widget('zii.widgets.CListView', array(
        'id'=>'archive-list',
        'dataProvider'=>$model->search($y,$m,$d),
        'itemView'=>'_view',
        /*'sortableAttributes'=>array(
            'h1',
            'h2',
        ),*/
    ));
    ?>
</div>
