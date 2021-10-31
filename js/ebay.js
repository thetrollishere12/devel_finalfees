$(document).ready(function () {
    function e() {
        var e = { useEasing: !0, useGrouping: !0, separator: ",", decimal: "." },
            t = 0,
            n = 0;
        $("input:checkbox:checked").each(function () {
            t += isNaN(parseFloat($(this).val())) ? 0 : parseFloat($(this).val());
        }),
            (n = $("#upgrade-double").is(":checked") ? 2 * t : t);
        var a = parseFloat($("input[name=sold_price]").val() || 0),
            i = parseFloat($("input[name=shipping_charge]").val() || 0),
            s = parseFloat($("input[name=shipping_cost]").val() || 0),
            c = parseFloat($("input[name=item_cost]").val() || 0),
            l = $("input[name=percent]").val() / 100,
            o = parseFloat($("input[name=item_tax]").val() / 100 || 0),
            p = parseFloat($("input[name=remitted_tax]").val() || 0),
            r = a * (r = parseFloat($("input[name=ad_cost]").val() / 100 || 0)),
            u = 0,
            d = 0.1,
            h = 0.3;
        if (((t = a + i).toFixed(2) > 0 && (u = parseFloat($("input[name=standard]").val() || 0)), (h = $("input:checkbox:eq(0)").is(":checked") ? 0 : 0.3), "no" == $("select[name=t_r_seller]").val())) d = d;
        else if ("yes" == $("select[name=t_r_seller]").val()) d = (9 * d) / 10;
        if ("yes" == $("select[name=ebay_store]").val())
            var m = $("select[name=category]").find(":selected").val(),
                b = parseFloat(t * d * m);
        else b = parseFloat(t * d);
        var g = (t + p) * l + u + c + s + b + n + h + r;
        g < 0 && (g = 0);
        var v = (t - g).toFixed(2);
        if (v < 0) o = 0;
        var x = v - t * o,
            f = (x / g) * 100 || 0,
            k = (x / t) * 100 || 0;
        x < 0 && ((k = 0), (f = 0)), (k !== 1 / 0 && k !== -1 / 0) || (k = 0), (f !== 1 / 0 && f !== -1 / 0) || (f = 0), profit_c(x, f, k);
        var _ = new CountUp("p-fees", 0, (a + i + p) * l + u, 2, 0.2, e),
            F = new CountUp("other-fees", 0, n, 2, 0.2, e),
            y = new CountUp("main-tax", 0, t * o + p, 2, 0.2, e),
            w = new CountUp("main-fees", 0, b + h + r, 2, 0.2, e),
            C = new CountUp("main-return", 0, f, 2, 0.2, e),
            U = new CountUp("main-margin", 0, k, 2, 0.2, e),
            q = new CountUp("main-profit", 0, x, 2, 0.2, e);
        graph(a, i, s, c, y.endVal, _.endVal, F.endVal, w.endVal, q.endVal), w.error ? console.error(w.error) : (_.start(), w.start(), C.start(), U.start(), q.start(), F.start(), y.start());
    }
    e(),
        $("#main-calculator")
            .children()
            .keyup(function () {
                e();
            }),
        $("button[name=p-reset]").click(function () {
            $("input[name=sold_price],input[name=shipping_charge],input[name=shipping_cost],input[name=item_cost],input[name=name],input[name=remitted_tax]").val(null),
                $("input[name=item_tax]").val($("input[name=item_tax]").attr("id")),
                $("input[type=checkbox]").prop("checked", !1),
                $("input[type=checkbox]").first().prop("checked", !0),
                $("input[name=percent]").val(2.9),
                $("input[name=standard]").val(".30"),
                e();
        }),
        $("select[name=show]").change(function () {
            "hide" == $(this).val() ? $(".list_up_ctn").slideUp() : "show" == $(this).val() && $(".list_up_ctn").slideDown();
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
                  $(".standard").slideUp());
        }),
        $("select").change(function () {
            e();
        }),
        $("select[name=ebay_store]").change(function () {
            "yes" == $(this).val() ? $("#category-slide").slideDown() : $("#category-slide").slideUp();
        }),
        $("input:checkbox").change(function () {
            e();
        }),
        $("input:checkbox:eq(2)").click(function () {
            $("input:checkbox:eq(2)").is(":checked")
                ? $("input:checkbox").each(function () {
                      var e =
                          (2 *
                              $(this)
                                  .siblings(".double")
                                  .text()
                                  .replace(/[^0-9\s]+/gi, "")) /
                          100;
                      console.log(e),
                          $(this)
                              .siblings(".double")
                              .text("+ $" + e.toFixed(2)),
                          $(this)
                              .siblings(".value")
                              .text("+ $" + e.toFixed(2) + " - Includes Gallery Plus, Scheduled Listing & Subtitle");
                  })
                : $("input:checkbox:eq(2)").is(":not(:checked)") &&
                  $("input:checkbox").each(function () {
                      var e =
                          $(this)
                              .siblings(".double")
                              .text()
                              .replace(/[^0-9\s]+/gi, "") /
                          2 /
                          100;
                      $(this)
                          .siblings(".double")
                          .text("+ $" + e.toFixed(2)),
                          $(this)
                              .siblings(".value")
                              .text("+ $" + e.toFixed(2) + " - Includes Gallery Plus, Scheduled Listing & Subtitle");
                  });
        }),
        $("input:checkbox:eq(9)").click(function () {
            $("input:checkbox:eq(9)").is(":checked")
                ? $(".disabled").each(function () {
                      $(this).prop("disabled", !0).prop("checked", !1).siblings(".upgrade-cost").addClass("grey").parent().addClass("grey");
                  })
                : $("input:checkbox:eq(9)").is(":not(:checked)") &&
                  $(".disabled").each(function () {
                      $(this).prop("disabled", !1).siblings(".upgrade-cost").removeClass("grey").parent().removeClass("grey");
                  });
        });
});
