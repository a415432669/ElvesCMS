<?php
require("../../class/connect.php");
require("../../class/q_functions.php");
require("../../class/db_sql.php");
require("../class/user.php");
require "../".LoadLang("pub/fun.php");
$link=db_connect();
$Elves=new mysqlquery();
$editor=1;
eCheckCloseMods('member');//关闭模块
$user=islogin();
$line=12;
$page_line=12;
$start=0;
$page=(int)$_GET['page'];
$page=RepPIntvar($page);
$offset=$page*$line;
$totalquery="select count(*) as total from {$dbtbpre}melvemembergbook where userid='$user[userid]'";
$num=$Elves->gettotal($totalquery);
$query="select gid,isprivate,uid,uname,ip,addtime,gbtext,retext from {$dbtbpre}melvemembergbook where userid='$user[userid]'";
$query.=" order by gid desc limit $offset,$line";
$sql=$Elves->query($query);
$returnpage=page1($num,$line,$page_line,$start,$page,$search);
//导入模板
require(elve_PATH.'core/template/member/mspace/gbook.php');
db_close();
$Elves=null;
?>