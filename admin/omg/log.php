<?php
define("INDEX",1);
require("../func.php");

ini_set('display_errors',1);
ini_set('register_globals','Off');

$db = open_db("localhost", "cam", "campass", "cam");

$log = get_var('log');
$lines = get_var('lines',200);

//echo $log;
?>
<a href="?log=<?=$log?>&lines=200">200</a>
<a href="?log=<?=$log?>&lines=1000">1000</a>
<a href="?log=<?=$log?>&lines=2000">2000</a>
<a href="?log=<?=$log?>&lines=5000">5000</a>

<?php
$buf = '';
echo '<pre>';
//ls -l ./vlc.log
system("ls -l /home/calc/vlc/log/$log", $buf);
system("tail -n $lines /home/calc/vlc/log/$log", $buf);
echo '</pre>';
 



?>
