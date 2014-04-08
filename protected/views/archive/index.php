<?php
/* @var $this ArchiveController */
/* @var $dataProvider CActiveDataProvider */
/* @var $y int */
/* @var $m int */
/* @var $d int */
/* @var $h1 int */
/* @var $h2 int */

$this->breadcrumbs=array(
	'Archives',
);

$this->menu=array(
	array('label'=>'Create Archive', 'url'=>array('create')),
	array('label'=>'Manage Archive', 'url'=>array('admin')),
);

$this->widget('zii.widgets.jui.CJuiSliderInput',array(
    'model'=>Archive::model(),
    'attribute'=>'h1',
    'maxAttribute'=>'h2',
    // additional javascript options for the slider plugin
    'options'=>array(
        'range'=>true,
        'min'=>0,
        'max'=>24,
    ),
));

?>


<a href="<?php echo $this->createUrl("index",array('cid'=>$cid,'y'=>$y,'m'=>$m,'d'=>$d,'h1'=>0,'h2'=>6));?>">
    0-6
</a>
<a href="<?php echo $this->createUrl("index",array('cid'=>$cid,'y'=>$y,'m'=>$m,'d'=>$d,'h1'=>6,'h2'=>12));?>">
    6-12
</a>
<a href="<?php echo $this->createUrl("index",array('cid'=>$cid,'y'=>$y,'m'=>$m,'d'=>$d,'h1'=>12,'h2'=>18));?>">
    12-18
</a>
<a href="<?php echo $this->createUrl("index",array('cid'=>$cid,'y'=>$y,'m'=>$m,'d'=>$d,'h1'=>18,'h2'=>24));?>">
    18-24
</a>


<div id="archive">
<?php
//$this->render('webroot.themes.'.Yii::app()->theme->name.'.components.views.ViewName',$params);
$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
));
?>
</div>
