<?php
/**
 * Created by PhpStorm.
 * User: calc
 * Date: 11.03.14
 * Time: 16:15
 */
class CalendarBuilder extends CComponent
{
    const INDEX_MONTH = 'month';
    const INDEX_YEAR = 'year';

    protected $d;
    protected $m;
    protected $y;

    protected $cal;

    public function __construct($y = 0, $m = 0, $d = 0)
    {
        if (!$y)
            $this->y = date('Y');
        else
            $this->setYear($y);

        if (!$m)
            $this->m = date('m');
        else
            $this->setMonth($m);

        if (!$d)
            $this->d = date('d');
        else
            $this->setDay($d);
    }

    function getYear()
    {
        return $this->y;
    }

    function getPrevYear()
    {
        return $this->y - 1;
    }

    function getNextYear()
    {
        return $this->y + 1;
    }

    function setYear($y)
    {
        if ($y < 2013) $this->y = 2013;
        $this->y = $y;
    }

    function getMonth()
    {
        return $this->m;
    }

    function getMonthName($m)
    {
        if($m<=0) return '';

        $mon = array(
            1 => 'Январь',
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

    function getDayName($d, $sh = 1)
    {
        $short = array(
            1 => 'Пн',
            'Вт',
            'Ср',
            'Чт',
            'Пт',
            'Сб',
            'Вс'
        );
        $long = array(
            1 => 'Понедельник',
            'Вторник',
            'Среда',
            'Четверг',
            'Пятница',
            'Суббота',
            'Воскресенье'
        );

        if ($sh) {
            return $short[$d];
        }
        return $long[$d];

    }

    public function getDate($offset){
        if($offset == 0)
            return array(
                self::INDEX_YEAR => $this->getYear(),
                self::INDEX_MONTH => $this->getMonth(),
            );
        $m = $this->getMonth() + $offset;
        $y = $this->getYear();
        if($m > 12){
            $y++;
            $m = $m - 12;
        }
        if($m < 1){
            $y--;
            $m = $m + 12;
        }
        return array(
            self::INDEX_YEAR => $y,
            self::INDEX_MONTH => $m,
        );
    }

    public function getPrevDate($p = 1){
        $m = $this->getPrevMonth($p);
        $y = $this->getYear();
        if($m==0){
            $m = 13 - $p;
            $y = $y - 1;
        }
        return array(
            self::INDEX_YEAR => $y,
            self::INDEX_MONTH => $m,
        );
    }

    public function getNextDate($p = 1){
        $m = $this->getNextMonth($p);
        $y = $this->getYear();
        if($m==0){
            $m = $p;
            $y = $y + 1;
        }
        return array(
            self::INDEX_YEAR => $y,
            self::INDEX_MONTH => $m,
        );
    }

    function getPrevMonth($p = 1)
    {
        return ($this->m - $p < 0) ? 0 : $this->m - $p;
    }

    function getNextMonth($n = 1)
    {
        return ($this->m + $n > 12) ? 0 : $this->m + $n;
    }

    function setMonth($m)
    {
        if ($m > 0)
            if ($m <= 12)
                $this->m = $m;
    }

    function getDay()
    {
        return $this->d;
    }

    function setDay($d)
    {
        if ($d > 0)
            if ($d <= $this->getLastDay())
                $this->d = $d;
    }

    function getFirstWeekDay()
    {
        return date('N', strtotime($this->getYear() . '-' . $this->getMonth() . '-01')) - 1;
    }

    function getLastDay()
    {
        return date('t', strtotime($this->getYear() . '-' . $this->getMonth() . '-01'));
    }

    function getLastWeekDay()
    {
        return date('N', strtotime($this->getYear() . '-' . $this->getMonth() . '-' . $this->getLastDay())) - 1;
    }

    function getWeekDay()
    {
        return date('N', strtotime($this->getYear() . '-' . $this->getMonth() . '-' . $this->getDay())) - 1;
    }

    function getFirstWeekNo()
    {
        return date('W', strtotime($this->getYear() . '-' . $this->getMonth() . '-01'));
    }

    function getLastWeekNo()
    {
        return date('W', strtotime($this->getYear() . '-' . $this->getMonth() . '-' . $this->getLastDay()));
    }

    function getWeekNo()
    {
        return date('W', strtotime($this->getYear() . '-' . $this->getMonth() . '-' . $this->getDay()));
    }

    function build()
    {
        $this->cal = array();

        for ($i = 0; $i < $this->getFirstWeekDay(); $i++) {
            $this->cal[$this->getYear()][$this->getMonth()][$this->getFirstWeekNo()][$i] = 0;
        }
        for ($i = 1; $i <= $this->getLastDay(); $i++) {
            $this->setDay($i);
            $this->cal[$this->getYear()][$this->getMonth()][$this->getWeekNo()][$this->getWeekDay()] = $i;
        }
        for ($i = $this->getLastWeekDay() + 1; $i < 7; $i++) {
            $this->cal[$this->getYear()][$this->getMonth()][$this->getLastWeekNo()][$i] = 0;
        }
    }

    public function getNavigateHtml(Controller $controller, array $params){
        $ret = '';
        $ret.= '<div class="calendar">';
            $ret.= '<a href="'.$controller->createUrl($controller->getRoute(), array_merge($params, $this->getDate(-1))).'" class="left">&nbsp;</a>';
            for($i = -2; $i<3; $i++){
                $month = $this->getDate($i)[self::INDEX_MONTH];
                $monthName = strtoupper($this->getMonthName($month));
                //$y = $this->getDate($i)[self::INDEX_YEAR];
                $url = $controller->createUrl($controller->getRoute(), array_merge($params, $this->getDate($i)) );
                $on = '';
                if($i==0) $on=' on';
                $ret.= '<a href="'.$url.'" class="month'.$on.'">'.$monthName.'</a>';
            }
            $ret.= '<a href="'.$controller->createUrl($controller->getRoute(), array_merge($params, $this->getDate(1))).'" class="right">&nbsp;</a>';
        $ret.= '</div>';
        return $ret;
    }


    // массив для отображения календаря
    function Display()
    {
        $this->build();
        return $this->cal;
    }
}