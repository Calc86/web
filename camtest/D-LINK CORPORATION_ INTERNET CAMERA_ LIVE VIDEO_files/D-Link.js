//=========Copy from Internet,  http://www.webtoolkit.info/ for encodeing data.
//NOTE: must put on top
var Base64 = {
    // private property
    //_keyStr : "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789#$@",
    _keyStr : "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",
	
    // public method for encoding
    encode : function (input) {
        var output = "";
        var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
        var i = 0;

        input = Base64._utf8_encode(input);

        while (i < input.length) {

            chr1 = input.charCodeAt(i++);
            chr2 = input.charCodeAt(i++);
            chr3 = input.charCodeAt(i++);

            enc1 = chr1 >> 2;
            enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
            enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
            enc4 = chr3 & 63;

            if (isNaN(chr2)) {
                enc3 = enc4 = 64;
            } else if (isNaN(chr3)) {
                enc4 = 64;
            }

            output = output +
            this._keyStr.charAt(enc1) + this._keyStr.charAt(enc2) +
            this._keyStr.charAt(enc3) + this._keyStr.charAt(enc4);
        }
        return output;
    },

    // public method for decoding
    decode : function (input) {
        var output = "";
        var chr1, chr2, chr3;
        var enc1, enc2, enc3, enc4;
        var i = 0;

        input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");

        while (i < input.length) {
            enc1 = this._keyStr.indexOf(input.charAt(i++));
            enc2 = this._keyStr.indexOf(input.charAt(i++));
            enc3 = this._keyStr.indexOf(input.charAt(i++));
            enc4 = this._keyStr.indexOf(input.charAt(i++));

            chr1 = (enc1 << 2) | (enc2 >> 4);
            chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
            chr3 = ((enc3 & 3) << 6) | enc4;

            output = output + String.fromCharCode(chr1);

            if (enc3 != 64) {
                output = output + String.fromCharCode(chr2);
            }
            if (enc4 != 64) {
                output = output + String.fromCharCode(chr3);
            }
        }
        output = Base64._utf8_decode(output);
        return output;
    },

    // private method for UTF-8 encoding
    _utf8_encode : function (string) {
        string = string.replace(/\r\n/g,"\n");
        var utftext = "";

        for (var n = 0; n < string.length; n++) {
            var c = string.charCodeAt(n);

            if (c < 128) {
                utftext += String.fromCharCode(c);
            }
            else if((c > 127) && (c < 2048)) {
                utftext += String.fromCharCode((c >> 6) | 192);
                utftext += String.fromCharCode((c & 63) | 128);
            }
            else {
                utftext += String.fromCharCode((c >> 12) | 224);
                utftext += String.fromCharCode(((c >> 6) & 63) | 128);
                utftext += String.fromCharCode((c & 63) | 128);
            }
        }
        return utftext;
    },

    // private method for UTF-8 decoding
    _utf8_decode : function (utftext) {
        var string = "";
        var i = 0;
        var c = c1 = c2 = 0;

        while ( i < utftext.length ) {
            c = utftext.charCodeAt(i);
            if (c < 128) {
                string += String.fromCharCode(c);
                i++;
            }
            else if((c > 191) && (c < 224)) {
                c2 = utftext.charCodeAt(i+1);
                string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
                i += 2;
            }
            else {
                c2 = utftext.charCodeAt(i+1);
                c3 = utftext.charCodeAt(i+2);
                string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
                i += 3;
            }
        }
        return string;
    }
};

var countdownLock = false;
var timerId=null;
var myTime;
var myPage;

function CountDown2ChangeContent(ctime,link)
{
  if(!countdownLock)
  {
    countdownLock = true;
    myTime = ctime;
    myPage = link;
    TimeLess();
  }
};

function TimeLess()
{
  //GE("show").innerHTML = GL("msg_wait",{1:myTime});
  ShowDLinkWarning(GL("msg_wait",{1:myTime}));
  myTime --;
  //alert(myTime);
  if (myTime > 0)
  {
    timerId = setTimeout("TimeLess()",1000);
  }
  else
  {
    //alert(myPage);
    g_lockLink = false;
    countdownLock = false;
    //ChangeContent(null,true);
    ChangeContent(myPage,true);
  }
};

