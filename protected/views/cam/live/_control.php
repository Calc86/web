<?php
/**
 * Created by PhpStorm.
 * User: calc
 * Date: 24.06.14
 * Time: 12:57
 */

/** @var $cam Cam */

$this->renderPartial('live/_js', array('cam' => $cam));
?>

<div id="control">
    <?php if($cam != null){
        $live = $cam->live ? ' on' : '';
        $rec = $cam->rec ? ' on' : '';
        $mtn = $cam->mtn ? ' on' : '';
        ?>

        <div class="button first cam" data-href="<?=$this->createUrl("update",array('id'=>$cam->id))?>">&nbsp;</div>
        <div class="button settings" data-href="<?=$this->createUrl("camSettings/update",array('cam_id'=>$cam->id))?>">&nbsp;</div>
        <div class="button play<?=$live?>">&nbsp;</div>
        <div class="button rec<?=$rec?>">&nbsp;</div>
        <div class="button last mtn<?=$mtn?>">&nbsp;</div>
    <?php } ?>
</div>
<div id="status">
</div>