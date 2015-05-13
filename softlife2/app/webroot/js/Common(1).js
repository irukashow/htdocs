// システム依存


function staff_open(pid) {
    var staff_url = system_top + "xw-user/C101/_staff.aspx?id=" + pid;
    $WOpen(staff_url, "", 1400, 900);
}

function customer_open(pid) {
    var customer_url = system_top + "xw-user/C101/_customer.aspx?id" + pid;
    $WOpen(customer_url, "", 800, 900);
}

function anken_open(pid) {
    var anken_url = system_top + "xw-user/C101/_anken.aspx?id=" + pid;
    $WOpen(staff_url, "", 1400, 900);
}




var dtSyozoku = new Object;
function syozoku_load(uid, async) {
    Loading_Start();

    //set select columns
    var arrCols = new Array;
    arrCols.push("ID");
    arrCols.push("DATE");
    arrCols.push("DATE2");
    arrCols.push("KEY1");
    arrCols.push("PARM1");
    arrCols.push("PARM2");
    //set where values
    var htCols = new Object;
    if (uid) htCols["ID"] = uid;
    //build list
    ajax_list("mm", "M_SYOZOKU", arrCols, htCols, "", async, function (res) {
        if (res["data"].length > 0) {
            for (i = 0; i < res["data"].length; i++) {
                dtSyozoku[res["data"][i]["ID"]] = res["data"][i];
            }
        }
        Loading_Exit();
    });

}








var dtStaff = new Object;
function staff_load(uid, async) {
    Loading_Start();

    //set select columns
    var arrCols = new Array;
    arrCols.push("ID");
    arrCols.push("DATE");
    arrCols.push("DATE2");
    arrCols.push("KEY1");
    arrCols.push("KEY2");
    arrCols.push("KEY3");
    arrCols.push("KEY4");
    arrCols.push("KEY5");
    arrCols.push("KEY6");
    arrCols.push("KEY10");
    arrCols.push("PARM1");
    arrCols.push("PARM2");
    arrCols.push("PARM3");
    arrCols.push("PARM4");
    arrCols.push("PARM5");
    arrCols.push("PARM6");
    arrCols.push("PARM7");
    arrCols.push("PARM8");
    arrCols.push("PARM9");
    arrCols.push("PARM10");
    arrCols.push("PARM11");
    arrCols.push("PARM12");
    arrCols.push("PARM13");
    arrCols.push("PARM14");
    arrCols.push("PARM15");
    arrCols.push("PARM16");
    arrCols.push("PARM17");
    arrCols.push("PARM18");
    arrCols.push("PARM19");
    arrCols.push("PARM20");
    arrCols.push("PARM21");
    arrCols.push("PARM22");
    arrCols.push("PARM23");
    arrCols.push("PARM24");
    arrCols.push("PARM25");
    arrCols.push("PARM26");
    arrCols.push("PARM27");
    arrCols.push("PARM28");
    arrCols.push("PARM29");
    arrCols.push("PARM30");
    arrCols.push("PARM31");
    arrCols.push("PARM32");
    arrCols.push("PARM33");
    arrCols.push("PARM34");
    arrCols.push("PARM35");
    arrCols.push("PARM51");
    arrCols.push("PARM52");
    arrCols.push("PARM53");
    arrCols.push("PARM54");
    arrCols.push("PARM55");
    arrCols.push("PARM56");
    arrCols.push("PARM61");
    arrCols.push("PARM62");
    arrCols.push("PARM63");
    arrCols.push("PARM64");
    arrCols.push("PARM65");
    arrCols.push("PARM66");
    arrCols.push("PARM71");
    arrCols.push("PARM72");
    arrCols.push("PARM73");
    arrCols.push("PARM74");
    arrCols.push("PARM75");
    arrCols.push("PARM76");
    arrCols.push("PARM81");
    arrCols.push("PARM82");
    arrCols.push("PARM83");
    arrCols.push("PARM84");
    arrCols.push("PARM85");
    arrCols.push("PARM86");
    arrCols.push("PARM87");
    arrCols.push("PARM99");
    arrCols.push("PARM100");
    arrCols.push("URL1");
    arrCols.push("URL2");
    //set where values
    var htCols = new Object;
    if (uid) htCols["ID"] = uid;
    //build list
    ajax_list("mm", "M_STAFF", arrCols, htCols, "", async, function (res) {
        if (res["data"].length > 0) {
            for (i = 0; i < res["data"].length; i++) {
                dtStaff[res["data"][i]["ID"]] = res["data"][i];
            }
        }
        Loading_Exit();
    });

}

function staff_eki_list(uid) {
    var arr = new Array;
    if (dtStaff[uid]["PARM53"]) arr.push(dtStaff[uid]["PARM54"] + dtStaff[uid]["PARM56"]);
    if (dtStaff[uid]["PARM63"]) arr.push(dtStaff[uid]["PARM64"] + dtStaff[uid]["PARM66"]);
    if (dtStaff[uid]["PARM73"]) arr.push(dtStaff[uid]["PARM74"] + dtStaff[uid]["PARM76"]);
    return arr;
}

var dtStaff_hyoka = new Object;
function staff_hyoka_load(uid, async) {
    Loading_Start();

    //set select columns
    var arrCols = new Array;
    arrCols.push("ID");
    arrCols.push("KEY1");
    arrCols.push("PARM1");
    arrCols.push("PARM2");
    arrCols.push("PARM3");
    arrCols.push("PARM4");
    arrCols.push("PARM5");
    arrCols.push("PARM6");
    arrCols.push("PARM7");
    arrCols.push("PARM8");
    arrCols.push("PARM9");
    arrCols.push("PARM10");
    arrCols.push("PARM11");
    arrCols.push("PARM12");
    arrCols.push("PARM13");
    arrCols.push("PARM100");
    //set where values
    var htCols = new Object;
    if (uid) htCols["KEY1"] = uid;
    //build list
    ajax_list("mm", "M_STAFF_HYOKA", arrCols, htCols, "", async, function (res) {
        if (res["data"].length > 0) {
            for (i = 0; i < res["data"].length; i++) {
                dtStaff_hyoka[res["data"][i]["KEY1"]] = res["data"][i];
            }
        }
        Loading_Exit();
    });

}

var dtStaff_summary = new Object;
function staff_summary_load(async) {
    Loading_Start();

    //set select columns
    var arrCols = new Array;
    arrCols.push("ID");
    //set where
    var htCols = new Object;
    htCols["KEY10"] = "0";
    //build list
    ajax_list("mm", "M_STAFF", arrCols, false, "", async, function (res) {
        dtStaff_summary = res["data"];
        Loading_Exit();
    });

}

function staff_next(uid) {
    for (i = 0; i < dtStaff_summary.length; i++) {
        if (dtStaff_summary[i]["ID"] == uid) {
            if ((i+1) < dtStaff_summary.length) {
                return dtStaff_summary[i + 1]["ID"];
            } else {
                return dtStaff_summary[0]["ID"];
            }
        }
    }
}

function staff_prev(uid) {
    for (i = 0; i < dtStaff_summary.length; i++) {
        if (dtStaff_summary[i]["ID"] == uid) {
            if (i == 0) {
                return dtStaff_summary[dtStaff_summary.length - 1]["ID"];
            } else {
                return dtStaff_summary[i - 1]["ID"];
            }
        }
    }
}












var dtAdmin = new Object;
function admin_load(uid, async) {
    Loading_Start();

    //set select columns
    var arrCols = new Array;
    arrCols.push("ID");
    arrCols.push("PARM1");
    arrCols.push("PARM2");
    arrCols.push("PARM3");
    arrCols.push("PARM4");
    arrCols.push("PARM10");
    arrCols.push("PARM11");
    arrCols.push("PARM12");
    arrCols.push("PARM13");
    arrCols.push("PARM14");
    //set where values
    var htCols = new Object;
    if (uid) htCols["ID"] = uid;
    //build list
    ajax_list("mm", "AUTH_ADMIN", arrCols, htCols, "", async, function (res) {
        if (res["data"].length > 0) {
            for (i = 0; i < res["data"].length; i++) {
                dtAdmin[res["data"][i]["ID"]] = res["data"][i];
            }
        }
        Loading_Exit();
    });

}




