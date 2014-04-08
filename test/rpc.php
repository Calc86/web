<?php

ini_set('display_errors', 1);
echo '<pre>';
require_once 'Zend/XmlRpc/Client.php'; 

$client = new Zend_XmlRpc_Client('http://10.112.28.202/rpc/vlc.php?token=4');
 
// Создание прокси-объекта к пространству имен "test"
$vlc  = $client->getProxy('vlc');
//echo '<pre>';
//print_r($vlc);
 
//$hello = $test->sayHello(1, 2);
// test.Hello(1,2) возвращает "hello"
$ret = $vlc->cam_play(7,'live');

echo rawurldecode($ret);

?>
