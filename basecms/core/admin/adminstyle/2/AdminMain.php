<?php
if(!defined('InElvesCMS'))
{
	exit();
}
$r=ReturnLeftLevel($loginlevel);
//图片识别
if(stristr($_SERVER['HTTP_USER_AGENT'],'MSIE 6.0'))
{
	$menufiletype='.gif';
}
else
{
	$menufiletype='.png';
}
?>
<HTML>
<HEAD>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<TITLE>Elves网站管理系统 － 最安全、最稳定的开源CMS系统</TITLE>
<LINK href="adminstyle/2/adminmain.css" rel=stylesheet>
<STYLE>
.flyoutLink A {
	COLOR: black; TEXT-DECORATION: none
}
.flyoutLink A:hover {
	COLOR: black; TEXT-DECORATION: none
}
.flyoutLink A:visited {
	COLOR: black; TEXT-DECORATION: none
}
.flyoutLink A:active {
	COLOR: black; TEXT-DECORATION: none
}
.flyoutMenu {
	BACKGROUND-COLOR: #eee
}
.flyoutMenu TD.flyoutLink {
	BORDER-RIGHT: #eee 1px solid; BORDER-TOP: #eee 1px solid; BORDER-LEFT: #eee 1px solid; CURSOR: hand; PADDING-TOP: 1px; BORDER-BOTTOM: #eee 1px solid
}
.flyoutMenu1 {
	BACKGROUND-COLOR: #fbf9f9
}
.flyoutMenu1 TD.flyoutLink1 {
	BORDER-RIGHT: #fbf9f9 1px solid; BORDER-TOP: #fbf9f9 1px solid; BORDER-LEFT: #fbf9f9 1px solid; CURSOR: hand; PADDING-TOP: 1px; BORDER-BOTTOM: #fbf9f9 1px solid
}
</STYLE>
<SCRIPT>
function switchSysBar(){
	if(switchPoint.innerText==3)
	{
		switchPoint.innerText=4
		document.all("frmTitle").style.display="none"
	}
	else
	{
		switchPoint.innerText=3
		document.all("frmTitle").style.display=""
	}
}
function switchSysBarInfo(){
	switchPoint.innerText=3
	document.all("frmTitle").style.display=""
}

function about(){
	window.showModalDialog("adminstyle/2/page/about.htm","ABOUT","dialogwidth:300px;dialogheight:150px;center:yes;status:no;scroll:no;help:no");
}

function over(obj){
		if(obj.className=="flyoutLink")
		{
			obj.style.backgroundColor='#B5C4EC'
			obj.style.borderColor = '#380FA6'
		}
		else if(obj.className=="flyoutLink1")
		{
		    obj.style.backgroundColor='#B5C4EC'
			obj.style.borderColor = '#380FA6'				
		}
}
function out(obj){
		if(obj.className=="flyoutLink")
		{
			obj.style.backgroundColor='#eee'
			obj.style.borderColor = 'eee'
		}
		else if(obj.className=="#flyoutLink1")
		{
		    obj.style.backgroundColor='#FBF9F9'
			obj.style.borderColor = '#FBF9F9'				
		}
}

function show(d){
	if(obj=document.all(d))	obj.style.visibility="visible";

}
function hide(d){
	if(obj=document.all(d))	obj.style.visibility="hidden";
}

function JumpToLeftMenu(url){
	document.getElementById("left").src=url;
}
function JumpToMain(url){
	document.getElementById("main").src=url;
}

