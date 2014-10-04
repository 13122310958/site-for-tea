<?php
define('EmpireCMSAdmin','1');
require("../class/connect.php");
require("../class/db_sql.php");
require("../class/functions.php");
require LoadLang("pub/fun.php");
require("../class/t_functions.php");
require("../data/dbcache/class.php");
require("../data/dbcache/MemberLevel.php");
$link=db_connect();
$empire=new mysqlquery();
//��֤�û�
$lur=is_login();
$logininid=$lur['userid'];
$loginin=$lur['username'];
$loginrnd=$lur['rnd'];
$loginlevel=$lur['groupid'];
$loginadminstyleid=$lur['adminstyleid'];

@set_time_limit(0);

//��֤�Ƿ�ִ��
function CheckDoTask($r){
	global $logininid;
	if($r['userid']&&$r['userid']!=$logininid)//ִ���û�
	{
		return false;
	}
	$time=time();
	$date=date("j,w,G,i,Y,m");
	$dr=explode(',',$date);
	if(','.$r['doday'].','!=',*,'&&$r['doday']!=$dr[0])//����
	{
		return false;
	}
	if(','.$r['doweek'].','!=',*,'&&$r['doweek']!=$dr[1])//����
	{
		return false;
	}
	if(','.$r['dohour'].','!=',*,'&&$r['dohour']!=$dr[2])//Сʱ
	{
		return false;
	}
	$min=(int)$dr[3];
	if($r['dominute']!=''&&$r['dominute']!=','&&!strstr($r['dominute'],','.$min.','))//����
	{
		return false;
	}
	if($r['lastdo'])
	{
		if(!TogTaskTime($r,$dr))
		{
			return false;
		}
	}
	return $time;
}

//��֤ʱ��
function TogTaskTime($r,$dr){
	$re['chdate']=$dr[4].'-'.$dr[5].'-';
	$re['date']='Y-m-';
	if($r['doday'])
	{
		$re['chdate'].='-'.$dr[0];
		$re['date'].='-j';
	}
	if($r['doweek'])
	{
		$re['chdate'].='-'.$dr[1];
		$re['date'].='-w';
	}
	if($r['dohour'])
	{
		$re['chdate'].='-'.$dr[2];
		$re['date'].='-G';
	}
	if($r['dominute'])
	{
		$re['chdate'].='-'.$dr[3];
		$re['date'].='-i';
	}
	if(date($re['date'],$r['lastdo'])==$re['chdate'])
	{
		return false;
	}
	return true;
}

$retasktime=20;

$tasksql="select id,filename,lastdo,doweek,doday,dohour,dominute,userid,taskname from {$dbtbpre}enewstask where isopen=1 and (userid=0 or (userid<>0 and userid='$logininid'))";

$ecms=$_GET['ecms'];

echo"<title>ִ�мƻ�����</title><link href='adminstyle/".$loginadminstyleid."/adminstyle.css' rel='stylesheet' type='text/css'>";

//ִ��
if($ecms=='dotask')
{
	$id=(int)$_GET['id'];
	if(empty($id))
	{
		exit();
	}
	$r=$empire->fetch1("select id,filename,lastdo,doweek,doday,dohour,dominute,userid,taskname from {$dbtbpre}enewstask where id=$id and isopen=1 limit 1");
	$file='../tasks/'.$r['filename'];
	if(empty($r['id'])||empty($r['filename'])||!file_exists($file))
	{
		exit();
	}
	$lasttime=CheckDoTask($r);
	if($lasttime)
	{
		echo"<script>parent.WriteTaskLog('���� <".$r['taskname']."> ��ʼִ��......');</script>";
		require_once($file);
		$usql=$empire->query("update {$dbtbpre}enewstask set lastdo='$lasttime' where id=$id");
		echo"<script>parent.WriteTaskLog('���� <".$r['taskname']."> ִ����ϣ����ִ��ʱ�䣺".date("Y-m-d H:i:s",$lasttime)."');</script>";
	}
}
//����
elseif($ecms=='retask')
{
	echo"<meta http-equiv=\"refresh\" content=\"".$retasktime.";url=task.php?ecms=retask\">";
	?>
	<script>
	function AddTaskDiv(divid,taskid){
		if(parent.document.getElementById(divid)!=null)
		{
			eval("parent."+divid+".location.href='task.php?ecms=dotask&id="+taskid+"';");
		}
		else
		{
			parent.document.getElementById("alltaskdiv").innerHTML+="<div id='"+divid+"'><iframe frameborder='0' id='"+divid+"' scrolling='no' src='task.php?ecms=dotask&id="+taskid+"' style='HEIGHT:0;VISIBILITY:inherit;WIDTH:0;Z-INDEX:1'></iframe></div>";
		}
	}
	</script>
	<script>
	<?php
	$sql=$empire->query($tasksql);
	while($r=$empire->fetch($sql))
	{
		if(CheckDoTask($r))
		{
			echo"AddTaskDiv('taskdiv".$r['id']."','".$r['id']."');";
		}
	}
	?>
	</script>
	<?php
}
//����
elseif($ecms=='TodoTask')
{
	$id=(int)$_GET['id'];
	if(empty($id))
	{
		exit();
	}
	//��֤Ȩ��
	CheckLevel($logininid,$loginin,$classid,"task");
	$r=$empire->fetch1("select id,filename,taskname from {$dbtbpre}enewstask where id=$id limit 1");
	$file='../tasks/'.$r['filename'];
	if($r['id']&&$r['filename']&&file_exists($file))
	{
		require_once($file);
		$enews=$ecms;
		//������־
		insert_dolog("id=$id&taskname=$r[taskname]&filename=$r[filename]");
	}
	printerror('TodoTaskSuccess','');
}
else
{
	?>
	<script>
		function WriteTaskLog(str){
			document.tasklogform.tasklog.value="  "+str+"\r\n"+document.tasklogform.tasklog.value;
		}
		function ClearTaskLog(){
			document.tasklogform.tasklog.value="";
		}
	</script>
	<IFRAME frameBorder="0" id="retaskfile" name="retaskfile" scrolling="no" src="task.php?ecms=retask" style="HEIGHT:0;VISIBILITY:inherit;WIDTH:0;Z-INDEX:1"></IFRAME>
	<table width='100%' border=0 align=center cellpadding=3 cellspacing=1 class='tableborder'>
		<form name="tasklogform" method="post">
		<tr class=header><td>������־&nbsp;&nbsp;&nbsp;[<a href="#ecms" onclick="ClearTaskLog();">�����־����</a>]</td></tr>
		<tr><td bgcolor='#ffffff'>
			<textarea name="tasklog" cols="80" rows="30" id="tasklog" style="width:100%">  �ƻ�����ʼ����ʱ�䣺<?=date("Y-m-d H:i:s")?></textarea>
		</td></tr>
		</form>
	</table>
	<div id="alltaskdiv">
	</div>
	<?php
}
db_close();
$empire=null;
?>