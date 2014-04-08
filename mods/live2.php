<?php

require_once './class/cam.class.php';

$mod = getMod(__FILE__);
$myvars = array();
if(isset($_SESSION['mod'][$mod])){
    $myvars = $_SESSION['mod'][$mod];
}

$src =   get_var('src', get_ar($myvars,'src','srv'));
$_SESSION['mod'][$mod]['src'] = $src;
$out =   get_var('out', get_ar($myvars,'out','vlc'));
$_SESSION['mod'][$mod]['out'] = $out;

$id = ses_var('id');

if($_SESSION['login']=='calc'){
    $body.= '<br>';
    $body.= '<a href="?mod='.$mod.'&src=srv">srv</a> ';
    $body.= '<a href="?mod='.$mod.'&src=source">source</a> ';
    $body.= '<a href="?mod='.$mod.'&src=rtsp">rtsp</a> ';
    $body.= '<a href="?mod='.$mod.'&out=vlc">vlc</a> ';
    $body.= '<a href="?mod='.$mod.'&out=qt">qt</a> ';
    $body.= '<a href="?mod='.$mod.'&out=jpg">jpg</a> ';
}

$body.= '<div>';

$q2 = "select id from cam where oid=$id and live=1 order by id";

$r2 = mysql_query($q2);
while ($row2 = mysql_fetch_assoc($r2)) {
    $cam = new cam($row2['id']);
    $body.= $cam->live($src,$out);
}

$body.= '</div>';
?>