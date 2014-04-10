<?php
/* @var $this SiteController */
/* $main = array of blocks*/

$this->pageTitle=Yii::app()->name . ' - About';
$this->breadcrumbs=array(
	'About',
);
?>
<h1>О нас</h1>

<p><?=$main['main_col1']->text?></p>
