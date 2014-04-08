<?php
/* @var $this CamController */
/* @var $model Cam */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'cam-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля отмеченные знаком <span class="required">*</span> обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'zone_id'); ?>
        <?php
        $zones = Zone::model()->findAll($this->cr_zones);
        $data = CHtml::listData($zones,'id','name');
        echo $form->dropDownList($model,'zone_id',$data);

        ?>
		<?php echo $form->error($model,'zone_id'); ?>
	</div>

	<!--<div class="row">
		<?php echo $form->labelEx($model,'user_id'); ?>
		<?php echo $form->textField($model,'user_id'); ?>
		<?php echo $form->error($model,'user_id'); ?>
	</div>-->

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'order'); ?>
		<?php echo $form->textField($model,'order'); ?>
		<?php echo $form->error($model,'order'); ?>
	</div>

    <div class="row">
        <?php echo $form->labelEx($model,'type_id'); ?>
        <?php
            $types = CamType::model()->findAll();
            $data = CHtml::listData($types,'id','name');
            echo $form->dropDownList($model,'type_id',$data);
        ?>
        <?php echo $form->error($model,'type_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'ip'); ?>
        <?php echo $form->textField($model,'ip'); ?>
        <?php echo $form->error($model,'ip'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'user'); ?>
        <?php echo $form->textField($model,'user'); ?>
        <?php echo $form->error($model,'user'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'pass'); ?>
        <?php echo $form->textField($model,'pass'); ?>
        <?php echo $form->error($model,'pass'); ?>
    </div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->