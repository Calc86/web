function GV(v,df)
{
  return (v.indexOf("<%") > -1 || v.indexOf("<@") > -1) ? df : v;
}

var AxVer="2,0,0,51";			//ActiveX Version.
var webPageVersion="D-Link1.1";	//HTML version.
var webPageSubVersion="02";		//HTML sub version, the "b" is beta version.
var DigSignName="D-Link";		//The name of the digital signature

var g_isSupMpeg4=GV("1",1);
var g_videoFormat=GV("1",0);
var g_isPal=(GV("1",1) == "1");
var g_deviceName=GV("LAN Camera","VideoServer");
var g_defaultStorage=GV("<%defaultstorage%>",1); // 0: cf, 1:sd 255:no card
//var g_SDInsert=parseInt(GV("0",0));
var g_CFInsert=GV("0",0);
var g_cardGetLink=GV("sdget.htm","sdget.htm");
var g_brandUrl=GV("http://www.dlink.com.tw",null);
var g_titleName=GV("DCS-2130","IPCAM");
// 20090202 Netpool Add for D-Link Style
var g_softwareversion=GV("1.01.ftpretry v14","1.00"); ;
var g_fullversion=GV("1.01.03.ftpretry v14","1.00.00"); ;
//var g_brandName=GV("D-Link".toLowerCase(),"nobrand");
var g_brandName="nobrand";
var g_supportTStamp=GV("1",0);
var g_ZoomSize = 0;
var g_p1XSize=parseInt(GV("1280",320));
var g_p1YSize=parseInt(GV("800",240));
var g_p2XSize=parseInt(GV("1280",320));
var g_p2YSize=parseInt(GV("800",240));
var g_p3XSize=parseInt(GV("640",320));
var g_p3YSize=parseInt(GV("360",240));
var g_p4XSize=parseInt(GV("<%profile4xsize%>",320));
var g_p4YSize=parseInt(GV("<%profile4ysize%>",240));
var g_isSupP1=(parseInt(GV("1",0)) >= 1);
var g_isSupP2=(parseInt(GV("1",0)) >= 1);
var g_isSupP3=(parseInt(GV("1",0)) >= 1);
var g_isSupP4=(parseInt(GV("0",0)) >= 1);
var g_isSupAJAX1=(parseInt(GV("1",0)) >= 1);
var g_isSupAJAX2=(parseInt(GV("1",0)) >= 1);
var g_isSupAJAX3=(parseInt(GV("1",0)) >= 1);
var g_RTSPName1 = GV("live1.sdp","live1.sdp");
var g_RTSPName2 = GV("live2.sdp","live2.sdp");
var g_RTSPName3 = GV("live3.sdp","live3.sdp");
var g_RTSPPort = GV("554",554);
var g_socketAuthority=parseInt(GV("2",3));  //0:admin,1:operator,2:viewer
var g_isAuthorityChange=(parseInt(GV("1",0)) == 1);
var g_isSupMotion=(parseInt(GV("1",0)) >= 1);
var g_isSupWireless=(parseInt(GV("0",0)) == 1);
var g_serviceFtpClient=parseInt(GV("1",0));
var g_serviceSmtpClient=parseInt(GV("1",0));
var g_servicePPPoE=parseInt(GV("1",0));
var g_serviceSNTPClient=parseInt(GV("1",0));
var g_serviceDDNSClient=parseInt(GV("1",0));
//20081212 chirun add virtualserver
var g_serviceVirtualSClient=parseInt(GV("1",0));

