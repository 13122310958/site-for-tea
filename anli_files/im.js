var stop = false;
var CloseType = 1;
var NextInviteTime = 500000;
//关闭浮动框

//设置模式
function setCloseType(type) {
    CloseType = type;
}
//设置弹框间隔时间
function setNextInviteTime(time) {
    NextInviteTime = time;
}

//关闭邀请框
function closeinvite() {
    document.getElementById("invite").style.display = "none";
    if (CloseType == 1) {
        //不再弹邀请框
        return;
    } else if (CloseType == 2) {
        //5秒后再次弹出邀请框
        window.setTimeout("ShowInvite()", NextInviteTime);
    }
}
//浮动框和邀请框的平滑移动

lastScrollY = 0;
function heartBeat() {
    if (!stop) {
        var diffY;
        if (document.documentElement && document.documentElement.scrollTop)
            diffY = document.documentElement.scrollTop;
        else if (document.body)
            diffY = document.body.scrollTop
        else
        { /*Netscape stuff*/ }
        percent = .1 * (diffY - lastScrollY);
        if (percent > 0) percent = Math.ceil(percent);
        else percent = Math.floor(percent);
        try {
            document.getElementById("invite").style.top = parseInt(document.getElementById("invite").style.top) + percent + "px";
        } catch (e) {stop = true; }
        lastScrollY = lastScrollY + percent;
    }
}
//显示邀请框
function ShowInvite() {
    if (CloseType == 2) {
        document.getElementById("invite").style.display = "block";
    }
}
//取得上级网页地址
function GetReferrerX() {
    var tempReferrer = "";
    try {
        tempReferrer = SetDataX(document.referrer, tempReferrer);
        tempReferrer = SetDataX(top.document.referrer, tempReferrer);
        tempReferrer = SetDataX(window.parent.document.referrer, tempReferrer);
    } catch (e) {
    }
    return tempReferrer;
}

function SetDataX(dataSource, data) {
    tempdata = data;
    try {
        if (dataSource && dataSource != '') {
            if (tempdata == '')
                tempdata = dataSource;
        }
    }
    catch (e) { }
    return tempdata;
}
//取得当前页面地址
function InitURLX() {
    var uri = "";
    try {
        uri = SetDataX(document.URL, uri);
        uri = SetDataX(window.location, uri);
        uri = SetDataX(window.parent.location, uri);
    } catch (e) {
    }
    return uri;
}
//取得网页标题
function InitTitleX() {
    var docTitle = document.title;
    try {
        if (typeof docTitle == 'undefined' || docTitle == null || docTitle == '') {
            var t_titles = document.getElementsByTagName("title");
            if (typeof t_titles != 'undefined' && t_titles && t_titles.length > 0) {
                docTitle = t_titles[0].innerText;
            } else {
                docTitle = "";
            }
        }
    } catch (e) { }
    return docTitle;
}



//打开商务通并更新访客的isIM变量
var chatWindow;
function OpenIM() {
    var tmpCarID = "errorID";
    var tmpCookieID = "errorCookieID";
    if (typeof CarID != "undefined" && CarID != null && CarID != '') {
        tmpCarID = CarID;
    }
    if (typeof cgid != "undefined" && cgid != null && cgid != '') {
        tmpCookieID = cgid;
    }

    var zooUrlII = "http://lr2.lvshou.net/LR/Chatpre.aspx?id=PDG31671888";
    var zooUrl = "http://d2.lvshou.net/LR/Chatpre.aspx?id=LXA91520613";
    var rnd = Math.round((Math.random() * 9 + 1)); //产生一个1-10的随机数
    if (rnd > 5) zooUrl = zooUrlII;
    var IMUrl = GetIMUrl();
    if (typeof IMUrl != "undefined" && IMUrl != null && IMUrl != '') {
        zooUrl = IMUrl;
    }

    if (zooUrl == "javascript:void(0)") {
        return;
    }

    var xHistoryZooUrl = "";
    if (typeof HistoryZoosNetURL != "undefined" && HistoryZoosNetURL != null) {
        xHistoryZooUrl = HistoryZoosNetURL;
    }
    else {
        xHistoryZooUrl = GetCookie("SaveImURL");
    }

    //如果历史记录的商务通站点为空，则再存一次
    if (GetCookie("SaveImURL") == "") {
        var tempDate = new Date();
        tempDate.setDate(tempDate.getDate() + 30);
        SetCookie("SaveImURL", zooUrl, tempDate);
    }

    var xSourceRefer = "";
    xSourceRefer = GetCookie("SaveSourceRefer");

    var xSourceTime = "";
    xSourceTime = GetCookie("SaveSourceTime");

    var xTitle = document.title.substring(0, 20);
    xTitle = xTitle.split("-")[0];
    var openURL = zooUrl + "&e=" + escape(InitURLX()) + "|title:" + escape(xTitle) + "CarID" + tmpCarID + "&r=" + escape(GetReferrerX()) + "&p=" + escape(InitURLX()) + "|title:" + escape(xTitle) + "CarID" + tmpCarID;
    var exParas = "height=455, width=630, toolbar=no, menubar=no, scrollbars=no, resizable=yes,location=no, status=no";
    chatWindow = window.open(openURL, "chatWindow", exParas);
    setCloseType(1);
    closeinvite();
    tmpCarID = null;
    if (typeof OnIM != 'undefined') {
        OnIM();
    }
    CheckChatWindow();
}
//检测商务通对话窗口是否被关闭
function CheckChatWindow() {

    if (chatWindow.closed == true) {
        setCloseType(2);
        window.setTimeout("ShowInvite()", NextInviteTime);
    }
    else {
        setTimeout("CheckChatWindow()", 5000);
    }
}
//动态获取商务通站点URL
function GetIMUrl() {
    var zooUrlII = "http://lr2.lvshou.net/LR/Chatpre.aspx?id=PDG31671888";
    var zooUrl = "http://d2.lvshou.net/LR/Chatpre.aspx?id=LXA91520613";
    var rnd = Math.round((Math.random() * 9 + 1)); //产生一个1-10的随机数
    if (rnd > 5) zooUrl = zooUrlII;
    if (GetCookie("SaveImURL") != "") {
        zooUrl = GetCookie("SaveImURL");
    }
    var url = "http://www.lvshou.com/Services/WebService.asmx/GetIMUrl";

    if (typeof WebSite != "undefined" && WebSite != null) {
        url = WebSite + "Services/WebService.asmx/GetIMUrl";
    }
    var result = "";
    //debugger;
    $.ajax({
        url: url,
        type: "Post",
        data: "{}",
        contentType: "Application/json; Charset=UTF-8",
        dataType: "json",
        async: false,
        success: function (data) {
            result = data.d.toString();
            if (typeof result != "undefined" && result != "") {
                zooUrl = result;
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            //            alert(XMLHttpRequest.status);
            //            alert(XMLHttpRequest.readyState);
            //            alert(textStatus);
            //            alert(errorThrown);
        }
    });
    return zooUrl;
}