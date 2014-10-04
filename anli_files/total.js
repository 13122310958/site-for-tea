$(document).ready(function () {

    //top_car///////////////////////////
    $('#cart_t').mousemove(function () {
        $('.lv_cart').css({ 'border-bottom': 'none' });
        $('#cart').slideDown(320);
    });
    $('#cart_t').mouseleave(function () {
        $('#cart').slideUp(200);
        $('.lv_cart').css({ 'border-bottom': '1px solid #b4dae6' });
    });
    //nav///////////////////////////////////
    $('.mainlevel').hover(function () {
        $(this).find('a:first').css({ background: '#fff', color: '#199400' });
        $(this).find('ul').stop(true, true).slideDown(320);
    }, function () {
        $(this).find('a:first').css({ background: 'none', color: '#fff' });
        $(this).find('ul').stop(true, true).slideUp(200);
    });
    $(".mainlevel li a").hover(function () {
        $(this).stop().animate({ marginLeft: "8px" }, 300);
    }, function () {
        $(this).stop().animate({ marginLeft: "0px" }, 300);
    });
    //jfnav///////////////////////////////////

    $('.jf_ce').hover(function () {
        $(this).find('a:first').css({ background: 'url(../images/jifen_08.jpg) no-repeat left #fff', color: '#E2144A', border: '1px solid #4ab809' });
        $(this).find('ul').stop(true, true).slideDown(320);
    }, function () {
        $(this).find('a:first').css({ background: 'url(../images/jifen_08.jpg) no-repeat left #fff', color: '#000', border: '0' });
        $(this).find('ul').stop(true, true).slideUp(200);
    });
    //abc/////////////////////////////////////
    $('.abc').hover(function () {
        $(this).find('a:first').css({ background: 'url(http://images.lvshou.com/nav_06.gif) no-repeat', color: '#000' });
        $(this).find('ul').stop(true, true).slideDown(320);
    }, function () {
        $(this).find('a:first').css({ background: 'none', color: '#fff' });
        $(this).find('ul').stop(true, true).slideUp(200);
    });
    $(".abc li a").hover(function () {
        $(this).stop().animate({ marginLeft: "13px" }, 300);
    }, function () {
        $(this).stop().animate({ marginLeft: "5px" }, 300);
    });
    //menu///////////////////////////////////
    $('.menu1,.menu1_div').hover(function () { $('.menu1_div').stop(true, true).slideDown(300); }, function () { $('.menu1_div').stop(true, true).slideUp(100); })
    $('.menu2,.menu2_div').hover(function () { $('.index_menu ul').addClass('menu_2'); $('.menu2_div').stop(true, true).slideDown(300) }, function () { $('.index_menu ul').removeClass('menu_2'); $('.menu2_div').slideUp(100); })
    $('.menu3,.menu3_div').hover(function () { $('.index_menu ul').addClass('menu_3'); $('.menu3_div').stop(true, true).slideDown(300) }, function () { $('.index_menu ul').removeClass('menu_3'); $('.menu3_div').slideUp(100); })
    $('.menu4,.menu4_div').hover(function () { $('.index_menu ul').addClass('menu_4'); $('.menu4_div').stop(true, true).slideDown(300) }, function () { $('.index_menu ul').removeClass('menu_4'); $('.menu4_div').slideUp(100); })
    $('.menu5,.menu5_div').hover(function () { $('.index_menu ul').addClass('menu_5'); $('.menu5_div').stop(true, true).slideDown(300) }, function () { $('.index_menu ul').removeClass('menu_5'); $('.menu5_div').slideUp(100); })
    //web_bank ////////////////////////////
    $("#web_bank li s").hover(function () { $(this).css({ 'border-color': '#2b9e05' }) }, function () { $(this).css({ 'border-color': '#ccc' }); $("#web_bank input:checked").next().css({ 'border-color': '#ff6600' }); });
    $("#web_bank input:checked").next().css({ 'border-color': '#ff6600' });
    $("#web_bank li").click(function () { $('#web_bank li').find('s').css({ 'border-color': '#ccc' }); $(this).find('input').attr("checked", true); $(this).find('s').css({ 'border-color': '#ff6600' }) });
    //xin_bank ///////////////////////
    $("#xin_bank li s").hover(function () { $(this).css({ 'border-color': '#2b9e05' }) }, function () { $(this).css({ 'border-color': '#ccc' }); $("#xin_bank input:checked").next().css({ 'border-color': '#ff6600' }); });
    $("#xin_bank input:checked").next().css({ 'border-color': '#ff6600' });
    $("#xin_bank li").click(function () { $('#xin_bank li').find('s').css({ 'border-color': '#ccc' }); $(this).find('input').attr("checked", true); $(this).find('s').css({ 'border-color': '#ff6600' }) });
    //foot_menu 2012-01-09///////////////////////////
    var navCookie = getCookie('navFix');
    if (navCookie) {
        $('.au_bzhu').stop().css('height', '170px');
        $('.au_bzhu').unbind();
    } else {
        $('.au_bzhu').stop().css('height', '22px');
        navAnimate();
    }

    function navAnimate() {
        $('.au_bzhu').hover(
		function () {
		    $(this).stop().animate({ height: '170px' }, "fast");
		},
		function () {
		    $(this).stop().animate({ height: '22px' }, "fast");
		});
    }

    function getCookie(Name) {
        var re = new RegExp(Name + "=[^;]+", "i");
        if (document.cookie.match(re))
            return document.cookie.match(re)[0].split("=")[1]
        return null
    }
});
//设置头导航样式
function SetHeadULClass() {
    var curUrl = window.location.toString();
    $("#ul_lvs_nav li:eq(0)").removeClass("cur");
    if (curUrl.indexOf("/zhuangpin") >= 0) {
        $("#ul_lvs_nav li:eq(2)").addClass("cur");
        return;
    }
    else if (curUrl.indexOf("/baojian") >= 0) {
        $("#ul_lvs_nav li:eq(3)").addClass("cur");
        return;
    }
    else if (curUrl.indexOf("/shoushen") >= 0) {
        $("#ul_lvs_nav li:eq(1)").addClass("cur");
        return;
    }
    else if (curUrl.indexOf("product/searchjfm") >= 0) {
        $("#ul_lvs_nav li:eq(2)").addClass("cur");
        return;
    }
    else if (curUrl.indexOf("product/searchjkm") >= 0) {
        $("#ul_lvs_nav li:eq(3)").addClass("cur");
        return;
    }
    else if (curUrl.indexOf("product/search") >= 0) {
        $("#ul_lvs_nav li:eq(1)").addClass("cur");
        return;
    }
    else if (curUrl.indexOf("brank") >= 0) {
        $("#ul_lvs_nav li:eq(4)").addClass("cur");
        return;
    }
    else if (curUrl.indexOf("article") >= 0) {
        $("#ul_lvs_nav li:eq(5)").addClass("cur");
        return;
    }
    else if (curUrl.indexOf("jifen") >= 0) {
        $("#ul_lvs_nav li:eq(6)").addClass("cur");
        return;
    }
    else {
        $("#ul_lvs_nav li:eq(0)").addClass("cur");
        return;
    }
}
//读取浏览的历史产品记录
function LoadHistoryProductInfo() {
    SetHeadULClass();
    var tmpHistory = "";
    var userHistoryProductInfo = "";
    try {
        if (GetCookie("HistoryProductInfo") != "") {
            tmpHistory = GetCookie("HistoryProductInfo");
            var productsArray = new Array();
            productsArray = tmpHistory.split(",");
            if (productsArray.length > 0) {
                for (var i = 0; i < productsArray.length; i++) {
                    if (i > 4) continue; //只取前5个记录
                    var tmpProduct = new Array();
                    tmpProduct = productsArray[i].split("|");
                    if (tmpProduct.length > 4) {
                        userHistoryProductInfo += " <li class='item'><div class=\"wrap\"><div class='thumb'>";
                        userHistoryProductInfo += " <a  href=\"" + tmpProduct[3] + "\" target=\"_blank\" title='" + tmpProduct[1] + "'>";
                        userHistoryProductInfo += "<img src=\"" + tmpProduct[4] + "\" width=\"68\" height=\"59\" /></a></div>";
                        userHistoryProductInfo += "<div class='des'><h5 class='summary'><a href=\"" + tmpProduct[3] + "\" target=\"_blank\" title='" + tmpProduct[1] + "'>" + tmpProduct[1] + "</a></h5>";
                        userHistoryProductInfo += "<p class='price'>绿瘦价：￥" + tmpProduct[2] + "</p><a href='" + tmpProduct[3] + "' class='btn-a'><span>立即订购>>></span></a>";
                        userHistoryProductInfo += "</div></div></li>";
                    }
                }
                $("#lvmod03_list3").html(userHistoryProductInfo);
            }
        }
    }
    catch (e) { }
}

