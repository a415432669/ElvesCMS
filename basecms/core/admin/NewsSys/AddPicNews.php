<?php
define('ElvesCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
$link=db_connect();
$Elves=new mysqlquery();
$editor=1;
//验证用户
$lur=is_login();
$logininid=$lur['userid'];
$loginin=$lur['username'];
$loginrnd=$lur['rnd'];
$loginlevel=$lur['groupid'];
$loginadminstyleid=$lur['adminstyleid'];
//验证权限
CheckLevel($logininid,$loginin,$classid,"picnews");
$url="<a href=ListPicNews.php>管理图片信息</a>&nbsp;>&nbsp;增加图片信息";
$melve=$_GET['melve'];
//修改图片信息
if($melve=="EditPicNews")
{
	$picid=(int)$_GET['picid'];
	$r=$Elves->fetch1("select title,pic_url,url,pic_width,pic_height,open_pic,border,pictext,classid from {$dbtbpre}melvepic where picid='$picid'");
	$open_pic0=" selected";
	$open_pic1="";
	if($r[open_pic]=="_parent")
	{
		$open_pic0="";
		$open_pic1=" selected";
	}
}
//图片类别
$sql=$Elves->query("select classid,classname from {$dbtbpre}melvepicclass order by classid");
while($cr=$Elves->fetch($sql))
{
	if($r[classid]==$cr[classid])
	{$select=" selected";}
	else
	{$select="";}
	$class.="<option value=".$cr[classid].$select.">".$cr[classname]."</option>";
}
db_close();
$Elves=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>管理图片信息</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>位置：<?=$url?>
    </td>
  </tr>
</table>
<form name="form1" method="post" action="ListPicNews.php">
<input type=hidden name=melve value=<?=$melve?>>
<input type=hidden name=picid value=<?=$picid?>>
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
    <tr class="header"> 
      <td height="25" colspan="2">增加图片信息</td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="25">请选择类别：</td>
      <td height="25"><select name="add[classid]" id="add[classid]">
          <?=$class?>
        </select>
        <input type="button" name="Submit6222" value="管理分类" onclick="window.open('PicClass.php');"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="18%" height="25">图片地址：</td>
      <td width="82%" height="25"><input name="pic_url" type="text" id="pic_url" value="<?=$r[pic_url]?>" size="36">
        <a onclick="window.open('../elveeditor/FileMain.php?modtype=5&type=1&classid=&doing=2&field=pic_url','','width=700,height=550,scrollbars=yes');" title="选择已上传的图片"><img src="../../data/images/changeimg.gif" width="22" height="22" border="0" align="absbottom"></a> 
        宽 
        <input name="pic_width" type="text" id="pic_width" value="<?=$r[pic_width]?>" size="4">
        × 高 
        <input name="pic_height" type="text" id="pic_height" value="<?=$r[pic_height]?>" size="4">
        ，边框： 
        <input name="border" type="text" id="border" value="<?=$r[border]?>" size="2"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">信息标题：</td>
      <td height="25"><input name="title" type="text" id="title" value="<?=$r[title]?>" size="50"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">链接地址：</td>
      <td height="25"><input name="url" type="text" id="url" value="<?=$r[url]?>" size="50"> 
        <select name=open_pic id="open_pic">
          <option value="_blank"<?=$open_pic0?>>在新窗口打开</option>
          <option value="_parent"<?=$open_pic1?>>在原窗口打开</option>
        </select></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" valign="top">信息简介：</td>
      <td height="25"><textarea name="pictext" cols="65" rows="6" id="pictext"><?=$r[pictext]?></textarea></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"><input type="submit" name="Submit" value="提交"> <input type="reset" name="Submit2" value="重置"></td>
    </tr>
  </table>
</form>
</body>
</html>
