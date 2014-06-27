<?php
/* @var $this ArchiveController */
/* @var $cam Cam */
/* @var $archive Archive */
/* @var int $day day */
/* @var int $month month */
/* @var int $year year */

$this->breadcrumbs=array(
	'Archives'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Archive', 'url'=>array('index')),
	array('label'=>'Create Archive', 'url'=>array('create')),
);

?>

<h1><?=$cam->name?> <?=$year?>-<?=$month?>-<?=$day?> <span id="range"><?=$archive->h1?>-<?=$archive->h2?></span> hours</h1>

<?php $this->renderPartial('_search1',array(
	'model'=>$archive,
)); ?>

<div id="archive">
    <?php
    $this->widget('zii.widgets.CListView', array(
        'id'=>'archive-list',
        'dataProvider'=>$archive->search($year, $month, $day),
        'itemView'=>'_view',
        /*'sortableAttributes'=>array(
            'h1',
            'h2',
        ),*/
    ));
    ?>
</div>