//new读取浏览的历史产品记录
function newLoadHistoryProductInfo() {
    SetHeadULClass();
    var tmpHistory = "";
    var userHistoryProductInfo = "";
    try {
        if (GetCookie("HistoryProductInfo") != "") {
            tmpHistory = GetCookie("HistoryProductInfo");
            var productsArray = new Array();
            productsArray = tmpHistory.split(",");
            if (productsArray.length > 0) {
                for (var i = 0; i < productsArray.length; i++) {
                    if (i > 4) continue; //只取前5个记录
                    var tmpProduct = new Array();
                    tmpProduct = productsArray[i].split("|");
                    if (tmpProduct.length > 4) {
                        userHistoryProductInfo += "<li class=\"clearfix\">";
                        userHistoryProductInfo += "<a class=\"npic\" target=\"_blank\" href=\"" + tmpProduct[3] + "\" title=\"" + tmpProduct[1] + "\"><img src=\"" + tmpProduct[4] + "\" alt=\"" + tmpProduct[1] + "\"></a>";
                        userHistoryProductInfo += "<div class=\"ninfo\">";
                        userHistoryProductInfo += "<p><a target=\"_blank\" href=\"" + tmpProduct[3] + "\" title=\"" + tmpProduct[1] + "\">" + tmpProduct[1] + "</a></p>";
                        userHistoryProductInfo += "<p class=\"cgray\">￥" + tmpProduct[2] + "</p></div></li>";
                    }
                }
                $("#lvmod03_list3").html(userHistoryProductInfo);
            }
        }
    }
    catch (e) { }
}

//allpage
function ShowDiv(objid) {
    if (objid != "divWeiBoSina" && objid != "divWeiBoQQ") {
        $('#' + objid).show();
        $('#' + objid).css("visibility", "visible");
    }
    if (objid == "divBuWei" || objid == "divFangShi") {
        document.getElementById(objid + "Li").className = "item hov";
    }
    if (objid == "divPingPai") {
        document.getElementById(objid + "Li").className = "item last hov";
    }
    if (objid == "divWeiBoSina") {

        document.getElementById(objid).className = "con show";
        document.getElementById('divWeiBoQQ').className = "con";
        document.getElementById(objid + "Li").className = "sina cur";
        document.getElementById('divWeiBoQQLi').className = "tencent";
        document.getElementById('divWeiBoTab').className = "tabs";
    }
    if (objid == "divWeiBoQQ") {
        document.getElementById(objid).className = "con show";
        document.getElementById('divWeiBoSina').className = "con";
        document.getElementById(objid + "Li").className = "tencent cur";
        document.getElementById('divWeiBoSinaLi').className = "sina";
        document.getElementById('divWeiBoTab').className = "tabs tabed";
    }
    //SetCookie("tmp"+objid,1);
}
function LoadLazyImg() {
    $("#slide").trigger("scroll");
    $("#pageflip").trigger("scroll");
}
function ChangeDivCss(p) {
    LoadLazyImg();
    var ls = document.getElementById("top-sale-ul").getElementsByTagName("li");
    for (var i = 0; i < ls.length; i++) {
        var tmpCN = ls[i].className.split(" ");
        if (i == p) {
            ls[i].className = tmpCN[0] + " show";
        } else {
            ls[i].className = tmpCN[0];
        }
    }
    LoadLazyImg();
}
function ChangeDivCss2(p) {
    LoadLazyImg();
    var ls = document.getElementById("puzzle-item").getElementsByTagName("div");

    for (var i = 0; i < (ls.length / 2); i++) {
        if (i == p || p == -1) {
            $("#puzzle-item-" + i).hide();
        } else {
            $("#puzzle-item-" + i).css("display", "block");
        }
    }
    LoadLazyImg();
}
function ChangeDivCss3(p) {
    LoadLazyImg();
    var ls = document.getElementById("ul-index-news").getElementsByTagName("li");
    var dv = document.getElementById("div-index-news");
    var dv0 = document.getElementById("div-index-news-0");
    var dv1 = document.getElementById("div-index-news-1");
    if (p == 0) {
        ls[0].className = "cur";
        ls[1].className = "";
        dv.className = "tab";
        dv0.className = "con show";
        dv1.className = "con";
    }
    if (p == 1) {
        ls[1].className = "cur";
        ls[0].className = "";
        dv.className = "tab tabed";
        dv1.className = "con show";
        dv0.className = "con";
    }
    LoadLazyImg();
}
function ChangeDivCss4(p) {
    LoadLazyImg();
    var ls = document.getElementById("ul-index-rmdp").getElementsByTagName("li");

    for (var i = 0; i < ls.length; i++) {
        var tmpCN = ls[i].className.split(" ");
        if (i == p) {
            ls[i].className = tmpCN[0] + " cur";
            document.getElementById("ul-index-rmdp-" + i).className = "f-s-con tabcon-" + (i + 1) + " show";
        } else {
            ls[i].className = tmpCN[0];
            document.getElementById("ul-index-rmdp-" + i).className = "f-s-con tabcon-" + (i + 1);
        }
    }
    LoadLazyImg();
}
function ChangeDivCss5(p) {
    LoadLazyImg();
    var ls = document.getElementById("ul-index-news2").getElementsByTagName("li");
    var dv = document.getElementById("div-index-news2");
    var dv0 = document.getElementById("div-index-news2-0");
    var dv1 = document.getElementById("div-index-news2-1");
    if (p == 0) {
        ls[0].className = "cur";
        ls[1].className = "";
        dv.className = "tabs";
        dv0.className = "con show";
        dv1.className = "con";
    }
    if (p == 1) {
        ls[1].className = "cur";
        ls[0].className = "";
        dv.className = "tabs tabed";
        dv1.className = "con show";
        dv0.className = "con";
    }
    LoadLazyImg();
}

function ChangeDivCss6(p) {
    LoadLazyImg();
    var ls = document.getElementById("ul-index-fzcp").getElementsByTagName("li");

    for (var i = 0; i < ls.length; i++) {
        var tmpCN = ls[i].className.split(" ");
        if (i == p) {
            ls[i].className = tmpCN[0] + " cur";
            document.getElementById("div-index-fzcp-" + i).className = "f-s-con show";
        } else {
            ls[i].className = tmpCN[0];
            document.getElementById("div-index-fzcp-" + i).className = "f-s-con";
        }
    }
    LoadLazyImg();
}

function ChangeDivCss7(p) {
    LoadLazyImg();
    var ls = document.getElementById("ul-articledetails-rmcp").getElementsByTagName("li");

    for (var i = 0; i < ls.length; i++) {
        var tmpCN = ls[i].className.split(" ");
        if (i == p) {
            ls[i].className = tmpCN[0] + " cur";
            document.getElementById("ul-articledetails-rmcp-con-" + i).className = "con cur";
        } else {
            ls[i].className = tmpCN[0];
            document.getElementById("ul-articledetails-rmcp-con-" + i).className = "con";
        }
    }
    LoadLazyImg();
}

function ChangeDivCss8(p) {
    LoadLazyImg();
    var ls = document.getElementById("ul-articledetails-ktxs").getElementsByTagName("li");

    for (var i = 0; i < ls.length; i++) {
        var tmpCN = ls[i].className.split(" ");
        if (i == p) {
            ls[i].className = tmpCN[0] + " cur";
            document.getElementById("ul-articledetails-ktxs-con-" + i).className = "con cur";
        } else {
            ls[i].className = tmpCN[0];
            document.getElementById("ul-articledetails-ktxs-con-" + i).className = "con";
        }
    }
    LoadLazyImg();
}
var xFootRun = true;

function ShowFooter() {
    LoadLazyImg();
    if (xFootRun) {
        var value = $('#site-help')[0].clientHeight + 10;
        $("#site-help").css("height", value + "px");
        if (value > 215) {xFootRun = false; }
        else {
            setTimeout("ShowFooter()", 1);
        } 
    }
}
function HideFooter() {
    if (!xFootRun) {
        var value = $('#site-help')[0].clientHeight - 5;
        $("#site-help").css("height", value + "px");
        if (value < 55) { xFootRun = true; }
        else {
            setTimeout("HideFooter()", 1);
        } 
    }
}

