<?php

require("config.class.php");


$do = get_var('do',0);
echo '<a href="?do=1">do</a>';
echo "<br>";

if(!$do){
    exit();
}

echo '<pre>';
//стартап список
echo "стартап список";
$q = "select name from org where banned=0";
$r = mysql_query($q);


$f = fopen("/var/www/html/vlc/etc/startup_list","w");
while($row = mysql_fetch_row($r)){
    fwrite($f, $row[0]."\n");
}
fclose($f);
echo "...ok\n";

$q = "select * from org order by id";
$r = mysql_query($q);

while($row = mysql_fetch_assoc($r)){
    echo $row['id'].') '.$row['name'].":\n";
    echo 'setup';
    passthru("/home/calc/vlc/bin/setup.sh $row[name] $row[id]");
    echo "...ok\n";
    
    $c = new config($row['id']);
    //vlm
    echo 'vlm';
    $f = fopen("/var/www/html/vlc/etc/$row[name]/vlc.vlm","w");
    fwrite($f, $c->vlm());
    fclose($f);
    echo "...ok\n";
    
    //motion
    $m = $c->motion();
    echo "motion";
    foreach ($m as $n=>$text) {
        $f = fopen("/var/www/html/vlc/etc/$row[name]/motion/$n.conf","w");
        fwrite($f, $text);
        fclose($f);
    }
    echo "...ok\n";
    
    //ffmpeg etc
    echo "ffmpeg etc";
    $f = fopen("/var/www/html/vlc/etc/$row[name]/ffmpeg.conf","w");
    fwrite($f, $c->ffmpeg_etc());
    fclose($f);
    echo "...ok\n";
    
    //ffmpeg bin
    echo "ffmpeg bin";
    $ff = $c->ffmpeg_bin();
    foreach ($ff as $n=>$text) {
        $f = fopen("/var/www/html/vlc/bin/$row[name]/ffmpeg/$n.sh","w");
        fwrite($f, $text);
        fclose($f);
    }
    echo "...ok\n";
    
    //mplayer etc
    echo "ffmpeg etc";
    $f = fopen("/var/www/html/vlc/etc/$row[name]/mplayer.conf","w");
    fwrite($f, $c->mplayer_etc());
    fclose($f);
    echo "...ok\n";
    
    //ffmpeg bin
    echo "mplayer bin";
    $ff = $c->mplayer_bin();
    foreach ($ff as $n=>$text) {
        $f = fopen("/var/www/html/vlc/bin/$row[name]/mplayer/$n.sh","w");
        fwrite($f, $text);
        fclose($f);
    }
    echo "...ok\n";
    
    //ffmpeg bin
    echo "logrotate etc";
    $log = $c->logrotate();
    $f = fopen("/var/www/html/vlc/etc/$row[name]/logrotate.conf","w");
    fwrite($f, $log);
    fclose($f);
    echo "...ok\n";
}

echo 'exec flags';
passthru("/home/calc/vlc/bin/setup_mod.sh $row[name] $row[id]");
echo "...ok\n";

echo 'done';
echo '</pre>';

