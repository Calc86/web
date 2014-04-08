<?php

require("./config.php");
require("./class/vlm.class.php");
$oid = get_var('oid',0);

$cam = get_var('cam');
$pref = get_var('pref');
$cmd = get_var('cmd');

if($oid){
    $q = "select name from org where id=$oid";
    $r = mysql_query($q);
    list($org) = mysql_fetch_row($r);
    
    $cc = new cam_control($oid, $org, $cam, $pref);
    switch ($cmd){
        case 'play':
            //echo 'play';
            $cc->play();
            echo $cc->message();
            break;
        case 'stop':
            $cc->stop();
            echo $cc->message();
            break;
        default:
    }
}

?>
