<?php
//************************************ ���ݱ� ************************************

//������ʼ��
function AddTableDefault($tbname,$tid){
	global $empire,$dbtbpre,$ecms_config;
	include("db/DefaultTable.php");
	//δ��˱�
	$otb=$dbtbpre."ecms_".$tbname;
	$tb=$otb."_check";
	CopyEcmsTb($otb,$tb);
	$odtb=$dbtbpre."ecms_".$tbname."_data_1";
	$dtb=$tb."_data";
	CopyEcmsTb($odtb,$dtb);
	//���ƴ浵��
	$otb=$dbtbpre."ecms_".$tbname;
	$tb=$otb."_doc";
	CopyEcmsTb($otb,$tb);
	$odtb=$dbtbpre."ecms_".$tbname."_data_1";
	$dtb=$tb."_data";
	CopyEcmsTb($odtb,$dtb);
	$optb=$dbtbpre."ecms_".$tbname."_index";
	$ptb=$tb."_index";
	CopyEcmsTb($optb,$ptb);
}

//�������ݱ�
function CopyNewTable($add,$userid,$username){
	global $empire,$dbtbpre;
	$tid=(int)$add['tid'];
	$newtbname=RepPostVar(strtolower(trim($add[newtbname])));
	if(!$tid||empty($newtbname)||!$add[tname])
	{
		printerror("EmptyTbname","");
	}
	CheckLevel($userid,$username,$classid,"table");//����Ȩ��
	$add[yhid]=(int)$add[yhid];
	$tr=$empire->fetch1("select tbname,intb from {$dbtbpre}enewstable where tid='$tid'");
	if(!$tr[tbname])
	{
		printerror("EmptyTbname","");
	}
	$num=$empire->gettotal("select count(*) as total from {$dbtbpre}enewstable where tbname='$newtbname' limit 1");
	if($num)
	{
		printerror("ReTbname","history.go(-1)");
	}
	$sql=$empire->query("insert into {$dbtbpre}enewstable(tbname,tname,tsay,isdefault,datatbs,deftb,yhid,mid,intb) values('$newtbname','$add[tname]','$add[tsay]',0,',1,','1','$add[yhid]',0,'$tr[intb]');");
	$newtid=$empire->lastid();
	//���Ʊ�
	CopyEcmsTb($dbtbpre."ecms_".$tr['tbname'],$dbtbpre."ecms_".$newtbname);	//���ݱ�
	CopyEcmsTb($dbtbpre."ecms_".$tr['tbname']."_data_1",$dbtbpre."ecms_".$newtbname."_data_1");	//���ݸ���
	CopyEcmsTb($dbtbpre."ecms_".$tr['tbname']."_index",$dbtbpre."ecms_".$newtbname."_index");	//����������
	CopyEcmsTb($dbtbpre."ecms_".$tr['tbname']."_doc",$dbtbpre."ecms_".$newtbname."_doc");	//�鵵��
	CopyEcmsTb($dbtbpre."ecms_".$tr['tbname']."_doc_data",$dbtbpre."ecms_".$newtbname."_doc_data");	//�鵵����
	CopyEcmsTb($dbtbpre."ecms_".$tr['tbname']."_doc_index",$dbtbpre."ecms_".$newtbname."_doc_index");	//�鵵������
	CopyEcmsTb($dbtbpre."ecms_".$tr['tbname']."_check",$dbtbpre."ecms_".$newtbname."_check");	//��˱�
	CopyEcmsTb($dbtbpre."ecms_".$tr['tbname']."_check_data",$dbtbpre."ecms_".$newtbname."_check_data");	//��˸���
	CopyEcmsTb($dbtbpre."ecms_infoclass_".$tr['tbname'],$dbtbpre."ecms_infoclass_".$newtbname);	//�ɼ��ڵ㸽�ӱ�
	CopyEcmsTb($dbtbpre."ecms_infotmp_".$tr['tbname'],$dbtbpre."ecms_infotmp_".$newtbname);	//�ɼ�������ʱ��
	//�ֶ�����
	$fsql=$empire->query("select * from {$dbtbpre}enewsf where tid=$tid order by fid");
	while($fr=$empire->fetch($fsql))
	{
		$usql=$empire->query("insert into {$dbtbpre}enewsf(f,fname,fform,fhtml,fzs,isadd,isshow,iscj,cjhtml,myorder,ftype,flen,dotemp,tid,tbname,savetxt,fvalue,iskey,tobr,dohtml,qfhtml,isonly,linkfieldval,samedata,fformsize,tbdataf,ispage,adddofun,editdofun,qadddofun,qeditdofun,linkfieldtb,linkfieldshow,editorys,issmalltext,fmvnum) values('$fr[f]','$fr[fname]','$fr[fform]','".addslashes(addslashes(stripSlashes($fr['fhtml'])))."','".addslashes(stripSlashes($fr[fzs]))."',$fr[isadd],$fr[isshow],$fr[iscj],'".addslashes(addslashes(stripSlashes($fr[cjhtml])))."',$fr[myorder],'$fr[ftype]','$fr[flen]',$fr[dotemp],$newtid,'$newtbname',$fr[savetxt],'".addslashes(addslashes(stripSlashes($fr[fvalue])))."',$fr[iskey],$fr[tobr],$fr[dohtml],'".addslashes(addslashes(stripSlashes($fr[qfhtml])))."','$fr[isonly]','".addslashes(stripSlashes($fr[linkfieldval]))."','$fr[samedata]','".addslashes(stripSlashes($fr[fformsize]))."','$fr[tbdataf]','$fr[ispage]','".addslashes(stripSlashes($fr[adddofun]))."','".addslashes(stripSlashes($fr[editdofun]))."','".addslashes(stripSlashes($fr[qadddofun]))."','".addslashes(stripSlashes($fr[qeditdofun]))."','".addslashes(stripSlashes($fr[linkfieldtb]))."','".addslashes(stripSlashes($fr[linkfieldshow]))."','$fr[editorys]','$fr[issmalltext]','".addslashes(stripSlashes($fr[fmvnum]))."');");
	}
	TogSaveTxtF(1);//��������
	GetConfig(1);//���»���
	if($sql)
	{
		//������־
		insert_dolog("tid=".$tid."<br>tb=".$tr[tbname]."<br>newtid=".$newtid."<br>newtb=".$newtbname);
		printerror("CopyTbSuccess","db/ListTable.php");
	}
	else
	{
		printerror("DbError","");
	}
}