//--start 2011.4.15 added
var locationcountdownLock = false;
var locationtimerId=null;
var locationmyTime;
var locationmyPage;
var locationmyfunction = null;
function CountDown2ChangeLocation(ctime,link,myfunction)
{
  if(!locationcountdownLock)
  {
    locationcountdownLock = true;
    locationmyTime = ctime;
    locationmyPage = link;
	locationmyfunction = myfunction;
    LocationTimeLess();
  }
};
//--end 2011.4.15
//--start 2011.4.15 added
function LocationTimeLess()
{
  ShowDLinkWarning(GL("now_setting")+",&nbsp;"+GL("msg_wait",{1:locationmyTime}));
  locationmyTime --;
  if (locationmyTime > 0)
  {
    locationtimerId = setTimeout("LocationTimeLess()",1000);
  }
  else
  {
    g_lockLink = false;
    locationcountdownLock = false;
	if(locationmyfunction!=null)
		locationmyfunction();
	if(locationmyPage!=null)
		window.location= locationmyPage;
  }
};
//--end 2011.4.15

function DLinkGoHref(link)
{
  location.href=link;
};

function DLinkSwapImage(id,newSrc)
{
  var obj = GE(id);
  if (obj != null)
  {
    obj.src = newSrc;
  }
};

function GetDLinkToolStr()
{
  var o='';
  o+='<table id="DLinkToolTable" width="800" valign="Middle" border="0" cellSpacing="0" cellPadding="0" >';
  o+='<tr class="topnav_bar" ><td>';
  o+='<img style="float:right;" border="0" src="top_space.gif" />';
  o+='<a onMouseOver="DLinkSwapImage(\'logoutImg\',\'logout_o.gif\')" onMouseDown="DLinkSwapImage(\'logoutImg\',\'logout_d.gif\')" onMouseOut="DLinkSwapImage(\'logoutImg\',\'logout_n.gif\')" href="logout.htm" target="_top" >';
  o+='<img id="logoutImg" style="float:right;" border="0" alt="logout" src="logout_n.gif" ></a>';
  o+='</td></tr></table>';
  return o;
};

function WriteDLinkHtmlHead(extTitle,otherName,onLoadFunc,onUnLoadFunc,onResizeFunc,refreshTime,index)
{
  var o='';
  o+=GetHtmlHeaderNoBannerStr(extTitle,otherName,onLoadFunc,onUnLoadFunc,onResizeFunc,refreshTime);
  o+=GetDLinkBannerTable(index);
  o+=GetDLinkTopnavTable(index);
  o+='<div id="WebContent" >';
  DW(o);
};
function WriteDLinkBottom(index)
{
  var o='';
  o+='</div>';
  o+='<div id="indexfloor"><table id="footer_container" width='+((index==0)?"950":"838")+' align="center"><tr>';
  o+='<td width="155" align="center">&nbsp;&nbsp;<img src="wireless_bottom.gif" width="114" height="35"></td>';
  o+='<td width="10">&nbsp;</td>';
  o+='<td>&nbsp;</td>';
  o+='</tr></table>';
  o+='<br><div align="center">Copyright &copy; 2011 D-Link Corporation.</div><br></div>';
  o+='</body>';
  DW(o);
};
function GetDLinkBannerTable(index)
{
  var o=''; 
  o+='<div id="indexLogo"><table id="header_container" align="center" cellpadding="5" cellspacing="0" width='+((index==0)?"950":"838")+' ><tr>';
  o+='<td><span id="header_text" >'+GL("product")+': '+g_titleName+'</span><a href="/cgi-bin/checksum.cgi">&nbsp;</a></td>';
  o+='<td align="right" nowrap="nowrap" >&nbsp;</td>';
  o+='<td align="right" nowrap="nowrap" ><span id="header_text" >'+GL("firmware_version")+': '+g_softwareversion+'</span></td>';
  o+='</tr></table>';
  o+='<table id="topnav_container_index" width='+((index==0)?"950":"838")+' align="center" cellpadding="0" cellspacing="0" ><tr>';
  o+='<td align="center" ><img src="dlink.gif" width='+((index==0)?"948":"836")+' height="92" ></td>';
  o+='</tr></table></div>';
  return o;
};
function GetDLinkTopnavTable(index)
{
  var o='';
  o+='<div id="indexMenu"><table id="TopnavTable" width='+((index==0)?"950":"838")+' height="27" align="center" bgcolor="#ffffff" cellpadding="2" cellspacing="1" ><tr id="topnav_container" >';
  o+='<td background="modelname.gif" width="127" height="27" id="modelname">'+g_modelname+'</td>';
  o+='<td id='+((index==0)?"topnavon_index":"topnavoff_index")+' width='+((index==0)?"135":"118")+'><a href="index.htm" >'+GL("live_video")+'</a></td>';
  o+='<td id='+((index==1)?"topnavon_index":"topnavoff_index")+' width='+((index==0)?"135":"118")+'><a href="setup.htm" >'+GL("setup")+'</a></td>';
  o+='<td id='+((index==2)?"topnavon_index":"topnavoff_index")+' width='+((index==0)?"135":"118")+'><a href="advanced.htm" >'+GL("advanced")+'</a></td>';
  o+='<td id='+((index==3)?"topnavon_index":"topnavoff_index")+' width='+((index==0)?"135":"118")+'><a href="maintenance.htm" >'+GL("maintenance")+'</a></td>';
  o+='<td id='+((index==4)?"topnavon_index":"topnavoff_index")+' width='+((index==0)?"135":"118")+'><a href="status.htm" >'+GL("title_status")+'</a></td>';
  o+='<td id='+((index==5)?"topnavon_index":"topnavoff_index")+' width='+((index==0)?"135":"118")+'><a href="help.htm" >'+GL("title_help")+'</a></td>';
  o+='</tr></table></div>';
  return o;
};

