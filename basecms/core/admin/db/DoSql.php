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
CheckLevel($logininid,$loginin,$classid,"execsql");

//执行SQL语句
function DoExecSql($add,$userid,$username){
	global $Elves,$dbtbpre;
	$dosave=(int)$add['dosave'];
	$query=$add['query'];
	if(!$query)
	{
		printerror("EmptyDoSqlQuery","history.go(-1)");
    }
	if($dosave==1&&!$add['sqlname'])
	{
		printerror("EmptySqltext","history.go(-1)");
	}
	$query=ClearAddsData($query);
	//保存
	if($dosave==1)
	{
		$add['sqlname']=hRepPostStr($add['sqlname'],1);
		$isql=$Elves->query("insert into {$dbtbpre}melvesql(sqlname,sqltext) values('".$add['sqlname']."','".addslashes($query)."');");
	}
	$query=RepSqlTbpre($query);
	DoRunQuery($query);
	//操作日志
	insert_dolog("query=".$query);
	printerror("DoExecSqlSuccess","DoSql.php");
}

//运行SQL
function DoRunQuery($sql){
	global $Elves;
	$sql=str_replace("\r","\n",$sql);
	$ret=array();
	$num=0;
	foreach(explode(";\n",trim($sql)) as $query)
	{
		$queries=explode("\n",trim($query));
		foreach($queries as $query)
		{
			$ret[$num].=$query[0]=='#'||$query[0].$query[1]=='--'?'':$query;
		}
		$num++;
	}
	unset($sql);
	foreach($ret as $query)
	{
		$query=trim($query);
		if($query)
		{
			$Elves->query($query);
		}
	}
}

//增加SQL语句
function AddSql($add,$userid,$username){
	global $Elves,$dbtbpre;
	if(!$add['sqlname']||!$add['sqltext'])
	{
		printerror("EmptySqltext","history.go(-1)");
	}
	$add['sqlname']=hRepPostStr($add['sqlname'],1);
	$add[sqltext]=ClearAddsData($add[sqltext]);
	$sql=$Elves->query("insert into {$dbtbpre}melvesql(sqlname,sqltext) values('".$add['sqlname']."','".addslashes($add[sqltext])."');");
	$lastid=$Elves->lastid();
	if($sql)
	{
		//操作日志
		insert_dolog("id=".$lastid."<br>sqlname=".$add[sqlname]);
		printerror("AddSqlSuccess","AddSql.php?melve=AddSql");
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//修改SQL语句
function EditSql($add,$userid,$username){
	global $Elves,$dbtbpre;
	$id=(int)$add[id];
	if(!$add['sqlname']||!$add['sqltext']||!$id)
	{
		printerror("EmptySqltext","history.go(-1)");
	}
	$add['sqlname']=hRepPostStr($add['sqlname'],1);
	$add[sqltext]=ClearAddsData($add[sqltext]);
	$sql=$Elves->query("update {$dbtbpre}melvesql set sqlname='".$add['sqlname']."',sqltext='".addslashes($add[sqltext])."' where id='$id'");
	if($sql)
	{
		//操作日志
		insert_dolog("id=".$id."<br>sqlname=".$add[sqlname]);
		printerror("EditSqlSuccess","ListSql.php");
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//删除SQL语句
function DelSql($id,$userid,$username){
	global $Elves,$dbtbpre;
	$id=(int)$id;
	if(!$id)
	{
		printerror("EmptySqlid","history.go(-1)");
	}
	$r=$Elves->fetch1("select sqlname from {$dbtbpre}melvesql where id='$id'");
	$sql=$Elves->query("delete from {$dbtbpre}melvesql where id='$id'");
	if($sql)
	{
		//操作日志
		insert_dolog("id=".$id."<br>sqlname=".$r[sqlname]);
		printerror("DelSqlSuccess","ListSql.php");
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//运行SQL语句
function ExecSql($id,$userid,$username){
	global $Elves,$dbtbpre;
	$id=(int)$id;
	if(empty($id))
	{
		printerror('EmptyExecSqlid','');
	}
	$r=$Elves->fetch1("select sqltext from {$dbtbpre}melvesql where id='$id'");
	if(!$r['sqltext'])
	{
		printerror('EmptyExecSqlid','');
    }
	$query=RepSqlTbpre($r['sqltext']);
	DoRunQuery($query);
	//操作日志
	insert_dolog("query=".$query);
	printerror("DoExecSqlSuccess","ListSql.php");
}

$melve=$_POST['melve'];
if(empty($melve))
{$melve=$_GET['melve'];}
//执行SQL语句
if($melve=='DoExecSql')
{
	DoExecSql($_POST,$logininid,$loginin);
}
elseif($melve=='AddSql')//增加
{
	AddSql($_POST,$logininid,$loginin);
}
elseif($melve=='EditSql')//修改
{
	EditSql($_POST,$logininid,$loginin);
}
elseif($melve=='DelSql')//删除
{
	DelSql($_GET['id'],$logininid,$loginin);
}
elseif($melve=='ExecSql')//执行
{
	ExecSql($_GET['id'],$logininid,$loginin);
}

$url="<a href=DoSql.php>执行SQL语句</a>";
db_close();
$Elves=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>执行SQL语句</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td height="25">位置：
      <?=$url?>
    </td>
    <td width="50%"><div align="right" class="emenubutton"> 
        <input type="button" name="Submit5" value="增加SQL语句" onclick="self.location.href='AddSql.php?melve=AddSql';">&nbsp;&nbsp;
        <input type="button" name="Submit4" value="管理SQL语句" onclick="self.location.href='ListSql.php';">
      </div></td>
  </tr>
</table>

<form action="DoSql.php" method="POST" name="sqlform" onsubmit="return confirm('确认要执行？');">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
    <tr class="header"> 
      <td height="25"><div align="center">执行SQL语句</div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><div align="center">(多条语句请用&quot;回车&quot;格开,每条语句以&quot;;&quot;结束，数据表前缀可用：“[!db.pre!]&quot;表示)</div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><div align="center"> 
          <textarea name="query" cols="90" rows="12" id="query"></textarea>
        </div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><div align="center"> 
          <input type="submit" name="Submit" value=" 执行SQL">
          &nbsp;&nbsp; 
          <input type="reset" name="Submit2" value="重置">
          <input name="melve" type="hidden" id="melve" value="DoExecSql" onclick="document.sqlform.dosave.value=0;">
          <input name="dosave" type="hidden" id="dosave" value="0">
        </div></td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF"><div align="center">SQL名称： 
          <input name="sqlname" type="text" id="sqlname">
          <input type="submit" name="Submit3" value="执行SQL并保存" onclick="document.sqlform.dosave.value=1;">
        </div></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF"><div align="center">此功能影响到整个系统的数据,请慎用.</div></td>
    </tr>
  </table>
  </form>
</body>
</html>
