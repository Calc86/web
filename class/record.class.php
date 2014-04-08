<?php


class record {
    protected $path;
    protected $records;
    protected $user;
    protected $type;
    protected $dir;
    
    public function __construct($user,$dir,$type='rec') {
        $this->user = $user;
        $this->type = $type;
        $this->dir = $dir;  
        $this->path = VLC . "/$type/$user/$dir";
        $this->fillRecords();
    }
    
    function getPath() {
        return $this->path;
    }
    
    function getWebPath() {
        return WEB.'/'.$this->type.'/'.$this->user.'/'.$this->dir;
    }
    
    function fillRecords() {
        $ar = scandir($this->getPath());
        //убрать . и ..
        array_shift ( $ar );
        array_shift ( $ar );
        $this->records = $ar;
    }
    
    function getRecords() {
        return $this->records;
    }
    
    function Display() {
        $list = array();
        
        //echo $this->path;
        
        foreach($this->records as $rec){
            $a = explode('_', $rec);
            $time = $a[0]; $user = $a[1]; $cam = $a[2]; 
            $b = explode(':',$time);
            $h = (int)$b[0]; $m = (int)$b[1];
            
            $list[$cam][$h][$m] = $rec;
        }
        
        return $list;
    }
    
    function ptsme($name) {
        $a = explode('.',$name);
        $name = $a[0];
        $path = $this->getPath().'/'.$name;
        //echo $path;
        $cmd = "ffmpeg -fflags +genpts -i $path.avi -codec copy $path.mp4 >> /dev/null";
        //echo $cmd;
        
        if(!file_exists($path.'.mp4')){
            exec($cmd);
        }else{
            $size = filesize($path.'.mp4');
            if(!$size)
                exec($cmd);
        }
        
        //удалить старый файл
        if(file_exists($path.'.avi')){
            //страховка от повреждения файла при перекодировании.
            $s1 = filesize($path.'.avi');
            $s2 = filesize($path.'.mp4');
            if($s2 > $s1 * 0.8){
                //echo 'del';
                exec("rm -f $path.avi");
            }
        }
        
        return $this->getWebPath().'/'.$name.'.mp4';
    }
}