function WriteDLinkTablePH(key)
{
  WriteDLinkTxtTablePH(GL(key));
};
function WriteDLinkTxtTablePH(title)
{
  DW('<table class="maincontent" align="center" border="0" cellspacing="0" cellpadding="0" >');
  DW('<tr><td colspan="2" class="page_header" >'+title+'</td></tr>');
  DW('<tr><td class="page" >');
};
function WriteDLinkTablePB()
{
  DW('</td></tr></table>');
};

function DLinkMainMenuDown(obj,key)
{
  obj.className = "menuDOWN";
};
function DLinkMainMenuIn(obj,key,isMM)
{
  obj.className = "menuON";
  if (isMM != false)
    WS( GL(key+"_comment") );
};
function DLinkMainMenuOut(obj,key)
{
  obj.className = "menu";
};

function GetDLinkContentLink(key,url,type)
{
  var o="";
  // 20090116 Netpool Modified for D-Link Style
  o+='<span class="menu" onMouseOver="DLinkMainMenuIn(this,\''+key+'\')" onMouseOut="DLinkMainMenuOut(this,\''+key+'\')" onMouseDown="DLinkMainMenuDown(this,\''+key+'\')" onClick="';
  if (type == "pop")
  {
    o+= 'PopupPTZ(\''+url+'\');';
  }
  else if (type == "card")
  {
    o+= 'WindowOpen(\''+url+'\',\'CARD\',\'location=yes,directorybuttons=no,scrollbars=yes,resizable=yes,menubar=yes,toolbar=yes\');';
  }
  // 20090116 Netpool Modified for D-Link Style
  else if(type=="live_video" || type=="help" || type=="image" || type=="network" || type=="maintenance" || type=="application")
  {
    o+='DLinkGoHref(\''+url+'\')';
  }
  else
  {
    o+= 'ChangeContent(\''+url+'\');';
  }
  o+='" >'+GL(key)+'</span>';
  return o;
};

