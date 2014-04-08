<?php

class news{
    protected $news = array();
    
    public function __construct($oid=0) {
        $q = "select * from news where oid=0 or oid=$oid order by date desc";
        $r = mysql_query($q);
        $n = mysql_num_rows($r);
        
        if($n){
            for($i=0;$i<$n;$i++){
                $row = mysql_fetch_assoc($r);
                //массив с новостями
                $this->news[$i]['date'] = $row['date'];
                $this->news[$i]['desc'] = $row['desc'];
                $this->news[$i]['oid'] = $row['oid'];
            }
        }
    }
    
    protected function DisplayMonth($m) {
        $mon = array(
            1=>'Января',
            'Февраля',
            'Марта',
            'Апреля',
            'Мая',
            'Июня',
            'Июля',
            'Августа',
            'Сентября',
            'Октября',
            'Ноября',
            'Декабря'
        );
        return $mon[$m];
    }


    protected function DisplayDate($date) {
        $time = strtotime($date);
        return date("d ".$this->DisplayMonth((int)date('m',$time))." Y года",$time);
    }


    public function Display() {
        $ret = '';
        
        foreach ($this->news as $new){
            $ret.='
                <div class="news">
                    <div class="date">'.$this->DisplayDate($new['date']).'</div>
                    '.($new['oid'] ? '<div class="private">private</div>' : '').'
                    '.$new['desc'].'
                </div>
            ';
        }
        
        return $ret;
    }
}

