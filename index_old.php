<?php

require ("./config.php");
//print_r($_SESSION);
$l = new login(0);


//$_SESSION['login'] = 'ruben';
//$_SESSION['id'] = 4;

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
        <?php echo '<b>'.$_SESSION['login'].'('.$_SESSION['admin'].')</b>: '?>
        <a href="./">Live</a> <a href="?mod=archive">Архив</a> 
        <?php if($_SESSION['admin']) { ?><a href="?mod=user">Управление доступом(в разработке)</a><?php } ?>
        <a href="./login.php?do=2">Logout</a>
        <?php
        switch ($mod) {
            case 'user':
                break;
            case 'archive':
                require("./mods/$mod.php");
                break;
            case 'live':
                require("./mods/live.php");
                break;
            case 'live2':
                require("./mods/$mod.php");
                break;
        }
        ?>
    </body>
</html>
