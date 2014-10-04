﻿function postcheck(){
	if (document.wfform.dgname.value==""){
	    alert('请填写姓名！');
		document.wfform.dgname.focus();
		return false;
	}
	var reg1 = /^[\u4e00-\u9fa5]{2,4}$/;
	if (!reg1.test(document.wfform.dgname.value)){
	    alert('姓名格式不正确，请填写真实姓名！');
		document.wfform.dgname.focus();
		return false;
	}
	if (document.wfform.mob.value==""){
		alert('请填写手机号码！');
		document.wfform.mob.focus();
		return false;
	}
	var reg2 = /^1[3,4,5,8]\d{9}$/;
	if (!reg2.test(document.wfform.mob.value)){
	    alert('手机号码格式不正确，请填写正确的手机号码！');
		document.wfform.mob.focus();
		return false;
	}
	if (document.wfform.address.value==""){
		alert('请填写详细地址！');
		document.wfform.address.focus();
		return false;
	}
	
	document.wfform.wfsubmit.disabled=true;	
	return true;	
}

var box  = (function(){
	var list = document.getElementsByTagName('script');
	return list[list.length-1].parentNode;
})();
/*
var iframe = document.createElement('iframe');
iframe.frameborder=0;
iframe.width = 0;
iframe.height = 0;
iframe.style.visibility = 'hidden';
iframe.onload = function(){
	box.innerHTML = (this.contentWindow.document.body.innerHTML);
}
iframe.src = 'xiadan.html';
box.appendChild(iframe);
*/
var xmlHttp=null;
try {
// Firefox, Opera 8.0+, Safari
xmlHttp=new XMLHttpRequest();
}
catch (e)
{
// Internet Explorer
try {
xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
}
catch (e) {
xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
}
}
xmlHttp.onreadystatechange = function(){
	if(xmlHttp.readyState == 4 && xmlHttp.status == 200){
		box.innerHTML = xmlHttp.responseText;
	}
}
xmlHttp.open('get','dd-html.js');
xmlHttp.send(null);
