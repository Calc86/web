var panspeed     = new Ctrl_SelectNum("panspeed",0,0x40,1,0x1A);
var tiltespeed   = new Ctrl_SelectNum("tiltespeed",0,0x40,1,0x1A);
mpMode=GetCookieInt("MP_MODE",1);
UpdateGSize(mpMode);
//PTZ (visca)
if(g_isSupportVisca == 1){
  var eptzpresetlistname = GV("<%viscasequencelistname%>","--Preset List--");
  var g_focusmodeinq = parseInt(GV("<%focusmodeinq%>",0)); //0=manual, 1=auto
}else
if(mpMode == 1)
  var eptzpresetlistname = "--Preset List--";
else if(mpMode == 2)
  var eptzpresetlistname = "--Preset List--";
else if(mpMode == 3)  
  var eptzpresetlistname = "--Preset List--";

var presetselect = new Ctrl_SelectEx("presetselect",eptzpresetlistname,null,null,"GoToPreset()");

if (isNaN(g_h264Status))
{
  g_h264Status = 5;
};
function SavePTZSpeed()
{
  SendHttpPublic(c_iniUrl+"&eptzspeed="+ptzspeed.GV());
};
var ptzspeed    = new Ctrl_SelectNum("ptzspeed",1,10,1,"10",null,"SavePTZSpeed()");
var profile     = new Ctrl_SelectNum("profile",1,3,1,"1",null,"ChangeProfile()");
var _ptzspeed = GV("10",5);
if(g_isSupportVisca == 1)
{
  var l_defspeed = "1;2;3;4;5;6;7;8;9;10;11;12;13;14;15;16";
  var visca_panspeed    = new Ctrl_SelectEx("visca_panspeed",GV("<%panspeedname%>",l_defspeed),GV("<%panspeed%>",1),"","OnClickSpeed('panspeed')");
  var visca_tiltspeed    = new Ctrl_SelectEx("visca_tiltspeed",GV("<%tiltspeedname%>",l_defspeed),GV("<%tiltspeed%>",1),"","OnClickSpeed('tiltspeed')");
  var visca_ptzpanlist    = new Ctrl_SelectEx("visca_ptzpanlist",GV("<%autopanname%>","1;2;3;4"),0);
  var visca_ptzseqlist    = new Ctrl_SelectNum("visca_ptzseqlist",1,8,1,"1");
  var visca_ptzcruiselist    = new Ctrl_SelectEx("visca_ptzcruiselist",GV("<%cruisename%>","1;2;3;4;5;6;7;8"),"1");
}

var ptzselectstr = '';
if(g_isSupportVisca == 1)
{
    g_PTZMode = 3;      // g_PTZMode = 3 for visca
    ptzselectstr = "VISCA";
}
else
if(g_isShowRs485 == 1 && g_isSupportEPTZ == 1)
{
    g_PTZMode = 0;//2;      // g_PTZMode = 2 for future
    ptzselectstr = "RS-485;EPTZ";
}
else
{
    if(g_isSupportEPTZ == 1){
        g_PTZMode = 1;
        ptzselectstr = "EPTZ";
    }else{
        g_PTZMode = 0;
        ptzselectstr = "RS-485";
    }    
}

/*
if(g_isShowRs485)
{
  if(g_isSupportEPTZ == 1)
  {
    g_PTZMode = 0;
    ptzselectstr = "RS-485;EPTZ";
  }
  else
  {
    g_PTZMode = 0;
	ptzselectstr = "RS-485";
  }
}
else
{
  g_PTZMode = 1;
  ptzselectstr = "EPTZ";
}
*/

var g_ptzselect = new Ctrl_SelectEx("g_ptzselect",ptzselectstr,0,null,"SetPTZMode()");

function SetPTZMode()
{
  if(g_ptzselect.GV() == 'RS-485')
  {
    g_PTZMode = 0;
    //alert("rs485");
  }
  else if(g_ptzselect.GV() == 'EPTZ')
  {
    g_PTZMode = 1;
    //alert("eptz");
  }
};

var imagePT = new Object();
/*
* if background is dark then bg = "dark"
* else if background is white then bg= "white" 
*/
function PTimageArray(bg){
  if(bg=="white")
    Ext = "white-";
  else
    Ext = "";
  
  if(g_isShowPtzCtrl)
  {
	//var imagePT = new Object( );
    imagePT["way_control_n"] = new Image(110, 110);
    imagePT["way_control_n"].src  = Ext+"way_control.jpg";

    imagePT["home_f"] = new Image(110, 110);
    imagePT["home_f"].src = Ext+"way_control_center_f.jpg";
    imagePT["home_p"] = new Image(110, 110);
    imagePT["home_p"].src = Ext+"way_control_center_p.jpg";

    imagePT["down_f"] = new Image(110, 110);
    imagePT["down_f"].src = Ext+"way_control_down_f.jpg";
    imagePT["down_p"] = new Image(110, 110);
    imagePT["down_p"].src = Ext+"way_control_down_p.jpg";

    imagePT["left_f"] = new Image(110, 110);
    imagePT["left_f"].src = Ext+"way_control_left_f.jpg";
    imagePT["left_p"] = new Image(110, 110);
    imagePT["left_p"].src = Ext+"way_control_left_p.jpg";

    imagePT["left_down_f"] = new Image(110, 110);
    imagePT["left_down_f"].src = Ext+"way_control_left_down_f.jpg";
    imagePT["left_down_p"] = new Image(110, 110);
    imagePT["left_down_p"].src = Ext+"way_control_left_down_p.jpg";

    imagePT["left_up_f"] = new Image(110, 110);
    imagePT["left_up_f"].src = Ext+"way_control_left_up_f.jpg";
    imagePT["left_up_p"] = new Image(110, 110);
    imagePT["left_up_p"].src = Ext+"way_control_left_up_p.jpg";

    imagePT["right_f"] = new Image(110, 110);
    imagePT["right_f"].src = Ext+"way_control_right_f.jpg";
    imagePT["right_p"] = new Image(110, 110);
    imagePT["right_p"].src = Ext+"way_control_right_p.jpg";

    imagePT["right_down_f"] = new Image(110, 110);
    imagePT["right_down_f"].src = Ext+"way_control_right_down_f.jpg";
    imagePT["right_down_p"] = new Image(110, 110);
    imagePT["right_down_p"].src = Ext+"way_control_right_down_p.jpg";

    imagePT["right_up_f"] = new Image(110, 110);
    imagePT["right_up_f"].src = Ext+"way_control_right_up_f.jpg";
    imagePT["right_up_p"] = new Image(110, 110);
    imagePT["right_up_p"].src = Ext+"way_control_right_up_p.jpg";
    
    imagePT["up_f"] = new Image(110, 110);
    imagePT["up_f"].src = Ext+"way_control_up_f.jpg";
    imagePT["up_p"] = new Image(110, 110);
    imagePT["up_p"].src = Ext+"way_control_up_p.jpg";

    imagePT["zoom_in_f"] = new Image(110, 110);
    imagePT["zoom_in_f"].src = Ext+"way_control_zoom_in_f.jpg";
    imagePT["zoom_in_p"] = new Image(110, 110);
    imagePT["zoom_in_p"].src = Ext+"way_control_zoom_in_p.jpg";

    imagePT["zoom_out_f"] = new Image(110, 110);
    imagePT["zoom_out_f"].src = Ext+"way_control_zoom_out_f.jpg";
    imagePT["zoom_out_p"] = new Image(110, 110);
    imagePT["zoom_out_p"].src = Ext+"way_control_zoom_out_p.jpg";
  }
}

