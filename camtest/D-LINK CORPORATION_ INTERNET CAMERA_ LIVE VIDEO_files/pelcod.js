//HEADER_BYTE = 0xFF;
PTZ_PROD_NAME = PTZ_PROD_PELCOD;
//PTZ_MAX_DEVICE_ID = 255;
CMD_STOP          = new Array(0,0,0,0);
CMD_ZOOM_IN       = new Array(0x00,0x20,0x00,0x00);
CMD_ZOOM_OUT      = new Array(0x00,0x40,0x00,0x00);
CMD_TILT_UP       = new Array(0x00,0x08,0x00,"SPD");
CMD_TILT_DOWN     = new Array(0x00,0x10,0x00,"SPD");
CMD_PAN_LEFT      = new Array(0x00,0x04,"SPD",0x00);
CMD_PAN_RIGHT     = new Array(0x00,0x02,"SPD",0x00);
CMD_ZERO_PAN      = new Array(0x00,0x07,0x00,0x22);
CMD_STEP_DOWN     = new Array(0x00,0x10,0x00,0x20);
CMD_STEP_RIGHT    = new Array(0x00,0x02,0x20,0x00);
CMD_FOCUS_NEAR    = new Array(0x01,0x00,0x00,0x00);
CMD_STEP_LEFT     = new Array(0x00,0x04,0x20,0x00);
CMD_FOCUS_FAR     = new Array(0x00,0x80,0x00,0x00);
CMD_STEP_UP       = new Array(0x00,0x08,0x00,0x20);
CMD_APERTURE_SUB  = new Array(0x04,0x00,0x00,0x00);
CMD_APERTURE_ADD  = new Array(0x02,0x00,0x00,0x00);
for (var i=0;i<PTZ_MAX_PRESET_NUMBER;i++)
{
  eval("CMD_SET_"+(i+1)+"=new Array(0x00,0x03,0x00,"+(i+1)+");");
}
for (var i=0;i<PTZ_MAX_PRESET_NUMBER;i++)
{
  eval("CMD_GOTO_"+(i+1)+"=new Array(0x00,0x07,0x00,"+(i+1)+");");
}
CMD_HOME          = new Array(0x00,0x07,0x00,0x22);
CMD_UP_LEFT       = new Array(0x00,0x0C,"SPD","SPD");
CMD_UP_RIGHT      = new Array(0x00,0x0A,"SPD","SPD");
CMD_DOWN_LEFT     = new Array(0x00,0x14,"SPD","SPD");
CMD_DOWN_RIGHT    = new Array(0x00,0x12,"SPD","SPD");
var CMD_SET_PAN_ZERO = new Array(0x00,0x4B,0x00,0x00);
var CMD_SET_TILT_ZERO = new Array(0x00,0x4D,0x00,0x00);
var CMD_SET_ZOOM_ZERO = new Array(0x00,0x4F,0x00,0x00);

function GetPTZCmd(cmds)
{
  var out = new Array(7);
  out[0] = 0xFF;
  out[1] = g_pantileid;
  out[2] = cmds[0];
  out[3] = cmds[1];

  if(cmds[2] == "SPD")
  {
    if(GE("panspeed") != null)
      out[4] = parseInt(panspeed.GV());
    else
      out[4] = 0x1A;
  }
  else
  {
    out[4] = cmds[2];
  }

  if(cmds[3] == "SPD")
  {
    if(GE("tiltespeed") != null)
      out[5] = parseInt(tiltespeed.GV());
    else
      out[5] = 0x1A;
  }
  else
  {
    out[5] = cmds[3];
  }

  out = SUM_ALL_MOD_256(out,1,6);
  return GetFixLenHexStr(out);
};