function HideDiv(objid) {
    if (typeof (neverClose) != "undefined" && neverClose == 1 && objid == "divBoxWrap") {
    } else {
        $('#' + objid).hide();
        if (objid == "divBuWei" || objid == "divFangShi" || objid == "divPingPai") {
            $('#' + objid).css("visibility", "hidden");
        }
        if (objid == "divBuWei" || objid == "divFangShi") {
            document.getElementById(objid + "Li").className = ("item");
        }
        if (objid == "divPingPai") {
            document.getElementById(objid + "Li").className = ("item last");
        }
    }
    //SetCookie("tmp" + objid, 0);
    //setTimeout("CloseDiv('" + objid + "')", 100);
}
function CloseDiv(objid) {
    if (GetCookie("tmp" + objid) == "0") {
        $('#' + objid).hide();
        $('#' + objid).css("visibility", "hidden");
    }
}
//car//////////////////////////////////
function sum(buy) {
    var total = 0;
    for (var i = 1; i <= buy; i++) {
        var m = $('#jia_goods_' + i).val();
        var mm = m.substr(1, m.length);
        total += Number(mm);
    }
    $('#total').text(total);
}
function change(goods, jia, jia_goods, buy) {
    var num = Number($('#' + goods).val());
    if (num < 1) { alert("已经只剩一件了，不买请点击删除！"); num = 1; $('#' + goods).val(num); }
    else {
        $('#' + goods).val(num);
    }
    $('#' + jia_goods).val('￥' + num * jia + '.00');
    return sum(buy);
}
function change_jian(g_id) {
    var num = Number($('#' + g_id).val());
    num--;
    if (num < 1) { alert("已经只剩一件了，不买请点击删除！"); num = 1; $('#' + g_id).val(num); }
    else {
        $('#' + g_id).val(num);
    }
    ChangeProductQuantity(num);
}
function change_add(g_id) {
    var num = Number($('#' + g_id).val());
    num++;
    $('#' + g_id).val(num);
    ChangeProductQuantity(num);
}
//check adress///////////////////////////////
function check(name, n) {
    if ($('#' + name).val() == '') {
        switch (n) {
            case 1:
                $('#error' + name).text('收货人不能为空');
                break;
            case 2:
                $('#error' + name).text('详细邮寄地址不能为空');
                break;
            case 3:
                $('#error' + name).text('邮箱地址不能为空');
                break;
            case 4:
                $('#error' + name).text('手机号码不能为空');
                break;
        }
    }
    else {
        $('#error' + name).text('*');
    }
}

function check_ok() {
    if ($('#Name').val() == '') {
        check('Name', 1);
        return false;
    }
    if ($('#Address').val() == '') {
        check('Address', 2);
        return false;
    }
    if ($('#Mobile').val() == '') {
        check('Mobile', 4);
        return false;
    }
}



//check reg///////////////////////////////
function check_reg(name, n) {
    if ($('#' + name).val() == '') {
        switch (n) {
            case 1:
                $('#error' + name).html('<span class="color4">* 用户名不能为空</span>');
                break;
            case 2:
                $('#error' + name).html('<span class="color4">* 请设置密码</span>');
                break;
            case 3:
                $('#error' + name).html('<span class="color4">* 请再输入一次密码</span>');
                break;
            case 4:
                $('#error' + name).html('<span class="color4">* 邮箱地址不能为空</span>');
                break;
        }
    }
    else {
        switch (n) {
            case 1:
                if ($('#' + name).val().length > 14 || $('#' + name).val().length < 6)
                { $('#error' + name).html('<span class="color4">* 用户名范围在6~14位之间</span>'); }
                else { $('#error' + name).html('<span class="color4">*</span>'); }
                break;
            case 2:
                if ($('#' + name).val().length > 16 || $('#' + name).val().length < 6)
                { $('#error' + name).html('<span class="color4">* 密码范围在6~16位之间</span>'); }
                else { $('#error' + name).html('<span class="color4">*</span>'); }
                break;
            case 3:
                if ($('#' + name).val() == $('#Pw').val())
                { $('#error' + name).html('<span class="color4">*</span>'); }
                else { $('#error' + name).html('<span class="color4">* 两次输入的密码不一致</span>'); }
                break;
            case 4:
                $('#error' + name).html('<span class="color4">*</span>');
                break;
            case 5:
                if ($('#' + name).val() == $('#newPwd').val())
                { $('#error' + name).html('<span class="color4">*</span>'); }
                else { $('#error' + name).html('<span class="color4">* 两次输入的密码不一致</span>'); }
                break;
        }
    }
}

function reg_ok() {
    var reg_Email = /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
    var str = $('#User').val();
    var reLen = 0;
    for (var i = 0; i < str.length; i++) {
        if (str.charCodeAt(i) < 27 || str.charCodeAt(i) > 126) {
            // 全角    
            reLen += 2;
        }
        else {
            reLen++;
        }
    }
    if ($('#User').val() == '' || reLen > 16 || reLen < 6) {
        check_reg('User', 1);
        return false;
    }
    if ($('#Pw').val() == '') {
        check_reg('Pw', 2);
        return false;
    }
    if ($('#Pw').val().length > 16 || $('#Pw').val().length < 6) {
        check_reg('Pw', 2);
        return false;
    }
    if ($('#Pw_ok').val() !== $('#Pw').val()) {
        check_reg('Pw_ok', 3);
        return false;
    }
    if ($('#Email').val() !== "") {
        if (!reg_Email.test($('#Email').val())) {
            $('#errorEmail').html('<span class="color4">* 邮箱格式不正确</span>');
            return false;
        }
    }
    if ($('#Email').val() == "") {

        check_reg('Email', 4);
        return false;

    }
    if ($('#Mobile').val() != '' && $('#Mobile').val().length != 11) {
        $('#errorMobile').html('<span class="color4">* 手机号码非法</span>');
        return false;
    }
}

function change_ok() {
    if ($('#oldPwd').val() == '') {
        check_reg('oldPwd', 2);
        return false;
    }
    if ($('#oldPwd').val().length > 16 || $('#oldPwd').val().length < 6) {
        check_reg('oldPwd', 2);
        return false;
    }
    if ($('#newPwd').val() !== $('#newPwd').val()) {
        check_reg('newPwd', 2);
        return false;
    }
    if ($('#newPwd').val().length > 16 || $('#newPwd').val().length < 6) {
        check_reg('newPwd', 2);
        return false;
    }
    if ($('#confirmPwd').val() == '') {
        check_reg('confirmPwd', 2);
        return false;
    }
    if ($('#confirmPwd').val() !== $('#newPwd').val()) {
        check_reg('confirmPwd', 5);
        return false;
    }
    if ($('#confirmPwd').val().length > 16 || $('#confirmPwd').val().length < 6) {
        check_reg('confirmPwd', 2);
        return false;
    }
}

//check goods_comments/////////////////////////
function check_comments() {
    if ($('#comments_info').val().length < 6) {
        alert('您的评论内容太短或者为空')
        return false;
    }
}


//tab//////////////////////////////////
var ID = function id(id) {
    return document.getElementById(id);
}
function setTab(m, n, tname, iname) {
    var title = ID("tab" + m).getElementsByTagName(tname);
    var info = ID("tabi" + m).getElementsByTagName(iname);
    for (i = 0; i < title.length; i++) {
        title[i].className = i == n ? "hover" : "";
        info[i].style.display = i == n ? "block" : "none";
    }
}

