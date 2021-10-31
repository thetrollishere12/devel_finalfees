$(document).ready(function () {
    function e(e) {
        "summary" === e
            ? $("#title").text("Summary").addClass("summary-page")
            : $("#title")
                  .text($("#" + e + ".spreadsheet-name-list").text())
                  .removeClass("summary-page"),
            $(".sub-spreadsheet").removeClass("s-click"),
            $("#" + e + ".sub-spreadsheet").slideDown(),
            $(".sub-spreadsheet")
                .not($("#" + e + ".sub-spreadsheet"))
                .slideUp(),
            $(".b-click").removeClass("b-click").addClass("h-grey"),
            $("#" + e + ".sheet")
                .addClass("b-click")
                .removeClass("h-grey"),
            $.ajax({
                url: "yearly-req",
                headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
                data: { spreadsheet_id: $(".b-click").attr("id"), sheet_sum: $("#title").attr("class") },
                method: "POST",
                beforeSend: function () {
                    $(".load_ctn").show();
                },
                success: function (e) {
                    for (var a = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0], t = 0; t < e.sales.length; t++) {
                        a[+(r = e.sales[t].sale_date.split("-"))[1]] || (a[+r[1]] = []), a[+r[1]].push(e.sales[t]);
                    }
                    var s = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
                    for (t = 0; t < e.expense.length; t++) {
                        var r;
                        s[+(r = e.expense[t].date.split("-"))[1]] || (s[+r[1]] = []), s[+r[1]].push(e.expense[t]);
                    }
                    var n = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                        o = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                        d = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                        l = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                        i = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
                    for (t = 0; t < a.length; t++)
                        if (0 != a[t])
                            for (e = 0; e < a[t].length; e++)
                                (n[t - 1] = n[t - 1] += parseFloat(a[t][e].sold_price) + parseFloat(a[t][e].shipping_charge)),
                                    (o[t - 1] = o[t - 1] += parseFloat(a[t][e].item_cost) + parseFloat(a[t][e].shipping_cost)),
                                    (d[t - 1] = d[t - 1] += parseFloat(a[t][e].fees) + parseFloat(a[t][e].other_fees) + parseFloat(a[t][e].processing_fees) + parseFloat(a[t][e].tax)),
                                    (l[t - 1] = l[t - 1] += parseFloat(a[t][e].profit));
                    for (t = 0; t < s.length; t++) if (0 != s[t]) for (e = 0; e < s[t].length; e++) i[t - 1] = i[t - 1] += parseFloat(s[t][e].amount) + parseFloat(s[t][e].tax);
                    null != window.myChart && window.myChart.destroy(),
                        (window.myChart = new Chart($("#barchart"), {
                            type: "horizontalBar",
                            data: {
                                labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
                                datasets: [
                                    { label: "Sold/Shipping Charge", backgroundColor: "#3490dc", data: n },
                                    { label: "Item/Shipping Cost", backgroundColor: "rgba(255, 193, 7, .8)", data: o },
                                    { label: "Tax/Fees", backgroundColor: "rgba(226, 40, 58, .8)", data: d },
                                    { label: "Expense", backgroundColor: "rgba(247, 104, 32,.8)", data: i },
                                    { label: "Profit", backgroundColor: "rgba(40, 167, 69, .8)", data: l },
                                ],
                            },
                            options: { legend: { display: !0 }, scales: { xAxes: [{ ticks: { fontSize: 9 } }] } },
                        }));
                },
                error: function (e, a, t) {},
            });
    }
    function a() {
        $.ajax({
            url: "spreadsheet/sheet_list",
            method: "POST",
            headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
            success: function (e) {
                for (var a = "", t = e.list, s = 0; s < t.length; s++)
                    a +=
                        '<div class="sheet spreadsheet-name h-grey" id="' +
                        t[s].spreadsheet_id +
                        '"><div class="spreadsheet-name-list" id="' +
                        t[s].spreadsheet_id +
                        '">' +
                        t[s].spreadsheet_name +
                        '</div><span class="icon-cog fix-btn" data-toggle="modal" data-target="#name_edit"></span></div>';
                $(".sheet-ul").empty().append(a);
            },
        });
    }
    function t(e, a) {
        "valid" === e || "empty" === e ? $(".popup_status").text(a.success).css({ background: a.color }) : $(".popup_status").text("Error. Please Try Again").css({ background: "#ea3f4f" }),
            $(".popup_status").stop(!0).fadeIn("fast").delay(1e3).fadeOut("fast");
    }
    e("summary"),
        a(),
        $(document).on("click", ".sheet", function (a) {
            e($(this).attr("id"));
        }),
        $("#new_sheet").click(function (e) {
            $.ajax({
                url: "spreadsheet/store",
                headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
                method: "POST",
                data: { action: "new_sheet", spreadsheet_name: $("input[name=spreadsheet_name]").val() },
                success: function (e) {
                    $("input[name=spreadsheet_name]").val(""), $(".modal").modal("hide"), a(), t(e.status, { success: "New Spreadsheet Saved", color: "#4caf50" }), "upgrade" === e.account && $("#sub_status").modal("show");
                },
                error: function (e, a, s) {
                    t(s);
                },
            });
        }),
        $(document).on("click", ".list_delete", function () {
            var s = $("input[name=rename_id]").val(),
                r = $("input[name=current_name]").val(),
                n = $(this).text();
            "Delete List" === n &&
                $.ajax({
                    url: "spreadsheet/list_delete",
                    headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
                    method: "POST",
                    data: { spreadsheet_id: s, spreadsheet_name: r, action: n, sheet_sum: $("#title").attr("class") },
                    success: function (r) {
                        a(),
                            t(r, { success: "Spreadsheet Deleted", color: "#ea3f4f" }),
                            $(".spreadsheet-name#" + s)
                                .prev()
                                .attr("id"),
                            e("summary"),
                            $(".modal").modal("hide");
                    },
                    error: function (e, a, s) {
                        t(s), $(".modal").modal("hide");
                    },
                });
        }),
        $(document).on("click", ".fix-btn", function () {
            var e = $(this).parent().attr("id"),
                a = $(this).siblings(".spreadsheet-name-list").text();
            $("#spreadsheet_rename").val(a), $("input[name=rename_id]").val(e), $("input[name=current_name]").val(a);
        }),
        $(document).on("click", "#new_sheet_name", function () {
            var e = $("input[name=rename_id]").val(),
                s = $("#spreadsheet_rename").val(),
                r = $(this).text();
            "Save" === r &&
                $.ajax({
                    url: "spreadsheet/list_update",
                    headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
                    method: "POST",
                    data: { spreadsheet_id: e, new_name: s, action: r, sheet_sum: $("#title").attr("class") },
                    success: function (e) {
                        a(), $(".modal").modal("hide"), t(e, { success: "New Spreadsheet Name Saved", color: "#4caf50" });
                    },
                    error: function (e, a, s) {
                        t(s), $(".modal").modal("hide");
                    },
                });
        });
});
