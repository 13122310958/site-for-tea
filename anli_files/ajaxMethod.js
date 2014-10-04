function SafeRequest(paraValue) {
    if (paraValue == undefined || paraValue == null)
        return "";
    var SafeRequest = "";
    paraValue = paraValue.replace("'", "''");
    paraValue = paraValue.replace("select ", "");
    paraValue = paraValue.replace("Add ", "");
    paraValue = paraValue.replace("delete ", "");
    paraValue = paraValue.replace("count(", "");
    paraValue = paraValue.replace("drop table ", "");
    paraValue = paraValue.replace("update ", "");
    paraValue = paraValue.replace("truncate ", "");
    paraValue = paraValue.replace("asc(", "");
    paraValue = paraValue.replace("mid(", "");
    paraValue = paraValue.replace("char(", "");
    paraValue = paraValue.replace("xp_cmdshell", "");
    paraValue = paraValue.replace("exec", "");
    paraValue = paraValue.replace("exec master", "");
    paraValue = paraValue.replace("net localgroup administrators", "");
    paraValue = paraValue.replace(" and ", "");
    paraValue = paraValue.replace("net user", "");
    paraValue = paraValue.replace(" or ", "");
    paraValue = paraValue.replace(" &nbsp; ", "");

    paraValue = paraValue.replace(";", "");
    paraValue = paraValue.replace("'", "");
    paraValue = paraValue.replace("&", "");
    paraValue = paraValue.replace("%20", "");
    paraValue = paraValue.replace("--", "");
    paraValue = paraValue.replace("==", "");
    paraValue = paraValue.replace("<", "");
    paraValue = paraValue.replace(">", "");
    paraValue = paraValue.replace("%", "");

    SafeRequest = paraValue;
    return SafeRequest;
}

function AddCarByID(productID, comID, quantity, price, points, pointsDeductible, myCallBack) {
    var result;
    var postData = "{productID:'" + productID + "',comID:'" + comID + "',quantity: '" + quantity + "', price: '" + price + "', points: '" + points + "', pointsDeductible: '" + pointsDeductible + "'}";
    var url = MemberWebSite + "Services/WebService.asmx/AddProductIntoCar";
    $.ajax({
        url: url,
        type: "POST",
        data: postData,
        contentType: "application/json; charset=UTF-8",
        dataType: "json",
        success: function (data) {
            if (typeof CarData != 'undefined')
                CarData = data.d;
            if (typeof myCallBack != 'undefined')
                myCallBack(data.d);
            if (typeof CarChanged != 'undefined')
                CarChanged();
        },
        error: function (f) {
        }
    });
}

function AddMSCarByID(productID, comID, quantity, price, points, pointsDeductible,addType, myCallBack) {
    var result;
    var postData = "{productID:'" + productID + "',comID:'" + comID + "',quantity: '" + quantity + "', price: '" + price + "', points: '" + points + "', pointsDeductible: '" + pointsDeductible + "',addType: '"+addType+"'}";
    var url = MemberWebSite + "Services/WebService.asmx/AddMSProductIntoCar";
    $.ajax({
        url: url,
        type: "POST",
        data: postData,
        contentType: "application/json; charset=UTF-8",
        dataType: "json",
        success: function (data) {
            if (typeof CarData != 'undefined')
                CarData = data.d;
            if (typeof myCallBack != 'undefined')
                myCallBack(data.d);
            if (typeof CarChanged != 'undefined')
                CarChanged();
        },
        error: function (f) {
        }
    });
}

function DeleteOrderProductSubmit(orderDetailID, myCallBack) {
    var postData = "{orderDetailID: '" + orderDetailID + "'}";
    var url = MemberWebSite + "Services/WebService.asmx/DeleteOrderProductSubmit";
    $.ajax({
        url: url,
        type: "POST",
        data: postData,
        contentType: "application/json; charset=UTF-8",
        dataType: "json",
        success: function (data) {
            CarData = data.d;
            myCallBack(data.d);
            CarChanged();
        },
        error: function (f) {
        }
    });
}

function ChangeQuantitySubmit(quantityNum, price, orderDetailID, points, pointsDeductible, myCallBack) {

    var postData = "{quantityNum:'" + quantityNum + "',price: '" + price + "', orderDetailID: '" + orderDetailID + "', points: '" + points + "', pointsDeductible: '" + pointsDeductible + "'}";
    var url = MemberWebSite + "Services/WebService.asmx/ChangeQuantitySubmit";
    $.ajax({
        url: url,
        type: "POST",
        data: postData,
        contentType: "application/json; charset=UTF-8",
        dataType: "json",
        success: function (data) {
            CarData = data.d;
            myCallBack(data.d);
            CarChanged();
        },
        error: function (f) {
        }
    });
    return false;
}

