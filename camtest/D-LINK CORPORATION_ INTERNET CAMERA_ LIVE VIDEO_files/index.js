//define the check alarm timer interval.
var g_AlarmCheckTime = 1500;
var g_AlarmApi = "getalarmstatus";
var timerID=null;
var timerID2=null;
var timerIDAlarm = null;
var timerChangeImage = null;
var timerEPTZ = null;
var timerEPTZJoystick = null;
//var timerVisca = null;
//var g_ViscaZoomEn = false;
//var g_ViscaInterval = 500;
var l_profileformat = new Array("<%profile1format%>","<%profile2format%>","<%profile3format%>","<%profile4format%>");
var g_entriggerout = parseInt(GV("<%allgiooutenable%>",0));
var g_h264Status = parseInt(GetCookie("VideoMode"));
if (isNaN(g_h264Status))
{
  g_h264Status = 1;
}
//g_h264Status = UpdateGSize(g_h264Status);
var DCL_1 = {
zoom : "1",
width  : "1280",
height : "800"
};
var DCL_2 = {
zoom : "1",
width  : "1280",
height : "800"
};
var DCL_3 = {
zoom : "1",
width  : "1280",
height : "800"
};
var DCL_4 = {
zoom : "1",
width  : "1280",
height : "800"
};

if (browser_IE)
{
  mpMode=GetCookieInt("MP_MODE", 1);
  if (isNaN(mpMode))
  {
    mpMode = 1;
  }
  mpMode = UpdateGSize(mpMode);
}
else
{
  number = 1;
  if(!g_isSupAJAX1 && !g_isSupAJAX2 && !g_isSupAJAX3)
    number = 1 ; 
  else
  {
    if(!g_isSupAJAX1)
      number = 2;
    else if(!g_isSupAJAX2)
      number = 3
    else if(!g_isSupAJAX3)
      number = 1 ;
  }
     
  mpMode=GetCookieInt("MP_MODE", number);
  SetCookie("MP_MODE", mpMode);
}
  //var savePath=GetCookieInt("SAVE_PATH","");
var savePath=GetCookieStr("SAVE_PATH","");

//MJPEG
var DCL_MP1_1 = {
  codec : V_JPEG,
  zoom : "1",
  width : "1280",
  height : "800"
};
//H.264
var DCL_MP1_2 = {
  codec : V_JPEG,
  zoom : "1",
  width : "1280",
  height : "1280"
};

//73XX
var DCL_MP1_3 = {
  codec : V_JPEG,
  zoom : "1",
  width : "1280",
  height : "1280"
};
var DCL_MP1_4 = {
  codec : V_JPEG,
  zoom : "1",
  width : "1280",
  height : "1280"
};
var DCL_MP1_5 = {
  codec : V_JPEG,
  zoom : "1",
  width : "1280",
  height : "1280"
};

var g_isMP73 = true;
//return the preference codec
//if not mulit profile will return 0
function GetCodec()
{
  var res = 0;
  if (g_isMP1 || g_isMP73)
  {
    res = eval("DCL_MP1_"+mpMode+".codec");
  }
  return res;                
};

//start 2010.12.27 modified
//var i18nStr = "English;\u7e41\u9ad4\u4e2d\u6587".split(";");
var i18nStr = "English;\u7b80\u4f53\u4e2d\u6587;\u7e41\u9ad4\u4e2d\u6587;\u010ce\u0161tina;Nederlands;Suomi;Fran\u00e7ais;Deutsch;Italiano;Polski;Portugu\u00eas;Espa\u00f1ol;Svenska;Magyar;Rom\u00e2n\u0103;Turkey".split(";");
//			   English;Chinese Simplified;      Chinese Traditional;     Czech;            Dutch;     Finnish;French;     German; Italian; Polish;Portuguese;    ;Spanish;    Swedish;Hungarian;Romanian;     Turkish
//--end 2010.12.27
var langList = '';
var langIDList;
var g_langID;
{
  var o='';
  var m='';
  var t=g_s_mui;
  var i=0;
  while (t > 0)
  {
    if (t%2 == 1)
    {
      o+=""+i18nStr[i]+";";
      m+=(i+";");
    }
    t = Math.floor(t/2);
    i++;
  }
  langList = o.substring(0,o.length-1);
  langIDList = m.substring(0,m.length-1).split(";");
  
  for (i=0;i<langIDList.length;i++)
  {
    if (langIDList[i]==g_mui)
    {
      g_langID = i;
      break;
    }
  }
}

var c_langSel = new Ctrl_Select("langSel",langList,g_langID,"","ChangeLanguage()");
var mySize = new SIZE(g_viewXSize,g_viewYSize);
function SIZE(w,h)
{
  this.w=parseInt(w,10);
  this.h=parseInt(h,10);
};

//=========CALL BACK========
function MY_CH_CHANGE()
{
};

function StartAX()
{

  if (IsVS())//Check is Video-Server
  {
	for (i=1;i<=g_maxCH;i++)
	{
	  StartActiveXEx(0,0,null,i,i,0);
	}	
  }
  else
  {
  //--start 2011.9.30 modified
    if(g_isSupportEPTZ == 1 || g_isSupportVisca==1)
		//StartActiveXEx(0,GetDLinkLightValue("listenButton"),null,null,null,5);
		StartActiveXEx(0,1,null,null,null,5);
	else if(g_isSupportEPTZ == 0)
	    //StartActiveXEx(0,GetDLinkLightValue("listenButton"),null,null,0,0);  
	    StartActiveXEx(0,1,null,null,0,0);  
  //--end 2011.9.30
  }
}

