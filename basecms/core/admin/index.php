<?php
define('ElvesCMSAdmin','1');
define('ElvesCMSAPage','login');
define('ElvesCMSNFPage','1');
require("../class/connect.php");
require("../class/functions.php");
//风格
$loginadminstyleid=elveReturnAdminStyle();
//变量处理
$Elvescmskey1='';
$Elvescmskey2='';
$Elvescmskey3='';
$Elvescmskey4='';
$Elvescmskey5='';
if($_POST['Elvescmskey1']&&$_POST['Elvescmskey2']&&$_POST['Elvescmskey3']&&$_POST['Elvescmskey4']&&$_POST['Elvescmskey5'])
{
	$Elvescmskey1=RepPostVar($_POST['Elvescmskey1']);
	$Elvescmskey2=RepPostVar($_POST['Elvescmskey2']);
	$Elvescmskey3=RepPostVar($_POST['Elvescmskey3']);
	$Elvescmskey4=RepPostVar($_POST['Elvescmskey4']);
	$Elvescmskey5=RepPostVar($_POST['Elvescmskey5']);
	$ecertkeyrndstr=$Elvescmskey1.'#!#'.$Elvescmskey2.'#!#'.$Elvescmskey3.'#!#'.$Elvescmskey4.'#!#'.$Elvescmskey5;
	esetcookie('ecertkeyrnds',$ecertkeyrndstr,0);
}
elseif(getcvar('ecertkeyrnds'))
{
	$certr=explode('#!#',getcvar('ecertkeyrnds'));
	$Elvescmskey1=RepPostVar($certr[0]);
	$Elvescmskey2=RepPostVar($certr[1]);
	$Elvescmskey3=RepPostVar($certr[2]);
	$Elvescmskey4=RepPostVar($certr[3]);
	$Elvescmskey5=RepPostVar($certr[4]);
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Elves网站管理系统</title>

<base onmouseover="window.status='Elves网站管理系统(ElvesCMS) ';return true">
<script>
if(self!=top)
{
	parent.location.href='index.php';
}
function CheckLogin(obj){
	if(obj.username.value=='')
	{
		alert('请输入用户名');
		obj.username.focus();
		return false;
	}
	if(obj.password.value=='')
	{
		alert('请输入登录密码');
		obj.password.focus();
		return false;
	}
	if(obj.loginauth!=null)
	{
		if(obj.loginauth.value=='')
		{
			alert('请输入认证码');
			obj.loginauth.focus();
			return false;
		}
	}
	if(obj.key!=null)
	{
		if(obj.key.value=='')
		{
			alert('请输入验证码');
			obj.key.focus();
			return false;
		}
	}
	return true;
}
</script>
<style>
  
  h1{font-size: 26px;font-family: '微软雅黑';color: #fcff00;}
  h1 em{font-size: 14px;padding: 0px;color: #fff;}
  .ctable{background-color: #3399ff;}
    .ctable td{color: #fff;font-size: 14px;padding: 5px;}
    .ctable td input,.ctable td select{border: 1px solid #fff;line-height: 25px;height: 25px;}
    button{height: 40px;padding-left: 20px;padding-right: 20px;}
</style>
</head>

<body text="383636"  onload="document.login.username.focus();">
<table width="98" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr> 
    <td height="60">&nbsp;</td>
  </tr>
</table>
<table width="524" border="0"  class="ctable"cellspacing="0" cellpadding="0" align="center" height="320">
  <form name="login" id="login" method="post" action="elveadmin.php" onsubmit="return CheckLogin(document.login);">
    <input type="hidden" name="melve" value="login">
    <tr> 
      <td width="61" rowspan="3" valign="top"></td>
      <td colspan="3"></td>
    </tr>
    <tr> 
      <td width="241" valign="top" >
       <h1>管理系统  <em>后台登录</em> </h1> 
      </td>
      <td width="157" rowspan="2" valign="top" > 
     </td>
      <td width="65" rowspan="2" valign="top"> 
       
      </td>
    </tr>
    <tr> 
      <td height="80"> <table width="230" height="100%" border="0" align="right" cellpadding="0" cellspacing="0">
          <tr> 
            <td width="50" height="27">用户名: </td>
            <td colspan="2"> <input name="username" type="text" class="b-form2" size="24"> 
            </td>
          </tr>
          <tr> 
            <td height="27">密&nbsp;&nbsp;码:&nbsp;</td>
            <td colspan="2"> <input name="password" type="password" class="b-form2" size="24"> 
            </td>
          </tr>
		  <?php
		  if($elve_config['esafe']['loginauth'])
		  {
		  ?>
          <tr> 
            <td height="27">认证码:&nbsp;</td>
            <td colspan="2"><input name="loginauth" type="password" id="loginauth" class="b-form2" size="24"></td>
          </tr>
          <?php
		  }
		  ?>
          <tr>
            <td height="27">提&nbsp;&nbsp;问:&nbsp;</td>
            <td colspan="2"><select name="equestion" id="equestion" onchange="if(this.options[this.selectedIndex].value==0){showanswer.style.display='none';}else{showanswer.style.display='';}">
                <option value="0">无安全提问</option>
                <option value="1">母亲的名字</option>
                <option value="2">爷爷的名字</option>
                <option value="3">父亲出生的城市</option>
                <option value="4">您其中一位老师的名字</option>
                <option value="5">您个人计算机的型号</option>
                <option value="6">您最喜欢的餐馆名称</option>
                <option value="7">驾驶执照的最后四位数字</option>
              </select></td>
          </tr>
          <tr id="showanswer">
            <td height="27">答&nbsp;&nbsp;案:&nbsp;</td>
            <td colspan="2"><input name="eanswer" type="text" id="eanswer" class="b-form2" size="24"></td>
          </tr>
          <?php
		  if(empty($public_r['adminloginkey']))
		  {
		  ?>
          <tr> 
            <td height="27">验证码:&nbsp;</td>
            <td width="83"> <input name="key" type="text" class="b-form2" size="9"> 
            </td>
            <td width="97"><img src="ShowKey.php" name="KeyImg" id="KeyImg" align="bottom" onclick="KeyImg.src='ShowKey.php?'+Math.random()" alt="看不清楚,点击刷新"></td>
          </tr>
          <?php
		  }
		  ?>
         <!-- <tr> 
            <td height="27">窗&nbsp;&nbsp;口:&nbsp;</td>
            <td colspan="2"><input type="radio" name="adminwindow" value="0" checked>
              正常 
              <input type="radio" name="adminwindow" value="1">
              全屏</td>
          </tr>-->
          <tr> 
            <td height="27">&nbsp;</td>
            <td colspan="2" valign="bottom"> 
              <button type="submit">登录</button>
            </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td colspan="4"><table width="100%" border="0" cellpadding="0" cellspacing="0" >
          <tr> 
            <td width="111" height="32">&nbsp;</td>
            <td width="111" valign="top">&nbsp;</td>
            <td width="302"><input name="Elvescmskey1" type="hidden" id="Elvescmskey1" value="<?php echo $Elvescmskey1;?>">
              <input name="Elvescmskey2" type="hidden" id="Elvescmskey2" value="<?php echo $Elvescmskey2;?>">
              <input name="Elvescmskey3" type="hidden" id="Elvescmskey3" value="<?php echo $Elvescmskey3;?>">
              <input name="Elvescmskey4" type="hidden" id="Elvescmskey4" value="<?php echo $Elvescmskey4;?>">
              <input name="Elvescmskey5" type="hidden" id="Elvescmskey5" value="<?php echo $Elvescmskey5;?>"></td>
          </tr>
        </table></td>
    </tr>

  </form>
</table>
<script>
if(document.login.equestion.value==0)
{
	showanswer.style.display='none';
}
</script>
</body>
</html>