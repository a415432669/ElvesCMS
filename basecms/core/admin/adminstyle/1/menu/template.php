<?php
if(!defined('InElvesCMS'))
{
	exit();
}
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
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>菜单</title>
<link href="../../../data/menu/menu.css" rel="stylesheet" type="text/css">
<script src="../../../data/menu/menu.js" type="text/javascript"></script>
<SCRIPT lanuage="JScript">
function tourl(url){
	parent.main.location.href=url;
}
</SCRIPT>
</head>
<body onLoad="initialize()">
<table border='0' cellspacing='0' cellpadding='0' align='center' width='100%'>
  <tr>
    <td>
	<select name="selecttempgroup" onchange="self.location.href='left.php?elve=template&gid='+this.options[this.selectedIndex].value">
	<?=$tempgroup?>
	</select>
	</td>
  </tr>
  </table>

<table border='0' cellspacing='0' cellpadding='0' align='center' width='100%'>
  <tr>
    <td height="20"><img src="images/noadd.gif" width="20" height="9"><a href="#Elvescms" onclick="window.open('../../template/melveBq.php','','width=600,height=600,scrollbars=yes,resizable=yes');">查看标签语法</a> 
    </td>
  </tr>
  <tr>
    <td height="20"><img src="images/noadd.gif" width="20" height="9"><a href="#Elvescms" onclick="window.open('../../template/MakeBq.php','','width=600,height=600,scrollbars=yes,resizable=yes');">自动生成标签</a> 
    </td>
  </tr>
  </table>
<?php
if($elve_config['esafe']['openeditdttemp']&&$r[dodttemp])
{
?>
<table border='0' cellspacing='0' cellpadding='0' align='center' width='100%'>
  <tr>
    <td height="20"><img src="images/noadd.gif" width="20" height="9"><a href="#Elvescms" onclick="window.open('../../openpage/AdminPage.php?leftfile=<?=urlencode('../template/dttemppageleft.php')?>&title=<?=urlencode('动态页面模板管理')?>','dttemppage','');">动态页面模板管理</a> 
    </td>
  </tr>
  </table>
<?php
}
?>

<table border='0' cellspacing='0' cellpadding='0'>
	<tr height=20>
			<td id="home"><img src="../../../data/images/homepage.gif" border=0></td>
			<td><b>模板管理</b></td>
	</tr>
</table>

<table border='0' cellspacing='0' cellpadding='0'>
<?
if($r[dotemplate])
{
?>
  <tr> 
    <td id="prindextemp" class="menu1" onclick="chengstate('indextemp')">
		<a onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">首页模板</a>
	</td>
  </tr>
  <tr id="itemindextemp" style="display:none"> 
    <td class="list">
		<table border='0' cellspacing='0' cellpadding='0'>
        <tr> 
          <td class="file">
			<a href="../../template/EditPublicTemp.php?tname=indextemp&gid=<?=$gid?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">首页模板</a>
          </td>
        </tr>
		<tr> 
          <td class="file1">
			<a href="../../template/ListIndexpage.php?gid=<?=$gid?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">管理首页方案</a>
          </td>
        </tr>
      </table>
	</td>
  </tr>
<?
}
?>

<?
if($r[dotemplate])
{
?>
  <tr> 
    <td id="prclasstemp" class="menu1" onclick="chengstate('classtemp')">
		<a onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">封面模板</a>
	</td>
  </tr>
  <tr id="itemclasstemp" style="display:none"> 
    <td class="list">
		<table border='0' cellspacing='0' cellpadding='0'>
        <tr> 
          <td class="file">
			<a href="../../template/ClassTempClass.php?gid=<?=$gid?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">管理封面模板分类</a>
          </td>
        </tr>
		<tr> 
          <td class="file1">
			<a href="../../template/ListClasstemp.php?gid=<?=$gid?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">管理封面模板</a>
          </td>
        </tr>
      </table>
	</td>
  </tr>
<?
}
?>