function MY_ONLOAD()
{
  //CallOnResize();
  //ZoomChange(); 
  mpMode=GetCookieInt("MP_MODE",1);
  mpMode=UpdateGSize(mpMode);
  //if(g_isSupportEPTZ == 1)
	//RunCropper();
  
  ChangeIndexWidthSize('profile'+mpMode);
  
  //alert(g_viewXSize+':'+g_viewYSize);
  SetLiveBoxStr();
  SetDLinkLightValue("gpOutputButton",g_entriggerout);

  clearTimeout(timerIDAlarm);
  clearTimeout(timerEPTZJoystick);
  clearTimeout(timerEPTZ);
  timerEPTZ = null;
  
  //This is read alarm status.
  timerIDAlarm = setTimeout("StartAlarmWorker()",g_AlarmCheckTime);
  if(g_isSupportEPTZ == 1)
  {
	//This is to read auto-pan or sequence status.
    timerEPTZ = setTimeout("SendEPTZWorker()",500);
	//This is to read Joystick status from ActiveX.
	timerEPTZJoystick = setTimeout("StartEPTZWorker()",1000);
  }else
  if(g_isSupportVisca==1)
  {
	//This is to read Joystick status from ActiveX.
	timerEPTZJoystick = setTimeout("StartEPTZWorker()",100);
  }
  SetAllLight();
  
  //This is read EPTZ coordinate.
  SendEPTZPoint(mpMode);
  
  //set main button status
  switch (mpMode)
  {
  case 1:
    SetDLinkLightValue("profile1",1);
    break;
  case 2:
    SetDLinkLightValue("profile2",1);
    break;
  case 3:
    SetDLinkLightValue("profile3",1);
    break;	
  case 4:
    SetDLinkLightValue("profile4",1);
    break;		
  default:
    SetDLinkLightValue("profile4",1);
    break;
  }
 
  if (browser_IE)
  {
    var obj = GE(AxID);
    if (obj != null)
    {
      try
      {
        obj.width = g_viewXSize;
        obj.height= g_viewYSize;
      }
	  catch (e){}
	}
  }
  else
  {
    //o = CheckBrowser();
	//if(o == 'Firefox' || o == 'Chrome')
	if(l_profileformat[mpMode-1]!="JPEG" || l_profilereviewer[mpMode-1]!="2048x1536")
	{
	  try
      {
        //obj.width = g_viewXSize;
        //obj.height= g_viewYSize;
		var obj = GE("QuickTimeLayer");
        obj.innerHTML= CreateQuickTime(mpMode, "UDP");
      }
	  catch (e){}
	}
	else
	{
	  var obj = GE("showdms_0");
	  if (obj != null)
	  {
	    obj.width = g_viewXSize;
		obj.height= g_viewYSize;
	  }
	}
  }
  
  if (browser_IE)
  {
    StartAX();
  }
  else
  {
    //o = CheckBrowser();
	//if(o == 'Firefox')
	if(l_profileformat[mpMode-1]!="JPEG" || l_profilereviewer[mpMode-1]!="2048x1536")
	{
		qt_counter = 0;
		setTimeout("CheckQuickTimeStatus()", 1000);
	}
	else
	{
	  imgFetcher.RunDms();
	}
  }
  	
  LoadAllImage();	
  g_lockLink = false;
  
  
};

var qt_counter = 0;
function CheckQuickTimeStatus()
{
	var qt = GE("qt_embed");
	if(qt!=null)
	{
	//--start 2011.10.6 added
		try{
			var status = qt.GetPluginStatus();
		}catch(e){
			//Quicktime plugin not support.
			ChangeToUseAjax();
		}
	//--end 2011.10.6 added	
	
		//alert("1: >"+status+"<");
		var msg = status.split(",");
		if(msg.length>1)
		{
			//alert("2: "+msg[1]);
			var obj = GE("QuickTimeLayer");
			if(QtProtocol=="UDP")
			{
				//alert("protocol: "+QtProtocol);
				obj.innerHTML= CreateQuickTime(mpMode, "TCP");
				setTimeout("CheckQuickTimeStatus()", 1000);
			}
			//--start 2011.10.6 added
			else
			{
				//change to use AJAX
				//alert("use ajax!");
				ChangeToUseAjax();
			}
			//--end 2011.10.6 added	
		}
		else
		if(status.indexOf("Waiting")!=-1)
		{
			//alert("Waiting");
			qt_counter++;
			if(qt_counter<10)
				setTimeout("CheckQuickTimeStatus()", 1000);
			else
			//	alert("timeout");
				ChangeToUseAjax();
		}
		else
		if(status.indexOf("Loading")!=-1)
		{
			//alert("3: "+status);
		}
		else
		if(status.indexOf("Playable")!=-1)
		{
			//alert("4: "+status);
		}
		else
		if(status.indexOf("Complete")!=-1)
		{
			//alert("5: "+status);
		}
	//--start 2011.10.6 added
		else
		if(status.indexOf("Error")!=-1)
		{
			//this is for iPhone
			ChangeToUseAjax();
		}
		else
		{
			//alert("6: unknow message!");
			qt_counter++;
			if(qt_counter<10)
				setTimeout("CheckQuickTimeStatus()", 1000);
			else
				ChangeToUseAjax();
		}
	//--end 2011.10.6 added	
	}
}

//--start 2011.10.7 added
//When Quicktime is not supprot, then switch to use ajax.
function ChangeToUseAjax()
{
	var livebox = GE("QuickTimeLayer");
	if(livebox!=null)
	{
		livebox.innerHTML = imgFetcher.GetDmsImgStr(g_viewXSize, g_viewYSize);
		var obj = GE("showdms_0");
		if (obj != null)
		{
			obj.width = g_viewXSize;
			obj.height= g_viewYSize;
		}
		imgFetcher.RunDms();
	}
}
//--end 2011.10.7