/*
 * if background is dark then bg = "dark"
 * else if background is white then bg= "white" 
*/
function PtzCtrlMap(bg){
  PTimageArray(bg);

  var w='';
  w+='<p></p><p style="display: inline;" id="displayPT1" align="center">';
  w+='<img usemap="#MapMap" src="'+imagePT["way_control_n"].src+'" name="PTControl" width="110" align="center" border="0" height="110">';
  w+='<map id="MapMap" name="MapMap">';
  w+=GetAREA("left up","left up","pt_left_up","pt_out","left_up","left_up","left_up","0,36,14,15,35,1,35,20,28,25,24,30,20,36","poly"); 
  w+=GetAREA("up","up","pt_up","pt_out","up","up","up","35,-7,73,-11,74,20,66,17,56,16,44,17,35,20","poly");
  w+=GetAREA("right up","right up","pt_right_up","pt_out","right_up","right_up","right_up","74,1,94,14,108,36,90,36,85,30,80,24,73,20","poly");		    
  w+=GetAREA("left ","left ","pt_left","pt_out","left","left","left","22,73,0,73,0,36,20,36,17,44,16,52,17,60,18,68","poly");		
  w+=GetAREA("home ","home","pt_home","pt_out","home","home","home","55,55,15","circle");
  w+=GetAREA("right ","right","pt_right","pt_out","right","right","right","113,36,113,73,88,73,93,64,94,55,94,46,91,36","poly");
  w+=GetAREA("left down ","left down","pt_left_down","pt_out","left_down","left_down","left_down","21,73,0,73,15,96,36,108,36,88,30,83,25,78","poly");
  w+=GetAREA("down ","down","pt_down","pt_out","down","down","down","36,87,36,111,74,114,74,86,66,90,55,91,44,90","poly");
  w+=GetAREA("right down ","right down","pt_right_down","pt_out","right_down","right_down","right_down","74,86,74,108,95,94,110,73,88,73,86,78,79,83","poly");
  w+=GetAREA("zoom in ","zoom in","pt_zoom_in","pt_out"  ,"zoom_in"  ,"zoom_in","zoom_in"  ,"55,39,55,15,41,17,27,27,19,39,16,56,21,73,30,84,42,89,55,91,55,69,44,65,40,53,44,44","poly");
  w+=GetAREA("zoom out ","zoom out","pt_zoom_out","pt_out","zoom_out","zoom_out","zoom_out","55,16,70,19,84,27,91,37,94,50,92,65,87,78,74,86,65,91,55,91,55,70,63,66,68,59,68,51,64,43,55,40","poly");
  w+='<area href="#" coords="18,22" shape="poly">';
  w+='</map></p>';
  
  return w;
}
function PtzCtrl()
{
  var w='';
  w = '<tr align="center"><td>'+PtzCtrlMap("dark")+'</td></tr>';
  
  if (g_isSupportVisca==1)
  {
    w+='<tr><td>&nbsp;</td></tr>';
    w+='<tr>';
   			w+='<td><a href="javascript:ClickAutoFocuse()"><img id="img_af" alt="'+GL("auto_focus")+'"src="/'+((g_focusmodeinq==1) ? 'v_af_on_n.gif':'v_af_off_n.gif')+'" width="38" height="20" border="0"/></a>';
   			w+='<font color="#ffffff">&nbsp;'+GL("mode")+'&nbsp;</font>';
   			w+='<a href="javascript:ClickManualFocuse()"><img id="img_mf" alt="'+GL("manual_focus")+'"src="/'+((g_focusmodeinq==0) ? 'v_mf_on_n.gif':'v_mf_off_n.gif')+'" width="38" height="20" border="0"/></a></td>';
   	w+='</tr><tr>';
		w+='<td><div id="mfctrl" style="display:'+( g_focusmodeinq==0 ? "block" : "none" )+';">';
    		w+='<img id="FocusNear" src="v_in_off_n.gif" width="38" height="20" onmouseup="ClickFocusStop();" onmousedown="ClickFocusNear();" style="cursor:pointer;">';
    		w+='<font color="#ffffff">&nbsp;'+GL("focus")+'&nbsp;</font>';
    		w+='<img id="FocusFar" src="v_out_off_n.gif" width="38" height="20" onmouseup="ClickFocusStop();" onmousedown="ClickFocusFar();" style="cursor:pointer;">';
		w+='</div></td>';
	w+='</tr>';
	
    w+='<tr><td>&nbsp;</td></tr>';
    w+='<tr><td>';
		w+='<table>';
				w+='<tr><td valign="bottom"><font color="#ffffff">'+GL("ptz_panspeed")+' </font></td><td>'+visca_panspeed.html+'</td></tr>';
				w+='<tr><td valign="bottom"><font color="#ffffff">'+GL("ptz_tiltespeed")+' </font></td><td>'+visca_tiltspeed.html+'</td></tr>';
				w+='<tr><td>&nbsp;</td></tr>';
			    w+='<tr><td><a href="javascript:ClickViscaPan()"><img id="img_pan" alt="'+GL("auto_pan")+'"src="/v_pan-off_n.gif" width="38" height="20" border="0"/></a>'+'</td><td>'+visca_ptzpanlist.html+'</td></tr>';
			    w+='<tr><td><a href="javascript:ClickViscaSequence()"><img id="img_seq" alt="'+GL("auto_sequence")+'"src="/v_seq-off_n.gif" width="38" height="20" border="0"/></a>'+'</td><td>'+visca_ptzseqlist.html+'</td></tr>';
			    w+='<tr><td><a href="javascript:ClickViscaCruise()"><img id="img_cruise" alt="'+GL("auto_cruise")+'"src="/v_cruise_off_n.gif" width="38" height="20" border="0"/></a>'+'</td><td>'+visca_ptzcruiselist.html+'</td></tr>';
		w+='</table>';
	w+='</td></tr>';
  }

  if(g_isSupportEPTZ == 1 && (!IsViewer()) )
  {
    w+='<tr><td>&nbsp;</td></tr>';
    w+='<tr><td align="center">';
		w+='<a href="javascript:ClickPan()"><img id="img_pan" alt="'+GL("auto_pan")+'" src="/pan-off_n.gif" width="32" height="32" border="0"/></a>&nbsp;&nbsp;';
		w+='<a href="javascript:ClickStop()"><img id="img_stop" alt="'+GL("stop")+'" src="/stop-off_n.gif" width="32" height="32" border="0"/></a>&nbsp;&nbsp;';
		w+='<a href="javascript:ClickSequence()"><img id="img_seq" alt="'+GL("setup_auto_sequence_t")+'" src="seq-off_n.gif" width="32" height="32" border="0"/></a>';
	w+='</td></tr>';
    //w+='<tr><td>&nbsp;</td></tr>';
	//w+='<tr><td id="gotopreset"><img id="img_preset" src="/goto-off_p.gif" width="66" height="20" border="0"/>&nbsp;'+presetselect.html+'</td></tr>';
  }	
  
  //w+='<tr><td><a href="javascript:ClickSequence()" ><img id="img_sequence" alt="'+GL("setup_auto_sequence_t")+'"src="/sequence_off.gif" width="32" height="32" border="0"/></a></td></tr>';
  
  w+='<tr><td align="left"><p align="left" id="displayPT2" style="display: inline;"><br/>';
  if(g_isShowRs485 == 1 && g_isSupportEPTZ == 1)
  {
  
    w+='<font color="#ffffff">'+GL("ptz_control")+'</font><br/>';
    w+=g_ptzselect.html+'<br/><br/>';
	
  }
  //w+='<font color="#ffffff">'+GL("ptz_panspeed")+'</font><br/>';
  //w+=panspeed.html+'<br/><br/>';
  //w+='<font color="#ffffff">'+GL("ptz_tiltespeed")+'</font><br/>';
  //w+=tiltespeed.html+'</p></td></tr>';
  
  //w+=InputButton("PerformAF",GL("af_automatically"),"autofocus_1")+'<br/>';
  
  
  if(g_isSupportEPTZ == 1)
  {
    w+='<font color="#ffffff">'+GL("ptz_speed")+' : </font>';
    w+=ptzspeed.html+'</p></td></tr>';
    //w+='<tr><td><img id="img_speed" src="/speed-off_p.gif" width="66" height="20" border="0"/>&nbsp;'+ptzspeed.html+'</td></tr>';

    w+='<tr><td></br><a href="javascript:ChangeGlobalViewStatus()" style="text-decoration:none"><img id="globalview_img" src="global-off_n.gif" width="96" height="20" border="0"/></a></td></tr>';
    //w+='<tr><td><p><img id="showdms_2" src="/Load.jpg" width="120" height="90"/></p></td></tr>';  
    w+='<tr><td><div id="GlobalView">&nbsp;</div></td></tr>';  
  }	else{
    ////chunche[08/31]: ptzspeed need to respond speed value, when not suppoet EPTZ!!
    ptzspeed.GV = function (){ return _ptzspeed; };
  }
  w+='<div></div><img id="sendPTZCmd" width="0" height="0" border="0" src="" />';
  return w;
};