//Dialog box ////////////////////////////////////////////////
(function ($) {
    var openedPopups = [];
    var popupLayerScreenLocker = false;
    var focusableElement = [];
    var setupJqueryMPopups = {
        screenLockerBackground: "#fff",
        screenLockerOpacity: "0.4"
    };

    $.setupJMPopups = function (settings) {
        setupJqueryMPopups = jQuery.extend(setupJqueryMPopups, settings);
        return this;
    }

    $.openPopupLayer = function (settings) {
        if (typeof (settings.name) != "undefined" && !checkIfItExists(settings.name)) {
            settings = jQuery.extend({
                width: "auto",
                height: "auto",
                parameters: {},
                target: "",
                success: function () { },
                error: function () { },
                beforeClose: function () { },
                afterClose: function () { },
                reloadSuccess: null,
                cache: false
            }, settings);
            loadPopupLayerContent(settings, true);
            return this;
        }
    }

    $.closePopupLayer = function (name) {
        if (name) {
            for (var i = 0; i < openedPopups.length; i++) {
                if (openedPopups[i].name == name) {
                    var thisPopup = openedPopups[i];

                    openedPopups.splice(i, 1)

                    thisPopup.beforeClose();

                    $("#popupLayer_" + name).fadeOut(function () {
                        $("#popupLayer_" + name).remove();

                        focusableElement.pop();

                        if (focusableElement.length > 0) {
                            $(focusableElement[focusableElement.length - 1]).focus();
                        }

                        thisPopup.afterClose();
                        hideScreenLocker(name);
                    });
                    break;
                }
            }
        } else {
            if (openedPopups.length > 0) {
                $.closePopupLayer(openedPopups[openedPopups.length - 1].name);
            }
        }

        return this;
    }

    $.reloadPopupLayer = function (name, callback) {
        if (name) {
            for (var i = 0; i < openedPopups.length; i++) {
                if (openedPopups[i].name == name) {
                    if (callback) {
                        openedPopups[i].reloadSuccess = callback;
                    }

                    loadPopupLayerContent(openedPopups[i], false);
                    break;
                }
            }
        } else {
            if (openedPopups.length > 0) {
                $.reloadPopupLayer(openedPopups[openedPopups.length - 1].name);
            }
        }

        return this;
    }

    function setScreenLockerSize() {
        if (popupLayerScreenLocker) {
            $('#popupLayerScreenLocker').height($(document).height() + "px");
            $('#popupLayerScreenLocker').width($(document.body).outerWidth(true) + "px");
        }
    }

    function checkIfItExists(name) {
        if (name) {
            for (var i = 0; i < openedPopups.length; i++) {
                if (openedPopups[i].name == name) {
                    return true;
                }
            }
        }
        return false;
    }

    function showScreenLocker() {
        if ($("#popupLayerScreenLocker").length) {
            if (openedPopups.length == 1) {
                popupLayerScreenLocker = true;
                setScreenLockerSize();
                $('#popupLayerScreenLocker').fadeIn();
            }

            if ($.browser.msie && $.browser.version < 7) {
                $("select:not(.hidden-by-jmp)").addClass("hidden-by-jmp hidden-by-" + openedPopups[openedPopups.length - 1].name).css("visibility", "hidden");
            }

            $('#popupLayerScreenLocker').css("z-index", parseInt(openedPopups.length == 1 ? 999 : $("#popupLayer_" + openedPopups[openedPopups.length - 2].name).css("z-index")) + 1);
        } else {
            $("body").append("<div id='popupLayerScreenLocker'><!-- --></div>");
            $("#popupLayerScreenLocker").css({
                position: "absolute",
                background: setupJqueryMPopups.screenLockerBackground,
                left: "0",
                top: "0",
                opacity: setupJqueryMPopups.screenLockerOpacity,
                display: "none"
            });
            showScreenLocker();

            $("#popupLayerScreenLocker").click(function () {
                $.closePopupLayer();
            });
        }
    }

    function hideScreenLocker(popupName) {
        if (openedPopups.length == 0) {
            screenlocker = false;
            $('#popupLayerScreenLocker').fadeOut();
        } else {
            $('#popupLayerScreenLocker').css("z-index", parseInt($("#popupLayer_" + openedPopups[openedPopups.length - 1].name).css("z-index")) - 1);
        }

        if ($.browser.msie && $.browser.version < 7) {
            $("select.hidden-by-" + popupName).removeClass("hidden-by-jmp hidden-by-" + popupName).css("visibility", "visible");
        }
    }

    function setPopupLayersPosition(popupElement, animate) {
        if (popupElement) {
            if (popupElement.width() < $(window).width()) {
                var leftPosition = (document.documentElement.offsetWidth - popupElement.width()) / 2;
            } else {
                var leftPosition = document.documentElement.scrollLeft + 5;
            }

            if (popupElement.height() < $(window).height()) {
                var topPosition = document.documentElement.scrollTop + ($(window).height() - popupElement.height()) / 5;
            } else {
                var topPosition = document.documentElement.scrollTop + 5;
            }

            var positions = {
                left: leftPosition + "px",
                top: topPosition + "px"
            };

            if (!animate) {
                popupElement.css(positions);
            } else {
                popupElement.animate(positions, "slow");
            }

            setScreenLockerSize();
        } else {
            for (var i = 0; i < openedPopups.length; i++) {
                setPopupLayersPosition($("#popupLayer_" + openedPopups[i].name), true);
            }
        }
    }

    function showPopupLayerContent(popupObject, newElement, data) {
        var idElement = "popupLayer_" + popupObject.name;

        if (newElement) {
            showScreenLocker();

            $("body").append("<div id='" + idElement + "'><!-- --></div>");

            var zIndex = parseInt(openedPopups.length == 1 ? 1000 : $("#popupLayer_" + openedPopups[openedPopups.length - 2].name).css("z-index")) + 2;
        } else {
            var zIndex = $("#" + idElement).css("z-index");
        }

        var popupElement = $("#" + idElement);

        popupElement.css({
            visibility: "hidden",
            width: popupObject.width == "auto" ? "" : popupObject.width + "px",
            height: popupObject.height == "auto" ? "" : popupObject.height + "px",
            position: "absolute",
            "z-index": zIndex
        });

        var linkAtTop = "<a href='#' class='jmp-link-at-top' style='position:absolute; left:-9999px; top:-1px;'>&nbsp;</a><input class='jmp-link-at-top' style='position:absolute; left:-9999px; top:-1px;' />";
        var linkAtBottom = "<a href='#' class='jmp-link-at-bottom' style='position:absolute; left:-9999px; bottom:-1px;'>&nbsp;</a><input class='jmp-link-at-bottom' style='position:absolute; left:-9999px; top:-1px;' />";

        popupElement.html(linkAtTop + data + linkAtBottom);

        setPopupLayersPosition(popupElement);

        popupElement.css("display", "none");
        popupElement.css("visibility", "visible");

        if (newElement) {
            popupElement.fadeIn();
        } else {
            popupElement.show();
        }

        $("#" + idElement + " .jmp-link-at-top, " +
		  "#" + idElement + " .jmp-link-at-bottom").focus(function () {
		      $(focusableElement[focusableElement.length - 1]).focus();
		  });

        var jFocusableElements = $("#" + idElement + " a:visible:not(.jmp-link-at-top, .jmp-link-at-bottom), " +
								   "#" + idElement + " *:input:visible:not(.jmp-link-at-top, .jmp-link-at-bottom)");

        if (jFocusableElements.length == 0) {
            var linkInsidePopup = "<a href='#' class='jmp-link-inside-popup' style='position:absolute; left:-9999px;'>&nbsp;</a>";
            popupElement.find(".jmp-link-at-top").after(linkInsidePopup);
            focusableElement.push($(popupElement).find(".jmp-link-inside-popup")[0]);
        } else {
            jFocusableElements.each(function () {
                if (!$(this).hasClass("jmp-link-at-top") && !$(this).hasClass("jmp-link-at-bottom")) {
                    focusableElement.push(this);
                    return false;
                }
            });
        }

        $(focusableElement[focusableElement.length - 1]).focus();

        popupObject.success();

        if (popupObject.reloadSuccess) {
            popupObject.reloadSuccess();
            popupObject.reloadSuccess = null;
        }
    }

    function loadPopupLayerContent(popupObject, newElement) {
        if (newElement) {
            openedPopups.push(popupObject);
        }

        if (popupObject.target != "") {
            showPopupLayerContent(popupObject, newElement, $("#" + popupObject.target).html());
        } else {
            $.ajax({
                url: popupObject.url,
                data: popupObject.parameters,
                cache: popupObject.cache,
                dataType: "html",
                method: "GET",
                success: function (data) {
                    showPopupLayerContent(popupObject, newElement, data);
                },
                error: popupObject.error
            });
        }
    }

    $(window).resize(function () {
        setScreenLockerSize();
        setPopupLayersPosition();
    });

    $(document).keydown(function (e) {
        if (e.keyCode == 27) {
            $.closePopupLayer();
        }
    });
})(jQuery);
//ajax login Dialog box 
function login() {
    $.openPopupLayer({
        name: "login",
        width: 288,
        url: WebSite + "/Member/login.aspx"
    });
}


function login2() {
    $.openPopupLayer({
        name: "login2",
        width: 625,
        url: WebSite + "/Measurement/Default.aspx"
    });
}

var DEFAULT_LENGTH = 14;
function lengthValidate() {

    var len = 0;
    var reLen = 0;
    var chaju = 0;
    var str = document.getElementById('cName').value;
    len = str.length;
    for (var i = 0; i < len; i++) {
        if (str.charCodeAt(i) < 27 || str.charCodeAt(i) > 126) {
            // 全角    
            reLen += 2;
        }
        else {
            reLen++;
        }
    }
    chaju = reLen - len;
    //alert(len+"|"+reLen+"|"+chaju);
    document.getElementById('cName').maxLength = DEFAULT_LENGTH - chaju;
}

function lengthValidateUser() {

    var len = 0;
    var reLen = 0;
    var chaju = 0;
    var str = document.getElementById('User').value;
    len = str.length;
    for (var i = 0; i < len; i++) {
        if (str.charCodeAt(i) < 27 || str.charCodeAt(i) > 126) {
            // 全角    
            reLen += 2;
        }
        else {
            reLen++;
        }
    }
    chaju = reLen - len;
    //alert(len+"|"+reLen+"|"+chaju);
    document.getElementById('User').maxLength = DEFAULT_LENGTH - chaju;
}
//scores_tips////////
function scores_tips() {
    $('#scores').animate({ opacity: 'show' }, { duration: 500 });
}
function close_scores() {
    $('#scores').animate({ opacity: 'hide' }, { duration: 500 });
}

