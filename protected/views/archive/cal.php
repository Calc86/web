<?php
/* @var $this ArchiveController */
/* @var $dataProvider CActiveDataProvider */
/* @var $cid  */
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