var dtShift = new Object;
function shift_load(async) {
    Loading_Start();

    //set select columns
    var arrCols = new Array;
    arrCols.push("ID");
    arrCols.push("KEY1");
    arrCols.push("KEY2");
    arrCols.push("KEY3");
    arrCols.push("KEY3");
    arrCols.push("KEY4");
    arrCols.push("KEY5");
    arrCols.push("KEY6");
    arrCols.push("KEY8");
    //build list
    ajax_list("dms", "T_SHIFT2", arrCols, false, "KEY8 DESC", async, function (res) {
        dtShift = res["data"];
        Loading_Exit();
    });

}

function shift_count(uid) {
    var cnt = 0;
    for (i = 0; i < dtShift.length; i++) {
        if (dtShift[i]["KEY2"] == uid) {
            cnt++;
        }
    }
    return cnt;
}

function shift_list(uid) {
    var arr = new Array;
    var cnt = 0;
    for (i = 0; i < dtShift.length; i++) {
        if (dtShift[i]["KEY2"] == uid) {
            if (cnt < 3) {
                arr.push(dtShift[i]["PARM1"]);
            } else {
                return arr;
            }
            cnt++;
        }
    }
    return arr;
}

var dtShiftYMD = new Array;
function shift_ymd(st, ex) {
    var st = DateString(st, "yyyyMMdd");
    var ex = DateString(ex, "yyyyMMdd");
    for (i = 0; i < dtShift.length; i++) {
        for (d = parseInt(st); d <= parseInt(ex); d++) {
            if (parseInt(dtShift[i]["KEY8"]) == d) {
                dtShiftYMD.push(dtShift[i]);
            }
        }
    }
}







var dtStaffSyokusyu2 = new Object;
function syokusyu2_load(async) {
    Loading_Start();

    //set select columns
    var arrCols = new Array;
    arrCols.push("ID");
    arrCols.push("KEY1");
    arrCols.push("KEY2");
    //build list
    ajax_list("mm", "M_STAFF_SYOKUSYU2", arrCols, false, "", async, function (res) {
        dtStaffSyokusyu2 = res["data"];
        syokusyu2_masta_load(async);
        Loading_Exit();
    });

}

var dtStaffSyokusyu2_Masta = new Object;
function syokusyu2_masta_load(async) {
    Loading_Start();

    //set select columns
    var arrCols = new Array;
    arrCols.push("ID");
    arrCols.push("PARM1");
    //build list
    ajax_list("mm", "M_ORDER_SELECT_SYOKUSYU", arrCols, false, "", async, function (res) {
        dtStaffSyokusyu2_Masta = res["data"];
        Loading_Exit();
    });

}

function shokusyu_list(uid) {
    var arr = new Array;
    for (i = 0; i < dtStaffSyokusyu2.length; i++) {
        if (dtStaffSyokusyu2[i]["KEY1"] == uid) {
            for (j = 0; j < dtStaffSyokusyu2_Masta.length; j++) {
                if (dtStaffSyokusyu2[i]["KEY2"] == dtStaffSyokusyu2_Masta[j]["ID"]) {
                    arr.push(dtStaffSyokusyu2_Masta[j]["PARM1"]);
                }
            }
        }
    }
    return arr;
}
















var dtCustomer = new Object;
function customer_load(uid, async) {
    Loading_Start();

    //set select columns
    var arrCols = new Array;
    arrCols.push("ID");
    arrCols.push("DATE");
    arrCols.push("DATE2");
    arrCols.push("KEY1");
    arrCols.push("KEY4");
    arrCols.push("KEY5");
    arrCols.push("KEY6");
    arrCols.push("KEY10");
    arrCols.push("PARM1");
    arrCols.push("PARM2");
    arrCols.push("PARM3");
    arrCols.push("PARM4");
    arrCols.push("PARM5");
    arrCols.push("PARM6");
    arrCols.push("PARM11");
    arrCols.push("PARM12");
    arrCols.push("PARM13");
    arrCols.push("PARM14");
    arrCols.push("PARM15");
    arrCols.push("PARM16");
    arrCols.push("PARM17");
    arrCols.push("PARM81");
    arrCols.push("PARM82");
    arrCols.push("PARM83");
    arrCols.push("PARM84");
    arrCols.push("PARM85");
    arrCols.push("PARM86");
    arrCols.push("PARM87");
    //set where values
    var htCols = new Object;
    if (uid) htCols["ID"] = uid;
    //build list
    ajax_list("mm", "M_CUSTOMER", arrCols, htCols, "", async, function (res) {
        if (res["data"].length > 0) {
            for (i = 0; i < res["data"].length; i++) {
                dtCustomer[res["data"][i]["ID"]] = res["data"][i];
            }
        }
        Loading_Exit();
    });

}

var dtCustomer_summary = new Object;
function customer_summary_load(async) {
    Loading_Start();

    //set select columns
    var arrCols = new Array;
    arrCols.push("ID");
    //set where
    var htCols = new Object;
    htCols["KEY10"] = "0";
    //build list
    ajax_list("mm", "M_CUSTOMER", arrCols, htCols, "", async, function (res) {
        dtCustomer_summary = res["data"];
        Loading_Exit();
    });

}

function customer_next(uid) {
    for (i = 0; i < dtCustomer_summary.length; i++) {
        if (dtCustomer_summary[i]["ID"] == uid) {
            if ((i + 1) < dtCustomer_summary.length) {
                return dtCustomer_summary[i + 1]["ID"];
            } else {
                return dtCustomer_summary[0]["ID"];
            }
        }
    }
}

function customer_prev(uid) {
    for (i = 0; i < dtCustomer_summary.length; i++) {
        if (dtCustomer_summary[i]["ID"] == uid) {
            if (i == 0) {
                return dtCustomer_summary[dtCustomer_summary.length - 1]["ID"];
            } else {
                return dtCustomer_summary[i - 1]["ID"];
            }
        }
    }
}








var dtAnken = new Object;
function anken_load(uid, async) {
    Loading_Start();

    //set select columns
    var arrCols = new Array;
    arrCols.push("ID");
    arrCols.push("DATE");
    arrCols.push("DATE2");
    arrCols.push("KEY1");
    arrCols.push("KEY4");
    arrCols.push("KEY5");
    arrCols.push("KEY6");
    arrCols.push("KEY10");
    arrCols.push("PARM1");
    arrCols.push("PARM2");
    arrCols.push("PARM3");
    arrCols.push("PARM4");
    arrCols.push("PARM5");
    arrCols.push("PARM6");
    arrCols.push("PARM11");
    arrCols.push("PARM12");
    arrCols.push("PARM13");
    arrCols.push("PARM14");
    arrCols.push("PARM15");
    arrCols.push("PARM16");
    arrCols.push("PARM17");
    arrCols.push("PARM81");
    arrCols.push("PARM82");
    arrCols.push("PARM83");
    arrCols.push("PARM84");
    arrCols.push("PARM85");
    arrCols.push("PARM86");
    arrCols.push("PARM87");
    //set where values
    var htCols = new Object;
    if (uid) htCols["ID"] = uid;
    //build list
    ajax_list("mm", "M_ANKEN", arrCols, htCols, "", async, function (res) {
        if (res["data"].length > 0) {
            for (i = 0; i < res["data"].length; i++) {
                dtAnken[res["data"][i]["ID"]] = res["data"][i];
            }
        }
        Loading_Exit();
    });

}

var dtAnken_summary = new Object;
function anken_summary_load(async) {
    Loading_Start();

    //set select columns
    var arrCols = new Array;
    arrCols.push("ID");
    //set where
    var htCols = new Object;
    htCols["KEY10"] = "0";
    //build list
    ajax_list("mm", "M_ANKEN", arrCols, htCols, "", async, function (res) {
        dtAnken_summary = res["data"];
        Loading_Exit();
    });

}

