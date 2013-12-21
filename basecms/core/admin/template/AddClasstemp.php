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
CheckLevel($logininid,$loginin,$classid,"template");
$gid=(int)$_GET['gid'];
$gname=CheckTempGroup($gid);
$urlgname=$gname."&nbsp;>&nbsp;";
$cid=$_GET['cid'];
$melve=$_GET['melve'];
$url=$urlgname."<a href=ListClasstemp.php?gid=$gid&classid=$cid>管理封面模板</a>&nbsp;>&nbsp;增加封面模板";
$postword='增加封面模板';
//复制
if($melve=="AddClasstemp"&&$_GET['docopy'])
{
	$tempid=(int)$_GET['tempid'];
	$r=$Elves->fetch1("select tempid,tempname,temptext,classid from ".GetDoTemptb("melveclasstemp",$gid)." where tempid=$tempid");
	$url=$urlgname."<a href=ListClasstemp.php?gid=$gid&classid=$cid>管理封面模板</a>&nbsp;>&nbsp;复制封面模板: ".$r[tempname];
	$postword='修改封面模板';
}
//修改
if($melve=="EditClasstemp")
{
	$tempid=(int)$_GET['tempid'];
	$r=$Elves->fetch1("select tempid,tempname,temptext,classid from ".GetDoTemptb("melveclasstemp",$gid)." where tempid=$tempid");
	$url=$urlgname."<a href=ListClasstemp.php?gid=$gid&classid=$cid>管理封面模板</a>&nbsp;>&nbsp;修改封面模板: ".$r[tempname];
	$postword='修改封面模板';
}
//分类
$cstr="";
$csql=$Elves->query("select classid,classname from {$dbtbpre}melveclasstempclass order by classid");
while($cr=$Elves->fetch($csql))
{
	$select="";
	if($cr[classid]==$r[classid])
	{
		$select=" selected";
	}
	$cstr.="<option value='".$cr[classid]."'".$select.">".$cr[classname]."</option>";
}
db_close();
$Elves=null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?=$postword?></title>
<link href="../adminstyle/<?=$loginadminstyleid?>/adminstyle.css" rel="stylesheet" type="text/css">
<script>
function ReturnHtml(html)
{
document.form1.temptext.value=html;
}
</script>
<SCRIPT lanuage="JScript">
<!--
function tempturnit(ss)
{
 if (ss.style.display=="") 
  ss.style.display="none";
 else
  ss.style.display=""; 
}
-->
</SCRIPT>
<script>
function ReTempBak(){
	self.location.reload();
}
</script>
</head>

<body>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td height="25">位置：<?=$url?></td>
  </tr>
