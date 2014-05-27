<?php /* @var $this Controller */ ?>
<?php /* @var $content string */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div id="content" class="white_box">
    <!--content -->
    <?php if(isset($this->breadcrumbs)):?>
        <?php $this->widget('zii.widgets.CBreadcrumbs', array(
                'links'=>$this->breadcrumbs,
            )); ?><!-- breadcrumbs -->
    <?php endif?>
	<?php echo $content; ?>
</div><!-- content -->
<?php $this->endContent(); ?>