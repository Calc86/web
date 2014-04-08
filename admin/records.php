<?php

require("../config.php");

$dir=  get_var('dir');


$d = dir("/home/calc/vlc/rec/$dir");
echo "Путь: " . $d->path . "<br>";
while (false !== ($entry = $d->read())) {
    if($entry == '.' || $entry == '..') continue;
    $path = $dir.'/'.$entry;
    if(is_dir($path))
        echo "<a href=\"?dir=$path\">".$entry."</a><br>";
    else
        echo "<a href=\"/vlc/rec/$path\">".$entry."</a><br>";
}
$d->close();





