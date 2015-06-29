// use infomation
//
// html or aspx write example source in header tag [script type="text/javascript"]
//
// var ajax_top = /ajax
//

function QueryStrings() {
    var vars = [], hash;
    var hashes = location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for (var i = 0; i < hashes.length; i++) {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        var val = hash[1];
        val = decodeURI(val);
        vars[hash[0]] = val;
    }
    return vars;
}

function set_radio(val, radio_name, defIdx) {
    var flg = false;
    for (i = 1; i < $("[name='" + radio_name + "']").length + 1; i++) {
        if ($("#" + radio_name + "_" + String(i)).val() == val) {
            $("#" + radio_name + "_" + String(i)).prop("checked", true);
            flg = true;
        } else {
            $("#" + radio_name + "_" + String(i)).prop("checked", false);
        }
    }
    if (!flg) {
        if (defIdx) {
            $("#" + radio_name + "_" + defIdx).prop("checked", true);
        }
    }
}

function get_radio(radio_name) {
    for (i = 1; i < $("[name='" + radio_name + "']").length + 1; i++) {
        if ($("#" + radio_name + "_" + String(i)).prop("checked")) {
            return $("#" + radio_name + "_" + String(i)).val();
        }
    }
    return "";
}

function GetFormdata() {
    var vars = new Object;
    $("input, select, textarea").each(function () {
        switch ($(this).attr("type").toUpperCase()) {
            case "SUBMIT":
            case "BUTTON":
            case "IMAGE":
                break;
            case "RADIO":
                if ($(this).prop("checked")) {
                    vars[$(this).attr("name")] = $(this).val();
                }
                break;
            case "CHECKBOX":
                if ($(this).prop("checked")) {
                    if (!vars[$(this).attr("name")]) {
                        vars[$(this).attr("name")] = $(this).val();
                    } else {
                        vars[$(this).attr("name")] += "," + $(this).val();
                    }
                }
                break;
            default:
                if ($(this).attr("name")) vars[$(this).attr("name")] = $(this).val();
        }
    });
    return vars;
}

function get_youtube(youtubeId, success) {
    jQuery.ajax({
        url: ajax_top + '/youtube.ashx'
        , type: 'POST'
        , cache: false
        , async: false
        , dataType: 'json'
        , data: {
            uid: youtubeId
        }
        , success: function (res) {
            if (res["result"] == "success") {
                success(res);
            } else alert(res["msg"]);
        }
    });
}

// 20150405 make ajax function
function ajax_list(extension, datakey, arrCols, htCols, sort, async, success) {

    if (async) async = true;
    else async = false;

    if (arrCols) {

        // require parms
        var parms = new Object;
        parms["datakey"] = datakey;
        parms["extension"] = extension;
        //check parms
        for (i = 0; i < arrCols.length; i++) {
            parms["Col_" + String(i)] = arrCols[i];
        }
        //search column
        if (htCols) {
            var idx = 0;
            for (var key in htCols) {
                parms["sCol_" + String(idx)] = key;
                parms["sVal_" + String(idx)] = htCols[key];
                idx++;
            }
        }
        //sort
        if (sort) parms["sort"] = sort;
       
        if (success) {
            $.ajax({
                url: ajax_top + '/list.ashx'
                , type: 'POST'
                , cache: false
                , dataType: 'json'
                , async: async
                , data: parms
                , success: function (res) {
                    if (res["result"] == "success") {
                        success(res);
                    } else alert(res["msg"]);
                }
                , error: ajax_error
            });
        } else {
            alert("引数[success(Callback関数)]を指定してください。");
        }
    } else {
        alert("引数[arrCols]を指定してください。");
    }
}