function LoadAllImage()
{
  if(g_PTZMode == 1 &&(!IsViewer()))
  {
	  GE("img_seq").src = "";
      GE("img_seq").src="seq-off_n.gif";
	  GE("img_stop").src = "";
      GE("img_stop").src="stop-off_n.gif";
	  GE("img_pan").src="";
      GE("img_pan").src="pan-off_n.gif";
      //GE("img_preset").src="goto-off_p.gif";
	  GE("globalview_img").src = "";
      if(g_isEPTZviewer)
        GE("globalview_img").src = "global-on_f.gif";
      else	
        GE("globalview_img").src="global-off_n.gif";
  }
  var i;
  for(i=0;i<g_supgioin;i++){
	GE("LIGHT_PIC_gpInputIcon"+(i+1)).src = "";
	if(g_isSupportVisca==1)
		GE("LIGHT_PIC_gpInputIcon"+(i+1)).src= "v_digital_input_off_"+(i+1)+".gif";
	else
		GE("LIGHT_PIC_gpInputIcon"+(i+1)).src= "digital_input_off_"+(i+1)+".gif";
  }
  GE("LIGHT_PIC_motionIcon").src="";
  GE("LIGHT_PIC_motionIcon").src="motion_notification_off.gif";
  GE("LIGHT_PIC_recordIcon").src="";
  GE("LIGHT_PIC_recordIcon").src="server_recorde_off.gif";
};
function StartAlarmWorker()
{
  SendHttp(c_iniUrl+"&getdlinkalarmstatus&getdlinksdstatus",true,SendOK);
};
var lastCode2 = -1;
var g_eventdostatus = 0;
var g_alwayGioOn = 0;
var g_iodostatus = 0;
function SendOK()
{
  if(g_SubmitHttp.readyState==4)
  {
    if(g_SubmitHttp.status==200)
    {
      try
      {
        var txt=g_SubmitHttp.responseText;
        var ix = txt.indexOf("OK getdlinkalarmstatus=");
        if(ix>=0)
        {
          var code = txt.substring(ix+23,ix+27);
          code = parseInt(code,16);
	      SetLight("gpInputIcon1",(((code & 0x00000001) != 0)?1:0));
	      SetLight("gpInputIcon2",(((code & 0x00000002) != 0)?1:0));
	      SetLight("motionIcon",(((code & 0x00000004) != 0)?1:0));
	      SetLight("recordIcon",(((code & 0x00000008) != 0)?1:0));
		  g_alwayGioOn = (((code & 0x00000010) != 0)?1:0);
		  g_iodostatus = (((code & 0x00000020) != 0)?1:0);
          if(g_isSupportVisca==1){
	        SetLight("gpInputIcon3",(((code & 0x00000040) != 0)?1:0));
	        SetLight("gpInputIcon4",(((code & 0x00000080) != 0)?1:0));
	        SetLight("gpInputIcon5",(((code & 0x00000100) != 0)?1:0));
	        SetLight("gpInputIcon6",(((code & 0x00000200) != 0)?1:0));
	        SetLight("gpInputIcon7",(((code & 0x00002000) != 0)?1:0));
	        SetLight("gpInputIcon8",(((code & 0x00004000) != 0)?1:0));
          }
		  
		  //alert(g_alwayGioOn);
		  //alert(g_iodostatus);
		  var status;
		  var v;
		  if(g_alwayGioOn==0)
		  {
		    status = 0;
			v=0;
		  }
		  else if( g_alwayGioOn==1 || g_iodostatus==1 )
		  {
		    status = 3;
			v=1;
		  }

		  ChangeDLinkLightStatus2("gpOutputButton", v ,status);
		  //g_alwayGioOn & g_iodostatus
		  ChangeIndexIOStatus( g_alwayGioOn , g_iodostatus );
        }

	    var iy = txt.indexOf("OK getdlinksdstatus=");
	    if(iy>=0)
	    {
          var code2 = txt.substring(iy+20,iy+23);
	      //alert(code2);

          code2 = parseInt(code2,16);
	      var sdinsert = ((code2 & 0x00000001) != 0);
          var sdlock = ((code2 & 0x00000002) != 0);
          var sdformat = ((code2 & 0x00000004) != 0);
	      var sdtesting = ((code2 & 0x00000008) != 0);
	  
	      if(lastCode2 != code2)
	      {
            var obj = GE("sdStatusStr");
            if(obj != null)
            {
              if(sdtesting)
			  {
				ShowSdBlock(false);
                obj.innerHTML = '&nbsp;';
			  }
	          else if(!sdinsert || !sdformat)
			  {
				ShowSdBlock(false);
                obj.innerHTML = GL("sd_no_inserted");
              //else if(!sdformat)
                //obj.innerHTML = GL("sd_format_failed")+'&nbsp;&nbsp;';
			  }
              else if(sdlock)
			  {
				ShowSdBlock(true);
                obj.innerHTML = GL("sd_write_protected");
			  }
              else
			  {
				ShowSdBlock(true);
                obj.innerHTML = GL("sd_ready");
			  }
  	          lastCode2 = code2;
	        }
	      }
	    }
      }
      catch (e){};
    }
    timerIDAlarm = setTimeout("StartAlarmWorker()",g_AlarmCheckTime);
  }
};

function ShowSdBlock(show)
{
	if(g_supportsdhide==0)
		return;
		
	var display = (show ? "block" : "none");
	var sd = GE("sdblock");
	if(sd!=null)
	{
		if(sd.style.display==display)
			return;

		sd.style.display=display;
	}
}

function SetAllLight()
{
  //SetDLinkLightValue("profile1",0);
  for(var id in DLinkLightAry)
  {
    tt = id.split("_");
    SetDLinkLightValue(tt[1],0);
  }
};
function ChangeIndexIOStatus(alwayGioOn,iodostatus)
{
  var obj = GE("iostatus");
  if( obj!=null && alwayGioOn==1)
  {
    obj.innerHTML=GL("user_trigger");
  }
  else if( obj!=null && iodostatus==1)
  {
	obj.innerHTML=GL("event_trigger");
  }
  else if(obj!=null && alwayGioOn==0 && iodostatus==0)
  {
    obj.innerHTML=GL("none");
  }
};
function MY_ONUNLOAD()
{
	var qt = GE("qt_embed");
	if(qt!=null)
	{
		qt.Stop();
	}
	
  clearTimeout( timerID );
  clearTimeout( timerID2 );
  clearTimeout( timerIDAlarm );
  clearTimeout( timerEPTZ);
  clearTimeout( timerIDTalk );
  //--2010.12.27 added
  StopGetEptzPostion();
  //--2010.12.27
};

function MY_ONRESIZE()
{
};

function Chk_Audio()
{
	//"<%audioinenable%>" = 0/1 = enable/disable
  return (g_isSupportAudio && ("<%audioinenable%>" == 0));
};

function ChangeLanguage()
{
//--start 2010.12.27 modified
  i = c_langSel.GV();
  mui = langIDList[i];
  SendHttp(c_iniUrl+"&mui="+mui,false,MuiOK);
//--end 2010.12.27
};

function MuiOK()
{
  if(g_SubmitHttp.readyState==4 && g_SubmitHttp.status==200)
  {
    try
    {
      var txt = g_SubmitHttp.responseText;
      var x = txt.indexOf("OK mui");
      if(x >= 0)
      {
        location.href="index.htm";
      }
    }
    catch (e){};
  }
};

