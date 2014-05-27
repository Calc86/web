<?php
/*
 *  http://gggeek.altervista.org/sw/xmlrpc/debugger/
 *  213.109.29.1
 *  /cam/server/xmlrpcs.php 
 * 
 */
ini_set('display_errors', 1);
include './xmlrpc-2.2.2/lib/xmlrpc.inc';
include './xmlrpc-2.2.2/lib/xmlrpcs.inc';

/*if ($_SERVER['REQUEST_METHOD'] != 'POST' && isset($_GET['showSource']))
{
	highlight_file(__FILE__);
	die();
}*/

/*
 * xmlrpc functions table
 */

$ft = array(
    "examples.myFunc"           => array("function" => "probka"),
    //infi
    "info.you_version"          => array("function" => "probka"),
    "info.my_version"           => array("function" => "probka"),
    //путь запуска программы
    "auth.i_find_you"           => array("function" => "probka"),
    "auth.it_is_me"             => array("function" => "probka"),
    "auth.get_my_passport"      => array("function" => "probka"),
    "auth.where_is_my_vpn"      => array("function" => "probka"),
    //путь vpn'a, смотреть на авторизацию по IP от vpn'a
    "control.give_me_settings"  => array("function" => "probka"),
    "control.test_my_ports"     => array("function" => "probka"),
    "control.start_my_server"   => array("function" => "probka"),
    //довести сервер до белого коленя
    "control.tick"              => array("function" => "probka")
);

function probka($params) {
    //заглушка
    print_r($params);
}

function i_find_you($params) {
    
}

$s = new xmlrpc_server($ft);
?>