//var g_GoToPreset;
function GoToPreset()
{
  var str = presetselect.GV();
  if(str=="--Preset List--") return;

  if(g_isSupportVisca == 1)
  {
    var sl =str.split("-");
    var name = sl[1];
    var num = parseInt(sl[0]);
		
    SendHttpPublic("cgi-bin/viscapreset.cgi?action=goto&name="+name+"&number="+num,false);
  }
  else
  {
    SendHttpPublic("cgi-bin/eptzpreset.cgi?action=goto&streamid="+mpMode+"&name="+presetselect.GV()+"&direction=point",false);
	if(g_isEPTZviewer)
		setTimeout( function(){ SendEPTZPoint(mpMode,GetGoTo) } , (EptzPositonWorking ? 1100 : 300) );
  }
  /*
  g_GoToPreset = null;
  g_GoToPreset = InitXHttp();
  g_GoToPreset.onreadystatechange = GetGoTo;
  
  try
  {
    g_GoToPreset.open("GET", "cgi-bin/eptzpreset.cgi?action=goto&name="+presetselect.GV(), false);
    g_GoToPreset.setRequestHeader("If-Modified-Since","0");
    g_GoToPreset.send(null);
    WS(GL("sending_"));
  }catch(e){};  
  */
};

function GetGoTo()
{
    if(SendEPTZPointHttp.readyState==4)
	{
		WS("");
		if(SendEPTZPointHttp.status==200)
		{
			var txt=SendEPTZPointHttp.responseText;
			var vv=txt.split('=');
			if(vv.length>=2)
			{
			  if(mpMode == 1)
			  {
				g_EPTZ1x1 = parseInt(vv[1].substr(0,4)*1);
				g_EPTZ1y1 = parseInt(vv[1].substr(4,4)*1);
				//SendEPTZCmd(g_EPTZ1x1,g_EPTZ1y1);
			  }
              else if(mpMode == 2)
              {			  
				g_EPTZ2x1 = parseInt(vv[1].substr(0,4)*1);
				g_EPTZ2y1 = parseInt(vv[1].substr(4,4)*1);
				//SendEPTZCmd(g_EPTZ2x1,g_EPTZ2y1);
			  }
              else if(mpMode == 3)
              {			  
				g_EPTZ3x1 = parseInt(vv[1].substr(0,4)*1);
				g_EPTZ3y1 = parseInt(vv[1].substr(4,4)*1);
				//SendEPTZCmd(g_EPTZ3x1,g_EPTZ3y1);
			  }	
			  //SendEPTZPoint(profile.GV());
			  if(g_isEPTZviewer)
				MoveUvumiWin();
			}
			else
			{
				alert(GL("get_fail"));
			}
		}
		else
		{
			alert(GL("get_fail"));
		}
	}
	
};