//�������ݱ�
function AddTable($add,$userid,$username){
	global $empire,$dbtbpre;
	$add[tbname]=RepPostVar(strtolower(trim($add[tbname])));
	if(!$add[tbname]||!$add[tname])
	{
		printerror("EmptyTbname","history.go(-1)");
    }
	//����Ȩ��
	CheckLevel($userid,$username,$classid,"table");
	$add[yhid]=(int)$add[yhid];
	$add['intb']=(int)$add['intb'];
	$num=$empire->gettotal("select count(*) as total from {$dbtbpre}enewstable where tbname='$add[tbname]' limit 1");
	if($num)
	{
		printerror("ReTbname","history.go(-1)");
	}
	$sql=$empire->query("insert into {$dbtbpre}enewstable(tbname,tname,tsay,isdefault,datatbs,deftb,yhid,intb) values('$add[tbname]','$add[tname]','$add[tsay]',0,',1,','1','$add[yhid]','$add[intb]');");
	$tid=$empire->lastid();
	//��ʹ����
	AddTableDefault($add[tbname],$tid);
	GetConfig(1);//���»���
	if($sql)
	{
		//������־
		insert_dolog("tid=".$tid."<br>tbname=".$add[tbname]);
		printerror("AddTbSuccess","db/AddTable.php?enews=AddTable");
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//�޸����ݱ�
function EditTable($add,$userid,$username){
	global $empire,$dbtbpre;
	$add[tbname]=RepPostVar(strtolower(trim($add[tbname])));
	$tid=(int)$add[tid];
	if(!$add[tbname]||!$add[tname]||!$tid)
	{
		printerror("EmptyTbname","history.go(-1)");
    }
	//����Ȩ��
	CheckLevel($userid,$username,$classid,"table");
	$add[yhid]=(int)$add[yhid];
	$add['intb']=(int)$add['intb'];
	//�ı����ݱ���
	if($add[tbname]!=$add[oldtbname])
	{
		$add[oldtbname]=RepPostVar($add[oldtbname]);
		$tbnum=$empire->gettotal("select count(*) as total from {$dbtbpre}enewstable where tbname='$add[tbname]' and tid<>$tid limit 1");
		if($tbnum)
		{
			printerror("ReTbname","history.go(-1)");
		}
		$tbr=$empire->fetch1("select tid,isdefault,datatbs,deftb from {$dbtbpre}enewstable where tid='$tid' limit 1");
		if(!$tbr['tid'])
		{
			printerror("EmptyTbname","history.go(-1)");
		}
		//����
		$empire->query("ALTER TABLE `{$dbtbpre}ecms_".$add[oldtbname]."` RENAME `{$dbtbpre}ecms_".$add[tbname]."`;");
		//������
		$empire->query("ALTER TABLE `{$dbtbpre}ecms_".$add[oldtbname]."_index` RENAME `{$dbtbpre}ecms_".$add[tbname]."_index`;");
		//����
		if($tbr['datatbs'])
		{
			$dtbr=explode(',',$tbr['datatbs']);
			$count=count($dtbr);
			for($i=1;$i<$count-1;$i++)
			{
				$empire->query("ALTER TABLE `{$dbtbpre}ecms_".$add[oldtbname]."_data_".$dtbr[$i]."` RENAME `{$dbtbpre}ecms_".$add[tbname]."_data_".$dtbr[$i]."`;");
			}
		}
		//�鵵��
		$empire->query("ALTER TABLE `{$dbtbpre}ecms_".$add[oldtbname]."_doc` RENAME `{$dbtbpre}ecms_".$add[tbname]."_doc`;");
		$empire->query("ALTER TABLE `{$dbtbpre}ecms_".$add[oldtbname]."_doc_data` RENAME `{$dbtbpre}ecms_".$add[tbname]."_doc_data`;");
		$empire->query("ALTER TABLE `{$dbtbpre}ecms_".$add[oldtbname]."_doc_index` RENAME `{$dbtbpre}ecms_".$add[tbname]."_doc_index`;");
		//��˱�
		$empire->query("ALTER TABLE `{$dbtbpre}ecms_".$add[oldtbname]."_check` RENAME `{$dbtbpre}ecms_".$add[tbname]."_check`;");
		$empire->query("ALTER TABLE `{$dbtbpre}ecms_".$add[oldtbname]."_check_data` RENAME `{$dbtbpre}ecms_".$add[tbname]."_check_data`;");
		//�ɼ�
	    $empire->query("ALTER TABLE `{$dbtbpre}ecms_infoclass_".$add[oldtbname]."` RENAME `{$dbtbpre}ecms_infoclass_".$add[tbname]."`;");
		$empire->query("ALTER TABLE `{$dbtbpre}ecms_infotmp_".$add[oldtbname]."` RENAME `{$dbtbpre}ecms_infotmp_".$add[tbname]."`;");
		//�ֶ�
		$empire->query("update {$dbtbpre}enewsf set tbname='$add[tbname]' where tid='$tid'");
		//��Ŀ
		$empire->query("update {$dbtbpre}enewsclass set tbname='$add[tbname]' where tid='$tid'");
		//$empire->query("update {$dbtbpre}enewszt set tbname='$add[tbname]' where tid='$tid'");
		$empire->query("update {$dbtbpre}enewsinfoclass set tbname='$add[tbname]' where tid='$tid'");
		$empire->query("update {$dbtbpre}enewsmod set tbname='$add[tbname]' where tid='$tid'");
		$empire->query("update {$dbtbpre}enewsinfotype set tbname='$add[tbname]' where tid='$tid'");
		//����
		$empire->query("update {$dbtbpre}enewssearch set tbname='$add[tbname]' where tbname='$add[oldtbname]'");
		$empire->query("update {$dbtbpre}enewssearchall_load set tbname='$add[tbname]' where tbname='$add[oldtbname]'");
		//Ĭ�ϱ�
		if($tbr['isdefault'])
		{
			$empire->query("update {$dbtbpre}enewspublic set tbname='$add[tbname]',tid='$tid'");
		}
		//�ı���
		TogSaveTxtF(1);
	}
	$sql=$empire->query("update {$dbtbpre}enewstable set tbname='$add[tbname]',tname='$add[tname]',tsay='$add[tsay]',yhid='$add[yhid]',intb='$add[intb]' where tid='$tid'");
	GetConfig(1);//���»���
	if($sql)
	{
		//������־
		insert_dolog("tid=".$tid."<br>tbname=".$add[tbname]);
		printerror("EditTbSuccess","db/ListTable.php");
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//ɾ�����ݱ�
function DelTable($tid,$userid,$username){
	global $empire,$dbtbpre;
	$tid=(int)$tid;
	if(!$tid)
	{
		printerror("NotChangeTb","");
    }
	//����Ȩ��
	CheckLevel($userid,$username,$classid,"table");
	$r=$empire->fetch1("select tid,tbname,isdefault,datatbs,deftb from {$dbtbpre}enewstable where tid='$tid'");
	if(empty($r[tid]))
	{
		printerror("NotChangeTb","");
	}
	//Ĭ�ϱ�
	if($r['isdefault'])
	{
		printerror("NotDelDefaultTb","");
	}
	$sql=$empire->query("delete from {$dbtbpre}enewstable where tid='$tid'");
	//ɾ�����ݱ�
	$empire->query("DROP TABLE IF EXISTS {$dbtbpre}ecms_".$r[tbname].";");
	$empire->query("DROP TABLE IF EXISTS {$dbtbpre}ecms_".$r[tbname]."_index;");
	if($r['datatbs'])
	{
		$dtbr=explode(',',$r['datatbs']);
		$count=count($dtbr);
		for($i=1;$i<$count-1;$i++)
		{
			$empire->query("DROP TABLE IF EXISTS {$dbtbpre}ecms_".$r[tbname]."_data_".$dtbr[$i].";");
		}
	}
	//ɾ���ɼ���
	$empire->query("DROP TABLE IF EXISTS {$dbtbpre}ecms_infoclass_".$r[tbname].";");
	$empire->query("DROP TABLE IF EXISTS {$dbtbpre}ecms_infotmp_".$r[tbname].";");
	//ɾ���鵵��
	$empire->query("DROP TABLE IF EXISTS {$dbtbpre}ecms_".$r[tbname]."_doc;");
	$empire->query("DROP TABLE IF EXISTS {$dbtbpre}ecms_".$r[tbname]."_doc_data;");
	$empire->query("DROP TABLE IF EXISTS {$dbtbpre}ecms_".$r[tbname]."_doc_index;");
	//ɾ����˱�
	$empire->query("DROP TABLE IF EXISTS {$dbtbpre}ecms_".$r[tbname]."_check;");
	$empire->query("DROP TABLE IF EXISTS {$dbtbpre}ecms_".$r[tbname]."_check_data;");
	//ɾ������
	$empire->query("delete from {$dbtbpre}enewsf where tid='$tid'");
	$empire->query("delete from {$dbtbpre}enewsmod where tid='$tid'");
	$empire->query("delete from {$dbtbpre}enewsinfoclass where tid='$tid'");
	//�ı���
	TogSaveTxtF(1);
	GetConfig(1);//���»���
	if($sql)
	{
		//������־
		insert_dolog("tid=".$tid."<br>tbname=".$r[tbname]);
		printerror("DelTbSuccess","db/ListTable.php");
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//Ĭ�����ݱ�
function DefaultTable($tid,$userid,$username){
	global $empire,$dbtbpre;
	$tid=(int)$tid;
	if(!$tid)
	{
		printerror("NotChangeDefaultTb","history.go(-1)");
    }
	//����Ȩ��
	CheckLevel($userid,$username,$classid,"table");
	$r=$empire->fetch1("select tid,tbname from {$dbtbpre}enewstable where tid='$tid'");
	if(empty($r[tid]))
	{
		printerror("NotChangeDefaultTb","history.go(-1)");
	}
	$usql=$empire->query("update {$dbtbpre}enewstable set isdefault=0");
	$sql=$empire->query("update {$dbtbpre}enewstable set isdefault=1 where tid='$tid'");
	$upsql=$empire->query("update {$dbtbpre}enewspublic set tbname='$r[tbname]',tid='$tid'");
	GetConfig(1);//���»���
	if($sql&&$usql&&$upsql)
	{
		//������־
		insert_dolog("tid=".$tid."<br>tbname=".$r[tbname]);
		printerror("DefaultTableSuccess","db/ListTable.php");
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//���Ӹ����ֱ�
function AddDataTable($add,$userid,$username){
	global $empire,$dbtbpre;
	//����Ȩ��
	CheckLevel($userid,$username,$classid,"table");
	$tid=(int)$add['tid'];
	$tbname=RepPostVar($add['tbname']);
	$datatb=(int)$add['datatb'];
	if(!$tid||!$tbname||!$datatb)
	{
		printerror("EmptyDataTable","history.go(-1)");
	}
	$tr=$empire->fetch1("select tid,datatbs from {$dbtbpre}enewstable where tid='$tid'");
	if(!$tr['tid'])
	{
		printerror("EmptyDataTable","history.go(-1)");
	}
	if(strstr($tr['datatbs'],','.$datatb.','))
	{
		printerror("ReDataTable","history.go(-1)");
	}
	if(empty($tr['datatbs']))
	{
		$tr['datatbs']=',';
	}
	$newdatatbs=$tr['datatbs'].$datatb.',';
	//����
	$odtb=$dbtbpre."ecms_".$tbname."_data_1";
	$dtb=$dbtbpre."ecms_".$tbname."_data_".$datatb;
	CopyEcmsTb($odtb,$dtb);
	$sql=$empire->query("update {$dbtbpre}enewstable set datatbs='$newdatatbs' where tid='$tid'");
	GetConfig(1);//���»���
	if($sql)
	{
		//������־
		insert_dolog("tid=".$tid."<br>tbname=".$tbname."&datatb=$datatb");
		printerror("AddDataTableSuccess","db/ListDataTable.php?tid=$tid&tbname=$tbname");
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//Ĭ�ϸ�����ű�
function DefDataTable($add,$userid,$username){
	global $empire,$dbtbpre;
	//����Ȩ��
	CheckLevel($userid,$username,$classid,"table");
	$tid=(int)$add['tid'];
	$tbname=RepPostVar($add['tbname']);
	$datatb=(int)$add['datatb'];
	if(!$tid||!$tbname||!$datatb)
	{
		printerror("NotChangeDataTable","history.go(-1)");
	}
	$tr=$empire->fetch1("select tid,datatbs from {$dbtbpre}enewstable where tid='$tid'");
	if(!$tr['tid'])
	{
		printerror("NotChangeDataTable","history.go(-1)");
	}
	if(!strstr($tr['datatbs'],','.$datatb.','))
	{
		printerror("NotChangeDataTable","history.go(-1)");
	}
	$sql=$empire->query("update {$dbtbpre}enewstable set deftb='$datatb' where tid='$tid'");
	GetConfig(1);//���»���
	if($sql)
	{
		//������־
		insert_dolog("tid=".$tid."<br>tbname=".$tbname."&datatb=$datatb");
		printerror("DefDataTableSuccess","db/ListDataTable.php?tid=$tid&tbname=$tbname");
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//ɾ�������ֱ�
function DelDataTable($add,$userid,$username){
	global $empire,$dbtbpre,$emod_r,$class_r;
	//����Ȩ��
	CheckLevel($userid,$username,$classid,"table");
	$tid=(int)$add['tid'];
	$tbname=RepPostVar($add['tbname']);
	$datatb=(int)$add['datatb'];
	if(!$tid||!$tbname||!$datatb)
	{
		printerror("NotChangeDataTable","history.go(-1)");
	}
	$tr=$empire->fetch1("select tid,tbname,datatbs,deftb from {$dbtbpre}enewstable where tid='$tid'");
	if(!$tr['tid'])
	{
		printerror("NotChangeDataTable","history.go(-1)");
	}
	if(!strstr($tr['datatbs'],','.$datatb.','))
	{
		printerror("NotChangeDataTable","history.go(-1)");
	}
	if($tr['deftb']==$datatb||$datatb==1)
	{
		printerror("NotDelDefDataTable","history.go(-1)");
	}
	$newdatatbs=str_replace(','.$datatb.',',',',$tr['datatbs']);
	$sql=$empire->query("update {$dbtbpre}enewstable set datatbs='$newdatatbs' where tid='$tid'");
	//ɾ����Ϣ
	$infosql=$empire->query("select * from {$dbtbpre}ecms_".$tr[tbname]." where stb='$datatb'");
	while($infor=$empire->fetch($infosql))
	{
		$mid=$class_r[$infor[classid]]['modid'];
		$pf=$emod_r[$mid]['pagef'];
		$stf=$emod_r[$mid]['savetxtf'];
		//��ҳ�ֶ�
		if($pf)
		{
			if(strstr($emod_r[$mid]['tbdataf'],','.$pf.','))
			{
				$finfor=$empire->fetch1("select ".$pf." from {$dbtbpre}ecms_".$tr[tbname]."_data_".$datatb." where id='$infor[id]'");
				$infor[$pf]=$finfor[$pf];
			}
		}
		//���ı�
		if($stf)
		{
			$newstextfile=$infor[$stf];
			$infor[$stf]=GetTxtFieldText($infor[$stf]);
			DelTxtFieldText($newstextfile);//ɾ���ļ�
		}
		//ɾ����Ϣ�ļ�
		DelNewsFile($infor[filename],$infor[newspath],$infor[classid],$infor[$pf],$infor[groupid]);
		//ɾ��������Ϣ
		$empire->query("delete from {$dbtbpre}ecms_".$tr[tbname]."_index where id='$infor[id]'");
		//ɾ����������¼�͸���
		DelSingleInfoOtherData($infor[classid],$infor[id],$infor,0,0);
	}
	$deltb=$empire->query("delete from {$dbtbpre}ecms_".$tr[tbname]." where stb='$datatb'");
	//ɾ���鵵��Ϣ
	$docinfosql=$empire->query("select * from {$dbtbpre}ecms_".$tr[tbname]."_doc where stb='$datatb'");
	while($infor=$empire->fetch($docinfosql))
	{
		$mid=$class_r[$infor[classid]]['modid'];
		$pf=$emod_r[$mid]['pagef'];
		$stf=$emod_r[$mid]['savetxtf'];
		//��ҳ�ֶ�
		if($pf)
		{
			if(strstr($emod_r[$mid]['tbdataf'],','.$pf.','))
			{
				$finfor=$empire->fetch1("select ".$pf." from {$dbtbpre}ecms_".$tr[tbname]."_doc_data where id='$infor[id]'");
				$infor[$pf]=$finfor[$pf];
			}
		}
		//���ı�
		if($stf)
		{
			$newstextfile=$infor[$stf];
			$infor[$stf]=GetTxtFieldText($infor[$stf]);
			DelTxtFieldText($newstextfile);//ɾ���ļ�
		}
		//ɾ����Ϣ�ļ�
		DelNewsFile($infor[filename],$infor[newspath],$infor[classid],$infor[$pf],$infor[groupid]);
		//ɾ��������Ϣ
		$empire->query("delete from {$dbtbpre}ecms_".$tr[tbname]."_doc_index where id='$infor[id]'");
		//ɾ��������Ϣ
		$empire->query("delete from {$dbtbpre}ecms_".$tr[tbname]."_doc_data where id='$infor[id]'");
		//ɾ����������¼�븽��
		DelSingleInfoOtherData($infor['classid'],$infor['id'],$infor,0,0);
	}
	$deltb=$empire->query("delete from {$dbtbpre}ecms_".$tr[tbname]."_doc where stb='$datatb'");
	//ɾ�������Ϣ
	$bakinfosql=$empire->query("select * from {$dbtbpre}ecms_".$tr[tbname]."_check where stb='$datatb'");
	while($infor=$empire->fetch($bakinfosql))
	{
		$mid=$class_r[$infor[classid]]['modid'];
		$pf=$emod_r[$mid]['pagef'];
		$stf=$emod_r[$mid]['savetxtf'];
		//��ҳ�ֶ�
		if($pf)
		{
			if(strstr($emod_r[$mid]['tbdataf'],','.$pf.','))
			{
				$finfor=$empire->fetch1("select ".$pf." from {$dbtbpre}ecms_".$tr[tbname]."_check_data where id='$infor[id]'");
				$infor[$pf]=$finfor[$pf];
			}
		}
		//���ı�
		if($stf)
		{
			$newstextfile=$infor[$stf];
			$infor[$stf]=GetTxtFieldText($infor[$stf]);
			DelTxtFieldText($newstextfile);//ɾ���ļ�
		}
		//ɾ����Ϣ�ļ�
		DelNewsFile($infor[filename],$infor[newspath],$infor[classid],$infor[$pf],$infor[groupid]);
		//ɾ��������Ϣ
		$empire->query("delete from {$dbtbpre}ecms_".$tr[tbname]."_index where id='$infor[id]'");
		//ɾ��������Ϣ
		$empire->query("delete from {$dbtbpre}ecms_".$tr[tbname]."_check_data where id='$infor[id]'");
		//ɾ����������¼�͸���
		DelSingleInfoOtherData($infor['classid'],$infor['id'],$infor,0,0);
	}
	$deltb=$empire->query("delete from {$dbtbpre}ecms_".$tr[tbname]."_check where stb='$datatb'");
	//ɾ����
	$deltb=$empire->query("DROP TABLE IF EXISTS {$dbtbpre}ecms_".$tr[tbname]."_data_".$datatb.";");
	GetConfig(1);//���»���
	if($sql)
	{
		//������־
		insert_dolog("tid=".$tid."<br>tbname=".$tr[tbname]."&datatb=$datatb");
		printerror("DelDataTableSuccess","db/ListDataTable.php?tid=$tid&tbname=$tr[tbname]");
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}


//************************************ �ֶ� ************************************

//�����ֶ�ֵ
function ReturnFvalue($value){
	$value=str_replace("\r\n","|",$value);
	return $value;
}

//ȡ�ñ���Ԫ��html����
function GetFform($type,$f,$fvalue,$linkfieldval,$fformsize='',$add){
	if($type=="select"||$type=="radio"||$type=="checkbox")
	{
		return GetFformSelect($type,$f,$fvalue,$fformsize);
	}
	$file="../data/html/fhtml.txt";
	$data=ReadFiletext($file);
	//�����ֶ�
	if($f=="newstext"||$f=="writer"||$f=="befrom"||$f=="downpath"||$f=="onlinepath"||$f=="morepic"||$f=="playerid")
	{
		$type=$f;
	}
	$exp="[!--".$type."--]";
	$r=explode($exp,$data);
	$string=str_replace("[!--enews.var--]",$f,$r[1]);
	$string=str_replace("[!--enews.def.val--]",$fvalue,$string);
	if($type=='linkfield')//ѡ����������ֶ�
	{
		$string=str_replace("[!--enews.cfield.var--]",$add[linkfieldval],$string);
		$string=str_replace("[!--enews.vfield.var--]",$add[linkfieldshow],$string);
		$string=str_replace("[!--enews.ctbname--]",$add[linkfieldtb],$string);
	}
	elseif($type=='linkfieldselect')//������������ֶ�
	{
		$selectf=$add[linkfieldval]==$add[linkfieldshow]?$add[linkfieldval]:$add[linkfieldval].','.$add[linkfieldshow];
		$string=str_replace("[!--enews.cfield.var--]",$add[linkfieldval],$string);
		$string=str_replace("[!--enews.vfield.var--]",$add[linkfieldshow],$string);
		$string=str_replace("[!--enews.ctbname--]",$add[linkfieldtb],$string);
		$string=str_replace("[!--enews.selectf--]",$selectf,$string);
	}
	elseif($type=='editor'||$type=='newstext')//�༭��
	{
		$editortype=$add[editorys]==0?'Default':'Basic';
		$string=str_replace("[!--editor.type--]",$editortype,$string);
		$string=str_replace("[!--editor.basepath--]",'',$string);
	}
	elseif($type=='morevaluefield')//��ֵ�ֶ�
	{
		$mvr=explode(',',$add['fmvnum']);
		$mv_var=ReturnMoreValueFieldHtmlVar($f,$mvr[0],$mvr[1],$mvr[2]);
		$string=str_replace("[!--enews.jstr--]",$mv_var['jstr'],$string);
		$string=str_replace("[!--enews.saytr--]",$mv_var['saytr'],$string);
		$string=str_replace("[!--enews.deftr--]",$mv_var['deftr'],$string);
		$string=str_replace("[!--enews.edittr--]",$mv_var['edittr'],$string);
		$string=str_replace("[!--enews.mvline--]",$mvr[1],$string);
		$string=str_replace("[!--enews.mvnum--]",$mvr[0],$string);
		$string=str_replace("[!--enews.mvmust--]",$mvr[2],$string);
	}
	$string=RepFformSize($f,$string,$type,$fformsize);
	return fAddAddsData($string);
}

//ȡ�òɼ�����Ԫ��html����
function GetCjform($type,$f){
	$file="../data/html/cjhtml.txt";
	$data=ReadFiletext($file);
	//�����ֶ�
	if($f=="downpath"||$f=="onlinepath"||$f=="morepic"||$f=="playerid")
	{
		$type=$f;
	}
	if($type=="password"||$type=="select"||$type=="radio"||$type=="checkbox"||$type=="date"||$type=="color"||$type=="linkfield"||$type=="editor"||$type=="ubbeditor"||$type=="linkfieldselect"||$type=="morevaluefield")
	{
		$type="text";
	}
	$exp="[!--".$type."--]";
	$r=explode($exp,$data);
	$string=str_replace("[!--enews.var--]",$f,$r[1]);
	return fAddAddsData($string);
}

//ȡ��Ͷ�����Ԫ��html����
function GetQFform($type,$f,$fvalue,$fformsize='',$add){
	if($type=="select"||$type=="radio"||$type=="checkbox")
	{
		return GetFformSelect($type,$f,$fvalue,$fformsize);
	}
	$file="../data/html/qfhtml.txt";
	$data=ReadFiletext($file);
	//�����ֶ�
	if($f=="newstext"||$f=="downpath"||$f=="onlinepath"||$f=="morepic"||$f=="playerid")
	{
		$type=$f;
	}
	$exp="[!--".$type."--]";
	$r=explode($exp,$data);
	$string=str_replace("[!--enews.var--]",$f,$r[1]);
	$string=str_replace("[!--enews.def.val--]",$fvalue,$string);
	if($type=='linkfield')//ѡ����������ֶ�
	{
		$string=str_replace("[!--enews.cfield.var--]",$add[linkfieldval],$string);
		$string=str_replace("[!--enews.vfield.var--]",$add[linkfieldshow],$string);
		$string=str_replace("[!--enews.ctbname--]",$add[linkfieldtb],$string);
	}
	elseif($type=='linkfieldselect')//������������ֶ�
	{
		$selectf=$add[linkfieldval]==$add[linkfieldshow]?$add[linkfieldval]:$add[linkfieldval].','.$add[linkfieldshow];
		$string=str_replace("[!--enews.cfield.var--]",$add[linkfieldval],$string);
		$string=str_replace("[!--enews.vfield.var--]",$add[linkfieldshow],$string);
		$string=str_replace("[!--enews.ctbname--]",$add[linkfieldtb],$string);
		$string=str_replace("[!--enews.selectf--]",$selectf,$string);
	}
	elseif($type=='editor'||$type=='newstext')//�༭��
	{
		$editortype=$add[editorys]==0?'Default':'Basic';
		$string=str_replace("[!--editor.type--]",$editortype,$string);
		$string=str_replace("[!--editor.basepath--]",'',$string);
	}
	elseif($type=='morevaluefield')//��ֵ�ֶ�
	{
		$mvr=explode(',',$add['fmvnum']);
		$mv_var=ReturnMoreValueFieldHtmlVar($f,$mvr[0],$mvr[1],$mvr[2]);
		$string=str_replace("[!--enews.jstr--]",$mv_var['jstr'],$string);
		$string=str_replace("[!--enews.saytr--]",$mv_var['saytr'],$string);
		$string=str_replace("[!--enews.deftr--]",$mv_var['deftr'],$string);
		$string=str_replace("[!--enews.edittr--]",$mv_var['edittr'],$string);
		$string=str_replace("[!--enews.mvline--]",$mvr[1],$string);
		$string=str_replace("[!--enews.mvnum--]",$mvr[0],$string);
		$string=str_replace("[!--enews.mvmust--]",$mvr[2],$string);
	}
	$string=RepFformSize($f,$string,$type,$fformsize);
	return fAddAddsData($string);
}

//ȡ��select/radioԪ�ش���
function GetFformSelect($type,$f,$fvalue,$fformsize=''){
	$vr=explode('|',$fvalue);
	$count=count($vr);
	$change='';
	$def=':default';
	for($i=0;$i<$count;$i++)
	{
		$isdef='';
		if(strstr($vr[$i],$def))
		{
			$dr=explode($def,$vr[$i]);
			$vr[$i]=$dr[0];
			$isdef="||\$ecmsfirstpost==1";
		}
		$selectvalr=explode('==',$vr[$i]);
		$val=$selectvalr[0];
		$valname=$selectvalr[1]?$selectvalr[1]:$selectvalr[0];
		if($type=='select')
		{
			$change.="<option value=\"".$val."\"<?=\$r[".$f."]==\"".$val."\"".$isdef."?' selected':''?>>".$valname."</option>";
		}
		elseif($type=='checkbox')
		{
			$change.="<input name=\"".$f."[]\" type=\"checkbox\" value=\"".$val."\"<?=strstr(\$r[".$f."],\"|".$val."|\")".$isdef."?' checked':''?>>".$valname;
		}
		else
		{
			$change.="<input name=\"".$f."\" type=\"radio\" value=\"".$val."\"<?=\$r[".$f."]==\"".$val."\"".$isdef."?' checked':''?>>".$valname;
		}
	}
	if($type=="select")
	{
		if($fformsize)
		{
			$addsize=' style="width:'.$fformsize.'"';
		}
		$change="<select name=\"".$f."\" id=\"".$f."\"".$addsize.">".$change."</select>";
	}
	return $change;
}

//�滻����Ԫ�س���
function RepFformSize($f,$string,$type,$fformsize=''){
	$fformsize=ReturnDefFformSize($f,$type,$fformsize);
	if($type=='textarea'||$type=='editor'||$type=='ubbeditor'||$type=='newstext')
	{
		$r=explode(',',$fformsize);
		$string=str_replace('[!--fsize.w--]',$r[0],$string);
		$string=str_replace('[!--fsize.h--]',$r[1],$string);
	}
	else
	{
		$string=str_replace('[!--fsize.w--]',$fformsize,$string);
	}
	return $string;
}

//����Ĭ�ϳ���
function ReturnDefFformSize($f,$type,$fformsize){
	if(empty($fformsize))
	{
		if($type=='textarea')
		{
			$fformsize='60,10';
		}
		elseif($type=='img')
		{
			$fformsize='45';
		}
		elseif($type=='file')
		{
			$fformsize='45';
		}
		elseif($type=='flash')
		{
			$fformsize='45';
		}
		elseif($type=='date')
		{
			$fformsize='12';
		}
		elseif($type=='color')
		{
			$fformsize='10';
		}
		elseif($type=='linkfield')
		{
			$fformsize='45';
		}
		elseif($type=='downpath')
		{
			$fformsize='45';
		}
		elseif($type=='onlinepath')
		{
			$fformsize='45';
		}
		elseif($type=='editor'||$type=='newstext')
		{
			$fformsize='100%,300';
		}
		elseif($type=='ubbeditor')
		{
			$fformsize='60,10';
		}
	}
	return $fformsize;
}

//���ض�ֵ�ֶ�¼����html�������
function ReturnMoreValueFieldHtmlVar($f,$mvnum,$mvline,$mvmust){
	global $fun_r;
	$del=' <input type="hidden" name="'.$f.'_mvid[]" id="'.$f.'_mvid_<?=$j?>" value="<?=$j?>"><input type="checkbox" name="'.$f.'_mvdelid[]" id="'.$f.'_mvdelid_<?=$j?>" value="<?=$j?>">'.$fun_r['FSingleDel'];
	$saytr='<tr>';
	$jstr='<tr>';
	$deftr='<tr>';
	$edittr='<tr>';
	for($i=0;$i<$mvnum;$i++)
	{
		$j=$i+1;
		//����
		$saytr.='<td align="center">'.$fun_r['FSetting'].$j.'</td>';
		//JS
		$jstr.='<td align="center"><input type="text" name="'.$f.'_'.$j.'[]" id="'.$f.'_'.$j.'_\'+j+\'" value=""></td>';
		//Ĭ��
		$deftr.='<td align="center"><input type="text" name="'.$f.'_'.$j.'[]" id="'.$f.'_'.$j.'_<?=$i?>" value=""></td>';
		//�޸�
		$edittr.='<td align="center"><input type="text" name="'.$f.'_'.$j.'[]" id="'.$f.'_'.$j.'_<?=$j?>" value="<?=$mvf_field['.$i.']?>">'.($i==0?$del:'').'</td>';
	}
	$saytr.='</tr>';
	$jstr.='</tr>';
	$deftr.='</tr>';
	$edittr.='</tr>';
	$r['saytr']=$saytr;
	$r['jstr']=$jstr;
	$r['deftr']=$deftr;
	$r['edittr']=$edittr;
	return $r;
}

//�����ֶα���
function DoPostFVar($add){
	$add['tid']=(int)$add['tid'];
	$add['tbname']=RepPostVar($add['tbname']);
	$add['f']=RepPostVar($add['f']);
	//��������
	$add[iscj]=(int)$add[iscj];
	$add[myorder]=(int)$add[myorder];
	$add[savetxt]=(int)$add[savetxt];
	$add[iskey]=(int)$add[iskey];
	$add[tobr]=(int)$add[tobr];
	$add[dohtml]=(int)$add[dohtml];
	$add[isonly]=(int)$add[isonly];
	$add[samedata]=(int)$add[samedata];
	$add[tbdataf]=(int)$add[tbdataf];
	$add[ispage]=(int)$add[ispage];
	$add[editorys]=(int)$add[editorys];
	$add[issmalltext]=(int)$add[issmalltext];
	if($add[fform]=='textarea'||$add[fform]=='editor')
	{
		if($add[fformwidth]||$add[fformheight])
		{
			$add['fformsize']=$add[fformwidth].','.$add[fformheight];
		}
	}
	if($add[fform]=='morevaluefield')
	{
		$add['fmvnum']=intval($add['fmvnum']).','.intval($add['fmvline']).','.intval($add['fmvmust']);
	}
	else
	{
		$add['fmvnum']='';
	}
	return $add;
}

//��֤�ֶ��Ƿ��ظ�
function CheckReTbF($add,$ecms=0){
	global $empire,$dbtbpre;
	$specialf=',oldurl,tmptime,smallurl,newsurl,titlepicl,';
	if(stristr($specialf,','.$add[f].','))
	{
		printerror("ReF","history.go(-1)");
	}
	//�޸�
	if($ecms==1&&$add[f]==$add[oldf])
	{
		return '';
	}
	//����
	$s=$empire->query("SHOW FIELDS FROM {$dbtbpre}ecms_".$add[tbname]);
	$b=0;
	while($r=$empire->fetch($s))
	{
		if($r[Field]==$add[f])
		{
			$b=1;
			break;
		}
    }
	if($b)
	{
		printerror("ReF","history.go(-1)");
	}
	//����
	$s=$empire->query("SHOW FIELDS FROM {$dbtbpre}ecms_".$add[tbname]."_data_1");
	$b=0;
	while($r=$empire->fetch($s))
	{
		if($r[Field]==$add[f])
		{
			$b=1;
			break;
		}
    }
	if($b)
	{
		printerror("ReF","history.go(-1)");
	}
	//������
	$s=$empire->query("SHOW FIELDS FROM {$dbtbpre}ecms_".$add[tbname]."_index");
	$b=0;
	while($r=$empire->fetch($s))
	{
		if($r[Field]==$add[f])
		{
			$b=1;
			break;
		}
    }
	if($b)
	{
		printerror("ReF","history.go(-1)");
	}
}

//�����ֶ�����
function ReturnTbFtype($add){
	if($add[ftype]=="TINYINT"||$add[ftype]=="SMALLINT"||$add[ftype]=="INT"||$add[ftype]=="BIGINT"||$add[ftype]=="FLOAT"||$add[ftype]=="DOUBLE")
	{
		$def=" default '0'";
	}
	elseif($add[ftype]=="VARCHAR"||$add[ftype]=="CHAR")
	{
		$def=" default ''";
	}
	elseif($add[ftype]=="DATE")
	{
		$def=" default '0000-00-00'";
	}
	elseif($add[ftype]=="DATETIME")
	{
		$def=" default '0000-00-00 00:00:00'";
	}
	else
	{
		$def='';
	}
	$type=$add[ftype];
	//VARCHAR
	if(($add[ftype]=='VARCHAR'||$add[ftype]=='CHAR')&&empty($add[flen]))
	{
		$add[flen]='255';
	}
	//�ֶγ���
	if($add[flen])
	{
		if($add[ftype]!="TEXT"&&$add[ftype]!="MEDIUMTEXT"&&$add[ftype]!="LONGTEXT"&&$add[ftype]!="DATE"&&$add[ftype]!="DATETIME")
		{
			$type.="(".$add[flen].")";
		}
	}
	$field=$add[f]." ".$type." NOT NULL".$def;
	return $field;
}

//�����ֶ�
function AddF($add,$userid,$username){
	global $empire,$dbtbpre;
	$add=DoPostFVar($add);
	$tid=$add[tid];
	$tbname=$add[tbname];
	if(empty($add[f])||empty($add[fname])||!$add[tid]||!$add[tbname])
	{
		printerror("EmptyF","history.go(-1)");
	}
	CheckLevel($userid,$username,$classid,"f");//��֤Ȩ��
	CheckReTbF($add,0);//�ֶ��Ƿ��ظ�
	//���ı�
	if($add[savetxt]==1)
	{
		$txtnum=$empire->gettotal("select count(*) as total from {$dbtbpre}enewsf where savetxt=1 and tid='$tid'");
		if($txtnum)
		{
			printerror('ReTxtF','');
		}
	}
	//��ҳ
	if($add['ispage']==1)
	{
		$pagenum=$empire->gettotal("select count(*) as total from {$dbtbpre}enewsf where ispage=1 and tid='$tid'");
		if($pagenum)
		{
			printerror('RePageF','');
		}
	}
	$add[fvalue]=ReturnFvalue($add[fvalue]);//��ʼ��ֵ
	$field=ReturnTbFtype($add);//�����ֶ�
	//��Ϣ�������ֶ�
	if($add[tbdataf]==1)//���ӱ�
	{
		$tbr=$empire->fetch1("select datatbs from {$dbtbpre}enewstable where tid='$tid'");
		if($tbr['datatbs'])
		{
			$dtbr=explode(',',$tbr['datatbs']);
			$count=count($dtbr);
			for($i=1;$i<$count-1;$i++)
			{
				$empire->query("alter table {$dbtbpre}ecms_".$tbname."_data_".$dtbr[$i]." add ".$field);
				if($add[iskey]==1)//����
				{
					$empire->query("ALTER TABLE {$dbtbpre}ecms_".$tbname."_data_".$dtbr[$i]." ADD INDEX(".$add[f].")");
				}
			}
		}
		//�鵵����
		$asql=$empire->query("alter table {$dbtbpre}ecms_".$tbname."_doc_data add ".$field);
		if($add[iskey]==1)//����
		{
			$keysql=$empire->query("ALTER TABLE {$dbtbpre}ecms_".$tbname."_doc_data ADD INDEX(".$add[f].")");
		}
		//��˸���
		$asql=$empire->query("alter table {$dbtbpre}ecms_".$tbname."_check_data add ".$field);
		if($add[iskey]==1)//����
		{
			$keysql=$empire->query("ALTER TABLE {$dbtbpre}ecms_".$tbname."_check_data ADD INDEX(".$add[f].")");
		}
	}
	else//����
	{
		$asql=$empire->query("alter table {$dbtbpre}ecms_".$tbname." add ".$field);
		if($add[iskey]==1)//����
		{
			$keysql=$empire->query("ALTER TABLE {$dbtbpre}ecms_".$tbname." ADD INDEX(".$add[f].")");
		}
		//�鵵����
		$asql=$empire->query("alter table {$dbtbpre}ecms_".$tbname."_doc add ".$field);
		if($add[iskey]==1)//����
		{
			$keysql=$empire->query("ALTER TABLE {$dbtbpre}ecms_".$tbname."_doc ADD INDEX(".$add[f].")");
		}
		//�������
		$asql=$empire->query("alter table {$dbtbpre}ecms_".$tbname."_check add ".$field);
		if($add[iskey]==1)//����
		{
			$keysql=$empire->query("ALTER TABLE {$dbtbpre}ecms_".$tbname."_check ADD INDEX(".$add[f].")");
		}
	}
	//�ɼ��������ֶ�
	if($add[iscj]==1)
	{
		$asql=$empire->query("alter table {$dbtbpre}ecms_infoclass_".$tbname." add zz_".$add[f]." text not null,add z_".$add[f]." varchar(255) not null,add qz_".$add[f]." varchar(255) not null,add save_".$add[f]." varchar(10) not null;");
		$asql=$empire->query("alter table {$dbtbpre}ecms_infotmp_".$tbname." add ".$field);
	}
	//�滻����
	$fhtml=GetFform($add[fform],$add[f],$add[fvalue],$add[linkfieldval],$add[fformsize],$add);
	$cjhtml=GetCjform($add[fform],$add[f]);
	$qfhtml=GetQFform($add[fform],$add[f],$add[fvalue],$add[fformsize],$add);
	$sql=$empire->query("insert into {$dbtbpre}enewsf(f,fname,fform,fhtml,fzs,isadd,isshow,iscj,cjhtml,myorder,ftype,flen,dotemp,tid,tbname,savetxt,fvalue,iskey,tobr,dohtml,qfhtml,isonly,linkfieldval,samedata,fformsize,tbdataf,ispage,adddofun,editdofun,qadddofun,qeditdofun,linkfieldtb,linkfieldshow,editorys,issmalltext,fmvnum) values('$add[f]','$add[fname]','$add[fform]','".eaddslashes2($fhtml)."','".eaddslashes($add[fzs])."',1,1,$add[iscj],'".eaddslashes2($cjhtml)."',$add[myorder],'$add[ftype]','$add[flen]',1,$tid,'$tbname',$add[savetxt],'".eaddslashes2($add[fvalue])."',$add[iskey],$add[tobr],$add[dohtml],'".eaddslashes2($qfhtml)."','$add[isonly]','".eaddslashes($add[linkfieldval])."','$add[samedata]','$add[fformsize]','$add[tbdataf]','$add[ispage]','$add[adddofun]','$add[editdofun]','$add[qadddofun]','$add[qeditdofun]','$add[linkfieldtb]','$add[linkfieldshow]','$add[editorys]','$add[issmalltext]','$add[fmvnum]');");
	$lastid=$empire->lastid();
	TogSaveTxtF(1);//��������
	if($add[savetxt]==1&&$add[iscj]==1)//����ı�
	{
		$tmpsql=$empire->query("alter table {$dbtbpre}ecms_infotmp_".$tbname." change ".$add[f]." ".$add[f]." mediumtext not null;");
	}
	GetConfig(1);//���»���
	if($sql)
	{
		insert_dolog("fid=".$lastid."<br>f=".$add[f]);//������־
		printerror("AddFSuccess","db/AddF.php?enews=AddF&tid=$tid&tbname=$tbname");
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//�޸����ݿ��ֶ�
function EditF($add,$userid,$username){
	global $empire,$dbtbpre;
	$add=DoPostFVar($add);
	$tid=$add[tid];
	$tbname=$add[tbname];
	$add[fid]=(int)$add['fid'];
	if(empty($add[f])||empty($add[fname])||empty($add[fid])||!$tid||!$tbname)
	{
		printerror("EmptyF","history.go(-1)");
	}
	CheckLevel($userid,$username,$classid,"f");//��֤Ȩ��
	//�Ƿ�ϵͳ�ڲ��ֶ�
	$cr=$empire->fetch1("select * from {$dbtbpre}enewsf where fid='$add[fid]'");
	if(empty($cr[isadd]))
	{
		printerror("NotIsAdd","history.go(-1)");
	}
	CheckReTbF($add,1);//�ֶ��Ƿ��ظ�
	//���ı�
	if($add[savetxt]==1&&!$cr[savetxt])
	{
		$txtnum=$empire->gettotal("select count(*) as total from {$dbtbpre}enewsf where savetxt=1 and fid<>".$add[fid]." and tid='$tid'");
		if($txtnum)
		{
			printerror('ReTxtF','');
		}
	}
	//��ҳ
	if($add['ispage']==1&&!$cr[ispage])
	{
		$pagenum=$empire->gettotal("select count(*) as total from {$dbtbpre}enewsf where ispage=1 and fid<>".$add[fid]." and tid='$tid'");
		if($pagenum)
		{
			printerror('RePageF','');
		}
	}
	$add[fvalue]=ReturnFvalue($add[fvalue]);//��ʼ��ֵ
	//�ı��ֶ�
	if($cr[f]<>$add[f]||$add[iskey]<>$cr[iskey]||$cr[iscj]<>$add[iscj]||$cr[ftype]<>$add[ftype]||$cr[flen]<>$add[flen])
	{
		$field=ReturnTbFtype($add);//�����ֶ�
		//��Ϣ��
		if($cr[tbdataf]==1)//���ӱ�
		{
			$tbr=$empire->fetch1("select datatbs from {$dbtbpre}enewstable where tid='$tid'");
			if($tbr['datatbs'])
			{
				$dtbr=explode(',',$tbr['datatbs']);
				$count=count($dtbr);
				for($i=1;$i<$count-1;$i++)
				{
					$empire->query("alter table {$dbtbpre}ecms_".$tbname."_data_".$dtbr[$i]." change ".$add[oldf]." ".$field);
					if($add[iskey]==1)//����
					{
						if($cr[iskey]==0)
						{
							$empire->query("ALTER TABLE {$dbtbpre}ecms_".$tbname."_data_".$dtbr[$i]." ADD INDEX(".$add[f].")");
						}
					}
					elseif($cr[iskey]==1&&$add[iskey]==0)//ɾ������
					{
						$empire->query("ALTER TABLE {$dbtbpre}ecms_".$tbname."_data_".$dtbr[$i]." DROP INDEX ".$add[oldf]);
					}
				}
			}
			//�鵵����
			$usql=$empire->query("alter table {$dbtbpre}ecms_".$tbname."_doc_data change ".$add[oldf]." ".$field);
			if($add[iskey]==1)//����
			{
				if($cr[iskey]==0)
				{
					$keysql=$empire->query("ALTER TABLE {$dbtbpre}ecms_".$tbname."_doc_data ADD INDEX(".$add[f].")");
				}
			}
			elseif($cr[iskey]==1&&$add[iskey]==0)//ɾ������
			{
				$keysql=$empire->query("ALTER TABLE {$dbtbpre}ecms_".$tbname."_doc_data DROP INDEX ".$add[oldf]);
			}
			//��˸���
			$usql=$empire->query("alter table {$dbtbpre}ecms_".$tbname."_check_data change ".$add[oldf]." ".$field);
			if($add[iskey]==1)//����
			{
				if($cr[iskey]==0)
				{
					$keysql=$empire->query("ALTER TABLE {$dbtbpre}ecms_".$tbname."_check_data ADD INDEX(".$add[f].")");
				}
			}
			elseif($cr[iskey]==1&&$add[iskey]==0)//ɾ������
			{
				$keysql=$empire->query("ALTER TABLE {$dbtbpre}ecms_".$tbname."_check_data DROP INDEX ".$add[oldf]);
			}
		}
		else//����
		{
			$usql=$empire->query("alter table {$dbtbpre}ecms_".$tbname." change ".$add[oldf]." ".$field);
			if($add[iskey]==1)//����
			{
				if($cr[iskey]==0)
				{
					$keysql=$empire->query("ALTER TABLE {$dbtbpre}ecms_".$tbname." ADD INDEX(".$add[f].")");
				}
			}
			elseif($cr[iskey]==1&&$add[iskey]==0)//ɾ������
			{
				$keysql=$empire->query("ALTER TABLE {$dbtbpre}ecms_".$tbname." DROP INDEX ".$add[oldf]);
			}
			//�鵵����
			$usql=$empire->query("alter table {$dbtbpre}ecms_".$tbname."_doc change ".$add[oldf]." ".$field);
			if($add[iskey]==1)//����
			{
				if($cr[iskey]==0)
				{
					$keysql=$empire->query("ALTER TABLE {$dbtbpre}ecms_".$tbname."_doc ADD INDEX(".$add[f].")");
				}
			}
			elseif($cr[iskey]==1&&$add[iskey]==0)//ɾ������
			{
				$keysql=$empire->query("ALTER TABLE {$dbtbpre}ecms_".$tbname."_doc DROP INDEX ".$add[oldf]);
			}
			//�������
			$usql=$empire->query("alter table {$dbtbpre}ecms_".$tbname."_check change ".$add[oldf]." ".$field);
			if($add[iskey]==1)//����
			{
				if($cr[iskey]==0)
				{
					$keysql=$empire->query("ALTER TABLE {$dbtbpre}ecms_".$tbname."_check ADD INDEX(".$add[f].")");
				}
			}
			elseif($cr[iskey]==1&&$add[iskey]==0)//ɾ������
			{
				$keysql=$empire->query("ALTER TABLE {$dbtbpre}ecms_".$tbname."_check DROP INDEX ".$add[oldf]);
			}
		}
		//�ɼ���
		if($add[iscj]==1)
		{
			if($cr[iscj]==1)
			{
				$empire->query("alter table {$dbtbpre}ecms_infotmp_".$tbname." change ".$add[oldf]." ".$field);
				$empire->query("alter table {$dbtbpre}ecms_infoclass_".$tbname." change zz_".$add[oldf]." zz_".$add[f]." text not null,change z_".$add[oldf]." z_".$add[f]." varchar(255) not null,change qz_".$add[oldf]." qz_".$add[f]." varchar(255) not null,change save_".$add[oldf]." save_".$add[f]." varchar(10) not null;");
			}
			else
			{
				$empire->query("alter table {$dbtbpre}ecms_infoclass_".$tbname." add zz_".$add[f]." text not null,add z_".$add[f]." varchar(255) not null,add qz_".$add[f]." varchar(255) not null,add save_".$add[f]." varchar(10) not null;");
				$empire->query("alter table {$dbtbpre}ecms_infotmp_".$tbname." add ".$field);
			}
		}
		elseif($add[iscj]==0&&$cr[iscj]==1)
		{
			$empire->query("alter table {$dbtbpre}ecms_infotmp_".$tbname." drop COLUMN ".$cr[f]);
			$empire->query("alter table {$dbtbpre}ecms_infoclass_".$tbname." drop COLUMN zz_".$cr[f].",drop COLUMN z_".$cr[f].",drop COLUMN qz_".$cr[f].",drop COLUMN save_".$cr[f]);
		}
	}
	//�滻����
	if($add[f]<>$cr[f]||$add[fform]<>$cr[fform]||$add[fvalue]<>$add[oldfvalue]||$cr[linkfieldtb]<>$add[linkfieldtb]||$cr[linkfieldshow]<>$add[linkfieldshow]||$cr[editorys]<>$add[editorys]||$add[linkfieldval]<>$cr[linkfieldval]||$add[fformsize]<>$cr[fformsize]||$add[fmvnum]<>$cr[fmvnum])
	{
		$fhtml=GetFform($add[fform],$add[f],$add[fvalue],$add[linkfieldval],$add[fformsize],$add);
	}
	else
	{
		$fhtml=$add[fhtml];
	}
	$cjhtml=GetCjform($add[fform],$add[f]);
	if($add[f]<>$cr[f]||$add[fform]<>$cr[fform]||$add[fvalue]<>$add[oldfvalue]||$cr[linkfieldtb]<>$add[linkfieldtb]||$cr[linkfieldshow]<>$add[linkfieldshow]||$cr[editorys]<>$add[editorys]||$add[linkfieldval]<>$cr[linkfieldval]||$add[fformsize]<>$cr[fformsize]||$add[fmvnum]<>$cr[fmvnum])
	{
		$qfhtml=GetQFform($add[fform],$add[f],$add[fvalue],$add[fformsize],$add);
	}
	else
	{
		$qfhtml=$add[qfhtml];
	}
	$sql=$empire->query("update {$dbtbpre}enewsf set f='$add[f]',fname='$add[fname]',fform='$add[fform]',fhtml='".eaddslashes2($fhtml)."',fzs='".eaddslashes($add[fzs])."',iscj=$add[iscj],cjhtml='".eaddslashes2($cjhtml)."',myorder=$add[myorder],ftype='$add[ftype]',flen='$add[flen]',fvalue='".eaddslashes2($add[fvalue])."',iskey=$add[iskey],tobr=$add[tobr],dohtml=$add[dohtml],qfhtml='".eaddslashes2($qfhtml)."',isonly='$add[isonly]',linkfieldval='$add[linkfieldval]',samedata='$add[samedata]',fformsize='$add[fformsize]',ispage='$add[ispage]',adddofun='$add[adddofun]',editdofun='$add[editdofun]',qadddofun='$add[qadddofun]',qeditdofun='$add[qeditdofun]',linkfieldtb='$add[linkfieldtb]',linkfieldshow='$add[linkfieldshow]',editorys='$add[editorys]',issmalltext='$add[issmalltext]',fmvnum='$add[fmvnum]' where fid='$add[fid]'");
	TogSaveTxtF(1);//��������
	if($add[savetxt]==1&&$add[iscj]==1)
	{
		$tmpsql=$empire->query("alter table {$dbtbpre}ecms_infotmp_".$tbname." change ".$add[f]." ".$add[f]." mediumtext not null;");
	}
	//���±���
	$record="<!--record-->";
    $field="<!--field--->";
	$like=$field.$add[oldf].$record;
	$newlike=$field.$add[f].$record;
	$slike=",".$add[oldf].",";
	$newslike=",".$add[f].",";
	$fsql=$empire->query("select mid,mtemp,cj,enter,tempvar,searchvar,tid,qenter,mustqenterf,qmtemp,listandf,listtempvar,canaddf,caneditf,orderf from {$dbtbpre}enewsmod where tid='$tid'");
	while($fr=$empire->fetch($fsql))
	{
		$and="";
		$enter=$fr['enter'];
		if($add[f]<>$add[oldf])
		{
			//�ɼ���
			if(strstr($fr[cj],$like))
			{
				$cj=str_replace($like,$newlike,$fr[cj]);
				$and=",cj='$cj'";
				ChangeMCj($fr[mid],$fr[tid],$cj);
			}
			//¼����
			if(strstr($fr[enter],$like))
			{
				$enter=str_replace($like,$newlike,$fr[enter]);
				$and.=",enter='$enter'";
			}
			//Ͷ����
			if(strstr($fr[qenter],$like))
			{
				$qenter=str_replace($like,$newlike,$fr[qenter]);
				$and.=",qenter='$qenter'";
			}
			//����ģ����
			if(strstr($fr[tempvar],$like))
			{
				$tempvar=str_replace($like,$newlike,$fr[tempvar]);
				$and.=",tempvar='$tempvar'";
			}
			//�б�ģ����
			if(strstr($fr[listtempvar],$like))
			{
				$listtempvar=str_replace($like,$newlike,$fr[listtempvar]);
				$and.=",listtempvar='$listtempvar'";
			}
			//������
			if(strstr($fr[searchvar],$slike))
			{
				$searchvar=str_replace($slike,$newslike,$fr[searchvar]);
				$and.=",searchvar='$searchvar'";
			}
			//������
			if(strstr($fr[mustqenterf],$slike))
			{
				$mustqenterf=str_replace($slike,$newslike,$fr[mustqenterf]);
				$and.=",mustqenterf='$mustqenterf'";
			}
			//�����
			if(strstr($fr[listandf],$slike))
			{
				$listandf=str_replace($slike,$newslike,$fr[listandf]);
				$and.=",listandf='$listandf'";
			}
			//������
			if(strstr($fr[orderf],$slike))
			{
				$orderf=str_replace($slike,$newslike,$fr[orderf]);
				$and.=",orderf='$orderf'";
			}
			//���޸�
			if(strstr($fr[caneditf],$slike))
			{
				$caneditf=str_replace($slike,$newslike,$fr[caneditf]);
				$and.=",caneditf='$caneditf'";
			}
			//������
			if(strstr($fr[canaddf],$slike))
			{
				$canaddf=str_replace($slike,$newslike,$fr[canaddf]);
				$and.=",canaddf='$canaddf'";
			}
			//����ģ��
			if(strstr($fr[mtemp],'[!--'.$add[oldf].'--]'))
			{
				$fr[mtemp]=str_replace('[!--'.$add[oldf].'--]','[!--'.$add[f].'--]',$fr[mtemp]);
				$and.=",mtemp='".addslashes(stripSlashes($fr[mtemp]))."'";
			}
			//Ͷ�����ģ��
			if(strstr($fr[qmtemp],'[!--'.$add[oldf].'--]'))
			{
				$fr[qmtemp]=str_replace('[!--'.$add[oldf].'--]','[!--'.$add[f].'--]',$fr[qmtemp]);
				$and.=",qmtemp='".addslashes(stripSlashes($fr[qmtemp]))."'";
			}
			if($and)
			{
				$empire->query("update {$dbtbpre}enewsmod set mid='$fr[mid]'".$and." where mid='$fr[mid]'");
			}
		}
		ChangeMForm($fr[mid],$fr[tid],$fr[mtemp]);
		ChangeQmForm($fr[mid],$fr[tid],$fr[qmtemp]);
	}
	GetConfig(1);//���»���
	if($sql)
	{
		insert_dolog("fid=".$add[fid]."<br>f=".$add[f]);//������־
		printerror("EditFSuccess","db/ListF.php?tid=$tid&tbname=$tbname");
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//�޸����ݱ�ϵͳ�ֶ�
function EditSysF($add,$userid,$username){
	global $empire,$dbtbpre;
	$tid=(int)$add['tid'];
	$tbname=RepPostVar($add['tbname']);
	$fid=(int)$add['fid'];
	$f=RepPostVar($add['f']);
	if(!$fid||!$tid||!$tbname||!$f||!$add[fname])
	{
		printerror("EmptyF","history.go(-1)");
	}
	CheckLevel($userid,$username,$classid,"f");//��֤Ȩ��
	//�ֶ�
	$addupdate='';
	if($f=='title'||$f=='titlepic')
	{
		if(!empty($add['flen']))
		{
			$field=$f." ".$add['ftype']."(".$add['flen'].") NOT NULL default ''";
			//��Ϣ��
			$empire->query("alter table {$dbtbpre}ecms_".$tbname." change ".$f." ".$field);
			//�鵵��
			$empire->query("alter table {$dbtbpre}ecms_".$tbname."_doc change ".$f." ".$field);
			//��˱�
			$empire->query("alter table {$dbtbpre}ecms_".$tbname."_check change ".$f." ".$field);
			//�ɼ���ʱ��
			$empire->query("alter table {$dbtbpre}ecms_infotmp_".$tbname." change ".$f." ".$field);
		}
		$addupdate=",ftype='$add[ftype]'";
	}
	//����
	$iskey=(int)$add['iskey'];
	if($f=='title'||$f=='titlepic')
	{
		if($iskey==1)//����
		{
			if($add['oldiskey']==0)
			{
				$empire->query("ALTER TABLE {$dbtbpre}ecms_".$tbname." ADD INDEX(".$f.")");
				$empire->query("ALTER TABLE {$dbtbpre}ecms_".$tbname."_doc ADD INDEX(".$f.")");
				$empire->query("ALTER TABLE {$dbtbpre}ecms_".$tbname."_check ADD INDEX(".$f.")");
			}
		}
		elseif($add['oldiskey']==1&&$iskey==0)//ɾ������
		{
			$empire->query("ALTER TABLE {$dbtbpre}ecms_".$tbname." DROP INDEX ".$f);
			$empire->query("ALTER TABLE {$dbtbpre}ecms_".$tbname."_doc DROP INDEX ".$f);
			$empire->query("ALTER TABLE {$dbtbpre}ecms_".$tbname."_check DROP INDEX ".$f);
		}
	}
	//��������
	$add[isonly]=(int)$add[isonly];
	$add[myorder]=(int)$add[myorder];
	//�滻����
	if($add[fform]<>$add[oldfform]||$add[fvalue]<>$add[oldfvalue]||$add[oldlinkfieldtb]<>$add[linkfieldtb]||$add[oldlinkfieldshow]<>$add[linkfieldshow]||$add[linkfieldval]<>$add[oldlinkfieldval]||$add[fformsize]<>$add[oldfformsize])
	{
		$fhtml=GetFform($add[fform],$add[f],$add[fvalue],$add[linkfieldval],$add[fformsize],$add);
	}
	else
	{
		$fhtml=$add[fhtml];
	}
	if($add[fform]<>$add[oldfform]||$add[fvalue]<>$add[oldfvalue]||$add[oldlinkfieldtb]<>$add[linkfieldtb]||$add[oldlinkfieldshow]<>$add[linkfieldshow]||$add[linkfieldval]<>$add[oldlinkfieldval]||$add[fformsize]<>$add[oldfformsize])
	{
		$qfhtml=GetQFform($add[fform],$add[f],$add[fvalue],$add[fformsize],$add);
	}
	else
	{
		$qfhtml=$add[qfhtml];
	}
	$sql=$empire->query("update {$dbtbpre}enewsf set fname='$add[fname]',fform='$add[fform]',fhtml='".eaddslashes2($fhtml)."',fzs='".eaddslashes($add[fzs])."',myorder=$add[myorder],flen='$add[flen]',fvalue='".eaddslashes2($add[fvalue])."',iskey=$iskey,qfhtml='".eaddslashes2($qfhtml)."',isonly='$add[isonly]',linkfieldval='$add[linkfieldval]',samedata='$add[samedata]',fformsize='$add[fformsize]',adddofun='$add[adddofun]',editdofun='$add[editdofun]',qadddofun='$add[qadddofun]',qeditdofun='$add[qeditdofun]',linkfieldtb='$add[linkfieldtb]',linkfieldshow='$add[linkfieldshow]'".$addupdate." where fid='$fid'");
	TogSaveTxtF(1);//��������
	//���±���
	$fsql=$empire->query("select mid,mtemp,tid,qmtemp from {$dbtbpre}enewsmod where tid='$tid'");
	while($fr=$empire->fetch($fsql))
	{
		ChangeMForm($fr[mid],$fr[tid],$fr[mtemp]);
		ChangeQmForm($fr[mid],$fr[tid],$fr[qmtemp]);
	}
	GetConfig(1);//���»���
	if($sql)
	{
		insert_dolog("fid=".$fid."<br>f=".$f);//������־
		printerror("EditFSuccess","db/EditSysF.php?tid=$tid&tbname=$tbname&fid=$fid");
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//ɾ�����ݿ��ֶ�
function DelF($fid,$tid,$tbname,$userid,$username){
	global $empire,$dbtbpre;
	$tid=(int)$tid;
	$tbname=RepPostVar($tbname);
	$fid=(int)$fid;
	if(empty($fid)||!$tid||!$tbname)
	{
		printerror("EmptyFid","history.go(-1)");
	}
	CheckLevel($userid,$username,$classid,"f");//��֤Ȩ��
	//�Ƿ�ϵͳ�ڲ��ֶ�
	$cr=$empire->fetch1("select isadd,f,tbdataf,iscj from {$dbtbpre}enewsf where fid='$fid'");
	if(empty($cr[isadd]))
	{
		printerror("NotIsAdd","history.go(-1)");
	}
	//ɾ�����ֶ�
	if($cr['tbdataf']==1)
	{
		$tbr=$empire->fetch1("select datatbs from {$dbtbpre}enewstable where tid='$tid'");
		if($tbr['datatbs'])
		{
			$dtbr=explode(',',$tbr['datatbs']);
			$count=count($dtbr);
			for($i=1;$i<$count-1;$i++)
			{
				$empire->query("alter table {$dbtbpre}ecms_".$tbname."_data_".$dtbr[$i]." drop COLUMN ".$cr[f]);
			}
		}
		//�鵵����
		$empire->query("alter table {$dbtbpre}ecms_".$tbname."_doc_data drop COLUMN ".$cr[f]);
		//��˸���
		$empire->query("alter table {$dbtbpre}ecms_".$tbname."_check_data drop COLUMN ".$cr[f]);
	}
	else
	{
		$usql=$empire->query("alter table {$dbtbpre}ecms_".$tbname." drop COLUMN ".$cr[f]);
		$usql=$empire->query("alter table {$dbtbpre}ecms_".$tbname."_doc drop COLUMN ".$cr[f]);
		$usql=$empire->query("alter table {$dbtbpre}ecms_".$tbname."_check drop COLUMN ".$cr[f]);
	}
	//�ɼ����ֶ�
	if($cr[iscj]==1)
	{
		$usql=$empire->query("alter table {$dbtbpre}ecms_infotmp_".$tbname." drop COLUMN ".$cr[f]);
		$usql=$empire->query("alter table {$dbtbpre}ecms_infoclass_".$tbname." drop COLUMN zz_".$cr[f].",drop COLUMN z_".$cr[f].",drop COLUMN qz_".$cr[f].",drop COLUMN save_".$cr[f]);
	}
	$sql=$empire->query("delete from {$dbtbpre}enewsf where fid='$fid'");
	TogSaveTxtF(1);//��������
	//ɾ��ģ�����ֶ���
	$record="<!--record-->";
	$field="<!--field--->";
	$like=$field.$cr[f].$record;
	$slike=",".$cr[f].",";
	$dsql=$empire->query("select mid,cj,enter,tempvar,searchvar,tid,qenter,mustqenterf,listandf,listtempvar,canaddf,caneditf,orderf from {$dbtbpre}enewsmod where tid='$tid' and (cj like '%".$like."%' or enter like '%".$like."%' or searchvar like '%".$slike."%' or tempvar like '%".$like."%' or listtempvar like '%".$like."%' or qenter like '%".$like."%' or mustqenterf like '%".$slike."%' or listandf like '%".$slike."%' or canaddf like '%".$slike."%' or caneditf like '%".$slike."%' or orderf like '%".$slike."%')");
	while($r=$empire->fetch($dsql))
	{
		$cj="";
		$enter="";
		$tempvar="";
		$listtempvar="";
		$searchvar="";
		$qenter="";
		$mustqenterf="";
		$listandf="";
		$orderf="";
		$canaddf="";
		$caneditf="";
		$re="";
		$re1="";
		$and="";
		$dh="";
		//�ɼ�
		if(strstr($r[cj],$like))
		{
			$re=explode($record,$r[cj]);
			for($i=0;$i<count($re)-1;$i++)
			{
				if(strstr($re[$i].$record,$like))
				{continue;}
				$cj.=$re[$i].$record;
			}
			//���²ɼ�����
			ChangeMCj($r[mid],$r[tid],$cj);
			$and="cj='$cj'";
		}
		$dh="";
		//¼�����
		if(strstr($r[enter],$like))
		{
			$re1=explode($record,$r[enter]);
			for($i=0;$i<count($re1)-1;$i++)
			{
				if(strstr($re1[$i].$record,$like))
				{continue;}
				$enter.=$re1[$i].$record;
			}
			if(!empty($and))
			{$dh=",";}
			$and.=$dh."enter='$enter'";
	    }
		$dh="";
		//Ͷ�����
		if(strstr($r[qenter],$like))
		{
			$re1=explode($record,$r[qenter]);
			for($i=0;$i<count($re1)-1;$i++)
			{
				if(strstr($re1[$i].$record,$like))
				{continue;}
				$qenter.=$re1[$i].$record;
			}
			if(!empty($and))
			{$dh=",";}
			$and.=$dh."qenter='$qenter'";
	    }
		$dh="";
		//����ģ�����
		if(strstr($r[tempvar],$like))
		{
			$re1=explode($record,$r[tempvar]);
			for($i=0;$i<count($re1)-1;$i++)
			{
				if(strstr($re1[$i].$record,$like))
				{continue;}
				$tempvar.=$re1[$i].$record;
			}
			if(!empty($and))
			{$dh=",";}
			$and.=$dh."tempvar='$tempvar'";
	    }
		$dh="";
		//�б�ģ�����
		if(strstr($r[listtempvar],$like))
		{
			$re1=explode($record,$r[listtempvar]);
			for($i=0;$i<count($re1)-1;$i++)
			{
				if(strstr($re1[$i].$record,$like))
				{continue;}
				$listtempvar.=$re1[$i].$record;
			}
			if(!empty($and))
			{$dh=",";}
			$and.=$dh."listtempvar='$listtempvar'";
	    }
		$dh="";
		//��������
		if(strstr($r[searchvar],$slike))
		{
			if(!empty($and))
			{$dh=",";}
			$searchvar=str_replace($slike,",",$r[searchvar]);
		    $and.=$dh."searchvar='$searchvar'";
		}
		//������
		$dh="";
		if(strstr($r[mustqenterf],$slike))
		{
			if(!empty($and))
			{$dh=",";}
			$mustqenterf=str_replace($slike,",",$r[mustqenterf]);
		    $and.=$dh."mustqenterf='$mustqenterf'";
		}
		//�������޸���
		$dh="";
		if(strstr($r[canaddf],$slike))
		{
			if(!empty($and))
			{$dh=",";}
			$canaddf=str_replace($slike,",",$r[canaddf]);
		    $and.=$dh."canaddf='$canaddf'";
		}
		$dh="";
		if(strstr($r[caneditf],$slike))
		{
			if(!empty($and))
			{$dh=",";}
			$caneditf=str_replace($slike,",",$r[caneditf]);
		    $and.=$dh."caneditf='$caneditf'";
		}
		//�����
		$dh="";
		if(strstr($r[listandf],$slike))
		{
			if(!empty($and))
			{$dh=",";}
			$listandf=str_replace($slike,",",$r[listandf]);
		    $and.=$dh."listandf='$listandf'";
		}
		//������
		$dh="";
		if(strstr($r[orderf],$slike))
		{
			if(!empty($and))
			{$dh=",";}
			$orderf=str_replace($slike,",",$r[orderf]);
		    $and.=$dh."orderf='$orderf'";
		}
		if($and)
		{
			$empire->query("update {$dbtbpre}enewsmod set ".$and." where mid='$r[mid]'");
		}
    }
	GetConfig(1);//���»���
    if($sql)
	{
		//������־
		insert_dolog("fid=".$fid."<br>f=".$cr[f]);
		printerror("DelFSuccess","db/ListF.php?tid=$tid&tbname=$tbname");
	}
	else
	{printerror("DbError","history.go(-1)");}
}

//�޸��ֶ�˳��
function EditFOrder($fid,$myorder,$tid,$tbname,$userid,$username){
	global $empire,$dbtbpre;
	$tid=(int)$tid;
	$tbname=RepPostVar($tbname);
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"f");
	for($i=0;$i<count($myorder);$i++)
	{
		$newmyorder=(int)$myorder[$i];
		$usql=$empire->query("update {$dbtbpre}enewsf set myorder=$newmyorder where fid='$fid[$i]'");
    }
	printerror("EditFOrderSuccess","db/ListF.php?tid=$tid&tbname=$tbname");
}

//ת���ֶ�
function ChangeDataTableF($add,$userid,$username){
	global $empire,$dbtbpre,$public_r,$fun_r;
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"f");
	$fid=(int)$add[fid];
	$tid=(int)$add[tid];
	$tbname=RepPostVar($add[tbname]);
	$line=(int)$add[line];
	$start=(int)$add[start];
	if(!$fid||!$tid||!$tbname)
	{
		printerror("ErrorUrl","history.go(-1)");
	}
	if(empty($line))
	{
		$line=200;
	}
	$fr=$empire->fetch1("select * from {$dbtbpre}enewsf where fid='$fid'");
	if(!$fr[fid])
	{
		printerror("ErrorUrl","history.go(-1)");
	}
	if(empty($fr[isadd]))
	{
		printerror("NotIsAdd","history.go(-1)");
	}
	$tid=$fr[tid];
	$tbname=$fr[tbname];
	$f=$fr[f];
	//���ֶ�
	if(empty($start))
	{
		$field=ReturnTbFtype($fr);//�����ֶ�
		if($fr[tbdataf])//ת�Ƶ�����
		{
			$empire->query("alter table {$dbtbpre}ecms_".$tbname." add ".$field);
			if($fr[iskey]==1)//����
			{
				$empire->query("ALTER TABLE {$dbtbpre}ecms_".$tbname." ADD INDEX(".$fr[f].")");
			}
			//�鵵����
			$empire->query("alter table {$dbtbpre}ecms_".$tbname."_doc add ".$field);
			if($fr[iskey]==1)//����
			{
				$empire->query("ALTER TABLE {$dbtbpre}ecms_".$tbname."_doc ADD INDEX(".$fr[f].")");
			}
			//�������
			$empire->query("alter table {$dbtbpre}ecms_".$tbname."_check add ".$field);
			if($fr[iskey]==1)//����
			{
				$empire->query("ALTER TABLE {$dbtbpre}ecms_".$tbname."_check ADD INDEX(".$fr[f].")");
			}
		}
		else//ת�Ƶ�����
		{
			$tbr=$empire->fetch1("select datatbs from {$dbtbpre}enewstable where tid='$tid'");
			if($tbr['datatbs'])
			{
				$dtbr=explode(',',$tbr['datatbs']);
				$count=count($dtbr);
				for($i=1;$i<$count-1;$i++)
				{
					$empire->query("alter table {$dbtbpre}ecms_".$tbname."_data_".$dtbr[$i]." add ".$field);
					if($fr[iskey]==1)//����
					{
						$empire->query("ALTER TABLE {$dbtbpre}ecms_".$tbname."_data_".$dtbr[$i]." ADD INDEX(".$fr[f].")");
					}
				}
			}
			//�鵵����
			$empire->query("alter table {$dbtbpre}ecms_".$tbname."_doc_data add ".$field);
			if($fr[iskey]==1)//����
			{
				$empire->query("ALTER TABLE {$dbtbpre}ecms_".$tbname."_doc_data ADD INDEX(".$fr[f].")");
			}
			//��˸���
			$empire->query("alter table {$dbtbpre}ecms_".$tbname."_check_data add ".$field);
			if($fr[iskey]==1)//����
			{
				$empire->query("ALTER TABLE {$dbtbpre}ecms_".$tbname."_check_data ADD INDEX(".$fr[f].")");
			}
		}
	}
	$selectf='';
	if(empty($fr[tbdataf]))
	{
		$selectf=','.$fr[f];
	}
	$b=0;
	$sql=$empire->query("select id,checked from {$dbtbpre}ecms_".$tbname."_index where id>$start order by id limit ".$line);
	while($r=$empire->fetch($sql))
	{
		$b=1;
		$newstart=$r['id'];
		//����
		$infotb=ReturnInfoMainTbname($tbname,$r['checked']);
		$infor=$empire->fetch1("select stb".$selectf." from ".$infotb." where id='$r[id]'");
		$infodatatb=ReturnInfoDataTbname($tbname,$r['checked'],$infor['stb']);
		if($fr[tbdataf])//����
		{
			$finfor=$empire->fetch1("select ".$f." from ".$infodatatb." where id='$r[id]'");
			$value=$finfor[$f];
			$empire->query("update ".$infotb." set ".$f."='".StripAddsData($value)."' where id='$r[id]'");
		}
		else//����
		{
			$value=$infor[$f];
			$empire->query("update ".$infodatatb." set ".$f."='".StripAddsData($value)."' where id='$r[id]'");
		}
	}
	if(empty($b))
	{
		echo"<link rel=\"stylesheet\" href=\"../data/images/css.css\" type=\"text/css\"><meta http-equiv=\"refresh\" content=\"".$public_r['realltime'].";url=ecmsmod.php?enews=ChangeDocDataTableF&tid=$tid&tbname=$tbname&fid=$fid&line=$line\">".$fun_r[AllChangeDataTableFSuccess];
		exit();
	}
	echo"<link rel=\"stylesheet\" href=\"../data/images/css.css\" type=\"text/css\"><meta http-equiv=\"refresh\" content=\"".$public_r['realltime'].";url=ecmsmod.php?enews=ChangeDataTableF&tid=$tid&tbname=$tbname&fid=$fid&line=$line&start=$newstart\">".$fun_r[OneChangeDataTableFSuccess]."(ID:<font color=red><b>".$newstart."</b></font>)";
	exit();
}

//ת���ֶ�(�鵵)
function ChangeDocDataTableF($add,$userid,$username){
	global $empire,$dbtbpre,$public_r,$fun_r;
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"f");
	$fid=(int)$add[fid];
	$tid=(int)$add[tid];
	$tbname=RepPostVar($add[tbname]);
	$line=(int)$add[line];
	$start=(int)$add[start];
	if(!$fid||!$tid||!$tbname)
	{
		printerror("ErrorUrl","history.go(-1)");
	}
	if(empty($line))
	{
		$line=200;
	}
	$fr=$empire->fetch1("select * from {$dbtbpre}enewsf where fid='$fid'");
	if(!$fr[fid])
	{
		printerror("ErrorUrl","history.go(-1)");
	}
	if(empty($fr[isadd]))
	{
		printerror("NotIsAdd","history.go(-1)");
	}
	$tid=$fr[tid];
	$tbname=$fr[tbname];
	$f=$fr[f];
	$selectf='';
	if(empty($fr[tbdataf]))
	{
		$selectf=','.$fr[f];
	}
	$b=0;
	$sql=$empire->query("select id,stb".$selectf." from {$dbtbpre}ecms_".$tbname."_doc where id>$start order by id limit ".$line);
	while($r=$empire->fetch($sql))
	{
		$b=1;
		$newstart=$r['id'];
		if($fr[tbdataf])//����
		{
			$finfor=$empire->fetch1("select ".$f." from {$dbtbpre}ecms_".$tbname."_doc_data where id='$r[id]'");
			$value=$finfor[$f];
			$empire->query("update {$dbtbpre}ecms_".$tbname."_doc set ".$f."='".StripAddsData($value)."' where id='$r[id]'");
		}
		else//����
		{
			$value=$r[$f];
			$empire->query("update {$dbtbpre}ecms_".$tbname."_doc_data set ".$f."='".StripAddsData($value)."' where id='$r[id]'");
		}
	}
	if(empty($b))
	{
		//ɾ���ֶ�
		if($fr[tbdataf])//ת�Ƶ�����
		{
			$tbr=$empire->fetch1("select datatbs from {$dbtbpre}enewstable where tid='$tid'");
			if($tbr['datatbs'])
			{
				$dtbr=explode(',',$tbr['datatbs']);
				$count=count($dtbr);
				for($i=1;$i<$count-1;$i++)
				{
					$empire->query("alter table {$dbtbpre}ecms_".$tbname."_data_".$dtbr[$i]." drop COLUMN ".$fr[f]);
				}
			}
			//�鵵����
			$empire->query("alter table {$dbtbpre}ecms_".$tbname."_doc_data drop COLUMN ".$fr[f]);
			//��˸���
			$empire->query("alter table {$dbtbpre}ecms_".$tbname."_check_data drop COLUMN ".$fr[f]);
		}
		else//ת�Ƶ�����
		{
			$empire->query("alter table {$dbtbpre}ecms_".$tbname." drop COLUMN ".$fr[f]);
			$empire->query("alter table {$dbtbpre}ecms_".$tbname."_doc drop COLUMN ".$fr[f]);
			$empire->query("alter table {$dbtbpre}ecms_".$tbname."_check drop COLUMN ".$fr[f]);
		}
		$newtbdataf=$fr[tbdataf]?0:1;
		$empire->query("update {$dbtbpre}enewsf set tbdataf='$newtbdataf' where fid='$fid'");
		//ɾ��ģ�����ֶ���
		if(empty($tbr['datatbs']))
		{
			$record="<!--record-->";
			$field="<!--field--->";
			$like=$field.$fr[f].$record;
			$slike=",".$fr[f].",";
			$dsql=$empire->query("select mid,searchvar,listandf,listtempvar,orderf from {$dbtbpre}enewsmod where tid='$tid' and (searchvar like '%".$slike."%' or listtempvar like '%".$like."%' or listandf like '%".$slike."%' or orderf like '%".$slike."%')");
			while($r=$empire->fetch($dsql))
			{
				$listtempvar="";
				$searchvar="";
				$listandf="";
				$orderf="";
				$re="";
				$re1="";
				$and="";
				$dh="";
				//�б�ģ�����
				if(strstr($r[listtempvar],$like))
				{
					$re1=explode($record,$r[listtempvar]);
					for($i=0;$i<count($re1)-1;$i++)
					{
						if(strstr($re1[$i].$record,$like))
						{continue;}
						$listtempvar.=$re1[$i].$record;
					}
					$and.=$dh."listtempvar='$listtempvar'";
				}
				$dh="";
				//��������
				if(strstr($r[searchvar],$slike))
				{
					if(!empty($and))
					{$dh=",";}
					$searchvar=str_replace($slike,",",$r[searchvar]);
					$and.=$dh."searchvar='$searchvar'";
				}
				//�����
				$dh="";
				if(strstr($r[listandf],$slike))
				{
					if(!empty($and))
					{$dh=",";}
					$listandf=str_replace($slike,",",$r[listandf]);
					$and.=$dh."listandf='$listandf'";
				}
				//������
				$dh="";
				if(strstr($r[orderf],$slike))
				{
					if(!empty($and))
					{$dh=",";}
					$orderf=str_replace($slike,",",$r[orderf]);
					$and.=$dh."orderf='$orderf'";
				}
				if($and)
				{
					$empire->query("update {$dbtbpre}enewsmod set ".$and." where mid='$r[mid]'");
				}
			}
		}
		GetConfig(1);//���»���
		insert_dolog("tid=$tid&tbname=$tbname<br>fid=$fid&field=$f&tbdataf=".$newtbdataf);//������־
		printerror("ChangeDataTableFSuccess","db/ListF.php?tid=$tid&tbname=$tbname");
	}
	echo"<link rel=\"stylesheet\" href=\"../data/images/css.css\" type=\"text/css\"><meta http-equiv=\"refresh\" content=\"".$public_r['realltime'].";url=ecmsmod.php?enews=ChangeDocDataTableF&tid=$tid&tbname=$tbname&fid=$fid&line=$line&start=$newstart\">".$fun_r[OneChangeDocDataTableFSuccess]."(ID:<font color=red><b>".$newstart."</b></font>)";
	exit();
}


//************************** ģ�� **************************

//����Ĭ��ϵͳģ��
function UpdateTbDefMod($tid,$tbname,$mid){
	global $empire,$dbtbpre;
	$num=$empire->gettotal("select count(*) as total from {$dbtbpre}enewsmod where tid='$tid'");
	if($num==1)
	{
		$empire->query("update {$dbtbpre}enewstable set mid='$mid' where tid='$tid'");
		$empire->query("update {$dbtbpre}enewsmod set isdefault=1 where mid='$mid'");
	}
}

//����ģ�ͱ���
function ChangeMForm($mid,$tid,$mtemp){
	global $empire,$dbtbpre;
	$file="../data/html/".$mid.".php";
	$sql=$empire->query("select f,fhtml from {$dbtbpre}enewsf where tid='$tid'");
	while($r=$empire->fetch($sql))
	{
		$mtemp=str_replace("[!--".$r[f]."--]",$r[fhtml],$mtemp);
    }
	$mtemp=AddCheckViewTempCode().$mtemp;
	WriteFiletext($file,$mtemp);
}

//����Ͷ�����
function ChangeQmForm($mid,$tid,$mtemp){
	global $empire,$dbtbpre;
	$file="../data/html/q".$mid.".php";
	$sql=$empire->query("select f,qfhtml from {$dbtbpre}enewsf where tid='$tid'");
	while($r=$empire->fetch($sql))
	{
		$mtemp=str_replace("[!--".$r[f]."--]",$r[qfhtml],$mtemp);
    }
	$mtemp=AddCheckViewTempCode().$mtemp;
	WriteFiletext($file,$mtemp);
}

//���²ɼ�
function ChangeMCj($mid,$tid,$cj){
	global $empire,$dbtbpre;
	$record="<!--record-->";
	$field="<!--field--->";
	//��ȡ�޸Ĳɼ�����
	$data="<tr><td bgcolor=ffffff>[!--enews.name--]</td><td bgcolor=ffffff>[!--enews.var--]</td></tr>";
	$file1="../data/html/editcj".$mid.".php";
	$file="../data/html/cj".$mid.".php";
	$r=explode($record,$cj);
	for($i=0;$i<count($r)-1;$i++)
	{
		$r1=explode($field,$r[$i]);
		$fr=$empire->fetch1("select cjhtml,fhtml from {$dbtbpre}enewsf where f='$r1[1]' and tid='$tid' limit 1");
		$cjtemp=str_replace("[!--enews.name--]",$r1[0],$fr[cjhtml]);
		$str.=$cjtemp;
		$editcjtemp=str_replace("[!--enews.name--]",$r1[0],$data);
		$editcjtemp=str_replace("[!--enews.var--]",$fr[fhtml],$editcjtemp);
		$editcj.=$editcjtemp;
	}
	WriteFiletext($file,AddCheckViewTempCode().$str);
	WriteFiletext($file1,AddCheckViewTempCode().$editcj);
}

//��ϲɼ���
function TogMCj($cname,$cchange){
	$record="<!--record-->";
	$field="<!--field--->";
	$c="";
	for($i=0;$i<count($cchange);$i++)
	{
		$v=$cchange[$i];
		$name=str_replace($field,"",$cname[$v]);
		$name=str_replace($record,"",$name);
		$c.=$name.$field.$v.$record;
	}
	return $c;
}

//���Ͷ����
function TogMqenter($cname,$cqenter){
	$record="<!--record-->";
	$field="<!--field--->";
	$c="";
	for($i=0;$i<count($cqenter);$i++)
	{
		$v=$cqenter[$i];
		$name=str_replace($field,"",$cname[$v]);
		$name=str_replace($record,"",$name);
		$c.=$name.$field.$v.$record;
	}
	return $c;
}

//���������
function TogMSearch($cname,$schange){
	$c="";
	for($i=0;$i<count($schange);$i++)
	{
		$v=$schange[$i];
		$c.=$v.",";
	}
	if($c)
	{
		$c=",".$c;
	}
	return $c;
}

//��ϱ�����
function TogMustf($cname,$menter){
	$c="";
	for($i=0;$i<count($menter);$i++)
	{
		$v=$menter[$i];
		$c.=$v.",";
	}
	if($c)
	{
		$c=",".$c;
	}
	return $c;
}

//���¼����
function TogMEnter($cname,$center,$ltempf,$ptempf,$tid){
	global $empire;
	$f=1;
	$record="<!--record-->";
	$field="<!--field--->";
	$c="";
	$lt="";
	$pt="";
	for($i=0;$i<count($center);$i++)
	{
		$v=$center[$i];
		$name=str_replace($field,"",$cname[$v]);
		$name=str_replace($record,"",$name);
		$c.=$name.$field.$v.$record;
	}
	for($i=0;$i<count($ltempf);$i++)
	{
		$v=$ltempf[$i];
		$name=str_replace($field,"",$cname[$v]);
		$name=str_replace($record,"",$name);
		$lt.=$name.$field.$v.$record;
	}
	for($i=0;$i<count($ptempf);$i++)
	{
		$v=$ptempf[$i];
		$name=str_replace($field,"",$cname[$v]);
		$name=str_replace($record,"",$name);
		$pt.=$name.$field.$v.$record;
	}
	$r[0]=$c;
	$r[1]=$lt;
	$r[2]=$pt;
	return $r;
}

//�����Զ�����¼�����ģ��
function ReturnMtemp($cname,$center){
	$temp="<tr><td width='16%' height=25 bgcolor='ffffff'>enews.name</td><td bgcolor='ffffff'>[!--enews.var--]</td></tr>";
	$ntemp="<tr><td height=25 colspan=2 bgcolor='ffffff'><div align=left>enews.name</div></td></tr></table><div style='background-color:#D0D0D0'>[!--enews.var--]</div><table width='100%' align=center cellpadding=3 cellspacing=1 bgcolor='#DBEAF5'>";
	for($i=0;$i<count($center);$i++)
	{
		$v=$center[$i];
		if($v=="newstext")
		{
			$data.=str_replace("enews.var",$v,str_replace("enews.name",$cname[$v],$ntemp));
			continue;
		}
		$data.=str_replace("enews.var",$v,str_replace("enews.name",$cname[$v],$temp));
    }
	return "<table width='100%' align=center cellpadding=3 cellspacing=1 bgcolor='#DBEAF5'>".$data."</table>";
}

//�����Զ�����Ͷ�����ģ��
function ReturnQmtemp($cname,$cqenter){
	$temp="<tr><td width='16%' height=25 bgcolor='ffffff'>enews.name</td><td bgcolor='ffffff'>[!--enews.var--]</td></tr>";
	$ntemp="<tr><td height=25 colspan=2 bgcolor='ffffff'><div align=left>enews.name</div></td></tr></table><div style='background-color:#D0D0D0'>[!--enews.var--]</div><table width='100%' align=center cellpadding=3 cellspacing=1 bgcolor='#DBEAF5'>";
	for($i=0;$i<count($cqenter);$i++)
	{
		$v=$cqenter[$i];
		if($v=="newstext")
		{
			$data.=str_replace("enews.var",$v,str_replace("enews.name",$cname[$v],$ntemp));
			continue;
		}
		$data.=str_replace("enews.var",$v,str_replace("enews.name",$cname[$v],$temp));
    }
	return "<table width=100% align=center cellpadding=3 cellspacing=1 bgcolor=#DBEAF5>".$data."</table>";
}

//����br��
function ReturnMTobrF($enter,$tid,$dof="tobr"){
	global $empire,$dbtbpre;
	$record="<!--record-->";
	$field="<!--field--->";
	$f=",";
	$sql=$empire->query("select f from {$dbtbpre}enewsf where ".$dof."=0 and tid='$tid'");
	while($r=$empire->fetch($sql))
	{
		if(strstr($enter,$field.$r[f].$record))
		{
			$f.=$r[f].",";
		}
	}
	return $f;
}

//����ģ��
function AddM($add,$cname,$cchange,$schange,$center,$cqenter,$menter,$listand,$ltempf,$ptempf,$canadd,$canedit,$listorder,$userid,$username){
	global $empire,$dbtbpre;
	$tid=(int)$add['tid'];
	$tbname=RepPostVar($add['tbname']);
	if(empty($add[mname])||!$tid||!$tbname)
	{
		printerror("EmptyM","history.go(-1)");
	}
	$listfile=eReturnCPath(str_replace('.','',$add[listfile]),'');
	CheckLevel($userid,$username,$classid,"m");//��֤Ȩ��
	//��ϲɼ���
	$cj=TogMCj($cname,$cchange);
	//���������
    $searchvar=TogMSearch($cname,$schange);
	//��ϱ�����
	$mustqenterf=TogMustf($cname,$menter);
	//��Ͻ����
	$listandf=TogMustf($cname,$listand);
	//���������
	$orderf=TogMustf($cname,$listorder);
	//���Ͷ����
	$qenter=TogMqenter($cname,$cqenter);
	//��Ͽ�������
	$canaddf=TogMustf($cname,$canadd);
	//��Ͽ��޸���
	$caneditf=TogMustf($cname,$canedit);
	//���¼����
    $er=TogMEnter($cname,$center,$ltempf,$ptempf,$tid);
    $enter=$er[0];	//¼����
	$listtempvar=$er[1];	//�б�ģ����
	$tempvar=$er[2];	//����ģ����
	//�Զ����ɱ���
	if($add[mtype])
	{
		$add[mtemp]=ReturnMtemp($cname,$center);
	}
	if($add[qmtype])
	{
		$add[qmtemp]=ReturnQmtemp($cname,$cqenter);
	}
	$setandf=(int)$add['setandf'];
	$add[definfovoteid]=(int)$add[definfovoteid];
	$showmod=(int)$add['showmod'];
	$usemod=(int)$add['usemod'];
	$myorder=(int)$add['myorder'];
	$add[printtempid]=(int)$add[printtempid];
	$sql=$empire->query("insert into {$dbtbpre}enewsmod(mname,mtemp,mzs,cj,enter,tempvar,sonclass,searchvar,tid,tbname,qenter,mustqenterf,qmtemp,listandf,setandf,listtempvar,qmname,canaddf,caneditf,definfovoteid,showmod,usemod,myorder,orderf,isdefault,listfile,printtempid) values('$add[mname]','".eaddslashes2($add[mtemp])."','$add[mzs]','$cj','$enter','$tempvar','','$searchvar',$tid,'$tbname','$qenter','$mustqenterf','".eaddslashes2($add[qmtemp])."','".addslashes($listandf)."','$setandf','$listtempvar','$add[qmname]','$canaddf','$caneditf',$add[definfovoteid],'$showmod','$usemod','$myorder','$orderf',0,'$listfile','$add[printtempid]');");
	$mid=$empire->lastid();
	UpdateTbDefMod($tid,$tbname,$mid);
	//���±���
	ChangeMForm($mid,$tid,$add[mtemp]);
	ChangeQmForm($mid,$tid,$add[qmtemp]);
	//�ɼ��ļ�
	ChangeMCj($mid,$tid,$cj);
	GetConfig(1);//���»���
    if($sql)
	{
	    insert_dolog("mid=".$mid."<br>m=".$add[mname]);//������־
		printerror("AddMSuccess","db/ListM.php?tid=$tid&tbname=$tbname");
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//�޸�ģ��
function EditM($add,$cname,$cchange,$schange,$center,$cqenter,$menter,$listand,$ltempf,$ptempf,$canadd,$canedit,$listorder,$userid,$username){
	global $empire,$dbtbpre;
	$tid=(int)$add['tid'];
	$tbname=RepPostVar($add['tbname']);
	$add[mid]=(int)$add[mid];
	if(empty($add[mname])||empty($add[mid])||!$tid||!$tbname)
	{
		printerror("EmptyM","history.go(-1)");
	}
	$listfile=eReturnCPath(str_replace('.','',$add[listfile]),'');
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"m");
	//��ϲɼ���
	$cj=TogMCj($cname,$cchange);
	//���������
    $searchvar=TogMSearch($cname,$schange);
	//��ϱ�����
	$mustqenterf=TogMustf($cname,$menter);
	//��Ͻ����
	$listandf=TogMustf($cname,$listand);
	//���������
	$orderf=TogMustf($cname,$listorder);
	//���Ͷ����
	$qenter=TogMqenter($cname,$cqenter);
	//��Ͽ�������
	$canaddf=TogMustf($cname,$canadd);
	//��Ͽ��޸���
	$caneditf=TogMustf($cname,$canedit);
	//���¼����
	$er=TogMEnter($cname,$center,$ltempf,$ptempf,$tid);
    $enter=$er[0];	//¼����
	$listtempvar=$er[1];	//�б�ģ����
	$tempvar=$er[2];	//����ģ����
	//�Զ����ɱ���
	if($add[mtype])
	{
		$add[mtemp]=ReturnMtemp($cname,$center);
	}
	if($add[qmtype])
	{
		$add[qmtemp]=ReturnQmtemp($cname,$cqenter);
	}
	$setandf=(int)$add['setandf'];
	$add[definfovoteid]=(int)$add[definfovoteid];
	$showmod=(int)$add['showmod'];
	$usemod=(int)$add['usemod'];
	$myorder=(int)$add['myorder'];
	$add[printtempid]=(int)$add[printtempid];
	$sql=$empire->query("update {$dbtbpre}enewsmod set mname='$add[mname]',mtemp='".eaddslashes2($add[mtemp])."',mzs='$add[mzs]',cj='$cj',enter='$enter',tempvar='$tempvar',searchvar='$searchvar',qenter='$qenter',mustqenterf='$mustqenterf',qmtemp='".eaddslashes2($add[qmtemp])."',listandf='".addslashes($listandf)."',setandf=$setandf,listtempvar='$listtempvar',qmname='$add[qmname]',canaddf='$canaddf',caneditf='$caneditf',definfovoteid=$add[definfovoteid],showmod='$showmod',usemod='$usemod',myorder='$myorder',orderf='$orderf',listfile='$listfile',printtempid='$add[printtempid]' where mid='$add[mid]'");
	//���±���
	ChangeMForm($add[mid],$tid,$add[mtemp]);
	ChangeQmForm($add[mid],$tid,$add[qmtemp]);
	//�ɼ��ļ�
	ChangeMCj($add[mid],$tid,$cj);
	GetConfig(1);//���»���
    if($sql)
	{
		//������־
	    insert_dolog("mid=".$add[mid]."<br>m=".$add[mname]);
		printerror("EditMSuccess","db/ListM.php?tid=$tid&tbname=$tbname");
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//ɾ��ģ��
function DelM($mid,$tid,$tbname,$userid,$username){
	global $empire,$dbtbpre;
	$tid=(int)$tid;
	$tbname=RepPostVar($tbname);
	$mid=(int)$mid;
	if(empty($mid)||!$tid||!$tbname)
	{
		printerror("EmptyMid","history.go(-1)");
	}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"m");
	$r=$empire->fetch1("select mname,isdefault from {$dbtbpre}enewsmod where mid='$mid'");
	$sql=$empire->query("delete from {$dbtbpre}enewsmod where mid='$mid'");
	$empire->query("delete from {$dbtbpre}enewsinfotype where mid='$mid'");//ɾ���������
	DelFiletext("../data/html/".$mid.".php");
	DelFiletext("../data/html/q".$mid.".php");
	DelFiletext("../data/html/cj".$mid.".php");
	DelFiletext("../data/html/editcj".$mid.".php");
	//��Ĭ��ģ��
	if($r[isdefault])
	{
		$modr=$empire->fetch1("select mid from {$dbtbpre}enewsmod where tid='$tid' order by mid");
		if($modr[mid])
		{
			$empire->query("update {$dbtbpre}enewstable set mid='$modr[mid]' where tid='$tid'");
			$empire->query("update {$dbtbpre}enewsmod set isdefault=1 where mid='$modr[mid]'");
		}
	}
	GetConfig(1);//���»���
    if($sql)
	{
	    insert_dolog("mid=".$mid."<br>m=".$r[mname]);//������־
		printerror("DelMSuccess","db/ListM.php?tid=$tid&tbname=$tbname");
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//Ĭ��ģ��
function DefM($mid,$tid,$tbname,$userid,$username){
	global $empire,$dbtbpre;
	$tid=(int)$tid;
	$tbname=RepPostVar($tbname);
	$mid=(int)$mid;
	if(empty($mid)||!$tid||!$tbname)
	{
		printerror("EmptyDefMid","history.go(-1)");
	}
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"m");
	$r=$empire->fetch1("select mname from {$dbtbpre}enewsmod where mid='$mid'");
	$empire->query("update {$dbtbpre}enewsmod set isdefault=0 where tid='$tid'");
	$sql=$empire->query("update {$dbtbpre}enewsmod set isdefault=1 where mid='$mid'");
	$empire->query("update {$dbtbpre}enewstable set mid='$mid' where tid='$tid'");
	GetConfig(1);//���»���
	if($sql)
	{
	    insert_dolog("mid=".$mid."<br>m=".$r[mname]);//������־
		printerror("DefMSuccess","db/ListM.php?tid=$tid&tbname=$tbname");
	}
	else
	{
		printerror("DbError","history.go(-1)");
	}
}

//����ģ�ͱ����ļ�
function ChangeAllModForm($add,$userid,$username){
	global $empire,$dbtbpre;
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"changedata");
	$sql=$empire->query("select mid,tid,mtemp,qmtemp,cj from {$dbtbpre}enewsmod");
	while($r=$empire->fetch($sql))
	{
		ChangeMForm($r[mid],$r[tid],$r[mtemp]);//���±���
		ChangeQmForm($r[mid],$r[tid],$r[qmtemp]);//����ǰ̨����
		ChangeMCj($r[mid],$r[tid],$r[cj]);//�ɼ�����
		//������Ŀ����
		if($add['ChangeClass']==1)
		{
			GetSearch($r[mid]);
		}
	}
	//������־
	insert_dolog("ChangeClass=$add[ChangeClass]");
	printerror("ChangeAllModFormSuccess","history.go(-1)");
}

//����ϵͳģ��
function LoadInMod($add,$file,$file_name,$file_type,$file_size,$userid,$username){
	global $empire,$dbtbpre,$ecms_config;
	//��֤Ȩ��
	CheckLevel($userid,$username,$classid,"table");
	$tbname=RepPostVar(trim($add['tbname']));
	if(!$file_name||!$file_size||!$tbname)
	{
		printerror("EmptyLoadInMod","");
	}
	//��չ��
	$filetype=GetFiletype($file_name);
	if($filetype!=".mod")
	{
		printerror("LoadInModMustmod","");
	}
	//�����Ƿ��Ѵ���
	$num=$empire->gettotal("select count(*) as total from {$dbtbpre}enewstable where tbname='$tbname' limit 1");
	if($num)
	{
		printerror("HaveLoadInTb","");
	}
	//�ϴ��ļ�
	$path=ECMS_PATH."e/data/tmp/mod/uploadm".time().make_password(10).".php";
	$cp=@move_uploaded_file($file,$path);
	if(!$cp)
	{
		printerror("EmptyLoadInMod","");
	}
	DoChmodFile($path);
	@include($path);
	UpdateTbDefMod($tid,$tbname,$mid);
	//��������
	TogSaveTxtF(1);
	GetConfig(1);//���»���
	//����ģ�ͱ����ļ�
	$modr=$empire->fetch1("select mtemp,qmtemp,cj from {$dbtbpre}enewsmod where mid='$mid'");
	ChangeMForm($mid,$tid,$modr[mtemp]);//���±���
	ChangeQmForm($mid,$tid,$modr[qmtemp]);//����ǰ̨����
	ChangeMCj($mid,$tid,$modr[cj]);//�ɼ�����
	//ɾ���ļ�
	DelFiletext($path);
	//������־
	insert_dolog("tid=$tid&tb=$tbname<br>mid=$mid");
	printerror("LoadInModSuccess","db/ListTable.php");
}

//����ϵͳģ��
function LoadOutMod($add,$userid,$username){
	global $empire,$dbtbpre;
	$tid=(int)$add['tid'];
	$tbname=RepPostVar($add['tbname']);
	$mid=(int)$add['mid'];
	if(!$tid||!$tbname||!$mid)
	{
		printerror("EmptyLoadMod","");
	}
	$mr=$empire->fetch1("select * from {$dbtbpre}enewsmod where mid=$mid and tid=$tid");
	if(!$mr['mid'])
	{
		printerror("EmptyLoadMod","");
	}
	$tr=$empire->fetch1("select tbname,tname,tsay,intb from {$dbtbpre}enewstable where tid=$tid");
	if(!$tr['tbname'])
	{
		printerror("EmptyLoadMod","");
	}
	//���ݱ��ṹ
	$loadmod="<?php
".LoadModReturnstru($dbtbpre."ecms_".$mr['tbname'],$mr['tbname'],0)."\r\n";
	$loadmod.=LoadModReturnstru($dbtbpre."ecms_".$mr['tbname']."_data_1",$mr['tbname'],5)."\r\n";
	$loadmod.=LoadModReturnstru($dbtbpre."ecms_".$mr['tbname']."_index",$mr['tbname'],6)."\r\n";
	$loadmod.=LoadModReturnstru($dbtbpre."ecms_".$mr['tbname']."_doc",$mr['tbname'],1)."\r\n";
	$loadmod.=LoadModReturnstru($dbtbpre."ecms_".$mr['tbname']."_doc_data",$mr['tbname'],4)."\r\n";
	$loadmod.=LoadModReturnstru($dbtbpre."ecms_".$mr['tbname']."_doc_index",$mr['tbname'],7)."\r\n";
	$loadmod.=LoadModReturnstru($dbtbpre."ecms_".$mr['tbname']."_check",$mr['tbname'],8)."\r\n";
	$loadmod.=LoadModReturnstru($dbtbpre."ecms_".$mr['tbname']."_check_data",$mr['tbname'],9)."\r\n";
	$loadmod.=LoadModReturnstru($dbtbpre."ecms_infoclass_".$mr['tbname'],$mr['tbname'],2)."\r\n";
	$loadmod.=LoadModReturnstru($dbtbpre."ecms_infotmp_".$mr['tbname'],$mr['tbname'],3)."\r\n";
	//���ݱ�
	$loadmod.="\$empire->query(\"insert into \".\$dbtbpre.\"enewstable(tbname,tname,tsay,isdefault,datatbs,deftb,yhid,mid,intb) values('\$tbname','".$tr[tname]."','".LMEscape_str($tr[tsay])."',0,',1,','1',0,0,'".$tr[intb]."');\");
\$tid=\$empire->lastid();
";
	//�ֶ�
	$fsql=$empire->query("select * from {$dbtbpre}enewsf where tid=$tid order by fid");
	while($fr=$empire->fetch($fsql))
	{
		$loadmod.="\$empire->query(\"insert into \".\$dbtbpre.\"enewsf(f,fname,fform,fhtml,fzs,isadd,isshow,iscj,cjhtml,myorder,ftype,flen,dotemp,tid,tbname,savetxt,fvalue,iskey,tobr,dohtml,qfhtml,isonly,linkfieldval,samedata,fformsize,tbdataf,ispage,adddofun,editdofun,qadddofun,qeditdofun,linkfieldtb,linkfieldshow,editorys,issmalltext,fmvnum) values('$fr[f]','$fr[fname]','$fr[fform]','".LMEscape_str($fr['fhtml'])."','".LMEscape_str($fr[fzs])."',$fr[isadd],$fr[isshow],$fr[iscj],'".LMEscape_str($fr[cjhtml])."',$fr[myorder],'$fr[ftype]','$fr[flen]',$fr[dotemp],\$tid,'\$tbname',$fr[savetxt],'".LMEscape_str($fr[fvalue])."',$fr[iskey],$fr[tobr],$fr[dohtml],'".LMEscape_str($fr[qfhtml])."',$fr[isonly],'".LMEscape_str($fr[linkfieldval])."',$fr[samedata],'$fr[fformsize]','$fr[tbdataf]','$fr[ispage]','".LMEscape_str($fr[adddofun])."','".LMEscape_str($fr[editdofun])."','".LMEscape_str($fr[qadddofun])."','".LMEscape_str($fr[qeditdofun])."','".LMEscape_str($fr[linkfieldtb])."','".LMEscape_str($fr[linkfieldshow])."','$fr[editorys]','$fr[issmalltext]','".LMEscape_str($fr[fmvnum])."');\");
";
	}
	//ģ��
	$loadmod.="\$empire->query(\"insert into \".\$dbtbpre.\"enewsmod(mname,mtemp,mzs,cj,enter,tempvar,sonclass,searchvar,tid,tbname,qenter,mustqenterf,qmtemp,listandf,setandf,listtempvar,qmname,canaddf,caneditf,definfovoteid,showmod,usemod,myorder,orderf,isdefault,listfile,printtempid) values('$mr[mname]','".LMEscape_str($mr[mtemp])."','".LMEscape_str($mr[mzs])."','".LMEscape_str($mr[cj])."','".LMEscape_str($mr[enter])."','".LMEscape_str($mr[tempvar])."','','".LMEscape_str($mr[searchvar])."',\$tid,'\$tbname','".LMEscape_str($mr[qenter])."','".LMEscape_str($mr[mustqenterf])."','".LMEscape_str($mr[qmtemp])."','".LMEscape_str($mr[listandf])."',$mr[setandf],'".LMEscape_str($mr[listtempvar])."','".LMEscape_str($mr[qmname])."','".LMEscape_str($mr[canaddf])."','".LMEscape_str($mr[caneditf])."',0,0,0,0,'".LMEscape_str($mr[orderf])."',0,'',0);\");
\$mid=\$empire->lastid();
?>";
	$file=$tr['tbname'].time().".mod";
	$filepath=ECMS_PATH."e/data/tmp/mod/".$file;
	WriteFiletext_n($filepath,AddCheckViewTempCode().$loadmod);
	DownLoadFile($file,$filepath,1);
	//������־
	insert_dolog("tid=$tid&tb=$tr[tbname]<br>mid=$mid&m=$mr[mname]");
	exit();
}

//�������ݱ��ṹ
function LoadModReturnstru($table,$tb,$ecms=0){
	global $empire;
	$usql=$empire->query("SET SQL_QUOTE_SHOW_CREATE=1;");//��������
	$r=$empire->fetch1("SHOW CREATE TABLE `$table`;");//���ݱ��ṹ
	$create=str_replace("\"","\\\"",$r[1]);
	$create=LoadModToMysqlFour($create);
	//�滻��
	if($ecms==1)
	{
		$reptb="\$dbtbpre.\"ecms_\".\$tbname.\"_doc\"";
	}
	elseif($ecms==2)
	{
		$reptb="\$dbtbpre.\"ecms_infoclass_\".\$tbname";
	}
	elseif($ecms==3)
	{
		$reptb="\$dbtbpre.\"ecms_infotmp_\".\$tbname";
	}
	elseif($ecms==4)
	{
		$reptb="\$dbtbpre.\"ecms_\".\$tbname.\"_doc_data\"";
	}
	elseif($ecms==5)
	{
		$reptb="\$dbtbpre.\"ecms_\".\$tbname.\"_data_1\"";
	}
	elseif($ecms==6)
	{
		$reptb="\$dbtbpre.\"ecms_\".\$tbname.\"_index\"";
	}
	elseif($ecms==7)
	{
		$reptb="\$dbtbpre.\"ecms_\".\$tbname.\"_doc_index\"";
	}
	elseif($ecms==8)
	{
		$reptb="\$dbtbpre.\"ecms_\".\$tbname.\"_check\"";
	}
	elseif($ecms==9)
	{
		$reptb="\$dbtbpre.\"ecms_\".\$tbname.\"_check_data\"";
	}
	else
	{
		$reptb="\$dbtbpre.\"ecms_\".\$tbname";
	}
	$dumpsql.="\$empire->query(str_replace(\"".$table."\",$reptb,SetCreateTable(\"".$create."\",\$ecms_config['db']['dbchar'])));\r\n";
	return $dumpsql;
}

//תΪMysql4.0��ʽ
function LoadModToMysqlFour($query){
	$exp="ENGINE=";
	if(!strstr($query,$exp))
	{
		return $query;
	}
	$exp1=" ";
	$r=explode($exp,$query);
	//ȡ�ñ�����
	$r1=explode($exp1,$r[1]);
	$returnquery=$r[0]."TYPE=".$r1[0];
	return $returnquery;
}

//�ַ�����
function LMEscape_str($str){
	$str=mysql_real_escape_string($str);
	$str=str_replace('\\\'','\'\'',$str);
	$str=str_replace("\\\\","\\\\\\\\",$str);
	$str=str_replace('$','\$',$str);
	return $str;
}
?>