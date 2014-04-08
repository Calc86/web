<?php

require("./config.php")

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset=utf-8 />

        <!-- Website Design By: www.happyworm.com -->
        <title>OKO</title>

        <script typee="text/javascript" >
            /*var vlcplugin = document.getElementById("vlc");
            vlcplugin.onclick = function(){ alert('123');};*/
        </script>
        <!-- 1. jquery library -->
        <script
          src="http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js">
        </script>

        <!-- 2. flowplayer -->
        <script src="http://releases.flowplayer.org/5.3.2/flowplayer.min.js"></script>

        <!-- 3. skin -->
        <link rel="stylesheet" type="text/css"
           href="http://releases.flowplayer.org/5.3.2/skin/minimalist.css" />
    </head>
    <body>
<?php
/*define("INDEX",1);
require("./admin/func.php");

ini_set('display_errors',1);
ini_set('register_globals','Off');

$db = open_db("localhost", "cam", "campass", "cam");
*/
$q = "select * from org";
$r = mysql_query($q);
 
while ($row = mysql_fetch_assoc($r)) { 
    //print_r($row);
    echo '<div>';
    echo '<h2>'.$row['name'].'</h2>';
    
    $q2 = "select * from cam where oid=$row[id]";
    $r2 = mysql_query($q2);
    while($row2 = mysql_fetch_assoc($r2)){
        //print_r($row2);
        echo '<div style="display: inline-block; border: 1px solid black; width: 650px;">';
        //echo '<h5>'.$row2['cam_name'].'</h5>';
        echo '<center>
            <embed type="application/x-vlc-plugin" pluginspage="http://www.videolan.org"
               version="VideoLAN.VLCPlugin.2"  width="640"  height="340" id="vlc" loop="yes" autoplay="yes" 
               toolbar="true" allowfullscreen="true"
               windowless="yes" controls="true"
               target="http://'.LIVE_HOST.':'.$row2['stream-port'].'/'.$row2['stream-path'].'.mp4"
               />
               <!--<div class="flowplayer">
               <video>
                  <source type="video/mp4" src="rtsp://'.LIVE_HOST.':1'.$row2['stream-port'].'/'.$row2['stream-path'].'.sdp"/>
               </video>
            </div>-->
            <!--<object width="640" height="368" id="qt" classid="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B"
                codebase="http://www.apple.com/qtactivex/qtplugin.cab">
            <param name="src" value="rtsp://'.LIVE_HOST.':1'.$row2['stream-port'].'/'.$row2['stream-path'].'.sdp">
            <param name="autoplay" value="true">
            <param name="controller" value="false">
            <embed id="plejer" name="plejer" src="/poster.mov" bgcolor="000000" 
                width="640" height="368" scale="ASPECT" 
                qtsrc="rtsp://'.LIVE_HOST.':1'.$row2['stream-port'].'/'.$row2['stream-path'].'.sdp"  kioskmode="true" 
                    showlogo=false" autoplay="true" controller="false" 
                    pluginspage="http://www.apple.com/quicktime/download/">
            </embed></object>-->

               
               </center>';
        echo '<b>'.$row2['cam-name'].'</b>'; 
        echo '<br>';
        echo "live: ".yn($row2['live']).", rec: $row2[rec], mtn: $row2[mtn] <br>";
        //print_r($row2);
        echo ' <a href="'.$row2['source-proto'].'://'.$row2['cam-ip'].':'.$row2['source-port'].'/'.$row2['source-path'].'">source</a>';
        echo ' <a href="http://'.LIVE_HOST.':'.$row2['stream-port'].'/'.$row2['stream-path'].'.mp4">http</a>';
        echo ' <a href="rtsp://'.LIVE_HOST.':1'.$row2['stream-port'].'/'.$row2['stream-path'].'.sdp">rtsp</a>';
        echo ' <a href="http://'.$row2['cam-ip'].':'.$row2['mtn-port'].'/'.$row2['mtn-path'].'">snap</a> ';
        echo ' <a href="http://'.LIVE_HOST.'/cam/curl/proxy.php?cid='.$row2['id'].'">proxy</a> ';
        
        $oid = $row['id'];
        $cam = $row2['cam-name'];
        echo "<a href=\"./vlm.php?oid=$oid&cam=$cam&pref=rec&cmd=play\">record start</a>";
        echo " <a href=\"./vlm.php?oid=$oid&cam=$cam&pref=rec&cmd=stop\">record stop</a>";
        echo '</div>';
    }
    
    echo '<div>';
}