function SendEPTZCmd(left,top)
{
  var str_x = '';
  var str_y = '';
  str_x += left;
  str_y += top;
  if(str_x.length < 4)
  {
	if(str_x.length == 1)
	  str_x='000'+str_x;
	else if(str_x.length == 2)
	  str_x='00'+str_x;
	else if(str_x.length == 3)  
	  str_x='0'+str_x;
  }
  if(str_y.length < 4)
  {
	if(str_y.length == 1)
	  str_y='000'+str_y;
	else if(str_y.length == 2)
	  str_y='00'+str_y;
	else if(str_y.length == 3)  
	  str_y='0'+str_y;
  }	  
  SendHttpEPTZ("/vb.htm?eptzcoordinate="+mpMode+str_x+str_y,false);
};

function ChangeImg(id,src)
{
  obj = GE(id);
  if(obj != null)
    obj.src = src;
};


function ClickPan()
{
  ChangeImg("img_pan","pan-on_n.gif");
  //ChangeImg("img_seq","seq-off_p.gif");
  SendHttpPublic("cgi-bin/eptzpreset.cgi?action=autopan&streamid="+mpMode,false);
  //setTimeout('ChangeImg("img_pan","pan-off_n.gif")', 200);
};

function ClickStop()
{
  ChangeImg("img_stop","stop-on_n.gif");
  //ChangeImg("img_pan","pan-off_p.gif");
  //ChangeImg("img_seq","seq-off_p.gif");
  SendHttpPublic("cgi-bin/eptzpreset.cgi?action=stop&streamid="+mpMode,false);
  setTimeout('ChangeImg("img_stop","stop-off_n.gif")', 200);
};

function ClickSequence()
{
  //ChangeImg("img_pan","pan-off_p.gif");
  ChangeImg("img_seq","seq-on_n.gif");
  SendHttpPublic("cgi-bin/eptzpreset.cgi?action=seq_go&streamid="+mpMode,false);
  //setTimeout('ChangeImg("img_seq","seq-off_n.gif")', 200);
};

//only for visca of ptz
function CheckImgMatch(id,img){
	var src = "";
	obj = GE(id);
	
	if(obj!=null){
		src = obj.src;
		if(src.match(img)==img)
			return true;
		else
			return false;
	}
}
function ClickViscaPan(){
	if (g_isSupportVisca==1){
		if(CheckImgMatch("img_pan", "v_pan-on_n.gif")){
			SendViscaCmdToDevice(CMD_AUTO_STOP);
			ChangeImg("img_pan", "v_pan-off_n.gif");
		}else{
			SendViscaCmdToDevice(CMD_AUTO_PAN);
			ChangeImg("img_pan", "v_pan-on_n.gif");
		}
		ChangeImg("img_seq", "v_seq-off_n.gif");
		ChangeImg("img_cruise", "v_cruise_off_n.gif");
	}
};
function ClickViscaSequence(){
	if (g_isSupportVisca==1){
		if(CheckImgMatch("img_seq", "v_seq-on_n.gif")){
			SendViscaCmdToDevice(CMD_AUTO_STOP);
			ChangeImg("img_seq", "v_seq-off_n.gif");
		}else{
			SendViscaCmdToDevice(CMD_AUTO_SEQUENCE);
			ChangeImg("img_seq", "v_seq-on_n.gif");
		}
		ChangeImg("img_pan", "v_pan-off_n.gif");
		ChangeImg("img_cruise", "v_cruise_off_n.gif");
	}
}
function ClickViscaCruise(){
	if (g_isSupportVisca==1){
		if(CheckImgMatch("img_cruise", "v_cruise_on_n.gif")){
			SendViscaCmdToDevice(CMD_AUTO_STOP);
			ChangeImg("img_cruise", "v_cruise_off_n.gif");
		}else{
			SendViscaCmdToDevice(CMD_AUTO_CRUISE);
			ChangeImg("img_cruise", "v_cruise_on_n.gif");
		}
		ChangeImg("img_pan", "v_pan-off_n.gif");
		ChangeImg("img_seq", "v_seq-off_n.gif");
	}
}
function ClickAutoFocuse(mode)
{
  if (g_isSupportVisca==1 && g_focusmodeinq==0){
	  SendViscaCmdToDevice("CMD_FOCUS_AUTO");
	  
	  ChangeImg("img_af", "v_af_on_n.gif");
	  ChangeImg("img_mf", "v_mf_off_n.gif");
	  //ChangeImg("FocusNear", "v_in_off_p.gif");
	  //ChangeImg("FocusFar", "v_out_off_p.gif");
	  GE("mfctrl").style.display = "none";
	  g_focusmodeinq = 1;
  }
};
function ClickManualFocuse()
{
  if (g_isSupportVisca==1 && g_focusmodeinq==1){
	  SendViscaCmdToDevice("CMD_FOCUS_MANUAL");
	  
	  ChangeImg("img_af", "v_af_off_n.gif");
	  ChangeImg("img_mf", "v_mf_on_n.gif");
	  //ChangeImg("FocusNear", "v_in_off_n.gif");
	  //ChangeImg("FocusFar", "v_out_off_n.gif");
	  GE("mfctrl").style.display = "block";
	  g_focusmodeinq = 0;
  }
};
function ClickFocusStop()
{
  if (g_isSupportVisca==1 && g_focusmodeinq==0)
	 SendViscaCmdToDevice("CMD_FOCUS_STOP");
};
function ClickFocusFar()
{
  if (g_isSupportVisca==1 && g_focusmodeinq==0)
	 SendViscaCmdToDevice("CMD_FOCUS_FAR");
};
function ClickFocusNear()
{
  if (g_isSupportVisca==1 && g_focusmodeinq==0)
	 SendViscaCmdToDevice("CMD_FOCUS_NEAR");
};
//end only for visca

