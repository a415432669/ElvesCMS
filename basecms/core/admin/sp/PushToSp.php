<?php
define('ElvesCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
require "../".LoadLang("pub/fun.php");
require("../../data/dbcache/class.php");
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

//推送信息
function PushInfoToSp($add,$userid,$username){
	global $Elves,$dbtbpre,$lur,$class_r;
	$classid=(int)$add['classid'];
	$tid=(int)$add['tid'];
	$spid=$add['spid'];
	$spcount=count($spid);
	$id=explode(',',$add[ids]);
	$count=count($id);
	if(!$count)
	{
		printerror('NotChangeSpInfo','');
	}
	if(!$spcount)
	{
		printerror('NotChangeSp','');
	}
	//表名
	$tbname='';
	if($classid)
	{
		$tbname=$class_r[$classid]['tbname'];
	}
	elseif($tid)
	{
		$tbr=$Elves->fetch1("select tbname from {$dbtbpre}melvetable where tid='$tid'");
		$tbname=$tbr['tbname'];
	}
	if(!$tbname)
	{
		printerror('ErrorUrl','');
	}
	//碎片
	$sps='';
	$dh='';
	for($spi=0;$spi<$spcount;$spi++)
	{
		$myspid=intval($spid[$spi]);
		if(!$myspid)
		{
			continue;
		}
		$spr=$Elves->fetch1("select spid,sptype,maxnum,groupid,userclass,username,isclose,cladd from {$dbtbpre}melvesp where spid='$myspid'");
		if(empty($spr[spid]))
		{
			continue;
		}
		if($spr[isclose])
		{
			continue;
		}
		if($spr[sptype]!=2)
		{
			continue;
		}
		if($spr[cladd]&&!CheckDoLevel($lur,$spr[groupid],$spr[userclass],$spr[username],1))
		{
			continue;
		}
		for($i=0;$i<$count;$i++)
		{
			$myid=intval($id[$i]);
			$infor=$Elves->fetch1("select classid,newstime from {$dbtbpre}elve_".$tbname."_index where id='$myid'");
			$rer=$Elves->fetch1("select sid from {$dbtbpre}melvesp_2 where spid='$myspid' and id='$myid' and classid='$infor[classid]' limit 1");
			if($rer['sid'])
			{
				$Elves->query("update {$dbtbpre}melvesp_2 set newstime='$infor[newstime]' where sid='".$rer['sid']."'");
			}
			else
			{
				$Elves->query("insert into {$dbtbpre}melvesp_2(spid,classid,id,newstime) values('$myspid','$infor[classid]','$myid','$infor[newstime]');");
			}
		}
		$sps.=$dh.$myspid;
		$dh=',';
		//删除多余碎片信息
		DelMoreSpInfo($myspid,$spr);
	}
	//操作日志
	insert_dolog("classid=$classid&tid=$tid<br>spid=".$sps."<br>id=".$add[ids]);
	echo"<script>alert('推送成功');window.close();</script>";
	exit();
}

//删除多余碎片信息
function DelMoreSpInfo($spid,$spr){
	global $Elves,$dbtbpre;
	if(!$spr[maxnum]||$spr[sptype]==3)
	{
		return '';
	}
	if($spr[sptype]==1)
	{
		$num=$Elves->gettotal("select count(*) as total from {$dbtbpre}melvesp_1 where spid='$spid'");
		if($num>$spr[maxnum])
		{
			$limitnum=$num-$spr[maxnum];
			$ids='';
			$dh='';
			$sql=$Elves->query("select sid from {$dbtbpre}melvesp_1 where spid='$spid' order by sid limit ".$limitnum);
			while($r=$Elves->fetch($sql))
			{
				$ids.=$dh.$r['sid'];
				$dh=',';
			}
			$Elves->query("delete from {$dbtbpre}melvesp_1 where sid in ($ids)");
		}
	}
	elseif($spr[sptype]==2)
	{
		$num=$Elves->gettotal("select count(*) as total from {$dbtbpre}melvesp_2 where spid='$spid'");
		if($num>$spr[maxnum])
		{
			$limitnum=$num-$spr[maxnum];
			$ids='';
			$dh='';
			$sql=$Elves->query("select sid from {$dbtbpre}melvesp_2 where spid='$spid' order by sid limit ".$limitnum);
			while($r=$Elves->fetch($sql))
			{
				$ids.=$dh.$r['sid'];
				$dh=',';
			}
			$Elves->query("delete from {$dbtbpre}melvesp_2 where sid in ($ids)");
		}
	}
}

$melve=$_POST['melve'];
if(empty($melve))
{$melve=$_GET['melve'];}
if($melve=='PushInfoToSp')//增加碎片
{
	PushInfoToSp($_POST,$logininid,$loginin);
}

//审核表
$addelvecheck='';
$elvecheck=(int)$_GET['elvecheck'];
$indexchecked=1;
if($elvecheck)
{
	$addelvecheck='&elvecheck='.$elvecheck;
	$indexchecked=0;
}

$add='';
//分类
$cid=(int)$_GET['cid'];
if($cid)
{
	$add.=" and cid='$cid'";
}
//栏目
$classid=(int)$_GET['classid'];
if($classid)
{
	$classwhere=ReturnClass($class_r[$classid][featherclass]);
	$add.=" and (classid=0 or classid='$classid' or (".$classwhere."))";
}
//表ID
$tid=(int)$_GET['tid'];
//ID
$ids=$_GET['id'];
if(!$ids)
{
	echo"<script>alert('请选择信息');window.close();</script>";
	exit();
}
$query="select spid,spname,varname,sppic,spsay from {$dbtbpre}melvesp where sptype=2 and isclose=0 and (cladd=0 or (cladd=1 and (groupid like '%,".$lur[groupid].",%' or userclass like '%,".$lur[classid].",%' or username like '%,".$lur[username].",%')))".$add." order by spid desc";
$sql=$Elves->query($query);
//分类
$scstr="";
$scsql=$Elves->query("select classid,classname from {$dbtbpre}melvespclass order by classid");
while($scr=$Elves->fetch($scsql))
{
	$select="";
	if($scr[classid]==$cid)
	{
		$select=" selected";
	}
	$scstr.="<option value='".$scr[classid]."'".$select.">".$scr[classname]."</option>";
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>推送信息到碎片</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" cellspacing="1" cellpadding="3">
  <tr> 
    <td>位置: 推送信息到碎片 
      <div align="right"> </div></td>
  </tr>
</table>

<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
<form name="searchform" method="GET" action="PushToSp.php">
  <tr> 
      <td> 选择分类： 
        <select name="select" id="select" onchange=window.location='PushToSp.php?classid=<?=$classid?>&tid=<?=$tid?>&id=<?=$ids?>&cid='+this.options[this.selectedIndex].value>
          <option value="0">所有分类</option>
          <?=$scstr?>
        </select></td>
  </tr>
</form>
</table>
<form name="form1" method="post" action="PushToSp.php">
  <table width="100%" border="0" cellspacing="1" cellpadding="3">
    <tr>
      <td>推送信息ID：<?=$ids?></td>
    </tr>
  </table>
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
    <tr class="header"> 
      <td width="26%"><div align="center">选择</div></td>
      <td width="74%" height="25"> <div align="center">碎片名称</div></td>
    </tr>
    <?
  while($r=$Elves->fetch($sql))
  {
	if($r[sptype]==1)
	{
		$sptype='静态信息';
	}
	elseif($r[sptype]==2)
	{
		$sptype='动态信息';
	}
	else
	{
		$sptype='代码碎片';
	}
	$sppic='';
	if($r[sppic])
	{
		$sppic='<a href="'.$r[sppic].'" title="碎片效果图" target="_blank"><img src="../../data/images/showimg.gif" border=0></a>';
	}
  ?>
    <tr bgcolor="#FFFFFF" id="chsp<?=$r[spid]?>"> 
      <td><div align="center"> 
          <input name="spid[]" type="checkbox" id="spid[]" value="<?=$r[spid]?>" onClick="if(this.checked){chsp<?=$r[spid]?>.style.backgroundColor='#DBEAF5';}else{chsp<?=$r[spid]?>.style.backgroundColor='#ffffff';}">
        </div></td>
      <td height="25"> 
        <?=$sppic?>
        <a title="<?=$r[spsay]?>"> 
        <?=$r[spname]?>
        </a> </td>
    </tr>
    <?
  }
  ?>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" colspan="2"><div align="center">
          <input type="submit" name="Submit2" value="确定推送">
          &nbsp;&nbsp;<input type="button" name="Submit3" value="取消" onclick="window.close();">
          <input name="melve" type="hidden" id="melve" value="PushInfoToSp">
          <input name="classid" type="hidden" id="classid" value="<?=$classid?>">
          <input name="tid" type="hidden" id="tid" value="<?=$tid?>">
          <input name="ids" type="hidden" id="ids" value="<?=$ids?>">
		  <input name="elvecheck" type="hidden" id="elvecheck" value="<?=$elvecheck?>">
        </div></td>
    </tr>
  </table>
</form>
</body>
</html>
<?
db_close();
$Elves=null;
?>