<?
if($r[dotemplate])
{
?>
  <tr> 
    <td id="prlisttemp" class="menu1" onclick="chengstate('listtemp')">
		<a onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">列表模板</a>
	</td>
  </tr>
  <tr id="itemlisttemp" style="display:none"> 
    <td class="list">
		<table border='0' cellspacing='0' cellpadding='0'>
        <tr> 
          <td class="file">
			<a href="../../template/ListtempClass.php?gid=<?=$gid?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">管理列表模板分类</a>
          </td>
        </tr>
		<tr> 
          <td class="file1">
			<a href="../../template/ListListtemp.php?gid=<?=$gid?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">管理列表模板</a>
          </td>
        </tr>
      </table>
	</td>
  </tr>
<?
}
?>

<?
if($r[dotemplate])
{
?>
  <tr> 
    <td id="prnewstemp" class="menu1" onclick="chengstate('newstemp')">
		<a onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">内容模板</a>
	</td>
  </tr>
  <tr id="itemnewstemp" style="display:none"> 
    <td class="list">
		<table border='0' cellspacing='0' cellpadding='0'>
        <tr> 
          <td class="file">
			<a href="../../template/NewstempClass.php?gid=<?=$gid?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">管理内容模板分类</a>
          </td>
        </tr>
		<tr> 
          <td class="file1">
			<a href="../../template/ListNewstemp.php?gid=<?=$gid?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">管理内容模板</a>
          </td>
        </tr>
      </table>
	</td>
  </tr>
<?
}
?>

<?
if($r[dotemplate])
{
?>
  <tr> 
    <td id="prbqtemp" class="menu1" onclick="chengstate('bqtemp')">
		<a onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">标签模板</a>
	</td>
  </tr>
  <tr id="itembqtemp" style="display:none"> 
    <td class="list">
		<table border='0' cellspacing='0' cellpadding='0'>
        <tr> 
          <td class="file">
			<a href="../../template/BqtempClass.php?gid=<?=$gid?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">管理标签模板分类</a>
          </td>
        </tr>
		<tr> 
          <td class="file1">
			<a href="../../template/ListBqtemp.php?gid=<?=$gid?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">管理标签模板</a>
          </td>
        </tr>
      </table>
	</td>
  </tr>
<?
}
?>

<?
if($r[dotempvar])
{
?>
  <tr> 
    <td id="prtempvar" class="menu1" onclick="chengstate('tempvar')">
		<a onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">公共模板变量</a>
	</td>
  </tr>
  <tr id="itemtempvar" style="display:none"> 
    <td class="list">
		<table border='0' cellspacing='0' cellpadding='0'>
        <tr> 
          <td class="file">
			<a href="../../template/TempvarClass.php?gid=<?=$gid?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">管理模板变量分类</a>
          </td>
        </tr>
		<tr> 
          <td class="file1">
			<a href="../../template/ListTempvar.php?gid=<?=$gid?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">管理模板变量</a>
          </td>
        </tr>
      </table>
	</td>
  </tr>
<?
}
?>

<?
if($r[dotemplate])
{
?>
  <tr> 
    <td id="prpubtemp" class="menu1" onclick="chengstate('pubtemp')">
		<a onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">公共模板</a>
	</td>
  </tr>
  <tr id="itempubtemp" style="display:none"> 
    <td class="list">
		<table border='0' cellspacing='0' cellpadding='0'>
		<tr> 
          <td class="file">
			<a href="../../template/EditPublicTemp.php?tname=cptemp&gid=<?=$gid?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">控制面板模板</a>
          </td>
        </tr>
		<tr> 
          <td class="file">
			<a href="../../template/EditPublicTemp.php?tname=schalltemp&gid=<?=$gid?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">全站搜索模板</a>
          </td>
        </tr>
		<tr> 
          <td class="file">
			<a href="../../template/EditPublicTemp.php?tname=searchformtemp&gid=<?=$gid?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">高级搜索表单模板</a>
          </td>
        </tr>
		<tr> 
          <td class="file">
			<a href="../../template/EditPublicTemp.php?tname=searchformjs&gid=<?=$gid?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">横向搜索JS模板</a>
          </td>
        </tr>
		<tr> 
          <td class="file">
			<a href="../../template/EditPublicTemp.php?tname=searchformjs1&gid=<?=$gid?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">纵向搜索JS模板</a>
          </td>
        </tr>
		<tr> 
          <td class="file">
			<a href="../../template/EditPublicTemp.php?tname=otherlinktemp&gid=<?=$gid?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">相关信息模板</a>
          </td>
        </tr>
		<tr> 
          <td class="file">
			<a href="../../template/EditPublicTemp.php?tname=gbooktemp&gid=<?=$gid?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">留言板模板</a>
          </td>
        </tr>
		<tr> 
          <td class="file">
			<a href="../../template/EditPublicTemp.php?tname=pljstemp&gid=<?=$gid?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">评论JS调用模板</a>
          </td>
        </tr>
		<tr> 
          <td class="file">
			<a href="../../template/EditPublicTemp.php?tname=downpagetemp&gid=<?=$gid?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">最终下载页模板</a>
          </td>
        </tr>
		<tr> 
          <td class="file">
			<a href="../../template/EditPublicTemp.php?tname=downsofttemp&gid=<?=$gid?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">下载地址模板</a>
          </td>
        </tr>
		<tr> 
          <td class="file">
			<a href="../../template/EditPublicTemp.php?tname=onlinemovietemp&gid=<?=$gid?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">在线播放地址模板</a>
          </td>
        </tr>
		<tr> 
          <td class="file">
			<a href="../../template/EditPublicTemp.php?tname=listpagetemp&gid=<?=$gid?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">列表分页模板</a>
          </td>
        </tr>
		<tr> 
          <td class="file">
			<a href="../../template/EditPublicTemp.php?tname=loginiframe&gid=<?=$gid?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">登陆状态模板</a>
          </td>
        </tr>
		<tr> 
          <td class="file1">
			<a href="../../template/EditPublicTemp.php?tname=loginjstemp&gid=<?=$gid?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">JS调用登陆模板</a>
          </td>
        </tr>
      </table>
	</td>
  </tr>
<?
}
?>