function ChangeGlobalViewStatus(status)
{
  var viewer = false;
  var obj = GE("GlobalView");
  
  if(obj != null)
  {
    if(status != null)
	  viewer = !status;
	else
	  viewer = g_isEPTZviewer;
	  
    if(viewer)
	{
	  g_isEPTZviewer = false;
	  
	  if(EptzPositonWorking)
		StopGetEptzPostion();
	  
	  setTimeout(function(){
		  GE("globalview_img").src = "global-off_n.gif";
		  obj.innerHTML='';
	  }, 500);
	}
	else
	{
	  GE("globalview_img").src = "global-on_f.gif";
      obj.innerHTML='<img id="showdms_2" src="/Load.jpg" width="'+g_globalWidth+'" height="'+g_globalHeight+'"/>';
	  if(g_isSupportEPTZ == 1)
	    RunCropper();
		
	  if(!EptzPositonWorking)
		SendEPTZPoint(mpMode);
		
	  g_isEPTZviewer = true;
	}  
  }
};

function PerformAF()
{
  SubmitHttp = null;
  SubmitHttp = InitXHttp();
  
  try
  {
    SubmitHttp.open("GET", "cgi-bin/lencontrol.cgi?autofocus=1", false);
    SubmitHttp.setRequestHeader("If-Modified-Since","0");
    SubmitHttp.send(null);
    WS(GL("sending_"));
  }catch(e){};
  g_httpOK = true;
};

