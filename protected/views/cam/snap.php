<?php

/* @var $this Controller
 * @var $cam Cam
 */

WebYii::app()->theme = 'blank';
$this->layout = 'blank';
?>

<script>
    function reload(){
        location.reload();
    }
</script>

<a id="frame" onClick="reload()" href="#"><img src="<?=$cam->getSnapshot()?>"></a>
