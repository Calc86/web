<?php
//print_r($_SESSION);
/*
 * ses vars
 * [mod][archive][year]
 *               [month]
 *               [day]
 * 
 * 
 * ffmpeg -fflags +genpts -i 0000.mp4 -codec copy 000.mp4
 */

require_once './class/calendar.class.php';
require_once './class/records.class.php';
require_once './class/record.class.php';

$mod = getMod(__FILE__);

//$user = ses_var('login');
$user = db_field('org', ses_var('id'), $n = 'login');

$myvars = array();
if (isset($_SESSION['mod'][$mod])) {
    $myvars = $_SESSION['mod'][$mod];
}

$day = (int) get_var('day', get_ar($myvars, 'day', 0));
if( $day < 0 || $day > 31) $day= (int)date('d');
$month = (int) get_var('month', get_ar($myvars, 'month', date('m')));
if( $month < 0 || $month > 12) $month= (int)date('m');
$year = (int) get_var('year', get_ar($myvars, 'year', date('Y')));

$cam = get_var('cam', get_ar($myvars, 'cam', 0));
$hour = get_var('hour', get_ar($myvars, 'hour', 0));
$min = get_var('min', get_ar($myvars, 'min', 0));

$_SESSION['mod'][$mod]['day'] = $day;
$_SESSION['mod'][$mod]['month'] = $month;
$_SESSION['mod'][$mod]['year'] = $year;

$_SESSION['mod'][$mod]['cam'] = $cam;
$_SESSION['mod'][$mod]['hour'] = $hour;
$_SESSION['mod'][$mod]['min'] = $min;

//print_r($_SESSION);

$rs = new records($user);
$rcal = $rs->calendar();

$cal = new calendar($year, $month);
$calendar = $cal->Display();