function ajax_update(extension, datakey, uid, htCols, async, success) {
    
    if (async) async = true;
    else async = false;

    if (htCols) {
        // require parms
        var parms = new Object;
        parms["uid"] = uid;
        parms["datakey"] = datakey;
        parms["extension"] = extension;

        //check column
        if (htCols) {
            var idx = 0;
            for (var key in htCols) {
                parms["Col_" + String(idx)] = key;
                parms["Val_" + String(idx)] = htCols[key];
                idx++;
            }
        }

        if (success) {
            $.ajax({
                url: ajax_top + '/update.ashx'
                , type: 'POST'
                , cache: false
                , dataType: 'json'
                , async: async
                , data: parms
                , success: function (res) {
                    if (res["result"] == "success") {
                        success(res);
                    } else alert(res["msg"]);
                }
                , error: ajax_error
            });
        } else {
            alert("引数[success(Callback関数)]を指定してください。");
        }
    } else {
        alert("引数[htCols]を指定してください。");
    }
}

function ajax_remove(extension, datakey, uid, async, success) {

    if (async) async = true;
    else async = false;

    var parms = new Object;
    parms["uid"] = uid;
    parms["datakey"] = datakey;
    parms["extension"] = extension;

    if (success) {
        $.ajax({
            url: ajax_top + '/remove.ashx'
            , type: 'POST'
            , cache: false
            , dataType: 'json'
            , async: async
            , data: parms
            , success: function (res) {
                if (res["result"] == "success") {
                    success(res);
                } else alert(res["msg"]);
            }
        });
    } else {
        alert("引数[success(Callback関数)]を指定してください。");
    }

}

function ajax_error(XMLHttpRequest, textStatus, errorThrown) {
    // , error: ajax_error
    var msg = "【通信エラー】\n";
    msg += "この画面をキャプチャーしてご連絡ください。\n";
    msg += "XMLHttpRequest : " + XMLHttpRequest.status + "\n";
    msg += "textStatus : " + textStatus + "\n";
    msg += "errorThrown : " + errorThrown.message + "\n";
    alert(msg);
}

function ajax_complete(XMLHttpRequest, textStatus) {
    // , complete: ajax_complete
    var msg = "【Complete】\n";
    msg += "XMLHttpRequest : " + XMLHttpRequest.status + "\n";
    msg += "textStatus : " + textStatus + "\n";
    alert(msg);
}


