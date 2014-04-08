<?php
/*
 * Скрипт нужно проверять на отдельно взятых камерах и дописывать в комменты с какими камерами заработало.
 */

$cid = get_var('cid',0);
$ip = get_var('ip');
$port = get_var('port');
$path= get_var('path');
$user = get_var('user');
$pass = get_var('pass');
$mode = get_var('mode');

//if($ip=='' || $port=='' || $path=='' || $user=='' || $pass=='') exit();
//print_r($_GET);

function get_var($var, $def = ''){
    if(isset($_GET[$var]))
        return $_GET[$var];
    else
        return $def;
}

switch ($mode){
    //HTTP авторизация, обычно на камерах DLink
    case 'dlink':
        $url = "http://$ip:$port/$path";
        $ch = curl_init();       
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);    
        curl_setopt($ch, CURLOPT_URL, $url);    
        curl_setopt($ch, CURLOPT_USERPWD, "$user:$pass");    
        $result = curl_exec($ch);    
        curl_close($ch);    
        
        $im = imagecreatetruecolor(640,368);
        $imc = imagecreatefromstring($result);
        imagecopy($im,$imc,0,0,0,0,640,360);
        header('Content-type: image/jpeg'); 
        imagejpeg($im);
        
        
        //echo $result;   
        
        break;
    //cookie авторизация
    case 'ubqt':
        $dir = ".";
        $ck = "$dir/tmp/$cid-cookie.txt";
        $url = "http://$ip:$port/login.cgi";
        //$jpg = "$dir/tmp/$cid.jpg";
        //$cmd = "curl -c $ck $url && curl -o $jpg -LH 'Expect:' -b $ck -F username=$user -F password=$pass -F uri=$path $url";
        //exec($cmd);
        $cmd = "curl -c $ck $url --connect-timeout 1 >/dev/null 2>/dev/null && curl --connect-timeout 1 -LH 'Expect:' -b $ck -F username=$user -F password=$pass -F uri=$path $url";
        //echo $cmd;
        header('Content-type: image/jpeg');
        echo shell_exec($cmd);

        //$buf = file_get_contents($jpg);
        //echo $buf;
        break;
    //еще не реализовано
    case 'http':
    default:
        $url = "http://www.example.com/protected/";   
        $ch = curl_init();       
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);    
        curl_setopt($ch, CURLOPT_URL, $url);    
        curl_setopt($ch, CURLOPT_USERPWD, "myusername:mypassword");    
        $result = curl_exec($ch);    
        curl_close($ch);    
        echo $result;   
        break;
}



?>
