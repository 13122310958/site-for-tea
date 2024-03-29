<?php
//返回参数内容
function ReturnSettingString($r){
	$filename='data/setting.txt';
	$text=ReadFiletext($filename);
	//后台安全
	$text=str_replace('[!@--do_loginauth--@!]',addslashes($r[do_loginauth]),$text);
	$text=str_replace('[!@--do_ecookiernd--@!]',addslashes($r[do_ecookiernd]),$text);
	$text=str_replace('[!@--do_ckhloginfile--@!]',intval($r[do_ckhloginfile]),$text);
	$text=str_replace('[!@--do_ckhloginip--@!]',intval($r[do_ckhloginip]),$text);
	$text=str_replace('[!@--do_ckhsession--@!]',intval($r[do_ckhsession]),$text);
	$text=str_replace('[!@--do_theloginlog--@!]',intval($r[do_theloginlog]),$text);
	$text=str_replace('[!@--do_thedolog--@!]',intval($r[do_thedolog]),$text);
	$text=str_replace('[!@--do_ckfromurl--@!]',intval($r[do_ckfromurl]),$text);
	//COOKIE
	$text=str_replace('[!@--phome_cookiedomain--@!]',addslashes($r[phome_cookiedomain]),$text);
	$text=str_replace('[!@--phome_cookiepath--@!]',addslashes($r[phome_cookiepath]),$text);
	$text=str_replace('[!@--phome_cookievarpre--@!]',addslashes($r[phome_cookievarpre]),$text);
	$text=str_replace('[!@--phome_cookieadminvarpre--@!]',addslashes($r[phome_cookieadminvarpre]),$text);
	$text=str_replace('[!@--phome_cookieckrnd--@!]',addslashes($r[phome_cookieckrnd]),$text);
	$text=str_replace('[!@--phome_cookieckrndtwo--@!]',addslashes($r[phome_cookieckrndtwo]),$text);
	//防火墙
	$text=str_replace('[!@--efw_open--@!]',intval($r[efw_open]),$text);
	$text=str_replace('[!@--efw_pass--@!]',addslashes($r[efw_pass]),$text);
	$text=str_replace('[!@--efw_adminloginurl--@!]',addslashes($r[efw_adminloginurl]),$text);
	$text=str_replace('[!@--efw_adminhour--@!]',addslashes($r[efw_adminhour]),$text);
	$text=str_replace('[!@--efw_adminweek--@!]',addslashes($r[efw_adminweek]),$text);
	$text=str_replace('[!@--efw_adminckpassvar--@!]',addslashes($r[efw_adminckpassvar]),$text);
	$text=str_replace('[!@--efw_adminckpassval--@!]',addslashes($r[efw_adminckpassval]),$text);
	$text=str_replace('[!@--efw_cleargettext--@!]',addslashes($r[efw_cleargettext]),$text);
	return $text;
}

//生成配置文件
function GetSettingConfig($string){
	$filename=ECMS_PATH."e/config/config.php";
	$exp='//-------EmpireCMS.Seting.area-------';
	$text=ReadFiletext($filename);
	$r=explode($exp,$text);
	if($r[0]=='')
	{
		return false;
	}
	$r[1]=$string;
	$setting=$r[0].$exp.$r[1].$exp.$r[2];
	WriteFiletext_n($filename,$setting);
}

