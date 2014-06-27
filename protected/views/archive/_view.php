<?php
/* @var $this ArchiveController */
/* @var $data Archive */

?>

<a class="view <?=$data->type?>" href="<?php echo $this->createUrl('view', array('id'=>$data->id)); ?>">

	<!--<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />-->

	<!--<b><?php echo CHtml::encode($data->getAttributeLabel('cam_id')); ?>:</b>
	<?php echo CHtml::encode($data->cam_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
	<?php echo CHtml::encode($data->type); ?>
	<br />-->

	<!--<b><?php echo CHtml::encode($data->getAttributeLabel('date_start')); ?>:</b>-->
	<?php echo CHtml::encode(date("H:i:s",$data->date_start)); ?> -

	<!--<b><?php echo CHtml::encode($data->getAttributeLabel('date_end')); ?>:</b>-->
	<?php echo CHtml::encode(date("H:i:s",$data->date_end)); ?>

    <!--<b><?php echo CHtml::encode($data->getAttributeLabel('watched')); ?>:</b>
    <?php echo CHtml::encode($data->watched); ?>
    <br />-->

    <?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('date_rebuild')); ?>:</b>
	<?php echo CHtml::encode($data->date_rebuild); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('time_rebuild')); ?>:</b>
	<?php echo CHtml::encode($data->time_rebuild); ?>
	<br />
 */ ?>

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('rebuilded')); ?>:</b>
	<?php echo CHtml::encode($data->rebuilded); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('watched')); ?>:</b>
	<?php echo CHtml::encode($data->watched); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('file')); ?>:</b>
	<?php echo CHtml::encode($data->file); ?>
	<br />

	*/ ?>

</a>
