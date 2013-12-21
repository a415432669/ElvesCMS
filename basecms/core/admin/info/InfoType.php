<?php
define('ElvesCMSAdmin','1');
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/functions.php");
require("../../data/dbcache/class.php");
require '../'.LoadLang('pub/fun.php');
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
CheckLevel($logininid,$loginin,$classid,"infotype");

//处理分类字段变量
function DoPostInfoTypeVar($add){
	if(empty($add['ttype']))
	{
		$add['ttype']='.html';
	}
	$add['tname']=eaddslashes(ehtmlspecialchars($add['tname']));
	$add['mid']=(int)$add['mid'];
	$add['myorder']=(int)$add['myorder'];
	$add['yhid']=(int)$add['yhid'];
	$add['tnum']=(int)$add['tnum'];
	$add['listtempid']=(int)$add['listtempid'];
	$add['maxnum']=(int)$add['maxnum'];
	$add['reorder']=RepPostVar2($add['reorder']);
	$add['intro']=eaddslashes(RepPhpAspJspcode($add['intro']));
	$add['pagekey']=eaddslashes(RepPhpAspJspcode($add['pagekey']));
	$add['newline']=(int)$add['newline'];
	$add['hotline']=(int)$add['hotline'];
	$add['goodline']=(int)$add['goodline'];
	$add['hotplline']=(int)$add['hotplline'];
	$add['firstline']=(int)$add['firstline'];
	$add['jstempid']=(int)$add['jstempid'];
	$add['nrejs']=(int)$add['nrejs'];
	$add['listdt']=(int)$add['listdt'];
	$add['repagenum']=(int)$add['repagenum'];
	//目录
	$add['tpath']=trim($add['tpath']);
	$add['tpath']=$add['pripath'].$add['tpath'];
	return $add;
}