$(document).ready(function () {

    //lvnav 2012-03-20///////////////////////////
    $("#lvnav .lvnum").mouseover(function () { var obj = $(this); obj.addClass("active"); obj.siblings(".lvnum").each(function () { $(this).removeClass("active"); }) });

    (function ($) { //页签效果
        $(".lvtab .lvtabnav li").click(function () {
            $(this).addClass("lvnow").siblings("li").removeClass("lvnow");
            $(this).parents(".lvtab").find(".lvtabcont").hide();
            $(this).parents(".lvtab").find(".lvtabcont:eq(" + $(this).parent(".lvtabnav").find("li").index($(this)) + ")").show();
        });
    })(jQuery);

    //lvfooter 2012-03-20///////////////////////////	
    var navCookie;
    if (navCookie) {
        $('.lvfooter_cont').stop().css('height', '145px');
        $('.lvfooter_cont').unbind();
    } else {
        $('.lvfooter_cont').stop().css('height', '22px');
        navAnimate();
    }

    function navAnimate() {
        $('.lvfooter_cont').hover(
		function () {
		    $(this).stop().animate({ height: '145px' }, "fast");
		},
		function () {
		    $(this).stop().animate({ height: '22px' }, "fast");
		});
    }

});

//返回顶部
$(document).ready(function () {
    var show_delay;
    var scroll_left = 0; //940为页面宽度
    $(".scrollTop").click(function () {
        document.documentElement.scrollTop = 0;
        document.body.scrollTop = 0;
    });
    $(window).resize(function () {
        scroll_left = 0;
        $(".scrollTop").css("left", scroll_left);
    });
    reshow(scroll_left, show_delay);
});
function reshow(marign_l, show_d) {
    $(".scrollTop").css("left", marign_l);
    if ((document.documentElement.scrollTop + document.body.scrollTop) != 0) {
        $(".scrollTop").css("display", "block");
    }
    else {
        $(".scrollTop").css("display", "none");
    }
    if (show_d) window.clearTimeout(show_d);
    show_d = setTimeout("reshow()", 500);
}
//增加购物车产品数量
function AddProductCount(qlty) {
    var currentCount = 1;

    if (GetCookie("ProductCount") != "") {
        if (typeof (qlty) != "undefined") {
            currentCount = parseInt(GetCookie("ProductCount")) + parseInt(qlty);
        } else {
            currentCount = parseInt(GetCookie("ProductCount")) + 1;
        }
    }
    var tempDate = new Date();
    tempDate.setDate(tempDate.getDate() + 1);
    SetCookie("ProductCount", currentCount, null, "/", WebSite.replace("http://www.", "").replace("/", ""));
}

function FastBuyProduct(pID, qty, pri, pois) {
    if (typeof xIsOutStock != "undefined" && xIsOutStock != "" && xIsOutStock == "True") {
        alert("尊敬的客户您好，该产品目前属于缺货状态，无法下单!");
        return;
    }
    if (qty <= 0) {
        alert("购买件数不能小于1件！"); return;
    }
    if (pois == undefined || pois == "")
        pois = 0;
    AddCarByID(pID, "", qty, pri, pois, 0, function (data) {
        AddProductCount(qty);
        if (typeof WindownLoctioningExtend != 'undefined') WindownLoctioningExtend();
        window.location.href = MemberWebSite + "Member/Car.aspx";
    });
}

function FastBuyMSProduct(pID, qty, pri, pois) {
    if (typeof xIsOutStock != "undefined" && xIsOutStock != "" && xIsOutStock == "True") {
        alert("尊敬的客户您好，该产品目前属于缺货状态，无法下单!");
        return;
    }
    if (qty <= 0) {
        alert("购买件数不能小于1件！"); return;
    }
    if (pois == undefined || pois == "")
        pois = 0;
    AddMSCarByID(pID, "", qty, pri, pois, 0,2, function (data) {
        AddProductCount(qty);
        if (typeof WindownLoctioningExtend != 'undefined') WindownLoctioningExtend();
        window.location.href = MemberWebSite + "Member/Car.aspx";
    });
}

/* 图片延迟加载 */
function getPosition(h) { var a = navigator.userAgent.toLowerCase(); var b = (a.indexOf("opera") != -1); var e = (a.indexOf("msie") != -1 && !b); var d = h; if (d.parentNode === null || d.style.display == "none") { return false } var l = null; var k = []; var i; if (d.getBoundingClientRect) { i = d.getBoundingClientRect(); if (a.indexOf("ipad") != -1) { return { x: i.left, y: i.top} } var c = jQuery(window).scrollTop(); var f = jQuery(window).scrollLeft(); return { x: i.left + f, y: i.top + c} } else { if (document.getBoxObjectFor) { i = document.getBoxObjectFor(d); var j = (d.style.borderLeftWidth) ? parseInt(d.style.borderLeftWidth) : 0; var g = (d.style.borderTopWidth) ? parseInt(d.style.borderTopWidth) : 0; k = [i.x - j, i.y - g] } else { k = [d.offsetLeft, d.offsetTop]; l = d.offsetParent; if (l != d) { while (l) { k[0] += l.offsetLeft; k[1] += l.offsetTop; l = l.offsetParent } } if (a.indexOf("opera") != -1 || (a.indexOf("safari") != -1 && d.style.position == "absolute")) { k[0] -= document.body.offsetLeft; k[1] -= document.body.offsetTop } } } if (d.parentNode) { l = d.parentNode } else { l = null } while (l && l.tagName != "BODY" && l.tagName != "HTML") { k[0] -= l.scrollLeft; k[1] -= l.scrollTop; if (l.parentNode) { l = l.parentNode } else { l = null } } return { x: k[0], y: k[1]} } jQuery(document).ready(function lazyload() { var d = jQuery("img[src2]"); var a = function () { return jQuery(window).height() + jQuery(window).scrollTop() }; imgLoad(d, a()); var c = 150; var b = 0; jQuery(window).bind("scroll", function () { var e = Math.abs(jQuery(window).scrollTop() - b); if (e >= c) { imgLoad(d, a()); if (imgLoadStatus == 1) { b += c; imgLoadStatus = 0 } } }) }); var imgLoadStatus = 0; function imgLoad(b, a) { b = jQuery("img[src2]"); b.each(function () { var d = jQuery(this).attr("src2"); if (d) { var c = getPosition(jQuery(this)[0]).y; if (c <= a && (c + jQuery(this).height()) >= jQuery(window).scrollTop()) { jQuery(this).attr("src", d).removeAttr("src2") } } }); imgLoadStatus = 1 };

var zhangxu = { $: function (objName) { if (document.getElementById) { return eval('document.getElementById("' + objName + '")') } else { return eval('document.all.' + objName) } }, isIE: navigator.appVersion.indexOf("MSIE") != -1 ? true : false, addEvent: function (l, i, I) { if (l.attachEvent) { l.attachEvent("on" + i, I) } else { l.addEventListener(i, I, false) } }, delEvent: function (l, i, I) { if (l.detachEvent) { l.detachEvent("on" + i, I) } else { l.removeEventListener(i, I, false) } }, readCookie: function (O) { var o = "", l = O + "="; if (document.cookie.length > 0) { var i = document.cookie.indexOf(l); if (i != -1) { i += l.length; var I = document.cookie.indexOf(";", i); if (I == -1) I = document.cookie.length; o = unescape(document.cookie.substring(i, I)) } }; return o }, writeCookie: function (i, l, o, c) { var O = "", I = ""; if (o != null) { O = new Date((new Date).getTime() + o * 3600000); O = "; expires=" + O.toGMTString() }; if (c != null) { I = ";domain=" + c }; document.cookie = i + "=" + escape(l) + O + I }, readStyle: function (I, l) { if (I.style[l]) { return I.style[l] } else if (I.currentStyle) { return I.currentStyle[l] } else if (document.defaultView && document.defaultView.getComputedStyle) { var i = document.defaultView.getComputedStyle(I, null); return i.getPropertyValue(l) } else { return null } } };