function WriteLeftSideTable()
{
  var o='';
  o+='<table width="125" border="0" height="100%" >';
  o+='<tr><td id="sidenav_container" ><p align="center" >';
  if(g_supgioin == 1)
  {
    o+=AddLightBtn("gpInputIcon1",0,0,32,37,"digital_input_on_1.gif","digital_input_off_1.gif",null,GL("gpInputIcon_alt"));
	o+=AddLightBtn("motionIcon",0,0,42,38,"motion_notification_on.gif","motion_notification_off.gif",null,GL("motionIcon_alt"));
	o+=AddLightBtn("recordIcon",0,0,40,37,"server_recorde_on.gif","server_recorde_off.gif",null,GL("recordIcon_alt"));
  }
  else
  {
	if (g_isSupportVisca==1)
	{
		o+=AddLightBtn("gpInputIcon1",0,0,24,30,"v_digital_input_on_1.gif","v_digital_input_off_1.gif",null,GL("gpInputIcon_alt"));
		o+='&nbsp;';
		o+=AddLightBtn("gpInputIcon2",0,0,24,30,"v_digital_input_on_2.gif","v_digital_input_off_2.gif",null,GL("gpInputIcon_alt"));
		o+='&nbsp;';
		o+=AddLightBtn("gpInputIcon3",0,0,24,30,"v_digital_input_on_3.gif","v_digital_input_off_3.gif",null,GL("gpInputIcon_alt"));
		o+='&nbsp;';
		o+=AddLightBtn("gpInputIcon4",0,0,24,30,"v_digital_input_on_4.gif","v_digital_input_off_4.gif",null,GL("gpInputIcon_alt"));
		o+='<br>';
		o+=AddLightBtn("gpInputIcon5",0,0,24,30,"v_digital_input_on_5.gif","v_digital_input_off_5.gif",null,GL("gpInputIcon_alt"));
		o+='&nbsp;';
		o+=AddLightBtn("gpInputIcon6",0,0,24,30,"v_digital_input_on_6.gif","v_digital_input_off_6.gif",null,GL("gpInputIcon_alt"));
		o+='&nbsp;';
		o+=AddLightBtn("gpInputIcon7",0,0,24,30,"v_digital_input_on_7.gif","v_digital_input_off_7.gif",null,GL("gpInputIcon_alt"));
		o+='&nbsp;';
		o+=AddLightBtn("gpInputIcon8",0,0,24,30,"v_digital_input_on_8.gif","v_digital_input_off_8.gif",null,GL("gpInputIcon_alt"));
		o+='<br><br>';
	}
	else
	{
		o+=AddLightBtn("gpInputIcon1",0,0,32,37,"digital_input_on_1.gif","digital_input_off_1.gif",null,GL("gpInputIcon_alt"));
		//o+='<img title="'+GL("gpInputIcon_alt")+'" alt="'+GL("gpInputIcon_alt")+'" src="digital_input_off_1.gif" name="gpInputIcon1" id="gpInputIcon1" width="32" height="37">';
		o+='&nbsp;&nbsp;&nbsp;&nbsp;';
		o+=AddLightBtn("gpInputIcon2",0,0,32,37,"digital_input_on_2.gif","digital_input_off_2.gif",null,GL("gpInputIcon_alt"));
		//o+='<img title="'+GL("gpInputIcon_alt")+'" alt="'+GL("gpInputIcon_alt")+'" src="digital_input_off_2.gif" name="gpInputIcon2" id="gpInputIcon2" width="32" height="37">';
		o+='<br>';	
	}
    o+=AddLightBtn("motionIcon",0,0,42,38,"motion_notification_on.gif","motion_notification_off.gif",null,GL("motionIcon_alt"));
    //o+='<img title="'+GL("motionIcon_alt")+'" alt="'+GL("motionIcon_alt")+'" src="motion_notification_off.gif" name="motionIcon" id="motionIcon" width="42" height="38">';
    o+='&nbsp;&nbsp;';
    o+=AddLightBtn("recordIcon",0,0,40,37,"server_recorde_on.gif","server_recorde_off.gif",null,GL("recordIcon_alt"));
    //o+='<img title="'+GL("recordIcon_alt")+'" alt="'+GL("recordIcon_alt")+'" src="server_recorde_off.gif" name="recordIcon" id="recordIcon" width="40" height="37">';
  }
  o+='</p></td></tr>';
  o+='<tr height="60" vAlign="top" ><td><div id="sidenav"><div id="sidenavoff">'+GL("camera")+'</div><div><a href="checkout.htm">'+GL("logout")+'</a></div></div></td></tr>';
//--2011.1.27 modified
  //o+='<tr><td><font color="#ffffff">'+GL("sd_status")+':'+'<div id="sdStatusStr" align="right" >&nbsp;</div></font></td></tr>';
  o+='<tr><td id="sdblock" style="display:'+(g_supportsdhide==1?'none':'block')+';"><font color="#ffffff">'+GL("sd_status")+':'+'<div id="sdStatusStr" align="right" >&nbsp;</div></font></td></tr>';
//--2011.1.27
  
  o+='<tr><td><font color="#ffffff">'+GL("io_status")+':'+'<div id="iostatus" align="right" >&nbsp;</div></font></td></tr>';
  
  //to do ptz
  if(g_isShowPtzCtrl && !IsViewer())
  {
    o+=PtzCtrl();
  }
  
  o+='<tr vAlign="top" ><td><br><font color="#ffffff">'+GL("select_language")+'</font><br>';
  o+=c_langSel.html;
  o+='</td></tr></table>';
  DW(o);
};

function WriteLiveVideoTable()
{
  var o='';
  o+='<div id="maincontent" >'
  o+=GetDLinkOrangeBox(GL("live_video"),'<div id="boxstr"></div>');
  o+=GetDLinkBlackBox(GL("live_video"),GetLiveVideoBox());
  o+='</div>';
  DW(o);
};