function anken_next(uid) {
    for (i = 0; i < dtAnken_summary.length; i++) {
        if (dtAnken_summary[i]["ID"] == uid) {
            if ((i + 1) < dtAnken_summary.length) {
                return dtAnken_summary[i + 1]["ID"];
            } else {
                return dtAnken_summary[0]["ID"];
            }
        }
    }
}

function anken_prev(uid) {
    for (i = 0; i < dtAnken_summary.length; i++) {
        if (dtAnken_summary[i]["ID"] == uid) {
            if (i == 0) {
                return dtAnken_summary[dtAnken_summary.length - 1]["ID"];
            } else {
                return dtAnken_summary[i - 1]["ID"];
            }
        }
    }
}

var dtAnken_jigyosyu = new Object;
function anken_jigyosyu_load(async) {
    Loading_Start();

    //set select columns
    var arrCols = new Array;
    arrCols.push("ID");
    arrCols.push("KEY1");
    arrCols.push("KEY2");
    arrCols.push("KEY3");
    //build list
    ajax_list("mm", "M_ANKEN_JIGYOSYU", arrCols, false, "", async, function (res) {
        if (res["data"].length > 0) {
            for (i = 0; i < res["data"].length; i++) {
                dtAnken_jigyosyu[res["data"][i]["KEY1"]] = res["data"][i];
            }
        }
        Loading_Exit();
    });

}

var dtAnken_Keiyaku = new Object;
function anken_keiyaku_load(async) {
    Loading_Start();

    //set select columns
    var arrCols = new Array;
    arrCols.push("ID");
    arrCols.push("KEY1");
    arrCols.push("KEY2");
    arrCols.push("KEY3");
    //build list
    ajax_list("mm", "M_ANKEN_KEIYAKU", arrCols, false, "", async, function (res) {
        if (res["data"].length > 0) {
            for (i = 0; i < res["data"].length; i++) {
                dtAnken_Keiyaku[res["data"][i]["KEY1"]] = res["data"][i];
            }
        }
        Loading_Exit();
    });

}

















// 共通システム
$(function () {

    // 画面の切替
    //$('body').css({ display: 'block', opacity: '0' }).animate({ opacity: '1' }, 300);
    $('body').css({ display: 'block', opacity: '1' });

    // ヘッダー固定
    $('.headerFix').css({ 'width': '100%', 'zIndex': '1000', 'position': 'fixed', 'top': '0px' });
    var h = String(parseInt($('.headerFix').outerHeight()));
    $('.headerFix').after("<div class='headerFix_CP' style='height:" + h + "px'>&nbsp;</div>");

    // Enterで更新禁止
    $("input").keypress(function (ev) {
        if ((ev.which && ev.which === 13) || (ev.keyCode && ev.keyCode === 13)) {
            return false;
        } else {
            return true;
        }
    });

    // 外部取得ファイルはコンパイルを含め仮読み込み
    $.ajax({
        url: "http://ajax.deprog.jp/post_get.ashx"
            , type: 'POST'
            , cache: false
            , dataType: 'json'
            , async: true
            , data: {
                post1: "569"
                , post2: "0077"
            }
    });

    $.ajax({
        url: "http://ajax.deprog.jp/post_todohuken.ashx"
        , type: 'POST'
        , cache: false
        , dataType: 'json'
        , async: true
    });

});

// event manager
function $addEvent(target, type, func, arg) {
    if (target.addEventListener) {
        if (arg) {
            target.addEventListener(type, (function () { func(arg); }), false);
        } else {
            target.addEventListener(type, func, false);
        }
    } else if (target.attachEvent) {  // IE
        if (arg) {
            target.attachEvent("on" + type, (function () { func(arg); }));
        } else {
            target.attachEvent("on" + type, func);
        }
    } else {
        if (arg) {
            target.onload = (function () { func(arg); });
        } else {
            target.onload = func;
        }
    }
}

function alert_delay(obj) {
    setTimeout(function () { alert(obj); }, 100);
}

// submit control is lock on release
$(function () {
    $("form").submit(function () {
        SubmitRelease();
    });
});

function SubmitRelease() {
    try {
        $("input:disabled").removeAttr("disabled");
        $("select:disabled").removeAttr("disabled");
    } catch (e) { alert_delay(e); }
}

// control finder
function $getObj(ctl) {
    // target control finder
    var allCtl = document.getElementsByTagName("*");
    for (i = 0; i < allCtl.length; i++) {
        if (allCtl[i].id.indexOf(ctl, 0) > -1) {
            // get control
            return allCtl[i];
        }
    }
    // not found
    return false;
}

// Sleep
function $Sleep(ms) {
    var d1 = new Date().getTime();
    var d2 = new Date().getTime();
    while (d2 < (d1 + ms)) {
        d2 = new Date().getTime();
    }
    return;
}

// TimerLink
function $TimerLink(ms, lnk) {
    setTimeout(function () {
        window.top.location.href(lnk);
    }, ms);
}

// WOpen
function $WOpen(url, name, w, h) {
    if (!(w) && !(h)) {
        w = Math.round(screen.width * 0.99);
        h = Math.round(screen.height * 0.95);
        window.open(url, name, 'width=' + String(w) + ', height=' + String(h) + ', left=0, top=0, menubar=no, toolbar=no, scrollbars=yes, location=no, status=no, resizable=yes');
    } else if (!(w)) {
        w = Math.round(screen.width * 0.99);
        window.open(url, name, 'width=' + String(w) + ', height=500, left=0, top=0, menubar=no, toolbar=no, scrollbars=yes, location=no, status=no, resizable=yes');
    } else {
        window.open(url, name, 'width=' + String(w) + ', height=' + String(h) + ', menubar=no, toolbar=no, scrollbars=yes, location=no, status=no, resizable=yes');
    }
}

// WClose
function $WClose() {
    var nvua = navigator.userAgent;
    if (nvua.indexOf('MSIE') >= 0) {
        if (nvua.indexOf('MSIE 5.0') == -1) {
            top.opener = '';
        }
    }
    else if (nvua.indexOf('Gecko') >= 0) {
        top.name = 'CLOSE_WINDOW';
        wid = window.open('', 'CLOSE_WINDOW');
    }
    top.close();
    //(window.open('', '_top').opener = top).close();
    return false;
}

function FindControl(control, name) {
    var namingcontainer = control.id.split("_");
    namingcontainer[namingcontainer.length - 1] = name;
    return document.getElementById(namingcontainer.join("_"));
}

// check date type
function IsDate(text) {
    if ((new Date(text)) === null) return false;
    if ((new Date(text)) == 'NaN') return false;
    if ((new Date(text)) == 'Invalid Date') return false;
    return true;
}
function IsNumber(str) {
    if (str.match(/[^0-9]+/)) {
        return false;
    }
    return true;
}
function IsNumber2(str) {
    if (parseFloat(str)) {
        return true;
    } else {
        return false;
    }
}
function IsMail(str) {
    if (!(str)) {
        return true;
    } else if (!str.match(/^[A-Za-z0-9]+[\w-\.-]+@[\w\.-]+\.\w{2,}$/)) {
        return false;
    }
    return true;
}

// check date type (input type text)
function DateCheck(txtCtl) {
    if (txtCtl.value) {
        if (IsDate(txtCtl.value)) {
            // OK
            return;
        } else {
            alert_delay(msg_parm1);
            setTimeout(function () { txtCtl.focus(); txtCtl.select(); }, 1);
        }
    } else {
        // no input data
        return;
    }
}

// check date type (input type text)
function NumberCheck(txtCtl) {
    if (txtCtl.value) {
        if (IsNumber(txtCtl.value)) {
            // OK
            return true;
        } else {
            alert_delay(msg_parm2);
            setTimeout(function () { txtCtl.focus(); txtCtl.select(); }, 1);
            return false;
        }
    } else {
        // no input data
        return true;
    }
}

// check date type (input type text)
function MailCheck(txtCtl) {
    if (!IsMail(txtCtl.value)) {
        alert_delay(msg_parm3);
        return false;
    } else {
        // OK
        return true;
    }
}