//滚动图片构造函数
function ScrollPic(scrollContId, arrLeftId, arrRightId, dotListId) { this.scrollContId = scrollContId; this.arrLeftId = arrLeftId; this.arrRightId = arrRightId; this.dotListId = dotListId; this.dotClassName = "dotItem"; this.dotOnClassName = "dotItemOn"; this.dotObjArr = []; this.pageWidth = 0; this.frameWidth = 0; this.speed = 10; this.space = 10; this.pageIndex = 0; this.autoPlay = true; this.autoPlayTime = 5; var _autoTimeObj, _scrollTimeObj, _state = "ready"; this.stripDiv = document.createElement("DIV"); this.listDiv01 = document.createElement("DIV"); this.listDiv02 = document.createElement("DIV"); if (!ScrollPic.childs) { ScrollPic.childs = [] }; this.ID = ScrollPic.childs.length; ScrollPic.childs.push(this);this.initialize = function () { if (!this.scrollContId) { throw new Error("必须指定scrollContId."); return }; this.scrollContDiv = zhangxu.$(this.scrollContId); if (!this.scrollContDiv) { throw new Error("scrollContId不是正确的对象.(scrollContId = \"" + this.scrollContId + "\")"); return }; this.scrollContDiv.style.width = this.frameWidth + "px"; this.scrollContDiv.style.overflow = "hidden"; this.listDiv01.innerHTML = this.listDiv02.innerHTML = this.scrollContDiv.innerHTML; this.listDiv02.innerHTML = ""; this.scrollContDiv.innerHTML = ""; this.scrollContDiv.appendChild(this.stripDiv); this.stripDiv.appendChild(this.listDiv01); this.stripDiv.appendChild(this.listDiv02); this.stripDiv.style.overflow = "hidden"; this.stripDiv.style.zoom = "1"; this.stripDiv.style.width = "32766px"; this.listDiv01.style.cssFloat = "left"; this.listDiv01.style.styleFloat = "left"; this.listDiv02.style.cssFloat = "left"; this.listDiv02.style.styleFloat = "left"; this.listDiv02.style.display = "none"; zhangxu.addEvent(this.scrollContDiv, "mouseover", Function("ScrollPic.childs[" + this.ID + "].stop()")); zhangxu.addEvent(this.scrollContDiv, "mouseout", Function("ScrollPic.childs[" + this.ID + "].play()")); if (this.arrLeftId) { this.arrLeftObj = zhangxu.$(this.arrLeftId); if (this.arrLeftObj) { zhangxu.addEvent(this.arrLeftObj, "mousedown", Function("ScrollPic.childs[" + this.ID + "].rightMouseDown()")); zhangxu.addEvent(this.arrLeftObj, "mouseup", Function("ScrollPic.childs[" + this.ID + "].rightEnd()")); zhangxu.addEvent(this.arrLeftObj, "mouseout", Function("ScrollPic.childs[" + this.ID + "].rightEnd()")) } }; if (this.arrRightId) { this.arrRightObj = zhangxu.$(this.arrRightId); if (this.arrRightObj) { zhangxu.addEvent(this.arrRightObj, "mousedown", Function("ScrollPic.childs[" + this.ID + "].leftMouseDown()")); zhangxu.addEvent(this.arrRightObj, "mouseup", Function("ScrollPic.childs[" + this.ID + "].leftEnd()")); zhangxu.addEvent(this.arrRightObj, "mouseout", Function("ScrollPic.childs[" + this.ID + "].leftEnd()")) } }; if (this.dotListId) { this.dotListObj = zhangxu.$(this.dotListId); if (this.dotListObj) { var pages = Math.round(this.listDiv01.offsetWidth / this.frameWidth + 0.4), i, tempObj; for (i = 0; i < pages; i++) { tempObj = document.createElement("span"); this.dotListObj.appendChild(tempObj); this.dotObjArr.push(tempObj); if (i == this.pageIndex) { tempObj.className = this.dotClassName } else { tempObj.className = this.dotOnClassName }; tempObj.title = "第" + (i + 1) + "页"; zhangxu.addEvent(tempObj, "click", Function("ScrollPic.childs[" + this.ID + "].pageTo(" + i + ")")) } } }; if (this.autoPlay) { this.play() } };  this.leftMouseDown = function () { if (_state != "ready") { return }; _state = "floating"; _scrollTimeObj = setInterval("ScrollPic.childs[" + this.ID + "].moveLeft()", this.speed) }; this.rightMouseDown = function () { if (_state != "ready") { return }; _state = "floating"; _scrollTimeObj = setInterval("ScrollPic.childs[" + this.ID + "].moveRight()", this.speed) }; this.moveLeft = function () { if (this.scrollContDiv.scrollLeft + this.space >= this.listDiv01.scrollWidth) { this.scrollContDiv.scrollLeft = this.scrollContDiv.scrollLeft + this.space - this.listDiv01.scrollWidth } else { this.scrollContDiv.scrollLeft += this.space }; this.accountPageIndex() }; this.moveRight = function () { if (this.scrollContDiv.scrollLeft - this.space <= 0) { this.scrollContDiv.scrollLeft = this.listDiv01.scrollWidth + this.scrollContDiv.scrollLeft - this.space } else { this.scrollContDiv.scrollLeft -= this.space }; this.accountPageIndex() }; this.leftEnd = function () { if (_state != "floating") { return }; _state = "stoping"; clearInterval(_scrollTimeObj); var fill = this.pageWidth - this.scrollContDiv.scrollLeft % this.pageWidth; this.move(fill) }; this.rightEnd = function () { if (_state != "floating") { return }; _state = "stoping"; clearInterval(_scrollTimeObj); var fill = -this.scrollContDiv.scrollLeft % this.pageWidth; this.move(fill) }; this.move = function (num, quick) { var thisMove = num / 5; if (!quick) { if (thisMove > this.space) { thisMove = this.space }; if (thisMove < -this.space) { thisMove = -this.space } }; if (Math.abs(thisMove) < 1 && thisMove != 0) { thisMove = thisMove >= 0 ? 1 : -1 } else { thisMove = Math.round(thisMove) }; var temp = this.scrollContDiv.scrollLeft + thisMove; if (thisMove > 0) { if (this.scrollContDiv.scrollLeft + thisMove >= this.listDiv01.scrollWidth) { this.scrollContDiv.scrollLeft = this.scrollContDiv.scrollLeft + thisMove - this.listDiv01.scrollWidth } else { this.scrollContDiv.scrollLeft += thisMove } } else { if (this.scrollContDiv.scrollLeft - thisMove <= 0) { this.scrollContDiv.scrollLeft = this.listDiv01.scrollWidth + this.scrollContDiv.scrollLeft - thisMove } else { this.scrollContDiv.scrollLeft += thisMove } }; num -= thisMove; if (Math.abs(num) == 0) { _state = "ready"; if (this.autoPlay) { this.play() }; this.accountPageIndex(); return } else { this.accountPageIndex(); setTimeout("ScrollPic.childs[" + this.ID + "].move(" + num + "," + quick + ")", this.speed) } }; this.next = function () { if (_state != "ready") { return }; _state = "stoping"; this.move(this.pageWidth, true) }; this.play = function () { if (!this.autoPlay) { return }; clearInterval(_autoTimeObj); _autoTimeObj = setInterval("ScrollPic.childs[" + this.ID + "].next()", this.autoPlayTime * 1000) }; this.stop = function () { clearInterval(_autoTimeObj) }; this.pageTo = function (num) { if (_state != "ready") { return }; _state = "stoping"; var fill = num * this.frameWidth - this.scrollContDiv.scrollLeft; this.move(fill, true) }; this.accountPageIndex = function () { this.pageIndex = Math.round(this.scrollContDiv.scrollLeft / this.frameWidth); if (this.pageIndex > Math.round(this.listDiv01.offsetWidth / this.frameWidth + 0.4) - 1) { this.pageIndex = 0 }; var i; for (i = 0; i < this.dotObjArr.length; i++) { if (i == this.pageIndex) { this.dotObjArr[i].className = this.dotClassName } else { this.dotObjArr[i].className = this.dotOnClassName } } } }; /*  |xGv00|348a1e765af980b2d2cc3f5f23c1e236 */

