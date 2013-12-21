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
CheckLevel($logininid,$loginin,$classid,"ztf");
$url="<a href='ListZt.php'>管理专题</a>&nbsp;>&nbsp;<a href='ListZtF.php'>管理专题字段</a>";
$sql=$Elves->query("select * from {$dbtbpre}melveztf order by myorder,fid");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>管理字段</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td width="50%">位置： 
      <?=$url?>
    </td>
    <td><div align="right" class="emenubutton">
        <input type="button" name="Submit2" value="增加专题字段" onclick="self.location.href='AddZtF.php?melve=AddZtF';">
		&nbsp;&nbsp;
		<input type="button" name="Submit2" value="管理专题" onclick="self.location.href='ListZt.php';">
      </div></td>
  </tr>
</table>
<form name="form1" method="post" action="../elveclass.php" onsubmit="return confirm('确认要操作?');">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
    <tr class="header"> 
      <td width="6%" height="25"><div align="center">顺序</div></td>
      <td width="27%" height="25">
<div align="center">字段名</div></td>
      <td width="27%">
<div align="center">字段标识</div></td>
      <td width="23%"><div align="center">字段类型</div></td>
      <td width="17%" height="25"><div align="center">操作</div></td>
    </tr>
  <?
  while($r=$Elves->fetch($sql))
  {
  	$ftype=$r[ftype];
  	if($r[flen])
	{
		if($r[ftype]!="TEXT"&&$r[ftype]!="MEDIUMTEXT"&&$r[ftype]!="LONGTEXT")
		{
			$ftype.="(".$r[flen].")";
		}
	}
  ?>
    <tr bgcolor="ffffff"> 
      <td height="25"><div align="center"> 
          <input name="myorder[]" type="text" id="myorder[]" value="<?=$r[myorder]?>" size="3">
          <input type=hidden name=fid[] value=<?=$r[fid]?>>
        </div></td>
      <td height="25"><div align="center"> 
          <?=$r[f]?>
        </div></td>
      <td><div align="center"> 
          <?=$r[fname]?>
        </div></td>
      <td><div align="center">
	  	  <?=$ftype?>
	  </div></td>
      <td height="25"><div align="center"> 
         [<a href='AddZtF.php?melve=EditZtF&fid=<?=$r[fid]?>'>修改</a>]&nbsp;&nbsp;[<a href='../elveclass.php?melve=DelZtF&fid=<?=$r[fid]?>' onclick="return confirm('确认要删除?');">删除</a>]
        </div></td>
    </tr>
    <?
	}
	?>
    <tr bgcolor="ffffff"> 
      <td height="25">&nbsp;</td>
      <td height="25" colspan="4"><input type="submit" name="Submit" value="修改字段顺序">
        <font color="#666666">(值越小越前面)</font> 
        <input name="melve" type="hidden" id="melve" value="EditZtFOrder"> 
      </td>
    </tr>
  </table>
</form>
<table width="100%" border="0" cellspacing="1" cellpadding="3" class="tableborder">
  <tr class="header">
    <td height="25">字段调用说明</td>
  </tr>
  <tr>
    <td height="25" bgcolor="#FFFFFF">使用内置调用专题自定义字段函数：ReturnZtAddField(专题ID,字段名)，专题ID=0为当前专题ID。取多个字段内容可用逗号隔开，例子：<br>
      取得'classtext'字段内容：$value=ReturnZtAddField(0,'classtext'); //$value就是字段内容。<br>
      取得多个字段内容：$value=ReturnZtAddField(1,'ztid,classtext'); //$value['classtext']才是字段内容。</td>
  </tr>
</table>
</body>
</html>
<?
db_close();
$Elves=null;
?>