function GetLiveVideoBox()
{
  var o='';
  o+='<div align="center" id="ctrlCtx" >';

  if (browser_IE)
  {
    if (IsVS())
	{
	  o+=GetTagAX1AndFixSize(1);
	}
	else
      o+=GetTagAX1AndFixSize();
  }	
  else
  {
	mpMode = UpdateGSize(mpMode);
    //v = CheckBrowser();
	//if(v == 'Firefox' || v == 'Chrome')
	if(l_profileformat[mpMode-1]!="JPEG" || l_profilereviewer[mpMode-1]!="2048x1536")
	{
	  o='<div id="QuickTimeLayer" align="center">';
		o+=CreateIdleQuickTime();
	  o+='</div>';
	}
	else
	{
	  o+=imgFetcher.GetDmsImgStr(g_viewXSize,g_viewYSize);
	}
    //
  }
  o+='</div><br>';


  o+='<table align="center"><tr>';
  o+='<td>';
  if (browser_IE)
  {
	if(g_isSupP1 && g_numProfile>=1)
		o+=GetDLinkLightBtn("profile1","profile1_on_f.gif","profile1_on_n.gif","profile1_on_p.gif","profile1_off_f.gif","profile1_off_n.gif","profile1_off_p.gif","ShowProfile1");
	if(g_isSupP2 && g_numProfile>=2)
		o+='&nbsp;'+GetDLinkLightBtn("profile2","profile2_on_f.gif","profile2_on_n.gif","profile2_on_p.gif","profile2_off_f.gif","profile2_off_n.gif","profile2_off_p.gif","ShowProfile2");
	if(g_isSupP3 && g_numProfile>=3)
		o+='&nbsp;'+GetDLinkLightBtn("profile3","profile3_on_f.gif","profile3_on_n.gif","profile3_on_p.gif","profile3_off_f.gif","profile3_off_n.gif","profile3_off_p.gif","ShowProfile3");
	if(g_isSupP4 && g_IsSupportProfile4 && g_numProfile>=4)
	  o+='&nbsp;'+GetDLinkLightBtn("profile4","profile4_on_f.gif","profile4_on_n.gif","profile4_on_p.gif","profile4_off_f.gif","profile4_off_n.gif","profile4_off_p.gif","ShowProfile4");
  }
  else
  {
    //if(g_isSupAJAX1)
	if(g_isSupP1 && g_numProfile>=1)
      o+=GetDLinkLightBtn("profile1","profile1_on_f.gif","profile1_on_n.gif","profile1_on_p.gif","profile1_off_f.gif","profile1_off_n.gif","profile1_off_p.gif","ShowProfile1");
    //if(g_isSupAJAX2)
	if(g_isSupP2 && g_numProfile>=2)
      o+='&nbsp;'+GetDLinkLightBtn("profile2","profile2_on_f.gif","profile2_on_n.gif","profile2_on_p.gif","profile2_off_f.gif","profile2_off_n.gif","profile2_off_p.gif","ShowProfile2");
    //if(g_isSupAJAX3)
	if(g_isSupP3 && g_numProfile>=3)
      o+='&nbsp;'+GetDLinkLightBtn("profile3","profile3_on_f.gif","profile3_on_n.gif","profile3_on_p.gif","profile3_off_f.gif","profile3_off_n.gif","profile3_off_p.gif","ShowProfile3");
  }  
  if (browser_IE)
  {
    //o+='<div align="center">';
    //o+=GetDLinkLightBtn("profile1","profile1_on_f.gif","profile1_on_n.gif","profile1_on_p.gif","profile1_off_f.gif","profile1_off_n.gif","profile1_off_p.gif","ShowProfile1");
    //o+='&nbsp;'+GetDLinkLightBtn("profile2","profile2_on_f.gif","profile2_on_n.gif","profile2_on_p.gif","profile2_off_f.gif","profile2_off_n.gif","profile2_off_p.gif","ShowProfile2");
    //if(g_isSupP3)
      //o+='&nbsp;'+GetDLinkLightBtn("profile3","profile3_on_f.gif","profile3_on_n.gif","profile3_on_p.gif","profile3_off_f.gif","profile3_off_n.gif","profile3_off_p.gif","ShowProfile3");
    //o+='&nbsp;'+GetDLinkLightBtn("profile4","profile4_on_f.gif","profile4_on_n.gif","profile4_on_p.gif","profile4_off_f.gif","profile4_off_n.gif","profile4_off_p.gif",null);
    o+='&nbsp;'+GetDLinkLightBtn("screenButton","full_screen_f.gif","full_screen_n.gif","full_screen_p.gif","full_screen_f.gif","full_screen_n.gif","full_screen_p.gif","ShowFullScreen");
    o+='&nbsp;&nbsp;&nbsp;&nbsp;';
    o+='&nbsp;'+GetDLinkLightBtn("snapshotButton","snapshot_f.gif","snapshot_n.gif","snapshot_p.gif","snapshot_f.gif","snapshot_n.gif","snapshot_p.gif","Snapshot");
    o+='&nbsp;'+GetDLinkLightBtn("recordButton","recorde_on_f.gif","recorde_on_n.gif","recorde_on_p.gif","recorde_off_f.gif","recorde_off_n.gif","recorde_off_p.gif","RecordAviSwitch");
    o+='&nbsp;'+GetDLinkLightBtn("pathButton","path_setting_f.gif","path_setting_n.gif","path_setting_p.gif","path_setting_f.gif","path_setting_n.gif","path_setting_p.gif","ShowSetPath");
    o+='&nbsp;'+GetDLinkLightBtn("listenButton","listen_on_f.gif","listen_on_n.gif","listen_on_p.gif","listen_off_f.gif","listen_off_n.gif","listen_off_p.gif","AudioSwitch");
    if(g_isSupportEPTZ != 1 && g_isSupportVisca==0)
	  o+='&nbsp;'+GetDLinkLightBtn("zoomButton","zoomin_f.gif","zoomin_n.gif","zoomin_p.gif","zoomin_f.gif","zoomin_n.gif","zoomin_p.gif","ZoomSwitch");
    
	if(!IsViewer())
    {
	//--start 2010.12.27 copy from appro
	  if(g_isSupportTwoWayAudio && g_isHttp)
	//--end 2010.12.27
		o+='&nbsp;'+GetDLinkLightBtn("streamoutButton","talk_on_f.gif","talk_on_n.gif","talk_on_p.gif","talk_off_f.gif","talk_off_n.gif","talk_off_p.gif","TwoWayAudio");
      o+='&nbsp;'+GetDLinkLightBtn("gpOutputButton","digital_output_on_f.gif","digital_output_on_n.gif","digital_output_on_p.gif","digital_output_off_f.gif","digital_output_off_n.gif","digital_output_off_p.gif","SetDigitalOutput");

      //o+='&nbsp;'+GetDLinkLightBtn("ledButton","led_on_f.gif","led_on_n.gif","led_on_p.gif","led_off_f.gif","led_off_n.gif","led_off_p.gif",null);
    }
    //o+='</div>';
  }
  else
  {
    o+='&nbsp;'+GetDLinkLightBtn("snapshotButton","snapshot_f.gif","snapshot_n.gif","snapshot_p.gif","snapshot_f.gif","snapshot_n.gif","snapshot_p.gif","Snapshot");
  }
  o+='</td>';
  
  if((g_isSupportEPTZ == 1 && !IsViewer()) || g_isSupportVisca==1)
  {
    o+='<td>&nbsp;</td>'
    o+='<td id="gotopreset">'+GL("persetgoto")+'&nbsp;'+presetselect.html+'</td>';
  }	
  o+='</tr></table>';
  
  return o;
};

var QtProtocol = "";
function CreateQuickTime(profile, protocol)
{
	QtProtocol = protocol;
	
  if(profile == 1)
    var RTSPName = g_RTSPName1;
  else if(profile == 2)
    var RTSPName = g_RTSPName2;
  else if(profile == 3)
    var RTSPName = g_RTSPName3;
  
  var isUpnp = false;
  var g_upnpport = parseInt(GV("<%upnpforwardingport%>",0));
  if(g_Port==g_upnpport)
	isUpnp = true;

  var o='';
//start 2010.11.04 added, if user input port number, quicktime will error.
  var host = location.host.split(":");
//end 2010.11.04
  //o+='<object width="0" height="0" codebase="http://www.apple.com/qtactivex/qtplugin.cab#version=6,0,2,0" classid="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" type="video/quicktime">';
  //o+='<param value="true" name="autoplay"/>';
  //o+='<param value="true" name="controller"/>';
  //o+='<param value="rtsp://'+location.host+':'+g_RTSPPort+'/'+RTSPName+'" name="qtsrc"/>';
  //o+='</object>';
  o+='<embed id="qt_embed" width="'+g_viewXSize+'" height="'+g_viewYSize+'" ';
  o+='controller="true" ';
  o+='autoplay="true" ';
  o+='src="qt.mov" ';
  //o+='qtsrcdontusebrowser="" ';
  if(protocol=="UDP")
	o+='qtsrc="rtsp://'+host[0]+':'+(isUpnp?g_upnpport:g_RTSPPort)+'/'+RTSPName+'" ';
  else
	o+='qtsrc="rtsp://'+host[0]+':'+(isUpnp?g_upnpport:g_Port)+'/'+RTSPName+'" ';
  o+='type="video/quicktime" ';
  o+='scale="ToFit" ';
  o+='>';
  //alert(o);
  return o;
};

function CreateIdleQuickTime()
{
  var o='';
  o+='<embed id="qt_embed" width="'+g_viewXSize+'" height="'+g_viewYSize+'" ';
  o+='controller="true" ';
  o+='autoplay="false" ';
  o+='src="qt.mov" ';
  o+='qtsrcdontusebrowser="" ';
  o+='bgcolor="black" ';
  o+='qtsrc="" ';
  o+='type="video/quicktime" ';
  o+='scale="ToFit"';
  o+='>';
  
  return o;
};
/*
var audioSupport="<%audioenable%>";
function AudioProcess()
{
  StartActiveXEx(0,GetLight("audioBtn"),GetCodec(),null,null,4,null,g_h264Status);
};
function RecProcess()
{
  var camDate = new Date();
  if (IsMpeg4())
  {
    var ctrl = GE(AxID);
    if (ctrl != null)
    {
      if (GetLight("recBtn") == 1)
      {
        var y,M,d,h,m,s;
        y=FixNum(camDate.getYear(),2);
        M=FixNum(camDate.getMonth()+1,2);
        d=FixNum(camDate.getDate(),2);
        h=FixNum(camDate.getHours(),2);
        m=FixNum(camDate.getMinutes(),2);
        s=FixNum(camDate.getSeconds(),2);
        var filename = "Clip_DCS-2130_"+y+M+d+h+m+s+".avi";  
        ctrl.RecordStart(filename);
      }
      else
      {
        ctrl.RecordStop();
      }
    }
  }
};
*/

