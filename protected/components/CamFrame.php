<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class CamFrame extends CComponent
{
    // TODO: бОльшая часть плагинов должна быть в модели Cam
    const PLUGIN_IMG = 'img';
    const SRC_MOTION = 'motion';

    public $width = 420;
    public $height = 316;
    protected $cam;

    public function __construct(CamSettings $cam){
        $this->cam = $cam;
    }

    private function getStreamPort(){
        return 9000+$this->cam->cam_id;
    }


    protected function get_srv_proto() {
        return 'http';
    }

    protected function get_srv_host() {
        return MyConfig::getVlcLiveIP();
    }

    public function src_srv() {
        return MyConfig::getNginxVlcStream($this->cam->cam_id);
        /*return $this->url(
            $this->get_srv_proto(), $this->get_srv_host(), $this->getStreamPort(), $this->cam->stream_path.'.mp4'
        );*/
    }

    public function src_source() {
        return $this->url(
            $this->cam->live_proto, $this->cam->cam->ip, $this->cam->live_port, $this->cam->live_path
        );
    }

    public function src_srv_rtsp() {
        //http://10.112__28.35:9001/qwer1.mp4
        return $this->url(
            'rtsp', $this->get_srv_host(), '1' . $this->getStreamPort(), $this->stream_path . '.mp4'
        );
    }

    protected function url($proto, $host, $port, $path) {
        return $proto . "://" . $host . ':' . $port . '/' . $path;
    }

    public function live($src = 'srv', $plugin = 'vlc') {
        $source = '';

        switch ($src) {
            case 'source':
                $source = $this->src_source();
                break;
            case 'rtsp':
            default:
                $source = $this->src_srv_rtsp();
                break;
            case 'motion':
                $source = MyConfig::getNginxMotionStream($this->cam->cam_id);
                break;
            case 'm_snap':
                /** @var CWebApplication $app */
                $app = Yii::app();
                $source = $app->session['cam_id'];
                break;
            case 'srv':
            default:
                $source = $this->src_srv();
        }

        switch ($plugin) {
            case 'real':
                return $this->real_plugin($source);
            case 'jpg':
                $source = 'jpg';
                return $this->jpg_plugin($source);
            case 'qt':
                return $this->qt_plugin($source);
                break;
            case 'img':
                return $this->img_plugin($source);
                break;
            case 'snap':
                return $this->snap_plugin($source);
                break;
            case 'cambozola':
                return $this->cambozola_plugin($source);
                break;
            case 'axis':
                return $this->axis_plugin($source);
                break;
            case 'fpf':
                return $this->fpf_plugin($source);
                break;
            case 'fp5':
                return $this->fp5_plugin($source);
                break;
            /*case 'vlc':
                return $this->vlc_plugin($source);*/
            case 'vlc':
            default:
                return $this->vlc2_plugin($source);
        }
    }

    protected function container($plugin) {
        $ret = '';
        $ret.= '<div style="display: inline-block; border: 0px solid black; width: ' . ($this->width + 10) . 'px;">';
        //echo '<h5>'.$row2['cam_name'].'</h5>';
        $ret.= '<b>' . $this->name . '</b>';
        $ret.= '<center>';

        $ret.= $plugin;

        $ret.= '</center>';
        $ret.= '</div>';

        return $ret;
    }

    protected function vlc_plugin($source) {
        $ret = '';
        $ret.= '<div style="display: inline-block; border: 0px solid black; width: ' . ($this->w + 10) . 'px;">';
        //echo '<h5>'.$row2['cam_name'].'</h5>';
        $ret.= '<b>' . $this->name . '</b>';
        $ret.= '<center>
            <embed type="application/x-vlc-plugin" pluginspage="http://www.videolan.org"
               version="VideoLAN.VLCPlugin.2"  width="' . $this->width . '"  height="' . $this->height . '" id="vlc_' . $this->cam_id . '" loop="yes" autoplay="yes"
               toolbar="false" allowfullscreen="true"
               windowless="yes" controls="true"
               target="' . $source . '"/>
               </center>';
        $ret.= '</div>';

        return $ret;
    }

    public function vlc2_plugin($source) {
        $ret = '';
        $ret.= '<div style="display: inline-block; border: 0px solid black; width: ' . ($this->width) . 'px;">';
        //echo '<h5>'.$row2['cam_name'].'</h5>';
        //$ret.= '<div style="height: 20px; margin-bottom: -20px;">' . $this->cam->cam->name . '</div>';
        $ret.= '<center>
            <OBJECT classid="clsid:9BE31822-FDAD-461B-AD51-BE1D1C159921"
                 codebase="http://get.videolan.org/vlc/2.1.3/win32/vlc-2.1.3-win32.exe"
                 width="' . $this->width . '" height="' . $this->height . '" id="vlc'.rand().'" events="True">
               <param name="Src" value="'.$source.'" />
               <param name="ShowDisplay" value="True" />
               <param name="AutoLoop" value="True" />
               <param name="AutoPlay" value="True" />
               <embed id="vlcEmb'.rand().'"  type="application/x-google-vlc-plugin" version="VideoLAN.VLCPlugin.2"  pluginspage="http://www.videolan.org" autoplay="yes" loop="yes" width="'.$this->width.'" height="'.$this->height.'"
                 target="'.$source.'" ></embed>
            </OBJECT>
               </center>';
        $ret.= '</div>';

        return $ret;
    }

    protected function img_plugin($source) {
        return '<img id="video_frame" width="'.$this->width.'" src="'.$source.'">';
    }

    protected function cambozola_plugin($source) {
        return '<applet code="com.charliemouse.cambozola.Viewer" archive="/cambozola.jar" width="704" height="576">
            <param name="url" value="'.$source.'">
            </applet>';
    }

    protected function snap_plugin($id) {
        return '
            <script>
                function reload(){
                    location.reload();
                }
            </script>
            <a id="frame" onClick="reload()" href="#"><img src="'.MyConfig::getNginxMotionSnap($id).'"></a>
        ';
    }

    protected function axis_plugin($source){
        return '
            <object id="Player" width="450" height="288" border="0" classid="CLSID:745395C8-D0E1-4227-8586-624CA9A10A8D" codebase="/AMC.cab">
              <param name="Height" value="450">
              <param name="AutoStart" value="1">
              <param name="UIMode" value="none">
              <param name="MediaType" value="mjpeg-unicast">
              <param name="NetworkTimeout" value="5000">
              <param name="MediaUsername" value="webcam">
              <param name="MediaPassword" value="webcam">
              <param name="MediaURL" value="'.$source.'">
            </object>
        ';
    }

    /**
     * @param $source
     * @return string
     */
    public function fp5_plugin($source){
        //$source = 'http://10.154.28.203/lhttp/1/stream-1.m3u8';
        $source = 'http://10.154.28.203:9008/path.mp4';

        $baseUrl = WebYii::app()->baseUrl;
        $cs = WebYii::app()->clientScript;
        /* @var $cs CClientScript */
        $path = WebYii::app()->baseUrl."/flowplayer/html5";

        //$cs->registerCssFile("$path/skin/minimalist.css");
        $cs->registerCssFile("$path/skin/playful.css");

        $cs->registerScriptFile("$path/flowplayer.min.js");

        return '
        <div class="flowplayer">
           <video>
              <source type="video/mp4"  src="'.$source.'">
           </video>
        </div>
        ';
    }

    /**
     * @param $source
     * @return string
     */
    public function fpf_plugin($source){
        //$source = 'http://10.154.28.203/lhttp/1/stream-11.m3u8';
        //$source = 'http://10.154.28.203:9001/path.mp4';
        //$source = 'http://10.154.28.203/lhttp/1/stream-1.m3u8';
        $source = 'http://10.154.28.203:11011/stream.flv';
        //$source = 'http://10.154.28.191:13008/1.flv';
        //$source = 'http://10.154.28.203:9008/path.mp4';
        $baseUrl = Yii::app()->baseUrl;
        $cs = WebYii::app()->clientScript;
        /* @var $cs CClientScript */
        $path = Yii::app()->baseUrl."/flowplayer/flash";
        $cs->registerScriptFile("$path/flowplayer-3.2.13.min.js");

        $cs->registerScript('flowplayer', '
             flowplayer("player", "'.$path.'/flowplayer-3.2.18.swf");
        ');
        /*$cs->registerScript('flowplayer', '
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
        ');*/

        return '
            <a href="'.$source.'"
                style="display:block;width:'.$this->width.'px;height:'.$this->height.'px;"
                id="player">
            </a>';
    }

    protected function qt_plugin($source) {
        $ret = '';

        /*$ret.= '<object style="border: solid black 1px;" id="qtrtsp_object_'.$this->id.'" width="640" height="340" codebase="http://www.apple.com/qtactivex/qtplugin.cab"
		classid="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" type="video/quicktime">
                <param name="src" value="http://'.$this->cam_ip.'/qt.mov" />
                <param name="autoplay" value="true" />
                <param name="controller" value="false" />
                <param name="qtsrc" value="'.$source.'"/>
            </object>';*/
        $ret.= '<div style="display: inline-block; border: 0px solid black; width: ' . ($this->width + 10) . 'px;">';
        //echo '<h5>'.$row2['cam_name'].'</h5>';
        $ret.= '<b>' . $this->cam->cam->name . '</b>';
        $ret.= '<center>';

        $ret.= '<object width="640" height="480" id="qt" classid="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" codebase="http://www.apple.com/qtactivex/qtplugin.cab">';
        $ret.= '<param name="src" value="'.$source.'">';;
        $ret.= '<param name="autoplay" value="true">';
        $ret.= '<param name="controller" value="false">';
        $ret.= '<embed id="player'.rand().'" name="player" src="/poster.mov" bgcolor="000000" width="'.$this->w.'" height="'.$this->h.'" scale="ASPECT" qtsrc="'.$source.'"  kioskmode="true" showlogo=false" autoplay="true" controller="false" pluginspage="http://www.apple.com/quicktime/download/">';
        $ret.= '</embed></object>';

        $ret.= '</center>';
        $ret.= '</div>';

        return $ret;
    }

    protected function real_plugin($source) {
        $ret = '';

        $ret.= '<div style="display: inline-block; border: 0px solid black; width: ' . ($this->w + 10) . 'px;">';
        $ret.= '<b>' . $this->cam->cam->name . '</b>';
        $ret.= '<center>';
        $ret.= '<OBJECT ID=RVOCX CLASSID="clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA"
                WIDTH="' . $this->w . '" HEIGHT="' . $this->h . '">
                    <PARAM NAME="SRC" VALUE="' . $source . '">
                    <PARAM NAME="CONSOLE" VALUE="one">
                    <PARAM NAME="CONTROLS" VALUE="ImageWindow">
                    <PARAM NAME="BACKGROUNDCOLOR" VALUE="white">
                    <PARAM NAME="CENTER" VALUE="true">
                </OBJECT>';
        $ret.= '</center>';
        $ret.= '</div>';

        return $ret;
    }

    protected function jpg_plugin($source) {
        return '';
    }
}