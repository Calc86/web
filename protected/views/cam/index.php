<?php
/* @var $this CamController */

/*$this->breadcrumbs=array(
	'Cam',
);*/

$this->layout = 'column2';
?>


<div class="logo">
    <a class="img" href="<?=$this->createUrl("/")?>">&nbsp;</a>
</div>
<div class="menu pos1">
    <a href="<?=$this->createUrl('live');?>" class="cam">&nbsp;</a>
</div>
<div class="menu pos2">
    <a href="<?=$this->createUrl('archive');?>" class="arc">&nbsp;</a>
</div>
<div class="menu pos3">
    <a href="<?=$this->createUrl('balans');?>" class="bal">&nbsp;</a>
</div>
<div class="menu pos4">
    <a href="<?=$this->createUrl('settings');?>" class="set">&nbsp;</a>
</div>
<div class="menu pos5">
    <a href="<?=$this->createUrl('news');?>" class="news">&nbsp;</a>
</div>

