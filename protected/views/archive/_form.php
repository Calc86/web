<?php
/* @var $this ArchiveController */
/* @var $model Archive */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'archive-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'cam_id'); ?>
		<?php echo $form->textField($model,'cam_id'); ?>
		<?php echo $form->error($model,'cam_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo $form->textField($model,'type',array('size'=>4,'maxlength'=>4)); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date_start'); ?>
		<?php echo $form->textField($model,'date_start'); ?>
		<?php echo $form->error($model,'date_start'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date_end'); ?>
		<?php echo $form->textField($model,'date_end'); ?>
		<?php echo $form->error($model,'date_end'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date_rebuild'); ?>
		<?php echo $form->textField($model,'date_rebuild'); ?>
		<?php echo $form->error($model,'date_rebuild'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'time_rebuild'); ?>
		<?php echo $form->textField($model,'time_rebuild'); ?>
		<?php echo $form->error($model,'time_rebuild'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'rebuilded'); ?>
		<?php echo $form->textField($model,'rebuilded',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'rebuilded'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'watched'); ?>
		<?php echo $form->textField($model,'watched'); ?>
		<?php echo $form->error($model,'watched'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'file'); ?>
		<?php echo $form->textField($model,'file',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'file'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->