<?php
/* @var $this CamController */

$this->breadcrumbs=array(
	'Cam'=>array('/cam'),
	'Balans',
);
$this->layout = 'column2logo';
?>

<?php
//TODO: СДелать элемент "переключатель месяца"
?>

<div style="height: 90px;" class="">
    <div class="calendar">

        <a href="#" class="left">&nbsp;</a>

        <a href="#" class="month">ЯНВАРЬ</a>
        <a href="#" class="month">ФЕВРАЛЬ</a>
        <a href="#" class="month on">МАРТ</a>
        <a href="#" class="month">АПРЕЛЬ</a>
        <a href="#" class="month">МАЙ</a>

        <a href="#" class="right">&nbsp;</a>

    </div>
</div>
<div class="columns">
    <div class="balans font20">
        Приход: <b>1000 рублей</b><br><br>
        Расход: <b>500 рублей(<i>камера холл</i>)</b><br><br>
        <br><br><br>
        Тариф: <b>*****</b> <br><br>
        Период: <b>5 дней</b> <br><br>
        Осталось: <b>25 дней</b> <br><br>
    </div>
</div>


<!-- Месяца туда-сюда  начало-->
<!--<div style="position:absolute; top:150px; left:26px; text-align:left;">
    <div style="position:relative; top:0px; left:0px; width:799px; height:47px; text-align:left;">
        <div style="position:absolute; top:0px; left:0px; width:28px; height:47; text-align:left;"><img src="images/left.png" width="28" height="47" border="0"></div>

        <div style="position:absolute; top:0px; left:32px; width:147px; height:47; text-align:center;"><a href="#" class="month"><div class="month">ЯНВАРЬ</div></a></div>
        <div style="position:absolute; top:0px; left:179px; width:147px; height:47; text-align:center;"><a href="#" class="month"><div class="month">ФЕВРАЛЬ</div></a></div>
        <div style="position:absolute; top:0px; left:326px; width:147px; height:47; text-align:center;"><a href="#" class="month"><div class="month">МАРТ</div></a></div>
        <div style="position:absolute; top:0px; left:473px; width:147px; height:47; text-align:center;"><a href="#" class="month"><div class="month">АПРЕЛЬ</div></a></div>
        <div style="position:absolute; top:0px; left:620px; width:147px; height:47; text-align:center;"><a href="#" class="month"><div class="month">МАЙ</div></a></div>

        <div style="position:absolute; top:0px; right:0px; width:28px; height:47; text-align:left;"><img src="images/right.png" width="28" height="47" border="0"></div>
    </div>
</div>-->
<!-- Месяца туда-сюда  конец-->
<!-- Все тута начало -->

<!-- Все тута конец -->