function GetPageHead(leftPageList,index)
{
  var o='';
  o+='<table bordercolordark="#FFFFFF" width="838" Height="100%" align="center" bgcolor="#FFFFFF" border="1" cellpadding="2" cellspacing="0" >';
  o+='<tr><td id="sidenav_container" vAlign="top" width="125" align="left" >';
  o+=GetDLinkMenuStr(leftPageList,index);
  if(g_langName=='en_us')
    o+='</td><td id="maincontent_container" width="569" vAlign="top" ><div id="maincontent">';
  else 
    o+='</td><td id="maincontent_container" width="560" vAlign="top" ><div id="maincontent">';
  return o;
};
function GetPageBottom(rightKeyList)
{
  var o='';
  o+='</div></td><td id="sidehelp_container" vAlign="top" align="left" >';
  o+=GetRightTxtBox(rightKeyList);
  o+='</td></tr></table>';
  return o;
};
function GetDLinkMenuStr(items,index)
{
  var o='';
  o+='<table border="0" cellpadding="0" cellspacing="0" >';
  o+='<tr><td id="sidenav_container">';
  var i, j;
  for (i=0,j=0;i<items.length;i+=3,j++)
  {
    if(items[i+2] == 0)
      continue;
    o+='<div';
    if(index==j)
      //o+=' id="sidenavoff" >'+GL(items[i])+'';
      //o+=' id="sidenavoff" >'+'<table><tr><td onclick="ChangeContent(\''+items[i+1]+'\');" >'+GL(items[i])+'</td></tr></table>';
      o+=' id="sidenavoff" ><a href="javascript:ChangeContent(\''+items[i+1]+'\');" >'+GL(items[i])+'</a>';
    else if(items[i]=="checkout")
      o+=' id="sidenav"><a href='+items[i+1]+' >'+GL("logout")+'</a>';
    else if(items[i+2] == 2)
      o+=' id="sidenav"><a href='+items[i+1]+' >'+GL(items[i])+'</a>';
    else
      o+=' id="sidenav"><a href="javascript:ChangeContent(\''+items[i+1]+'\');" >'+GL(items[i])+'</a>';
    o+='</div>';
  }
  o+='</td></tr></table>';
  return o;
};
function GetRightTxtBox(bodyStrArray)
{
  var o='';
  o+='<table cellspacing="0" cellpadding="2" border="0" ><tr><td id="help_text" >';
  o+='<b>'+GL("right_txt_title")+'</b>';
  for(i=0;i<bodyStrArray.length;i+=2)
  {
    if(bodyStrArray[i+1])
      o+='<br><br>'+GL(bodyStrArray[i],{1:g_str});
  }
  o+='<p>&nbsp;</p></td></tr></table>';
  return o;
};

function GetDLinkOrangeBox(headTxt,bodyHTML)
{
  var o='';
  o+='<div id="box_header" ><h1>'+headTxt+'</h1>';
  o+=bodyHTML+'<div id="show" name="show" style="color:#ff0000;" ></div></div>';
  return o;
};

//2011.1.17 add "divid"
function GetDLinkBlackBox(headTxt,bodyHTML,bookMarker,divid)
{
  var o='';
  if(divid!=null)  
    o+='<div id='+divid+' class="box" ><h2>';
  else
    o+='<div class="box" ><h2>';
  if(bookMarker != null)
    o+='<a id="'+bookMarker+'" name="'+bookMarker+'" >'+headTxt+'<a>';
  else
    o+=headTxt;
  o+='</h2>'+bodyHTML+'</div>';
  return o;
};

function ShowDLinkWarning(warningHTML)
{
  //alert(innerHTML);
  var obj = GE("show");
  if(obj != null)
  {
	if(warningHTML!=null && warningHTML!="")
	{
		obj.style.display = "block";
		obj.innerHTML = warningHTML;
	}
	else
	{
		obj.style.display = "none";
	}
  }
};