function GetAREA(title,alt,id,onmouseout,onmouseover,onmouseup,onmousedown,coords,type)
{
  var i=''
  i+='<area title="'+title+'" alt="'+alt+'" id="'+id+'" onmouseout="outImage('+"'"+onmouseout+"'"+')" onmouseover="overImage('+"'"+onmouseover+"'"+')" onmouseup="move('+"'"+onmouseup+"'"+')" onmousedown="pressImage('+"'"+onmousedown+"'"+')" coords="'+coords+'" shape="'+type+'">';
  return i;
};
function overImage(type)
{
  if (type == "left_up")
	document.PTControl.src = imagePT["left_up_f"].src;
  if (type == "up")
	document.PTControl.src = imagePT["up_f"].src;
  if (type == "right_up")
	document.PTControl.src = imagePT["right_up_f"].src;
  if (type == "left")
	document.PTControl.src = imagePT["left_f"].src;
  if (type == "home")
	document.PTControl.src = imagePT["home_f"].src;
  if (type == "right")
	document.PTControl.src = imagePT["right_f"].src;
  if (type == "left_down")
	document.PTControl.src = imagePT["left_down_f"].src;
  if (type == "down")
	document.PTControl.src = imagePT["down_f"].src;
  if (type == "right_down")
	document.PTControl.src = imagePT["right_down_f"].src;
  if (type == "zoom_out")
	document.PTControl.src = imagePT["zoom_out_f"].src;
  if (type == "zoom_in")
	document.PTControl.src = imagePT["zoom_in_f"].src;
};
function outImage(type)
{
  if (type == "pt_out")
    document.PTControl.src = imagePT["way_control_n"].src;
};
function pressImage(type,isMouse)
{
  //alert(type);
  if(g_PTZMode!=3){//not visca
    num = 2*ptzspeed.GV();
    var x1 = g_EPTZmouseY;
    var y1 = g_EPTZmouseX;
  }
  //alert(g_EPTZmouseX+':'+g_EPTZmouseY);
  if (type == "left_up")
  {
	if(isMouse==null)
      document.PTControl.src = imagePT["left_up_p"].src;
	  
	if(g_PTZMode == 0 || g_PTZMode == 3){//rs485 or visca
      SendDLinkPTZCmd2Device("CMD_UP_LEFT");
	}
	else if(g_PTZMode == 1)//eptz
	{
	  x1 = parseInt(x1-num);
	  y1 = parseInt(y1-num);
	}
	
	if(!g_isEPTZviewer && g_PTZMode!=3)//GlobalView is Visabled, and not Visca.
	{
	  SendHttpPublic("/cgi-bin/eptzpreset.cgi?action=goto&streamid="+mpMode+"&direction=left_up");
	}
  }

  if (type == "up")
  {
	if(isMouse==null)
      document.PTControl.src = imagePT["up_p"].src;
	  
	if((g_PTZMode == 0)||(g_PTZMode == 3)){//rs485 or visca
      SendDLinkPTZCmd2Device("CMD_TILT_UP");
	}
	else if(g_PTZMode == 1)//eptz
	{
	  y1 = parseInt(y1-num);
	}
	
	if(!g_isEPTZviewer && g_PTZMode!=3){//GlobalView is Visabled, and not Visca.
	  SendHttpPublic("/cgi-bin/eptzpreset.cgi?action=goto&streamid="+mpMode+"&direction=up");
	}
  }

  if (type == "right_up")
  {
	if(isMouse==null)
      document.PTControl.src = imagePT["right_up_p"].src;
	  
	if((g_PTZMode == 0)||(g_PTZMode == 3)){//rs485 or visca
      SendDLinkPTZCmd2Device("CMD_UP_RIGHT");
	}
	else if(g_PTZMode == 1)//eptz
	{
      x1 = parseInt(x1+num);
	  y1 = parseInt(y1-num);
	}  
	
	if(!g_isEPTZviewer && g_PTZMode!=3)//GlobalView is Visabled, and not Visca.
		SendHttpPublic("/cgi-bin/eptzpreset.cgi?action=goto&streamid="+mpMode+"&direction=right_up");
  }

  if (type == "left")
  {
	if(isMouse==null)
	  document.PTControl.src = imagePT["left_p"].src;
	  
	if((g_PTZMode == 0)||(g_PTZMode == 3)){//rs485 or visca
      SendDLinkPTZCmd2Device("CMD_PAN_LEFT");
	}
	else if(g_PTZMode == 1)//eptz
	{
      x1 = parseInt(x1-num);
	} 
	
	if(!g_isEPTZviewer && g_PTZMode!=3)//GlobalView is Visabled, and not Visca.
		SendHttpPublic("/cgi-bin/eptzpreset.cgi?action=goto&streamid="+mpMode+"&direction=left");
  }

  if (type == "home")
  {
	if(isMouse==null)
	  document.PTControl.src = imagePT["home_p"].src;
	
	if(g_PTZMode == 0)//RS485
      SendDLinkPTZCmd2Device("CMD_HOME");
	else if(g_PTZMode == 3)//VISCA
		SendHttpPublic("cgi-bin/viscahome.cgi?action=gohome",false);
	else if(g_PTZMode == 1)//EPTZ
	{
	  if(g_isEPTZviewer)
	  {
	    if(l_profileresolution[mpMode-1] != l_profilereviewer[mpMode-1])
		{
	      //g_Cropper.moveToClick_EPTZ(64/(240/90),80/(320/120)); 
		  num = l_profileresolution[mpMode-1].split('x');
		  num2 = l_profilereviewer[mpMode-1].split('x');
		  ratew = num[0]/num2[0];
		  rateh = num[1]/num2[1];
		  
		  ratew2 = num2[0]/g_globalWidth;
		  rateh2 = num2[1]/g_globalHeight;
		  
		  halfW = g_globalWidth/2;
		  halfH = g_globalHeight/2;
		  half2W = (num2[0]/ratew2)/ratew/2;
		  half2H = (num2[1]/ratew2)/rateh/2;
		  
		  //alert(halfW);
		  //alert(half2W);
          //alert(halfH - half2H);
          //alert(halfW - half2W);
		  g_Cropper.moveToClick_EPTZ(halfH - half2H,halfW - half2W); 
		}  
	  }
      else{
    	  SendHttpPublic("/cgi-bin/eptzpreset.cgi?action=goto&streamid="+mpMode+"&direction=home");
	  }
	  
	  var obj = GE(AxID);
      if (obj != null)
      {
	    g_ZoomSize = 0;
        obj.SetZoomSize(g_ZoomSize);
      }
	}
    return 0;	
  }

  if (type == "right")
  {
	if(isMouse==null)
      document.PTControl.src = imagePT["right_p"].src;
	if((g_PTZMode == 0)||(g_PTZMode == 3))//rs485 or visca
      SendDLinkPTZCmd2Device("CMD_PAN_RIGHT");
	else if(g_PTZMode == 1)//eptz
	{
      x1 = parseInt(x1+num);
	}    
	if(!g_isEPTZviewer && g_PTZMode!=3)//GlobalView is Visabled, and not Visca.
		SendHttpPublic("/cgi-bin/eptzpreset.cgi?action=goto&streamid="+mpMode+"&direction=right");
  }

  if (type == "left_down")
  {
	if(isMouse==null)
      document.PTControl.src = imagePT["left_down_p"].src;
	if((g_PTZMode == 0)||(g_PTZMode == 3))//rs485 or visca
      SendDLinkPTZCmd2Device("CMD_DOWN_LEFT");
	else if(g_PTZMode == 1)//eptz
	{
      x1 = parseInt(x1-num);
	  y1 = parseInt(y1+num);      
	}  
	if(!g_isEPTZviewer && g_PTZMode!=3)//GlobalView is Visabled, and not Visca.
		SendHttpPublic("/cgi-bin/eptzpreset.cgi?action=goto&streamid="+mpMode+"&direction=left_down");
  }

  if (type == "down")
  {
	if(isMouse==null)
      document.PTControl.src = imagePT["down_p"].src;
	if((g_PTZMode == 0)||(g_PTZMode == 3))//rs485 or visca
      SendDLinkPTZCmd2Device("CMD_TILT_DOWN");
	else if(g_PTZMode == 1)//eptz
	{
      y1 = parseInt(y1+num);
	}    
	if(!g_isEPTZviewer && g_PTZMode!=3)//GlobalView is Visabled, and not Visca.
		SendHttpPublic("/cgi-bin/eptzpreset.cgi?action=goto&streamid="+mpMode+"&direction=down");
  }

  if (type == "right_down")
  {
	if(isMouse==null)
	   document.PTControl.src = imagePT["right_down_p"].src;
	if((g_PTZMode == 0)||(g_PTZMode == 3))//rs485 or visca
      SendDLinkPTZCmd2Device("CMD_DOWN_RIGHT");
	else if(g_PTZMode == 1)//eptz
	{
	  x1 = parseInt(x1+num);
	  y1 = parseInt(y1+num);
	}
	if(!g_isEPTZviewer && g_PTZMode!=3)//GlobalView is Visabled, and not Visca.
		SendHttpPublic("/cgi-bin/eptzpreset.cgi?action=goto&streamid="+mpMode+"&direction=right_down");
  }

  if (type == "zoom_out")
  {
	if(isMouse==null)
      document.PTControl.src = imagePT["zoom_out_p"].src;
	if((g_PTZMode == 0)||(g_PTZMode == 3)){//rs485 or visca
      SendDLinkPTZCmd2Device("CMD_ZOOM_OUT");
	}
	else
	{//eptz
	  var obj = GE(AxID);
      if (obj != null)
      {
	    g_ZoomSize--;
		if(g_ZoomSize <= 0)
		  g_ZoomSize = 0;
        obj.SetZoomSize(g_ZoomSize);
      }
	} 
	//start 2010.11.8 add
	/*if(g_isSupportVisca == 1){
		g_ViscaZoomEn = true;
		clearTimeout(timerVisca);
		timerVisca = setTimeout("StartViscaWorker()", 0);
	}*/
	//end 2010.11.8
  }

  if (type == "zoom_in")
  {
	if(isMouse==null)
	  document.PTControl.src = imagePT["zoom_in_p"].src;
	if((g_PTZMode == 0)||(g_PTZMode == 3)){//rs485 or visca
      SendDLinkPTZCmd2Device("CMD_ZOOM_IN");
	}
	else
	{//eptz
	  var obj = GE(AxID);
      if (obj != null)
      {
	    g_ZoomSize++;
	    if(g_ZoomSize >=9)
		  g_ZoomSize = 9;
        obj.SetZoomSize(g_ZoomSize);
      }
	}
	//start 2010.11.8 add
	/*if(g_isSupportVisca == 1){
		g_ViscaZoomEn = true;
		clearTimeout(timerVisca);
		timerVisca = setTimeout("StartViscaWorker()", 0);
	}*/
	//end 2010.11.8
  }
  
  if(g_PTZMode == 1)
  {//EPTZ
    if(y1 < 0)
	  y1 = 0;
	if(x1 < 0)
      x1 = 0;
	  
	w = parseInt(g_globalWidth-g_EPTZWidth);
	h = parseInt(g_globalHeight-g_EPTZHeight);
    if(y1 > h)	  
	  y1 = h;
	if(x1 > w)
      x1 = w; 
	if(g_isEPTZviewer)
      g_Cropper.moveToClick_EPTZ(y1,x1); 
  }	
}
function move(type) 
{
  if (type=="left_up" || type=="up" || type=="right_up" || type=="left" ||
      type=="right" || type=="left_down" || type=="down" || type=="right_down")
  {
	if (g_isSupportVisca==1){
		SendDLinkPTZStopCmd(CMD_PANTILT_STOP);//CMD_PANTILT_STOP
	}else{
		SendDLinkPTZStopCmd();//stop
	}
  }
  else
  if (type=="zoom_out" || type=="zoom_in")
  {
	SendDLinkPTZStopCmd();
	//start 2010.11.8 add
	/*if(g_isSupportVisca == 1){
		g_ViscaZoomEn = false;
		clearTimeout(timerVisca);
	}*/
	if (g_isSupportVisca==1)
		StartViscaWorker();//to update zoom ratio.
	//end 2010.11.8
  }

  document.PTControl.src = imagePT["way_control_n"].src;
}

