<?php

class menu{
    protected $type = 0;    //главная стрница или строка внизу
    public function __construct($type=0) {
        $this->type = $type;
    }
    
    public function DisplaySettings() {
        $ret = '';
        
        $ret.= '
            <div class="settings">
                <a href="?mod=mtn">Запись по движению</a>
                <a href="?mod=rec">Круглосуточная запись</a>
                <a href="?mod=alarm">Оповещение</a>
                <a href="?mod=schedule">Расписание</a>
                <a href="?mod=user">Персональные данные</a>
            </div>
            ';
        
        return $ret;
    }
    
    public function Display() {
        $ret = ''; 
        
        switch($this->type){
            case 0:
                $ret.= '
                    <div id="menu">
                        <a href="?mod=live" class="cam">&nbsp;</a>
                        <a href="?mod=cash" class="bal">&nbsp;</a>
                        <a href="?mod=settings" class="set">&nbsp;</a>
                        <a href="?mod=archive&day=0&cam=0" class="arc">&nbsp;</a>
                        <a href="?mod=news" class="news">&nbsp;</a>
                    </div>
                    ';
                break;
            case 1:
                //основное меню
                $ret.= '
                    <div>
                        <a href="?mod=live">Камеры</a>
                        <a href="?mod=cash">Баланс</a>
                        <a href="?mod=settings">Настройки</a>
                        <a href="?mod=archive">Архив</a>
                        <a href="?mod=news">Новости</a>
                    </div>
                    ';
                break;
        }
        
        return $ret;
    }
    
}