function GetDLinkBox(headTxt,headColor,headBgColor,bodyHTML,bodyColor,bodyBgColor,widthTxt,bookmarker)
{
  var o='';
  o+='<table class="maincontent" style="width:'+widthTxt+'; " border="0" cellspacing="0" cellpadding="0" >';
  o+='<tr><td class="box_header" style="color:#'+headColor+'; background-color:#'+headBgColor+'; border-color:#'+headBgColor+'; " >';
  if(bookmarker != null)
    o+='<a name="'+bookmarker+'"></a>';
  o+=headTxt+'</td></tr>';
  o+='<tr><td class="box_body" style="color:#'+bodyColor+'; background-color:#'+bodyBgColor+'; border-color:#'+headBgColor+'; " >'+bodyHTML+'</td></tr>';
  o+='</table>';
  return o;
};
function DLinkLightInfo(id,on_f_Img,on_n_Img,on_p_Img,off_f_Img,off_n_Img,off_p_Img,chgFun)
{
  this.id = id;
  this.on_f_Img = on_f_Img;
  this.on_n_Img = on_n_Img;
  this.on_p_Img = on_p_Img;
  this.off_f_Img = off_f_Img;
  this.off_n_Img = off_n_Img;
  this.off_p_Img = off_p_Img;
  this.value = 0;
  this.status = 0;
  this.onChangeFunc = chgFun;
  this.lightSwitch = DLinkLightSwitch;
};
function DLinkLightSwitch()
{
  var res;
  if (this.value == 0)
  {
    if(this.status == 1)
      res = this.off_f_Img;
    else if(this.status == 2)
      res = this.off_p_Img;
    else
      res = this.off_n_Img;
  }
  else
  {
    if(this.status == 1)
      res = this.on_f_Img;
    else if(this.status == 2)
      res = this.on_p_Img;
    else
      res = this.on_n_Img;
  }
  return res;
};
var DLinkLightAry = {};
function GetDLinkLightBtn(id,on_f_Img,on_n_Img,on_p_Img,off_f_Img,off_n_Img,off_p_Img,onChangeFunc)
{
  DLinkLightAry["LIGHT_"+id] = new DLinkLightInfo(id,on_f_Img,on_n_Img,on_p_Img,off_f_Img,off_n_Img,off_p_Img,onChangeFunc);
  var o='';
  o+='<img id="LIGHT_PIC_'+id+'" src="'+off_n_Img+'" title="'+GL(id+'_0')+'" alt="'+GL(id+'_0')+'" onmouseout="ChangeDLinkLightStatus(\''+id+'\',\'0\');" onmouseover="ChangeDLinkLightStatus(\''+id+'\',\'1\');" onmouseup="ChangeIndexWidthSize(\''+id+'\');SwitchDLinkLightValue(\''+id+'\');'+onChangeFunc+'()" onmousedown="ChangeDLinkLightStatus(\''+id+'\',\'2\');" style="cursor:pointer;" >';
  return o;
};
function ChangeDLinkLightStatus(id,status)
{
//alert(id);
//alert(status);
  var e = GE("LIGHT_PIC_"+id);
  var obj = DLinkLightAry["LIGHT_"+id];
  if (e != null && obj != null)
  {
    obj.status = status;
    e.src = obj.lightSwitch();
  }
};
function ChangeDLinkLightStatus2(id,value,status)
{
  var e = GE("LIGHT_PIC_"+id);
  var obj = DLinkLightAry["LIGHT_"+id];
  if (e != null && obj != null)
  {
    obj.value = value;
    obj.status = status;
    e.src = obj.lightSwitch();
  }
};
function GetDLinkLightValue(id)
{
  var res = 0;
  var e = DLinkLightAry["LIGHT_"+id];
  if (e != null)
    res = e.value;
  return res;
};
function SetDLinkLightValue(id,val)
{ 
  var e = DLinkLightAry["LIGHT_"+id];
  if (e != null)
    e.value = val;
  SetDLinkLightTitle(id,val);
  ChangeDLinkLightStatus(id,1);  
};
function ChangeIndexWidthSize(id)
{
  a = id.split("profile");
  UpdateGSize(a[1]);
  var obj1 = GE("indexLogo");
  var obj2 = GE("indexMenu");
  var obj3 = GE("indexfloor");
  if( (obj1 != null) && (obj2 != null) && (obj3 != null) )
  {
    if(g_viewXSize>720)
    {
      //alert(">720");
      obj1.innerHTML = indexLogo2(0);
      obj2.innerHTML = indexMenu2(0);
      obj3.innerHTML = indexfloor2(g_viewXSize+170);
    }
    else
    {
      //alert("<720");
      obj1.innerHTML = indexLogo(0);
      obj2.innerHTML = indexMenu(0);
      obj3.innerHTML = indexfloor();
    }
  }
};
function indexLogo(index)
{
  var o='';
  o+='<table id="header_container" align="center" cellpadding="5" cellspacing="0" width='+((index==0)?"950":"838")+' ><tr>';
  o+='<td><span id="header_text" >'+GL("product")+': '+g_titleName+'</span><a href="/cgi-bin/checksum.cgi">&nbsp;</a></td>';
  o+='<td align="right" nowrap="nowrap" >&nbsp;</td>';
  o+='<td align="right" nowrap="nowrap" ><span id="header_text" >'+GL("firmware_version")+': '+g_softwareversion+'</span></td>';
  o+='</tr></table>';
  o+='<table id="topnav_container_index" width='+((index==0)?"950":"838")+' align="center" cellpadding="0" cellspacing="0" ><tr>';
  o+='<td align="center" ><img src="dlink.gif" width='+((index==0)?"948":"836")+' height="92" ></td>';
  o+='</tr></table>';
  return o;
};
function indexLogo2(index)
{
  w = parseInt(g_viewXSize) + 170;
  var o=''; 
  o+='<table id="header_container" align="center" cellpadding="5" cellspacing="0" width='+ w +' ><tr>';
  o+='<td><span id="header_text" >'+GL("product")+': '+g_titleName+'</span><a href="/cgi-bin/checksum.cgi">&nbsp;</a></td>';
  o+='<td align="right" nowrap="nowrap" >&nbsp;</td>';
  o+='<td align="right" nowrap="nowrap" ><span id="header_text" >'+GL("firmware_version")+': '+g_softwareversion+'</span></td>';
  o+='</tr></table>';
  return o;
};
function indexMenu(index)
{
  var o='';
  o+='<table id="TopnavTable" width='+((index==0)?"950":"838")+' height="27" align="center" bgcolor="#ffffff" cellpadding="2" cellspacing="1" ><tr id="topnav_container" >';
  o+='<td background="modelname.gif" width="127" height="27" id="modelname">'+g_modelname+'</td>';
  o+='<td id='+((index==0)?"topnavon_index":"topnavoff_index")+' width='+((index==0)?"135":"118")+'><a href="index.htm" >'+GL("live_video")+'</a></td>';
  o+='<td id='+((index==1)?"topnavon_index":"topnavoff_index")+' width='+((index==0)?"135":"118")+'><a href="setup.htm" >'+GL("setup")+'</a></td>';
  o+='<td id='+((index==2)?"topnavon_index":"topnavoff_index")+' width='+((index==0)?"135":"118")+'><a href="advanced.htm" >'+GL("advanced")+'</a></td>';
  o+='<td id='+((index==3)?"topnavon_index":"topnavoff_index")+' width='+((index==0)?"135":"118")+'><a href="maintenance.htm" >'+GL("maintenance")+'</a></td>';
  o+='<td id='+((index==4)?"topnavon_index":"topnavoff_index")+' width='+((index==0)?"135":"118")+'><a href="status.htm" >'+GL("title_status")+'</a></td>';
  o+='<td id='+((index==5)?"topnavon_index":"topnavoff_index")+' width='+((index==0)?"135":"118")+'><a href="help.htm" >'+GL("title_help")+'</a></td>';
  o+='</tr></table>';
  return o;
};
function indexMenu2(index)
{
  w = (parseInt(g_viewXSize)+170);
  w1 = (parseInt(g_viewXSize))/6;
  //alert(w);
  var o='';
  o+='<table id="TopnavTable" width='+ w +' height="27" align="center" bgcolor="#ffffff" cellpadding="2" cellspacing="1" ><tr id="topnav_container" >';
  o+='<td background="modelname.gif" width="127" height="27" id="modelname">'+g_modelname+'</td>';
  o+='<td id='+((index==0)?"topnavon_index2":"topnavoff_index2")+' width='+ w1 +'><a href="index.htm" >'+GL("live_video")+'</a></td>';
  o+='<td id='+((index==1)?"topnavon_index2":"topnavoff_index2")+' width='+ w1 +'><a href="setup.htm" >'+GL("setup")+'</a></td>';
  o+='<td id='+((index==2)?"topnavon_index2":"topnavoff_index2")+' width='+ w1 +'><a href="advanced.htm" >'+GL("advanced")+'</a></td>';
  o+='<td id='+((index==3)?"topnavon_index2":"topnavoff_index2")+' width='+ w1 +'><a href="maintenance.htm" >'+GL("maintenance")+'</a></td>';
  o+='<td id='+((index==4)?"topnavon_index2":"topnavoff_index2")+' width='+ w1 +'><a href="status.htm" >'+GL("title_status")+'</a></td>';
  o+='<td id='+((index==5)?"topnavon_index2":"topnavoff_index2")+' width='+ w1 +'><a href="help.htm" >'+GL("title_help")+'</a></td>';
  o+='</tr></table>';
  return o;
};
function indexfloor()
{
  var o='';
  o+='<table id="footer_container" width='+((0==0)?"950":"838")+' align="center"><tr>';
  o+='<td width="155" align="center">&nbsp;&nbsp;<img src="wireless_bottom.gif" width="114" height="35"></td>';
  o+='<td width="10">&nbsp;</td>';
  o+='<td>&nbsp;</td>';
  o+='</tr></table>';
  o+='<br><div align="center">Copyright &copy; 2011 D-Link Corporation.</div><br>';
  return o;
};
function indexfloor2(w)
{
  var o='';
  o+='<table id="footer_container" width='+(w)+' align="center"><tr>';
  o+='<td width="155" align="center">&nbsp;&nbsp;<img src="wireless_bottom.gif" width="114" height="35"></td>';
  o+='<td width="10">&nbsp;</td>';
  o+='<td>&nbsp;</td>';
  o+='</tr></table>';
  o+='<br><div align="center">Copyright &copy; 2011 D-Link Corporation.</div><br>';
  
  return o;
}
function SetDLinkLightTitle(id,val)
{
  var e = GE("LIGHT_PIC_"+id);
  if (e != null)
  {
    var key = id + "_" + val;
    e.title = GL(key);
    e.alt = GL(key);
  }
};
function SwitchDLinkLightValue(id)
{
  var value = GetDLinkLightValue(id);
  if(value == 0)
    SetDLinkLightValue(id,1);
  else
    SetDLinkLightValue(id,0);
};
function GetButtonHtml(name,value,onClickFun,width,onMouseDownFun,onMouseUpFun)
{
  return ('<input type="button" name="'+name+'" id="'+name+'" value="'+value+'"'+((width==null) ? '' : ('style="width:'+width+'px"'))+' onclick="'+onClickFun+';" '+((onMouseDownFun==null) ? '' : ('onMouseDown="'+onMouseDownFun+';"'))+' '+((onMouseUpFun==null) ? '' : ('onMouseUp="'+onMouseUpFun+';"'))+' >');
};

