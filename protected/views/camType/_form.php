<?php
/* @var $this CamTypeController */
/* @var $model CamType */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'cam-type-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'vendor_id'); ?>
        <?php
        $vendors = CamVendor::model()->findAll();
        $data = CHtml::listData($vendors,'id','name');
        echo $form->dropDownList($model,'vendor_id',$data);
        //echo $form->textField($model,'vendor_id');
        ?>
		<?php echo $form->error($model,'vendor_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>


    <div class="row">
        <?php echo $form->labelEx($model,'live_proto'); ?>
        <?php echo $form->dropDownList($model,'live_proto',CamType::$enum_live_proto) ?>
        <?php echo $form->error($model,'live_proto'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model,'live_port'); ?>
        <?php echo $form->textField($model,'live_port'); ?>
        <?php echo $form->error($model,'live_port'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model,'live_path'); ?>
        <?php echo $form->textField($model,'live_path',array('size'=>60,'maxlength'=>255)); ?>
        <?php echo $form->error($model,'live_path'); ?>
    </div>
	<div class="row">
		<?php echo $form->labelEx($model,'live_auth'); ?>
        <?php echo $form->dropDownList($model,'live_auth',CamType::$enum_live_auth);?>
		<?php echo $form->error($model,'live_auth'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'live_user'); ?>
		<?php echo $form->textField($model,'live_user',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'live_user'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'live_pass'); ?>
		<?php echo $form->textField($model,'live_pass',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'live_pass'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'live_width'); ?>
		<?php echo $form->textField($model,'live_width'); ?>
		<?php echo $form->error($model,'live_width'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'live_height'); ?>
		<?php echo $form->textField($model,'live_height'); ?>
		<?php echo $form->error($model,'live_height'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'live_audio'); ?>
		<?php echo $form->dropDownList($model,'live_audio',CamType::$enum_live_audio) ?>
		<?php echo $form->error($model,'live_audio'); ?>
	</div>


    <div class="row">
        <?php echo $form->labelEx($model,'stop_proto'); ?>
        <?php echo $form->dropDownList($model,'stop_proto',CamType::$enum_stop_proto); ?>
        <?php echo $form->error($model,'stop_proto'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model,'stop_port'); ?>
        <?php echo $form->textField($model,'stop_port'); ?>
        <?php echo $form->error($model,'stop_port'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model,'stop_path'); ?>
        <?php echo $form->textField($model,'stop_path',array('size'=>60,'maxlength'=>255)); ?>
        <?php echo $form->error($model,'stop_path'); ?>
    </div>
	<div class="row">
		<?php echo $form->labelEx($model,'stop_auth'); ?>
		<?php echo $form->dropDownList($model,'stop_auth',CamType::$enum_stop_auth) ?>
		<?php echo $form->error($model,'stop_auth'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'stop_user'); ?>
		<?php echo $form->textField($model,'stop_user',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'stop_user'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'stop_pass'); ?>
		<?php echo $form->textField($model,'stop_pass',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'stop_pass'); ?>
	</div>
    <div class="row">
        <?php echo $form->labelEx($model,'stop_width'); ?>
        <?php echo $form->textField($model,'stop_width'); ?>
        <?php echo $form->error($model,'stop_width'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model,'stop_height'); ?>
        <?php echo $form->textField($model,'stop_height'); ?>
        <?php echo $form->error($model,'stop_height'); ?>
    </div>

	<div class="row">
		<?php echo $form->labelEx($model,'ispy_url'); ?>
		<?php echo $form->textField($model,'ispy_url',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'ispy_url'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'comment'); ?>
		<?php echo $form->textArea($model,'comment',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'comment'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->