function ChangeProfile(mode)
{
  var obj = GE(AxID);
  if (obj != null && GetDLinkLightValue("recordButton") == 1)
  {
	  //--2010.12.21 added
		g_TotalTime = REC_TIME;
		clearTimeout(timerRecordAvi);
	  //--
        obj.RecordAviStop();
  }
  
  if(mpMode == mode)
  {
    SetDLinkLightValue(("profile"+mpMode),1);
    return;
  }
  TurnOffAllProfileBtn();

  mpMode = UpdateGSize(mode);
  SetCookie("MP_MODE", mpMode);
  SetDLinkLightValue(("profile"+mpMode),1);
  //why?? why?? why??  different with appro???  appro is not use this turn on off.
  //isFirstOneshowCoords = true;
  
  StopGetEptzPostion();
  ChangeGlobalViewStatus(false);
  
  //if(g_isEPTZviewer)
  //  if(g_isSupportEPTZ == 1)
  //    g_Cropper.hide();
  
  if(g_isSupportVisca == 0)
    ChangePreset(mode);

//--start 2011.4.27, fix IE9 Live fault.
  location.reload();
  //MY_ONLOAD();
//--end 2011.4.27
};

function ChangePreset(mode)
{
  if(mode == 1)
    SendHttp("vb.htm?paratest=eptzpresetlistname1",false,GetPreset);
  else if(mode == 2)
    SendHttp("vb.htm?paratest=eptzpresetlistname2",false,GetPreset);
  else if(mode == 3)  
    SendHttp("vb.htm?paratest=eptzpresetlistname3",false,GetPreset);
};

function GetPreset()
{
  
  if (g_SubmitHttp.readyState==4)
  {
    if (g_SubmitHttp.status == 200)
    {
	//start 2010.11.4, End of the string are 0xa, but firefor will show Garbled
      var txt=g_SubmitHttp.responseText;
	  txt=txt.substring(0,txt.length-1).split("=");
	//end 2010.11.04
	//start modified--2010.11.17
	  var obj = GE("gotopreset");
	  if(obj != null)
	    obj.innerHTML = '<td id="gotopreset">'+GL("persetgoto")+'&nbsp;'+presetselect.rehtml(txt[1])+'</td></tr>';
	//end modified--2010.11.17
    }
  }
  
};
function SetLiveBoxStr()
{
  var o='';
  o+=GL("live_video_boxstr",{1:g_viewXSize,2:g_viewYSize});
  //if(g_sdLock == 1)
  //  o+='<br><font color="#ff0000" face="Arial" >'+GL("sd_card_lock")+'</font>';

  GE("boxstr").innerHTML = o;
  //return o;
};

function TurnOffAllProfileBtn()
{
  SetDLinkLightValue("profile1",0);
  SetDLinkLightValue("profile2",0);
  SetDLinkLightValue("profile3",0);
  SetDLinkLightValue("profile4",0);
}
function ShowProfile1()
{
  ChangeProfile(1);
  //SetDLinkLightValue("profile1",1);
};

function ShowProfile2()
{
  ChangeProfile(2);
  //SetDLinkLightValue("profile2",1);
};

function ShowProfile3()
{
  ChangeProfile(3);
  //SetDLinkLightValue("profile3",1);
};

function ShowProfile4()
{
  ChangeProfile(4);
  //SetDLinkLightValue("profile3",1);
};
//var p = window.createPopup();
function ShowFullScreen()
{
  window.open("fullscreen.htm",'fullscreen','fullscreen=1,directories=0, location=0, menubar=0, resizable=0, scrollbars=0, status=0, titlebar=0, toolbar=0, scrollbars="no"');
  //window.moveTo(0,0);
  //window.resizeTo(screen.availWidth,screen.availHeight);
  //setTimeout("RunFS()",500);
}
function RunFS()
{
  var obj = GE(AxID);
  if (obj != null)
  {
    obj.EnableFullScreen(1);
  }
}
function GetDateStr(pfx,tail)
{
  var y,M,d,h,m,s,ms;
  var myDate = new Date();
  if (browser_FireFox)
  {
    y=FixNum(myDate.getYear()+1900,4);
  }
  else
  {
    y=FixNum(myDate.getYear(),4);
  }
  M=FixNum(myDate.getMonth()+1,2);
  d=FixNum(myDate.getDate(),2);
  h=FixNum(myDate.getHours(),2);
  m=FixNum(myDate.getMinutes(),2);
  s=FixNum(myDate.getSeconds(),2);
  ms=parseInt((myDate.getTime() % 1000)/100);
  return (g_titleName+"_"+y+M+d+h+m+s+ms+"."+tail);
  //return (pfx + "_"+g_titleName+"_"+y+M+d+h+m+s+ms+"."+tail);
}
function CheckSavePath()
{
  if(savePath=="" || savePath==null)
  {
    alert(GL("err_storage_folder"));
    return false;
  }
  return true;
}

//function PopupPage(URL,id,x,y,w,h)
//{
  //var fullProps = "dialogLeft:"+x+"px;dialogTop:"+y+"px;dialogWidth:"+w+"px;dialogHeight:"+h+"px;";
  //fullProps+="resizable:no;scrollbars:no;status:no";
  //showModalDialog(URL,id,fullProps);
//};

function Snapshot()
{
  if (browser_IE)
  {
    if(CheckSavePath())
    {
      var obj = GE(AxID);
      if (obj != null)
      {
        //obj.SaveCurrentImageWithText(savePath+ GetDateStr("Snapshot_","jpg"), "", 0); //0x55 show time and date
        //obj.SaveCurrentImageWithText(savePath+ GetDateStr("","jpg"), "", 0); //0x55 show time and date
        obj.Snapshot(savePath+ GetDateStr("","jpg"));
      }
    }
  }
  else
  {
    PopupPage("/dms?nowprofileid="+mpMode+"&"+Math.random(),'Snapshot',0,0,g_viewXSize,g_viewYSize);
  }  
}

