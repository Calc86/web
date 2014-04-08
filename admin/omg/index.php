<?php
define("INDEX",1);
require("../func.php");

ini_set('display_errors',1);
ini_set('register_globals','Off');

$db = open_db("localhost", "cam", "campass", "cam");

?>
<html>
    <head>
        <title>OMG admin</title>
    </head>
    <body>
        <table>
            <tr>
                <td><a href="?l=oko">oko</a></td>
                <td><a href="?l=doall">doall</a></td>
                <td><a href="?l=rec">rec</a></td>
                <td><a href="?l=mtn">mtn</a></td>
                <td><b>log:</b></td>
                <td><a href="?l=log&n=rc">rc.log</a></td>
                <td><a href="?l=log&n=startup">startup.log</a></td>
                <td><b>links:</b></td>
                <td><a target="_blank" href="/vlc/tmp/video.php?org=ruben&cam=cam1">video.php</a></td>
                <td><a target="_blank" href="/phpmyadmin/">mysql</a></td>
                <td><a target="_blank" href="/munin/">munin</a></td>
                <td><b>vlc:</b></td>
                
                <td>
                <?php
                    $q = "select name from org";
                    $r = mysql_query($q);
                    while($row = mysql_fetch_row($r)){
                        echo "<a href=\"?l=log&n=$row[0]/vlc\">$row[0]/vlc.log</a> ";
                    }
                ?>
                </td>
            </tr>
        </table>
        <?php
        $l = get_var('l','oko');
        $n = get_var('n');
        switch($l){
            case 'log':
                $src="./log.php?log=$n.log";
                break;
            case 'doall':
                $src="/cam/admin/mods/doall.mod.php";
                break;
            case 'rec':
                $src="/vlc/rec/";
                break;
            case 'mtn':
                $src="/vlc/mtn/";
                break;
            case 'oko':
            default:
                $src = "/cam/oko.php";
        }
        ?>
        <iframe src="<?php echo $src; ?>" width="100%" height="90%">
        
        </iframe>
    </body>
</html>