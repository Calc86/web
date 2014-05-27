<?php
/**
 * Created by PhpStorm.
 * User: calc
 * Date: 30.04.14
 * Time: 11:41
 * интерфейс "безопасника"
 */

$cams = Cam::model()->search();

//Yii::app()->clientScript->registerScript

$cs = Yii::app()->clientScript;
/* @var $cs CClientScript*/
$cs->registerCoreScript( 'jquery.ui' );
$cs->registerCssFile(
    Yii::app()->clientScript->getCoreScriptUrl().
    '/jui/css/base/jquery-ui.css'
);

$cs->registerCss('secure','
#sortable {
    list-style-type: none;
    margin: 0;
    padding: 0;
    width: 850px;
}
#sortable li {
    margin: 0;
    padding: 0;
    float: left;
    width: 420px;
    height: 315px;
    /*font-size: 4em;*/
    text-align: center;
}

');

$cs->registerScript('secure','
    $(function() {
    $( "#sortable" ).sortable();
    $( "#sortable" ).disableSelection();
  });
');

?>
<a href="#">1x1</a> | <a href="#">2x2</a> | <a href="#">3x3</a> | <a href="#">4x4</a>
<ul id="sortable">
    <?php
    foreach($cams->getData() as $cam){
        echo '<li class="ui-state-default">';
        $frame = new CamFrame($cam->cs);
            echo $frame->live(CamFrame::SRC_MOTION, CamFrame::PLUGIN_IMG);
        echo '</li>';
    }
    ?>
</ul>