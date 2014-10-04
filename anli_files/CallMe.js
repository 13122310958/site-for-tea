function IsCallChecked() {
    var lx = "call";
    var textid = "商务通弹出立即呼我留言";
    var textPhone = $("#textPhone").val();
    if (textPhone == "") {
        CxcDialog('绿瘦提示', '请输入立即呼我联系方式!', 'Warning');
        $("#textPhone").focus();
        return false;
    }
    if (textPhone.length != 11) {
        CxcDialog('绿瘦提示', '立即呼我联系方式必须是11位数!', 'Warning');
        $("#textPhone").focus();
        return false;
    }
    $.ajax({
        url: WebSite + "Services/WebService.asmx/AddLeaveMessage",
        type: "Post",
        data: "{phone:'" + textPhone + "',content:'" + textid + "',type:'"+lx+"'}",
        contentType: "application/json;",
        dataType: "json",
        success: function (data) {
            var rel = data.d;
            if (rel > 0) {
                CxcDialog('绿瘦提示', '瘦身顾问会尽快与您联系!', 'OK');
                $("#textPhone").val("");
                $("#textPhone").focus();
            }
            else if (rel == "-2") {
                CxcDialog('绿瘦提示', '一天一个IP只可以提交2次!', 'Warning');
                $("#textPhone").val("");
                $("#textPhone").focus();
            }
        },
        error: function (err) {
            CxcDialog('绿瘦提示', '立即呼我联系方式提交失败!', 'Error');
            $("#textPhone").val("");
            $("#textPhone").focus();
        }
    });
}