function ajax_select(targetID, extension, datakey, parms, sDom, iDisplayLength, aaSorting, fnCreatedRow, fnDrawCallback, sqlName, scrollY, scrollHeight) {
    //validation
    var msg = new Array;
    if (!targetID) msg.push("引数[targetID]を指定してください。");
    if ($('#' + targetID).length == 0) msg.push("指定したテーブルが存在しません。");
    if (!extension) msg.push("引数[extension]を指定してください。");
    if (!datakey) msg.push("引数[datakey]を指定してください。");
    if (!parms) msg.push("引数[parms]を指定してください。");
    if (!sDom) sDom = '<"H"lfip>t<"F"ip>';
    if (!iDisplayLength) iDisplayLength = 25;
    if (msg.length > 0) {
        alert(msg.join("\n"));
        return false;
    }

    //default
    for (i = 0; i < parms.length; i++) {
        if (!parms[i]["title"]) parms[i]["title"] = "COL_" + String(i);
        if (!parms[i]["width"]) parms[i]["width"] = "";
        if (!parms[i]["sCol"]) parms[i]["sCol"] = "";
        if (!parms[i]["sType"]) parms[i]["sType"] = "";
        if (!parms[i]["sInit"]) parms[i]["sInit"] = "";
        if (!parms[i]["sWhere"]) parms[i]["sWhere"] = "";
        if (!parms[i]["sBeetween"]) parms[i]["sBeetween"] = "";
        if (!parms[i]["sOr"]) parms[i]["sOr"] = "";
        else parms[i]["sOr"] = "1";
        if (!parms[i]["sSort"]) parms[i]["sSort"] = "";
        if (!parms[i]["bSortable"]) parms[i]["bSortable"] = false;
        if (!parms[i]["bVisible"]) parms[i]["bVisible"] = false;
        if (!parms[i]["search"]) parms[i]["search"] = false;
        if (!parms[i]["add"]) parms[i]["add"] = false;
    }

    //table clear
    if (targetID) $("#" + targetID).html("");

    //table options
    var isSearch = false;
    var isAdd = false;
    for (i = 0; i < parms.length; i++) {
        if (parms[i]["search"]) isSearch = true;
        if (parms[i]["add"]) isAdd = true;
    }

    //make title
    var thead_title = $("<tr />");
    var tfoot_title = $("<tr />");
    var thead_2 = $("<tr class='datatables-top' />");
    var thead_3 = $("<tr class='datatables-new' />");
    for (i = 0; i < parms.length; i++) {
        //title 
        if ( (!parms[i]["width"]) || (parms[i]["width"] == "auto") || (!parms[i]["bVisible"]) ) {
            thead_title.append('<th>' + parms[i]["title"] + '</th>');
            tfoot_title.append('<th style="padding:0;">' + parms[i]["title"] + '</th>');
        } else {
            thead_title.append('<th style="width:' + parms[i]["width"] + ';">' + parms[i]["title"] + '</th>');
            tfoot_title.append('<th style="width:' + parms[i]["width"] + '; padding:0;">' + parms[i]["title"] + '</th>');
        }
        //search
        if (isSearch) {
            if (parms[i]["sCol"]) {
                switch (parms[i]["search"]) {
                    case "auto":
                        thead_2.append('<td id="' + targetID + '_' + parms[i]["sCol"] + '_search' + '" column_index="' + String(i) + '"><input class="balloon" title="Enterで検索" column_index="' + String(i) + '" type="text" placeholder="絞り込み" style="width:90%;" /></td>');
                        break;
                    default:
                        thead_2.append('<td id="' + targetID + '_' + parms[i]["sCol"] + '_search' + '" column_index="' + String(i) + '">&nbsp;</td>');
                        break;
                }
            } else {
                thead_2.append('<td column_index="' + String(i) + '">&nbsp;</td>');
            }
        }
        //add
        if (isAdd) {
            if (parms[i]["sCol"]) {
                switch (parms[i]["add"]) {
                    case "auto":
                        thead_3.append('<td class="td2" id="' + targetID + '_' + parms[i]["sCol"] + '_add' + '" column_index="' + String(i) + '"><input id="' + targetID + '_' + parms[i]["sCol"] + '_0' + '" column_index="' + String(i) + '" type="text" placeholder="' + parms[i]["title"] + '" style="width:90%;" /></td>');
                        break;
                    default:
                        thead_3.append('<td class="td2" id="' + targetID + '_' + parms[i]["sCol"] + '_add' + '" column_index="' + String(i) + '">&nbsp;</td>');
                        break;
                }
            } else {
                thead_3.append('<td class="td2" column_index="' + String(i) + '"><input id="' + targetID + '_add' + '" type="button" class="buttonUI new" value="新規作成" style="width:135px;" /></td>');
            }
        }
    }

    //bulid table layout
    var thead = $("<thead />").append(thead_title);
    var tbody = $("<tbody />").append('<tr><td class="td2 dataTables_empty" colspan="100" >データ受信中...</td></tr>');
    var tfoot = $("<tfoot />").append(tfoot_title);
    if (isSearch) thead.append(thead_2);
    if (isAdd) thead.append(thead_3);
    if (scrollY) {
        $('#' + targetID).append(thead).append(tbody);
    } else {
        $('#' + targetID).append(thead).append(tbody).append(tfoot);
    }

    //ajax path
//    var ajax_path = ajax_top + '/select.ashx?extension=' + extension + '&datakey=' + datakey;
//    if (sqlName) ajax_path = ajax_top + '/select_manual.ashx?sqlName=' + sqlName;

    var ajax_data = new Object;
    var ajax_path = ajax_top + '/select.ashx';
    if (sqlName) {
        ajax_path = ajax_top + '/select_manual.ashx';
        ajax_data['sqlName'] = sqlName;
    }

    ajax_data['extension'] = extension;
    ajax_data['datakey'] = datakey;

    for (i = 0; i < parms.length; i++) {
        ajax_data["sCol_" + String(i)] = parms[i]["sCol"];
        ajax_data["sType_" + String(i)] = parms[i]["sType"];
        ajax_data["sInit_" + String(i)] = parms[i]["sInit"];
        ajax_data["sWhere_" + String(i)] = parms[i]["sWhere"];
        ajax_data["sBeetween_" + String(i)] = parms[i]["sBeetween"];
        ajax_data["sOr_" + String(i)] = parms[i]["sOr"];
        ajax_data["sSort_" + String(i)] = parms[i]["sSort"];
//        if (parms[i]["sCol"]) ajax_path += "&sCol_" + String(i) + "=" + parms[i]["sCol"];
//        if (parms[i]["sType"]) ajax_path += "&sType_" + String(i) + "=" + parms[i]["sType"];
//        if (parms[i]["sInit"]) ajax_path += "&sInit_" + String(i) + "=" + parms[i]["sInit"];
//        if (parms[i]["sWhere"]) ajax_path += "&sWhere_" + String(i) + "=" + parms[i]["sWhere"];
//        if (parms[i]["sSort"]) ajax_path += "&sSort_" + String(i) + "=" + encodeURIComponent(parms[i]["sSort"]);
    }

    //aoColumns
    var aoColumns = new Array;
    for (i = 0; i < parms.length; i++) {
        aoColumns.push({ sType: parms[i]["sType"], bSortable: parms[i]["bSortable"], bVisible: parms[i]["bVisible"] });
    }

    //bulid datatables
    //$("debug").html(ajax_path);
    var oTable;
    oTable = $('#' + targetID).dataTable({
        "sDom": sDom
        //, "sScrollY": "300"
        //, "bScrollCollapse": false
        , "bAutoWidth": false
        , "iDisplayLength": iDisplayLength
        , "aaSorting": aaSorting
        , "aoColumns": aoColumns
        // use ajax
        , "bProcessing": true
        , "bDeferRender": true
        , "bServerSide": true
        //, "sAjaxSource": ajax_path
        , "ajax": {
            url: ajax_path
            , type: 'POST'
            , data: ajax_data
        }
        // make row
        , "fnCreatedRow": function (nRow, aData, iDataIndex) {
            fnCreatedRow(nRow, aData, iDataIndex);
        }
        // complete
        , "fnDrawCallback": function (oSettings) {
            $(".datatables-top td, .datatables-new td").removeClass("ui-state-default");
            if (scrollY) $(window).trigger("resize");

            $(".dataTables_filter").hide();
            $(".dataTables_empty").width($('#' + targetID).width());
            fnDrawCallback(oSettings);
        }
    });

    //event
    if (scrollY) {
        $(window).resize(function () {
            windows_table_fix(targetID, scrollHeight);
        });
        $("#" + targetID + " tbody").scroll(table_height);
    }


    //base search
    for (i = 0; i < parms.length; i++) {
        if (parms[i]["sInit"]) SearchColSetting(oTable.fnSettings(), i, parms[i]["sInit"]);
    }

    //search columns
    for (i = 0; i < parms.length; i++) {
        //search
        if (isSearch) {
            if (parms[i]["sCol"]) {
                switch (parms[i]["search"]) {
                    case "auto":
                        $('#' + targetID + '_' + parms[i]["sCol"] + '_search input').keyup(function (e) {
                            if (e.keyCode == 13) {
                                oTable.fnFilter($(this).val(), $(this).attr("column_index"));
                            }
                        });
                        break;
                    default:
                        break;
                }
            }
        }
    }

    //complete
    return oTable;
}