<?
if($r[dotemplate])
{
?>
  <tr> 
    <td id="prjstemp" class="menu1" onclick="chengstate('jstemp')">
		<a onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">JS模板</a>
	</td>
  </tr>
  <tr id="itemjstemp" style="display:none"> 
    <td class="list">
		<table border='0' cellspacing='0' cellpadding='0'>
		<tr> 
          <td class="file">
			<a href="../../template/JsTempClass.php?gid=<?=$gid?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">管理JS模板分类</a>
          </td>
        </tr>
		<tr> 
          <td class="file1">
			<a href="../../template/ListJstemp.php?gid=<?=$gid?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">管理JS模板</a>
          </td>
        </tr>
      </table>
	</td>
  </tr>
<?
}
?>

<?
if($r[dotemplate])
{
?>
  <tr> 
    <td id="prsearchtemp" class="menu1" onclick="chengstate('searchtemp')">
		<a onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">搜索模板</a>
	</td>
  </tr>
  <tr id="itemsearchtemp" style="display:none"> 
    <td class="list">
		<table border='0' cellspacing='0' cellpadding='0'>
		<tr> 
          <td class="file">
			<a href="../../template/SearchtempClass.php?gid=<?=$gid?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">管理搜索模板分类</a>
          </td>
        </tr>
		<tr> 
          <td class="file1">
			<a href="../../template/ListSearchtemp.php?gid=<?=$gid?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">管理搜索模板</a>
          </td>
        </tr>
      </table>
	</td>
  </tr>
<?
}
?>

<?
if($r[dotemplate])
{
?>
  <tr> 
    <td id="prpltemp" class="menu1" onclick="chengstate('pltemp')">
		<a onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">评论列表模板</a>
	</td>
  </tr>
  <tr id="itempltemp" style="display:none"> 
    <td class="list">
		<table border='0' cellspacing='0' cellpadding='0'>
		<tr> 
          <td class="file">
			<a href="../../template/AddPltemp.php?melve=AddPlTemp&gid=<?=$gid?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">增加评论模板</a>
          </td>
        </tr>
		<tr> 
          <td class="file1">
			<a href="../../template/ListPltemp.php?gid=<?=$gid?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">管理评论模板</a>
          </td>
        </tr>
      </table>
	</td>
  </tr>
<?
}
?>

<?
if($r[dotemplate])
{
?>
  <tr> 
    <td id="prprinttemp" class="menu1" onclick="chengstate('printtemp')">
		<a onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">打印模板</a>
	</td>
  </tr>
  <tr id="itemprinttemp" style="display:none"> 
    <td class="list">
		<table border='0' cellspacing='0' cellpadding='0'>
		<tr> 
          <td class="file">
			<a href="../../template/AddPrinttemp.php?melve=AddPrintTemp&gid=<?=$gid?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">增加打印模板</a>
          </td>
        </tr>
		<tr> 
          <td class="file1">
			<a href="../../template/ListPrinttemp.php?gid=<?=$gid?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">管理打印模板</a>
          </td>
        </tr>
      </table>
	</td>
  </tr>
<?
}
?>