var l_profilerate = new Array("25","15","5","<%profile4rate%>");
var timerRecordAvi = null;
var REC_TIME = 30;
var g_TotalTime = REC_TIME;
var g_AviQuality = 100;
function RecordAviSwitch()
{
  if(CheckSavePath())
  {
    var obj = GE(AxID);
    if (obj != null)
    {
      if (GetDLinkLightValue("recordButton") == 1)
      {
	    //mpMode = GetCookieInt("MP_MODE",1);
		//if(mpMode == 1) 
		  //g_GetProFileFPS = "getprofile1fps";
		//if(mpMode == 2) 
          //g_GetProFileFPS = "getprofile2fps";
		//if(mpMode == 3) 
		  //g_GetProFileFPS = "getprofile3fps";
		  
		//SendHttp(c_iniUrl+"&"+g_GetProFileFPS,true,GetFPS);
		savePath = GetCookieStr("SAVE_PATH","");
		//alert(g_GetFPS);
        //obj.RecordAviStart(savePath+ GetDateStr("","avi"),parseInt(g_AviQuality),parseInt(g_GetFPS));
        obj.RecordAviStart(savePath+ GetDateStr("","avi"),parseInt(g_AviQuality),parseInt(l_profilerate[mpMode-1]));
		
		//--2010.12.21 added
		timerRecordAvi = setTimeout("CheckRecordAviStart()",1000); 
		//--
      }
      else
      {
	  //--2010.12.21 added
		g_TotalTime = REC_TIME;
		clearTimeout(timerRecordAvi);
	  //--
        obj.RecordAviStop();
      }
    }
  }
  else
  {
    SetDLinkLightValue("recordButton",0);
  }
}

//--2010.12.21 added, copy from appro
function CheckRecordAviStart()
{
  var obj = GE(AxID);
  if (obj != null)
  {
    g_TotalTime--;

//start modified--2010.11.23
	if(parseInt(g_TotalTime) >= 0 && obj.GetAviRecordStatus()==1)
	//if(parseInt(g_TotalTime) >= 0)
//end modified--2010.11.23
    {
      timerRecordAvi = setTimeout("CheckRecordAviStart()",1000); 
    }
    else
	{
	  g_TotalTime = REC_TIME;
	  obj.RecordAviStop();
	  obj.RecordAviStart(savePath+ GetDateStr("","avi"),parseInt(g_AviQuality),parseInt(l_profilerate[mpMode-1]));
	  timerRecordAvi = setTimeout("CheckRecordAviStart()",1000);
	}
  }
};
//--

function GetFPS()
{
if(g_SubmitHttp.readyState==4)
  {
    if(g_SubmitHttp.status==200)
    {
      try
      {
        var txt=g_SubmitHttp.responseText;
        var ix = txt.split("OK "+g_GetProFileFPS+"=");
		//alert(ix);
		//alert(ix.length);
        if(ix.length>=0)
        {
          g_GetFPS = ix[1];		  
        }
		else
		{
		  g_GetFPS = 15;
		}
      }
      catch (e){};
    }
  }
}

function ShowSetPath()
{
  var obj = GE(AxID);
  if (obj != null)
  {
    savePath = obj.BrowserFolder(savePath);
    SetCookie("SAVE_PATH",savePath);
  }
};

function AudioSwitch()
{
  var auOn = 0;
  if ( Chk_Audio() )
  {
    auOn = !GetDLinkLightValue("listenButton");
  	if(auOn==0)
	{
		var obj = GE(AxID);
		if(obj!=null)
			obj.AudioPlayerEnable = 1;
		DLinkLightSwitch("listenButton");
	}
	else if(auOn==1)
	{
		var obj = GE(AxID);
		if(obj!=null)
			obj.AudioPlayerEnable = 0;
		DLinkLightSwitch("listenButton");
	}
  }
/*
 //ben 20100706////////////////
  var auon = "<%audioinenable%>";
  //hard code,if litsen audio in off, don't light up button
  //notic:audioinenable = 1 -> "audio in off" checkbox is selected, means off audio
  //
  if(auon == 1){  
    SetDLinkLightValue("listenButton",0);
	return;
  }
  //end of ben 20100706////////////////	

  StartAX();
*/
};

function ZoomSwitch()
{
  var obj = GE(AxID);
  if (obj != null)
  {
    obj.PreviewZoom();
  }
};
var timerIDTalk = null;
var g_TalkTime = 0;
function TwoWayAudio()
{
   //ben 20100706////////////////
  var auout = "<%audiooutenable%>";
  //alert(auout);
  //hard code,if Audio out off, don't light up button
  //notic:audiooutenable = 1 -> "audio out off" checkbox is selected, means off talk
  //
  if(auout == 1){  
    SetDLinkLightValue("streamoutButton",0);
	return;
  }
  else
  {
  //end of ben 20100706////////////////	
    var obj = GE(AxID);
    if (obj == null)
    {
      SetDLinkLightValue("streamoutButton",0);
      return;
    }

    if (GetDLinkLightValue("streamoutButton") == 1)
    {
	  //start 2010.11.04 added, if user input port number, activex will error.
	  host = location.host.split(":");
      g_TalkTime = obj.StartTwoWayAudio(host[0],0,0,3);
	  //end 2010.11.04
      //alert(g_TalkTime);
      if(g_TalkTime > 0)
      {
        timerIDTalk = setTimeout('StopTwoWayAudio()',parseInt(g_TalkTime)*1000);//2011.7.11 modified
      } 
      else
      {
        SetDLinkLightValue("streamoutButton",0);
      }
    }
    else
    {
      obj.StopTwoWayAudio();
      clearTimeout( timerIDTalk );
    }
    //alert("To control 2 way Audio.");
  }	
};

//--start 2011.7.11 added
function StopTwoWayAudio()
{
	var obj = GE(AxID);
	if (obj != null)
	{
		obj.StopTwoWayAudio();
		SetDLinkLightValue("streamoutButton",0);
		clearTimeout( timerIDTalk );
	}
}
//--end 2011.7.11

//function Chk_TwoWayAudio()
//{
//  return ("<%audiooutenable%>" == 1);
//};

function SetDigitalOutput()
{
  //var o = c_iniUrl+"&allgiooutenable="+GetDLinkLightValue("gpOutputButton");
  if(g_iodostatus)
  {
    if(g_alwayGioOn)
      var o = c_iniUrl+"&giooutalwayson=1:0";
	else
	  var o = c_iniUrl+"&giooutreset=1:1"
  }
  else
  {
    var o = c_iniUrl+"&giooutalwayson=1:"+GetDLinkLightValue("gpOutputButton");
  
  }
  SendHttp(o,false);
};

var SendEPTZStatusHttp = null;
function SendEPTZWorker()
{
  SendEPTZStatusHttp = null;
  SendEPTZStatusHttp = InitXHttp();
  SendEPTZStatusHttp.onreadystatechange = GetEPTZStatus;
  try
  {
	SendEPTZStatusHttp.open("GET", "/vb.htm?geteptzstatus", true);
    SendEPTZStatusHttp.setRequestHeader("If-Modified-Since","0");
    SendEPTZStatusHttp.send(null);
  }catch(e){};
  //g_httpOK = true;
};