function windows_table_fix(targetID, scrollHeight) {
    var b = Browser();
    var cntTh = $("#" + targetID + " thead tr:eq(0) th").length;
    for (i = 0; i < cntTh; i++) {
        var wTh = parseInt($("#" + targetID + " thead tr:first th:eq(" + String(i) + ")").innerWidth());
        if (i < (cntTh - 1)) {
            $("#" + targetID + " tbody tr:first td:eq(" + String(i) + ")").width(wTh - 19);
        } else {
            if (b.isIE) {
                $("#" + targetID + " tbody tr:first td:eq(" + String(i) + ")").width(wTh - 37);
            } else {
                $("#" + targetID + " tbody tr:first td:eq(" + String(i) + ")").width(wTh - 38);
            }
        }
    }
    // width
    var now_width = parseInt($("#" + targetID).outerWidth());
    // height
    if (scrollHeight) {
        $("#" + targetID + " tbody").css({ display: "block", maxHeight: String(scrollHeight) + "px", overflowY: "scroll" }).width(now_width - 3);
    } else {
        $("#" + targetID + " tbody").css({ display: "block", maxHeight: "100px", overflowY: "scroll" }).width(now_width - 3);
    }
}

function table_height(e) {
    var p = parseInt($(this).scrollTop());
    if (p > 0) {
        if ($(".auto_scroll_hidden").is(":hidden")) {
            //ok
        } else {
            $(".auto_scroll_hidden").slideUp("fast");
            $(window).trigger("resize");
        }
    } else {
        if ( $(".auto_scroll_hidden").is(":hidden")) {
            $(".auto_scroll_hidden").slideDown("fast");
            $(window).trigger("resize");
        } else {
            //ok
        }
    }
    //alert(p);
}

