<?php
/**
 * Created by PhpStorm.
 * User: calc
 * Date: 24.06.14
 * Time: 9:58
 */

/* @var $this CController
 * @var $cam
 */

$url = $this->createUrl('live',array('id'=>$cam->id));
$on = '';
if($cam != null)
    $on = $cam->id==$cam->id ? ' on' : '';

$nginxImage = MyConfig::getNginxImgUrl($cam->id);

?>

<a style="background-image: url(<?=$nginxImage;?>)" href="<?=$url?>" class="kadr small shadow<?=$on;?>">
    <div class="font16">
        <?=$cam->name?>
    </div>
</a>