function GetEPTZStatus()
{
  if (SendEPTZStatusHttp.readyState==4)
  {
    if (SendEPTZStatusHttp.status != 200)
    {
      //WS(GL("fail_"));
    }
    else
    {
	  var list = SendEPTZStatusHttp.responseText.split('=');
	  if(list.length==2){
	    var pan = list[1].substr(0,1);
	    var preset = list[1].substr(1,1);
        CheckEPTZLight(pan,preset);
	  }
	  timerEPTZ = setTimeout("SendEPTZWorker()",1000);
	}
  }	
};

function CheckEPTZLight(pan,preset)
{
//start added--2010.11.17
  var panobj = GE("img_pan");
  var seqobj = GE("img_seq");
  if(panobj==null || seqobj==null)
	return;
//end added--2010.11.17
  
//start modified--2010.11.17
  if(mpMode == 1)
  {
    if( ((pan&0x1)!=0)?1:0 ){
	  panobj.src = "/pan-on_n.gif";
	  AutoPanOn = true;//--2010.12.21 added
	}else{
	  panobj.src = "/pan-off_n.gif";  
	  AutoPanOn = false;//--2010.12.21 added
	}  
	if( ((preset&0x1)!=0)?1:0 ){
	  seqobj.src = "/seq-on_n.gif";
	  SequenceOn = true;//--2010.12.21 added
	}else{  
	  seqobj.src = "/seq-off_n.gif"; 
	  SequenceOn = false;	  //--2010.12.21 added
	}
  }
  else if(mpMode == 2)
  {
    if( ((pan&0x2)!=0)?1:0 ){
	  panobj.src = "/pan-on_n.gif";
	  AutoPanOn = true;//--2010.12.21 added
	}else{  
	  panobj.src = "/pan-off_n.gif";
	  AutoPanOn = false;//--2010.12.21 added
	} 
	if( ((preset&0x2)!=0)?1:0 ){
	  seqobj.src = "/seq-on_n.gif";
	  SequenceOn = true;//--2010.12.21 added
	}else{  
	  seqobj.src = "/seq-off_n.gif"; 
	  SequenceOn = false;		  //--2010.12.21 added
	}	  
  }
  else if(mpMode == 3)
  {
    if( ((pan&0x4)!=0)?1:0 ){
	  panobj.src = "/pan-on_n.gif";
	  AutoPanOn = true;//--2010.12.21 added
	}else{  
	  panobj.src = "/pan-off_n.gif";
	  AutoPanOn = false;//--2010.12.21 added
	}  
	if( ((preset&0x4)!=0)?1:0 ){
	  seqobj.src = "/seq-on_n.gif";
	  SequenceOn = true;//--2010.12.21 added
	}else{  
	  seqobj.src = "/seq-off_n.gif"; 
	  SequenceOn = false;	//--2010.12.21 added
	}
  }
//end modified--2010.11.17
  
  //--2010.12.27 added
  if(AutoPanOn || SequenceOn)
  {
	if(g_isEPTZviewer)
	{
		if(EptzPositonWorking && EptzPostionProfile!=mpMode)
			StopGetEptzPostion();
			
		if(!EptzPositonWorking)
			StartGetEptzPostion();
	}
	else
	{
		if(EptzPositonWorking)
			StopGetEptzPostion();
	}
  }
  else
  {
	if(EptzPositonWorking)
		StopGetEptzPostion();
  }
  //--end 2010.12.27
  
};

/*
var JOYSTICK_MIN = 0;
var JOYSTICK_MID = 32767;
var JOYSTICK_MAX = 65535; 
var JOYSTICK_FIXNUM = 3000;

function StartEPTZWorker()
{
  if(browser_IE)
  {
    var obj = GE(AxID);
	if(obj!=null)
	{
	  if(obj.GetIsJoystick() == 1)
	  {
	    var x1 = parseInt( obj.GetJoystickX() );
	    var y1 = parseInt( obj.GetJoystickY() );
	  }
	  else
      {
	  
	  }
	  timerEPTZJoystick = setTimeout("StartEPTZWorker()",50);
	}
  }
  else
  {
  
  }
};
*/

var SendViscaStatusHttp = null;
//var SendViscaStep = 0;
function StartViscaWorker()
{
  //"&getviscaalarmout&getzoomratio";
  //SendViscaStep = 0;
  SendViscaWorker("/cgi-bin/visca.cgi?getzoom");
  //SendViscaWorker("/vb.htm?getzoomratio");
};
function SendViscaWorker(url)
{
  SendViscaStatusHttp = null;
  SendViscaStatusHttp = InitXHttp();
  SendViscaStatusHttp.onreadystatechange = GetViscaStatus;
  try
  {
	//SendViscaStatusHttp.open("GET", "/cgi-bin/visca.cgi?getzoom", false);
	//SendViscaStatusHttp.open("GET", "/vb.htm?getzoomratio", false);
	SendViscaStatusHttp.open("GET", url, true);
    SendViscaStatusHttp.setRequestHeader("If-Modified-Since","0");
    SendViscaStatusHttp.send(null);
  }catch(e){};
};
function GetViscaStatus()
{
  if (SendViscaStatusHttp.readyState==4)
  {
    if (SendViscaStatusHttp.status != 200)
    {
      //WS(GL("fail_"));
    }
    else
    {
		//if(SendViscaStep==0){
		//	SendViscaStep = 1;
		//	SendViscaWorker("/vb.htm?getzoomratio");
		//	return;
		//}
		
        //var txt = SendViscaStatusHttp.responseText;
        /*var iz = txt.indexOf("OK getviscaalarmout=");
        if(iz>=0)
        {
          var code = txt.substring(iz+20,iz+21);
          g_alwayGioOn = parseInt(code);
          g_iodostatus = 0;
		  var status;
		  var v;
		  if(g_alwayGioOn==0)
		  {
		    status = 0;
			v=0;
		  }
		  else
		  {
		    status = 3;
			v=1;
		  }

		  //visca's output status use api=getdlinksdstatus
		  ChangeDLinkLightStatus2("gpOutputButton", v ,status);
		  //g_alwayGioOn & g_iodostatus
		  ChangeIndexIOStatus( g_alwayGioOn , g_iodostatus );
        }*/
		
        /*var iw = txt.indexOf("OK getzoomratio=");
        if(iw>=0){
        	var code = txt.substring(iw+16,iw+18);
			if(code=="1X") code = "";
			
        	var ax = GE(AxID);
			if (ax != null){
			
				try	{
					ax.Information = code;
				}
				catch (e){}
			}
		}*/
		/*var list = txt.split("=");
		var zoom = list[1];
		if(zoom=="1X")
			zoom = "";
		
       	var ax = GE(AxID);
		if (ax != null){
			
			try	{
				ax.Information = zoom;
			}
			catch (e){}
		}*/
        //
		
		//if(SendViscaStep==0){
		//	SendViscaStep = 1;
		//	SendViscaWorker(c_iniUrl+"&getzoomratio");
		//}else
		//if(g_ViscaZoomEn)
		//	timerVisca = setTimeout("StartViscaWorker()", g_ViscaInterval);
	}
  }	
};