function GetDLinkSubmitButton(name,value,onClickFun,CLID,isAsync,SubmitCallBack)//--2011.1.5 add "SubmitCallBack"
{
  var fun = "ValidateCtrlAndSubmit";
  fun += ((CheckIsNullNoMsg(CLID))?"(CTRLARY":("("+CLID) );
  fun += ((CheckIsNullNoMsg(isAsync))?",null":(","+isAsync) );
//--start 2011.1.5 added
  fun += (SubmitCallBack!=null ? ","+SubmitCallBack : ",null");
//--end 2011.1.5
  fun += ")";
  fun += ((CheckIsNullNoMsg(onClickFun))?"":(";"+onClickFun) );
  //alert(fun+isAsync);
  return GetButtonHtml(name,value,fun);
};

function GetDLinkSubmitDoubleButton(SubmitCallBack)//--2011.1.5 add "SubmitCallBack"
{
  return  ('<br><center>'+GetDLinkSubmitButton("saveBtn",GL("save_settings"),null,null,null,SubmitCallBack)+'&nbsp;'+GetButtonHtml("unsaveBtn",GL("unsave_settings"),"NoSave()")+'</center>');
};

function GetDLinkDownButton(onClickFun1,value1,onClickFun2,value2)
{
  var o='';
  o+='<br><center>';
  o+=InputButton(onClickFun1,value1);
  if(onClickFun2!=null)
    o+='&nbsp;'+InputButton(onClickFun2,value2);
  o+='</center>';
  return o;
};