function SearchColSetting(oSettings, column_index, value) {
    if (oSettings) {
        for (iCol = 0; iCol < oSettings.aoPreSearchCols.length; iCol++) {
            switch (iCol) {
                case column_index:
                    oSettings.aoPreSearchCols[iCol].sSearch = value;
                    break;
            }
        }
    }
}

function ajax_ekidata(prefObj, lineObj, stationObj, stationObj2) {
    
    //initialize
    if (prefObj) {
        if (prefObj.children().length == 0) {
            $.ajax({
                url: ajax_top + '/ekidata.ashx'
                , type: 'POST'
                , cache: false
                , dataType: 'json'
                , async: true
                , success: function (res) {
                    if (res["result"] == "success") {
                        prefObj.children().remove();
                        prefObj.append($("<option>").val("").text("選択してください"));
                        for (var key in res["data"]) {
                            prefObj.append($("<option>").val(key).text(res["data"][key]));
                        }
                        //初期値があればセット
                        if (prefObj.attr("pref")) {
                            prefObj.val(prefObj.attr("pref")).removeAttr("pref");
                            prefObj.trigger("change");
                        }
                        //路線リスト初期化
                        if (lineObj) {
                            lineObj.children().remove();
                            lineObj.append($("<option>").val("").text("都道府県を選択してください")).attr("disabled", "disabled");
                        }
                        //駅リスト初期化
                        if (stationObj) {
                            stationObj.children().remove();
                            stationObj.append($("<option>").val("").text("路線を選択してください")).attr("disabled", "disabled");
                        }
                        if (stationObj2) {
                            stationObj2.children().remove();
                            stationObj2.append($("<option>").val("").text("路線を選択してください")).attr("disabled", "disabled");
                        }
                    } else alert(res["msg"]);
                }
            });
        }
    }

    if (prefObj) {
        //set event
        prefObj.change(function () {
            if ($(this).val()) {
                var parms = { pref: $(this).val() };
                $.ajax({
                    url: ajax_top + '/ekidata.ashx'
                    , type: 'POST'
                    , cache: false
                    , dataType: 'json'
                    , async: true
                    , data: parms
                    , success: function (res) {
                        if (res["result"] == "success") {
                            //路線リスト更新
                            if (lineObj) {
                                lineObj.children().remove();
                                lineObj.append($("<option>").val("").text("選択してください")).removeAttr("disabled");
                                for (var key in res["data"]) {
                                    lineObj.append($("<option>").val(key).text(res["data"][key]));
                                }
                                //初期値があればセット
                                if (lineObj.attr("line")) {
                                    lineObj.val(lineObj.attr("line")).removeAttr("line");
                                    lineObj.trigger("change");
                                }
                            }
                            //駅リスト削除
                            if (stationObj) {
                                stationObj.children().remove();
                                stationObj.append($("<option>").val("").text("路線を選択してください")).attr("disabled", "disabled");
                            }
                            if (stationObj2) {
                                stationObj2.children().remove();
                                stationObj2.append($("<option>").val("").text("路線を選択してください")).attr("disabled", "disabled");
                            }
                        } else alert(res["msg"]);
                    }
                });
            } else {
                //路線リスト初期化
                if (lineObj) {
                    lineObj.children().remove();
                    lineObj.append($("<option>").val("").text("都道府県を選択してください")).attr("disabled", "disabled");
                }
                //駅リスト初期化
                if (stationObj) {
                    stationObj.children().remove();
                    stationObj.append($("<option>").val("").text("路線を選択してください")).attr("disabled", "disabled");
                }
                if (stationObj2) {
                    stationObj2.children().remove();
                    stationObj2.append($("<option>").val("").text("路線を選択してください")).attr("disabled", "disabled");
                }
            }
        });
    }
    if (lineObj) {
        //event
        lineObj.change(function () {
            if ($(this).val()) {
                var parms = { line: $(this).val() };
                $.ajax({
                    url: ajax_top + '/ekidata.ashx'
                    , type: 'POST'
                    , cache: false
                    , dataType: 'json'
                    , async: true
                    , data: parms
                    , success: function (res) {
                        if (res["result"] == "success") {
                            //駅リスト更新
                            if (stationObj) {
                                stationObj.children().remove();
                                stationObj.append($("<option>").val("").text("選択してください")).removeAttr("disabled");
                                for (var key in res["data"]) {
                                    stationObj.append($("<option>").val(key).text(res["data"][key]));
                                }
                                //初期値があればセット
                                if (stationObj.attr("station")) {
                                    stationObj.val(stationObj.attr("station")).removeAttr("station");
                                }
                            }
                            if (stationObj2) {
                                stationObj2.children().remove();
                                stationObj2.append($("<option>").val("").text("選択してください")).removeAttr("disabled");
                                for (var key in res["data"]) {
                                    stationObj2.append($("<option>").val(key).text(res["data"][key]));
                                }
                            }

                        } else alert(res["msg"]);
                    }
                });
            } else {
                //駅リスト初期化
                if (stationObj) {
                    stationObj.children().remove();
                    stationObj.append($("<option>").val("").text("路線を選択してください")).attr("disabled", "disabled");
                }
                if (stationObj2) {
                    stationObj2.children().remove();
                    stationObj2.append($("<option>").val("").text("路線を選択してください")).attr("disabled", "disabled");
                }
            }
        });
    }
}

