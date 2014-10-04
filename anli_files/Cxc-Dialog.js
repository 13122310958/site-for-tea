function CxcDialog(Title, Content, Statustion) {
    var DialogBox = "<div class='cxc_Mobile' id='Cxc_Dialog'>" +
    "<div class='cxc_dialog'>" +
    "<div class='cxc_dialog_filt'>" +
    "<div class='cxc_dialog_bd'>" +
    "<div class='cxc_top'><p id='Cxc_Mobile' onmousedown='MoveDiv(Cxc_Dialog,event);'>" + Title + "</p><span onclick='CxcClose()'>x</span></div>" +
    "<p class='cxc_bd " + Statustion + "'>" + Content + "</p>" +
    "<p class='cxc_ft'><span class='img'  onclick='CxcClose()'></span></p>" +
    "</div>" +
    "</div>" +
    "</div>" +
    "</div><div class='Masklayer' id='Masklayer'></div>";
    $("body").append(DialogBox);
}

function CxcClose() {
    $("#Cxc_Dialog").remove();
    $("#Masklayer").remove();
}