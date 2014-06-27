<?php
/* @var $this ArchiveController */
/* @var $model Archive */
/* @var $form CActiveForm */


WebYii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	/*$('#archive-list').yiiListView('update', {
		data: $(this).serialize()
	});*/
	$.fn.yiiListView.update('archive-list', {
        //this entire js section is taken from admin.php. w/only this line diff
        data: $(this).serialize()
    });
	return false;
});
");
?>

<div class="search-form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'search',
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

    <?php
    $this->widget('zii.widgets.jui.CJuiSliderInput',array(
        //'model'=>Archive::model(),
        'name'=>'hours_range',
        //'attribute'=>'h2',
        /*'maxAttribute'=>'h2',*/
        'event'=>'change',
        //'event'=>'stop',
        // additional javascript options for the slider plugin
        'options'=>array(
            //'range'=>true,
            'values'=>array($model->h1, $model->h2),
            'min'=>0,
            'max'=>24,
            'slide'=>'js:function(event,ui){$("#Archive_h2").val(ui.values[1]);$("#Archive_h1").val(ui.values[0]);$("#range").html(ui.values[0] + "-" + ui.values[1]);}',
            'stop'=>'js:function(event,ui){$("#search").submit()}',
        ),
    ));
    ?>

    <div class="row">
        <?php echo $form->hiddenField($model, 'h1'); ?>
    </div>

    <div class="row">
        <?php echo $form->hiddenField($model, 'h2'); ?>
    </div>

    <div class="row">
        <?php echo CHtml::hiddenField('yt0', 'Search'); ?>
    </div>

	<!--<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>-->

<?php $this->endWidget(); ?>

</div><!-- search-form -->