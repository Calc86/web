<?php
/**
 * Created by PhpStorm.
 * User: calc
 * Date: 10.06.14
 * Time: 10:56
 */

require_once __DIR__.'/interfaces/include.php';
require_once __DIR__.'/classes/include.php';

ini_set('display_errors', 1);

function handleError($err_no, $err_str, $err_file, $err_line, array $err_context)
{
    // error was suppressed with the @-operator
    if (0 === error_reporting()) {
        return false;
    }

    throw new Exception($err_str);
}
set_error_handler('handleError', E_ALL);


$db = \ping\Database::getInstance();

$q = "select u.id as uid, c.id as id, c.ip as ip from users as u, cams as c where u.id=c.user_id and u.banned=0 and c.live = 1";

$r = $db->query($q);

/*$hosts = array(
    '10.154.28.203'
);*/

$ports = array();

while( ($row = $r->fetch_row()) != false ){
    list($uid, $cid, $ip) = $row;
    $hosts[$ip] = array();
    $ports[$uid] = array('port', array(8100 + $uid),   array());
    $ports[$cid] = array('port', array(9000 + $cid),   array());
}

$defaultRules = array('down', 'state');
$default = array('fping', array(), array());
$hosts['10.154.28.203'] = $ports;

$ping = new \ping\Ping($hosts, $default, $defaultRules);

if(file_exists('hosts'))
    unlink('hosts');

foreach($hosts as $host=>$tests)
{
    \ping\Bash::execute("echo $host >>hosts");
}

$tester = \ping\Tester::getInstance();
$lock = new \ping\Lock('test');

if(!$lock->create()){
    // вдруг система перезагрузилась во время update
    $lock->wait(5*60);
    $lock->delete();
    $lock->create();
}

$tester->test($ping->getHosts());

$lock->delete();