function ajax_todohuken(obj, val) {
    obj.html("");
    obj.append($('<option />').val("").html("選択してください"));
    obj.append($('<option />').val("北海道").html("北海道"));
    obj.append($('<option />').val("青森県").html("青森県"));
    obj.append($('<option />').val("岩手県").html("岩手県"));
    obj.append($('<option />').val("宮城県").html("宮城県"));
    obj.append($('<option />').val("秋田県").html("秋田県"));
    obj.append($('<option />').val("山形県").html("山形県"));
    obj.append($('<option />').val("福島県").html("福島県"));
    obj.append($('<option />').val("茨城県").html("茨城県"));
    obj.append($('<option />').val("栃木県").html("栃木県"));
    obj.append($('<option />').val("群馬県").html("群馬県"));
    obj.append($('<option />').val("埼玉県").html("埼玉県"));
    obj.append($('<option />').val("千葉県").html("千葉県"));
    obj.append($('<option />').val("東京都").html("東京都"));
    obj.append($('<option />').val("神奈川県").html("神奈川県"));
    obj.append($('<option />').val("山梨県").html("山梨県"));
    obj.append($('<option />').val("長野県").html("長野県"));
    obj.append($('<option />').val("新潟県").html("新潟県"));
    obj.append($('<option />').val("富山県").html("富山県"));
    obj.append($('<option />').val("石川県").html("石川県"));
    obj.append($('<option />').val("福井県").html("福井県"));
    obj.append($('<option />').val("岐阜県").html("岐阜県"));
    obj.append($('<option />').val("静岡県").html("静岡県"));
    obj.append($('<option />').val("愛知県").html("愛知県"));
    obj.append($('<option />').val("三重県").html("三重県"));
    obj.append($('<option />').val("滋賀県").html("滋賀県"));
    obj.append($('<option />').val("京都府").html("京都府"));
    obj.append($('<option />').val("大阪府").html("大阪府"));
    obj.append($('<option />').val("兵庫県").html("兵庫県"));
    obj.append($('<option />').val("奈良県").html("奈良県"));
    obj.append($('<option />').val("和歌山県").html("和歌山県"));
    obj.append($('<option />').val("鳥取県").html("鳥取県"));
    obj.append($('<option />').val("島根県").html("島根県"));
    obj.append($('<option />').val("岡山県").html("岡山県"));
    obj.append($('<option />').val("広島県").html("広島県"));
    obj.append($('<option />').val("山口県").html("山口県"));
    obj.append($('<option />').val("徳島県").html("徳島県"));
    obj.append($('<option />').val("香川県").html("香川県"));
    obj.append($('<option />').val("愛媛県").html("愛媛県"));
    obj.append($('<option />').val("高知県").html("高知県"));
    obj.append($('<option />').val("福岡県").html("福岡県"));
    obj.append($('<option />').val("佐賀県").html("佐賀県"));
    obj.append($('<option />').val("長崎県").html("長崎県"));
    obj.append($('<option />').val("熊本県").html("熊本県"));
    obj.append($('<option />').val("大分県").html("大分県"));
    obj.append($('<option />').val("宮崎県").html("宮崎県"));
    obj.append($('<option />').val("鹿児島県").html("鹿児島県"));
    obj.append($('<option />').val("沖縄県").html("沖縄県"));
    obj.val(val);
}

