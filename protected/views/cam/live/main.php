<?php
/** @var $this CamController
 * @var $cam Cam
 * @var $src
 * @var $plugin
 * @var $frame string
 */

$this->layout = 'column2columns';

$this->breadcrumbs=array(
	'Cam'=>array('/cam'),
	'Cams',
);

?>

<!-- Просмотры START-->
<div class="column1">
    <div id="live" class="shadow font16">
        <?=$frame?>
    </div>
    <div class="font16 text" id="text">
        <div id="plugins">
            <?php if($cam != null){ ?>
                <a href="<?=$this->createUrl('', array('id'=>$cam->id, 'src'=>Cam::SOURCE_DEFAULT, 'plugin'=>$this::PLUGIN_DEFAULT))?>">Живое видео</a> |
                <a href="<?=$this->createUrl('', array('id'=>$cam->id, 'src'=>Cam::SOURCE_MOTION, 'plugin'=>$this::PLUGIN_MJPEG_IMG))?>">Детектор движения</a> |
                <a href="<?=$this->createUrl('snap', array('id' => $cam->id))?>" target="_blank">snap</a>
            <?php } ?>
        </div>
        <?php
        $this->renderPartial('live/_control', array('cam' => $cam));
        ?>
    </div>
</div>

<div class="column2">
    <a href="<?=$this->createUrl('create')?>">Добавить камеру</a><br><br>
    <?php
    $cams = Cam::model()->search();
    foreach($cams->data as $c){
        $this->renderPartial("live/_cam", array('cam'=>$c, 'active_id' => $cam->id));
    }
    ?>
</div>

