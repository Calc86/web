<?php

require("vlm.class.php");


$do = get_var('do',0);
echo '<a href="?do=1">do</a>';
echo "<br>";

if(!$do){
    
    exit();
}

$q = "select * from org order by id";
$r = mysql_query($q);

while($row = mysql_fetch_assoc($r)){
    $vlm = new vlm($row['id']);
    $f = fopen("/var/www/vlc/etc/$row[name].vlm","w");
    fwrite($f, $vlm);
    fclose($f);
}
echo 'done';

