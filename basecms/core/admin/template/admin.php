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
$loginlevel=(int)$lur['groupid'];
$loginadminstyleid=(int)$lur['adminstyleid'];
$r=ReturnLeftLevel($loginlevel);
//模板组
$gid=(int)$_GET['gid'];
if(!$gid)
{
	if($elve_config['sets']['deftempid'])
	{
		$gid=$elve_config['sets']['deftempid'];
	}
	elseif($public_r['deftempid'])
	{
		$gid=$public_r['deftempid'];
	}
	else
	{
		$gid=1;
	}
}
$tempgroup="";
$tgname="";
$tgsql=$Elves->query("select gid,gname,isdefault from {$dbtbpre}melvetempgroup order by gid");
while($tgr=$Elves->fetch($tgsql))
{
	$tgselect="";
	if($tgr['gid']==$gid)
	{
		$tgname=$tgr['gname'];
		$tgselect=" selected";
	}
	$tempgroup.="<option value='".$tgr['gid']."'".$tgselect.">".$tgr['gname']."</option>";
}
if(empty($tgname))
{
	printerror("ErrorUrl","");
}
require("../adminstyle/".$loginadminstyleid."/AdminTemp.php");
db_close();
$Elves=null;
?>