var g_ResolutionX;
var g_ResolutionY;
var g_tempx1;
var g_tempy1;
var g_MouseNumX = 0;
var g_MouseNumY = 0;
var JOYSTICK_MIN = 0;
var JOYSTICK_MID = 32767;
var JOYSTICK_MAX = 65535; 
var JOYSTICK_FIXNUM = 3000;
var timerPTZ = null;
var g_EPTZ_type = "";
var g_PTZ_TimeInterval = 100;

function StartEPTZWorker()
{
  if(!IsMozilla())
  {
    var obj = GE(AxID);
    if(obj!=null)
    {
	  if(obj.GetIsJoystick() == 1)
	  {
		var cmd = '';
	    var x1 = parseInt( obj.GetJoystickX() );
	    var y1 = parseInt( obj.GetJoystickY() );
	    
	    if(x1 < (JOYSTICK_MID - JOYSTICK_FIXNUM) )
		{//x-left
			if(y1 < (JOYSTICK_MID - JOYSTICK_FIXNUM) )
			{//y-top area
				//left-up
				if(g_EPTZ_type!="left_up"){
				  cmd = '';
				  for(i=0;i<CMD_UP_LEFT.length;i++)
				    cmd += CMD_UP_LEFT[i]+',';
				  pressImage("left_up",cmd);
				  g_EPTZ_type = "left_up";
				}
				
			}
			else if(y1 >= (JOYSTICK_MID - JOYSTICK_FIXNUM) && y1 <= (JOYSTICK_MID + JOYSTICK_FIXNUM))
			{//y-middle area
				//left
				if(g_EPTZ_type!="left"){
				  cmd = '';
				  for(i=0;i<CMD_PAN_LEFT.length;i++)
				    cmd += CMD_PAN_LEFT[i]+',';
				  pressImage("left",cmd);
				  g_EPTZ_type = "left";
				}
				
			}
			else if(y1 > (JOYSTICK_MID + JOYSTICK_FIXNUM) )
			{//y-bottom area
				//left-down
				if(g_EPTZ_type!="left_down"){
				  cmd = '';
				  for(i=0;i<CMD_DOWN_LEFT.length;i++)
				    cmd += CMD_DOWN_LEFT[i]+',';
				  pressImage("left_down",cmd);
				  g_EPTZ_type = "left_down";
				}
				
			}
		}
		else if(x1 >= (JOYSTICK_MID - JOYSTICK_FIXNUM) && x1 <= (JOYSTICK_MID + JOYSTICK_FIXNUM))
		{//x-middle
			if(y1 < (JOYSTICK_MID - JOYSTICK_FIXNUM) )
			{//y-top area
				//up
				if(g_EPTZ_type!="up"){
				  cmd = '';
				  for(i=0;i<CMD_TILT_UP.length;i++)
				    cmd += CMD_TILT_UP[i]+',';
				  pressImage("up",cmd);
				  g_EPTZ_type = "up";
				}
				
			}
			else if(y1 >= (JOYSTICK_MID - JOYSTICK_FIXNUM) && y1 <= (JOYSTICK_MID + JOYSTICK_FIXNUM))
			{//y-middle area
				if(g_EPTZ_type!=""){
					//to do stop
					if(g_PTZMode == 0)//PTZ
					{
						cmd = '';
						for(i=0;i<CMD_STOP.length;i++)
							cmd += CMD_STOP[i]+',';
						SendPTZCmdToDevice(cmd);
					}else
					if(g_PTZMode == 3){//VISCA
						SendDLinkPTZStopCmd(CMD_PANTILT_STOP);//CMD_PANTILT_STOP
					}
					g_EPTZ_type = "";
				}
				//g_EPTZnum = 1;
				//var obj = GE("PTControl");
	            //obj.src = imagePT["ptz"].src;
			}
			else if(y1 > (JOYSTICK_MID + JOYSTICK_FIXNUM) )
			{//y-bottom area
				//down
				if(g_EPTZ_type!="down"){
				  cmd = '';
				  for(i=0;i<CMD_TILT_DOWN.length;i++)
				    cmd += CMD_TILT_DOWN[i]+',';
				  pressImage("down",cmd);
				  g_EPTZ_type = "down";
				}
				
			}
		}
		else if(x1 > (JOYSTICK_MID + JOYSTICK_FIXNUM) )
		{//x-right
			if(y1 < (JOYSTICK_MID - JOYSTICK_FIXNUM) )
			{//y-top area
				//right-up
				if(g_EPTZ_type!="right_up"){
				  cmd = '';
				  for(i=0;i<CMD_UP_RIGHT.length;i++)
				    cmd += CMD_UP_RIGHT[i]+',';
			      pressImage("right_up",cmd);
			      g_EPTZ_type = "right_up";
				}
				
			}
			else if(y1 >= (JOYSTICK_MID - JOYSTICK_FIXNUM) && y1 <= (JOYSTICK_MID + JOYSTICK_FIXNUM))
			{//y-middle area
				//right
				if(g_EPTZ_type!="right"){
				  cmd = '';
				  for(i=0;i<CMD_PAN_RIGHT.length;i++)
				     cmd += CMD_PAN_RIGHT[i]+',';
				  pressImage("right",cmd);
				  g_EPTZ_type = "right";
				}
				
			}
			else if(y1 > (JOYSTICK_MID + JOYSTICK_FIXNUM) )
			{//y-bottom area
				//right-down
				if(g_EPTZ_type!="right_down"){
				  cmd = '';
				  for(i=0;i<CMD_DOWN_RIGHT.length;i++)
				  {
				    cmd += CMD_DOWN_RIGHT[i]+',';
				  }
				  pressImage("right_down",cmd);
				  g_EPTZ_type = "right_down";
				}
				
			}
		}
	  }
      else
      {	  
        g_MouseNumX = parseInt(obj.GetJoystickMouseX());
        g_MouseNumY = (-1)*parseInt(obj.GetJoystickMouseY());
        //window.status = "MouseNumX="+g_MouseNumX+" MouseNumY="+g_MouseNumY;
        
	    if(g_MouseNumX != 0 && g_MouseNumY != 0)
		{
			EPTZMouseEvent( g_MouseNumX/4, g_MouseNumY/4 );
		}
	    else
		{
	    	if(g_EPTZ_type!="")
			{
		      if (g_isSupportVisca==1)
		   		SendDLinkPTZStopCmd(CMD_PANTILT_STOP);//CMD_PANTILT_STOP, not include zoom stop
		      else
		   		SendDLinkPTZStopCmd();//stop
		   	  g_EPTZ_type = "";
		   	}
	    }
	  }
	  timerEPTZJoystick = setTimeout("StartEPTZWorker()",g_PTZ_TimeInterval);
	}
  }
  else
  {
	//not IE
  }  
  
};

