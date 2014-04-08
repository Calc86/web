//Note: The page that import this page, must fill up the follow variable, remember, do not use "var" to define.
//var TRANS_DATA_LEN = 0;  //The length of transimt command.
//var HEADER_BYTE = 0x00;  //the first fixed byte value.
var PTZ_PROD_NAME = "";  //PTZ brand, it will effect use which check sum function.
var CMD_STOP = null; //define the stop PTZ command.
var CMD_STOPS = null; //define the stop PTZ command. List, can sent multi.
var PTZ_MAX_DEVICE_ID = 255; // Max ID value.
var CMD_ZOOM_IN       = null;
var CMD_ZOOM_OUT      = null;
var CMD_TILT_UP       = null;
var CMD_TILT_DOWN     = null;
var CMD_PAN_LEFT      = null;
var CMD_PAN_RIGHT     = null;
var CMD_ZERO_PAN      = null;
var CMD_STEP_DOWN     = null;
var CMD_STEP_RIGHT    = null;
var CMD_FOCUS_NEAR    = null;
var CMD_STEP_LEFT     = null;
var CMD_FOCUS_FAR     = null;
var CMD_STEP_UP       = null;
var CMD_APERTURE_SUB  = null;
var CMD_APERTURE_ADD  = null;

var PTZ_MAX_PRESET_NUMBER = 20;
/*
var CMD_SET_1         = null;
var CMD_SET_2         = null;
var CMD_SET_3         = null;
var CMD_SET_4         = null;
var CMD_SET_5         = null;
var CMD_SET_6         = null;
var CMD_SET_7         = null;
var CMD_SET_8         = null;
var CMD_SET_9         = null;
var CMD_SET_10        = null;
*/
for (var i=0;i<PTZ_MAX_PRESET_NUMBER;i++)
{
  eval("var CMD_SET_"+(i+1)+" = null;");
}
/*
var CMD_GOTO_1        = null;
var CMD_GOTO_2        = null;
var CMD_GOTO_3        = null;
var CMD_GOTO_4        = null;
var CMD_GOTO_5        = null;
var CMD_GOTO_6        = null;
var CMD_GOTO_7        = null;
var CMD_GOTO_8        = null;
var CMD_GOTO_9        = null;
var CMD_GOTO_10       = null;
*/
for (var i=0;i<PTZ_MAX_PRESET_NUMBER;i++)
{
  eval("var CMD_GOTO_"+(i+1)+" = null;");
}

var CMD_MENU          = null;
var CMD_PRESET        = null;
var CMD_PRESET_GO     = null;
var CMD_PRESET_X      = null;
var CMD_AUTO_SCAN     = null;
var CMD_AUTO_SCAN_X   = null;
var CMD_PAT_START     = null;
var CMD_PAT_STOP      = null;
var CMD_PAT_RUN       = null;
var CMD_HOME          = null;
var CMD_UP_LEFT       = null;
var CMD_UP_RIGHT      = null;
var CMD_DOWN_LEFT     = null;
var CMD_DOWN_RIGHT    = null;

//--start add for visca
var CMD_PANTILT_STOP  = null;

var CMD_AUTO_PAN	  = null;
var CMD_AUTO_SEQUENCE = null;
var CMD_AUTO_CRUISE	  = null;
var CMD_AUTO_STOP	  = null;

var CMD_FOCUS_AUTO	  = null;
var CMD_FOCUS_MANUAL  = null;
var CMD_FOCUS_STOP	  = null;

var CMD_DZOOM_ON	= null;
var CMD_DZOOM_OFF	= null;
var CMD_BACKLIGHT_ON	= null;
var CMD_BACKLIGHT_OFF	= null;
var CMD_PICTURE_FLIP_ON		= null;
var CMD_PICTURE_FLIP_OFF	= null;
var CMD_FREEZE_ON	= null;
var CMD_FREEZE_OFF	= null;
var CMD_2D_NOISE_REDUCTION_ON = null;
var CMD_2D_NOISE_REDUCTION_OFF = null;
var CMD_3D_NOISE_REDUCTION_ON = null;
var CMD_3D_NOISE_REDUCTION_OFF = null;
var CMD_ANGLEADJUST_MIN_ANGLE  = null;
var CMD_ANGLEADJUST_MAX_ANGLE  = null;
var CMD_MASK_DISPLAY_ON = null;
var CMD_MASK_DISPLAY_OFF = null;
var CMD_MASK_COLOR = null;
var CMD_MASK_SET = null;
var CMD_MASK_CLEAR = null;