//取得上级网页地址
function GetPageReferX() {
    var tempReferrer = "";
    var tempNow = new Date();
    var tempDate = new Date();
    var tempLocation = "";
    tempDate.setDate(tempDate.getDate() + 30);
    tempLocation = SetPageDataX(window.location, tempLocation);
    if (GetCookie("SavaFirstLocation") == "") {
        SetCookie("SavaFirstLocation", tempLocation, tempDate);
    }
    else {
        tempLocation = GetCookie("SavaFirstLocation");
    }

    try {
        tempReferrer = SetPageDataX(document.referrer, tempReferrer);
        tempReferrer = SetPageDataX(top.document.referrer, tempReferrer);
        tempReferrer = SetPageDataX(window.parent.document.referrer, tempReferrer);
    } catch (e) {
    }
    if (GetCookie("SaveSourceTime") == "") {
        SetCookie("SaveSourceTime", tempNow.toLocaleDateString(), tempDate);
    }
    if (GetCookie("SaveSourceRefer") == "") {
        SetCookie("SaveSourceRefer", tempReferrer, tempDate);
    }
    else {
        tempReferrer = GetCookie("SaveSourceRefer");
    }
    if (tempReferrer == "") tempReferrer = window.location;
    tempReferrer = tempReferrer + "firsturl" + tempLocation;

    //保存至服务器端
    var postData = "{url:'" + tempReferrer + "'}";
    var url = MemberWebSite + "Services/WebService.asmx/SetReferUrl";
    $.ajax({
        url: url,
        type: "POST",
        data: postData,
        contentType: "application/json; charset=UTF-8",
        dataType: "json",
        success: function (data) {
            
        },
        error: function (f) {
        }
    });

    return tempReferrer;
}
function SetPageDataX(dataSource, data) {
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
//存cookie
function SetCookie(name, value, expiry, path, domain, secure) {
    //debugger;
    var nameString = escape(name) + "=" + escape(value);
    var expiryString = (expiry == null) ? "" : " ;expires = " + expiry.toGMTString();
    var pathString = (path == null) ? "" : " ;path = " + path;
    var domainString = (domain == null) ? "" : " ;domain = " + domain;
    var secureString = (secure) ? ";secure" : "";
    document.cookie = nameString + expiryString + pathString + domainString + secureString;
}
//读cookie
function GetCookie(name) {
    var CookieFound = false;
    var start = 0;
    var end = 0;
    var CookieString = document.cookie;
    var i = 0;
    while (i <= CookieString.length) {
        start = i;
        end = start + name.length;
        if (CookieString.substring(start, end) == name) {
            CookieFound = true;
            break;
        }
        i++;
    }
    if (CookieFound) {
        start = end + 1;
        end = CookieString.indexOf(";", start);
        if (end < start)
            end = CookieString.length;
        return unescape(CookieString.substring(start, end));
    }
    return "";
}
function FastBuyProduct(pID, qty, pri, pois) {
    if (qty <= 0) {
        alert("购买件数不能小于1件！"); return;
    }
    if (typeof pois == 'undefined' || pois == "")
        pois = 0;
    AddCarByID(pID, "", qty, pri, pois, 0, function (data) {
        AddProductCount();
        window.location.href = MemberWebSite + "Member/Car.aspx";
    });
}
function AddProductCount() {
    var currentCount = 1;
    if (GetCookie("ProductCount") != "") {
        currentCount = parseInt(GetCookie("ProductCount")) + 1;
    }
    var tempDate = new Date();
    tempDate.setDate(tempDate.getDate() + 1);
    SetCookie("ProductCount", currentCount, null, "/", WebSite.replace("http://www.", "").replace("/", ""));
}
//取得上级网页地址

function VoteHuYou(huyouType, myCallBack) {
    var postData = "{huyouType: '" + huyouType + "'}";
    var url = MemberWebSite + "Services/WebService.asmx/VoteHuYou";
    $.ajax({
        url: url,
        type: "POST",
        data: postData,
        contentType: "application/json; charset=UTF-8",
        dataType: "json",
        success: function (data) {
            if (typeof myCallBack != 'undefined')
                myCallBack(data.d);
        },
        error: function (f) {
        }
    });
}

function GetVoteData(myCallBack) {
    var url = MemberWebSite + "Services/WebService.asmx/GetVoteData";
    $.ajax({
        url: url,
        type: "POST",
        contentType: "application/json; charset=UTF-8",
        dataType: "json",
        success: function (data) {
            if (typeof myCallBack != 'undefined')
                myCallBack(data.d);
        },
        error: function (f) {
        }
    });
}
GetPageReferX();