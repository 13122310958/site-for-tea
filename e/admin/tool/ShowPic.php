<?php
define('EmpireCMSAdmin','1');
require("../../class/connect.php");
$picurl=ehtmlspecialchars($_GET['picurl']);
$pic_width=ehtmlspecialchars($_GET['pic_width']);
$pic_height=ehtmlspecialchars($_GET['pic_height']);
$url=ehtmlspecialchars($_GET['url']);
?>
<title>���Ԥ��</title>
<a href="<?=$url?>" target=_blank><img src="<?=$picurl?>" border=0 width=<?=$pic_width?> height=<?=$pic_height?>></a>