</table>
<br>
  <table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <form name="form1" method="post" action="ListClasstemp.php">
    <tr class="header"> 
      <td height="25" colspan="2"> 
        <?=$postword?>
        <input name="melve" type="hidden" id="melve" value="<?=$melve?>"> <input name="tempid" type="hidden" id="tempid" value="<?=$tempid?>"> 
        <input name="cid" type="hidden" id="cid" value="<?=$cid?>"> <input name="gid" type="hidden" id="gid" value="<?=$gid?>"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="19%" height="25">模板名称(*)</td>
      <td width="81%" height="25"> <input name="tempname" type="text" id="tempname" value="<?=$r[tempname]?>" size="30"> 
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">所属分类</td>
      <td height="25"><select name="classid" id="classid">
          <option value="0">不隶属于任何类别</option>
          <?=$cstr?>
        </select> <input type="button" name="Submit6222322" value="管理分类" onclick="window.open('ClassTempClass.php');"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"><strong>模板内容</strong>(*)</td>
      <td height="25">请将模板内容<a href="#elve" onclick="window.clipboardData.setData('Text',document.form1.temptext.value);document.form1.temptext.select()" title="点击复制模板内容"><strong>复制到Dreamweaver(推荐)</strong></a>或者使用<a href="#elve" onclick="window.open('editor.php?getvar=opener.document.form1.temptext.value&returnvar=opener.document.form1.temptext.value&fun=ReturnHtml','edittemp','width=880,height=600,scrollbars=auto,resizable=yes');"><strong>模板在线编辑</strong></a>进行可视化编辑</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" colspan="2"><div align="center"> 
          <textarea name="temptext" cols="90" rows="27" id="temptext" wrap="OFF" style="WIDTH: 100%"><?=ehtmlspecialchars(stripSlashes($r[temptext]))?></textarea>
        </div></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="25">&nbsp;</td>
      <td height="25"><input type="submit" name="Submit" value="保存模板"> &nbsp;<input type="reset" name="Submit2" value="重置">
        <?php
		if($melve=='EditClasstemp')
		{
		?>
        &nbsp;&nbsp;[<a href="#Elvescms" onclick="window.open('TempBak.php?temptype=classtemp&tempid=<?=$tempid?>&gid=<?=$gid?>','ViewTempBak','width=450,height=500,scrollbars=yes,left=300,top=150,resizable=yes');">修改记录</a>] 
        <?php
		}
		?>
      </td>
    </tr>
	</form>
	<tr bgcolor="#FFFFFF"> 
      <td height="25" colspan="2">&nbsp;&nbsp;[<a href="#elve" onclick="tempturnit(showtempvar);">显示模板变量说明</a>] 
        &nbsp;&nbsp;[<a href="#elve" onclick="window.open('melveBq.php','','width=600,height=500,scrollbars=yes,resizable=yes');">查看模板标签语法</a>] 
        &nbsp;&nbsp;[<a href="#elve" onclick="window.open('../ListClass.php','','width=800,height=600,scrollbars=yes,resizable=yes');">查看JS调用地址</a>] 
        &nbsp;&nbsp;[<a href="#elve" onclick="window.open('ListTempvar.php','','width=800,height=600,scrollbars=yes,resizable=yes');">查看公共模板变量</a>] 
        &nbsp;&nbsp;[<a href="#elve" onclick="window.open('ListBqtemp.php','','width=800,height=600,scrollbars=yes,resizable=yes');">查看标签模板</a>] 
      </td>
    </tr>
    <tr bgcolor="#FFFFFF" id="showtempvar" style="display:none"> 
      <td height="25" colspan="2"><table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#DBEAF5">
          <tr bgcolor="#FFFFFF"> 
            <td width="33%" height="25"> <input name="textfield7" type="text" value="[!--pagetitle--]">
              :页面标题</td>
            <td width="34%"><input name="textfield72" type="text" value="[!--pagekey--]">
              :页面关键字</td>
            <td width="33%"><input name="textfield73" type="text" value="[!--pagedes--]">
              :页面描述</td>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td height="25"><input name="textfield8" type="text" value="[!--news.url--]">
              :网站地址</td>
            <td><input name="textfield9" type="text" value="[!--newsnav--]">
              :所在位置导航条</td>
            <td><input name="textfield92" type="text" value="[!--class.menu--]">
              :一级栏目导航</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield10" type="text" value="[!--self.classid--]">
              :本栏目/专题ID</td>
            <td><input name="textfield11" type="text" value="[!--class.keywords--]">
              :栏目/专题关键字</td>
            <td><input name="textfield12" type="text" value="[!--class.classimg--]">
              :栏目/专题缩略图</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield132" type="text" value="[!--class.name--]">
              :栏目名</td>
            <td><input name="textfield13" type="text" value="[!--class.intro--]">
              :栏目/专题简介</td>
            <td><input name="textfield14" type="text" value="[!--bclass.id--]">
              : 父栏目ID</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td height="25"><input name="textfield15" type="text" value="[!--bclass.name--]">
              :父栏目名称</td>
            <td><strong>支持公共模板变量</strong></td>
            <td><strong>支持所有模板标签</strong></td>
          </tr>
        </table></td>
    </tr>
  </table>
</body>
</html>