<?php
require('../../class/connect.php');
require("../../class/db_sql.php");
require('../../member/class/user.php');
$link=db_connect();
$Elves=new mysqlquery();
$editor=1;
eCheckCloseMods('member');//关闭模块
$tobind=(int)$_GET['tobind'];
if($elve_config['member']['loginurl'])
{
	Header("Location:".$elve_config['member']['loginurl']);
	exit();
}
//导入模板
require(elve_PATH.'core/template/member/login.php');
db_close();
$Elves=null;
?>
