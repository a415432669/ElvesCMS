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
CheckLevel($logininid,$loginin,$classid,"workflow");
$wfid=(int)$_GET['wfid'];
if(!$wfid)
{
	printerror('ErrorUrl','');
}
$wfr=$Elves->fetch1("select wfid,wfname from {$dbtbpre}melveworkflow where wfid='$wfid'");
if(!$wfr['wfid'])
{
	printerror('ErrorUrl','');
}
$melve=$_GET['melve'];
$postword='增加节点';
$url="<a href=ListWf.php>管理工作流</a> &gt; ".$wfr[wfname]." &gt; <a href='ListWfItem.php?wfid=$wfid'>管理节点</a> &gt; 增加节点";
//复制
if($melve=="AddWorkflowItem"&&$_GET['docopy'])
{
	$tid=(int)$_GET['tid'];
	$r=$Elves->fetch1("select * from {$dbtbpre}melveworkflowitem where tid='$tid'");
	$url="<a href=ListWf.php>管理工作流</a> &gt; ".$wfr[wfname]." &gt; <a href='ListWfItem.php?wfid=$wfid'>管理节点</a> &gt; 复制节点：<b>".$r[tname]."</b>";
	$username=substr($r[username],1,-1);
}
//修改
if($melve=="EditWorkflowItem")
{
	$postword='修改节点';
	$tid=(int)$_GET['tid'];
	$r=$Elves->fetch1("select * from {$dbtbpre}melveworkflowitem where tid='$tid'");
	$url="<a href=ListWf.php>管理工作流</a> &gt; ".$wfr[wfname]." &gt; <a href='ListWfItem.php?wfid=$wfid'>管理节点</a> &gt; 修改节点：<b>".$r[tname]."</b>";
	$username=substr($r[username],1,-1);
}
//用户组
$group='';
$groupsql=$Elves->query("select groupid,groupname from {$dbtbpre}melvegroup order by groupid");
while($groupr=$Elves->fetch($groupsql))
{
	$select='';
	if(strstr($r[groupid],','.$groupr[groupid].','))
	{
		$select=' selected';
	}
	$group.="<option value='".$groupr[groupid]."'".$select.">".$groupr[groupname]."</option>";
}
//部门
$userclass='';
$ucsql=$Elves->query("select classid,classname from {$dbtbpre}melveuserclass order by classid");
while($ucr=$Elves->fetch($ucsql))
{
	$select='';
	if(strstr($r[userclass],','.$ucr[classid].','))
	{
		$select=' selected';
	}
	$userclass.="<option value='".$ucr[classid]."'".$select.">".$ucr[classname]."</option>";
}
//原节点
$items='';
$maxtno=0;
$ytsql=$Elves->query("select tid,tname,tno from {$dbtbpre}melveworkflowitem where wfid='$wfid'");
while($ytr=$Elves->fetch($ytsql))
{
	if($ytr[tno]>$maxtno)
	{
		$maxtno=$ytr[tno];
	}
	$select='';
	if($ytr[tid]==$r[tbdo])
	{
		$select=' selected';
	}
	$items.="<option value='".$ytr[tid]."'".$select.">".$ytr[tname]."(".$ytr[tno].")</option>";
}
if($melve=="AddWorkflowItem")
{
	$r[tno]=$maxtno+1;
}
db_close();
$Elves=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<title>工作流</title>
<script>
function selectalls(doselect,formvar)
{  
	 var bool=doselect==1?true:false;
	 var selectform=document.getElementById(formvar);
	 for(var i=0;i<selectform.length;i++)
	 { 
		  selectform.all[i].selected=bool;
	 } 
}
</script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td>位置：<?=$url?></td>
  </tr>
</table>
<form name="form1" method="post" action="ListWfItem.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
    <tr class="header"> 
      <td height="25" colspan="2"> 
        <?=$postword?>
        <input name="melve" type="hidden" id="melve" value="<?=$melve?>"> <input name="tid" type="hidden" id="tid" value="<?=$tid?>"> 
        <input name="wfid" type="hidden" id="wfid" value="<?=$wfid?>"> </td>
    </tr>
    <tr> 
      <td width="18%" height="25" bgcolor="#FFFFFF">节点编号</td>
      <td width="82%" height="25" bgcolor="#FFFFFF"> <input name="tno" type="text" id="tno" value="<?=$r[tno]?>" size="42"> 
        <select name="changetno" id="changetno" onchange="document.form1.tno.value=this.options[this.selectedIndex].value">
          <option>选择</option>
          <option value="1">起始编号(1)</option>
          <option value="100">结束编号(100)</option>
        </select> </td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">节点名称</td>
      <td height="25" bgcolor="#FFFFFF"> <input name="tname" type="text" id="tname" value="<?=$r[tname]?>" size="42"></td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF">状态说明</td>
      <td height="25" bgcolor="#FFFFFF"><input name="tstatus" type="text" id="tstatus" value="<?=$r[tstatus]?>" size="42"></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">节点描述</td>
      <td height="25" bgcolor="#FFFFFF"> <textarea name="ttext" cols="60" rows="5" id="varname3"><?=ehtmlspecialchars($r[ttext])?></textarea></td>
    </tr>
    <tr> 
      <td height="25" colspan="2">接收对象</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">用户</td>
      <td height="25" bgcolor="#FFFFFF"> <input name="username" type="text" id="username" value="<?=$username?>" size="42"> 
        <font color="#666666"> 
        <input type="button" name="Submit3" value="选择" onclick="window.open('../ChangeUser.php?field=username&form=form1','','width=300,height=520,scrollbars=yes');">
        (多个用户用“,”逗号隔开)</font></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">用户组</td>
      <td height="25" bgcolor="#FFFFFF"> <select name="groupid[]" size="5" multiple id="groupidselect" style="width:180">
          <?=$group?>
        </select>
        [<a href="#Elvescms" onclick="selectalls(0,'groupidselect')">全部取消</a>]</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">部门</td>
      <td height="25" bgcolor="#FFFFFF"> <select name="userclass[]" size="5" multiple id="userclassselect" style="width:180">
          <?=$userclass?>
        </select>
        [<a href="#Elvescms" onclick="selectalls(0,'userclassselect')">全部取消</a>]</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">流转方式</td>
      <td height="25" bgcolor="#FFFFFF"><input type="radio" name="lztype" value="0"<?=$r[lztype]==0?' checked':''?>>
        普通流转 
        <input type="radio" name="lztype" value="1"<?=$r[lztype]==1?' checked':''?>>
        会签</td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">返工时打回</td>
      <td height="25" bgcolor="#FFFFFF"><select name="tbdo" id="tbdo">
          <option value="0"<?=$r[tbdo]==0?' selected':''?>>打回作者</option>
          <?=$items?>
        </select></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">否决时操作</td>
      <td height="25" bgcolor="#FFFFFF"><select name="tddo" id="tddo">
          <option value="0"<?=$r[tddo]==0?' selected':''?>>不操作</option>
          <option value="1"<?=$r[tddo]==1?' selected':''?>>删除信息</option>
        </select></td>
    </tr>
    <tr> 
      <td height="25" bgcolor="#FFFFFF">&nbsp;</td>
      <td height="25" bgcolor="#FFFFFF"> <input type="submit" name="Submit" value="提交"> 
        <input type="reset" name="Submit2" value="重置"></td>
    </tr>
  </table>
</form>
</body>
</html>
