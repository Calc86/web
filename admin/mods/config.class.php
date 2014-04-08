<?php
/*
 * OLD DO NOT UPDATE!!!
 */
define("INDEX",1);
require("../func.php");

ini_set('display_errors',1);
ini_set('register_globals','Off');

$db = open_db("localhost", "cam", "campass", "cam");

class config{
    protected $_oid;
    protected $_org_name;
    //protected $_tmp;
    protected $_live;
    protected $_rec;
    protected $_mtn;
    protected $_log;
    
    public function __construct($oid=0) {
        $this->_oid = 0;
        $tmp = $this->get_tmp();
        $this->split_tmp($tmp);
        if(!$oid) return;
        $this->set_org($oid);
    }
    
    public function set_org($oid){
        $this->_oid = $oid;
        $q = "select name from org where id=$oid";
        $r = mysql_query($q);
        $n = mysql_num_rows($r);
        if(!$n) return;
        list($this->_org_name) = mysql_fetch_array($r);
    }
    
    protected function get_tmp(){
        return file_get_contents("/var/www/html/vlc/etc/cam.tmp.vlm");
    }
    
    protected function split_tmp($tmp) {
        $a = explode('<cam>', $tmp);
        $cam = $a[1];
        $a = explode('<live>', $cam);
        $this->_live = $a[1];
        $a = explode('<rec>', $cam);
        $this->_rec = $a[1];
        $a = explode('<mtn>', $cam);
        $this->_mtn = $a[1];
    }

    protected function get_search($row,$array=array()) {
        //return array('{id}','{oid}','{org-name}','{cam-name}','{source}','{stream-port}');
        $ar = array();
        
        foreach($row as $k=>$v){
            $ar[]='{'.$k.'}';
        }
        
        return array_merge($ar,$array);
    }
    
    protected function get_replace($row,$array=array()) {
        $ar = array();
        
        foreach($row as $v){
            $ar[]=$v;
        }
        
        return array_merge($ar,$array);
    }
    
    protected function db_var($row) {
        $ar = array();
        foreach($row as $k => $v){
            $k = "row_".str_replace("-", "_", $k);
            $ar[$k]=$v;
        }
        return $ar;
    }
    
    public function mplayer_etc() {
        return $this->ffmpeg_etc();
    }
    
    public function mplayer_bin() {
        if(!$this->_oid) return '';
        $ff = file_get_contents("/home/calc/vlc/bin/mplayer.sh.tmp");
        $buf = array();
        
        //$search =  $this->get_search();
        
        $q = "select * from cam where oid=$this->_oid";
        $r = mysql_query($q);
        
        while($row = mysql_fetch_assoc($r)){
            $dbv = $this->db_var($row);
            foreach ($dbv as $k=>$v) $$k=$v;
            $search =  $this->get_search($row,array('{org-name}'));
            $replace = $this->get_replace($row,array($this->_org_name));
            if($row_live){
                if($row_mtn)
                    $buf[$row_cam_name] = str_replace($search, $replace, $ff);
            }
        }
        
        return $buf;
    }
    
    public function ffmpeg_etc() {
        if(!$this->_oid) return '';
        $buf = '';
        
        //$search =  $this->get_search();
        
        $q = "select * from cam where oid=$this->_oid";
        $r = mysql_query($q);
        
        while($row = mysql_fetch_assoc($r)){
            $dbv = $this->db_var($row);
            foreach ($dbv as $k=>$v) $$k=$v;
            if($row_live){
                if($row_mtn)
                    $buf.= $row_cam_name."\n";
            }
        }
        
        return $buf;
    }
    
    public function ffmpeg_bin() {
        if(!$this->_oid) return '';
        $ff = file_get_contents("/home/calc/vlc/bin/ffmpeg.sh.tmp");
        $buf = array();
        
        //$search =  $this->get_search();
        
        $q = "select * from cam where oid=$this->_oid";
        $r = mysql_query($q);
        
        while($row = mysql_fetch_assoc($r)){
            $dbv = $this->db_var($row);
            foreach ($dbv as $k=>$v) $$k=$v;
            $search =  $this->get_search($row,array('{org-name}'));
            $replace = $this->get_replace($row,array($this->_org_name));
            if($row_live){
                if($row_mtn)
                    $buf[$row_cam_name] = str_replace($search, $replace, $ff);
            }
        }
        
        return $buf;
    }