function tododisplay(ss){
	if(ss=="elveinfomenu") 
	{
  		document.getElementById('elveinfomenu').style.display="";
		document.getElementById('elvesysmenu').style.display="none";
	}
	else
	{
  		document.getElementById('elveinfomenu').style.display="none";
		document.getElementById('elvesysmenu').style.display="";
	}
}
</SCRIPT>
</HEAD>
<BODY bgColor="#eee" leftMargin=0 topMargin=0>
<TABLE width="100%" height="100%" border=0 cellpadding="0" cellSpacing=0>
<tr>
<td height="60">

  <TABLE width="100%" height="60" border=0 cellpadding="0" cellSpacing=0 style="background-color: #6699cc;">
    <TBODY>
      <TR> 
        <TD width="180"><div align="center"><a href="main.php" target="main" title="Elves网站管理系统"><img src="adminstyle/2/images/logo.png" border="0"></a></div></TD>
		<TD height=60> 
			<TABLE width=100% height="60" border=0 cellpadding="0" cellSpacing=0>
                <TBODY>
                  <TR align=middle> 
                    <TD width=80 onmouseout="this.style.backgroundColor=''" onmouseover="this.style.backgroundColor='#8CBDEF';tododisplay('elveinfomenu');" onclick="switchSysBarInfo();JumpToLeftMenu('Listmelve.php');" style="CURSOR: hand"> 
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr> 
                          <td><div align="center"><IMG height=32 src="adminstyle/2/images/info<?=$menufiletype?>" width=32 border=0 title="信息管理"></div></td>
                        </tr>
                        <tr> 
                          <td height="23"><div align="center"><font color="#FFFFFF"><strong>信息管理</strong></font></div></td>
                        </tr>
                      </table></TD>
                    <TD width=80 onmouseout="this.style.backgroundColor=''" onmouseover="this.style.backgroundColor='#8CBDEF';tododisplay('elvesysmenu');" onclick="return false;" style="CURSOR: hand"> 
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr> 
                          <td><div align="center"><IMG height=32 src="adminstyle/2/images/other<?=$menufiletype?>" width=32 border=0 title="功能菜单"></div></td>
                        </tr>
                        <tr> 
                          <td height="23"><div align="center"><font color="#FFFFFF"><strong>功能菜单</strong></font></div></td>
                        </tr>
                      </table></TD>
                    <TD ><div align="right" style="margin-right:15px"><font color="#ffffff">用户：<a href="user/EditPassword.php" target="main"><font color="#ffffff"><b><?=$loginin?></b></font></a>&nbsp;&nbsp;&nbsp;[<a href="#elve" onclick="if(confirm('确认要退出?')){JumpToMain('elveadmin.php?melve=exit');}"><font color="#ffffff">退出</font></a>]&nbsp;&nbsp;</font></div></TD>
                  </TR>
                </TBODY>
              </TABLE>
        
      </TD>
      </TR>
    </TBODY>
  </TABLE>

</td></tr>
<tr><td height="22">

  <TABLE width="100%" height="22" border=0 cellpadding="0" cellSpacing=0>
    <TBODY>
      <TR> 
        <TD class=flyoutMenu style="background:#eee" width="1%"> </TD>   
		    <TD width="99%" height="27"> 
              <TABLE class=flyoutMenu border=0 id="elveinfomenu">
                <TBODY>
                  <TR align=middle> 
                    <TD width="60" class="flyoutLink" onclick="JumpToMain('AddInfoChClass.php');" onmouseover="over(this)" onmouseout="out(this)">增加信息</TD>
                    <TD width="60" class="flyoutLink" onclick="JumpToMain('ListAllInfo.php');" onmouseover="over(this)" onmouseout="out(this)">管理信息</TD>
                    <TD width="60" class="flyoutLink" onclick="JumpToMain('ListAllInfo.php?elvecheck=1');" onmouseover="over(this)" onmouseout="out(this)">审核信息</TD>
                    <TD width="60" class="flyoutLink" onclick="JumpToMain('workflow/ListWfInfo.php');" onmouseover="over(this)" onmouseout="out(this)">签发信息</TD>
					<?php
					if($r[dopl])
					{
					?>
                    <TD width="60" class="flyoutLink" onclick="JumpToMain('openpage/AdminPage.php?leftfile=<?=urlencode('../pl/PlNav.php')?>&mainfile=<?=urlencode('../pl/PlMain.php')?>&title=<?=urlencode('管理评论')?>');" onmouseover="over(this)" onmouseout="out(this)">管理评论</TD>
					<?php
					}
					?>
                    <TD width="60" class="flyoutLink" onclick="JumpToMain('sp/UpdateSp.php');" onmouseover="over(this)" onmouseout="out(this)">更新碎片</TD>
					<TD width="60" class="flyoutLink" onclick="JumpToMain('special/UpdateZt.php');" onmouseover="over(this)" onmouseout="out(this)">更新专题</TD>
					<?php
					if($r[dochangedata])
					{
					?>
                    <TD width="60" class="flyoutLink" onclick="JumpToMain('ReHtml/ChangeData.php');" onmouseover="over(this)" onmouseout="out(this)">数据更新</TD>
					<?php
					}
					?>
                    <TD width="60" class="flyoutLink" onclick="JumpToMain('main.php');" onmouseover="over(this)" onmouseout="out(this)">后台首页</TD>
                    <TD width="60" class="flyoutLink" onclick="window.open('../../');" onmouseover="over(this)" onmouseout="out(this)">网站首页</TD>
                    <TD width="60" class="flyoutLink" onclick="window.open('map.php','','width=1250,height=670,scrollbars=auto,resizable=yes,top=120,left=120');" onmouseover="over(this)" onmouseout="out(this)">后台地图</TD>
                  </TR>
                </TBODY>
              </TABLE>
              <TABLE class=flyoutMenu border=0 id="elvesysmenu" style="display:none">
                <TBODY>
                  <TR align=middle> 
                    <TD width="60" class="flyoutLink" onclick="JumpToMain('user/EditPassword.php');" onmouseover="over(this)" onmouseout="out(this)">修改资料</TD>
					<?php
					if($r[doclass])
					{
					?>
                    <TD width="60" class="flyoutLink" onclick="JumpToMain('ListClass.php');" onmouseover="over(this)" onmouseout="out(this)">管理栏目</TD>
					<?php
					}
					?>
					<?php
					if($r[dozt])
					{
					?>
                    <TD width="60" class="flyoutLink" onclick="JumpToMain('special/ListZt.php');" onmouseover="over(this)" onmouseout="out(this)">管理专题</TD>
					<?php
					}
					?>
					<?php
					if($r[docj])
					{
					?>
                    <TD width="60" class="flyoutLink" onclick="JumpToMain('ListInfoClass.php');" onmouseover="over(this)" onmouseout="out(this)">管理采集</TD>
					<?php
					}
					?>
					<?php
					if($r[dofile])
					{
					?>
                    <TD width="60" class="flyoutLink" onclick="JumpToMain('file/ListFile.php?type=9');" onmouseover="over(this)" onmouseout="out(this)">管理附件</TD>
					<?php
					}
					?>
					<?php
					if($r[dosp])
					{
					?>
                    <TD width="60" class="flyoutLink" onclick="JumpToMain('sp/ListSp.php');" onmouseover="over(this)" onmouseout="out(this)">管理碎片</TD>
					<?php
					}
					?>
					<?php
					if($r[dotags])
					{
					?>
                    <TD width="60" class="flyoutLink" onclick="JumpToMain('tags/ListTags.php');" onmouseover="over(this)" onmouseout="out(this)">管理TAGS</TD>
					<?php
					}
					?>
					<?php
					if($r[dogbook])
					{
					?>
                    <TD width="60" class="flyoutLink" onclick="JumpToMain('tool/gbook.php');" onmouseover="over(this)" onmouseout="out(this)">管理留言</TD>
					<?php
					}
					?>
					<?php
					if($r[dofeedback])
					{
					?>
                    <TD width="60" class="flyoutLink" onclick="JumpToMain('tool/feedback.php');" onmouseover="over(this)" onmouseout="out(this)">管理反馈</TD>
					<?php
					}
					?>
					<?php
					if($r[dodownerror])
					{
					?>
                    <TD width="60" class="flyoutLink" onclick="JumpToMain('DownSys/ListError.php');" onmouseover="over(this)" onmouseout="out(this)">错误报告</TD>
					<?php
					}
					?>
                  </TR>
                </TBODY>
              </TABLE></TD>
      </TR>
    </TBODY>
  </TABLE>

