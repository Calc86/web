<?php
    $id = ses_var('id');

    $body.= '<div>';

    $q2 = "select * from cam where oid=$id and live=1";
    $r2 = mysql_query($q2);
    while($row2 = mysql_fetch_assoc($r2)){
        //print_r($row2);
        $body.= '<div style="display: inline-block; border: 0px solid black; width: 650px;">';
        //echo '<h5>'.$row2['cam_name'].'</h5>';
        $body.= '<b>'.$row2['cam-name'].'</b>'; 
        $body.= '<center>
            <embed type="application/x-vlc-plugin" pluginspage="http://www.videolan.org"
               version="VideoLAN.VLCPlugin.2"  width="640"  height="340" id="vlc" loop="yes" autoplay="yes" 
               toolbar="false" allowfullscreen="true"
               windowless="yes" controls="true"
               target="http://'.LIVE_HOST.':'.$row2['stream-port'].'/'.$row2['stream-path'].'.mp4"
               />
               </center>';

        $body.= '</div>';
    }

    $body.= '<div>';
?>