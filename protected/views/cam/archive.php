<?php
/* @var $this CamController */

$this->breadcrumbs=array(
	'Cam'=>array('/cam'),
	'Archive',
);
$this->layout = 'column2columns';
?>


<div class="hr up"></div>
<!-- Video inc blocks Start-->
<?php
$cams = Cam::model()->search();
$i=0;
foreach($cams->data as $cam)
{
    $style = ' style="background-image: url('.$this->createUrl("snap",array('id'=>$cam->id)).');"';
?>
    <a style="background-image: url(<?=MyConfig::getNginxImgUrl($cam->id);?>)" href="<?php echo $this->createUrl("archive/cal",array('cid'=>$cam->id)) ?>" class="kadr normal"<?=$style?>>
        <div class="font16"><?=$cam->name?></div>
    </a>
<?php
}
?>



<!-- Video inc blocks End-->
<div class="hr down"></div>