<?
if($r[dotemplate])
{
?>
  <tr> 
    <td id="pruserpagetemp" class="menu1" onclick="chengstate('userpagetemp')">
		<a onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">自定义页面模板</a>
	</td>
  </tr>
  <tr id="itemuserpagetemp" style="display:none"> 
    <td class="list">
		<table border='0' cellspacing='0' cellpadding='0'>
        <tr> 
          <td class="file">
			<a href="../../template/AddPagetemp.php?melve=AddPagetemp&gid=<?=$gid?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">增加自定义页面模板</a>
          </td>
        </tr>
		<tr> 
          <td class="file1">
			<a href="../../template/ListPagetemp.php?gid=<?=$gid?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">管理自定义页面模板</a>
          </td>
        </tr>
      </table>
	</td>
  </tr>
<?
}
?>

<?
if($r[dotemplate])
{
?>
  <tr> 
    <td id="prvotetemp" class="menu1" onclick="chengstate('votetemp')">
		<a onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">投票模板</a>
	</td>
  </tr>
  <tr id="itemvotetemp" style="display:none"> 
    <td class="list">
		<table border='0' cellspacing='0' cellpadding='0'>
		<tr> 
          <td class="file">
			<a href="../../template/AddVotetemp.php?melve=AddVoteTemp&gid=<?=$gid?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">增加投票模板</a>
          </td>
        </tr>
		<tr> 
          <td class="file1">
			<a href="../../template/ListVotetemp.php?gid=<?=$gid?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">管理投票模板</a>
          </td>
        </tr>
      </table>
	</td>
  </tr>
<?
}
?>

<?
if($r[dobq])
{
?>
  <tr> 
    <td id="prbq" class="menu1" onclick="chengstate('bq')">
		<a onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">标签</a>
	</td>
  </tr>
  <tr id="itembq" style="display:none"> 
    <td class="list">
		<table border='0' cellspacing='0' cellpadding='0'>
		<tr> 
          <td class="file">
			<a href="../../template/BqClass.php?gid=<?=$gid?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">管理标签分类</a>
          </td>
        </tr>
		<tr> 
          <td class="file1">
			<a href="../../template/ListBq.php?gid=<?=$gid?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">管理标签</a>
          </td>
        </tr>
      </table>
	</td>
  </tr>
<?
}
?>

<?
if($r[dotempgroup])
{
?>
  <tr> 
    <td id="prtempgroup" class="menu1" onclick="chengstate('tempgroup')">
		<a onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">模板组管理</a>
	</td>
  </tr>
  <tr id="itemtempgroup" style="display:none"> 
    <td class="list">
		<table border='0' cellspacing='0' cellpadding='0'>
		<tr> 
          <td class="file1">
			<a href="../../template/TempGroup.php" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">导入/导出模板组</a>
          </td>
        </tr>
      </table>
	</td>
  </tr>
<?
}
?>

<?
if($r[dotemplate])
{
?>
  <tr> 
    <td id="prtother" class="menu3" onclick="chengstate('tother')">
		<a onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">其他相关</a>
	</td>
  </tr>
  <tr id="itemtother" style="display:none"> 
    <td class="list1">
		<table border='0' cellspacing='0' cellpadding='0'>
        <tr> 
          <td class="file">
			<a href="../../template/LoadTemp.php?gid=<?=$gid?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">批量导入栏目模板</a>
          </td>
        </tr>
		<tr> 
          <td class="file">
			<a href="../../template/ChangeListTemp.php?gid=<?=$gid?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">批量更换列表模板</a>
          </td>
        </tr>
		<tr> 
          <td class="file1">
			<a href="../../template/RepTemp.php?gid=<?=$gid?>" target="main" onmouseout="this.style.fontWeight=''" onmouseover="this.style.fontWeight='bold'">批量替换模板字符</a>
          </td>
        </tr>
      </table>
	</td>
  </tr>
<?
}
?>
</table>
</body>
</html>