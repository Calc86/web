<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class CamFrame extends CComponent
{
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
        return $this->url(
            $this->get_srv_proto(), $this->get_srv_host(), $this->getStreamPort(), $this->cam->stream_path.'.mp4'
        );
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
            /*case 'vlc':
                return $this->vlc_plugin($source);*/
            case 'vlc':
            default:
                return $this->vlc2_plugin($source);
        }
    }

    protected function container($plugin) {
        $ret = '';
        $ret.= '<div style="display: inline-block; border: 0px solid black; width: ' . ($this->w + 10) . 'px;">';
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

    protected function vlc2_plugin($source) {
        $ret = '';
        $ret.= '<div style="display: inline-block; border: 0px solid black; width: ' . ($this->width) . 'px;">';
        //echo '<h5>'.$row2['cam_name'].'</h5>';
        //$ret.= '<div style="height: 20px; margin-bottom: -20px;">' . $this->cam->cam->name . '</div>';
        $ret.= '<center>
            <OBJECT classid="clsid:9BE31822-FDAD-461B-AD51-BE1D1C159921"
                 codebase="http://downloads.videolan.org/pub/videolan/vlc/latest/win32/axvlc.cab"
                 width="' . $this->width . '" height="' . $this->height . '" id="vlc'.rand().'" events="True">
               <param name="Src" value="'.$source.'" />
               <param name="ShowDisplay" value="True" />
               <param name="AutoLoop" value="True" />
               <param name="AutoPlay" value="True" />
               <embed id="vlcEmb'.rand().'"  type="application/x-google-vlc-plugin" version="VideoLAN.VLCPlugin.2" autoplay="yes" loop="yes" width="'.$this->width.'" height="'.$this->height.'"
                 target="'.$source.'" ></embed>
            </OBJECT>
               </center>';
        $ret.= '</div>';

        return $ret;
    }

    /* protected function qt_plugin($source) {
      $ret = '';
      $ret.= '<embed id="qt_'.$this->id.'" controller="true" autoplay="true" src="qwer1.mp4"
      qtsrc="'.$source.'" type="video/quicktime" scale="ToFit" height="'.$this->h.'" width="'.$this->w.'">';

      return $ret;
      } */

    /*protected function qt_plugin($source) {
        $ret = '';
        $ret.= '<OBJECT classid=\'clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B\' width="320" height="240" codebase=\'http://www.apple.com/qtactivex/qtplugin.cab\'>
            <param name=\'src\' value="' . $source . '">
            <param name=\'autoplay\' value="true">
            <param name=\'controller\' value="false">
            <param name=\'loop\' value="false">
            <EMBED src="' . $source . '" width="320" height="240" autoplay="true"
            controller="true" loop="false" bgcolor="#000000" pluginspage=\'http://www.apple.com/quicktime/download/\'>
            </EMBED>
        </OBJECT> ';
        return $ret;
    }*/

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