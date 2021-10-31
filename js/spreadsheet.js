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
            $("select[name=yearly] option").attr("id", e),
            $.ajax({
                url: "spreadsheet/select",
                headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
                method: "POST",
                data: {
                    spreadsheet_id: e,
                    sheet_sum: $("#title").attr("class"),
                    currency:$("select[name=currency_name]").val(),
                    name: $("input[name=search]").val(),
                    sort: $("select[name=sort]").val(),
                    sort_order: $("select[name=sort_order]").val(),
                    start_date: $("input[name=start]").val(),
                    end_date: $("input[name=end]").val(),
                },
                beforeSend: function () {
                    $(".load_ctn").show();
                },
                success: function (e) {
                    console.log(e.sales.spreadsheet_sales);
                        $(".load_ctn").hide(),
                        $(".spreadsheet-grid").empty().append(e.limit),
                        $(".expense-grid").empty().append(e.exlimit),
                        l(e.sales.spreadsheet_sales, e.expense.spreadsheet_ex),
                        r(),
                        a(e.sales.spreadsheet_sales, e.expense.spreadsheet_ex);
                },
                error: function (e, t, s) {
                    console.log(e), i(s);
                },
            });
    }
    function t(e) {
        $.ajax({
            url: "paginate?page=" + e,
            data: {
                spreadsheet_id: $(".b-click").attr("id"),
                sheet_sum: $("#title").attr("class"),
                name: $("input[name=search]").val(),
                sort: $("select[name=sort]").val(),
                sort_order: $("select[name=sort_order]").val(),
                start_date: $("input[name=start]").val(),
                end_date: $("input[name=end]").val(),
            },
            beforeSend: function () {
                $(".load_ctn").show();
            },
            success: function (t) {
                $(".load_ctn").hide(), $(".page").text(e), $(".spreadsheet-grid").empty().append(t);
            },
        });
    }
    function s(e) {
        $.ajax({
            url: "paginate_ex?page=" + e,
            data: {
                spreadsheet_id: $(".b-click").attr("id"),
                sheet_sum: $("#title").attr("class"),
                name: $("input[name=search]").val(),
                sort: $("select[name=sort]").val(),
                sort_order: $("select[name=sort_order]").val(),
                start_date: $("input[name=start]").val(),
                end_date: $("input[name=end]").val(),
            },
            beforeSend: function () {
                $(".load_ctn").show();
            },
            success: function (t) {
                $(".load_ctn").hide(), $(".page").text(e), $(".expense-grid").empty().append(t);
            },
        });
    }
    function a(e, t) {
        $("#sum_sales").text(e.sales),
            $("#sum_sold").text(e.sold_price.toFixed(2)),
            $("#sum_ship_charge").text(e.shipping_charge.toFixed(2)),
            $("#sum_cost").text(e.item_cost.toFixed(2)),
            $("#sum_ship_cost").text(e.shipping_cost.toFixed(2)),
            $("#sum_fees").text(e.fees.toFixed(2)),
            $("#sum_p_fees").text(e.p_fees.toFixed(2)),
            $("#sum_tax").text(e.tax.toFixed(2)),
            $("#sum_expense").text(t.expense.toFixed(2)),
            $("#sum_profit").text((e.profit - t.expense).toFixed(2));
    }
    function n() {
        $.ajax({
            url: "spreadsheet/sheet_list",
            method: "POST",
            headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
            success: function (e) {
                for (var t = "", s = e.list, a = 0; a < s.length; a++)
                    t +=
                        '<div class="sheet spreadsheet-name h-grey" id="' +
                        s[a].spreadsheet_id +
                        '"><div class="spreadsheet-name-list" id="' +
                        s[a].spreadsheet_id +
                        '">' +
                        s[a].spreadsheet_name +
                        '</div><span class="icon-cog fix-btn" data-toggle="modal" data-target="#name_edit"></span></div>';
                $(".sheet-ul").empty().append(t);
            },
        });
    }
    function i(e, t) {
        "valid" === e || "empty" === e ? $(".popup_status").text(t.success).css({ background: t.color }) : $(".popup_status").text("Error. Please Try Again").css({ background: "#ea3f4f" }),
            $(".popup_status").stop(!0).fadeIn("fast").delay(1e3).fadeOut("fast");
    }
    function r() {
        var e = $("select[name=yearly] option:selected").val(),
            t = $("select[name=yearly] option:selected").text(),
            s = $("select[name=yearly] option:selected").attr("id"),
            a = $("select[name=year] option:selected").val();
        switch (e) {
            case "sold_price":
            case "shipping_charge":
                var n = "#3490dc";
                break;
            case "item_cost":
            case "shipping_cost":
                n = "rgba(255, 193, 7, 0.9)";
                break;
            case "fees":
            case "other_fees":
            case "processing_fees":
            case "total_fees":
            case "tax":
                n = "rgba(200, 35, 51, 0.8)";
                break;
            case "expense":
                n = "rgba(247, 104, 32,.8)";
                break;
            case "profit":
                n = "rgba(76, 175, 80, 0.8)";
        }
        $.ajax({
            url: "spreadsheet/yearly",
            headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
            method: "POST",
            data: { id: s, type: e, year: a, sheet_sum: $("#title").attr("class") },
            beforeSend: function () {
                $(".load_ctn").show();
            },
            success: function (e) {
                console.log(e);
                $(".load_ctn").hide(),
                    null != window.lineChart && window.lineChart.destroy(),
                    (window.lineChart = new Chart($("#line"), {
                        type: "line",
                        data: { responsive: !0, labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"], datasets: [{ label: [t], data: e, backgroundColor: n, borderColor: n }] },
                        options: {
                            plugins: {
                                zoom: {
                                    pan: { enabled: !0, mode: "xy", rangeMin: { x: null, y: null }, rangeMax: { x: null, y: null } },
                                    zoom: { enabled: !0, mode: "y", rangeMin: { x: null, y: null }, rangeMax: { x: null, y: null }, speed: 0.05 },
                                },
                            },
                            scales: { xAxes: [{ ticks: { fontSize: 8 } }], yAxes: [{ ticks: { fontSize: 8 } }] },
                            elements: { line: { tension: 0 } },
                            legend: { display: !1 },
                        },
                    }));
            },
            error: function (e, t, s) {
                console.log(e);
            },
        });
    }
    function l(e, t) {
        null != window.myChart && (window.myChart.destroy(), window.myPieChart.destroy());
        var s = (parseFloat(e.sold_price) + parseFloat(e.shipping_charge)).toFixed(2),
            a = (parseFloat(e.item_cost) + parseFloat(e.shipping_cost)).toFixed(2),
            n = (parseFloat(e.fees) + parseFloat(e.tax) + parseFloat(e.p_fees)).toFixed(2),
            i = ((t = parseFloat(t.expense).toFixed(2)), (e.profit - t).toFixed(2)),
            r = [s, a, n, t, i];
        (window.myPieChart = new Chart($("#chart"), {
            type: "pie",
            data: {
                responsive: !0,
                labels: ["Sold/Shipping Charge", "Item/Shipping Cost", "Total Tax/Fees", "Total Expense"],
                datasets: [
                    {
                        data: [s, a, n, t],
                        backgroundColor: ["#3490dc", "rgba(255, 193, 7, .8)", "rgba(226, 40, 58, .8)", "rgba(247, 104, 32,.8)"],
                        borderColor: ["#3490dc", "rgba(255, 193, 7, .8)", "rgba(226, 40, 58, .8)", "rgba(247, 104, 32,.8)"],
                    },
                ],
            },
        })),
            (window.myChart = new Chart($("#barchart"), {
                type: "bar",
                data: {
                    responsive: !0,
                    labels: ["Sold/Shipping Charge", "Item/Shipping Cost", "Total Tax/Fees", "Total Expense", "Profit"],
                    datasets: [{ label: "Total Amount", data: r, backgroundColor: ["#3490dc", "rgba(255, 193, 7, .8)", "rgba(226, 40, 58, .8)", "rgba(247, 104, 32,.8)", "rgba(40, 167, 69, .8)"] }],
                },
                options: { legend: { display: !1 }, scales: { xAxes: [{ ticks: { fontSize: 9 } }] } },
            }));
    }
    $("input[name=start]").val(moment().subtract(12, "month").format("YYYY-MM-DD")),
        $("input[name=end]").val(moment().format("YYYY-MM-DD")),
        n(),
        e("summary"),
        $("select[name=sort],select[name=sort_order],input[name=end],input[name=start]").change(function () {
            e($(".b-click").attr("id"));
        }),
        $(".reset_filter").click(function () {
            location.reload();
        }),
        $(".search_btn").click(function () {
            e($(".b-click").attr("id"));
        }),
        $(document).on("click", ".sheet", function (t) {
            e($(this).attr("id"));
        }),
        $(document).on("click", ".sub-spreadsheet", function (e) {
            $(this).addClass("s-click").siblings().removeClass("s-click"), $(this).attr("id"), $(this).text();
        }),
        $(document).on("click", ".spreadsheet-grid .pagination a", function (e) {
            e.preventDefault(), t($(this).attr("href").split("page=")[1]);
        }),
        $(document).on("click", ".expense-grid .pagination a", function (e) {
            e.preventDefault(), s($(this).attr("href").split("page=")[1]);
        }),
        $("#new_sheet").click(function (e) {
            $.ajax({
                url: "spreadsheet/store",
                headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
                method: "POST",
                data: { action: "new_sheet", spreadsheet_name: $("input[name=spreadsheet_name]").val() },
                success: function (e) {
                    $("input[name=spreadsheet_name]").val(""),
                    $(".modal").modal("hide"),
                    n(),
                    i(e.status, { success: "New Spreadsheet Saved", color: "#4caf50" }),
                    "upgrade" === e.account && $("#sub_status").modal("show");
                },
                error: function (e, t, s) {
                    i(s);
                },
            });
        }),
        $(document).on("click", ".list_delete", function () {
            var t = $("input[name=rename_id]").val(),
                s = $("input[name=current_name]").val(),
                a = $(this).text();
            "Delete List" === a &&
                $.ajax({
                    url: "spreadsheet/list_delete",
                    headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
                    method: "POST",
                    data: { spreadsheet_id: t, spreadsheet_name: s, action: a, sheet_sum: $("#title").attr("class") },
                    success: function (s) {
                        n(),
                            i(s, { success: "Spreadsheet Deleted", color: "#ea3f4f" }),
                            $(".spreadsheet-name#" + t)
                                .prev()
                                .attr("id"),
                            e("summary"),
                            $(".modal").modal("hide");
                    },
                    error: function (e, t, s) {
                        i(s), $(".modal").modal("hide");
                    },
                });
        }),
        $(document).on("click", ".fix-btn", function () {
            var e = $(this).parent().attr("id"),
                t = $(this).siblings(".spreadsheet-name-list").text();
            $("#spreadsheet_rename").val(t), $("input[name=rename_id]").val(e), $("input[name=current_name]").val(t);
        }),
        $(document).on("click", "#new_sheet_name", function () {
            var e = $("input[name=rename_id]").val(),
                t = $("#spreadsheet_rename").val(),
                s = $(this).text();
            "Save" === s &&
                $.ajax({
                    url: "spreadsheet/list_update",
                    headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
                    method: "POST",
                    data: { spreadsheet_id: e, new_name: t, action: s, sheet_sum: $("#title").attr("class") },
                    success: function (e) {
                        n(), $(".modal").modal("hide"), i(e, { success: "New Spreadsheet Name Saved", color: "#4caf50" });
                    },
                    error: function (e, t, s) {
                        i(s), $(".modal").modal("hide");
                    },
                });
        }),
        $(document).on("click", ".sales_delete", function (e) {
            $(this).val(),
                $.ajax({
                    url: "spreadsheet/delete_sale",
                    headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
                    method: "POST",
                    data: {
                        item_id: $(this).attr("id"),
                        spreadsheet_id: $(this).parent().siblings("input").val(),
                        sheet_sum: $("#title").attr("class"),
                        name: $("input[name=search]").val(),
                        sort: $("select[name=sort]").val(),
                        sort_order: $("select[name=sort_order]").val(),
                        start_date: $("input[name=start]").val(),
                        end_date: $("input[name=end]").val(),
                        action: "destroy_sales",
                    },
                    success: function (e) {
                        var s = $(".spreadsheet-grid span.page-link").text().replace("›", "").replace("‹", "");
                        25 * s == e.sales.spreadsheet_sales.sales * s && (s -= 1),
                            t(s),
                            a(e.sales.spreadsheet_sales, e.expense.spreadsheet_ex),
                            l(e.sales.spreadsheet_sales, e.expense.spreadsheet_ex),
                            r(),
                            i(e.expense.status, { success: "Sale Deleted", color: "#ea3f4f" });
                    },
                    error: function (e, t, s) {
                        i(s);
                    },
                });
        }),
        $(document).on("click", ".expense_delete", function (e) {
            $(this).val(),
                $.ajax({
                    url: "spreadsheet/delete_expense",
                    headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
                    method: "POST",
                    data: {
                        item_id: $(this).attr("id"),
                        spreadsheet_id: $(this).parent().siblings("input").val(),
                        sheet_sum: $("#title").attr("class"),
                        name: $("input[name=search]").val(),
                        sort: $("select[name=sort]").val(),
                        sort_order: $("select[name=sort_order]").val(),
                        start_date: $("input[name=start]").val(),
                        end_date: $("input[name=end]").val(),
                        action: "destroy_expense",
                    },
                    success: function (e) {
                        console.log(e);
                        var t = $(".expense-grid span.page-link").text().replace("›", "").replace("‹", "");
                        25 * t == e.sales.spreadsheet_sales.sales * t && (t -= 1),
                            s(t),
                            a(e.sales.spreadsheet_sales, e.expense.spreadsheet_ex),
                            l(e.sales.spreadsheet_sales, e.expense.spreadsheet_ex),
                            r(),
                            i(e.expense.status, { success: "Expense Deleted", color: "#ea3f4f" });
                    },
                    error: function (e, t, s) {
                        console.log(e), i(s);
                    },
                });
        }),
        $(document).on("click", ".sales_edit", function () {
            "Edit" === $(this).text()
                ? ($(this).text("Done").css({ background: "#4CAF50" }),
                  $(this).parent().siblings().children().children("input").css({ "pointer-events": "auto", background: "#edf5ff" }),
                  $(this).parent().siblings().children("input").css({ "pointer-events": "auto", background: "#edf5ff" }),
                  $(this).parent().siblings().children("select").css({ "pointer-events": "auto", background: "#edf5ff" }),
                  $(".sales_edit").not(this).css({ visibility: "hidden" }),
                  $(this).parent().next().children().css({ visibility: "visible" }))
                : "Done" === $(this).text() &&
                  ($(this).text("Edit").css({ background: "#3490dc" }),
                  $(this).parent().siblings().children().children("input").css({ "pointer-events": "none", background: "white" }),
                  $(this).parent().siblings().children("input").css({ "pointer-events": "none", background: "white" }),
                  $(this).parent().siblings().children("select").css({ "pointer-events": "none", background: "white" }),
                  $(".sales_edit").not(this).css({ visibility: "visible" }),
                  $(this).parent().next().children().css({ visibility: "hidden" }),
                  $.ajax({
                      url: "spreadsheet/edit_sale",
                      method: "POST",
                      headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
                      data: {
                          item_id: $(this).attr("id"),
                          sheet_sum: $("#title").attr("class"),
                          spreadsheet_id: $(this).parent().siblings("input").val(),
                          date: $(this).parent().siblings().children("input[name=date]").val(),
                          itm_name: $(this).parent().siblings().children("input[name=name]").val(),
                          currency: $(this).parent().siblings().children("select[name=currency]").val(),
                          sold_price: $(this).parent().siblings().children().children("input[name=sold_price]").val(),
                          item_cost: $(this).parent().siblings().children().children("input[name=item_cost]").val(),
                          shipping_charge: $(this).parent().siblings().children().children("input[name=shipping_charge]").val(),
                          shipping_cost: $(this).parent().siblings().children().children("input[name=shipping_cost]").val(),
                          fees: $(this).parent().siblings().children().children("input[name=fees]").val(),
                          other_fees: $(this).parent().siblings().children().children("input[name=other_fees]").val(),
                          processing_fees: $(this).parent().siblings().children().children("input[name=processing_fees]").val(),
                          tax: $(this).parent().siblings().children().children("input[name=tax]").val(),
                          profit: $(this).parent().siblings().children().children("input[name=profit]").val(),
                          action: "edit_sales",
                          sort: $("select[name=sort]").val(),
                          sort_order: $("select[name=sort_order]").val(),
                          start_date: $("input[name=start]").val(),
                          end_date: $("input[name=end]").val(),
                      },
                      success: function (e) {
                          console.log(e);
                          var s = $(".spreadsheet-grid span.page-link").text().replace("›", "").replace("‹", "");
                          25 * s == e.sales.spreadsheet_sales.sales * s && (s -= 1),
                              t(s),
                              a(e.sales.spreadsheet_sales, e.expense.spreadsheet_ex),
                              l(e.sales.spreadsheet_sales, e.expense.spreadsheet_ex),
                              r(),
                              i((e = e.sales.status), { success: "Edited Sale Saved", color: "#4caf50" });
                      },
                      error: function (e, t, s) {
                          console.log(e), i(e);
                      },
                  }));
        }),
        $(document).on("click", ".expense_edit", function () {
            "Edit" === $(this).text()
                ? ($(this).text("Done").css({ background: "#4CAF50" }),
                  $(this).parent().siblings().children().children("input").css({ "pointer-events": "auto", background: "#edf5ff" }),
                  $(this).parent().siblings().children("input").css({ "pointer-events": "auto", background: "#edf5ff" }),
                  $(this).parent().siblings().children("select").css({ "pointer-events": "auto", background: "#edf5ff" }),
                  $(".expense_edit").not(this).css({ visibility: "hidden" }),
                  $(this).parent().next().children().css({ visibility: "visible" }))
                : "Done" === $(this).text() &&
                  ($(this).text("Edit").css({ background: "#3490dc" }),
                  $(this).parent().siblings().children().children("input").css({ "pointer-events": "none", background: "white" }),
                  $(this).parent().siblings().children("input").css({ "pointer-events": "none", background: "white" }),
                  $(this).parent().siblings().children("select").css({ "pointer-events": "none", background: "white" }),
                  $(".expense_edit").not(this).css({ visibility: "visible" }),
                  $(this).parent().next().children().css({ visibility: "hidden" }),
                  $.ajax({
                      url: "spreadsheet/edit_expense",
                      method: "POST",
                      headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
                      data: {
                          item_id: $(this).attr("id"),
                          sheet_sum: $("#title").attr("class"),
                          spreadsheet_id: $(this).parent().siblings("input").val(),
                          date: $(this).parent().siblings().children("input[name=date]").val(),
                          itm_name: $(this).parent().siblings().children("input[name=name]").val(),
                          currency: $(this).parent().siblings().children("select[name=currency]").val(),
                          account: $(this).parent().siblings().children("select[name=account]").val(),
                          description: $(this).parent().siblings().children("input[name=description]").val(),
                          amount: $(this).parent().siblings().children().children("input[name=amount]").val(),
                          tax: $(this).parent().siblings().children().children("input[name=tax]").val(),
                          action: "edit_sales",
                          sort: $("select[name=sort]").val(),
                          sort_order: $("select[name=sort_order]").val(),
                          start_date: $("input[name=start]").val(),
                          end_date: $("input[name=end]").val(),
                      },
                      success: function (e) {
                          console.log(e);
                          var t = $(".expense-grid span.page-link").text().replace("›", "").replace("‹", "");
                          25 * t == e.sales.spreadsheet_sales.sales * t && (t -= 1),
                              s(t),
                              a(e.sales.spreadsheet_sales, e.expense.spreadsheet_ex),
                              l(e.sales.spreadsheet_sales, e.expense.spreadsheet_ex),
                              r(),
                              i((e = e.sales.status), { success: "Edited Expense Saved", color: "#4caf50" });
                      },
                      error: function (e, t, s) {
                          console.log(e), i(s);
                      },
                  }));
        }),
        $(document).on("click", ".reset_btn", function () {
            r();
        }),
        $("select[name=yearly],select[name=year]").change(function () {
            r();
        });

        $("select[name=currency_name]").change(function(){
        	e($(".b-click").attr("id"));
        });


        $("#download_btn").click(function(){

            spreadsheet_id = $(".b-click").attr("id");
            sheet_sum = $("#title").attr("class");
            name = $("input[name=search]").val();
            sort = $("select[name=sort]").val();
            sort_order = $("select[name=sort_order]").val();
            start_date = $("input[name=start]").val();
            end_date = $("input[name=end]").val();

            window.location="download?spreadsheet_id="+spreadsheet_id+"&sheet_sum="+sheet_sum+"&name"+name+"&sort="+sort+"&sort_order="+sort_order+"&start_date="+start_date+"&end_date="+end_date;

        });


});
