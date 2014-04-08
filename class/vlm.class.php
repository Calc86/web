<?php
/*
new ruben_cam1_live broadcast enabled
setup ruben_cam1_live input "rtsp://10.112.249.47:10001/live/ch00_0"
setup ruben_cam1_live output http-reconnect
setup ruben_cam1_live output http-continious
setup ruben_cam1_live output #std{access=http{mime=multipart/x-mixed-replace;boundary=--myboundary},mux=ts,dst=*:9001}
control ruben_cam1_live play
 */

class vlc_http{
    protected $msg;
    protected $ip;
    protected $port;
    protected $url;
    protected $fullurl;
    
    public function __construct($port,$url) {
        $this->ip = '10.112.28.35';
        $this->port = $port;
        $this->set_url($url);
        //$this->full_url();
        //print_r($this);
    }
    
    protected function set_url($url) {
        $this->url = $url;
        $this->full_url();
    }
    
    protected function full_url() {
        $this->fullurl = "http://$this->ip:$this->port/$this->url";
    }
    
    protected function cmd($cmd) {
        $this->msg = '';
        $f = fopen($this->fullurl.rawurlencode($cmd),"r");
        while ($buf=fread($f, 1024)){
            $this->msg.=$buf;
        }
        fclose($f);
    }
}

class vlm extends vlc_http{
    //protected $msg;
    //protected $ip;
    //protected $port;
    //protected $url;
    //protected $fullurl;
    
    //public function __construct($ip,$port) {
    public function __construct($port) {
        parent::__construct($port, 'requests/vlm_cmd.xml?command=');
        //$this->ip = '10.112__28.35';
        //$this->port = $port;
        //$this->url = 'requests/vlm_cmd.xml?command=';
        //$this->fullurl = "http://$this->ip:$this->port/$this->url";
    }
    
    public function _new($cam) {
        $this->cmd("new $cam broadcast enabled");
    }
    
    public function _setup($cam, $cmd,$io=1) {
        $direction = '';
        switch ($io) {
            case 0:
                $direction = 'input';
                //$this->cmd("setup $cam input \"$cmd\"");
                break;
            case 1:
            default:
                $direction = 'output';
                //$this->cmd("setup $cam output $cmd");
                break;
        }
        $cmd = "setup $cam $direction $cmd";
        //echo $cmd;
        $this->cmd($cmd);
    }
    
    public function _control($cam,$cmd) {
        $this->cmd("control $cam $cmd");
    }
    
    public function message() {
        return $this->msg;
    }
}

class org_vlm extends vlm{
    protected $org;
    protected $oid;
    public function __construct($oid,$org) {
        $port = 8100+$oid;
        parent::__construct($port);
        $this->org = $org;
        $this->oid = $oid;
    }
}

class cam_vlm extends org_vlm{
    protected $cam;
    protected $pref;
    protected $full;
    
    public function __construct($oid, $org, $cam, $pref) {
        parent::__construct($oid, $org);
        
        $this->set_cam($cam);
        $this->set_pref($pref);
        $this->full_cam();
    }
    
    protected function full_cam() {
        $this->full = $this->org.'_'.$this->cam.'_'.$this->pref;
    }
    
    protected function set_cam($cam) {
        $this->cam = $cam;
        //$this->full_url();
    }
    
    protected function set_pref($pref) {
        $this->pref = $pref;
        //$this->full_url();
    }
}

class cam_control extends cam_vlm{
    //protected $org;
    //protected $cam;
    //protected $pref;
    //protected $full;
    
    public function __construct($oid,$org,$cam,$pref='live') {
        //$port = 8100+$oid;
        parent::__construct($oid, $org, $cam, $pref);
        //$this->org = $org;
        //$this->cam = $cam;
        //$this->pref = $pref;
        //$this->full = $this->org.'_'.$this->cam.'_'.$this->pref;
    }
    
    public function play() {
        switch($this->pref){
            case 'rec':
            case 'mtn':
                //send "output #std{access=file,mux=ts,dst=/home/calc/vlc/$pref/$org/$date/$full.avi}"
                $date = date("Y-m-d");
                $time = date("H:i:s");
                
                $path = "/home/calc/vlc/$this->pref/$this->org/$date";
                if(!file_exists($path)){
                    mkdir($path);
                }
                $cmd = "#std{access=file,mux=ts,dst=$path/$time".'_'."$this->full.avi}";
                //echo $cmd;
                $this->_setup($this->full, $cmd);
                $this->_control($this->full, 'play');
                break;
            case 'live':
            default:
                $this->_control($this->full, 'play');
                break;
        }
    }
    
    public function stop() {
        $this->_control($this->full, 'stop');
    }
}


//TODO убрать pref из конструктора, статус формировать по pref и все функции возвращать по pref
//pref = префикс rec или mtn или live
class cam_status extends cam_vlm{
    protected $sxml;
    protected $status;  //[cam][pref]
    
    public function __construct($oid, $org, $cam, $pref='') {
        parent::__construct($oid, $org, $cam, $pref);
        $this->set_pref($pref);
        $this->set_url('requests/vlm.xml');
        $this->cmd('');
        $this->status = array();
        
        //парсим 
        $this->parse();
    }
    
    protected function parse() {
        $this->sxml = new SimpleXMLElement($this->message());
        //print_r($this->sxml);
        
        if(property_exists($this->sxml , 'broadcast')){
            $cam = array();
            foreach($this->sxml->broadcast as $bc){
                
                //echo $this->full;
                
                $c_org = '';
                $c_name = '';
                $c_pref = '';
                
                $a = explode('_', $bc['name']);
                //print_r($a);
                $c_org = $a[0];
                $c_name = $a[1];
                $c_pref = $a[2];
                
                $cam = $bc;
                
                foreach($cam->attributes() as $n=>$v){
                    $this->status[$c_name][$c_pref][$n] = (string) $v;
                }   
                
                foreach($cam as $n=>$v){
                    switch($n){
                        case 'output':
                            $this->status[$c_name][$c_pref][$n] = (string) $v;
                            break;
                        case 'inputs':
                            $this->status[$c_name][$c_pref]['input'] = (string) $v->input;
                            break;
                        case 'instances':
                            $this->status[$c_name][$c_pref]['state'] = (string)$cam->instances->instance['state'];
                            break;
                    }
                }
                if(!isset($this->status[$c_name][$c_pref]['state']))
                    $this->status[$c_name][$c_pref]['state'] = 'stopped';
            }
            
        }
    }
    
    public function status($cam,$pref) {
        return $this->status[$cam][$pref];
    }
    
    public function state($cam,$pref) {
        if($this->status[$cam][$pref]['state'] == 'playing')
            return 1;
        else
            return 0;
    }
    
    public function xml() {
        header("Content-Type: text/xml");
        return $this->message();
    }
}