//防火墙设置
function SetFirewall($add,$userid,$username){
	global $ecms_config;
	$r[efw_open]=(int)$add[fw_open];
	$r[efw_pass]=$add[fw_pass];
	$r[efw_adminloginurl]=$add[fw_adminloginurl];
	//时间点
	$hour=$add['fw_adminhour'];
	$hcount=count($hour);
	$adminhour='';
	if($hcount)
	{
		$dh='';
		for($i=0;$i<$hcount;$i++)
		{
			$adminhour.=$dh.intval($hour[$i]);
			$dh=',';
		}
	}
	$r[efw_adminhour]=$adminhour;
	//星期
	$week=$add['fw_adminweek'];
	$wcount=count($week);
	$adminweek='';
	if($wcount)
	{
		$dh='';
		for($i=0;$i<$wcount;$i++)
		{
			$adminweek.=$dh.intval($week[$i]);
			$dh=',';
		}
	}
	$r[efw_adminweek]=$adminweek;
	$r[efw_adminckpassvar]=$add[fw_adminckpassvar];
	$r[efw_adminckpassval]=$add[fw_adminckpassval];
	$r[efw_cleargettext]=$add[fw_cleargettext];
	//原来设置
	$r[do_loginauth]=$ecms_config['esafe']['loginauth'];
	$r[do_ecookiernd]=$ecms_config['esafe']['ecookiernd'];
	$r[do_ckhloginfile]=$ecms_config['esafe']['ckhloginfile'];
	$r[do_ckhloginip]=$ecms_config['esafe']['ckhloginip'];
	$r[do_ckhsession]=$ecms_config['esafe']['ckhsession'];
	$r[do_theloginlog]=$ecms_config['esafe']['theloginlog'];
	$r[do_thedolog]=$ecms_config['esafe']['thedolog'];
	$r[do_ckfromurl]=$ecms_config['esafe']['ckfromurl'];

	$r[phome_cookiedomain]=$ecms_config['cks']['ckdomain'];
	$r[phome_cookiepath]=$ecms_config['cks']['ckpath'];
	$r[phome_cookievarpre]=$ecms_config['cks']['ckvarpre'];
	$r[phome_cookieadminvarpre]=$ecms_config['cks']['ckadminvarpre'];
	$r[phome_cookieckrnd]=$ecms_config['cks']['ckrnd'];
	$r[phome_cookieckrndtwo]=$ecms_config['cks']['ckrndtwo'];
	$string=ReturnSettingString($r);
	GetSettingConfig($string);
	//操作日志
	insert_dolog('');
	if(($r[efw_open]&&!$ecms_config['fw']['eopen'])||$ecms_config['fw']['epass']!=$r[efw_pass]||$ecms_config['fw']['adminckpassvar']!=$r[efw_adminckpassvar]||$ecms_config['fw']['adminckpassval']!=$r[efw_adminckpassval])
	{
		printerror('SetFirewallSuccessLogin','../index.php');
	}
	printerror('SetFirewallSuccess','SetFirewall.php');
}

//安全设置
function SetSafe($add,$userid,$username){
	global $ecms_config;
	$r[do_loginauth]=$add[loginauth];
	$r[do_ecookiernd]=$add[ecookiernd];
	$r[do_ckhloginfile]=(int)$add[ckhloginfile];
	$r[do_ckhloginip]=(int)$add[ckhloginip];
	$r[do_ckhsession]=(int)$add[ckhsession];
	$r[do_theloginlog]=(int)$add[theloginlog];
	$r[do_thedolog]=(int)$add[thedolog];
	$r[do_ckfromurl]=(int)$add[ckfromurl];

	$r[phome_cookiedomain]=$add[cookiedomain];
	$r[phome_cookiepath]=$add[cookiepath];
	$r[phome_cookievarpre]=$add[cookievarpre];
	$r[phome_cookieadminvarpre]=$add[cookieadminvarpre];
	$r[phome_cookieckrnd]=$add[cookieckrnd];
	$r[phome_cookieckrndtwo]=$add[cookieckrndtwo];
	//原来设置
	$r[efw_open]=$ecms_config['fw']['eopen'];
	$r[efw_pass]=$ecms_config['fw']['epass'];
	$r[efw_adminloginurl]=$ecms_config['fw']['adminloginurl'];
	$r[efw_adminhour]=$ecms_config['fw']['adminhour'];
	$r[efw_adminweek]=$ecms_config['fw']['adminweek'];
	$r[efw_adminckpassvar]=$ecms_config['fw']['adminckpassvar'];
	$r[efw_adminckpassval]=$ecms_config['fw']['adminckpassval'];
	$r[efw_cleargettext]=$ecms_config['fw']['cleargettext'];
	$string=ReturnSettingString($r);
	GetSettingConfig($string);
	//操作日志
	insert_dolog('');
	if($ecms_config['esafe']['ecookiernd']!=$r[do_ecookiernd]||$ecms_config['cks']['ckadminvarpre']!=$r[phome_cookieadminvarpre])
	{
		printerror('SetSafeSuccessLogin','../index.php');
	}
	printerror('SetSafeSuccess','SetSafe.php');
}
?>