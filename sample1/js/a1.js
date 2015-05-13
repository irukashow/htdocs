//selSyozoku

/***
テーブル関係の設定
***/
var oTable1;
var oTable2;
$(function () {

    //masta loading
    staff_load('', false);
    admin_load('', false);
    shift_load(false);
    syokusyu2_load(false);

    /** 
    oTable1
    **/
    // setting
    var parm1_w = "(CAST(ISNULL(DATE, '') AS NVARCHAR) + ISNULL(PARM1, '') + ISNULL(PARM2, '') + ISNULL(PARM3, '') + ISNULL(PARM4, ''))";
    var parm9_w = "( CAST(CONVERT(nvarchar(8), GETDATE(), 112) as int) - ISNULL(PARM10, CAST(CONVERT(nvarchar(8), GETDATE(), 112) as int)) ) / 10000";

    var parms = new Array;
    /* 0*/parms.push({ title: "ID", sCol: "ID", sType: "numeric", sInit: "", bVisible: false });
    /* 1*/parms.push({ title: "KEY10", sCol: "KEY10", sType: "numeric", sInit: "0", bVisible: false });
    /* 2*/parms.push({ title: "-", width: "50%", sCol: "DUMMY", bVisible: true });
    /* 3*/parms.push({ title: "写真<br>登録番号", width: "150%", sCol: "KEY4", sWhere: "", sInit: "", bSortable: true, bVisible: true, search: "auto", add: false });
    /* 4*/parms.push({ title: "氏名<br>登録年月日", width: "150%", sCol: "PARM1", sWhere: parm1_w, sInit: "", bSortable: true, bVisible: true, search: "auto", add: false });
    /* 5*/parms.push({ title: "年齢<br>性別", width: "100%", sCol: "PARM10", sWhere: parm9_w, sInit: "", bSortable: true, bVisible: true, search: "auto", add: false });
    /* 6*/parms.push({ title: "担当者", width: "100%", sCol: "KEY3", sWhere: "", sInit: "", bSortable: true, bVisible: true, search: "auto", add: false });
    /* 7*/parms.push({ title: "OJT実施<br>実施年月日", width: "150%", sCol: "DUMMY", sWhere: "", sInit: "", bSortable: false, bVisible: true, search: false, add: false });
    /* 8*/parms.push({ title: "勤務回数", width: "150%", sCol: "DUMMY", sWhere: "", sInit: "", bSortable: false, bVisible: true, search: false, add: false });
    /* 9*/parms.push({ title: "紹介可能職種", width: "150%", sCol: "DUMMY", sWhere: "", sInit: "", bSortable: false, bVisible: true, search: false, add: false });
    /*10*/parms.push({ title: "就業状況<br>更新日・更新者", width: "200%", sCol: "KEY5", sWhere: "", sInit: "", bSortable: false, bVisible: true, search: false, add: false });
    /*11*/parms.push({ title: "最近3ヶ月の勤務現場", width: "200%", sCol: "DUMMY", sWhere: "", sInit: "", bSortable: false, bVisible: true, search: false, add: false });
    /*12*/parms.push({ title: "都道府県", width: "200%", sCol: "DUMMY", sWhere: "(ISNULL(PARM83,'') + ISNULL(PARM84,'') + ISNULL(PARM85,''))", sSort: "(ISNULL(PARM81,'') + ISNULL(PARM82,''))", sInit: "", bSortable: true, bVisible: true, search: "auto", add: false });
    /*13*/parms.push({ title: "沿線<br>最寄駅", width: "200%", sCol: "DUMMY", sWhere: "", sSort: "CAST(ISNULL(PARM55, 999999))", sInit: "", bSortable: false, bVisible: true, search: false, add: false });
    /*14*/parms.push({ title: "年末調整<br>希望有無", width: "200%", sCol: "PARM29", sWhere: "", sInit: "", bSortable: false, bVisible: true, search: false, add: false });
    /*15*/parms.push({ title: "-", sCol: "DUMMY", sOr: true, sBeetween: "PARM55", bVisible: false });
    /*16*/parms.push({ title: "-", sCol: "DUMMY", sOr: true, sBeetween: "PARM65", bVisible: false });
    /*17*/parms.push({ title: "-", sCol: "DUMMY", sOr: true, sBeetween: "PARM75", bVisible: false });
    /*18*/parms.push({ title: "-", sCol: "DUMMY", sOr: true, sWhere: "PARM53", bVisible: false });
    /*19*/parms.push({ title: "-", sCol: "DUMMY", sOr: true, sWhere: "PARM63", bVisible: false });
    /*20*/parms.push({ title: "-", sCol: "DUMMY", sOr: true, sWhere: "PARM73", bVisible: false });
    /*21*/parms.push({ title: "-", sCol: "DUMMY", sBeetween: parm9_w, bVisible: false });
    /*22*/parms.push({ title: "-", sCol: "DUMMY", sType: "numeric", sWhere: "KEY1", sInit: $("#selSyozoku").val(), bVisible: false });

    // build table
    //$("body").css("overflow", "hidden");
    oTable1 = ajax_select("table1", "mm", "M_STAFF", parms, "", 25, [[0, 'asc']]
        , function (nRow, aData, iDataIndex) {
            $('td', nRow).addClass("td2");
            var idx = -1;
            idx++;
            var name = dtStaff[aData[0]]["PARM1"] + " " + dtStaff[aData[0]]["PARM2"];
            var face = (
                        (dtStaff[aData[0]]["URL1"]) ?
                        '<a class="pictureUI" rel="staff" href="' + system_top + dtStaff[aData[0]]["URL1"] + '" title="' + name + '"><img src="' + system_top + dtStaff[aData[0]]["URL1"] + '" alt="' + name + '" style="height:50px;" /></a>'
                        : '<a class="pictureUI" rel="staff" href="' + system_top + 'src/noimage.jpg" title="' + name + '"><img src="' + system_top + 'src/noimage.jpg" alt="' + name + '" style="height:50px;" /></a>'
            //'<img src="' + system_top + dtStaff[aData[0]]["URL1"] + '" alt="' + name + '" style="height:50px;" />'
            //: '<img src="' + system_top + 'src/noimage.jpg" alt="' + name + '" style="height:50px;" />'
            );
            var name_admin = ((dtAdmin[dtStaff[aData[0]]["KEY3"]]) ? dtAdmin[dtStaff[aData[0]]["KEY3"]]["PARM1"] + " " + dtAdmin[dtStaff[aData[0]]["KEY3"]]["PARM2"] : "");
            idx++; $('td:eq(' + String(idx) + ')', nRow).addClass("c").html(face + '<br>' + dtStaff[aData[0]]["KEY4"]);
            idx++; $('td:eq(' + String(idx) + ')', nRow).html("<a href='javascript:$WOpen(\"_staff.aspx?id=" + aData[0] + "\", \"\", 1400, 900);'>" + name + "</a><br>" + ((dtStaff[aData[0]]["DATE"]) ? dtStaff[aData[0]]["DATE"].substr(0, 4) + "/" + dtStaff[aData[0]]["DATE"].substr(4, 2) + "/" + dtStaff[aData[0]]["DATE"].substr(6, 2) : ""));
            var sex = ((dtStaff[aData[0]]["PARM9"] == '男') ? '<img src="../../src/icon/man1.png" alt="男" style="height:20px;">' : '<img src="../../src/icon/man2.png" alt="女" style="height:20px;">');
            idx++; $('td:eq(' + String(idx) + ')', nRow).addClass("c").html(GetBirthday(dtStaff[aData[0]]["PARM10"]) + "歳<br>" + sex);
            idx++; $('td:eq(' + String(idx) + ')', nRow).html(name_admin);
            idx++; $('td:eq(' + String(idx) + ')', nRow).html(((dtStaff[aData[0]]["PARM18"]) ? dtStaff[aData[0]]["PARM18"].substr(0, 4) + "/" + dtStaff[aData[0]]["PARM18"].substr(4, 2) + "/" + dtStaff[aData[0]]["PARM18"].substr(6, 2)
                    : '<input type="button" class="buttonUI" value="OJT実施" onclick="alert();" /> '));
            idx++; $('td:eq(' + String(idx) + ')', nRow).addClass("r").html(shift_count(aData[0]) + "回");
            idx++; $('td:eq(' + String(idx) + ')', nRow).html(shokusyu_list(aData[0]).join("<br>"));
            idx++; $('td:eq(' + String(idx) + ')', nRow).addClass("table1_KEY5").attr({ "pid": aData[0], "KEY5": dtStaff[aData[0]]["KEY5"] });
            idx++; $('td:eq(' + String(idx) + ')', nRow).html(shift_list().join("<br>"));
            idx++; $('td:eq(' + String(idx) + ')', nRow).html(dtStaff[aData[0]]["PARM83"] + dtStaff[aData[0]]["PARM84"]);
            idx++; $('td:eq(' + String(idx) + ')', nRow).html(staff_eki_list(aData[0]).join("<br>"));
            idx++; $('td:eq(' + String(idx) + ')', nRow).addClass("c").html(dtStaff[aData[0]]["PARM29"]);

        }
        , function (oSettings) {
            $("#table1 td a").css({ textDecoration: "none", color: "blue" });
            $ButtonUI();
            $PictureUI();
            //            $(".dateUI").attr("buttonImage", system_top + "src/calendar.gif");
            //            $DateUI();

        }, "", true, 450);

    //$("#table1_add").click(function () { detail_disp("0"); });

    ajax_ekidata($("#PARM51"), $("#PARM53"), $("#PARM55_from"), $("#PARM55_to"));
    ajax_ekidata($("#PARM61"), $("#PARM63"), $("#PARM65_from"), $("#PARM65_to"));
    ajax_ekidata($("#PARM71"), $("#PARM73"), $("#PARM75_from"), $("#PARM75_to"));

    $("#selSyozoku").change(function () {
        SearchColSetting(oTable1.fnSettings(), 22, $(this).val());
        oTable1.fnDraw();
    });
});

function ekiSearch() {
    SearchColSetting(oTable1.fnSettings(), 15, $("#PARM55_from").val() + "," + $("#PARM55_to").val());
    SearchColSetting(oTable1.fnSettings(), 16, $("#PARM65_from").val() + "," + $("#PARM65_to").val());
    SearchColSetting(oTable1.fnSettings(), 17, $("#PARM75_from").val() + "," + $("#PARM75_to").val());
    SearchColSetting(oTable1.fnSettings(), 18, $("#PARM53").val());
    SearchColSetting(oTable1.fnSettings(), 19, $("#PARM63").val());
    SearchColSetting(oTable1.fnSettings(), 20, $("#PARM73").val());
    oTable1.fnDraw();
}

function yearSearch() {
    SearchColSetting(oTable1.fnSettings(), 21, $("#PARM10_from").val() + "," + $("#PARM10_to").val());
    oTable1.fnDraw();
}

function removeList(val) {
    if (val == "0") {
        $("#remove1").css("color", "Gray");
        $("#remove2").css("color", "Red");
    } else {
        $("#remove1").css("color", "Blue");
        $("#remove2").css("color", "Gray");
    }
    SearchColSetting(oTable1.fnSettings(), 1, val);
    oTable1.fnDraw();
}
