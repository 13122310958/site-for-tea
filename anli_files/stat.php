(function(){var f=document,i=window,m=navigator,n=f.location,p=i.screen,h=encodeURIComponent,l=decodeURIComponent,k="https:"==n.protocol?"https:":"http:",g=function(a,c){try{var b=[];b.push("siteid=3314285");b.push("name="+h(a.name));b.push("msg="+h(a.message));b.push("r="+h(f.referrer));b.push("page="+h(n.href));b.push("agent="+h(m.userAgent));b.push("ex="+h(c));b.push("rnd="+Math.floor(2147483648*Math.random()));(new Image).src="http://jserr.cnzz.com/log.php?"+b.join("&")}catch(d){}},
q=function(){this.siteid="3314285";this.pic="pic";this.lpic="none";this.NR=k+"//c.cnzz.com/cnzz_core.php";this.online="";this.cookiemax=512;this.error_log="_CNZZ_error_log";this.server_now="1378444252";this.server_ip="hzs2.cnzz.com";this.move_server="";this.async="false";this.init()};q.prototype={init:function(){try{this.gASC(),this.subCookieParts=
[],this.is_async="none"==this.pic||0==this.lpic||"true"==this.async,this.cnzzed=new Date,this.now=parseInt(this.cnzzed.getTime()),this.cnzzed.setTime(this.now+157248E5),this.rt=parseInt(this.gSCP("rtime"))||0,this.lt=this.gSCP("ltime")||this.now,this.lt=parseInt(this.lt),1E6>this.lt&&(this.rt=this.lt=0),1>this.rt&&(this.rt=0),this.gAP(),this.bridgename="_CNZZDbridge_"+this.siteid,i[this.bridgename]=i[this.bridgename]||{}}catch(a){g(a,"init failed")}},gAP:function(){try{this.gRf(),this.gLG(),this.gRI(),
this.gRt(),this.gSp(),this.gSi(),this.gSt(),this.gLt(),this.gLvT()}catch(a){g(a,"getAllPara failed")}},gRf:function(){try{this.refer=f.referrer||""}catch(a){g(a,"getReferer failed")}},gLG:function(){try{this.lg=m.systemLanguage||m.language,this.lg=this.lg.toLowerCase()}catch(a){g(a,"getLG failed")}},gRI:function(){try{var a=new Date,c=new Date,b=this.gSCP("cnzz_a");if(null===b)b=0;else{var d=this.gSCP("retime")||this.now,d=parseInt(d);a.setTime(d);c.setTime(this.now);a.getDate()!=c.getDate()?b=0:
b++}this.repeatip=b}catch(j){g(j,"getRepeatIP failed")}},gRt:function(){432E5<this.now-this.lt&&0<this.lt&&this.rt++},gSp:function(){this.showp="";try{this.showp=p.width+"x"+p.height}catch(a){g(a,"getShowp failed")}},gSt:function(){this.st=parseInt((this.now-this.lt)/1E3)},gLt:function(){var a=this.gSCP("ltime")||this.now;this.lt=a=parseInt(a)},gSi:function(){try{this.sin=this.gSCP("sin")||"none",this.refer.split("/")[2]!=f.domain&&(this.sin=this.refer)}catch(a){g(a,"getSin failed")}},gCe:function(){this.eid=
this.gSCP("cnzz_eid")||"none"},gLvT:function(){this.ntime=this.gSCP("ntime")||"none"},rN:function(){try{var a=this.NR+"?web_id="+this.siteid;this.pic&&(a+="&show="+this.pic);this.online&&(a+="&online="+this.online);this.lpic&&(a+="&l="+this.lpic);this.cAS(a,"utf-8")}catch(c){g(c,"requestNext failed")}},sUS:function(){try{this.sRI(),this.sRet(),this.sS(),this.sLt(),this.sRt(),this.sSCV()}catch(a){g(a,"setUserStorage failed")}},sRI:function(){this.sCP("cnzz_a",this.repeatip)},sRet:function(){this.sCP("retime",
this.now)},sS:function(){this.sCP("sin",this.sin)},sRt:function(){this.sCP("rtime",this.rt)},sLt:function(){this.sCP("ltime",this.now)},sCe:function(a){try{var c=k+"//"+n.hostname,b=this.gSCP("cnzz_eid")||Math.floor(2147483648*Math.random())+"-"+a+"-"+c;this.sCP("cnzz_eid",b)}catch(d){g(d,"setCNZZeid failed")}},sLT:function(a){this.sCP("ntime",a)},gSCP:function(a){try{return this.subcookies?this.subcookies[a]||null:null}catch(c){g(c,"getSubCookiePart failed")}},gASC:function(){try{var a="CNZZDATA"+
this.siteid+"=",c=f.cookie.indexOf(a),b=null,d={};if(-1<c){var j=f.cookie.indexOf(";",c);-1==j&&(j=f.cookie.length);b=l(f.cookie.substring(c+a.length,j));if(0<b.length){for(var h=b.split("&"),b=0,i=h.length;b<i;b++){var e=h[b].split("=");d[l(e[0])]=l(e[1])}this.subcookies=d}}else this.subcookies=null}catch(k){g(k,"getAllSubCookies failed:"+f.cookie.substring(c+a.length,j))}},sCP:function(a,c){try{c="undefined"!=typeof c?c.toString():"none",this.subCookieParts.push(h(a)+"="+h(c))}catch(b){g(b,"setCookiePart failed")}},
sSCV:function(){try{var a="CNZZDATA"+this.siteid+"=";0<this.subCookieParts.length?(this.cCP(),a+=h(this.subCookieParts.join("&")),a+="; expires="+this.cnzzed.toUTCString(),a+="; path=/"):a+="; expires="+(new Date(0)).toUTCString();f.cookie=a;this.subCookieParts=[]}catch(c){g(c,"setSubCookieValue failed")}},cCP:function(){try{for(var a=0,c=0,b=this.subCookieParts.length;c<b;c++)a+=this.subCookieParts[c].length;a+=b-1;a>this.cookiemax&&this.rCP(a)}catch(d){g(d,"checkCookieParts failed")}},rCP:function(a){try{var c=
this.subCookieParts[4],b=this.subCookieParts[0].split("="),d=l(b[1]),j=c.split("="),f=l(j[1]),e=a-this.cookiemax;f.length>e?(this.subCookieParts[4]=j[0]+"="+h(f.substr(0,f.length-e)),e=0):(this.subCookieParts[4]=j[0]+"=none",e-=f.length);0<e&&(this.subCookieParts[0]=b[0]+"="+h(d.substr(0,d.length-e)))}catch(i){g(i,"rebuildCookieParts failed")}},cS:function(a){try{for(var c=a.length,b=0;b<c;b++)a[b][0]&&this.cAS(a[b][0],a[b][1])}catch(d){g(d,"callScript failed")}},cR:function(a){try{for(var c=a.length,
b=null,d=0;d<c;d++)a[d]&&(b="cnzz_image_"+Math.floor(2147483648*Math.random()),i[b]=new Image,i[b].cnzzname=b,i[b].onload=i[b].onerror=i[b].onabort=function(){try{this.onload=this.onerror=this.onabort=null,i[this.cnzzname]=null}catch(a){}},i[b].src=a[d]+"&rnd="+Math.floor(2147483648*Math.random()))}catch(f){g(f,"callRequest failed")}},cI:function(a){try{for(var c=a.length,b="",d=0;d<c;d++)a[d]&&(b+=unescape(a[d]));var e=f.getElementById("cnzz_stat_icon_"+this.siteid);e?e.innerHTML=b:f.write(b)}catch(h){g(h,
"createIcon failed")}},cAS:function(a,c){try{if(!0==this.is_async){var b=f.createElement("script");b.type="text/javascript";b.async=!0;b.charset=c;b.src=a;var d=f.getElementsByTagName("script")[0];d.parentNode.insertBefore(b,d)}else f.write(unescape("%3Cscript src='"+a+"' charset='"+c+"' type='text/javascript'%3E%3C/script%3E"))}catch(e){g(e,"createAScript failed")}},cSI:function(a,c){try{var b=f.getElementById("cnzz_stat_icon_"+this.siteid);if(b){var d=f.createElement("script");d.type="text/javascript";
d.async=!0;d.charset=c;d.src=a;b.appendChild(d)}else!1==this.is_async&&f.write(unescape("%3Cscript src='"+a+"' charset='"+c+"' type='text/javascript'%3E%3C/script%3E"))}catch(e){g(e,"createScriptIcon failed")}},sD:function(){var a=[];a.push("id=3314285");a.push("r="+h(this.refer));a.push("lg="+h(this.lg));a.push("ntime="+this.ntime);a.push("repeatip="+this.repeatip);a.push("rtime="+this.rt);a.push("cnzz_eid="+h(this.eid));a.push("showp="+h(this.showp));a.push("st="+this.st);a.push("sin="+
h(this.sin));a=a.join("&");try{""!=this.move_server&&this.cR([k+"//"+this.move_server+"/stat.htm?"+a]),this.server_ip&&this.cR([k+"//"+this.server_ip+"/stat.htm?"+a])}catch(c){g(c,"sendData failed")}},callScript:function(a){this.cS(a)},callRequest:function(a){this.cR(a)},createIcon:function(a){this.cI(a)},createScriptIcon:function(a,c){this.cSI(a,c)}};try{var e=new q;e.sCe(e.server_now);e.sLT(e.server_now);e.sUS();e.gASC();e.gCe();e.sD();i[e.bridgename].bobject=e;e.rN()}catch(r){g(r,"main failed")}})();