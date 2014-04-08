<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>

<table id="layout">
    <tr>
        <td id="left_menu">
            <!-- MENU START -->
            <!--<div id="menu">-->
            <div class="menu">
                <a href="<?=$this->createUrl("cam/live")?>" class="cam">&nbsp;</a><br>
                <a href="<?=$this->createUrl("cam/archive")?>" class="arc">&nbsp;</a><br>
                <a href="<?=$this->createUrl("cam/balans")?>" class="bal">&nbsp;</a><br>
                <a href="<?=$this->createUrl("cam/settings")?>" class="set">&nbsp;</a><br>
                <a href="<?=$this->createUrl("cam/news")?>" class="news">&nbsp;</a><br>
            </div>
            <!-- MENU END -->
        </td>
        <td id="content">
            <!-- MAIN BLOCK START -->
            <div id="main">
                <div class="content">
                    <div class="logo_small">
                        <a href="<?=$this->createUrl("/cam")?>" class="img">
                            &nbsp;<br>
                            UserID:<?=Yii::app()->user->id?><br>
                            UserName:<?=Yii::app()->user->name?>
                        </a>
                    </div>
                    <div style="height: 90px;" class="">
                        <!-- Какое то еще меню -->
                    </div>
                    <div class="columns">
                        <?php echo $content; ?>
                    </div>
                </div>
            </div>
            <!-- MAIN BLOCK END -->
        </td>
    </tr>
</table>

<?php $this->endContent(); ?>