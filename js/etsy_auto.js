var click1;
var month = $("#active_month").val();
var page=1;
var expenses = [];
var user_id = $("active_account").val();
var user_id_billing = null;
function toObject(e, t) {
    for (var a = {}, s = 0; s < e.length; s++) a[e[s]] = t[s];
    return a
}

function activeSelect() {
    alert(1);
    var e = $("#active_select").val(),
        t = $("#loader");
    t.fadeIn(), $.ajax({
        url: "sold",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        method: "POST",
        data: "active_select=" + e + "&current_page=1",
        success: function(e) {
            t.fadeOut(), $(".auto-grid").empty().append(e)
        },
        error: function(e, a, s) {
            t.fadeOut(), popMessage("danger", "Network error! ")
        }
    })
}



function list() {
    $.ajax({
        url: "/pg_sheet_list",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        method: "POST",
        success: function(e) {
            $("#list").empty().append(e)
        },
        error: function(e, t, a) {
            $("#list").empty().append("wtf")
        }
    })
}


function getObject() {
    $("#no-data").css("display", "none");
    var e = $("#loader");
    e.fadeIn();
    var t = $("#from-date").val(),
        a = $("#to-date").val(),
        s = new Date;
    s.setTime(s.getTime() + 6e6), $.cookie("fromdate", t, {
        expires: s,
        path: "/"
    }),
 $.cookie("todate", a, {
        expires: s,
        path: "/"
    }),
 confirm = $(".sold-date").html();
    var n = 0;
    "undefined" != typeof confirm && confirm && $(".sold-date").each(function(e) {
        _this = $(this);
        var s = convertDate($.trim(_this.html()));
        new Date(t) < new Date(s) && new Date(a) > new Date(s) ? (_this.closest("tr").css("display", "table-row"), n++) : _this.closest("tr").css("display", "none")
    }),
 0 == n && $("#no-data").css("display", "table-cell"), e.fadeOut()
}

function convertDate(e) {
    var t = e.split("/");
    return t[2] + "-" + t[1] + "-" + t[0]
}

function allshow() {
    $("#no-data").css("display", "none");
    var e = $("#loader");
    e.fadeIn(), confirm = $(".sold-date").html(), "undefined" != typeof confirm && confirm && $(".sold-date").each(function(e) {
        _this = $(this), _this.closest("tr").css("display", "table-row")
    }),
 e.fadeOut()
}

function allcheck() {
    var e = $("#all-check");
    e.is(":checked") ? $(".fee-checkbox").prop("checked", !0) : e.is(":not(':checked')") && $(".fee-checkbox").prop("checked", !1)
}


function allcheckBilling() {
    var e = $("#all-check-billing");
    e.is(":checked") ? $(".fee-checkbox-billing").prop("checked", !0) : e.is(":not(':checked')") && $(".fee-checkbox-billing").prop("checked", !1)
}


function popMessage(e, t) {
    var a = $(".msg");
    switch ($(".btn-success"), $(".btn-danger"), $(".btn-warning"), $(".btn-info"), hide(), e) {
        case "success":
            a.addClass("msg-success active").text(t);
            break;
        case "danger":
            a.addClass("msg-danger active").text(t);
            break;
        case "warning":
            a.addClass("msg-warning active").text(t);
            break;
        case "info":
            a.addClass("msg-info active").text(t)
    }
    timer()
}

function timer() {
    var e;
    clearTimeout(e), e = setTimeout(function() {
        hide()
    }, 3e3)
}

function hide() {
    $(".msg").removeClass("msg-success msg-danger msg-warning msg-info active")
}
$("input.shipping-cost").bind("change keyup input", function() {
    var e = this.selectionStart - 1,
        t = this.value.replace(/[^0-9\.]/g, "");
    "." === t.charAt(0) && (t = t.slice(1));
    var a = t.indexOf(".") + 1;
    a >= 0 && (t = t.substr(0, a) + t.slice(a).replace(".", "")), this.value !== t && (this.value = t, this.selectionStart = e, this.selectionEnd = e)
}),
 
$("input.ad-fee").bind("change keyup input", function() {
    var e = this.selectionStart - 1,
        t = this.value.replace(/[^0-9\.]/g, "");
    "." === t.charAt(0) && (t = t.slice(1));
    var a = t.indexOf(".") + 1;
    a >= 0 && (t = t.substr(0, a) + t.slice(a).replace(".", "")), this.value !== t && (this.value = t, this.selectionStart = e, this.selectionEnd = e)
}),


$("#new_sheet").click(function(e) {
    e.preventDefault();
    var t = $("input[name='spreadsheet_name']"),
        a = t.val(),
        s = $("#loader");
    s.fadeIn(), $.ajax({
        url: "/autonewsheet",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        type: "POST",
        data: {
            action: "new_sheet",
            spreadsheet_name: a
        },
        success: function(a) {
            "valid" == a.status ? (e.preventDefault(), t.val(""), $("#add_page").modal("hide"), popMessage("success", "The new spreadsheet has been created!"), s.fadeOut()) : "error" == a.status && (e.preventDefault(), t.val(""), $("#add_page").modal("hide"), popMessage("danger", "Wrong! please upgrade your account"), s.fadeOut()), list()
        },
        error: function(e, t, a) {
            popMessage("danger", "Network error!"), s.fadeOut()
        }
    })
}),

$("#newsheet_close_alert").click(function() {
    $(".newsheet-alert").fadeOut(), $(".newsheet-alert-message").empty()
}),


 list();