//增加分类
function AddInfoType($add,$userid,$username){
	global $Elves,$dbtbpre;
	if(!$add[mid]||!$add[tname]||!$add[listtempid]||!$add[tpath])
	{
		printerror("EmptyInfoTypeName","history.go(-1)");
    }
	$add=DoPostInfoTypeVar($add);
	CheckLevel($userid,$username,$classid,"infotype");
	$createpath=elve_PATH.$add[tpath];
	//检测目录是否存在
	if(file_exists($createpath))
	{
		printerror("ReInfoTypePath","");
	}
	CreateInfoTypePath($add[tpath]);//建立目录
	//取得表名
	$tabler=GetModTable($add[mid]);
	$tabler[tid]=(int)$tabler[tid];
	$sql=$Elves->query("insert into {$dbtbpre}melveinfotype(tname,mid,myorder,yhid,tnum,listtempid,tpath,ttype,maxnum,reorder,tid,tbname,timg,intro,pagekey,newline,hotline,goodline,hotplline,firstline,jstempid,nrejs,listdt,repagenum) values('$add[tname]','$add[mid]','$add[myorder]','$add[yhid]','$add[tnum]','$add[listtempid]','$add[tpath]','$add[ttype]','$add[maxnum]','$add[reorder]','$tabler[tid]','$tabler[tbname]','$add[timg]','$add[intro]','$add[pagekey]','$add[newline]','$add[hotline]','$add[goodline]','$add[hotplline]','$add[firstline]','$add[jstempid]','$add[nrejs]','$add[listdt]','$add[repagenum]');");
	$typeid=$Elves->lastid();
	//生成页面
	if($add[listdt]==0)
	{
		//ListHtml($typeid,$ret_r,5);
	}
	GetClass();//更新缓存
	if($sql)
	{
		//操作日志
	    insert_dolog("typeid=".$typeid."<br>tname=".$add[tname]);
		printerror("AddInfoTypeSuccess","InfoType.php");
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//修改分类
function EditInfoType($add,$userid,$username){
	global $Elves,$dbtbpre;
	$typeid=(int)$add['typeid'];
	if(!$typeid||!$add[mid]||!$add[tname]||!$add[listtempid]||!$add[tpath])
	{
		printerror("EmptyInfoTypeName","history.go(-1)");
    }
	$add=DoPostInfoTypeVar($add);
	CheckLevel($userid,$username,$classid,"infotype");
	//改变目录
	if($add[oldtpath]<>$add[tpath])
	{
		$createpath=elve_PATH.$add[tpath];
		if(file_exists($createpath))
		{
			printerror("ReInfoTypePath","");
		}
		if($add['oldpripath']==$add['pripath'])
		{
			$new=elve_PATH;
			@rename($new.$add[oldtpath],$new.$add[tpath]);//改变目录名
		}
		else
		{
			CreateInfoTypePath($add[tpath]);//建立目录
		}
    }
	//取得表名
	$tabler=GetModTable($add[mid]);
	$tabler[tid]=(int)$tabler[tid];
	//修改
	$sql=$Elves->query("update {$dbtbpre}melveinfotype set tname='$add[tname]',mid='$add[mid]',myorder='$add[myorder]',yhid='$add[yhid]',tnum='$add[tnum]',listtempid='$add[listtempid]',tpath='$add[tpath]',ttype='$add[ttype]',maxnum='$add[maxnum]',reorder='$add[reorder]',tid='$tabler[tid]',tbname='$tabler[tbname]',timg='$add[timg]',intro='$add[intro]',pagekey='$add[pagekey]',newline='$add[newline]',hotline='$add[hotline]',goodline='$add[goodline]',hotplline='$add[hotplline]',firstline='$add[firstline]',jstempid='$add[jstempid]',nrejs='$add[nrejs]',listdt='$add[listdt]',repagenum='$add[repagenum]' where typeid='$typeid'");
	GetClass();//更新缓存
	//生成页面
	if($add[listdt]==0)
	{
		ListHtml($typeid,$ret_r,5);
	}
	if($sql)
	{
		insert_dolog("typeid=".$typeid."<br>tname=".$add[tname]);//操作日志
		printerror("EditInfoTypeSuccess","InfoType.php?mid=$add[fmid]");
	}
	else
	{
		printerror("DbError","");
	}
}

//删除分类
function DelInfoType($add,$userid,$username){
	global $Elves,$dbtbpre;
	$typeid=(int)$add[typeid];
	if(!$typeid)
	{
		printerror("NotDelInfoTypeid","");
	}
	CheckLevel($userid,$username,$classid,"infotype");
	$r=$Elves->fetch1("select * from {$dbtbpre}melveinfotype where typeid='$typeid'");
	if(empty($r[typeid]))
	{
		printerror("NotDelInfoTypeid","history.go(-1)");
	}
	//删除专题
	$sql=$Elves->query("delete from {$dbtbpre}melveinfotype where typeid='$typeid'");
	$delpath=elve_PATH.$r[tpath];
	$del=DelPath($delpath);
	//改变信息分类值
	$usql=$Elves->query("update {$dbtbpre}elve_".$r[tbname]." set ttid=0 where ttid='$typeid'");
	$usql=$Elves->query("update {$dbtbpre}elve_".$r[tbname]."_check set ttid=0 where ttid='$typeid'");
	$usql=$Elves->query("update {$dbtbpre}elve_".$r[tbname]."_doc set ttid=0 where ttid='$typeid'");
	GetClass();//更新缓存
	if($sql)
	{
		insert_dolog("typeid=".$typeid."<br>tname=".$r[tname]);//操作日志
		printerror("DelInfoTypeSuccess","InfoType.php?mid=$add[fmid]");
	}
	else
	{
		printerror("DbError","");
	}
}

//修改分类顺序
function EditInfoTypeOrder($typeid,$myorder,$userid,$username){
	global $Elves,$dbtbpre;
	CheckLevel($userid,$username,$classid,"infotype");
	for($i=0;$i<count($typeid);$i++)
	{
		$newmyorder=(int)$myorder[$i];
		$typeid[$i]=(int)$typeid[$i];
		$sql=$Elves->query("update {$dbtbpre}melveinfotype set myorder='$newmyorder' where typeid='$typeid[$i]'");
    }
	//操作日志
	insert_dolog("");
	printerror("EditInfoTypeOrderSuccess",$_SERVER['HTTP_REFERER']);
}

$melve=$_POST['melve'];
if(empty($melve))
{$melve=$_GET['melve'];}
if($melve)
{
	include('../../class/delpath.php');
	include('../../class/copypath.php');
	include('../../class/t_functions.php');
}
if($melve=="AddInfoType")//增加分类
{
	AddInfoType($_POST,$logininid,$loginin);
}
elseif($melve=="EditInfoType")//修改分类
{
	EditInfoType($_POST,$logininid,$loginin);
}
elseif($melve=="DelInfoType")//删除分类
{
	DelInfoType($_GET,$logininid,$loginin);
}
elseif($melve=="EditInfoTypeOrder")//修改分类排序
{
	EditInfoTypeOrder($_POST['typeid'],$_POST['myorder'],$logininid,$loginin);
}


$search='';
$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$line=50;//每页显示条数
$page_line=12;//每页显示链接数
$offset=$page*$line;//总偏移量
$query="select typeid,tname,mid,myorder,tpath from {$dbtbpre}melveinfotype";
$totalquery="select count(*) as total from {$dbtbpre}melveinfotype";
$add='';
$mid=(int)$_GET['mid'];
if($mid)
{
	$add=" where mid='$mid'";
	$search.='&mid='.$mid;
}
$query.=$add;
$totalquery.=$add;
$num=$Elves->gettotal($totalquery);//取得总条数
$query=$query." order by myorder,typeid limit $offset,$line";
$sql=$Elves->query($query);
$returnpage=page2($num,$line,$page_line,$start,$page,$search);
//模型
$mstr="";
$msql=$Elves->query("select mid,mname from {$dbtbpre}melvemod where usemod=0 order by myorder,mid");
while($mr=$Elves->fetch($msql))
{
	$select="";
	if($mr[mid]==$mid)
	{
		$select=" selected";
	}
	$mstr.="<option value='".$mr[mid]."'".$select.">".$mr[mname]."</option>";
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>标题分类</title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script>
function CheckAll(form)
  {
  for (var i=0;i<form.elements.length;i++)
    {
    var e = form.elements[i];
    if (e.name != 'chkall')
       e.checked = form.chkall.checked;
    }
  }
</script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td width="69%" height="25">位置：<a href="InfoType.php">管理标题分类</a> </td>
    <td width="31%"><div align="right" class="emenubutton">
        <input type="button" name="Submit5" value="增加标题分类" onclick="self.location.href='AddInfoType.php?melve=AddInfoType';">
      </div></td>
  </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td>选择所属系统模型： 
      <select name="mid" id="mid" onchange="window.location='InfoType.php?mid='+this.options[this.selectedIndex].value;">
        <option value="0">不限系统模型</option>
        <?=$mstr?>
      </select> </td>
  </tr>
</table>
<br>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <form name="infotypeform" method="post" action="InfoType.php" onsubmit="return confirm('确认要提交?');">
    <input name="fmid" type="hidden" id="fmid" value="<?=$mid?>">
    <tr class="header"> 
      <td width="4%"><div align="center">选择 </div></td>
      <td width="6%"><div align="center">ID</div></td>
      <td width="4%"><div align="center">排序</div></td>
      <td width="32%" height="25"><div align="center">分类名称</div></td>
      <td width="21%"><div align="center">所属系统模型</div></td>
      <td width="16%" height="25"><div align="center">操作</div></td>
      <td width="17%">操作</td>
    </tr>
    <?php
  while($r=$Elves->fetch($sql))
  {
  	$modr=$Elves->fetch1("select mid,mname from {$dbtbpre}melvemod where mid='$r[mid]'");
  	$turl=sys_ReturnBqInfoTypeUrl($r['typeid']);
  ?>
    <tr bgcolor="#FFFFFF"> 
      <td><div align="center"> 
          <input name="classid[]" type="checkbox" id="classid[]" value="<?=$r[typeid]?>">
        </div></td>
      <td><div align="center"> 
          <?=$r[typeid]?>
          <input name="typeid[]" type="hidden" id="typeid[]" value="<?=$r[typeid]?>">
        </div></td>
      <td><div align="center"> 
          <input name="myorder[]" type="text" id="myorder[]" value="<?=$r[myorder]?>" size="6">
        </div></td>
      <td height="25"> <div align="center"><a href="<?=$turl?>" target="_blank"> 
          <?=$r[tname]?>
          </a></div></td>
      <td><div align="center">[<a href="InfoType.php?mid=<?=$modr[mid]?>"> 
          <?=$modr[mname]?>
          </a>]</div></td>
      <td height="25"><a href="AddInfoType.php?melve=EditInfoType&typeid=<?=$r[typeid]?>&fmid=<?=$mid?>">修改</a> 
        <a href="AddInfoType.php?melve=AddInfoType&docopy=1&typeid=<?=$r[typeid]?>&fmid=<?=$mid?>">复制</a> 
        <a href="InfoType.php?melve=DelInfoType&typeid=<?=$r[typeid]?>&fmid=<?=$mid?>" onclick="return confirm('确认要删除？');">删除</a></td>
      <td><a href="../elvechtml.php?melve=ReTtHtml&typeid=<?=$r[typeid]?>&fmid=<?=$mid?>">刷新</a> 
        <a href='../elvechtml.php?melve=ReSingleJs&doing=1&classid=<?=$r[typeid]?>'>JS</a> 
        <a href="#elve" onclick="window.open('../view/TtUrl.php?ttid=<?=$r[typeid]?>','','width=500,height=250');">调用</a></td>
    </tr>
    <?
  }
  ?>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"><div align="center">
          <input type=checkbox name=chkall value=on onclick=CheckAll(this.form)>
        </div></td>
      <td height="25" colspan="6"> <div align="right">
          <input type="submit" name="Submit" value="刷新页面" onClick="document.infotypeform.melve.value='GoReListHtmlMore';document.infotypeform.action='../elvechtml.php';">
		  &nbsp;&nbsp;
          <input type="submit" name="Submit52" value="修改排序" onClick="document.infotypeform.melve.value='EditInfoTypeOrder';document.infotypeform.action='InfoType.php';">
          &nbsp; 
          <input name="melve" type="hidden" id="melve" value="EditInfoTypeOrder">
          <input name="gore" type="hidden" id="gore" value="2">
          <input name="from" type="hidden" id="from" value="info/InfoType.php">
          &nbsp; <font color="#666666">(排序值越小越前面)</font></div></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" colspan="7"> 
        <?=$returnpage?>
      </td>
    </tr>
  </form>
</table>
</body>
</html>
<?php
db_close();
$Elves=null;
?>