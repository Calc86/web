<?php

/*
 * использование:
 * new login; //для проверки залогинен или нет.
 * new login($do,$login,$pass); // залогиничание $do==1
 */
class login{
    public function __construct($do=0,$login='',$pass='') {
        //print_r($_SESSION);
        if($do>=2) $this->LoginPage (); //logout
        if($do){
           $this->login($login, $pass);
        }
        else
        {
            if(!$this->is_login()){
                $this->LoginPage();
            }
        }
    }

    protected function db_is_login($login,$pass) {
        $ret = array(
            'login'=>0,
            'id' => 0,
            'tbl'=>'',
            'uid'=>0,
            'admin'=>0
            );   //ни чего не вышло
        
        //нескольо вариантов залогинивания
        //                   login         id        uid  tbl
        $qs[] = "select 1 as login,  id as id, id as uid, 'org'  as tbl,  1    as admin from org  where login='$login' and pass='$pass'";
        $qs[] = "select 1 as login, oid as id, id as uid, 'user' as tbl, admin as admin from user where login='$login' and pass='$pass'";
        
        foreach ($qs as $q){
            $r = mysql_query($q);
            $n = mysql_num_rows($r);
            if($n){ //нашли комбинацию
                list($ret['login'], $ret['id'], $ret['uid'], $ret['tbl'], $ret['admin']) = mysql_fetch_row($r);
                break;  //прошло успешно, прервать цикл и вернуть массив
            }
        }
        
        return $ret;
    }
    
    protected function login($login,$pass) {
        if($login=='') $this->LoginPage();
        if($pass=='') $this->LoginPage();
        
        
        $ret = $this->db_is_login($login, $pass);
        
        
        if($ret['login']==1){
            $hash = $this->calc_hash($login, $pass);
            $this->db_hash($ret['uid'], $hash,$ret['tbl']);
            $this->set_session($ret['id'], $login, $pass,$hash,$ret['tbl'],$ret['uid'],$ret['admin']);
        }
    }

    protected function login_old($login,$pass) {
        if($login=='') $this->LoginPage();
        if($pass=='') $this->LoginPage();
        $q = "select id from org where login='$login' and pass='$pass'";
        //echo $q;
        $r = mysql_query($q);
        $n = mysql_num_rows($r);
        //Авторизация через org
        if($n){
            list($id) = mysql_fetch_row($r);
            $hash = $this->calc_hash($login, $pass);
            $this->db_hash($id, $hash);
            $this->set_session($id, $login, $pass,$hash);
        }
        else    //авторизация через user
        {
            $q = "select oid as id, id as uid from user where login='$login' and pass='$pass'";
        }
    }
    
    protected function is_login() {
        $id = ses_var('uid',0);
        if(!$id) return 0;
        $login = ses_var('login');
        if($login=='') return 0;
        $hash = ses_var('hash');
        if($hash=='') return 0;
        $tbl = ses_var('tbl','org');
        if($tbl=='') return 0;
        
        $q = "select id from $tbl where id=$id and login='$login' and hash='$hash'";
        //echo $q;
        //exit;
        $r = mysql_query($q);
        $n = mysql_num_rows($r);
        
        return $n;
    }


    protected function LoginPage() {
        //print_r($_SESSION);
        $this->kill_session();
        //echo 'not logged in';
        header("Location: ./login.php");
        exit();
    }
    
    protected function calc_hash($p1,$p2,$p3='',$p4='') {
        return md5(rand(1,100).$p1.$p2.$p3.$p4);
    }
    
    
    protected function db_hash($id, $hash, $tbl = 'org') {
        $q = "update `$tbl` set hash='$hash', `login-date`=NOW() where id=$id";
        echo $q;
        mysql_query($q);
    }


    protected function set_session($id,$login,$pass,$hash,$tbl='org',$uid=0,$admin=0) {
        $_SESSION['id'] = $id;  //id организации
        $_SESSION['login'] = $login;    //имя пользователя
        //$_SESSION['pass'] = $pass;
        $_SESSION['hash'] = $hash;  //хеш
        $_SESSION['tbl'] = $tbl;    //таблица залогинивания
        if($tbl=='org') $uid = $id;
        $_SESSION['uid'] = $uid;    //id пользователя, если таблица org, то совпадает с id
        $_SESSION['admin'] = $admin;
    }
    
    protected function kill_session() {
        $_SESSION['id'] = 0;
        $_SESSION['login'] = '';
        //$_SESSION['pass'] = '';
        $_SESSION['hash'] = '';
        $_SESSION['tbl'] = '';
        $_SESSION['uid'] = '';
        session_destroy();
    }
    
    
};


