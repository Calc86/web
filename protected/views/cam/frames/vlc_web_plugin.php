<?php
/**
 * Created by PhpStorm.
 * User: calc
 * Date: 24.06.14
 * Time: 13:39
 */

/**
 * @var $this Controller
 * @var $source string
 */

$width = 420;
$height = 316;

?>

<div style="display: inline-block; border: 0 solid black; width: <?=$width?>px;">
    <OBJECT classid="clsid:9BE31822-FDAD-461B-AD51-BE1D1C159921"
            codebase="http://get.videolan.org/vlc/2.1.3/win32/vlc-2.1.3-win32.exe"
            width="<?=$width?>" height="<?=$height?>" id="vlc<?=rand()?>" events="True">
        <param name="Src" value="<?=$source?>" />
        <param name="ShowDisplay" value="True" />
        <param name="AutoLoop" value="True" />
        <param name="AutoPlay" value="True" />
        <embed id="vlcEmb<?=rand()?>"  type="application/x-google-vlc-plugin" version="VideoLAN.VLCPlugin.2"  pluginspage="http://www.videolan.org" autoplay="yes" loop="yes" width="<?=$width?>" height="<?=$height?>"
         target="<?=$source?>"></embed>
    </OBJECT>
</div>

