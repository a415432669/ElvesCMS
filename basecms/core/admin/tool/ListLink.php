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
CheckLevel($logininid,$loginin,$classid,"link");

//------------------增加友情链接
function AddLink($add,$userid,$username){
	global $Elves,$dbtbpre;
	if(!$add[lname]||!$add[lurl])
	{printerror("EmptyLname","history.go(-1)");}
	//验证权限
	CheckLevel($userid,$username,$classid,"link");
	$ltime=date("Y-m-d H:i:s");
	$add[lname]=hRepPostStr($add[lname],1);
	$add[lpic]=hRepPostStr($add[lpic],1);
	$add[lurl]=hRepPostStr($add[lurl],1);
	$add[email]=hRepPostStr($add[email],1);
	$add[onclick]=(int)$add[onclick];
	$add[myorder]=(int)$add[myorder];
	$add[ltype]=(int)$add[ltype];
	$add[checked]=(int)$add[checked];
	$add[classid]=(int)$add[classid];
	$add[cid]=(int)$add[cid];
	$sql=$Elves->query("insert into {$dbtbpre}melvelink(lname,lpic,lurl,ltime,onclick,width,height,target,myorder,email,lsay,ltype,checked,classid) values('".$add[lname]."','".$add[lpic]."','".$add[lurl]."','$ltime',$add[onclick],'$add[width]','$add[height]','$add[target]',$add[myorder],'".$add[email]."','".eaddslashes($add[lsay])."',$add[ltype],$add[checked],$add[classid]);");
	$lastid=$Elves->lastid();
	if($sql)
	{
		//操作日志
		insert_dolog("lid=".$lastid."<br>lname=".$add[lname]);
		printerror("AddLinkSuccess","AddLink.php?melve=AddLink&cid=$add[cid]");
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//----------------修改友情链接
function EditLink($add,$userid,$username){
	global $Elves,$dbtbpre;
	$add[lid]=(int)$add[lid];
	if(!$add[lname]||!$add[lurl]||!$add[lid])
	{printerror("EmptyLname","history.go(-1)");}
	//验证权限
	CheckLevel($userid,$username,$classid,"link");
	$add[lname]=hRepPostStr($add[lname],1);
	$add[lpic]=hRepPostStr($add[lpic],1);
	$add[lurl]=hRepPostStr($add[lurl],1);
	$add[email]=hRepPostStr($add[email],1);
	$add[onclick]=(int)$add[onclick];
	$add[myorder]=(int)$add[myorder];
	$add[ltype]=(int)$add[ltype];
	$add[checked]=(int)$add[checked];
	$add[classid]=(int)$add[classid];
	$add[cid]=(int)$add[cid];
	$sql=$Elves->query("update {$dbtbpre}melvelink set lname='".$add[lname]."',lpic='".$add[lpic]."',lurl='".$add[lurl]."',onclick=$add[onclick],width='$add[width]',height='$add[height]',target='$add[target]',myorder=$add[myorder],email='".$add[email]."',lsay='".eaddslashes($add[lsay])."',ltype=$add[ltype],checked=$add[checked],classid=$add[classid] where lid='$add[lid]'");
	if($sql)
	{
		//操作日志
		insert_dolog("lid=".$add[lid]."<br>lname=".$add[lname]);
		printerror("EditLinkSuccess","ListLink.php?classid=$add[cid]");
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//---------------删除友情链接
function DelLink($lid,$cid,$userid,$username){
	global $Elves,$dbtbpre;
	$lid=(int)$lid;
	$cid=(int)$cid;
	if(!$lid)
	{printerror("EmptyLid","history.go(-1)");}
	//验证权限
	CheckLevel($userid,$username,$classid,"link");
	$r=$Elves->fetch1("select lname from {$dbtbpre}melvelink where lid='$lid'");
	$sql=$Elves->query("delete from {$dbtbpre}melvelink where lid='$lid'");
	if($sql)
	{
		//操作日志
		insert_dolog("lid=".$lid."<br>lname=".$r[lname]);
		printerror("DelLinkSuccess","ListLink.php?classid=$cid");
	}
	else
	{printerror("DbError","history.go(-1)");}
}

$melve=$_POST['melve'];
if(empty($melve))
{$melve=$_GET['melve'];}
if($melve=="AddLink")
{
	AddLink($_POST,$logininid,$loginin);
}
elseif($melve=="EditLink")
{
	EditLink($_POST,$logininid,$loginin);
}
elseif($melve=="DelLink")
{
	$lid=$_GET['lid'];
	$cid=$_GET['cid'];
	DelLink($lid,$cid,$logininid,$loginin);
}
else
{}
$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$line=16;//每页显示条数
$page_line=25;//每页显示链接数
$offset=$page*$line;//总偏移量
$query="select * from {$dbtbpre}melvelink";
$totalquery="select count(*) as total from {$dbtbpre}melvelink";
//类别
$add="";
$classid=(int)$_GET['classid'];
if($classid)
{
	$add=" where classid=$classid";
	$search="&classid=$classid";
}
$query.=$add;
$totalquery.=$add;
$num=$Elves->gettotal($totalquery);//取得总条数
$query=$query." order by myorder,lid limit $offset,$line";
$sql=$Elves->query($query);
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
//类别
$cstr="";
$csql=$Elves->query("select classid,classname from {$dbtbpre}melvelinkclass order by classid");
while($cr=$Elves->fetch($csql))
{
	$select="";
	if($cr[classid]==$classid)
	{
		$select=" selected";
	}
	$cstr.="<option value='".$cr[classid]."'".$select.">".$cr[classname]."</option>";
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<title>管理友情链接</title>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td width="50%" height="25">位置：<a href="ListLink.php">管理友情链接</a></td>
    <td><div align="right" class="emenubutton">
        <input type="button" name="Submit5" value="增加友情链接" onclick="self.location.href='AddLink.php?melve=AddLink';">
      </div></td>
  </tr>
</table>

<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td> 选择类别： 
      <select name="classid" id="classid" onchange=window.location='ListLink.php?classid='+this.options[this.selectedIndex].value>
        <option value="0">显示所有类别</option>
        <?=$cstr?>
      </select> </td>
  </tr>
</table>
<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td width="6%" height="25"> <div align="center">ID</div></td>
    <td width="51%" height="25"> <div align="center">预览</div></td>
    <td width="11%" height="25"> <div align="center">点击</div></td>
    <td width="12%"><div align="center">状态</div></td>
    <td width="20%" height="25"> <div align="center">操作</div></td>
  </tr>
  <?
  while($r=$Elves->fetch($sql))
  {
  //文字
  if(empty($r[lpic]))
  {
  $logo="<a href='".$r[lurl]."' title='".$r[lname]."' target=".$r[target].">".$r[lname]."</a>";
  }
  //图片
  else
  {
  $logo="<a href='".$r[lurl]."' target=".$r[target]."><img src='".$r[lpic]."' alt='".$r[lname]."' border=0 width='".$r[width]."' height='".$r[height]."'></a>";
  }
  if(empty($r[checked]))
  {$checked="关闭";}
  else
  {$checked="显示";}
  ?>
  <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
    <td height="25"> <div align="center"> 
        <?=$r[lid]?>
      </div></td>
    <td height="25"> <div align="center"> 
        <?=$logo?>
      </div></td>
    <td height="25"> <div align="center"> 
        <?=$r[onclick]?>
      </div></td>
    <td><div align="center"><?=$checked?></div></td>
    <td height="25"> <div align="center">[<a href="AddLink.php?melve=EditLink&lid=<?=$r[lid]?>&cid=<?=$classid?>">修改</a>]&nbsp;[<a href="ListLink.php?melve=DelLink&lid=<?=$r[lid]?>&cid=<?=$classid?>" onclick="return confirm('确认要删除？');">删除</a>]</div></td>
  </tr>
  <?
  }
  ?>
  <tr bgcolor="#FFFFFF"> 
    <td height="25" colspan="5">&nbsp;&nbsp;&nbsp; 
      <?=$returnpage?>
    </td>
  </tr>
</table>
</body>
</html>
<?
db_close();
$Elves=null;
?>
