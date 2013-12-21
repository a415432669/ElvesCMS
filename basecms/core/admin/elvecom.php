<?php
define('ElvesCMSAdmin','1');
require("../class/connect.php");
require("../class/db_sql.php");
require("../class/functions.php");
require LoadLang("pub/fun.php");
require("../class/t_functions.php");
require("../data/dbcache/class.php");
require("../data/dbcache/MemberLevel.php");
$link=db_connect();
$Elves=new mysqlquery();
$melve=$_POST['melve'];
if(empty($melve))
{
	$melve=$_GET['melve'];
}
//验证用户
$lur=is_login();
$logininid=$lur['userid'];
$loginin=$lur['username'];
$loginrnd=$lur['rnd'];
$loginlevel=$lur['groupid'];
$loginadminstyleid=$lur['adminstyleid'];
$incftp=0;
if($public_r['phpmode'])
{
	include("../class/ftp.php");
	$incftp=1;
}
//防采集
if($public_r['opennotcj'])
{
	@include("../data/dbcache/notcj.php");
}
require("../class/comdofun.php");
if($melve=="AddUserpage")//增加自定义页面
{
	AddUserpage($_POST,$logininid,$loginin);
}
elseif($melve=="EditUserpage")//修改自定义页面
{
	EditUserpage($_POST,$logininid,$loginin);
}
elseif($melve=="DelUserpage")//删除自定义页面
{
	$id=$_GET['id'];
	$cid=$_GET['cid'];
	DelUserpage($id,$cid,$logininid,$loginin);
}
elseif($melve=="DoReUserpage")//刷新自定义页面
{
	DoReUserpage($_POST,$logininid,$loginin);
}
elseif($melve=="ChangeInfoOtherLink")//批量更新相关链接
{
	$start=$_GET['start'];
	$classid=$_GET['classid'];
	$from=$_GET['from'];
	$retype=$_GET['retype'];
	$startday=$_GET['startday'];
	$endday=$_GET['endday'];
	$startid=$_GET['startid'];
	$endid=$_GET['endid'];
	$tbname=$_GET['tbname'];
	ChangeInfoOtherLink($start,$classid,$from,$retype,$startday,$endday,$startid,$endid,$tbname,$logininid,$loginin);
}
elseif($melve=="CheckPath")//目录是否存在
{
	$classpath=$_GET['pripath'].$_GET['classpath'];
	CheckPath($classpath);
}
elseif($melve=="DoRepNewstext")//批量替换字段值
{
	$start=$_POST['start'];
	$oldword=$_POST['oldword'];
	$newword=$_POST['newword'];
	$field=$_POST['field'];
	$classid=$_POST['classid'];
	$tid=$_POST['tid'];
	$tbname=$_POST['tbname'];
	$over=$_POST['over'];
	$dozz=$_POST['dozz'];
	$dotxt=$_POST['dotxt'];
	DoRepNewstext($start,$oldword,$newword,$field,$classid,$tid,$tbname,$over,$dozz,$dotxt,$logininid,$loginin);
}
elseif($melve=="AddTempvarClass"||$melve=="AddPageClass"||$melve=="AddBqtempClass"||$melve=="AddListtempClass"||$melve=="AddNewstempClass"||$melve=="AddSearchtempClass"||$melve=="AddBqClass"||$melve=="AddJsTempClass"||$melve=="AddZtClass"||$melve=="AddLinkClass"||$melve=="AddClassTempClass"||$melve=="AddErrorClass"||$melve=='AddTagsClass'||$melve=='AddUserlistClass'||$melve=='AddUserjsClass')//增加类别
{
	$add=$_POST;
	AddThisClass($add,$logininid,$loginin);
}
elseif($melve=="EditTempvarClass"||$melve=="EditPageClass"||$melve=="EditBqtempClass"||$melve=="EditListtempClass"||$melve=="EditNewstempClass"||$melve=="EditSearchtempClass"||$melve=="EditBqClass"||$melve=="EditJsTempClass"||$melve=="EditZtClass"||$melve=="EditLinkClass"||$melve=="EditClassTempClass"||$melve=="EditErrorClass"||$melve=='EditTagsClass'||$melve=='EditUserlistClass'||$melve=='EditUserjsClass')//修改类别
{
	$add=$_POST;
	EditThisClass($add,$logininid,$loginin);
}
elseif($melve=="DelTempvarClass"||$melve=="DelPageClass"||$melve=="DelBqtempClass"||$melve=="DelListtempClass"||$melve=="DelNewstempClass"||$melve=="DelSearchtempClass"||$melve=="DelBqClass"||$melve=="DelJsTempClass"||$melve=="DelZtClass"||$melve=="DelLinkClass"||$melve=="DelClassTempClass"||$melve=="DelErrorClass"||$melve=='DelTagsClass'||$melve=='DelUserlistClass'||$melve=='DelUserjsClass')//删除类别
{
	$classid=$_GET['classid'];
	$doing=$_GET['doing'];
	DelThisClass($classid,$doing,$logininid,$loginin);
}
elseif($melve=="RepDownLevel")//批量替换地址权限
{
	RepDownLevel($_POST,$logininid,$loginin);
}
elseif($melve=='ClearTmpFileData')//清空临时数据与文件
{
	ClearTmpFileData($_GET,$logininid,$loginin);
}
elseif($melve=='ClearBreakInfo')//清理多余信息
{
	ClearBreakInfo($_POST,$logininid,$loginin);
}
elseif($melve=='ResetAddDataNum')//重置信息或评论数统计
{
	$type=$_GET['type'];
	$from=$_GET['from'];
	ResetAddDataNum($type,$from,$logininid,$loginin);
}
else
{
	printerror("ErrorUrl","history.go(-1)");
}
db_close();
$Elves=null;
?>