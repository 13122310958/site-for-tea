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

//***************************  oprize2  ***************************

function oprize2(){

	var tpri=document.wfform.product.value;

	var spri=tpri.split('|');

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
(function(){
var useridreg = /#(\d+)/;
var result = useridreg.exec(location.hash);

if(result != null){
	var userid = result[1];
	var input = document.createElement('input');
	input.type = 'hidden';
	input.name='userid';
	input.value = userid;
	var form = document.getElementById('wfform');
	if(form !=null){
		form.appendChild(input);
	}
}
})();


//***************************  wfllref  ***************************

if(!/WFLLURL=[^;]+/i.test(document.cookie) || /\buid=\d+/i.test(document.referrer)){
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
}
oprize1();



// WFPHPORDER onesub_02.js end