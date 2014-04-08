<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class MyConfig extends CComponent
{
    const VLC_LIVE_IP = '10.154.28.202';
    const VLC_LIVE_RPC_PATH = '/rpc/main_rpc.php?token=';

    public function __construct(){
    }

    public static function getLiveRPCUrl($token){
        return 'http://'.MyConfig::VLC_LIVE_IP.MyConfig::VLC_LIVE_RPC_PATH.$token;
    }

    public static function getVlcLiveIP(){
        return MyConfig::VLC_LIVE_IP;
    }
}