var CMD_WDR_ON		= null;
var CMD_WDR_OFF		= null;
var CMD_WB_AUTO		= null;
var CMD_WB_INDOOR	= null;
var CMD_WB_OUTDOOR	= null;
var CMD_WB_ATW		= null;
var CMD_WB_MANUAL	= null;
var CMD_FLIP_OFF	= null;
var CMD_FLIP_ME		= null;
var CMD_FLIP_IMAGE	= null;
var CMD_AE_FULL_AUTO	= null;
var CMD_AE_MANUAL		= null;
var CMD_AE_SHUTTER_PRIORITY	= null;
var CMD_GAIN_DIRECT	= null;
var CMD_SHUTTER_DIRECT	= null;
var CMD_HOME_ON			= null;
var CMD_HOME_OFF		= null;
var CMD_HOME_SET		= null;
var CMD_ALARM_OUTPUT_ENABLE = null;
var CMD_ALARM_OUTPUT_DISABLE = null;
var CMD_APERTURE_DIRECT = null;
var CMD_EXPCOMP_DIRECT = null;

var CMD_AUTOPAN_SET		= null;
var CMD_AUTOPAN_END		= null;
var CMD_AUTOPAN_SET_DIR_SPEED= null;
var CMD_AUTOPAN_GO		= null;

var CMD_CRUISE_SET		= null;
var CMD_CRUISE_END		= null;
var CMD_CRUISE_GO		= null;

var CMD_PANTILT_FACTORY_DEFAULT = null;
var CMD_PANTILT_RESET	= null;
//--end add for visca

// Please implement GetPTZCmd(cmds)

// Define constant, The PTZ brand name.
var PTZ_PROD_SENSOR = "Sensormatic";
var PTZ_PROD_SEEKU = "SeeKu";
var PTZ_PROD_FASTRAX = "Capture";
var PTZ_PROD_DRAGON = "Dragon";
var PTZ_PROD_PELCOD = "Pelco-D";
var PTZ_PROD_PELCOP = "Pelco-P";
var PTZ_PROD_SANTEC = "SANTEC";
var PTZ_PROD_LILIN = "Lilin";
var PTZ_PROD_VISCA = "Visca";

var PTZ_ID_NAME = "PTZ_ID_SELECT";
var serial = (g_isSupportRS485)?1:0;
var supBoth = ((g_isSupportRS485==1)&&(g_isSupportRS232==1));

var g_pantileid = parseInt(GV("<%485ID%>",1));
// Try to load User Default PTZ Protocol Function.
var g_ptzprotocol = GV("<%rs485protocol%>",0);
if (g_isSupportVisca==1)
  loadJS("visca.js");
else{
  if(g_ptzprotocol == 0)
    loadJS("pelcod.js");
  else
    loadJS("pelcop.js");
}
function CreatePTZHeader()
{
  var o='';
  //o+='<html><head><title>SpeedDome Controller</title>';
  o+='<title>SpeedDome Controller</title>';
  //o+='<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">';
  //o+='<link href="lc_'+g_langName+'.css" rel="stylesheet" type="text/css">';
  o+='<link href="lc_en_us.css" rel="stylesheet" type="text/css">';
  o+='</head><body onload="LoadSerial()" ><img id="sendPTZCmd" width="0" height="0" border="0" src="" />';
  DW(o);
}

function CreatePTZBottom()
{
  var o='';
  o+='<div id="Layer2" style="width:433px; height:144px; position:absolute; left:0px; top:0px; z-index:2;">';
  o+='<img name="pelcod" src="K_lilin.gif" width="455" height="125" border="0" usemap="#m_pelcod" alt="">';
  o+=GetImageMapHtml();
  o+='</div>';
//  o+='<div id="Layer3" style="width:70px; height:200px; position:absolute; left:25px; top:19px; z-index:3;">';
//  o+=GetSelectNumberHtml(PTZ_ID_NAME,1,PTZ_MAX_DEVICE_ID,1,g_ptzID,"ChangePTZID()");
//  o+='</div>';
//  o+='<img name="Layer232" id="Layer232" src="cover.gif" width="15" height="7" style="position:absolute; visibility:hidden; top: 22px; left: 164px;z-index:5;">';
//  o+='<img name="Layer485" id="Layer485" src="cover.gif" width="15" height="7" style="position:absolute; visibility:hidden; top: 21px; left: 191px;z-index:5;">';
//  o+='<div style="position:absolute;left:80px;top:22px;z-index:3;"><span class=b1>'+PTZ_PROD_NAME+'</span></div>';
  o+="</body></html>";
  DW(o);
}

