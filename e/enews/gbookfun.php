<?php
//发表留言
function AddGbook($add){
	global $empire,$dbtbpre,$level_r,$public_r;
	//验证本时间允许操作
	eCheckTimeCloseDo('gbook');
	//验证IP
	eCheckAccessDoIp('gbook');
	CheckCanPostUrl();//验证来源
	if($add['bid'])
	{
		$bid=(int)$add['bid'];
	}
	else
	{
		$bid=(int)getcvar('gbookbid');
	}
	$name=RepPostStr(trim($add[name]));
	$email=RepPostStr($add[email]);
	$mycall=RepPostStr($add[mycall]);
	$lytext=RepPostStr($add[lytext]);
	if(empty($bid)||empty($name)||empty($email)||!trim($lytext))
	{
		printerror("EmptyGbookname","history.go(-1)",1);
    }
	if(!chemail($email))
	{
		printerror("EmailFail","history.go(-1)",1);
	}
	//验证码
	$keyvname='checkgbookkey';
	if($public_r['gbkey_ok'])
	{
		ecmsCheckShowKey($keyvname,$add['key'],1);
	}
	$lasttime=getcvar('lastgbooktime');
	if($lasttime)
	{
		if(time()-$lasttime<$public_r['regbooktime'])
		{
			printerror("GbOutTime","",1);
		}
	}
	//版面是否存在
	$br=$empire->fetch1("select bid,checked,groupid from {$dbtbpre}enewsgbookclass where bid='$bid';");
	if(empty($br[bid]))
	{
		printerror("EmptyGbook","history.go(-1)",1);
	}
	//权限
	if($br['groupid'])
	{
		$user=islogin();
		if($level_r[$br[groupid]][level]>$level_r[$user[groupid]][level])
		{
			printerror("HaveNotEnLevel","history.go(-1)",1);
		}
	}
	$lytime=date("Y-m-d H:i:s");
	$ip=egetip();
	$userid=(int)getcvar('mluserid');
	$username=RepPostVar(getcvar('mlusername'));
	$sql=$empire->query("insert into {$dbtbpre}enewsgbook(name,email,`mycall`,lytime,lytext,retext,bid,ip,checked,userid,username) values('$name','$email','$mycall','$lytime','$lytext','','$bid','$ip','$br[checked]','$userid','$username');");
	ecmsEmptyShowKey($keyvname);//清空验证码
	if($sql)
	{
		esetcookie("lastgbooktime",time(),time()+3600*24);//设置最后发表时间
		$reurl=DoingReturnUrl("../tool/gbook/?bid=$bid",$add['ecmsfrom']);
		printerror("AddGbookSuccess",$reurl,1);
	}
	else
	{printerror("DbError","history.go(-1)",1);}
}
?>