// ContactField
function ContactFieldSendBeforeCheck(tag, arg1, arg2, arg3, arg4, arg5) {
    try {
        var key1 = "required";
        var key2 = "msg";
        var ret = "";
        var tags = document.getElementById(tag).getElementsByTagName("*");

        var grpChk = [];
        var grpMsg = [];

        var scrollRet = false;
        // Validation
        for (i = 0; i < tags.length; i++) {
            if ((tags[i].getAttribute(key1)) && (tags[i].getAttribute(key1) != "")) {
                // Require Check
                if (tags[i].tagName.toUpperCase() == "SPAN") {
                    // radio checkbox
                    var inner = tags[i].getElementsByTagName("*");
                    var flg = false;
                    for (j = 0; j < inner.length; j++) {
                        if (inner[j].getAttribute("type")) {
                            if ((inner[j].getAttribute("type").toUpperCase() == "RADIO") || (inner[j].getAttribute("type").toUpperCase() == "CHECKBOX")) {
                                if (inner[j].checked) { flg = true; break; }
                            }
                        }
                    }
                    if (!(flg)) {
                        switch (msg_lang) {
                            case 'us':
                                ret += msg_parm101 + tags[i].getAttribute(key2) + "\n";
                                break;
                            default:
                                ret += tags[i].getAttribute(key2) + msg_parm101 + "\n";
                                break;
                        }
                        if (!(scrollRet)) { ControlToFocus(tags[i]); scrollRet = true; }
                    }
                } else if (tags[i].tagName.toUpperCase() == "SELECT") {
                    // select
                    if (!(tags[i].value)) {
                        switch (msg_lang) {
                            case 'us':
                                ret += msg_parm101 + tags[i].getAttribute(key2) + "\n";
                                break;
                            default:
                                ret += tags[i].getAttribute(key2) + msg_parm101 + "\n";
                                break;
                        }
                        $(tags[i]).css("backgroundColor", "#fdd").focus(function () { $(this).css("backgroundColor", "#fff"); });
                        if (!(scrollRet)) { ControlToFocus(tags[i]); scrollRet = true; }
                    }
                } else if (tags[i].tagName.toUpperCase() == "INPUT") {
                    // input
                    if (tags[i].getAttribute('type').toUpperCase() == "RADIO") {
                        if (tags[i].checked) {
                            grpChk[tags[i].getAttribute("name")] = true;
                        } else {
                            if (grpChk[tags[i].getAttribute("name")]) {
                                // ok
                            } else {
                                grpChk[tags[i].getAttribute("name")] = false;
                                grpMsg[tags[i].getAttribute("name")] = tags[i].getAttribute(key2);
                            }
                        }

                    } else if (tags[i].getAttribute('type').toUpperCase() == "CHECKBOX") {
                        if (tags[i].checked) {
                            grpChk[tags[i].getAttribute("base_id")] = true;
                        } else {
                            if (grpChk[tags[i].getAttribute("base_id")]) {
                                // ok
                            } else {
                                grpChk[tags[i].getAttribute("base_id")] = false;
                                grpMsg[tags[i].getAttribute("base_id")] = tags[i].getAttribute(key2);
                            }
                        }

                    } else if (!(tags[i].value)) {
                        if (tags[i].getAttribute('type').toUpperCase() == "FILE") {
                            if (!(arg1)) {
                                switch (msg_lang) {
                                    case 'us':
                                        ret += msg_parm102 + tags[i].getAttribute(key2) + "\n";
                                        break;
                                    default:
                                        ret += tags[i].getAttribute(key2) + msg_parm102 + "\n";
                                        break;
                                }
                                $(tags[i]).css("backgroundColor", "#fdd").focus(function () { $(this).css("backgroundColor", "#fff"); });
                                if (!(scrollRet)) { ControlToFocus(tags[i]); scrollRet = true; }
                            }
                        } else {
                            switch (msg_lang) {
                                case 'us':
                                    ret += msg_parm103 + tags[i].getAttribute(key2) + "\n";
                                    break;
                                default:
                                    ret += tags[i].getAttribute(key2) + msg_parm103 + "\n";
                                    break;
                            }
                            $(tags[i]).css("backgroundColor", "#fdd").focus(function () { $(this).css("backgroundColor", "#fff"); });
                            if (!(scrollRet)) { ControlToFocus(tags[i]); scrollRet = true; }
                        }
                    }
                } else if (tags[i].tagName.toUpperCase() == "TEXTAREA") {
                    // textarea
                    if (!(tags[i].value)) {
                        switch (msg_lang) {
                            case 'us':
                                ret += msg_parm103 + tags[i].getAttribute(key2) + "\n";
                                break;
                            default:
                                ret += tags[i].getAttribute(key2) + msg_parm103 + "\n";
                                break;
                        }
                        $(tags[i]).css("backgroundColor", "#fdd").focus(function () { $(this).css("backgroundColor", "#fff"); });
                        if (!(scrollRet)) { ControlToFocus(tags[i]); scrollRet = true; }
                    }
                } else {
                    // continue
                }
            }
        }

        // input [radio / checkbox] check

        for (var grp in grpChk) {
            if (grpChk[grp]) {
            } else {
                switch (msg_lang) {
                    case 'us':
                        ret += msg_parm101 + grpMsg[grp] + "\n";
                        break;
                    default:
                        ret += grpMsg[grp] + msg_parm101 + "\n";
                        break;
                }
            }
        }

        // Result Check
        if (ret) {
            alert_delay(ret);
            return false;
        } else {
            if (ContactFieldSendBeforeValueCheck(tag)) {
                if (ContactFieldSendBeforeMailCheck(tag)) {
                    return ContactFieldSendBeforeNumberCheck(tag);
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }

    } catch (e) {
        alert_delay(e);
        return false;
    }
}

function ContactFieldSendBeforeValueCheck(tag) {
    try {
        var key1 = "checkvalue";
        var key2 = "msg";
        var chkel;
        var chkval = "";
        var chkkey = "";
        var ret = "";
        var tags = document.getElementById(tag).getElementsByTagName("*");
        var scrollRet = false;
        // Validation
        for (keyLen = 0; keyLen < 10; keyLen++) {
            for (i = 0; i < tags.length; i++) {
                if ((tags[i].getAttribute(key1)) && (tags[i].getAttribute(key1) == keyLen.toString())) {
                    // Value Check
                    if (tags[i].tagName.toUpperCase() == "INPUT") {
                        // input
                        if (!(chkval)) {
                            chkel = tags[i];
                            chkval = tags[i].value;
                            chkkey = tags[i].getAttribute(key1);
                        } else if (chkval == tags[i].value) {
                            // OK
                            chkval = "";
                        } else {
                            switch (msg_lang) {
                                case 'us':
                                    ret += msg_parm104 + tags[i].getAttribute(key2) + "\n";
                                    break;
                                default:
                                    ret += tags[i].getAttribute(key2) + msg_parm104 + "\n";
                                    break;
                            }
                            $(chkel).css("backgroundColor", "#fdd").focus(function () { $(this).css("backgroundColor", "#fff"); });
                            $(tags[i]).css("backgroundColor", "#fdd").focus(function () { $(this).css("backgroundColor", "#fff"); });
                            if (!(scrollRet)) { ControlToFocus(tags[i]); scrollRet = true; }
                            chkval = "";
                        }
                    } else {
                        // continue
                    }
                }
            }
        }

        // Result Check
        if (ret) {
            alert_delay(ret);
            return false;
        } else {
            return true;
        }

    } catch (e) {
        alert_delay(e);
        return false;
    }
}

function ContactFieldSendBeforeMailCheck(tag) {
    try {
        var key1 = "mailcheck";
        var key2 = "msg";
        var chkval = "";
        var chkkey = "";
        var ret = "";
        var tags = document.getElementById(tag).getElementsByTagName("*");
        var scrollRet = false;
        // Validation
        for (i = 0; i < tags.length; i++) {
            if ((tags[i].getAttribute(key1)) && (tags[i].getAttribute(key1) == "1")) {
                // Mail Check
                if (tags[i].tagName.toUpperCase() == "INPUT") {
                    // input
                    if (IsMail(tags[i].value)) {
                        // OK
                    } else {
                        switch (msg_lang) {
                            case 'us':
                                ret += msg_parm106 + tags[i].getAttribute(key2) + "\n";
                                break;
                            default:
                                ret += tags[i].getAttribute(key2) + msg_parm106 + "\n";
                                break;
                        }
                        $(tags[i]).css("backgroundColor", "#fdd").focus(function () { $(this).css("backgroundColor", "#fff"); });
                        if (!(scrollRet)) { ControlToFocus(tags[i]); scrollRet = true; }
                    }
                } else {
                    // continue
                }
            }
        }

        // Result Check
        if (ret) {
            alert_delay(ret);
            return false;
        } else {
            return true;
        }

    } catch (e) {
        alert_delay(e);
        return false;
    }
}

function ContactFieldSendBeforeNumberCheck(tag) {
    try {
        var key1 = "numcheck";
        var key2 = "msg";
        var chkval = "";
        var chkkey = "";
        var ret = "";
        var tags = document.getElementById(tag).getElementsByTagName("*");
        var scrollRet = false;
        // Validation
        for (i = 0; i < tags.length; i++) {
            if ((tags[i].getAttribute(key1)) && (tags[i].getAttribute(key1) == "1")) {
                // Mail Check
                if (tags[i].tagName.toUpperCase() == "INPUT") {
                    // input
                    if (IsNumber2(tags[i].value)) {
                        // OK
                    } else if (IsNumber(tags[i].value)) {
                        // OK
                    } else if (!(tags[i].value)) {
                        // OK
                    } else {
                        switch (msg_lang) {
                            case 'us':
                                ret += msg_parm105 + tags[i].getAttribute(key2) + "\n";
                                break;
                            default:
                                ret += tags[i].getAttribute(key2) + msg_parm105 + "\n";
                                break;
                        }
                        $(tags[i]).css("backgroundColor", "#fdd").focus(function () { $(this).css("backgroundColor", "#fff"); });
                        if (!(scrollRet)) { ControlToFocus(tags[i]); scrollRet = true; }
                    }
                } else {
                    // continue
                }
            }
        }

        // Result Check
        if (ret) {
            alert_delay(ret);
            return false;
        } else {
            return true;
        }

    } catch (e) {
        alert_delay(e);
        return false;
    }
}


// CalenderField
var CalenderFieldColor;
function SetCalenderFieldColor(color) {
    CalenderFieldColor = color;
}

function ChangeCalenderField(el, datevalue) {
    if (CalenderFieldColor) {
        if (DeprogWeb) {
            url = location.href.split("/");
            file = url[url.length - 1].split(".");
            DeprogWeb.CalenderField_Update(file[0], datevalue, CalenderFieldColor, (function (ret) {
                // OK
            })
				, (function (err) {
				    // Error
				    alert_delay(err);
				}));
            el.setAttribute('basecolor', CalenderFieldColor);
        } else {
            switch (msg_lang) {
                case 'us':
                    alert_delay(msg_parm301);
                    break;
                default:
                    alert_delay(msg_parm301);
                    break;
            }
        }
    } else {
        switch (msg_lang) {
            case 'us':
                alert_delay(msg_parm302);
                break;
            default:
                alert_delay(msg_parm302);
                break;
        }
    }
}



// Target Focus And Scroll
function ControlToFocus(ctl) {
    //Focus
    ctl.focus();
    //Scroll
    var t = parseInt(GetTop(ctl));
    window.scrollTo(0, (t + 30));
    if (t > 150) {
        window.scrollTo(0, (t - 150));
    } else {
        window.scrollTo(0, 0);
    }
}

// Get Control Position Left 
function GetLeft(oj) {
    return $(oj).offset().left;
}

// Get Control Position Top
function GetTop(oj) {
    return $(oj).offset().top;
}

// Get Control Heigth
function GetHeight(oj) {
    return $(oj).height();
}

// Get Control Width
function GetWidth(oj) {
    return $(oj).width();
}

// Set Control Position Left 
function SetLeft(oj, val) {
    $(oj).offset({ top: GetTop(oj), left: val });
}

// Set Control Position Top
function SetTop(oj, val) {
    $(oj).offset({ top: val, left: GetLeft(oj) });
}

// Set Control Heigth
function SetHeight(oj, val) {
    $(oj).height(val);
}

// Set Control Width
function SetWidth(oj, val) {
    $(oj).width(val);
}

// Set Position
function SetPosition(oj, left, top) {
    $(oj).offset({ top: top, left: left });
}

// Inputed is Convert To Date
function ConvertDate(txt) {
    try {
        var date = new Date();
        var txtDate = txt.value.split("/");
        if (txt.value) {
            if (txtDate.length == 3) {
                date = new Date(txt.value);
                if (!(IsDate(date))) return false;
                var m = (date.getMonth() + 1).toString();
                var d = date.getDate().toString();
                if (m.length == 1) m = '0' + m;
                if (d.length == 1) d = '0' + d;
                txt.value = date.getFullYear().toString() + '/' + m + '/' + d;
                return true;
            } else if (txtDate.length == 2) {
                date = new Date((new Date()).getFullYear().toString() + '/' + txt.value);
                if (!(IsDate(date))) return false;
                var m = (date.getMonth() + 1).toString();
                var d = date.getDate().toString();
                if (m.length == 1) m = '0' + m;
                if (d.length == 1) d = '0' + d;
                txt.value = date.getFullYear().toString() + '/' + m + '/' + d;
                return true;
            } else if (txtDate.length == 1) {
                date = new Date((new Date()).getFullYear().toString() + '/' + ((new Date()).getMonth() + 1).toString() + '/' + txt.value);
                if (!(IsDate(date))) return false;
                if (date.getMonth() != (new Date()).getMonth()) return false;
                var m = (date.getMonth() + 1).toString();
                var d = date.getDate().toString();
                if (m.length == 1) m = '0' + m;
                if (d.length == 1) d = '0' + d;
                txt.value = date.getFullYear().toString() + '/' + m + '/' + d;
                return true;
            } else {
                // 日付以外のデータ
                return false;
            }
        }
    } catch (e) { return false; }
}

// Inputed is Convert To Date
function ConvertDate2(txtvalue) {
    try {
        var date = new Date();
        var txtDate = txtvalue.split("/");
        if (txtvalue) {
            if (txtDate.length == 3) {
                date = new Date(txtvalue);
                if (!(IsDate(date))) return false;
                var m = (date.getMonth() + 1).toString();
                var d = date.getDate().toString();
                if (m.length == 1) m = '0' + m;
                if (d.length == 1) d = '0' + d;
                return date.getFullYear().toString() + '/' + m + '/' + d;
            } else if (txtDate.length == 2) {
                date = new Date((new Date()).getFullYear().toString() + '/' + txtvalue);
                if (!(IsDate(date))) return false;
                var m = (date.getMonth() + 1).toString();
                var d = date.getDate().toString();
                if (m.length == 1) m = '0' + m;
                if (d.length == 1) d = '0' + d;
                return date.getFullYear().toString() + '/' + m + '/' + d;
            } else if (txtDate.length == 1) {
                date = new Date((new Date()).getFullYear().toString() + '/' + ((new Date()).getMonth() + 1).toString() + '/' + txtvalue);
                if (!(IsDate(date))) return false;
                if (date.getMonth() != (new Date()).getMonth()) return false;
                var m = (date.getMonth() + 1).toString();
                var d = date.getDate().toString();
                if (m.length == 1) m = '0' + m;
                if (d.length == 1) d = '0' + d;
                return date.getFullYear().toString() + '/' + m + '/' + d;
            } else {
                // 日付以外のデータ
                return '';
            }
        }
    } catch (e) { return ''; }
}

// Set Value All Control
function SetValue(ctl, val) {
    var ret = '';
    try {
        //JQueryに変換
        if (ctl.tagName) ctl = $(ctl);

        //タグに応じた取得方法
        if (ctl) {
            switch (ctl[0].tagName.toUpperCase()) {
                case "DIV":
                case "SPAN":
                    if (ctl.find("input").length > 0) {
                        ctl.find("input").each(function () {
                            switch ($(this).attr("type").toUpperCase()) {
                                case "RADIO":
                                    if ($(this).val() == val) {
                                        $(this).prop("checked", true);
                                    }
                                    break;

                                case "CHECKBOX":
                                    var vals = val.split(",");
                                    $("input[name='" + ctl.attr("name") + "']").each(function () {
                                        $(this).prop("checked", false);
                                        for (i = 0; i < vals.length; i++) {
                                            if ($(this).val() == vals[i]) {
                                                $(this).prop("checked", true);
                                            }
                                        }
                                    });
                                    break;

                                default:
                                    break;
                            }
                        });
                    } else {
                        ctl.html(val);
                    }
                    break;

                case "A":
                    ctl.html(val);
                    break;

                case "INPUT":
                    switch (ctl.attr("type").toUpperCase()) {
                        case "RADIO":
                            $("input[name='" + ctl.attr("name") + "']").each(function () {
                                if ($(this).val() == val) {
                                    $(this).prop("checked", true);
                                } else {
                                    $(this).prop("checked", false);
                                }
                            });
                            break;

                        case "CHECKBOX":
                            var vals = val.split(",");
                            $("input[name='" + ctl.attr("name") + "']").each(function () {
                                $(this).prop("checked", false);
                                for (i = 0; i < vals.length; i++) {
                                    if ($(this).val() == vals[i]) {
                                        $(this).prop("checked", true);
                                    }
                                }
                            });
                            break;

                        default:
                            ctl.val(val);
                            break;
                    }
                    break;

                case "TEXTAREA":
                    ctl.val(val);
                    break;

                case "SELECT":
                    if (ctl.attr("class").indexOf("select2-offscreen") > -1) {
                        ctl.val(val);
                        ctl.select2();
                    } else {
                        ctl.val(val);
                    }
                    break;

            }
        }

    } catch (e) {
        alert(e);
    }

    return true;
}

function GetValue(ctl) {
    var ret = '';

    try {

        //JQueryに変換
        if (ctl.tagName) ctl = $(ctl);

        //タグに応じた取得方法
        if (ctl) {
            switch (ctl[0].tagName.toUpperCase()) {
                case "DIV":
                case "SPAN":
                    if (ctl.find("input").length > 0) {
                        ctl.find("input").each(function () {
                            switch ($(this).attr("type").toUpperCase()) {
                                case "RADIO":
                                    if ($(this).prop("checked")) {
                                        ret = $(this).val();
                                    }
                                    break;
                                case "CHECKBOX":
                                    if ($(this).prop("checked")) {
                                        if (ret) ret += ",";
                                        ret += $(this).val();
                                    }
                                    break;
                                default:
                                    break;
                            }
                        });
                    } else {
                        ret = ctl.html();
                    }
                    break;

                case "A":
                    ret = ctl.html();
                    break;

                case "INPUT":
                    switch (ctl.attr("type").toUpperCase()) {
                        case "RADIO":
                            $("input[name='" + ctl.attr("name") + "']").each(function () {
                                if ($(this).prop("checked")) {
                                    ret = $(this).val();
                                }
                            });
                            break;

                        case "CHECKBOX":
                            $("input[name='" + ctl.attr("name") + "']").each(function () {
                                if ($(this).prop("checked")) {
                                    if (ret) ret += ",";
                                    ret += $(this).val();
                                }
                            });
                            break;

                        default:
                            ret = ctl.val();
                            break;
                    }
                    break;

                case "TEXTAREA":
                    ret = ctl.val();
                    break;

                case "SELECT":
                    ret = ctl.val();
                    break;

            }

        }
    
    } catch (e) {
        alert(e);
    }

    return ret;
}

function NumberCommaSplit(str) {
    var num = new String(str).replace(/,/g, "");
    while (num != (num = num.replace(/^(-?\d+)(\d{3})/, "$1,$2")));
    return num;
}

function ToDay() {
    myDate = new Date();
    theDate = myDate.getDate();
    theFyear = myDate.getFullYear();
    theYear = myDate.getYear(); theMonth = myDate.getMonth() + 1;
    return theFyear + "/" + theMonth + "/" + theDate;
}

function MonthAdd(d, n) {
    if (IsDate(d)) {
        var nd = new Date(d);
        nd.setMonth(nd.getMonth() + n);
        return nd;
    } else {
        return d;
    }
}

function GetBirthday(datevalue) {
    var d1 = datevalue;
    if (IsDate(datevalue)) d1 = DateString(datevalue, "yyyyMMdd");
    var d2 = DateString(ToDay(), "yyyyMMdd");
    try {
        if (d1) {
            d1 = parseInt(d1);
            d2 = parseInt(d2);
            return parseInt((d2 - d1) / 10000);
        }
    } catch (e) {
        return 0;
    }
}

function DateString(date, format) {
    if (IsDate(date)) {
        date = new Date(date);
        if (!format) format = 'yyyy-MM-dd hh:mm:ss.fs';
        format = format.replace(/yyyy/g, date.getFullYear());
        format = format.replace(/MM/g, ('0' + (date.getMonth() + 1)).slice(-2));
        format = format.replace(/dd/g, ('0' + date.getDate()).slice(-2));
        format = format.replace(/hh/g, ('0' + date.getHours()).slice(-2));
        format = format.replace(/mm/g, ('0' + date.getMinutes()).slice(-2));
        format = format.replace(/ss/g, ('0' + date.getSeconds()).slice(-2));
        if (format.match(/fs/g)) {
            var milliSeconds = ('00' + date.getMilliseconds()).slice(-3);
            var length = format.match(/fs/g).length;
            for (var i = 0; i < length; i++) format = format.replace(/S/, milliSeconds.substring(i, i + 1));
        }
        return format;
    } else {
        return date;
    }
}

//set language
var msg_lang = "ja";
var msg_parm1 = "";
var msg_parm2 = "";
var msg_parm3 = "";
var msg_parm101 = "";
var msg_parm102 = "";
var msg_parm103 = "";
var msg_parm104 = "";
var msg_parm105 = "";
var msg_parm301 = "";
var msg_parm302 = "";
$(function () {
    //get lang
    try {
        var s = document.getElementsByTagName("script");
        for (var srcX = 0; srcX < s.length; srcX++) {
            if (s[srcX]) {
                var src = s[srcX].getAttribute("src");
                if (src) {
                    if (src.indexOf("?") > 0) {
                        src = src.substring(src.indexOf("?") + 1);
                        if (src.indexOf("&") > 0) {
                            var q = src.split("&");
                            for (var i = 0; i < q.length; i++) {
                                if (q[i].split("=")[0] == "set_language") {
                                    if (q[i].split("=")[1]) {
                                        msg_lang = q[i].split("=")[1];
                                    }
                                }
                            }
                        } else {
                            if (src.split("=")[0] == "set_language") {
                                msg_lang = src.split("=")[1];
                            }
                        }
                    }
                    if (msg_lang) break;
                }
            }
        }
    } catch (e) {
        alert_delay(e);
    }
    //charset
    switch (msg_lang) {
        case 'us':
            msg_parm1 = 'Please provide date format.\nEX：2000/1/1';
            msg_parm2 = 'Please provide number format.\nEX：0123456789';
            msg_parm3 = 'Please provide e-mail address format.\nEX：abc@sample.co.jp';
            msg_parm101 = 'Please select ';
            msg_parm102 = 'Please attach ';
            msg_parm103 = 'Please provide ';
            msg_parm104 = 'Please provide again ';
            msg_parm105 = 'Please provide number format ';
            msg_parm106 = 'Please provide e-mail address format [EX：abc@sample.co.jp]';
            msg_parm301 = 'This function cannot be used.\nPlease ask an administrator.';
            msg_parm302 = 'Please choose contents to change from the above.';
            break;
        default:
            //japanese
            msg_parm1 = '日付型で入力して下さい。\n例：2000/1/1';
            msg_parm2 = '数値型で入力して下さい。\n例：0123456789';
            msg_parm3 = 'Mailアドレスを正しく入力して下さい。\n例：abc@sample.co.jp';
            msg_parm101 = 'を選択してください。';
            msg_parm102 = 'ファイルを選択してください。';
            msg_parm103 = 'を入力してください。';
            msg_parm104 = 'を確認してください。';
            msg_parm105 = 'を数値で入力してください。[例：01234]';
            msg_parm106 = 'をメールアドレスで入力してください。[例：abc@sample.co.jp]';
            msg_parm301 = 'この機能をご利用できません。管理者にお問い合わせください。';
            msg_parm302 = '上記より変更したい内容を選択してください。';
            break;
    }
});

// Auto Image Opacity
$(function () {
    // [A] tags all
    var atags = document.getElementsByTagName('a');
    for (i = 0; i < atags.length; i++) {
        var imgs = atags[i].getElementsByTagName('img');
        if (atags[i].getAttribute("noalpha") === null) {
            // focus
            if (imgs.length > 0) {
                $(atags[i]).focus(function () { $(this).blur(); });
            }
            // mouseevent
            for (j = 0; j < imgs.length; j++) {
                $(atags[i]).hover(
                    function () {
                        // mouseover
                        $(this).css({ "opacity": "0.7" });
                    }
                    , function () {
                        // mouseout
                        $(this).css({ "opacity": "1" });
                    }
                );
            }
        }
    }
    // [input][image] tags all
    var inputtags = document.getElementsByTagName('input');
    for (i = 0; i < inputtags.length; i++) {
        if (inputtags[i].getAttribute("type")) {
            if (inputtags[i].getAttribute("type").toUpperCase() == "IMAGE") {
                // focus
                $(inputtags[i]).focus(function () { $(this).blur(); });
                // mouseover
                $(inputtags[i]).hover(
                    function () {
                        // mouseover
                        $(this).css({ "opacity": "0.7" });
                    }
                    , function () {
                        // mouseout
                        $(this).css({ "opacity": "1" });
                    }
                );
            }
        }
    }
});

// watch
$(function () {
    // function
    var wf = (function (obj) {
        if (obj) {
            now = new Date();
            year = now.getYear();
            month = now.getMonth() + 1;
            day = now.getDate();
            hour = now.getHours();
            minute = now.getMinutes();
            second = now.getSeconds();
            if (year < 1000) { year += 1900 }
            if (hour < 10) { hour = '0' + hour }
            if (minute < 10) { minute = '0' + minute }
            if (second < 10) { second = '0' + second }
            if (obj.tagName.toUpperCase() == "SPAN") {
                obj.innerHTML = year + '/' + month + '/' + day + '  ' + hour + ':' + minute + ':' + second;
            } else if (obj.tagName.toUpperCase() == "DIV") {
                obj.innerHTML = year + '/' + month + '/' + day + '  ' + hour + ':' + minute + ':' + second;
            } else if (obj.tagName.toUpperCase() == "INPUT") {
                obj.value = year + '/' + month + '/' + day + '  ' + hour + ':' + minute + ':' + second;
            } else {
            }
            setTimeout(function () { wf(obj); }, 1000);
        }
    });
    // tags all
    var tags = document.getElementsByTagName('*');
    for (i = 0; i < tags.length; i++) {
        if (!(tags[i].getAttribute("watch") === null)) {
            wf(tags[i]);
        }
    }
});

// Auto Expand [set event]
$(function () {
    try {
        for (expandI = 2; expandI < 10; expandI++) {
            AutoExpand(String(expandI));
        }
    } catch (e) { }
});

// Auto Expand
function AutoExpand(num) {
    $('#pand' + num).click(function (ev) {
        if ($('#targ' + num).is(':hidden')) $('#targ' + num).slideDown('fast');
        else $('#targ' + num).slideUp('fast');
    });
    if ($('#pand' + num).attr("open")) {
        //Open
    } else {
        //Close
        $('#targ' + num).hide();
    }
}

/************
jQuery Support
************/
// ButtonUI PostBack
function ButtonUI(instance) {
    SubmitRelease();
    __doPostBack(instance, '');
}

$(function () {
    //button
    $ButtonUI();
    //buttonset
    $ButtonsetUI();
    //radio
    $Radio();
    //radio list
    $RadioListUI();
    //check
    $Check();
    //check list
    $CheckListUI();
    //date
    $DateUI();
    //time
    $TimeUI();
    //select
    $SelectUI();
    //picture
    $PictureUI();
    //list table
    $TableUI();
    // テキスト (必須時の内容をwatermark [title属性を透かし表示]）
    $Watermark()
    //balloon
    $Balloon();
    //scrollbar
    $Scrollbar();
});


function $ButtonUI() {
    //$(".buttonUI").button().click(function (event) { event.preventDefault(); });
    $(".buttonUI").button();
    $(".buttonUI[disabled='disabled']").each(function (i) {
        $(this).button('disable').removeAttr("onclick");
    });
    $(".buttonUI[active='1']").each(function (i) {
        $(this).addClass("ui-state-active").hover(function () { $(this).addClass("ui-state-active"); }, function () { $(this).addClass("ui-state-active"); });
    });
}

function $ButtonsetUI() {
    $(".buttonsetUI").buttonset();
    $(".ui-buttonset").find(".ui-button").css("margin-right", "-.6em");
    $(".ui-buttonset").find(".ui-button[disabled='disabled']").each(function (i) {
        $(this).button('disable').removeAttr("onclick");
    });
    $(".ui-buttonset").find(".ui-button[active='1']").each(function (i) {
        $(this).addClass("ui-state-active").hover(function () { $(this).addClass("ui-state-active"); }, function () { $(this).addClass("ui-state-active"); });
    });
}

function $Radio() {
    $(".Radio").button();
}

function $RadioListUI() {
    $(".RadioListUI").buttonset();
    $(".ui-buttonset").find(".ui-button").css("margin-right", "-.6em");
    $(".ui-buttonset").find(".ui-button[disabled='disabled']").each(function (i) {
        $(this).button('disable').removeAttr("onclick");
    });
    $(".ui-buttonset").find(".ui-button[active='1']").each(function (i) {
        $(this).addClass("ui-state-active").hover(function () { $(this).addClass("ui-state-active"); }, function () { $(this).addClass("ui-state-active"); });
    });
}

function $Check() {
    $(".Check").button();
}

function $CheckListUI() {
    $(".CheckListUI").button();
}

function $DateUI() {
    $(".dateUI").each(function (i) {
        $(this).datepicker({
            showButtonPanel: true,
            selectOtherMonths: true,
            changeMonth: true,
            changeYear: true,
            yearRange: ($(this).attr("yearRange")) ? $(this).attr("yearRange") : String((new Date()).getFullYear() - 5) + ':' + String((new Date()).getFullYear() + 5),
            dateFormat: 'yy/mm/dd',

            defaultDate: ($(this).attr("defaultDate")) ? $(this).attr("defaultDate") : null,
            showOn: "button",
            buttonText: ($(this).attr("buttonText")) ? $(this).attr("buttonText") : "...",
            buttonImage: $(this).attr("buttonImage"),
            buttonImageOnly: true,

            onSelect: function (dateText, inst) {
                if ($(this).attr("birthdisp")) {
                    SetValue(document.getElementById($(this).attr("birthdisp")), GetBirthday(dateText));
                }
                if ($(this).attr("onSelect")) {
                    eval($(this).attr("onSelect"));
                }
            }
        });

        if ($(this).attr("birthdisp")) {
            if ($(this).val()) {
                SetValue(document.getElementById($(this).attr("birthdisp")), GetBirthday($(this).val()));
            }
        }

    });
}

function $TimeUI() {
    $(".timeUI").each(function (i) {
        var timeID = $(this).attr("id");
        if (timeID) {
            //timepicker
            $('#' + timeID).timepicker({
                showOn: 'button',
                button: $('.' + timeID),
                showLeadingZero: true,
                timeSeparator: ':'
            }).css({
                "backgroundColor": "rgb(235, 235, 228)"
                , "color": "rgb(84, 84, 84)"
                , "borderWidth": "1px"
                , "borderStyle": "solid"
                , "borderColor": "#aaa"
                , "marginRight": "0px"
                , "position": "relative"
            });
            //layout
            $("." + timeID).css(
            {
                "width": "16px"
                , "height": "16px"
                , "display": "inline-block"
                , "borderRadius": "2px"
                , "MozBorderRadius": "2px"
                , "WebkitBorderRadius": "2px"
                , "borderWidth": "1px"
                , "borderStyle": "solid"
                , "borderColor": "#222222"
                , "marginTop": "2px"
                , "cursor": "pointer"
                , "position": "relative"
                , "top": "3px"
                , "left": "-2px"
            });
        }
    });
}

function $SelectUI() {
    $(".selectUI").each(function (i) {
        if ($(this).attr("msg")) {
            if (!($(this).attr("placeholder"))) {
                $(this).attr("placeholder", "必須：" + $(this).attr("msg"));
            }
        }
        $(this).select2({
            placeholder: ($(this).attr("placeholder")) ? $(this).attr("placeholder") : "選択してください",
            allowClear: true
        });
    });
}

function $PictureUI() {
    $(".pictureUI").fancybox({
        'transitionIn': 'elastic',
        'transitionOut': 'elastic',
        'titlePosition': 'over',
        'titleFormat': function (title, currentArray, currentIndex, currentOpts) {
            return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
        }
    });
}

function $TableUI() {
    $(".tableUI thead input").each(function (i) {
        this.initVal = this.value;
    });
    $(".tableUI thead input").focus(function () {
        if (this.className == "search_init") {
            this.className = "";
            this.value = "";
        }
    });
    $(".tableUI thead input").blur(function (i) {
        if (this.value == "") {
            this.className = "search_init";
            this.value = this.initVal;
        }
    });
}

function $Balloon() {
    $(".balloon").balloon({
        position: "bottom"
        , offsetX: 0
        , offsetY: 10
        , minLifetime: 0
        , tipSize: 10
        , showDuration: 100
        , hideDuration: 100
        //, showAnimation: function (d) { this.fadeIn(d); }
        //, hideAnimation: function (d) { this.slideUp(d); }
        , css: {
            fontSize: '80%'
            , color: '#f33'
        }
    });
}

function $Scrollbar() {
    $(".scrollbar").mCustomScrollbar({
        theme: "rounded-dots-dark"
        , axis: "y"
        , scrollbarPosition: "inside"
        , alwaysShowScrollbar: 1
        , axis: "y"
        , axis: "y"
    });
}

function $Watermark() {
    var userAgent = window.navigator.userAgent.toLowerCase();
    var appVersion = window.navigator.appVersion.toLowerCase();
    Watermark_Base();
}

/*   Watermark for base */
function Watermark_Base() {
    // set type[text]
    $(":text").each(function (i) {
        if ($(this).attr("msg")) {
            if ($(this).attr("title")) {
                //ok
                $(this).attr("placeholder", $(this).attr("title"));
            } else {
                if ($(this).attr("disabled")) {
                    //ok
                } else {
                    switch (msg_lang) {
                        case 'us':
                            $(this).attr("placeholder", "Required：" + $(this).attr("msg"));
                            break;
                        default:
                            $(this).attr("placeholder", "必須：" + $(this).attr("msg"));
                            break;
                    }
                }
            }
        }
    });

    // set type[password]
    $(":password").each(function (i) {
        if ($(this).attr("msg")) {
            if ($(this).attr("title")) {
                //ok
                $(this).attr("placeholder", $(this).attr("title"));
            } else {
                if ($(this).attr("disabled")) {
                    //ok
                } else {
                    switch (msg_lang) {
                        case 'us':
                            $(this).attr("placeholder", "Required：" + $(this).attr("msg"));
                            break;
                        default:
                            $(this).attr("placeholder", "必須：" + $(this).attr("msg"));
                            break;
                    }
                }
            }
        }
    });

    // set textarea 
    $("textarea").each(function (i) {
        if ($(this).attr("msg")) {
            if ($(this).attr("title")) {
                //ok
                $(this).attr("placeholder", $(this).attr("title"));
            } else {
                switch (msg_lang) {
                    case 'us':
                        $(this).attr("placeholder", "Required：" + $(this).attr("msg"));
                        break;
                    default:
                        $(this).attr("placeholder", "必須：" + $(this).attr("msg"));
                        break;
                }
            }
        }
    });

}


/************
AJAX Support
************/
// PostSearch
$(function () {
    $("#txtParm41").keyup(function () { GetAddress(); });
    $("#txtParm42").keyup(function () { GetAddress(); });
});

function GetAddress() {
    var p1 = $("#txtParm41").val();
    var p2 = $("#txtParm42").val();
    if ((p1 + p2).length == 7) {
        $.ajax({
            url: "http://ajax.deprog.jp/post_get.ashx"
            , type: 'POST'
            , cache: false
            , dataType: 'json'
            , data: {
                post1: p1
                , post2: p2
            }
            , success: function (res) {
                if (res["result"] == "success") {
                    SetValue($("#txtParm43"), res["parm1"]);
                    SetValue($("#txtParm44"), res["parm2"]);
                    SetValue($("#txtParm45"), res["parm3"]);
                    $("#txtParm46").focus();
                }
            }
        });
    }
}

function GetAddress_Set(obj1, obj2, r1, r2, r3, r4) {
    obj1.keyup(function () { GetAddress_Get(obj1, obj2, r1, r2, r3, r4); });
    obj2.keyup(function () { GetAddress_Get(obj1, obj2, r1, r2, r3, r4); });
}

function GetAddress_Get(obj1, obj2, r1, r2, r3, r4) {
    var p1 = obj1.val();
    var p2 = obj2.val();
    if ((p1 + p2).length == 7) {
        $.ajax({
            url: "http://ajax.deprog.jp/post_get.ashx"
            , type: 'POST'
            , cache: false
            , dataType: 'json'
            , data: {
                post1: p1
                , post2: p2
            }
            , success: function (res) {
                if (res["result"] == "success") {
                    r1.val(res["parm1"]);
                    r2.val(res["parm2"]);
                    r3.val(res["parm3"]);
                    r4.focus();
                }
            }
        });
    }
}

/************
MaterPage Support
************/
function Update() {
    opener.$('#btnReload').click();
    $WClose();
}

function Loading_Start() {
    $("#lock").show();
}

function Loading_Exit() {
    $("#lock").hide();
}

/************
PaypalManager Support
************/
$(function () {
    $(".PaypalManager").each(function (i) {
        $(this).attr("name", $(this).attr("id"));
    });
    if ($(".PaypalManager").length > 0) {
        document.forms[0].action = "https://www.paypal.com/j1/cgi-bin/webscr";
        document.forms[0].submit();
    }
});

/************
Browser Support
************/
function Browser() {
    var ua = {};
    ua.name = window.navigator.userAgent.toLowerCase();
    ua.isIE = (ua.name.indexOf('msie') >= 0 || ua.name.indexOf('trident') >= 0);
    ua.isiPhone = ua.name.indexOf('iphone') >= 0;
    ua.isiPod = ua.name.indexOf('ipod') >= 0;
    ua.isiPad = ua.name.indexOf('ipad') >= 0;
    ua.isiOS = (ua.isiPhone || ua.isiPod || ua.isiPad);
    ua.isAndroid = ua.name.indexOf('android') >= 0;
    ua.isTablet = (ua.isiPad || (ua.isAndroid && ua.name.indexOf('mobile') < 0));
    if (ua.isIE) {
        ua.verArray = /(msie|rv:?)\s?([0-9]{1,})([\.0-9]{1,})/.exec(ua.name);
        if (ua.verArray) {
            ua.ver = parseInt(ua.verArray[2], 10);
        }
    }
    if (ua.isiOS) {
        ua.verArray = /(os)\s([0-9]{1,})([\_0-9]{1,})/.exec(ua.name);
        if (ua.verArray) {
            ua.ver = parseInt(ua.verArray[2], 10);
        }
    }
    if (ua.isAndroid) {
        ua.verArray = /(android)\s([0-9]{1,})([\.0-9]{1,})/.exec(ua.name);
        if (ua.verArray) {
            ua.ver = parseInt(ua.verArray[2], 10);
        }
    }

    return ua;
}