// datas is a byte array for cal.
// startIx the start cal index.
// sumIx is the checksum position(index), this byte will not be cal. it is for store result.
function SUM_ALL_MOD_256(datas,startIx,sumIx)
{
  var sum = 0;
  for (var i=startIx;i<datas.length;i++)
  {
    if (i != sumIx)
    {
      sum += datas[i];
    }
  }
  datas[sumIx] = sum % 256;
  return datas;
}

function ALL_XOR(datas,startIx,sumIx)
{
  var r = 0;
  for (var i=startIx;i<datas.length;i++)
  {
    if (i != sumIx)
    {
      r ^= datas[i];
    }
  }
  datas[sumIx] = r;
  return datas;
}

function ZERO_SUB_SUM_ALL(datas,startIx,sumIx)
{
  var sum = 0;
  for (var i=startIx;i<datas.length;i++)
  {
    if (i != sumIx)
    {
      sum += datas[i];
    }
  }
  datas[sumIx] = ((0 - sum) % 256)+256;
  return datas;
}


// datas is a byte array.
function GetFixLenHexStr(datas)
{
  var o="";
  for (var i=0;i<datas.length;i++)
  {
    o += FixNum(datas[i].toString(16),2,'0'); 
  }
  return o;
}

//This is function is for overwrite.
function GetPTZCmd(cmds)
{
  return "";
}


//cmds is the send out command, not include header, id , checksum, This is a byte array.
//delay If not null, it will add delay time and stop command.
function SendPTZCmdToDevice(cmdName,delay)
{
  var delayStr = ((serial==1)?"&rs485delay=":"&rs232delay=");
  //var outputStr = ((serial==1)?"&rs485output=":"&rs232output=");
  var outputStr = "&ipncptz=";
  var o = "vb.htm?language=ie";
  o+=outputStr;
  o+=GetPTZCmd(eval(cmdName));
  if (delay != null)
  {
    o+=(delayStr+delay);
    o+=(outputStr+GetPTZStopCmd());
  }

  //fix IE7 cache problem
  o += "%00"+Math.random();
  //alert(o);
  GE("sendPTZCmd").src = o;
}


function GetPTZStopCmd()
{
  var delayStr = ((serial==1)?"&rs485delay=":"&rs232delay=");
  var o='';
  if (CMD_STOPS != null)
  {
    for (var i=0;i<CMD_STOPS.length;i++)
    {
      o+=GetPTZCmd(CMD_STOPS[i]);
      o+=delayStr+"50";
    }
  }
  else
  {
    o=GetPTZCmd(CMD_STOP);
  }
  return o;
}
function SendPTZStopCmd()
{
  var outputStr = ((serial==1)?"&rs485output=":"&rs232output=");
  var o = "vb.htm?language=ie";
  o+=outputStr;
  o+=GetPTZStopCmd();
  //alert(o);
  GE("sendPTZCmd").src = o;
}

function GetPTZArea(left,top,width,height,cmdName,title,delay)
{
  var o='';
  if (cmdName != null && eval(cmdName +" != null"))
  {
    o+='<area shape="rect" coords="'+left+','+top+','+(left+width)+','+(top+height)+'" ';
    if (delay != null)
    {
      o+='href="#'+title+'" onMouseDown="SendPTZCmdToDevice('+cmdName+','+delay+')" ';
    }
    else
    {
      o+='href="#'+title+'" onMouseDown="SendPTZCmdToDevice('+cmdName+')" ';
      o+='onMouseUp="SendPTZStopCmd()" ';
    }
    o+=' title="'+title+'" alt="'+title+'" onClick="return false;" >';
  }
  return o;
}

