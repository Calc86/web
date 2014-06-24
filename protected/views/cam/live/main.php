<?php
/* @var $this CamController
 * @var $cam Cam
 * @var $src
 * @var $plugin
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
        <?php
            if($cam != null){
                $frame = new CamFrame($cam->cs);
                echo $frame->live($src, $plugin);
            }
        ?>
    </div>    <div class="font16 text" id="text">
        <div id="plugins">
            <?php if($cam != null){ ?>
                <a href="<?=$this->createUrl('', array('id'=>$cam->id, 'plugin'=>'vlc'))?>">Живое видео</a> |
                <a href="<?=$this->createUrl('', array('id'=>$cam->id, 'src'=>'motion', 'plugin'=>'img'))?>">Детектор движения</a> |
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
        $this->renderPartial("live/_cam", array('cam'=>$c));
    }
    ?>
</div>

