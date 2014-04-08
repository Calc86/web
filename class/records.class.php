<?php

class records {

    protected $user;
    protected $path;
    protected $date;
    protected $type = 'rec';
    protected $records = array();

    public function __construct($user, $type = 'rec') {
        $this->user = $user;
        $this->type = $type;
        $this->path = VLC . "/$type/$user";
        
        $this->fillRecords();
    }
    
    function getRecords() {
        return $this->records;
    }
    
    function fillRecords() {
         $ar = scandir($this->getPath());
        //убрать . и ..
        array_shift ( $ar ); // .
        array_shift ( $ar ); // ..
        $this->records = $ar;
    }

    function dateFilter($month=0,$year=0) {
        if(!$month)
            $month = date('m');
        if(!$year)
            $year = date('Y');
        
        $recs = array();
        foreach($this->records as $rec){
            $ar = explode('-',$rec);
            $y = $ar[0]; $m = $ar[1]; $d = $ar[2];
            
            if($y == $year){
                if($m == $month){
                    array_push($recs, $y.'-'.$m.'-'.$d);
                }
            }
            $this->records = $recs;
        }
    }
    
    function calendar() {
        $cal = array();
        $n = count($this->records);
        foreach($this->records as $rec){
            $ar = explode('-',$rec);
            $y = (int)$ar[0]; $m = (int)$ar[1]; $d = (int)$ar[2]; 
            $cal[$y][$m][$d] = 1;   //имеем папочку в это дате
        }
        
        return $cal;
    }
    
    function getDirName($y,$m,$d) {
        return sprintf('%04d-%02d-%02d',$y,$m,$d);   
    }
    
    
    function getPath() {
        return $this->path;
    }

}

