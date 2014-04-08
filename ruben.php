<?php

require ("./config.php");
//print_r($_SESSION);
//new login;
$_SESSION['login'] = 'ruben';
$_SESSION['id'] = 4;

$mod = get_var('mod','live');

?>

<html>
    <head>
        <title>cam server</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        
        <script src="mediaelement_old/build/jquery.js"></script>
	<script src="mediaelement_old/build/mediaelement-and-player.min.js"></script>
	
	<link rel="stylesheet" href="mediaelement_old/build/mediaelementplayer.min.css" />
        
      

    </head>
    <body>
        <a href="./">Live</a> <a href="?mod=archive">Архив</a> <a href="./login.php?do=2">Logout</a>
        <?php
        switch ($mod) {
            case 'archive':
                require("./mods/$mod.php");
                break;
            case 'live':
                require("./mods/live.php");
                break;
        }
        ?>
    </body>
</html>
