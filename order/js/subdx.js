/**
 *******************************************************************
 ************* ─────────────────── **************
 ************* ──  WFPHP在线订单系统官方正式版 ── **************
 ************* ─────────────────── **************
 ************* 官方网站：http://www.wf1805.cn/        **************
 ************* 官方店铺：http://889889.taobao.com/    **************
 ************* 程序开发：WENFEI                       **************
 ************* 客户服务：[淘宝旺旺] yygynui613        **************
 ************* 技术支持：[腾讯QQ] 183712356           **************
 *******************************************************************
 *************   官方正版 *** 版权所有 *** 盗版必究   **************
 *******************************************************************
 */

window.onerror = function(){return true;} 
//***************************  oprize1  ***************************
function oprize1(){
	var product = document.wfform.product.value;
	for(var i=0;i<document.wfform.product.length;i++){
		if(document.wfform.product[i].checked==true){
			product = document.wfform.product[i].value;
			break;
		}
	}
	var spri=product.split('|');
	var pri=spri[1];
	if(document.wfform.cpmun.value=="" || document.wfform.cpmun.value==0){	
		var tmun=1;
	}
	else{
		var tmun=document.wfform.cpmun.value;
	}	
	var prit=pri*tmun;
	document.wfform.price.value=prit;
	document.getElementById("showprit").innerHTML=prit;
}

//***************************  diqu  ***************************
new PCAS("province","city","area");
function diqu(){
	wfform.address.value=wfform.province.value+wfform.city.value+wfform.area.value;
}

//***************************  paytype  ***************************
function changeItem(i){
    var k = 3;
	for(var j = 0;j < k;j++){
	    if(j == i){
		    document.getElementById("paydiv" + j).style.display = "block";
		}
		else{		
		    document.getElementById("paydiv" + j).style.display = "none";
		}
	}
}

//***************************  paytype  ***************************
function opay(){
	document.getElementById("wfform").target="_parent";
}
function opay2(){
    document.getElementById("wfform").target="_blank";
}

//***************************  wfllref  ***************************
var wfllref = '';
if (document.referrer.length > 0){
	wfllref = document.referrer;
}
try{
	if (wfllref.length == 0 && opener.location.href.length > 0){
    wfllref = opener.location.href;
	}
}
catch (e){}
document.cookie="WFLLURL=" + wfllref + ";path=/";
oprize1();

// WFPHPORDER onesub_01.js end