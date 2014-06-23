<?php
/* @var $this CamController
 * @var $cam Cam
 * @var $src
 * @var $plugin
 */

$this->breadcrumbs=array(
	'Cam'=>array('/cam'),
	'Cams',
);

$this->layout = 'column2columns';

if($cam != null){
    $live_url = $this->createUrl("ajax",array("id"=>$cam->id,'type'=>'live'));
    $rec_url = $this->createUrl("ajax",array("id"=>$cam->id,'type'=>'rec'));
    $mtn_url = $this->createUrl("ajax",array("id"=>$cam->id,'type'=>'mtn'));

    /** @var CWebApplication $app */
    $app = Yii::app();
    $app->clientScript->registerScript('cam', "
        var live_url='$live_url';
        var rec_url='$rec_url';
        var mtn_url='$mtn_url';

        $(document).ready(function(){
        });

        $('.play').click(function(){
            if($(this).hasClass('on')){
                $(this).removeClass('on');
            }else{
                $(this).addClass('on');
                var live = $('#live').html();
                $('#live').html(live);
            }
            $('#status').load(live_url).fadeIn( 400 ).delay(2000).slideUp( 300 );
        });

        $('.rec').click(function(){
            if($(this).hasClass('on')){
                $(this).removeClass('on');
            }else{
                $(this).addClass('on');
            }
            $('#status').load(rec_url).fadeIn( 400 ).delay(2000).slideUp( 300 );
        });

        $('.mtn').click(function(){
            if($(this).hasClass('on')){
                $(this).removeClass('on');
            }else{
                $(this).addClass('on');
            }
            $('#status').load(mtn_url).fadeIn( 400 ).delay(2000).slideUp( 300 );
        });

        function url_me(){
            location.href = $(this).attr('data-href');
        }
        $('.cam').click(url_me);
        $('.settings').click(url_me);


    ");
}
?>

<!-- Просмотры START-->
<div class="column1">
    <div id="live" class="shadow font16">
        <?php
            if($cam != null){
                /** @var CamSettings $cs */
                $cs = CamSettings::model()->findByAttributes(array('cam_id'=>$cam->id));
                $frame = new CamFrame($cs);
                echo $frame->live($src, $plugin);
            }
        ?>
    </div>
    <?php
    /*
    <div>
        <video src="http://10.154.28.203/lhttp/1/stream-8.m3u8" autoplay="autoplay" controls="controls">
        </video>
    </div>*/
    ?>
    <div class="font16 text" id="text">
        <div id="control">
            <?php if($cam != null){
                $live = $cam->live ? ' on' : '';
                $rec = $cam->rec ? ' on' : '';
                $mtn = $cam->mtn ? ' on' : '';
                ?>

                <div style="background-color: white;">
                    <a href="<?=$this->createUrl('', array('id'=>$cam->id))?>">dvr</a>
                    motion
                    (
                    <a href="<?=$this->createUrl('', array('id'=>$cam->id, 'src'=>'motion'))?>">std</a>,
                    <a href="<?=$this->createUrl('', array('id'=>$cam->id, 'src'=>'motion', 'plugin'=>'img'))?>">img</a>
                    <a href="<?=$this->createUrl('', array('id'=>$cam->id, 'src'=>'motion', 'plugin'=>'cambozola'))?>">cambozola</a>
                    <a href="<?=$this->createUrl('', array('id'=>$cam->id, 'src'=>'motion', 'plugin'=>'axis'))?>">axis</a>
                    <a target="_blank" href="<?=$this->createUrl('snap')?>">snap</a>
                    )
                </div>

                <div class="button first cam" data-href="<?=$this->createUrl("update",array('id'=>$cam->id))?>">&nbsp;</div>
                <div class="button settings" data-href="<?=$this->createUrl("camSettings/update",array('cam_id'=>$cam->id))?>">&nbsp;</div>
                <div class="button play<?=$live?>">&nbsp;</div>
                <div class="button rec<?=$rec?>">&nbsp;</div>
                <div class="button last mtn<?=$mtn?>">&nbsp;</div>
            <?php } ?>
        </div>
        <div id="status">
        </div>
    </div>
</div>

<div class="column2">
    <a href="<?=$this->createUrl('create')?>">Добавить камеру</a><br><br>
    <?php

    $cams = Cam::model()->search();
    foreach($cams->data as $c){
        $style = ' style="background-image: url('.$this->createUrl("snap",array('id'=>$c->id)).');"';
        $url = $this->createUrl('live',array('id'=>$c->id));
        $on = '';
        if($cam != null)
            $on = $cam->id==$c->id ? ' on' : '';

        //echo '<a'.$style.' href=""></a>';
        ?>
        <a style="background-image: url(<?=MyConfig::getNginxImgUrl($c->id);?>)" href="<?=$url?>" class="kadr small shadow<?=$on;?>"<?=$style?>>
            <div class="font16">
                <?=$c->name?>
            </div>
        </a>
        <?php
    }
    ?>
</div>

<!-- Стрелки начало-->
<!--<div class="column3">
    <div style="position:absolute; top:2px; right:2px; width:40px; height:30; text-align:center;"><a href="#"><img src="images/button_arrow_up.png" width="40" height="30" border="0"></a></div>
    <div style="position:absolute; top:405px; right:2px; width:40px; height:30; text-align:center;"><a href="#"><img src="images/button_arrow_down.png" width="40" height="30" border="0"></a></div>
</div>-->
<!-- Стрелки конец-->
<!-- Просмотры END-->

<!-- Месяца туда-сюда  конец-->

