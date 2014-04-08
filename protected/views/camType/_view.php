<?php
/* @var $this CamTypeController */
/* @var $data CamType */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('vendor_id')); ?>:</b>
	<?php echo CHtml::encode($data->vendor_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('live_auth')); ?>:</b>
	<?php echo CHtml::encode($data->live_auth); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('live_user')); ?>:</b>
	<?php echo CHtml::encode($data->live_user); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('live_pass')); ?>:</b>
	<?php echo CHtml::encode($data->live_pass); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('live_proto')); ?>:</b>
	<?php echo CHtml::encode($data->live_proto); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('live_port')); ?>:</b>
	<?php echo CHtml::encode($data->live_port); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('live_path')); ?>:</b>
	<?php echo CHtml::encode($data->live_path); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('live_width')); ?>:</b>
	<?php echo CHtml::encode($data->live_width); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('live_height')); ?>:</b>
	<?php echo CHtml::encode($data->live_height); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('live_audio')); ?>:</b>
	<?php echo CHtml::encode($data->live_audio); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('stop_auth')); ?>:</b>
	<?php echo CHtml::encode($data->stop_auth); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('stop_user')); ?>:</b>
	<?php echo CHtml::encode($data->stop_user); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('stop_pass')); ?>:</b>
	<?php echo CHtml::encode($data->stop_pass); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('stop_proto')); ?>:</b>
	<?php echo CHtml::encode($data->stop_proto); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('stop_port')); ?>:</b>
	<?php echo CHtml::encode($data->stop_port); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('stop_path')); ?>:</b>
	<?php echo CHtml::encode($data->stop_path); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ispy_url')); ?>:</b>
	<?php echo CHtml::encode($data->ispy_url); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('comment')); ?>:</b>
	<?php echo CHtml::encode($data->comment); ?>
	<br />

	*/ ?>

</div>