function GetImageMapHtml()
{
  var o ='';
  o+='<map name="m_pelcod">';
//  o+='<area shape="rect" coords="165,22,178,28" href="#" onClick="SerialChange()">';
//  o+='<area shape="rect" coords="192,21,205,27" href="#" onClick="SerialChange()">';
  o+=GetPTZArea(405,36,38,22,"CMD_ZOOM_IN","Zoom In");
  o+=GetPTZArea(313,36,38,22,"CMD_ZOOM_OUT","Zoom Out");
  o+=GetPTZArea(360,36,38,22,"CMD_TILT_UP","Tilt Up");
  o+=GetPTZArea(360,86,38,22,"CMD_TILT_DOWN","Tilt Down");
  o+=GetPTZArea(313,62,38,22,"CMD_PAN_LEFT","Pan Left");
  o+=GetPTZArea(405,62,38,22,"CMD_PAN_RIGHT","Pan Right");
//  o+=GetPTZArea(222,86,38,22,"CMD_STEP_DOWN","Step Down",50);
//  o+=GetPTZArea(264,62,38,22,"CMD_STEP_RIGHT","Step Right",50);
//  o+=GetPTZArea(264,86,38,22,"CMD_FOCUS_NEAR","Focus Near");
//  o+=GetPTZArea(180,62,38,22,"CMD_STEP_LEFT","Step Left",50);
//  o+=GetPTZArea(180,86,38,22,"CMD_FOCUS_FAR","Focus Far");
//  o+=GetPTZArea(221,36,38,22,"CMD_STEP_UP","Step Up",50);
//  o+=GetPTZArea(313,86,38,22,"CMD_APERTURE_SUB","Aperture -");
//  o+=GetPTZArea(405,86,38,22,"CMD_APERTURE_ADD","Aperture +");
//  for (var i=0;i<10;i++)
//  {
//    o+=GetPTZArea(35+(13*i),60,14,19,"CMD_SET_"+(i+1),"Set "+(i+1));
//  }
//  for (var i=0;i<10;i++)
//  {
//    o+=GetPTZArea(35+(13*i),78,14,19,"CMD_GOTO_"+(i+1),"Goto "+(i+1));
//  }
  o+='</map>';

  return o;
}


function SerialChange()
{
  if (!supBoth)
    return;
	if (serial==1)
	{
		serial = 0;
		Serial232();
	}
	else 
	{
		serial = 1;
		Serial485();
	}
}
function LoadSerial()
{
	if (serial==1)
	{
		Serial485();
	}
	else 
	{
		Serial232();
	}
}
function Serial485()
{
  SetVisible("Layer232",false);
  SetVisible("Layer485",true);
}
function Serial232()
{
  SetVisible("Layer232",true);
  SetVisible("Layer485",false);
}
function ChangePTZID()
{
  GE("sendPTZCmd").src="/vb.htm?setlayoutnum=1:" + GetValue(PTZ_ID_NAME);
}