function GetDLinkOrangeBoxWithSubmitDoubleButton(tKey,sKey,SubmitCallBack,eventAmount)//--2011.1.5 add "SubmitCallBack"
{
  if(g_isIpcam)
    var g_str = GL("ipcam_str"); 
  else
    var g_str = GL("videoserver_str");
	
  //1= device name
  //2= total event
  return GetDLinkOrangeBox(GL(tKey),(GL(sKey,{1:g_str,2:eventAmount})+'<br>'+GetDLinkSubmitDoubleButton(SubmitCallBack)));
};

function WIPX_DLINK(tid,ctx,type,noteTxt,color)
{
  var o='';
  o+='<table><tr class="b1"><td width="150" height="30" >';
  o+=GL(tid)+':</td><td>'+ctx+'</td>'
  if(type=='text')
    o+='<td><FONT COLOR="'+color+'">'+noteTxt+'</FONT></td>';
  o+='</tr></table>';
  return o;
};
function WIP_DLINK(tid,id,type,noteTxt,color)
{
  return WIPX_DLINK(tid,WH_(id),type,noteTxt,color);
};
function WH_DLINK(id)
{
  return WH_(id);
};
function InputButton(onClickFun,value,id)
{
  var o='';
  o+='<input type="button" id="'+id+'"onclick="'+onClickFun+'()" value="'+value+ '">';
  return o;
};
function CheckTxt(check,text)
{
  var w='';
  w+=check.GetHtml();
  if(text!=null)
    w+=text;
  return w;
};
function RadioTxt(radio,number,text)
{
  //var o='';
  //o+=radio.GetHtml(number)+((text!=null)?text:'');
  return radio.GetHtml(number)+'&nbsp;'+((text!=null)?text:'');
};
function TextToTxt(text,ctrlText)
{
  var w='';
  w+='<td>'+text+'</td><td>'+ctrlText.html+'</td>';
  return w;
};
function ToBinaryArray(value)
{
  binaryArray = new Array();
  value=value.toString(2);
  if(value==2)
  {
    binaryArray[0]=1;binaryArray[1]=0;
  }
  else
  {
    len=value.length;
    for(i=0;i<len;i++)
    {
      binaryArray[i] = value.substring(i,i+1);
    }
  }	
  return binaryArray;
};
function ArrayToStringNumber(array)
{
  len=array.length;
  str='';
  for(i=len;i>0;i--)
  {
    str=str+array[i-1];
  }
  return parseInt(str,2);
};
function CtrlSendHttp(ctrlName,value)
{
  if(value==null)
    SendHttp(c_iniUrl+"&"+ctrlName.setcmd+ctrlName.GV());
  else
  {
    SendHttp(c_iniUrl+"&"+ctrlName.setcmd+value);
  }  
}
function CtrlMutiSendHttp(objName,value,isAsync,callBack)
{
  len = objName.length;
  ctrlHttp='';
  if(CheckIsNullNoMsg(value))
  {
    for(i=0;i<len;i++)
    {
      ctrlHttp+= '&' + objName[i].setcmd + objName[i].GV();
    }
  }
  else
  {
    for(i=0;i<len;i++)
    {
      ctrlHttp+= '&' + objName[i].setcmd + value[i];
    }
  }
  SendHttp(c_iniUrl+ctrlHttp,isAsync,callBack);
}