var g_s_maskarea=GV("1",0);
var g_machineCode="2021";
var g_maxCH=GV("1",1);
var g_isSupportRS485 = ("0"==1);
var g_isSupportRS232 = ("0"==1);
var g_useActiveX=GV("0",1);
var g_ptzID=GV("0",1);
var g_s_mui=GV("2497",1);
var g_mui=GV("0",-1);
var g_isSupportSeq=("0"==1);
var g_isSupportMQ=(parseInt("-1") >= 0);
var g_quadMode=GV("-1",1); //default is 1:quad
//var g_isSupportSmtpAuth=(g_machineCode!="1290");
var g_isSupportSmtpAuth=true;
var g_isSupportIPFilter=("1"==1);
var g_oemFlag0=(parseInt(GV("15",0)));
var g_s_daynight=(parseInt(GV("0",0)) == 1);//ICR
var s_irled = parseInt(GV("<%supportirled%>",0));//IR
var s_power = parseInt(GV("<%supportdcpower%>",0));//power
//start--2010.11.15
var g_isIpcam = (parseInt(GV("0",0))==0);//0/1=true/false=IpCam/VideoServer
//end--2010.11.15
var g_is264=(parseInt(GV("0",0)) == 1);
var g_isSelMpeg4=(parseInt(GV("0",0)) == 1);
var g_isSupportD2N=false;
var g_isSupportN2D=false;
var g_isSupportAudio=(parseInt(GV("<%supportaudio%>",0)) >= 1);
var g_isSupportTwoWayAudio=(parseInt(GV("<%supporttwowayaudio%>",0)) >= 1);//2010.12.27 copy from appro
var g_isSupportptzpage=(parseInt(GV("1",1)) == 1);
//var g_isShowPtzCtrl=((g_machineCode=="1670") && (g_socketAuthority < 2));
var g_isShowPtzCtrl=false;
//20090206 chirun add for 7313
var g_IMGStatus=1;
// 20090210 Netpool add to fix Img_htm
var g_stream1name = GV("Profile-1(1280x800)","");
var g_stream2name = GV("Profile-2(1280x800)","");
var g_stream3name = GV("Profile-3(640x360)","");
var g_stream4name = GV("<%stream4name%>","");

//Multi profile Case 1 --> for 7228,7227 Supprot H.264 and MJPEG
var g_isMP1 = (g_machineCode==1671 || g_machineCode==1771);
//Multi Profile for 73xx
var g_isMP73 = (g_machineCode==2001 || g_machineCode==2100 || g_machineCode==1679 || g_machineCode==1677 || g_machineCode==2000);
var g_enpantilt = (parseInt(GV("<%rs485enable%>",0)) == 1);
var g_supgioin = parseInt(GV("1",2));
var g_numAllProfile=parseInt(GV("3",4));//2011.3.22 added
var g_numProfile = parseInt(GV("2",3));
var g_IsSupportProfile4 = (parseInt(GV("<%getprofile4uistatus%>",0)) == 1);
var mpMode = 1;
var g_motionBlock;
var g_MotionAmount = 3;
var g_audioType = GV("G.726","G.726");
var g_viewXSize;
var g_viewYSize;
var g_GetFPS = 15;
var g_GetProFileFPS = "getprofile1fps";
var g_isRunMotion = parseInt(GV("<%motionwizardconfig%>",1));
var g_modelname=GV("DCS-2130","DCS-3710");
// 0 is non , 1 is for 355
var g_profileCheckMode = GV("<%profilecheckmode%>",0);
var g_isSupportEPTZ = parseInt(GV("<%supporteptz%>",1));
var g_isShowRs485 = parseInt(GV("<%rs485enable%>",0));
var g_isSupportVisca = parseInt(GV("<%supportvisca%>",0));
var g_isShowPtzCtrl= ((g_isShowRs485 || g_isSupportVisca || g_isSupportEPTZ) == 1);
var g_EPTZ1 = "<%profile1eptzcoordinate%>";
var g_EPTZ2 = "<%profile2eptzcoordinate%>";
var g_EPTZ3 = "<%profile3eptzcoordinate%>";
var g_EPTZ1x1 = parseInt(g_EPTZ1.substr(0,4)*1);
var g_EPTZ1y1 = parseInt(g_EPTZ1.substr(4,4)*1);
var g_EPTZ2x1 = parseInt(g_EPTZ2.substr(0,4)*1);
var g_EPTZ2y1 = parseInt(g_EPTZ2.substr(4,4)*1);
var g_EPTZ3x1 = parseInt(g_EPTZ3.substr(0,4)*1);
var g_EPTZ3y1 = parseInt(g_EPTZ3.substr(4,4)*1);
//--start 2011.4.18 modified
//var g_SupportJoystick = (g_isSupportVisca==1) ? 1 : 0;
var g_SupportJoystick = 1;
//--end 2011.4.18

