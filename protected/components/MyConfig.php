<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class MyConfig extends CComponent
{
    //const VLC_LIVE_IP = '10.154.28.203';
    //const VLC_LIVE_RPC_PATH = '/rpc/main_rpc.php?token=';
    const VLC_LIVE_RPC_PATH = '/out/rpc/native.php?token=';
    const NGINX_SECURE_LINK_HASH = '{phrase}{expire}{http_port}';
    //const NGINX_SECURE_LINK_HASH = 'dvr{expire}{http_port}';
    const NGINX_SECURE_LINK_EXPIRE = 30;    //30 секунд
    const MOTION_STREAM_PORT = 55300;
    const VLC_STREAM_PORT = 9000;

    public function __construct(){
    }

    public static function getLiveRPCUrl($token){
        //return 'http://'.MyConfig::VLC_LIVE_IP.MyConfig::VLC_LIVE_RPC_PATH.$token;
        return 'http://'.Yii::app()->params->vlcLiveHost.MyConfig::VLC_LIVE_RPC_PATH.$token;
    }

    public static function getVlcLiveIP(){
        //return MyConfig::VLC_LIVE_IP;
        return Yii::app()->params->vlcLiveHost;
    }

    protected static function getNginxSecureString($phrase, $pattern, $expire, $port){
        return str_replace(array('{phrase}', '{expire}','{http_port}'),array($phrase, $expire, $port), $pattern);
    }

    protected static function getNginxSecureHash($secure){
        $hash = md5($secure, true);
        return strtr( base64_encode($hash), array( '+' => '-', '/' => '_', '=' => '' ));
    }

    protected static function getNginxSecureUrl($ip,$phrase ,$pattern, $port, $short = false, $expire = 0){
        if(!$expire) $expire = MyConfig::getNginxSecureExpire();
        else $expire = time() + $expire;

        $secure = MyConfig::getNginxSecureString($phrase, $pattern, $expire, $port);
        $hash = MyConfig::getNginxSecureHash($secure);

        //$url = "http://{ip}/$phrase/?k={hash}&e={e}&id={id}";
        $url = "/$phrase/?k={hash}&e={e}&id={id}";
        if($short)
            $url = "/$phrase/?k={hash}&e={e}&id={id}";

        return str_replace(array('{ip}', '{hash}', '{e}', '{id}'), array(
            $ip,
            $hash,
            $expire,
            $port,
        ), $url);
    }

    protected static function getNginxSecureExpire(){
        return time() + MyConfig::NGINX_SECURE_LINK_EXPIRE;
    }

    public static function getNginxVlcStream($id){
        return MyConfig::getNginxSecureUrl(MyConfig::getVlcLiveIP(), 'dvr',MyConfig::NGINX_SECURE_LINK_HASH, $id + MyConfig::VLC_STREAM_PORT);
    }

    public static function getNginxMotionStream($id) {
        return MyConfig::getNginxSecureUrl(MyConfig::getVlcLiveIP(), 'motion' ,MyConfig::NGINX_SECURE_LINK_HASH, $id + MyConfig::MOTION_STREAM_PORT);
    }

    public static function getNginxImgUrl($id) {
        return MyConfig::getNginxSecureUrl($_SERVER['SERVER_ADDR'], 'snapshot' ,MyConfig::NGINX_SECURE_LINK_HASH, "/".Yii::app()->user->id."/".$id."/lastsnap.jpg", true);
    }

    public static function getNginxArchiveUrl($id, $download = 0) {
        if($download)
            return MyConfig::getNginxSecureUrl($_SERVER['SERVER_ADDR'], 'ad' ,MyConfig::NGINX_SECURE_LINK_HASH, $id, true);
        else
            return MyConfig::getNginxSecureUrl($_SERVER['SERVER_ADDR'], 'archive' ,MyConfig::NGINX_SECURE_LINK_HASH, $id, true);
    }
}