</td></tr>
<tr><td height="100%" bgcolor="#ffffff">

  <TABLE width="100%" height="100%" cellpadding="0" cellSpacing=0 border=0 borderColor="#ff0000">
  <TBODY>
    <TR> 
      <TD width="123" valign="top" bgcolor="#eee">
		<IFRAME frameBorder="0" id="dorepage" name="dorepage" scrolling="no" src="DoTimeRepage.php" style="HEIGHT:0;VISIBILITY:inherit;WIDTH:0;Z-INDEX:1"></IFRAME>
      </TD>
      <TD noWrap id="frmTitle">
		<IFRAME frameBorder="0" id="left" name="left" scrolling="auto" src="Listmelve.php" style="HEIGHT:100%;VISIBILITY:inherit;WIDTH:200px;Z-INDEX:2"></IFRAME>
      </TD>
      <TD>
		<TABLE border=0 cellPadding=0 cellSpacing=0 height="100%" bgcolor="#f8f8f8">
          <TBODY>
            <tr> 
              <TD onclick="switchSysBar()" style="HEIGHT:100%;"> <font style="COLOR:666666;CURSOR:hand;FONT-FAMILY:Webdings;FONT-SIZE:9pt;"> 
                <SPAN id="switchPoint" title="打开/关闭左边导航栏">3</SPAN></font> 
          </TBODY>
        </TABLE>
      </TD>
      <TD width="100%">
		<TABLE height="100%" cellSpacing=0 cellPadding=0 width="100%" align="right" border=0>
          <TBODY>
            <TR> 
              <TD align=right>
				<IFRAME id="main" name="main" style="WIDTH: 100%; HEIGHT: 100%" src="main.php" frameBorder=0></IFRAME>
              </TD>
            </TR>
          </TBODY>
        </TABLE>
      </TD>
    </TR>
  </TBODY>
  </TABLE>

</td></tr>
</TABLE>

</BODY>
</HTML>