function SendDLinkPTZCmd2Device(cmdName,delay,cmd,para)
{
  if (g_isSupportVisca==1)
  {
	SendViscaCmdToDevice(cmdName);
  }
  else
  {
	SendDLinkPTZCmd(cmdName,delay,cmd,para);
  }
};
//Internal use
function SendDLinkPTZCmd(cmdName,delay,cmd,para)
{
  var outputStr = "&ipncptz=";
  var o = "vb.htm?language=ie";
  if(cmd!=null && para!=null)
  {
    o+="&"+cmd+"="+encodeURIComponent(para);
  }

  if(g_ptzprotocol==0 && cmdName=="CMD_HOME")
  {
    o+=outputStr;
	o+=GetPTZCmd(eval(cmdName));
  }
  else
  {
    o+=outputStr;
    o+=GetPTZCmd(eval(cmdName));
  }

  if (delay != null)
  {
    o+=("&rs485delay="+delay);
    o+=(outputStr+GetPTZCmd(CMD_STOP));
  }

  //fix IE7 cache problem
  o+="%00"+Math.random();
  //alert(o);
  SendHttpPublic(o,false);
};
function SendDLinkPTZStopCmd(cmdName)
{
  if (g_isSupportVisca==1)
  {
	if (cmdName == null)
		SendViscaCmdToDevice(CMD_STOP); //zoom stop
	else
		SendViscaCmdToDevice(cmdName); //CMD_PANTILT_STOP
  }
  else
  {
	SendDLinkPTZStop();
  }
};
function SendDLinkPTZStop()
{
  var o = "vb.htm?language=ie";
  o+="&rs485output=";
  o+=GetPTZCmd(CMD_STOP);
  //alert(o);
  //GE("sendPTZCmd").src = o;
  SendHttpPublic(o,false);
};