    public function vlm() {
        if(!$this->_oid) return '';
        $buf = '';
        
        //$search =  $this->get_search();
        
        $q = "select * from cam where oid=$this->_oid";
        $r = mysql_query($q);
        
        while($row = mysql_fetch_assoc($r)){
            $dbv = $this->db_var($row);
            foreach ($dbv as $k=>$v) $$k=$v;
            //list($id,$oid,$cam_name,$source,$stream_port,$live,$rec,$mtn) = $row;
            //$replace = array($id, $oid, $this->_org_name,$cam_name,$source,$stream_port);
            $search =  $this->get_search($row,array('{org-name}'));
            $replace = $this->get_replace($row,array($this->_org_name));
            //print_r($search);
            if($row_live){
                $buf.= str_replace($search, $replace, $this->_live);
                if($row_rec) $buf.= str_replace($search, $replace, $this->_rec);
                if($row_mtn) $buf.= str_replace($search, $replace, $this->_mtn);
                $buf.= "\n\n";
            }
        }
        
        return $buf;
    }
    
    public function logrotate() {
        if(!$this->_oid) return '';
        $buf = '';
        
        $this->log = file_get_contents("/home/calc/vlc/etc/logrotate.tmp.conf");
        
        //$search =  $this->get_search();
        
        $search =  array('{org-name}');
        $replace = array($this->_org_name);
            
        $buf = str_replace($search, $replace, $this->log);
        
        return $buf;
    }
    
    public function motion() {
        if(!$this->_oid) return '';
        $buf['motion'] = file_get_contents("/var/www/html/vlc/etc/motion.tmp.conf");
        $thr =  file_get_contents("/var/www/html/vlc/etc/thread.tmp.conf");
        
        //$search =  $this->get_search();
        //$search[]= '{telnet-port}';
        
        $q = "select * from cam where oid=$this->_oid and mtn=1 and live=1";
        $r = mysql_query($q);
        $n = mysql_num_rows($r);
        if($n){
            $row = mysql_fetch_assoc($r);
            $dbv = $this->db_var($row);
            foreach ($dbv as $k=>$v) $$k=$v;
            //$replace = array($id, $oid, $this->_org_name,$cam_name,$source,$stream_port,4300+$this->_oid);
            $search =  $this->get_search($row,array('{org-name}','{telnet-port}'));
            $replace =  $this->get_replace($row,array($this->_org_name,44300+$this->_oid));
            $buf['motion'] = str_replace($search, $replace, $buf['motion']);
            
            $th='';
            $buf[$row['cam-name']] = $thr;
            //$replace = array($id, $oid, $this->_org_name,$cam_name,$source,$stream_port,4300+$this->_oid);
            $buf[$row['cam-name']] = str_replace($search, $replace, $buf[$row['cam-name']]);
            $th.= "thread /home/calc/vlc/etc/$this->_org_name/motion/".$row['cam-name'].".conf\n";
            
            //threads
            
            while($row = mysql_fetch_assoc($r)){
                $dbv = $this->db_var($row);
                foreach ($dbv as $k=>$v) $$k=$v;
                $buf[$row_cam_name] = $thr;
                //$replace = array($id, $oid, $this->_org_name,$cam_name,$source,$stream_port,4300+$this->_oid);
                $search =  $this->get_search($row,array('{org-name}','{telnet-port}'));
                $replace =  $this->get_replace($row,array($this->_org_name,44300+$this->_oid));
                $buf[$row_cam_name] = str_replace($search, $replace, $buf[$row_cam_name]);
                $th.= "thread /home/calc/vlc/etc/$this->_org_name/motion/$row_cam_name.conf\n";
            }
            $buf['motion'] = str_replace('{threads}', $th, $buf['motion']);
        }
        
        /*while($row = mysql_fetch_assoc($r)){
            foreach ($row as $k=>$v) $$k=$v;
            //list($id,$oid,$cam_name,$source,$stream_port,$live,$rec,$mtn) = $row;
            $replace = array($id, $oid, $this->_org_name,$cam_name,$source,$stream_port,4300+$this->_oid);
            $buf = str_replace($search, $replace, $buf);
        }*/
        
        return $buf;
    }
}


/*$c = new config(1);
echo '<pre>';
//print_r($c->motion());
print_r($c->ffmpeg_bin());*/

/*$c = new config(1);
echo '<pre>';
echo $c->vlm();*/

