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
CheckLevel($logininid,$loginin,$classid,"votemod");

//增加预设投票
function AddVoteMod($ysvotename,$title,$votename,$votenum,$delvid,$vid,$voteclass,$doip,$dotime,$width,$height,$tempid,$userid,$username){
	global $Elves,$dbtbpre;
	if(!$ysvotename||!$tempid)
	{
		printerror("EmptyVoteTitle","history.go(-1)");
	}
	//返回组合
	$votetext=ReturnVote($votename,$votenum,$delvid,$vid,0);
	//统计总票数
	for($i=0;$i<count($votename);$i++)
	{
		$t_votenum+=$votenum[$i];
	}
	$dotime=date("Y-m-d");
	$t_votenum=(int)$t_votenum;
	$voteclass=(int)$voteclass;
	$width=(int)$width;
	$height=(int)$height;
	$doip=(int)$doip;
	$tempid=(int)$tempid;
	$sql=$Elves->query("insert into {$dbtbpre}melvevotemod(title,votetext,voteclass,doip,dotime,tempid,width,height,votenum,ysvotename) values('$title','$votetext',$voteclass,$doip,'$dotime',$tempid,$width,$height,$t_votenum,'$ysvotename');");
	$voteid=$Elves->lastid();
	if($sql)
	{
		//操作日志
		insert_dolog("voteid=".$voteid."<br>title=".$title);
		printerror("AddVoteSuccess","AddVoteMod.php?melve=AddVoteMod");
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//修改预设投票
function EditVoteMod($voteid,$ysvotename,$title,$votename,$votenum,$delvid,$vid,$voteclass,$doip,$dotime,$width,$height,$tempid,$userid,$username){
	global $Elves,$dbtbpre;
	$voteid=(int)$voteid;
	if(!$voteid||!$ysvotename||!$tempid)
	{
		printerror("EmptyVoteTitle","history.go(-1)");
	}
	//返回组合
	$votetext=ReturnVote($votename,$votenum,$delvid,$vid,1);
	//统计总票数
	for($i=0;$i<count($votename);$i++)
	{
		$t_votenum+=$votenum[$i];
	}
	//处理变量
	$t_votenum=(int)$t_votenum;
	$voteclass=(int)$voteclass;
	$width=(int)$width;
	$height=(int)$height;
	$doip=(int)$doip;
	$tempid=(int)$tempid;
	$sql=$Elves->query("update {$dbtbpre}melvevotemod set title='$title',votetext='$votetext',voteclass=$voteclass,doip=$doip,dotime='$dotime',tempid=$tempid,width=$width,height=$height,votenum=$t_votenum,ysvotename='$ysvotename' where voteid='$voteid'");
	if($sql)
	{
		//操作日志
		insert_dolog("voteid=".$voteid."<br>title=".$title);
		printerror("EditVoteSuccess","ListVoteMod.php");
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//删除预设投票
function DelVoteMod($voteid,$userid,$username){
	global $Elves,$dbtbpre;
	$voteid=(int)$voteid;
	if(!$voteid)
	{
		printerror("NotDelVoteid","history.go(-1)");
	}
	$r=$Elves->fetch1("select title from {$dbtbpre}melvevotemod where voteid='$voteid'");
	$sql=$Elves->query("delete from {$dbtbpre}melvevotemod where voteid='$voteid'");
	if($sql)
	{
		//操作日志
		insert_dolog("voteid=".$voteid."<br>title=".$r[title]);
		printerror("DelVoteSuccess","ListVoteMod.php");
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}


$melve=$_POST['melve'];
if(empty($melve))
{$melve=$_GET['melve'];}
//增加投票
if($melve=="AddVoteMod")
{
	$title=$_POST['title'];
	$votename=$_POST['votename'];
	$votenum=$_POST['votenum'];
	$delvid=$_POST['delvid'];
	$vid=$_POST['vid'];
	$voteclass=$_POST['voteclass'];
	$doip=$_POST['doip'];
	$dotime=$_POST['dotime'];
	$width=$_POST['width'];
	$height=$_POST['height'];
	$tempid=$_POST['tempid'];
	$ysvotename=$_POST['ysvotename'];
	AddVoteMod($ysvotename,$title,$votename,$votenum,$delvid,$vid,$voteclass,$doip,$dotime,$width,$height,$tempid,$logininid,$loginin);
}
//修改投票
elseif($melve=="EditVoteMod")
{
	$voteid=$_POST['voteid'];
	$title=$_POST['title'];
	$votename=$_POST['votename'];
	$votenum=$_POST['votenum'];
	$delvid=$_POST['delvid'];
	$vid=$_POST['vid'];
	$voteclass=$_POST['voteclass'];
	$doip=$_POST['doip'];
	$dotime=$_POST['dotime'];
	$width=$_POST['width'];
	$height=$_POST['height'];
	$tempid=$_POST['tempid'];
	$ysvotename=$_POST['ysvotename'];
	EditVoteMod($voteid,$ysvotename,$title,$votename,$votenum,$delvid,$vid,$voteclass,$doip,$dotime,$width,$height,$tempid,$logininid,$loginin);
}
//删除投票
elseif($melve=="DelVoteMod")
{
	$voteid=$_GET['voteid'];
	DelVoteMod($voteid,$logininid,$loginin);
}

$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$line=20;//每页显示条数
$page_line=12;//每页显示链接数
$offset=$page*$line;//总偏移量
$query="select voteid,ysvotename,title,voteclass from {$dbtbpre}melvevotemod";
$num=$Elves->num($query);//取得总条数
$query=$query." order by voteid desc limit $offset,$line";
$sql=$Elves->query($query);
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
$url="<a href=ListVoteMod.php>管理预设投票</a>";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>投票</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" cellspacing="1" cellpadding="3">
  <tr> 
    <td width="50%">位置: 
      <?=$url?>
    </td>
    <td><div align="right" class="emenubutton">
        <input type="button" name="Submit5" value="增加预设投票" onclick="self.location.href='AddVoteMod.php?melve=AddVoteMod';">
      </div></td>
  </tr>
</table>
<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr class="header"> 
    <td width="10%" height="25"><div align="center">ID</div></td>
    <td width="43%" height="25"><div align="center">投票名称</div></td>
    <td width="18%" height="25"><div align="center">类型</div></td>
    <td width="29%" height="25"><div align="center">操作</div></td>
  </tr>
  <?
  while($r=$Elves->fetch($sql))
  {
  	$voteclass=empty($r['voteclass'])?'单选':'多选';
  ?>
  <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor='#ffffff'" onmouseover="this.style.backgroundColor='#C3EFFF'"> 
    <td height="25"><div align="center"> 
        <?=$r[voteid]?>
      </div></td>
    <td height="25"> 
      <?=$r[ysvotename]?>
    </td>
    <td height="25"><div align="center"> 
        <?=$voteclass?>
      </div></td>
    <td height="25"><div align="center">[<a href="AddVoteMod.php?melve=EditVoteMod&voteid=<?=$r[voteid]?>">修改</a>] 
        [<a href="ListVoteMod.php?melve=DelVoteMod&voteid=<?=$r[voteid]?>" onclick="return confirm('确认要删除?');">删除</a>]</div></td>
  </tr>
  <?
  }
  ?>
  <tr bgcolor="#FFFFFF"> 
    <td height="25" colspan="4">&nbsp; 
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
