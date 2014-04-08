<?php
/* @var $this ArchiveController */
/* @var $model Archive */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

    <?php
    /*
    $this->widget('zii.widgets.jui.CJuiSliderInput', array(
        'name'=>'slider_range',

        'event'=>'change',
        'options'=>array(
            'values'=>array(1050,2750),// default selection
            'min'=>0, //minimum value for slider input
            'max'=>5000, // maximum value for slider input
            'animate'=>true,
            // on slider change event
            'slide'=>'js:function(event,ui){$("#amount-range").val(ui.values[0]+\'-\'+ui.values[1]);}',
        ),
        // slider css options
        'htmlOptions'=>array(
            'style'=>''
        ),
    ));

     */
    $this->widget('zii.widgets.jui.CJuiSliderInput',array(
        //'model'=>Archive::model(),
        'name'=>'hours_range',
        //'attribute'=>'h2',
        /*'maxAttribute'=>'h2',*/
        'event'=>'change',
        // additional javascript options for the slider plugin
        'options'=>array(
            //'range'=>true,
            'values'=>array(0,24),
            'min'=>0,
            'max'=>24,
            'slide'=>'js:function(event,ui){$("#Archive_h2").val(ui.values[1]);$("#Archive_h1").val(ui.values[0]);}',
        ),
    ));
    ?>

    <div class="row">
        <?php echo $form->label($model,'h1'); ?>
        <?php echo $form->textField($model,'h1'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'h2'); ?>
        <?php echo $form->textField($model,'h2'); ?>
    </div>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cam_id'); ?>
		<?php echo $form->textField($model,'cam_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'type'); ?>
		<?php echo $form->textField($model,'type',array('size'=>4,'maxlength'=>4)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'date_start'); ?>
		<?php echo $form->textField($model,'date_start'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'date_end'); ?>
		<?php echo $form->textField($model,'date_end'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'date_rebuild'); ?>
		<?php echo $form->textField($model,'date_rebuild'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'time_rebuild'); ?>
		<?php echo $form->textField($model,'time_rebuild'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'rebuilded'); ?>
		<?php echo $form->textField($model,'rebuilded',array('size'=>11,'maxlength'=>11)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'watched'); ?>
		<?php echo $form->textField($model,'watched'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'file'); ?>
		<?php echo $form->textField($model,'file',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->