//20071031 Luther add for PTZ Control Panel
function CreatePtzPanel()
{
  var o='';
  o+='<div id="PtzPanel" style="border-style: ridge;border-width:5px; border-color:#735EFF; width:700; height:100; background-color:#E9E2FF">';
  o+='</div><img id="sendPTZCmd" width="0" height="0" border="0" src="" />';
  DW(o);
}
function CreatePtzButton(ww,hh)
{
  o='';
  o+=CreatePtzButtonHtml('ptzzmin'  ,'CMD_ZOOM_IN'     ,'ptz_zoom_in',true);
  o+=CreatePtzButtonHtml('ptzzmout' ,'CMD_ZOOM_OUT'    ,'ptz_zoom_out',true);
  o+=CreatePtzButtonHtml('ptzup'    ,'CMD_TILT_UP'     ,'ptz_up',true);
  o+=CreatePtzButtonHtml('ptzdown'  ,'CMD_TILT_DOWN'   ,'ptz_down',true);
  o+=CreatePtzButtonHtml('ptzright' ,'CMD_PAN_RIGHT'   ,'ptz_right',true);
  o+=CreatePtzButtonHtml('ptzleft'  ,'CMD_PAN_LEFT'    ,'ptz_left',true);
  o+=CreatePtzButtonHtml('ptzmenu'  ,'CMD_MENU'        ,'ptz_menu',false);
  o+=CreatePtzButtonHtml('ptzpreset','CMD_PRESET'      ,'ptz_preset',false);
  o+=CreatePtzButtonHtml('ptzgoto'  ,'CMD_PRESET_GO'   ,'ptz_preset_goto',false);
  o+=CreatePtzButtonHtml('ptzsetx'  ,'CMD_PRESET_X'    ,'ptz_preset_clear',false);
  o+=CreatePtzButtonHtml('ptzscan'  ,'CMD_AUTO_SCAN'   ,'ptz_auto_scan',false);
  o+=CreatePtzButtonHtml('ptzscanx' ,'CMD_AUTO_SCAN_X' ,'ptz_auto_scan_stop',false);
  o+=CreatePtzButtonHtml('ptziriso' ,'CMD_APERTURE_ADD','ptz_iris_open',true);
  o+=CreatePtzButtonHtml('ptzirisc' ,'CMD_APERTURE_SUB','ptz_iris_close',true);
  o+=CreatePtzButtonHtml('ptzfofar' ,'CMD_FOCUS_FAR'   ,'ptz_focus_far',true);
  o+=CreatePtzButtonHtml('ptzfonear','CMD_FOCUS_NEAR'  ,'ptz_focus_near',true);
  o+=CreatePtzButtonHtml('ptzpat'   ,'CMD_PAT_START'     ,'ptz_pat_start',false);
  o+=CreatePtzButtonHtml('ptzpatx'  ,'CMD_PAT_STOP'     ,'ptz_pat_stop',false);
  o+=CreatePtzButtonHtml('ptzpatgo' ,'CMD_PAT_RUN'     ,'ptz_pat_run',false);
  o+=CreatePtzIdList();
  o+=CreatePtzPresetList();
  DW(o);

}
function FixPtzButtonPos(ss)
{
  var hh = GE("PtzPanel").offsetTop+61;
  var ww = (document.body.offsetWidth / 2)-350;
  
  SetObjPos(ss,'ptzzmin'  ,ww,hh,590, 7);
  SetObjPos(ss,'ptzzmout' ,ww,hh,530, 7);
  SetObjPos(ss,'ptzup'    ,ww,hh,560, 7);
  SetObjPos(ss,'ptzdown'  ,ww,hh,560,68);
  SetObjPos(ss,'ptzright' ,ww,hh,590,37);
  SetObjPos(ss,'ptzleft'  ,ww,hh,530,37);
  SetObjPos(ss,'ptzmenu'  ,ww,hh,560,37);
  SetObjPos(ss,'ptzpreset',ww,hh,120,50);
  SetObjPos(ss,'ptzgoto'  ,ww,hh,197,50);
  SetObjPos(ss,'ptzsetx'  ,ww,hh,160,20);
  SetObjPos(ss,'ptzscan'  ,ww,hh,250,50);
  SetObjPos(ss,'ptzscanx' ,ww,hh,280,50);
  SetObjPos(ss,'ptziriso' ,ww,hh,590,68);
  SetObjPos(ss,'ptzirisc' ,ww,hh,530,68);
  SetObjPos(ss,'ptzfofar' ,ww,hh,500,50);
  SetObjPos(ss,'ptzfonear',ww,hh,470,50);
  SetObjPos(ss,'ptzpat'   ,ww,hh,350,50);
  SetObjPos(ss,'ptzpatx'  ,ww,hh,380,50);
  SetObjPos(ss,'ptzpatgo' ,ww,hh,410,50);
  SetObjPos(ss,'PtzIdBlock',ww,hh,10,10);
  SetObjPos(ss,'PtzPresetBlock',ww,hh,150,50);
  
  
}
function SetObjPos(isShow,name,bx,by,x,y)
{
  var obj=GE("PTZCTRL_"+name);
  if (obj != null)
  {
    obj.style.position="absolute";
    if (isShow==true)
    {
      obj.style.top = by+y;
      obj.style.left = bx+x;
    }
    else
    {
      obj.style.top = -600;
      obj.style.left = -600;
    }
  }
}

function CreatePtzIdList()
{
  return "<div id='PTZCTRL_PtzIdBlock'>ID: "+GetSelectNumberHtml("PtzID",1,255,1,1)+"</div>";
}
function CreatePtzPresetList()
{
  return "<div id='PTZCTRL_PtzPresetBlock'>"+GetSelectNumberHtml("PresetID",1,99,1,1)+"</div>";
}
function CreatePtzButtonHtml(id,cmd,i18n,isX)
{
  //alert("w:"+ww+" h:"+hh);
  var o='';
  o+='<input id="PTZCTRL_'+id+'" type="image" ';
  o+='style="position:absolute; top:-600px;left:-600px" ';
  o+='onMouseDown="SendPTZCmdToDevice(\''+cmd+'\')" ';
  if(isX)
  {
    o+='onMouseOut="SendPTZStopCmd()" ';
    o+='onMouseUp="SendPTZStopCmd()" ';
  }
  o+='src="'+id+'.gif" alt="'+GL(i18n)+'" >';
  return o;
}

//for visca
function SendViscaCmdToDevice(cmdName,p1,p2,p3,p4)
{
	var o="";

	if(p1!=null)
		cmdName[1]=p1;
	if(p2!=null)
		cmdName[2]=p2;
	if(p3!=null)
		cmdName[3]=p3;
	if(p4!=null)
		cmdName[4]=p4;
	
	o = "vb.htm?ipncvisca=";
	o+=GetPTZCmd(eval(cmdName));
	
	SendHttpPublic(o,false);
};