if (!$day) {
    /*
    <!-- calendar -->
                <div id="calendar" class="content">
                    <table class="month">
                        <tr>
                            <td class="lt"><a href="#">&nbsp;</a></td>
                            <td>3</td><td>4</td>
                            <td class="cur">7</td>
                            <td>5</td><td>6</td>
                            <td class="gt"><a href="#">&nbsp;</a></td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td class="header">
                                &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td class="body">
                                <table>
                                     <tr>
                                        <td>1</td>
                                        * ...
                                    </tr>
                                     *  ...
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
                <!-- calendar -->
     */
    
    $body.= '<div id="calendar">';
    $body.= '<div class="year">'.$year.'</div>';
    $body.= '<table class="month">';
    $body.= '   <tr>';
    $body.= '        <td class="lt"><a href="?mod=' . $mod . '&' . ($cal->getPrevMonth() ? 'month=' . $cal->getPrevMonth() : 'year=' . $cal->getPrevYear() . '&month=12') . '">&nbsp;</a></td>';
    $body.= '        <td>' . ($cal->getPrevMonth(2) ? $cal->getMonthName($cal->getPrevMonth(2)) : '') . '</td>';
    $body.= '        <td>' . ($cal->getPrevMonth(1) ? $cal->getMonthName($cal->getPrevMonth(1)) : '') . '</td>';
    $body.= '        <td class="cur">'.$cal->getMonthName($month).'</td>';
    $body.= '        <td>' . ($cal->getNextMonth(1) ? $cal->getMonthName($cal->getNextMonth(1)) : '') . '</td>';
    $body.= '        <td>' . ($cal->getNextMonth(2) ? $cal->getMonthName($cal->getNextMonth(2)) : '') . '</td>';
    $body.= '        <td class="gt"><a href="?mod=' . $mod . '&' . ($cal->getNextMonth() ? 'month=' . $cal->getNextMonth() : 'year=' . $cal->getNextYear() . '&month=1') . '">&nbsp;</a></td>';
    $body.= '    </tr>';
    $body.= '</table>';
    
    $body.= '<table>';
    $body.= '    <tr>
                    <td class="header">
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td class="body">
                        <table>';
    /*for($i=1;$i<=7;$i++){
        $body.= '<td>'.$cal->getDayName($i).'</td>';
    }*/
    $body.= '</tr>';
    foreach ($calendar[$year][$month] as $wno => $week) {
        $body.= '<tr>';
        //$body.= '<td class="wno">' . $wno . '</td>';
        foreach ($week as $dno => $day) {

            if (isset($rcal[$year][$month][$day])) {
                $day = '<a href="?mod=' . $mod . '&day=' . $day . '">' . $day . '</a>';
            }

            $day = ($day ? $day : '&nbsp;');

            $body.= '<td>' . $day . '</td>';
        }
        $body.= '</tr>';
    }
    
    $body.= '           </table>
                    </td>
                </tr>
            </table>';
    $body.= '</div>';
    
    /*
    $body.= '<table class="archive">';
    $body.= '<tr><td class="year" colspan="8">';
    $body.= '<table width="100%" class="year"><tr>
            <td class="lt"><a href="?mod=' . $mod . '&year=' . $cal->getPrevYear() . '">&lt;&lt;</a></td>
            <td class="year" align="center">' . $year . '</td>
            <td class="gt" align="right"><a href="?mod=' . $mod . '&year=' . $cal->getNextYear() . '">&gt;&gt;</a></td>
            </tr></table>';
    $body.= '</td></tr>';
    $body.= '<tr><td class="month" colspan="8">';
    $body.= '<table width="100%" class="month"><tr>
            <td class="lt"><a href="?mod=' . $mod . '&' . ($cal->getPrevMonth() ? 'month=' . $cal->getPrevMonth() : 'year=' . $cal->getPrevYear() . '&month=12') . '">&lt;</a></td>
            
            <td class="month" align="center">' . 
            '<span>' . ($cal->getPrevMonth(2) ? $cal->getMonthName($cal->getPrevMonth(2)) : '') . '</span> ' .
            '<span>' . ($cal->getPrevMonth(1) ? $cal->getMonthName($cal->getPrevMonth(1)) : '') . '</span> ' .
            '<b>'.$cal->getMonthName($month).'</b>' . 
            ' <span>' . ($cal->getNextMonth(1) ? $cal->getMonthName($cal->getNextMonth(1)) : '') . '</span>' .
            ' <span>' . ($cal->getNextMonth(2) ? $cal->getMonthName($cal->getNextMonth(2)) : '') . '</span>' .
            '</td>
                
            <td class="gt" align="right"><a href="?mod=' . $mod . '&' . ($cal->getNextMonth() ? 'month=' . $cal->getNextMonth() : 'year=' . $cal->getNextYear() . '&month=1') . '">&gt;</a></td>
            </tr></table>';
    $body.= '</td></tr>';
    $body.= '<tr class="header"><td>#</td>';
    for($i=1;$i<=7;$i++){
        $body.= '<td>'.$cal->getDayName($i).'</td>';
    }
    $body.= '</tr>';
    foreach ($calendar[$year][$month] as $wno => $week) {
        $body.= '<tr>';
        $body.= '<td class="wno">' . $wno . '</td>';
        foreach ($week as $dno => $day) {

            if (isset($rcal[$year][$month][$day])) {
                $day = '<a href="?mod=' . $mod . '&day=' . $day . '">' . $day . '</a>';
            }

            $day = ($day ? $day : '&nbsp;');

            $body.= '<td>' . $day . '</td>';
        }
        $body.= '</tr>';
    }
    $body.= '</table>';*/
} else {
    
    $body.= '<div class="archive">';
    
    $body.= "<br>Архив за " . sprintf('%04d-%02d-%02d', $year, $month, $day);
    $body.= '<br><a href="?mod=' . $mod . '&day=0&cam=0">К календарю</a>';
    //$path = $rs->getPath().'/'.$rs->getDirName($year, $month, $day);
    //echo $path;
    $rec = new record($user, $rs->getDirName($year, $month, $day));
    $list = $rec->Display();
    $body.= '<br>';
    if (!$cam) {
        
        foreach ($list as $cam => $ar) {
            $body.='
            <div class="frame">
                <div class="cam"></div>';
            $body.= '<a href="?mod=' . $mod . '&cam=' . $cam . '&hour=0&min=0" class="name">' . $cam . '</a>';
            $body.= '</div>';
        }
                
        
        /*foreach ($list as $cam => $ar) {
            $body.= '<a href="?mod=' . $mod . '&cam=' . $cam . '&hour=0&min=0">' . $cam . '</a><br>';
        }*/
    } else {
        $body.= '<table width="90%"><tr><td valign="top">';
        
        $body.= "Камера: $cam".  nl();
        $body.= '<br><a href="?mod=' . $mod . '&cam=0">К выбору камеры</a><br>'.  nl();

        if (isset($list[$cam])) {
            if (isset($list[$cam][$hour][$min])) {
                //плеер для проигрывания видео
                $name = $list[$cam][$hour][$min];
                $file = $rec->ptsme($name);
                //echo '<a href="'.$rec->getWebPath().'/'.$list[$cam][$hour][$min].'">'.$rec->getWebPath().'/'.$list[$cam][$hour][$min].'</a>';
                //$file = 'http://10.112__28.35/vlc/rec/ruben/2013-06-04/000.mp4';
                //http://10.112__28.35:9001/qwer1.mp4
                
                $body.= '
                <video width="640" height="360" src="' . $file . '" type="video/mp4" 
                       id="player1" poster="../media/echo-hereweare.jpg" 
                       controls="controls" preload="none"></video>';

                $body.= "\n<script>
                    $('audio,video').mediaelementplayer({
                        success: function(player, node) {
                            $('#' + node.id + '-mode').html('mode: ' + player.pluginType);
                        }
                    });
                </script>\n\n<br>";
                
                $body.= sprintf("%02d:%02d ", $hour, $min);
                $body.= '<a href="' . $file . '">Скачать</a>'.NL;
            }
            
            $body.= '</td><td>';
            
            $body.= '<table border="1" align="right" bgcolor="#444444">'.  nl();
            $now = date('Y-m-d H:') . (((int) (date('i') / 10)) * 10);
            //echo $now;
            //echo $date;
            foreach ($list[$cam] as $h => $ar) {
                $body.= '<tr><td>' . $h . '</td>';
                foreach ($ar as $m => $name) {
                    $date = sprintf('%04d-%02d-%02d %02d:%02d', $year, $month, $day, $h, $m);
                    if ($date != $now)
                        $body.= '<td><a href="?mod=' . $mod . '&hour=' . $h . '&min=' . $m . '">' . $m . '</a></td>';
                }
                $body.= '</tr>';
            }
            $body.= '</table>';
        }
        $body.= '</td></tr></table>';
    }
    
    $body.= '</div>';

    //$body.= '<pre><br><br>';
    //print_r($rec);
    //$records = $rec->getRecords();
    //print_r($records);
    //$list = $rec->Display();
    //print_r($list);
}



//debug
//echo '<pre><br><br>';
//$rs->dateFilter();
//$path2 = $rs->getPath().'/'.$rs->getDirName($year, $month, $day);
//echo $path2;

/* $rec = $rs->getRecords();
  print_R($rec); */
//print_r($rs->calendar());
/* echo '<br><br><br>';
  print_r($cal->Display()); */



/*
<!-- на черный день
<object id="MediaPlayer1" CLASSID="CLSID:22d6f312-b0f6-11d0-94ab-0080c74c7e95" codebase="http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=5,1,52,701"
standby="Loading Microsoft Windows® Media Player components..." type="application/x-oleobject" width="280" height="256">
<param name="fileName" value="<?= $file ?>">
<param name="animationatStart" value="true">
<param name="transparentatStart" value="true">
<param name="autoStart" value="true">
<param name="showControls" value="true">
<param name="Volume" value="-450">
<embed type="application/x-mplayer2" pluginspage="http://www.microsoft.com/Windows/MediaPlayer/" src="<?= $file ?>" name="MediaPlayer1" width=280 height=256 autostart=1 showcontrols=1 volume=-450>
</object>-->*/


?>