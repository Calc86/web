<?php
/* @var $this SiteController */
/* @var $main = array of blocks*/
/* @var $alias */

$this->pageTitle=Yii::app()->name . ' - '.(isset($main[$alias]) ? $main[$alias]->title : '');
$this->breadcrumbs=array(
    isset($main[$alias]) ? $main[$alias]->title : '',
);
?>
<h1><?=isset($main[$alias]) ? $main[$alias]->title : ''?></h1>

<p><?=isset($main[$alias]) ? $main[$alias]->text : ''?></p>