var l_profileresolution = new Array("1280x800","1280x800","640x360","<%profile4resolution%>");
var l_profilereviewer = new Array("<%profile1viewres%>","<%profile2viewres%>","<%profile3viewres%>");
//--start 2011.4.7 add for aspect ratio
var g_globalWidth = 120;
var g_globalHeight = 90;
var g_baseX = 320;
var g_baseY = 240;
var g_GlobalRateX = 0;
var g_GlobalRateY = 0;
var g_ViewerWidth = 320;
var g_ViewerHeight = 240;
//--end 2011.4.7
// 0 is RS485 , 1 is EPTZ, 2 is Rs485&EPTZ, 3 is visca&eptz
var g_PTZMode = 0;
var g_isSupportFan = (GV("0",0) == 1);
var g_EPTZmouse = new Object;
g_EPTZmouse.page = {x:0,y:0};
var g_KeepFocusWindow = 1;
var g_isSupportAF = parseInt(GV("0",1));
var g_EPTZmouseX;
var g_EPTZmouseY;
var g_EPTZWidth = null;
var g_EPTZHeight = null;
var g_isEPTZviewer =false;
var g_ZoomPosition = parseInt(GV("600",0));
var g_MaxZoomStep = parseInt(GV("600",0));
var g_ResolutionX;
var g_ResolutionY;
var g_tempx1 = null;
var g_tempy1 = null;
var g_SelectIndex = 0;
var timerChangeImage = null;
var timerMoveUvumiWin = null;
var FocusbusyTimer = null;
var g_IsPan1 = 0;
var g_IsPan2 = 0;
var g_IsPan3 = 0;
var g_IsPreset1 = 0;
var g_IsPreset2 = 0;
var g_IsPreset3 = 0;
//--start 2010.12.27 added for QoS
var g_supportqos = parseInt(GV("0", 0));
var g_supportcos = parseInt(GV("0", 0));
var g_supportbwc = parseInt(GV("1", 1));
//--end 2010.12.27
//--start 2010.12.30 added for ddns
var DDNS_TIMEOUT_MIN = 24;
var DDNS_TIMEOUT_MAX = 999;
//--end 2010.12.30
//--start 2011.1.14 add for wifi
var g_supportWifi = parseInt(GV("<%supportwifi%>", 0));
//--end 2011.1.14
//--start 2011.1.27 add for visca 6815
var g_supportsdhide = parseInt(GV("0",0));
//--end 2011.1.27
//--start 2011.2.17 add for visca 6815
var g_suptvout = parseInt(GV("0",1));//visca=0
var g_suptLed  = parseInt(GV("1",1));	//visca=0
//--end 2011.2.17
//--start 2011.6.21 add for test
var g_audioAmplifyRatio = parseFloat(GV("<%audioamplifyratio%>", 1));
//--end 2011.6.21
//--start 2011.10.19 add for ipv6
var g_host = location.host.split(":")[0];	//Initial IPv6 in common.js.
var g_Port = location.port;
var g_supportIPv6 = parseInt(GV("<%supportipv6%>", 0))==1;	//debug is 1.
var g_isIPv6 = false;
//--end 2011.10.19
//--start 2011.10.19 add for multicast
var g_isSupportMulticast = parseInt(GV("<%supportmulticast%>",0))!=0;	//multicast
var g_pf1mcen = parseInt(GV("<%profile1_mc_enable%>",0));
var g_pf2mcen = parseInt(GV("<%profile2_mc_enable%>",0));
var g_pf3mcen = parseInt(GV("<%profile3_mc_enable%>",0));
var g_StreamType = 3;	//stream type: 0=UDP unincast, 1=UDP multicast, 2=TCP, 3=HTTP(default)
//--end 2011.10.19

function loadJS(url)
{
	document.write('<sc'+'ript language="javascript" type="text/javascript" src="' + url + '"></script>');
}