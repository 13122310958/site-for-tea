var slist = document.getElementsByTagName('script');
var scElement = slist[slist.length-1];
var userid = scElement.getAttribute('uid');
if(!userid) userid = '';
document.writeln('<iframe id="wforder" src="/wforder/template/dd_06.html#'+userid+'" width="100%" marginheight="0" marginwidth="0" frameborder="0" scrolling="no" height="545"></iframe>');