/*	SWFObject v2.2 <http://code.google.com/p/swfobject/> 
is released under the MIT License <http://www.opensource.org/licenses/mit-license.php> 
*/
var swfobject = function () { var D = "undefined", r = "object", S = "Shockwave Flash", W = "ShockwaveFlash.ShockwaveFlash", q = "application/x-shockwave-flash", R = "SWFObjectExprInst", x = "onreadystatechange", O = window, j = document, t = navigator, T = false, U = [h], o = [], N = [], I = [], l, Q, E, B, J = false, a = false, n, G, m = true, M = function () { var aa = typeof j.getElementById != D && typeof j.getElementsByTagName != D && typeof j.createElement != D, ah = t.userAgent.toLowerCase(), Y = t.platform.toLowerCase(), ae = Y ? /win/.test(Y) : /win/.test(ah), ac = Y ? /mac/.test(Y) : /mac/.test(ah), af = /webkit/.test(ah) ? parseFloat(ah.replace(/^.*webkit\/(\d+(\.\d+)?).*$/, "$1")) : false, X = ! +"\v1", ag = [0, 0, 0], ab = null; if (typeof t.plugins != D && typeof t.plugins[S] == r) { ab = t.plugins[S].description; if (ab && !(typeof t.mimeTypes != D && t.mimeTypes[q] && !t.mimeTypes[q].enabledPlugin)) { T = true; X = false; ab = ab.replace(/^.*\s+(\S+\s+\S+$)/, "$1"); ag[0] = parseInt(ab.replace(/^(.*)\..*$/, "$1"), 10); ag[1] = parseInt(ab.replace(/^.*\.(.*)\s.*$/, "$1"), 10); ag[2] = /[a-zA-Z]/.test(ab) ? parseInt(ab.replace(/^.*[a-zA-Z]+(.*)$/, "$1"), 10) : 0 } } else { if (typeof O.ActiveXObject != D) { try { var ad = new ActiveXObject(W); if (ad) { ab = ad.GetVariable("$version"); if (ab) { X = true; ab = ab.split(" ")[1].split(","); ag = [parseInt(ab[0], 10), parseInt(ab[1], 10), parseInt(ab[2], 10)] } } } catch (Z) { } } } return { w3: aa, pv: ag, wk: af, ie: X, win: ae, mac: ac} } (), k = function () { if (!M.w3) { return } if ((typeof j.readyState != D && j.readyState == "complete") || (typeof j.readyState == D && (j.getElementsByTagName("body")[0] || j.body))) { f() } if (!J) { if (typeof j.addEventListener != D) { j.addEventListener("DOMContentLoaded", f, false) } if (M.ie && M.win) { j.attachEvent(x, function () { if (j.readyState == "complete") { j.detachEvent(x, arguments.callee); f() } }); if (O == top) { (function () { if (J) { return } try { j.documentElement.doScroll("left") } catch (X) { setTimeout(arguments.callee, 0); return } f() })() } } if (M.wk) { (function () { if (J) { return } if (!/loaded|complete/.test(j.readyState)) { setTimeout(arguments.callee, 0); return } f() })() } s(f) } } (); function f() { if (J) { return } try { var Z = j.getElementsByTagName("body")[0].appendChild(C("span")); Z.parentNode.removeChild(Z) } catch (aa) { return } J = true; var X = U.length; for (var Y = 0; Y < X; Y++) { U[Y]() } } function K(X) { if (J) { X() } else { U[U.length] = X } } function s(Y) { if (typeof O.addEventListener != D) { O.addEventListener("load", Y, false) } else { if (typeof j.addEventListener != D) { j.addEventListener("load", Y, false) } else { if (typeof O.attachEvent != D) { i(O, "onload", Y) } else { if (typeof O.onload == "function") { var X = O.onload; O.onload = function () { X(); Y() } } else { O.onload = Y } } } } } function h() { if (T) { V() } else { H() } } function V() { var X = j.getElementsByTagName("body")[0]; var aa = C(r); aa.setAttribute("type", q); var Z = X.appendChild(aa); if (Z) { var Y = 0; (function () { if (typeof Z.GetVariable != D) { var ab = Z.GetVariable("$version"); if (ab) { ab = ab.split(" ")[1].split(","); M.pv = [parseInt(ab[0], 10), parseInt(ab[1], 10), parseInt(ab[2], 10)] } } else { if (Y < 10) { Y++; setTimeout(arguments.callee, 10); return } } X.removeChild(aa); Z = null; H() })() } else { H() } } function H() { var ag = o.length; if (ag > 0) { for (var af = 0; af < ag; af++) { var Y = o[af].id; var ab = o[af].callbackFn; var aa = { success: false, id: Y }; if (M.pv[0] > 0) { var ae = c(Y); if (ae) { if (F(o[af].swfVersion) && !(M.wk && M.wk < 312)) { w(Y, true); if (ab) { aa.success = true; aa.ref = z(Y); ab(aa) } } else { if (o[af].expressInstall && A()) { var ai = {}; ai.data = o[af].expressInstall; ai.width = ae.getAttribute("width") || "0"; ai.height = ae.getAttribute("height") || "0"; if (ae.getAttribute("class")) { ai.styleclass = ae.getAttribute("class") } if (ae.getAttribute("align")) { ai.align = ae.getAttribute("align") } var ah = {}; var X = ae.getElementsByTagName("param"); var ac = X.length; for (var ad = 0; ad < ac; ad++) { if (X[ad].getAttribute("name").toLowerCase() != "movie") { ah[X[ad].getAttribute("name")] = X[ad].getAttribute("value") } } P(ai, ah, Y, ab) } else { p(ae); if (ab) { ab(aa) } } } } } else { w(Y, true); if (ab) { var Z = z(Y); if (Z && typeof Z.SetVariable != D) { aa.success = true; aa.ref = Z } ab(aa) } } } } } function z(aa) { var X = null; var Y = c(aa); if (Y && Y.nodeName == "OBJECT") { if (typeof Y.SetVariable != D) { X = Y } else { var Z = Y.getElementsByTagName(r)[0]; if (Z) { X = Z } } } return X } function A() { return !a && F("6.0.65") && (M.win || M.mac) && !(M.wk && M.wk < 312) } function P(aa, ab, X, Z) { a = true; E = Z || null; B = { success: false, id: X }; var ae = c(X); if (ae) { if (ae.nodeName == "OBJECT") { l = g(ae); Q = null } else { l = ae; Q = X } aa.id = R; if (typeof aa.width == D || (!/%$/.test(aa.width) && parseInt(aa.width, 10) < 310)) { aa.width = "310" } if (typeof aa.height == D || (!/%$/.test(aa.height) && parseInt(aa.height, 10) < 137)) { aa.height = "137" } j.title = j.title.slice(0, 47) + " - Flash Player Installation"; var ad = M.ie && M.win ? "ActiveX" : "PlugIn", ac = "MMredirectURL=" + O.location.toString().replace(/&/g, "%26") + "&MMplayerType=" + ad + "&MMdoctitle=" + j.title; if (typeof ab.flashvars != D) { ab.flashvars += "&" + ac } else { ab.flashvars = ac } if (M.ie && M.win && ae.readyState != 4) { var Y = C("div"); X += "SWFObjectNew"; Y.setAttribute("id", X); ae.parentNode.insertBefore(Y, ae); ae.style.display = "none"; (function () { if (ae.readyState == 4) { ae.parentNode.removeChild(ae) } else { setTimeout(arguments.callee, 10) } })() } u(aa, ab, X) } } function p(Y) { if (M.ie && M.win && Y.readyState != 4) { var X = C("div"); Y.parentNode.insertBefore(X, Y); X.parentNode.replaceChild(g(Y), X); Y.style.display = "none"; (function () { if (Y.readyState == 4) { Y.parentNode.removeChild(Y) } else { setTimeout(arguments.callee, 10) } })() } else { Y.parentNode.replaceChild(g(Y), Y) } } function g(ab) { var aa = C("div"); if (M.win && M.ie) { aa.innerHTML = ab.innerHTML } else { var Y = ab.getElementsByTagName(r)[0]; if (Y) { var ad = Y.childNodes; if (ad) { var X = ad.length; for (var Z = 0; Z < X; Z++) { if (!(ad[Z].nodeType == 1 && ad[Z].nodeName == "PARAM") && !(ad[Z].nodeType == 8)) { aa.appendChild(ad[Z].cloneNode(true)) } } } } } return aa } function u(ai, ag, Y) { var X, aa = c(Y); if (M.wk && M.wk < 312) { return X } if (aa) { if (typeof ai.id == D) { ai.id = Y } if (M.ie && M.win) { var ah = ""; for (var ae in ai) { if (ai[ae] != Object.prototype[ae]) { if (ae.toLowerCase() == "data") { ag.movie = ai[ae] } else { if (ae.toLowerCase() == "styleclass") { ah += ' class="' + ai[ae] + '"' } else { if (ae.toLowerCase() != "classid") { ah += " " + ae + '="' + ai[ae] + '"' } } } } } var af = ""; for (var ad in ag) { if (ag[ad] != Object.prototype[ad]) { af += '<param name="' + ad + '" value="' + ag[ad] + '" />' } } aa.outerHTML = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"' + ah + ">" + af + "</object>"; N[N.length] = ai.id; X = c(ai.id) } else { var Z = C(r); Z.setAttribute("type", q); for (var ac in ai) { if (ai[ac] != Object.prototype[ac]) { if (ac.toLowerCase() == "styleclass") { Z.setAttribute("class", ai[ac]) } else { if (ac.toLowerCase() != "classid") { Z.setAttribute(ac, ai[ac]) } } } } for (var ab in ag) { if (ag[ab] != Object.prototype[ab] && ab.toLowerCase() != "movie") { e(Z, ab, ag[ab]) } } aa.parentNode.replaceChild(Z, aa); X = Z } } return X } function e(Z, X, Y) { var aa = C("param"); aa.setAttribute("name", X); aa.setAttribute("value", Y); Z.appendChild(aa) } function y(Y) { var X = c(Y); if (X && X.nodeName == "OBJECT") { if (M.ie && M.win) { X.style.display = "none"; (function () { if (X.readyState == 4) { b(Y) } else { setTimeout(arguments.callee, 10) } })() } else { X.parentNode.removeChild(X) } } } function b(Z) { var Y = c(Z); if (Y) { for (var X in Y) { if (typeof Y[X] == "function") { Y[X] = null } } Y.parentNode.removeChild(Y) } } function c(Z) { var X = null; try { X = j.getElementById(Z) } catch (Y) { } return X } function C(X) { return j.createElement(X) } function i(Z, X, Y) { Z.attachEvent(X, Y); I[I.length] = [Z, X, Y] } function F(Z) { var Y = M.pv, X = Z.split("."); X[0] = parseInt(X[0], 10); X[1] = parseInt(X[1], 10) || 0; X[2] = parseInt(X[2], 10) || 0; return (Y[0] > X[0] || (Y[0] == X[0] && Y[1] > X[1]) || (Y[0] == X[0] && Y[1] == X[1] && Y[2] >= X[2])) ? true : false } function v(ac, Y, ad, ab) { if (M.ie && M.mac) { return } var aa = j.getElementsByTagName("head")[0]; if (!aa) { return } var X = (ad && typeof ad == "string") ? ad : "screen"; if (ab) { n = null; G = null } if (!n || G != X) { var Z = C("style"); Z.setAttribute("type", "text/css"); Z.setAttribute("media", X); n = aa.appendChild(Z); if (M.ie && M.win && typeof j.styleSheets != D && j.styleSheets.length > 0) { n = j.styleSheets[j.styleSheets.length - 1] } G = X } if (M.ie && M.win) { if (n && typeof n.addRule == r) { n.addRule(ac, Y) } } else { if (n && typeof j.createTextNode != D) { n.appendChild(j.createTextNode(ac + " {" + Y + "}")) } } } function w(Z, X) { if (!m) { return } var Y = X ? "visible" : "hidden"; if (J && c(Z)) { c(Z).style.visibility = Y } else { v("#" + Z, "visibility:" + Y) } } function L(Y) { var Z = /[\\\"<>\.;]/; var X = Z.exec(Y) != null; return X && typeof encodeURIComponent != D ? encodeURIComponent(Y) : Y } var d = function () { if (M.ie && M.win) { window.attachEvent("onunload", function () { var ac = I.length; for (var ab = 0; ab < ac; ab++) { I[ab][0].detachEvent(I[ab][1], I[ab][2]) } var Z = N.length; for (var aa = 0; aa < Z; aa++) { y(N[aa]) } for (var Y in M) { M[Y] = null } M = null; for (var X in swfobject) { swfobject[X] = null } swfobject = null }) } } (); return { registerObject: function (ab, X, aa, Z) { if (M.w3 && ab && X) { var Y = {}; Y.id = ab; Y.swfVersion = X; Y.expressInstall = aa; Y.callbackFn = Z; o[o.length] = Y; w(ab, false) } else { if (Z) { Z({ success: false, id: ab }) } } }, getObjectById: function (X) { if (M.w3) { return z(X) } }, embedSWF: function (ab, ah, ae, ag, Y, aa, Z, ad, af, ac) { var X = { success: false, id: ah }; if (M.w3 && !(M.wk && M.wk < 312) && ab && ah && ae && ag && Y) { w(ah, false); K(function () { ae += ""; ag += ""; var aj = {}; if (af && typeof af === r) { for (var al in af) { aj[al] = af[al] } } aj.data = ab; aj.width = ae; aj.height = ag; var am = {}; if (ad && typeof ad === r) { for (var ak in ad) { am[ak] = ad[ak] } } if (Z && typeof Z === r) { for (var ai in Z) { if (typeof am.flashvars != D) { am.flashvars += "&" + ai + "=" + Z[ai] } else { am.flashvars = ai + "=" + Z[ai] } } } if (F(Y)) { var an = u(aj, am, ah); if (aj.id == ah) { w(ah, true) } X.success = true; X.ref = an } else { if (aa && A()) { aj.data = aa; P(aj, am, ah, ac); return } else { w(ah, true) } } if (ac) { ac(X) } }) } else { if (ac) { ac(X) } } }, switchOffAutoHideShow: function () { m = false }, ua: M, getFlashPlayerVersion: function () { return { major: M.pv[0], minor: M.pv[1], release: M.pv[2]} }, hasFlashPlayerVersion: F, createSWF: function (Z, Y, X) { if (M.w3) { return u(Z, Y, X) } else { return undefined } }, showExpressInstall: function (Z, aa, X, Y) { if (M.w3 && A()) { P(Z, aa, X, Y) } }, removeSWF: function (X) { if (M.w3) { y(X) } }, createCSS: function (aa, Z, Y, X) { if (M.w3) { v(aa, Z, Y, X) } }, addDomLoadEvent: K, addLoadEvent: s, getQueryParamValue: function (aa) { var Z = j.location.search || j.location.hash; if (Z) { if (/\?/.test(Z)) { Z = Z.split("?")[1] } if (aa == null) { return L(Z) } var Y = Z.split("&"); for (var X = 0; X < Y.length; X++) { if (Y[X].substring(0, Y[X].indexOf("=")) == aa) { return L(Y[X].substring((Y[X].indexOf("=") + 1))) } } } return "" }, expressInstallCallback: function () { if (a) { var X = c(R); if (X && l) { X.parentNode.replaceChild(l, X); if (Q) { w(Q, true); if (M.ie && M.win) { l.style.display = "block" } } if (E) { E(B) } } a = false } } } } ();

//产品对比js
function changeList(i) {
    var tiele1 = document.getElementById("list-index");
    var tiele2 = document.getElementById("list-grid");
    var tiele3 = document.getElementById("list-text");
    var list1 = document.getElementById("productindex");
    var list2 = document.getElementById("gallery-list");
    var list3 = document.getElementById("producttext");
    if (i == 0) {
        tiele1.className = "current";
        tiele2.className = "";
        tiele3.className = "";
        list1.style.display = "block";
        list2.style.display = "none";
        list3.style.display = "none";
    }
    if (i == 1) {
        tiele1.className = "";
        tiele2.className = "current";
        tiele3.className = "";
        list1.style.display = "none";
        list2.style.display = "block";
        list3.style.display = "none";
    }
    if (i == 2) {
        tiele1.className = "";
        tiele2.className = "";
        tiele3.className = "current";
        list1.style.display = "none";
        list2.style.display = "none";
        list3.style.display = "block";
    }
}
/*添加*/
function Compareto(value) {
    var productID = value.split(',');
    var hidid = document.getElementById("divid2");
    var list = "";
    if ($(".compare-box li").length >= 5) {
        hidid.style.display = "block";
        setTimeout('hidden2()', 3000);
    }
    else {
        var hidproductID = document.getElementsByName("hidpid");
        var hidid = document.getElementById("divid");
        var a = this.document.getElementById("goods-compare");
        for (var i = 0; i < hidproductID.length; i++) {
            if (hidproductID[i].value == productID[0]) {
                hidid.style.display = "block";
                a.style.display = "block";
                setTimeout('hidden()', 3000);
                return;
            }
        }
        var a = this.document.getElementById("goods-compare");
        a.style.display = "block";
        $(".compare-box").append("<li class=\"division clearfix\"><div class=\"goods-name\"><a title=\"" + productID[1] + "\" gid=\"" + productID[0] + "\" href=\"\">" + productID[1] + "</a></div><div class=\"op\"><span class=\"price\">价格:" + productID[2] + "</span> <a class=\"btn-delete\" onclick=\"Deletes();\">删除</a></div><input type=\"hidden\" id=\"hidpid\" name=\"hidpid\" value=\"" + productID[0] + "\" /></li>");
    }
}
/*删除*/
function Deletes() {
    $(".compare-box li").click(function () { $(this).remove();});
}
/*清空*/
function Getempty() {
    $(".compare-box li").remove();
    var a = this.document.getElementById("goods-compare");
    a.style.display = "none";

}
/*关闭*/
function hide() {
    var a = this.document.getElementById("goods-compare");
    a.style.display = "none";
}
/*开始对比*/
function hidden() {
    document.getElementById("divid").style.display = "none";
}
function hidden2() {
    document.getElementById("divid2").style.display = "none";
}
function hidden3() {
    document.getElementById("divid3").style.display = "none";
}
//返回顶部事件
function pageScroll() {
    var top = document.getElementById("Totop");
    //把内容滚动指定的像素数（第一个参数是向右滚动的像素数，第二个参数是向下滚动的像素数）
    window.scrollBy(0, -100);
    //延时递归调用，模拟滚动向上效果
    scrolldelay = setTimeout('pageScroll()',1);
    //获取scrollTop值，声明了DTD的标准网页取document.documentElement.scrollTop，否则取document.body.scrollTop；因为二者只有一个会生效，另一个就恒为0，所以取和值可以得到网页的真正的scrollTop值
    var sTop = document.documentElement.scrollTop + document.body.scrollTop;
    //判断当页面到达顶部，取消延时代码（否则页面滚动到顶部会无法再向下正常浏览页面）
    if (sTop == 0) {
        clearTimeout(scrolldelay);
    }
}