function ajax_address(obj1, obj2, r1, r2, r3, r4) {
    obj1.keyup(function () { ajax_get_address(obj1, obj2, r1, r2, r3, r4); });
    obj2.keyup(function () { ajax_get_address(obj1, obj2, r1, r2, r3, r4); });
}

function ajax_get_address(obj1, obj2, r1, r2, r3, r4) {
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

function ajax_fileupload(targetId, extension, datakey, uid, idx, acceptedFiles, parallelUploads, maxFiles, success) {
    if (success) {
        if (!parallelUploads) parallelUploads = 1;
        if (!maxFiles) maxFiles = 1;

        var ajax_path = ajax_top + '/fileupload.ashx';
        ajax_path += "?extension=" + extension;
        ajax_path += "&datakey=" + datakey;
        ajax_path += "&uid=" + uid;
        ajax_path += "&idx=" + idx;

        $("#" + targetId).dropzone({
            url: ajax_path
            , parallelUploads: parallelUploads
            , maxFiles: maxFiles
            , acceptedFiles: acceptedFiles
            , success: function (_file, _return, _xml) {
                _file.previewElement.classList.add("dz-success");
                // _return["pid"]
                // _return["src"]
                success(_file, _return, _xml);
            }
            , complete: function () {
                setTimeout(function () {
                    $(".dz-preview:eq(0)").remove();
                    if ($(".dz-preview").length == 0) {
                        $(".dropzone").removeClass("dz-started");
                    }
                }, 1000);
            }
            , init: function () {
                Dropzone.autoDiscover = false;
                Dropzone.myAwesomeDropzone = false;
            }
        });
    
    } else {
        alert("引数[success(Callback関数)]を指定してください。");
    }
}

