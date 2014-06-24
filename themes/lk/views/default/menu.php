<?php
/**
 * Created by PhpStorm.
 * User: calc
 * Date: 24.06.14
 * Time: 14:42
 */
?>

<td id="left_menu">
    <!-- MENU START -->
    <!--<div id="menu">-->
    <div class="menu">
        UserID:<?=WebYii::app()->user->id?><br>
        UserName:<?=WebYii::app()->user->name?>
        <a href="<?=$this->createUrl("cam/live")?>" class="cam">&nbsp;</a><br>
        <a href="<?=$this->createUrl("cam/archive")?>" class="arc">&nbsp;</a><br>
        <a href="<?=$this->createUrl("cam/balans")?>" class="bal">&nbsp;</a><br>
        <a href="<?=$this->createUrl("cam/settings")?>" class="set">&nbsp;</a><br>
        <a href="<?=$this->createUrl("cam/news")?>" class="news">&nbsp;</a><br>
        <a href="<?=$this->createUrl('/site/logout')?>">logout</a>
    </div>
    <!-- MENU END -->
</td>