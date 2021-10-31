$(document).ready(function () {
    function e() {
        var e = { useEasing: !0, useGrouping: !0, separator: ",", decimal: "." },
            t = parseFloat($("input[name=sold_price]").val() || 0),
            n = parseFloat($("input[name=shipping_charge]").val() || 0),
            a = parseFloat($("input[name=shipping_cost]").val() || 0),
            i = parseFloat($("input[name=item_cost]").val() || 0),
            s = parseFloat($("input[name=item_tax]").val() / 100 || 0),
            percent = $("input[name=percent]").val() / 100,
            r = $("select[name=direct_deposit]").val(),
            o = t + n,
            standard = 0,
            p = i + a + 0.1 * o;
        if (t.toFixed(2) > 0) (standard = parseFloat($("input[name=standard]").val() || 0)), p < 0 && (p = 0);
        var c = (o - p).toFixed(2);
        if (((direct_deposit_fee = "yes" == r && c < 10 ? 2 : 0), c < 0)) s = 0;
        var l = c - o * s,
            d = (l / p) * 100 || 0,
            u = (l / t) * 100 || 0;
        l < 0 && ((u = 0), (d = 0)), (u !== 1 / 0 && u !== -1 / 0) || (u = 0), (d !== 1 / 0 && d !== -1 / 0) || (d = 0), profit_c(l, d, u);
        var m = new CountUp("other-fees", 0, direct_deposit_fee + t * percent + standard, 2, 0.2, e),
            _ = new CountUp("main-tax", 0, o * s, 2, 0.2, e),
            h = new CountUp("main-return", 0, d, 2, 0.2, e),
            f = new CountUp("main-margin", 0, u, 2, 0.2, e),
            g = new CountUp("main-fees", 0, 0.1 * o, 2, 0.2, e),
            v = new CountUp("main-profit", 0, l, 2, 0.2, e);
        graph(t, n, a, i, _.endVal, m.endVal, 0, g.endVal, v.endVal), m.error ? console.error(paypal_fees.error) : (m.start(), g.start(), f.start(), h.start(), v.start(), _.start());
    }
    e(),
        $("#main-calculator")
            .children()
            .keyup(function () {
                e();
            }),
        $("button[name=p-reset]").click(function () {
            $("input[name=sold_price],input[name=shipping_charge],input[name=shipping_cost],input[name=item_cost],input[name=name]").val(null),
                $("input[name=item_tax]").val($("input[name=item_tax]").attr("id")),
                $("select[name=direct_deposit]").val("no"),
                e();
        }),
        $("button[name=p-edit]").click(function () {
            "Edit Fees" == $(this).text()
                ? ($(".standard input").each(function () {
                      $(this).prop("disabled", !1);
                  }),
                  $(".standard").slideDown(),
                  $(this).text("Done Edit"))
                : ($(".standard input").each(function () {
                      $(this).prop("disabled", !0);
                  }),
                  $(this).text("Edit Fees"),
                  e(),
                  $(".standard").slideUp());
        }),
        $("select").change(function () {
            e();
        });
});
