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
CheckLevel($logininid,$loginin,$classid,"tags");

//清理多余数据
function ClearTags($start,$line,$userid,$username){
	global $Elves,$dbtbpre,$class_r,$fun_r;
	$line=(int)$line;
	if(empty($line))
	{
		$line=500;
	}
	$start=(int)$start;
	$b=0;
	$sql=$Elves->query("select id,classid,tid,tagid from {$dbtbpre}melvetagsdata where tid>$start order by tid limit ".$line);
	while($r=$Elves->fetch($sql))
	{
		$b=1;
		$newstart=$r['tid'];
		if(empty($class_r[$r[classid]]['tbname']))
		{
			$Elves->query("delete from {$dbtbpre}melvetagsdata where tid='$r[tid]'");
			$Elves->query("update {$dbtbpre}melvetags set num=num-1 where tagid='$r[tagid]'");
			continue;
		}
		$index_r=$Elves->fetch1("select id,classid,checked from {$dbtbpre}elve_".$class_r[$r[classid]]['tbname']."_index where id='$r[id]' limit 1");
		if(!$index_r['id'])
		{
			$Elves->query("delete from {$dbtbpre}melvetagsdata where tid='$r[tid]'");
			$Elves->query("update {$dbtbpre}melvetags set num=num-1 where tagid='$r[tagid]'");
		}
		else
		{
			//返回表
			$infotb=ReturnInfoMainTbname($class_r[$r[classid]]['tbname'],$index_r['checked']);
			//主表
			$infor=$Elves->fetch1("select stb from ".$infotb." where id='$r[id]' limit 1");
			//返回表信息
			$infodatatb=ReturnInfoDataTbname($class_r[$r[classid]]['tbname'],$index_r['checked'],$infor['stb']);
			//副表
			$finfor=$Elves->fetch1("select infotags from ".$infodatatb." where id='$r[id]' limit 1");
			$tagr=$Elves->fetch1("select tagname from {$dbtbpre}melvetags where tagid='$r[tagid]'");
			if(!stristr(','.$finfor['infotags'].',',','.$tagr['tagname'].','))
			{
				$Elves->query("delete from {$dbtbpre}melvetagsdata where tid='$r[tid]'");
				$Elves->query("update {$dbtbpre}melvetags set num=num-1 where tagid='$r[tagid]'");
			}
			elseif($index_r['classid']!=$r[classid])
			{
				$Elves->query("update {$dbtbpre}melvetagsdata set classid='$index_r[classid]' where tid='$r[tid]'");
			}
		}
	}
	if(empty($b))
	{
		//操作日志
		insert_dolog("");
		printerror('ClearTagsSuccess','ClearTags.php');
	}
	echo"<meta http-equiv=\"refresh\" content=\"0;url=ClearTags.php?melve=ClearTags&line=$line&start=$newstart\">".$fun_r[OneClearTagsSuccess]."(ID:<font color=red><b>".$newstart."</b></font>)";
	exit();
}

$melve=$_GET['melve'];
if($melve)
{
	include("../../data/dbcache/class.php");
	include "../".LoadLang("pub/fun.php");
	ClearTags($_GET[start],$_GET[line],$logininid,$loginin);
}

db_close();
$Elves=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>TAGS</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>位置：<a href=ListTags.php>管理TAGS</a> &gt; 清理多余TAGS信息</td>
  </tr>
</table>
<form name="tagsclear" method="get" action="ClearTags.php" onsubmit="return confirm('确认要操作?');">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
    <tr class="header"> 
      <td height="25" colspan="2">清理多余TAGS信息 <input name=melve type=hidden value=ClearTags></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="19%" height="25">每组整理数：</td>
      <td width="81%" height="25"><input name="line" type="text" id="line" value="500"> 
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"><input type="submit" name="Submit" value="开始清理"> <input type="reset" name="Submit2" value="重置"></td>
    </tr>
  </table>
</form>
</body>
</html>