?>
    </body>

</html>
<?php
/*
  <center>
  <embed id="tv" name="tv" type="application/x-vlc-plugin" pluginspage="http://www.videolan.org" version="VideoLAN.VLCPlugin.2" width=720 height=576 autoplay="yes" enablejavascript="true" target="dvb-t://frequency=690000000 :program=6" align=center />
  <script type="text/javascript">
  var vlc = document.getElementById("tv");
  vlc.playlist.add("dvb-t://frequency=746000000 :program=1");
  vlc.playlist.add("dvb-t://frequency=746000000 :program=2");
  vlc.playlist.add("dvb-t://frequency=746000000 :program=15");
  vlc.playlist.add("dvb-t://frequency=746000000 :program=21");
  vlc.playlist.add("dvb-t://frequency=746000000 :program=33");
  vlc.playlist.add("dvb-t://frequency=746000000 :program=32");
  vlc.playlist.add("dvb-t://frequency=746000000 :program=31");
  vlc.playlist.add("dvb-t://frequency=690000000 :program=5");
  vlc.playlist.add("dvb-t://frequency=690000000 :program=3");
  vlc.playlist.add("dvb-t://frequency=690000000 :program=26");
  vlc.playlist.add("dvb-t://frequency=690000000 :program=4");
  vlc.playlist.add("dvb-t://frequency=690000000 :program=23");
  vlc.playlist.add("dvb-t://frequency=690000000 :program=25");
  vlc.playlist.add("dvb-t://frequency=770000000 :program=26");
  vlc.playlist.add("dvb-t://frequency=690000000 :program=6");
  vlc.playlist.add("dvb-t://frequency=690000000 :program=24");
  vlc.playlist.add("dvb-t://frequency=770000000 :program=30");
  vlc.playlist.add("dvb-t://frequency=770000000 :program=29");
  </script>
  <div class="channels">
  <a href="#"  onclick="iptv.load('1'); return false;"><img src="img/ico1.jpg" alt="TVP1" /></a>
  <a href="#"  onclick="iptv.load('2'); return false;"><img src="img/ico2.jpg" alt="TVP2" /></a>
  <a href="#"  onclick="iptv.load('3'); return false;"><img src="img/ico3.jpg" alt="TVP Info Łódź" /></a>
  <a href="#"  onclick="iptv.load('4'); return false;"><img src="img/ico4.jpg" alt="TVP Info Warszawa" /></a>
  <a href="#"  onclick="iptv.load('5'); return false;"><img src="img/ico5.jpg" alt="TVP Polonia" /></a>
  <a href="#"  onclick="iptv.load('6'); return false;"><img src="img/ico6.jpg" alt="TVP Historia" /></a>
  <a href="#"  onclick="iptv.load('7'); return false;"><img src="img/ico7.jpg" alt="TVP Kultura" /></a>
  <a href="#"  onclick="iptv.load('8'); return false;"><img src="img/ico8.jpg" alt="TV4" /></a>
  <a href="#"  onclick="iptv.load('9'); return false;"><img src="img/ico9.jpg" alt="Polsat" /></a>
  <a href="#"  onclick="iptv.load('10'); return false;"><img src="img/ico10.jpg" alt="Polsat Sport News" /></a>
  <a href="#"  onclick="iptv.load('11'); return false;"><img src="img/ico11.jpg" alt="TVN" /></a>
  <a href="#"  onclick="iptv.load('12'); return false;"><img src="img/ico12.jpg" alt="TVN7" /></a>
  <a href="#"  onclick="iptv.load('13'); return false;"><img src="img/ico13.jpg" alt="TV6" /></a>
  <a href="#"  onclick="iptv.load('14'); return false;"><img src="img/ico14.jpg" alt="TTV" /></a>
  <a href="#"  onclick="iptv.load('15'); return false;"><img src="img/ico15.jpg" alt="TV Puls" /></a>
  <a href="#"  onclick="iptv.load('16'); return false;"><img src="img/ico16.jpg" alt="TV Puls 2" /></a>
  <a href="#"  onclick="iptv.load('17'); return false;"><img src="img/ico17.jpg" alt="ATM Rozrywka" /></a>
  <a href="#"  onclick="iptv.load('18'); return false;"><img src="img/ico18.jpg" alt="Eska TV" /></a>
  <a href="#"  onclick="iptv.load('19'); return false;"><img src="img/ico19.jpg" alt="Polo TV" /></a>
  </div>
  </span> */
?>