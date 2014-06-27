<?php
/* @var $this ArchiveController */
/* @var $dataProvider CActiveDataProvider */
/* @var Cam $cam  */
/* @var $year int */
/* @var $month int */
/* @var $days array */

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
    $cal = new CalendarBuilder($year, $month);
    $calendar = $cal->Display();
?>

<div style="height: 90px;" class="">
    <?=$cal->getNavigateHtml($this, array($this::GET_CAM_ID => $cam->id));?>
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
                $dayLink = '<a href="'.$this->createUrl("index", array(
                        $this::GET_CAM_ID => $cam->id,
                        $this::GET_YEAR => $year,
                        $this::GET_MONTH => $month,
                        $this::GET_DAY => $day)).'">'.$day.'</a>';
                echo '<td class="on">'.$dayLink.'</td>';
            }
            else{
                $dayLabel = ($day != 0 ? $day : '&nbsp;');
                echo '<td>' . $dayLabel . '</td>';
            }
        }
        echo '</tr>';
    }
    ?>
    </table>
</div>
<!-- Конец календарика -->
