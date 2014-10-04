<?php

//��֤��¼��ʽ
function MemberConnect_CheckApptype($apptype){
	global $empire,$dbtbpre;
	$appr=$empire->fetch1("select * from {$dbtbpre}enewsmember_connect_app where apptype='$apptype' and isclose=0 limit 1");
	if(!$appr['id'])
	{
		printerror2('��ѡ���¼��ʽ','../../../');
	}
	return $appr;
}

//��֤openid
function MemberConnect_CheckOpenid($apptype,$openid){
	global $empire,$dbtbpre;
	$mcr['id']=0;
	$mcr['userid']=0;
	if(!$apptype||!trim($openid))
	{
		return $mcr;
	}
	$mcr=$empire->fetch1("select id,userid from {$dbtbpre}enewsmember_connect where apptype='$apptype' and bindkey='$openid' limit 1");
	return $mcr;
}

//������¼
function MemberConnect_DoLogin($apptype,$openid){
	global $empire,$dbtbpre;
	$apptype=RepPostVar($apptype);
	$openid=RepPostVar($openid);
	$mcr=MemberConnect_CheckOpenid($apptype,$openid);
	if($mcr['id'])
	{
		$lifetime=0;
		$r=$empire->fetch1("select ".eReturnSelectMemberF('*')." from ".eReturnMemberTable()." where ".egetmf('userid')."='".$mcr['userid']."' limit 1");
		DoEcmsMemberLogin($r,$lifetime);
		MemberConnect_UpdateBindLogin($mcr['id']);
		MemberConnect_ResetVar();
		printerrortourl('../../../');
	}
	else
	{
		printerrortourl('../tobind.php');
	}
}

//���µ�¼��
function MemberConnect_UpdateBindLogin($id){
	global $empire,$dbtbpre;
	$id=(int)$id;
	$lasttime=time();
	$empire->query("update {$dbtbpre}enewsmember_connect set loginnum=loginnum+1,lasttime='$lasttime' where id='$id' limit 1");
}

//д���½��
function MemberConnect_InsertBind($apptype,$openid,$userid){
	global $empire,$dbtbpre;
	$apptype=RepPostVar($apptype);
	$openid=RepPostVar($openid);
	$userid=(int)$userid;
	$time=time();
	//��֤�Ƿ��ظ�
	MemberConnect_CheckReBind($apptype,$userid);
	$empire->query("insert into {$dbtbpre}enewsmember_connect(userid,apptype,bindkey,bindtime,loginnum,lasttime) values('$userid','$apptype','$openid','$time',1,'$time');");
}

//��֤�Ƿ�󶨹�
function MemberConnect_CheckReBind($apptype,$userid){
	global $empire,$dbtbpre;
	$num=$empire->gettotal("select count(*) as total from {$dbtbpre}enewsmember_connect where userid='$userid' and apptype='$apptype' limit 1");
	if($num)
	{
		printerror2("���ʺ��Ѱ󶨹��������ظ���","history.go(-1)");
	}
}

//ɾ����½��
function MemberConnect_DelBind($id){
	global $empire,$dbtbpre,$public_r;
	$user_r=islogin();//�Ƿ��½
	$id=(int)$id;
	$sql=$empire->query("delete from {$dbtbpre}enewsmember_connect where id='$id' and userid='$user_r[userid]';");
	if($sql)
	{
		printerror2("�ѽ����","../memberconnect/ListBind.php");
	}
	else
	{
		printerror("DbError","history.go(-1)",1);
	}
}

//ԭ�ʺŰ󶨵�¼
function MemberConnect_BindUser($userid){
	global $empire,$dbtbpre,$public_r;
	$apptype=RepPostVar($_SESSION['apptype']);
	$openid=RepPostVar($_SESSION['openid']);
	if(!trim($apptype)||!trim($openid))
	{
		printerror2('���Ե����Ӳ�����','../../../');
	}
	$appr=MemberConnect_CheckApptype($apptype);//��֤��¼��ʽ
	MemberConnect_CheckBindKey($apptype,$openid);
	MemberConnect_InsertBind($apptype,$openid,$userid);
	MemberConnect_ResetVar();
}

//����֤��
function MemberConnect_GetBindKey($apptype,$openid){
	global $ecms_config;
	$checkpass=md5(md5('check-'.$apptype.'-empirecms-'.$openid).'-#empire.cms!-'.$openid.'-|-empirecms-|-'.$ecms_config['cks']['ckrndtwo']);
	return $checkpass;
}

//��֤����֤��
function MemberConnect_CheckBindKey($apptype,$openid){
	global $ecms_config;
	$pass=md5(md5('check-'.$apptype.'-empirecms-'.$openid).'-#empire.cms!-'.$openid.'-|-empirecms-|-'.$ecms_config['cks']['ckrndtwo']);
	$checkpass=$_SESSION['openidkey'];
	if($pass!=$checkpass)
	{
		printerror2('���Ե����Ӳ�����','../../../');
	}
}

//���ñ���
function MemberConnect_ResetVar(){
	$_SESSION['state']='';
	$_SESSION['openid']='';
	$_SESSION['apptype']='';
	$_SESSION['openidkey']='';
}
?>