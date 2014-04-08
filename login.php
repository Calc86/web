<?php

require ("./config.php");
session_start();
//new login;

$do = get_var('do',0);
$login = post_var('login');
$pass = post_var('pass');

if($do){
    new login($do,$login,$pass);
    header("Location: ./index.php");
    //
    exit;
}

?>

<html>
    <head>
        <title>Login to cam</title>
    </head>
    <body>
        <form method="Post" action="?do=1">
            Login: <input type="Text" name="login" value=""><br>
            Pass: <input type="Password" name="pass" value=""><br>
            <input type="Submit" value="Login"><br>
        </form>
    </body>
</html>
