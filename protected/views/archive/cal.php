<?php
/* @var $this ArchiveController */
/* @var $dataProvider CActiveDataProvider */
/* @var $cid cam_id */
/* @var $year int */
/* @var $month int */

$this->breadcrumbs=array(
	'Archives',
);

$this->menu=array(
	array('label'=>'Create Archive', 'url'=>array('create')),
	array('label'=>'Manage Archive', 'url'=>array('admin')),
);
?>

<h1>Archives</h1>

<?php

// для каких дней мы имеем записи
//echo $year.'-'.$month;
//$days = array();
foreach($dataProvider->getData() as $archive){
    $days[$archive->day] = 1;
}

//print_r($days);



/* $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); */

?>

<!-- Переключалка по архивам START -->
<!--<div style="position:absolute; top:150px; left:25px; text-align:left;">
    <div style="position:relative; top:0px; left:0px; width:450px; height:30px; text-align:left;">
        <div style="position:absolute; top:0px; left:0px; width:150px; height:30;">
            <a href="#" title="Архив крулосуточной записи" onmouseover="document.one.src='images/barch_kruglos_hl.png'; window.status='Архив крулосуточной записи'; return true" onmouseout="document.one.src='images/barch_kruglos.png';"><img src="images/barch_kruglos.png" alt="Архив крулосуточной записи" title="Архив крулосуточной записи" name="one" border="0" width="150" height="30"></a>
        </div>
        <div style="position:absolute; top:0px; left:150px; width:150px; height:30;">
            <a href="#" title="Архив записи по расписанию" onmouseover="document.two.src='images/barch_raspis_hl.png'; window.status='Архив записи по расписанию'; return true" onmouseout="document.two.src='images/barch_raspis.png';"><img src="images/barch_raspis.png" alt="Архив записи по расписанию" title="Архив записи по расписанию" name="two" border="0" width="150" height="30"></a>
        </div>
        <div style="position:absolute; top:0px; left:300px; width:150px; height:30;">
            <a href="#" title="Архив записи по движению" onmouseover="document.three.src='images/barch_move_hl.png'; window.status='Архив записи по движению'; return true" onmouseout="document.three.src='images/barch_move.png';"><img src="images/barch_move.png" alt="Архив записи по движению" title="Архив записи по движению" name="three" border="0" width="150" height="30"></a>
        </div>
    </div>
</div>
<div style="position:absolute; top:180px; left:25px; width:800px; height:20px; text-align:left; background-color:#002038; color:#fff; text-width:700; border-top: 1px solid #ccc; border-bottom: 1px solid #ccc;" class="prozr">
    <span style="color:#ccc; font-weight: bold; font-family: Arial, Helvetica; font-size: 15px; font-style:normal;">&nbsp;Архив записей:</span>
</div>-->
<!-- Переключалка по архивам END -->
<!-- Месяца туда-сюда  начало-->

<?php
    $cal = new CalendarBuilder($year, $month);
    $calendar = $cal->Display();
?>

<div style="height: 90px;" class="">
    <?=$cal->getNavigateHtml($this,array('cid' => $cid));?>
</div>


<!-- Месяца туда-сюда  конец-->
<!-- Календарик ) -->
<div class="t" style="position:absolute; top:320px; left:110px; text-align:left;">
    <table>
    <?php
    for($i=1;$i<=7;$i++){
        echo '<td>'.$cal->getDayName($i).'</td>';
    }
    foreach ($calendar[$year][$month] as $wno => $week) {
        echo '<tr>';
        //echo '<td class="wno">' . $wno . '</td>';
        foreach ($week as $dno => $day) {
            $class = '';
            if (isset($days[$day])) {
                $day = '<a href="'.$this->createUrl("index",array('cid'=>$cid,'y'=>$year,'m'=>$month,'d'=>$day)).'">' . $day . '</a>';
                echo '<td class="on">'.$day.'</td>';
            }
            else{
                $day = ($day!=0 ? $day : '&nbsp;');
                echo '<td>' . $day . '</td>';
            }
        }
        echo '</tr>';
    }
    ?>
    </table>
</div>
<!-- Конец календарика -->
