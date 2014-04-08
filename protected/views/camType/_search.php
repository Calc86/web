<?php
/* @var $this CamTypeController */
/* @var $model CamType */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'vendor_id'); ?>
		<?php echo $form->textField($model,'vendor_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'live_auth'); ?>
		<?php echo $form->textField($model,'live_auth',array('size'=>6,'maxlength'=>6)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'live_user'); ?>
		<?php echo $form->textField($model,'live_user',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'live_pass'); ?>
		<?php echo $form->textField($model,'live_pass',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'live_proto'); ?>
		<?php echo $form->textField($model,'live_proto',array('size'=>4,'maxlength'=>4)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'live_port'); ?>
		<?php echo $form->textField($model,'live_port'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'live_path'); ?>
		<?php echo $form->textField($model,'live_path',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'live_width'); ?>
		<?php echo $form->textField($model,'live_width'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'live_height'); ?>
		<?php echo $form->textField($model,'live_height'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'live_audio'); ?>
		<?php echo $form->textField($model,'live_audio',array('size'=>3,'maxlength'=>3)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'stop_auth'); ?>
		<?php echo $form->textField($model,'stop_auth',array('size'=>6,'maxlength'=>6)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'stop_user'); ?>
		<?php echo $form->textField($model,'stop_user',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'stop_pass'); ?>
		<?php echo $form->textField($model,'stop_pass',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'stop_proto'); ?>
		<?php echo $form->textField($model,'stop_proto',array('size'=>4,'maxlength'=>4)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'stop_port'); ?>
		<?php echo $form->textField($model,'stop_port'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'stop_path'); ?>
		<?php echo $form->textField($model,'stop_path',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ispy_url'); ?>
		<?php echo $form->textField($model,'ispy_url',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'comment'); ?>
		<?php echo $form->textArea($model,'comment',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->