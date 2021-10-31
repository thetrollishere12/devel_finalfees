var click1;

function toObject(e, t) {
    for (var a = {}, s = 0; s < e.length; s++) a[e[s]] = t[s];
    return a
}

function activeSelect() {
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
            $("#list").empty().append("Error")
        }
    })
}

function selectPage(e) {
    var t = $.trim(e),
        a = $("#active_select").val(),
        s = $("#loader");
    s.fadeIn(), $.ajax({
        url: "sold",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        method: "POST",
        data: "active_select=" + a + "&current_page=" + t,
        success: function(e) {
            s.fadeOut(), $(".auto-grid").empty().append(e)
        },
        error: function(e, t, a) {
            s.fadeOut(), popMessage("danger", "Network error! ")
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
    }), $.cookie("todate", a, {
        expires: s,
        path: "/"
    }), confirm = $(".sold-date").html();
    var n = 0;
    "undefined" != typeof confirm && confirm && $(".sold-date").each(function(e) {
        _this = $(this);
        var s = convertDate($.trim(_this.html()));
        new Date(t) < new Date(s) && new Date(a) > new Date(s) ? (_this.closest("tr").css("display", "table-row"), n++) : _this.closest("tr").css("display", "none")
    }), 0 == n && $("#no-data").css("display", "table-cell"), e.fadeOut()
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
    }), e.fadeOut()
}

function allcheck() {
    var e = $("#all-check");
    e.is(":checked") ? $(".fee-checkbox").prop("checked", !0) : e.is(":not(':checked')") && $(".fee-checkbox").prop("checked", !1)
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
}), $("input.ad-fee").bind("change keyup input", function() {
    var e = this.selectionStart - 1,
        t = this.value.replace(/[^0-9\.]/g, "");
    "." === t.charAt(0) && (t = t.slice(1));
    var a = t.indexOf(".") + 1;
    a >= 0 && (t = t.substr(0, a) + t.slice(a).replace(".", "")), this.value !== t && (this.value = t, this.selectionStart = e, this.selectionEnd = e)
}), $(".shipping-cost").focusin(function() {
    _this = $(this);
    var e = $.trim(_this.val()) / 1;
    _this.attr("old-val", e)
}), $(".item-cost").focusin(function() {
    _this = $(this);
    var e = $.trim(_this.val()) / 1;
    _this.attr("old-val", e)
}), $(".shipping-cost").focusout(function() {
    _this = $(this);
    var e = $.trim(_this.val()) / 1,
        t = $.trim(_this.closest("tr").find("td").eq("19").children().html()) / 1 - e + _this.attr("old-val") / 1;
    _this.closest("tr").find("td").eq("19").children().html(t.toFixed(2)), popMessage("success", "The profit has been updated to " + t.toFixed(2) + "!")
}), $(".item-cost").focusout(function() {
    _this = $(this);
    var e = $.trim(_this.val()) / 1,
        t = _this.attr("old-val"),
        a = $.trim(_this.closest("tr").find("td").eq("19").children().html()) / 1 - e + t / 1;
    _this.closest("tr").find("td").eq("19").children().html(a.toFixed(2)), popMessage("success", "The profit has been updated to " + a.toFixed(2) + "!")
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
        method: "POST",
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
}), $("#newsheet_close_alert").click(function() {
    $(".newsheet-alert").fadeOut(), $(".newsheet-alert-message").empty()
}), $(document).on("click", ".add_sales_btn", function(e) {
    var t = (new Date).getTime();
    if (!(t - click1 < 1e3)) {
        click1 = t, e.preventDefault();
        var a, s = $("#sheet_page_list").children("option:selected").attr("id"),
            n = [],
            i = [],
            r = $("#sheet_page_list").val();
        r = r.substring(13, r.length), a = ["spreadsheet_id", "date", "spreadsheet_name", "platform", "currency", "name", "sold_price", "item_cost", "shipping_charge", "shipping_cost", "fees", "other_fees", "processing_fees", "tax", "profit", "sale_id", "item_id", "quantity"];
        var c = 0;
        $(".fee-checkbox").each(function(e) {
            if (_this = $(this), _this.is(":checked")) {
                var t = $.trim(_this.parent().parent().find("td").children().eq("2").html()),
                    d = $.trim(_this.parent().parent().find("td").children().eq("3").html()),
                    o = $.trim(_this.parent().parent().find("td").eq("4").children().html()),
                    l = $.trim(_this.parent().parent().find("td").eq("5").children().html()),
                    h = parseFloat($.trim(_this.parent().parent().find("td").eq("6").children().html())),
                    p = $.trim(_this.parent().parent().find("td").eq("7").children().html()),
                    u = $.trim(_this.parent().parent().find("td").eq("8").children().val()),
                    f = $.trim(_this.parent().parent().find("td").eq("9").children().html()),
                    m = $.trim(_this.parent().parent().find("td").eq("10").children().val()),
                    g = $.trim(_this.parent().parent().find("td").eq("11").children().html()),
                    _ = $.trim(_this.parent().parent().find("td").eq("12").children().html()),
                    v = $.trim(_this.parent().parent().find("td").eq("13").children().html()),
                    k = $.trim(_this.parent().parent().find("td").eq("17").children().html()),
                    b = $.trim(_this.parent().parent().find("td").eq("19").children().html());
                sale_date1 = o.split("/"), o = sale_date1[2] + "-" + sale_date1[1] + "-" + sale_date1[0], i = [s, o, r, "ebay", "$", l, p, u, f, m, g, _, v, k, b, t, d, h], n[c] = toObject(a, i), c++
            }
        }), 0 === n.length ? popMessage("danger", "Wrong! Please  select checkbox!") : n.length > 200 ? popMessage("danger", "Wrong! you can't select more than 200  at once ") : (console.log(n), $("#loader").fadeIn(), $.ajax({
            url: "multinewsheet",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            method: "POST",
            data: {
                fee_array: n
            },
            success: function(e) {
                "valid" == e.status ? ($("#loader").fadeOut(), popMessage("success", "The selected sales has been added!")) : ($("#loader").fadeOut(), popMessage("danger", "Wrong! Please upgrade your account!"))
            },
            error: function(e, t, a) {
                popMessage("danger", "Wrong! Please upgrade your account!")
            }
        }))
    }
}), list();