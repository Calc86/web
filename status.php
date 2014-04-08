<?php

require("./config.php");
require("./class/vlm.class.php");
$oid = get_var('oid',4);

$cam = get_var('cam','cam1');
$pref = get_var('pref','rec');
$cmd = get_var('cmd');

echo '<pre>';

if($oid){
    $q = "select name from org where id=$oid";
    $r = mysql_query($q);
    list($org) = mysql_fetch_row($r);
    
    $cs = new cam_status($oid, $org, $cam, $pref);
    //echo $cs->xml();
    //print_r($cs);
    print_r($cs->status('cam1','live'));
}

?>
