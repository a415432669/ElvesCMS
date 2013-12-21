<?php
define('ElvesCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
require "../".LoadLang("pub/fun.php");
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
CheckLevel($logininid,$loginin,$classid,"template");

//增加首页方案
function AddIndexpage($add,$userid,$username){
	global $Elves,$dbtbpre;
	if(!$add[tempname]||!$add[temptext])
	{
		printerror("EmptyIndexpageName","history.go(-1)");
	}
	//验证权限
	CheckLevel($userid,$username,$classid,"template");
	$gid=(int)$add['gid'];
	$add[tempname]=hRepPostStr($add[tempname],1);
	$add[temptext]=RepPhpAspJspcode($add[temptext]);
	$sql=$Elves->query("insert into {$dbtbpre}melveindexpage(tempname,temptext) values('".$add[tempname]."','".eaddslashes2($add[temptext])."');");
	$tempid=$Elves->lastid();
	//备份模板
	AddEBakTemp('indexpage',1,$tempid,$add[tempname],$add[temptext],0,0,'',0,0,'',0,0,0,$userid,$username);
	if($sql)
	{
		//操作日志
		insert_dolog("tempid=$tempid&tempname=$add[tempname]");
		printerror("AddIndexpageSuccess","AddIndexpage.php?melve=AddIndexpage&gid=$gid");
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//修改首页方案
function EditIndexpage($add,$userid,$username){
	global $Elves,$dbtbpre,$public_r;
	$tempid=(int)$add[tempid];
	if(!$tempid||!$add[tempname]||!$add[temptext])
	{
		printerror("EmptyIndexpageName","history.go(-1)");
	}
	//验证权限
	CheckLevel($userid,$username,$classid,"template");
	$gid=(int)$add['gid'];
	$add[tempname]=hRepPostStr($add[tempname],1);
	$add[temptext]=RepPhpAspJspcode($add[temptext]);
	$sql=$Elves->query("update {$dbtbpre}melveindexpage set tempname='".$add[tempname]."',temptext='".eaddslashes2($add[temptext])."' where tempid='$tempid'");
	//备份模板
	AddEBakTemp('indexpage',1,$tempid,$add[tempname],$add[temptext],0,0,'',0,0,'',0,0,0,$userid,$username);
	//刷新首页
	if($tempid==$public_r['indexpageid'])
	{
		NewsBq($classid,eaddslashes($add[temptext]),1,0);
		//删除动态模板缓存文件
		DelOneTempTmpfile('indexpage');
	}
	if($sql)
	{
		//操作日志
		insert_dolog("tempid=$tempid&tempname=$add[tempname]");
		printerror("EditIndexpageSuccess","ListIndexpage.php?gid=$gid");
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//删除首页方案
function DelIndexpage($tempid,$userid,$username){
	global $Elves,$dbtbpre,$public_r;
	$tempid=(int)$tempid;
	if(empty($tempid))
	{
		printerror("NotChangeIndexpageid","history.go(-1)");
	}
	//验证权限
	CheckLevel($userid,$username,$classid,"template");
	$gid=(int)$_GET['gid'];
	$r=$Elves->fetch1("select tempname from {$dbtbpre}melveindexpage where tempid='$tempid'");
	$sql=$Elves->query("delete from {$dbtbpre}melveindexpage where tempid='$tempid'");
	if($tempid==$public_r['indexpageid'])
	{
		$Elves->query("update {$dbtbpre}melvepublic set indexpageid=0");
		GetConfig();//更新缓存
	}
	//删除备份记录
	DelEbakTempAll('indexpage',1,$tempid);
	//刷新首页
	if($tempid==$public_r['indexpageid'])
	{
		$indextempr=$Elves->fetch1("select indextemp from ".GetTemptb("melvepubtemp")." limit 1");
		$indextemp=$indextempr['indextemp'];
		NewsBq($classid,$indextemp,1,0);
		//删除动态模板缓存文件
		DelOneTempTmpfile('indexpage');
	}
	if($sql)
	{
		//操作日志
		insert_dolog("tempid=$tempid&tempname=$r[tempname]");
		printerror("DelIndexpageSuccess","ListIndexpage.php?gid=$gid");
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//启用首页方案
function DefIndexpage($tempid,$userid,$username){
	global $Elves,$dbtbpre,$public_r;
	$tempid=(int)$tempid;
	if(empty($tempid))
	{
		printerror("NotChangeIndexpageid","history.go(-1)");
	}
	//验证权限
	CheckLevel($userid,$username,$classid,"template");
	$gid=(int)$_GET['gid'];
	$r=$Elves->fetch1("select tempname,temptext from {$dbtbpre}melveindexpage where tempid='$tempid'");
	if($tempid==$public_r['indexpageid'])
	{
		$def=0;
		$mess='NoDefIndexpageSuccess';
		$sql=$Elves->query("update {$dbtbpre}melvepublic set indexpageid=0");
	}
	else
	{
		$def=1;
		$mess='DefIndexpageSuccess';
		$sql=$Elves->query("update {$dbtbpre}melvepublic set indexpageid='$tempid'");
	}
	GetConfig();//更新缓存
	//刷新首页
	if($def)
	{
		NewsBq($classid,$r[temptext],1,0);
		//删除动态模板缓存文件
		DelOneTempTmpfile('indexpage');
	}
	else
	{
		$indextempr=$Elves->fetch1("select indextemp from ".GetTemptb("melvepubtemp")." limit 1");
		$indextemp=$indextempr['indextemp'];
		NewsBq($classid,$indextemp,1,0);
		//删除动态模板缓存文件
		DelOneTempTmpfile('indexpage');
	}
	if($sql)
	{
		//操作日志
		insert_dolog("tempid=$tempid&tempname=$r[tempname]&def=$def");
		printerror($mess,"ListIndexpage.php?gid=$gid");
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//操作
$melve=$_POST['melve'];
if(empty($melve))
{$melve=$_GET['melve'];}
if($melve)
{
	include("../../class/t_functions.php");
	include("../../data/dbcache/class.php");
	include("../../data/dbcache/MemberLevel.php");
	include("../../class/tempfun.php");
}
//增加首页方案
if($melve=="AddIndexpage")
{
	AddIndexpage($_POST,$logininid,$loginin);
}
//修改首页方案
elseif($melve=="EditIndexpage")
{
	EditIndexpage($_POST,$logininid,$loginin);
}
//删除首页方案
elseif($melve=="DelIndexpage")
{
	DelIndexpage($_GET['tempid'],$logininid,$loginin);
}
//启用首页方案
elseif($melve=="DefIndexpage")
{
	DefIndexpage($_GET['tempid'],$logininid,$loginin);
}

$gid=(int)$_GET['gid'];
$url="<a href=ListIndexpage.php?gid=$gid>管理首页方案</a>";
$search="&gid=$gid";
$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$line=25;//每页显示条数
$page_line=12;//每页显示链接数
$offset=$page*$line;//总偏移量
$query="select tempid,tempname from {$dbtbpre}melveindexpage";
$totalquery="select count(*) as total from {$dbtbpre}melveindexpage";
$num=$Elves->gettotal($totalquery);//取得总条数
$query=$query." order by tempid desc limit $offset,$line";
$sql=$Elves->query($query);
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>管理首页方案</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td width="50%">位置： 
      <?=$url?>
    </td>
    <td><div align="right" class="emenubutton"> 
        <input type="button" name="Submit5" value="增加首页方案" onclick="self.location.href='AddIndexpage.php?melve=AddIndexpage&gid=<?=$gid?>';">
      </div></td>
  </tr>
</table>
  
<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td width="5%" height="25"><div align="center">ID</div></td>
    <td width="49%" height="25"><div align="center">方案名称</div></td>
    <td width="17%"><div align="center">启用/取消</div></td>
    <td width="29%" height="25"><div align="center">操作</div></td>
  </tr>
  <?php
  while($r=$Elves->fetch($sql))
  {
  	//默认方案
	if($public_r['indexpageid']==$r['tempid'])
	{
		$bgcolor='#DBEAF5';
		$openindexpage='取消此方案';
		$movejs='';
	}
	else
	{
		$bgcolor='#ffffff';
		$openindexpage='启用此方案';
		$movejs=' onmouseout="this.style.backgroundColor=\'#ffffff\'" onmouseover="this.style.backgroundColor=\'#C3EFFF\'"';
	}
  ?>
  <tr bgcolor="<?=$bgcolor?>"<?=$movejs?>> 
    <td height="25"><div align="center"> 
        <?=$r[tempid]?>
      </div></td>
    <td height="25"><div align="center"> 
        <?=$r[tempname]?>
      </div></td>
    <td><div align="center"> <a href="ListIndexpage.php?melve=DefIndexpage&tempid=<?=$r[tempid]?>&gid=<?=$gid?>" onclick="return confirm('确定设置?');"><?=$openindexpage?></a></div></td>
    <td height="25"><div align="center"> [<a href="AddIndexpage.php?melve=EditIndexpage&tempid=<?=$r[tempid]?>&gid=<?=$gid?>">修改</a>] 
        [<a href="AddIndexpage.php?melve=AddIndexpage&docopy=1&tempid=<?=$r[tempid]?>&gid=<?=$gid?>">复制</a>] 
        [<a href="../elvetemp.php?melve=PreviewIndexpage&tempid=<?=$r[tempid]?>&gid=<?=$gid?>" target="_blank">预览</a>] 
        [<a href="ListIndexpage.php?melve=DelIndexpage&tempid=<?=$r[tempid]?>&gid=<?=$gid?>" onclick="return confirm('确认要删除？');">删除</a>]</div></td>
  </tr>
  <?
  }
  ?>
  <tr bgcolor="ffffff"> 
    <td height="25" colspan="4">&nbsp; 
      <?=$returnpage?>
    </td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td height="25"><font color="#666666">说明：首页方案：可以将某一方案作为临时首页，特别是在节假日制作特别首页非常有用。全部取消时为使用默认首页模板。</font></td>
  </tr>
</table>
</body>
</html>
<?
db_close();
$Elves=null;
?>