<?php
/**
 * Created by PhpStorm.
 * User: calc
 * Date: 10.06.14
 * Time: 11:57
 */

namespace ping;


class Web {
    public static function getVar($var, $default = ''){
        return isset($_GET[$var]) ? $_GET[$var] : $default;
    }
    //$q = "select u.id as uid, c.id as id, c.ip as ip from users as u, cams as c where u.id=c.user_id and u.banned=0 and c.live = 1";
    public function get($needStatus = '', $needTest = ''){

        $json = array();

        $q = "select ip from ips where hide=0";
        $r = Database::getInstance()->query($q);

        $path = realpath($_SERVER['DOCUMENT_ROOT'].'/state');
        while(($row = $r->fetch_row()) != false){
            list($host) = $row;

            //$json[$host] = array();
            $hostPath = $path.'/'.$host;
            if(is_dir($hostPath)){
                $d2 = dir($hostPath);
                /** @var $d \Directory */
                while (false !== ($test = $d2->read())) {
                    //if($entry == '.' || $entry == '..') continue;
                    if(!is_file($hostPath.'/'.$test)) continue;

                    //берем только файлы за последние 2 минуты
                    if(filectime($hostPath.'/'.$test) < time()-120) continue;

                    $buf = file_get_contents($hostPath.'/'.$test);
                    $csv = str_getcsv($buf, ';');
                    list($ip, $t, $status, $time) = $csv;
                    if(($status == $needStatus || $needStatus == '') && ($t == $needTest || $needTest == ''))
                        $json[$host][$test] = $csv;
                }
                $d2->close();
            }
            //if(!count($json[$host]))
            if(!isset($json[$host]) && $needStatus == "")
            {
                $json[$host] = array('unknown');
            }
        }

        return json_encode($json);
        //return $json;
    }
}
