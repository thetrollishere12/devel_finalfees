$(document).ready(function() {

    function a() {
        $.ajax({
            url: "pg_sheet_list_expense",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            method: "POST",
            success: function(e) {
                console.log(e);
                $("#expense-list").empty().append(e)
            },
            error: function(e, a, t) {
                $("#expense-list").empty().append("Error")
            }
        })
    }
    a()

    function e() {
        var e = {
                useEasing: !0,
                useGrouping: !0,
                separator: ",",
                decimal: "."
            },
            a = parseFloat($("input[name=name]").val() || 0),
            b = parseFloat($("input[name=expense]").val() || 0),
            c = parseFloat($("input[name=fees]").val() || 0),
            d = parseFloat($("input[name=item_tax]").val() || 0);

            gg = new CountUp("main-fees", 0, b+(b*(d/100)), 2, 0.2, e);
            tt = new CountUp("main-tax", 0, b*(d/100), 2, 0.2, e);
            gg.error ? console.error(gg.error) : (gg.start(),tt.start());


            expense(b,c,b*(d/100));
    }
    e()


    $("#main-calculator").children().keyup(function() {
        e()
    }),



    $("button[name=p-reset]").click(function() {
        $("input[name=name],textarea[name=description],input[name=expense]").val(null),
        e()
    });

    var p = moment().format("YYYY-MM-DD");
    $("input[name=date]").val(p);
    $(document).on("click", ".add_expense_btn", function() {
        if (!(p = $("input[name=name]").val()) || 0 === p.length) var p = $("input[name=name]").attr("class");
        $.ajax({
            url: "pages/store_expense",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            method: "POST",
            data: {
                spreadsheet_id: $("select[name=selects]").find("option:selected").attr("id"),
                date: $("input[name=date]").val(),
                spreadsheet_name: $("select[name=selects]").find("option:selected").text().replace("Spreadsheet: ", ""),
                platform: $("input[name=name]").attr("class"),
                currency: $("select[name=currency]").val(),
                name:p,
                description:$("textarea[name=description]").val(),
                expense: parseFloat($("input[name=expense]").val() || 0),
                tax: parseFloat($("#main-tax").text().replace(/\,/g, "") || 0),
                account:$("select[name=account]").find("option:selected").text(),
                currency: $("#currency option:selected").val()
            },
            success: function(e) {
                $(".alert").stop(!0).fadeOut(100).fadeIn(1e3), $(".alert-message").empty().append(e.message), $(".alert,.upgrade_acc").css({
                    background: e.color,
                    color: e.text
                }), $(".p-reset").click()
            },
            error: function(e, a, t) {
                $(".alert").stop(!0).fadeOut(100).fadeIn(1e3), $(".alert-message").empty().append("Error Try Again"), $(".alert,.upgrade_acc").css({
                    background: "#ea3f4f",
                    color: "white"
                })
            }
        })
    });



});

function expense(b,c,d) {
    null!=window.myChart&&window.myChart.destroy();
    window.myChart=new Chart($("#barchart"), {
        type:"bar", data: {
            labels:["Total Expense", "Fees", "Tax"], datasets:[ {
                label: "Total Expense", data: [b], backgroundColor: "#007bff"
            }
            , {
                label: "Fees", data: [0, c], backgroundColor: "#ffc107"
            }
            , {
                label: "Tax", data: [0, 0, d], backgroundColor: "#4caf50"
            }
            ]
        }
        , options: {
            response:!1, legend: {
                display: !1
            }
            , scales: {
                xAxes:[ {
                    stacked: !0
                }
                ], yAxes:[ {
                    stacked: !0
                }
                ]
            }
        }
    }
    )
}

expense();