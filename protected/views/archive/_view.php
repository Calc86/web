<?php
/* @var $this ArchiveController */
/* @var $data Archive */
?>

<a class="view" href="<?php echo $this->createUrl('view', array('id'=>$data->id)); ?>">

	<!--<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />-->

	<b><?php echo CHtml::encode($data->getAttributeLabel('cam_id')); ?>:</b>
	<?php echo CHtml::encode($data->cam_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
	<?php echo CHtml::encode($data->type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_start')); ?>:</b>
	<?php echo CHtml::encode(date("H:i:s",$data->date_start)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_end')); ?>:</b>
	<?php echo CHtml::encode(date("H:i:s",$data->date_end)); ?>
	<br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('watched')); ?>:</b>
    <?php echo CHtml::encode($data->watched); ?>
    <br />

    <?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('date_rebuild')); ?>:</b>
	<?php echo CHtml::encode($data->date_rebuild); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('time_rebuild')); ?>:</b>
	<?php echo CHtml::encode($data->time_rebuild); ?>
	<br />
 */ ?>

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('rebuilded')); ?>:</b>
	<?php echo CHtml::encode($data->rebuilded); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('watched')); ?>:</b>
	<?php echo CHtml::encode($data->watched); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('file')); ?>:</b>
	<?php echo CHtml::encode($data->file); ?>
	<br />

	*/ ?>

</a>

<?php

/*
    $body.= '<table width="90%"><tr><td valign="top">';

    $body.= "Камера: $cam".  nl();
    $body.= '<br><a href="?mod=' . $mod . '&cam=0">К выбору камеры</a><br>'.  nl();

    if (isset($list[$cam])) {
        if (isset($list[$cam][$hour][$min])) {
            //плеер для проигрывания видео
            $name = $list[$cam][$hour][$min];
            $file = $rec->ptsme($name);
            //echo '<a href="'.$rec->getWebPath().'/'.$list[$cam][$hour][$min].'">'.$rec->getWebPath().'/'.$list[$cam][$hour][$min].'</a>';
            //$file = 'http://10.112.28.35/vlc/rec/ruben/2013-06-04/000.mp4';
            //http://10.112.28.35:9001/qwer1.mp4

            $body.= '
                <video width="640" height="360" src="' . $file . '" type="video/mp4"
                       id="player1" poster="../media/echo-hereweare.jpg"
                       controls="controls" preload="none"></video>';

            $body.= "\n<script>
                    $('audio,video').mediaelementplayer({
                        success: function(player, node) {
                            $('#' + node.id + '-mode').html('mode: ' + player.pluginType);
                        }
                    });
                </script>\n\n<br>";

            $body.= sprintf("%02d:%02d ", $hour, $min);
            $body.= '<a href="' . $file . '">Скачать</a>'.NL;
        }

        $body.= '</td><td>';

        $body.= '<table border="1" align="right" bgcolor="#444444">'.  nl();
        $now = date('Y-m-d H:') . (((int) (date('i') / 10)) * 10);
        //echo $now;
        //echo $date;
        foreach ($list[$cam] as $h => $ar) {
            $body.= '<tr><td>' . $h . '</td>';
            foreach ($ar as $m => $name) {
                $date = sprintf('%04d-%02d-%02d %02d:%02d', $year, $month, $day, $h, $m);
                if ($date != $now)
                    $body.= '<td><a href="?mod=' . $mod . '&hour=' . $h . '&min=' . $m . '">' . $m . '</a></td>';
            }
            $body.= '</tr>';
        }
        $body.= '</table>';
    }
    $body.= '</td></tr></table>';

 */
?>