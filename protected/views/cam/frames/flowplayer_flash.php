<?php
/**
 * Created by PhpStorm.
 * User: calc
 * Date: 24.06.14
 * Time: 13:32
 */

/**
 * @var $this Controller
 * @var $cam Cam
 */

$path = WebYii::app()->baseUrl."/flowplayer/flash";
WebYii::app()->clientScript->registerScriptFile("$path/flowplayer-3.2.13.min.js");

/*WebYii::app()->clientScript->registerScript('flowplayer', '
             flowplayer("player", "'.$path.'/flowplayer-3.2.18.swf");
        ');*/

WebYii::app()->clientScript->registerScript('flowplayer', '
         flowplayer("player", "'.$path.'/flowplayer-3.2.18.swf", {
            plugins:  {
                httpstreaming: {
                    url: \'/flowplayer/flash/flowplayer.httpstreaminghls-3.2.10.swf\'
                },
            },
            clip: {
                url: "'.$source.'",
                urlResolvers: ["httpstreaming"],
                provider: "httpstreaming",
                autoPlay: true,
            }
         });
');
?>

<a href="<?=$source?>"
    style="display:block;width:<?=$this->width?>px;height:<?=$this->height?>px;"
    id="player">
</a>
