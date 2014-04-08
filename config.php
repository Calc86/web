<?php

ini_set('display_errors', 1);
//session_start();  //используется в скрипте proxy, который вызывается 4 раза в секунду.

define("TLPORT",44300);
define("DIR",'/home/vlc/vlc/www');
define("VLC",'/home/vlc/vlc');
define("WEB",'/vlc');
define("NL","\n");
define("VLC_LIVE",'10.112.28.202');
define("LIVE_HOST",VLC_LIVE);
//$dir = '/home/calc/vlc/www';
$dir = DIR;

//Europe/Moscow
date_default_timezone_set('Europe/Moscow');
define("INDEX",1);
require ("$dir/admin/func.php");
require ("$dir/class/login.class.php");

$db = open_db('10.112.28.207', 'cam', 'campass', 'cam');

function getMod($path) {
    $a = basename($path);
    $a = explode('.',$a);
    return $a[0];
}
?>
