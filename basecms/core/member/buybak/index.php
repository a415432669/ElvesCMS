<?php
require("../../class/connect.php");
require("../../class/db_sql.php");
require("../../class/q_functions.php");
require("../class/user.php");
require "../".LoadLang("pub/fun.php");
$link=db_connect();
$Elves=new mysqlquery();
$editor=1;
eCheckCloseMods('member');//关闭模块
//是否登陆
$user=islogin();
$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$start=0;
$line=25;//每页显示条数
$page_line=12;//每页显示链接数
$offset=$page*$line;//总偏移量
$totalquery="select count(*) as total from {$dbtbpre}melvebuybak where userid='$user[userid]'";
$num=$Elves->gettotal($totalquery);//取得总条数
$query="select * from {$dbtbpre}melvebuybak where userid='$user[userid]'";
$query=$query." order by buytime desc limit $offset,$line";
$sql=$Elves->query($query);
$returnpage=page1($num,$line,$page_line,$start,$page,$search);
//导入模板
require(elve_PATH.'core/template/member/buybak.php');
db_close();
$Elves=null;
?>