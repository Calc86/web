<?php

require_once './class/news.class.php';

$news = new news(ses_var('id',0));

$body.= $news->Display();

?>
