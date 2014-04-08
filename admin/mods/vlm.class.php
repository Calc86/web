<?php
define("INDEX",1);
require("../func.php");

ini_set('display_errors',1);
ini_set('register_globals','Off');

$db = open_db("localhost", "root", "qwertyui", "cam");

class vlm{
    protected $_oid;
    protected $_org_name;
    //protected $_tmp;
    protected $_live;
    protected $_rec;
    protected $_mtn;
    
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
        return file_get_contents("/var/www/vlc/etc/cam.tmp.vlm");
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


    public function __toString() {
        if(!$this->_oid) return '';
        $buf = '';
        
        $q = "select * from cam where oid=$this->_oid";
        $r = mysql_query($q);
        $search =  array('{id}','{oid}','{org-name}','{cam-name}','{source}','{stream-port}');
        
        
        while($row = mysql_fetch_assoc($r)){
            foreach ($row as $k=>$v) $$k=$v;
            //list($id,$oid,$cam_name,$source,$stream_port,$live,$rec,$mtn) = $row;
            $replace = array($id, $oid, $this->_org_name,$cam_name,$source,$stream_port);
            if($live){
                $buf.= str_replace($search, $replace, $this->_live);
                if($rec) $buf.= str_replace($search, $replace, $this->_rec);
                if($mtn) $buf.= str_replace($search, $replace, $this->_mtn);
                $buf.= "\n\n";
            }
        }
        
        return $buf;
    }
}

/*$vlm = new vlm(1);
echo '<pre>';
echo $vlm;*/