function EPTZMouseEvent(x,y){
//calculate direct
	cmdtype = "";
	s = y/x;
	a = Math.atan(s)*180/3.14;
	//window.status = 'x= '+x+' y= '+y+ ' y/x= '+s+' angle= '+a;
	
	if(x>0)
	{
		//1
		if(a>0 && a<22.5)
			cmdtype = "right";
		else if(a>=22.5 && a<67.5)
			cmdtype = "right_up";
		else if(a>=67.5 && a<90)
			cmdtype = "top";
		//4
		else if(a<0 && a>-22.5)
			cmdtype = "right";
		else if(a<=-22.5 && a>-67.5)
			cmdtype = "right_down";
		else if(a<=-67.5 && a>-90)
			cmdtype = "down";
	}
	else
	{
		//3
		if(a>0 && a<22.5)
			cmdtype = "left";
		else if(a>=22.5 && a<67.5)
			cmdtype = "left_down";
		else if(a>=67.5 && a<90)
			cmdtype = "down";
		//2
		else if(a<0 && a>(-22.5))
			cmdtype = "left";
		else if(a<=-22.5 && a>-67.5)
			cmdtype = "left_up";
		else if(a<=-67.5 && a>-90)
			cmdtype = "up";
	}
	
//--2010.12.29 calculate speed
	if (g_isSupportVisca==1)
	{
		rateX = Math.floor(g_viewXSize/320);
		rateY = Math.floor(g_viewYSize/240);
		oX = Math.floor(g_viewXSize/2/rateX/4);
		oY = Math.floor(g_viewYSize/2/rateY/4);
		psRateX = oX/15;//pan speed rate
		tsRateY = oY/15;//tile speed rate
		pspeed = Math.abs(Math.floor(x/psRateX));//pan speed
		tspeed = Math.abs(Math.floor(y/tsRateY));//tile speed
		
		//window.status = 'rateX= '+rateX+' rateY= '+rateY;
		//window.status = 'oX= '+oX+' oY= '+oY;
		window.status = 'pspeed= '+pspeed+' tspeed= '+tspeed;
		if(visca_panspeed!=null)
		{
			visca_panspeed.SV( pspeed<=15 ? pspeed : 15 );
			OnClickSpeed("panspeed");		
		}
		if(visca_tiltspeed!=null)
		{
			visca_tiltspeed.SV( tspeed<=15 ? tspeed : 15 );
			OnClickSpeed("tiltspeed");
		}
	}
//--2010.12.29
	
//--start 2011.4.18 modified, send command
	if (g_isSupportVisca==1)
	{
		if (cmdtype!=g_EPTZ_type)
			pressImage(cmdtype, true);
	}
	else
	{
		pressImage(cmdtype, true);
	}
	g_EPTZ_type = cmdtype;
//--end 2011.4.18
};

function OnClickSpeed(type)
{
	if(type=="panspeed")
	{
		SendHttpPublic(c_iniUrl+"&setvspanspeed="+visca_panspeed.GV());
	}
	else
	if(type=="tiltspeed")
	{
		SendHttpPublic(c_iniUrl+"&setvstiltspeed="+visca_tiltspeed.GV());
	}
}