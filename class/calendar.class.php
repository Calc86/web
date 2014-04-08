<?php

class calendar{
    protected $d;
    protected $m;
    protected $y;
    
    protected $cal;
    
    public function __construct($y=0,$m=0,$d=0) {
        if(!$y)
            $this->y = date('Y');
        else
            $this->setYear ($y);
        
        if(!$m)
            $this->m = date('m');
        else
            $this->setMonth ($m);
        
        if(!$d)
            $this->d = date('d');
        else
            $this->setDay($d);
    }
    
    function getYear() {
        return $this->y;
    }
    
    function getPrevYear() {
        return $this->y-1;
    }
    
    function getNextYear() {
        return $this->y+1;
    }
    
    function setYear($y) {
        if($y<2013) $this->y = 2013;
        $this->y = $y;
    }
    
    function getMonth() {
        return $this->m;
    }
    
    function getMonthName($m) {
        $mon = array(
            1=>'Январь',
            'Февраль',
            'Март',
            'Апрель',
            'Май',
            'Июнь',
            'Июль',
            'Август',
            'Сентябрь',
            'Октябрь',
            'Ноябрь',
            'Декабрь'
            );
        return $mon[$m];
    }
    
    function getDayName($d,$sh=1) {
        $short = array(
            1=>'Пн',
            'Вт',
            'Ср',
            'Чт',
            'Пт',
            'Сб',
            'Вс'
            );
        $long = array(
            1=>'Понедельник',
            'Вторник',
            'Среда',
            'Четверг',
            'Пятница',
            'Суббота',
            'Воскресенье'
        );
        
        if($sh){
            return $short[$d];
        }
        return $long[$d];
        
    }
    
    function getPrevMonth($p=1) {
        return ($this->m-$p< 0) ? 0 : $this->m-$p ;
    }
    
    function getNextMonth($n=1) {
        return ($this->m+$n>12) ? 0 : $this->m+$n;
    }
    
    function setMonth($m) {
        if($m>0)
            if($m<=12)
                $this->m = $m;
    }
    
    function getDay() {
        return $this->d;
    }
    
    function setDay($d) {
        if($d>0)
            if($d<=$this->getLastDay())
                $this->d = $d;
    }
    
    function getFirstWeekDay() {
        return date('N',strtotime($this->getYear().'-'.$this->getMonth().'-01'))-1;
    }
    
    function getLastDay() {
        return date('t',strtotime($this->getYear().'-'.$this->getMonth().'-01'));
    }
    
    function getLastWeekDay() {
        return date('N',strtotime($this->getYear().'-'.$this->getMonth().'-'.$this->getLastDay()))-1;
    }
    
    function getWeekDay() {
        return date('N',strtotime($this->getYear().'-'.$this->getMonth().'-'.$this->getDay()))-1;
    }
    
    function getFirstWeekNo() {
        return date('W',strtotime($this->getYear().'-'.$this->getMonth().'-01'));
    }
    
    function getLastWeekNo() {
        return date('W',strtotime($this->getYear().'-'.$this->getMonth().'-'.$this->getLastDay()));
    }
    
    function getWeekNo() {
        return date('W',strtotime($this->getYear().'-'.$this->getMonth().'-'.$this->getDay()));
    }
    
    function build() {
        $this->cal = array();
        
        for($i=0;$i<$this->getFirstWeekDay();$i++){
            $this->cal[$this->getYear()][$this->getMonth()][$this->getFirstWeekNo()][$i] = 0;
        }
        for($i=1;$i<=$this->getLastDay();$i++){
            $this->setDay($i);
            $this->cal[$this->getYear()][$this->getMonth()][$this->getWeekNo()][$this->getWeekDay()] = $i;
        }
        for($i=$this->getLastWeekDay()+1;$i<7;$i++){
            $this->cal[$this->getYear()][$this->getMonth()][$this->getLastWeekNo()][$i] = 0;
        }
    }
    
    // массив для отображения календаря
    function Display() {
        $this->build();
        return $this->cal;
    }
}

