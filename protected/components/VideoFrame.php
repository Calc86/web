<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class VideoFrame extends CComponent
{
    public $width = 640;
    public $height = 480;
    protected $cam;

    public function __construct(){
    }

    public function view($path){
        $ret = '';

        /*
            <video width="640" height="360" src="/vlc/rec/ruben/2014-03-15/00:00:04_ruben_cam2_rec.mp4" type="video/mp4" id="player1" poster="../media/echo-hereweare.jpg" controls="controls" preload="none"></video>
        */
        $ret.= '<video type="video/mp4" id="player1" poster="'.Yii::app()->baseUrl.'/mediaelement/build/background.png" controls="controls" preload="none" src="'.$path.'" width="'.$this->width.'" height="'.$this->height.'"></video>';

        return $ret;
    }
}
