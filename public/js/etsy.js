$(document).ready(function() {
    calculations();
    select_change();
    $('#main-calculator').children().keyup(function() {
        calculations();
        select_change();
    });
    $('button[name=p-reset]').click(function() {
        $('input[name=sold_price],input[name=shipping_charge],input[name=shipping_cost],input[name=item_cost],input[name=ad_cost],input[name=name]').val(null);
        $('input[name=item_tax]').val($('input[name=item_tax]').attr('id'));
        $("select[name=etsy_payment]").val(1);
        var value = $("select[name=etsy_payment]").find(":selected").text().split('+');
        $('input[name=percent]').val(parseFloat(value[0].replace("%", "")));
        $('input[name=standard]').val(parseFloat(value[1].replace("$", "")));
        calculations()
    })
    $('button[name=p-edit]').click(function() {
        if ($(this).text() == "Edit Fees") {
            $('.standard input').each(function() {
                $(this).prop("disabled", !1)
            });
            $('.standard').slideDown();
            $(this).text('Done Edit')
        } else {
            $('.standard input').each(function() {
                $(this).prop("disabled", !0)
            });
            $(this).text('Edit Fees');
            calculations();
            $('.standard').slideUp()
        }
    });
    $("select").change(function() {
        select_change()
    });

    function select_change() {
        var value = $("select[name=etsy_payment]").find(":selected").text().split('+');
        $('input[name=percent]').val(parseFloat(value[0].replace("%", "")));
        $('input[name=standard]').val(parseFloat(value[1].replace("$", "")));
        calculations()
    }

    function calculations() {
        var options = {  
            useEasing: !0,
              useGrouping: !0,
              separator: ',',
              decimal: '.',
        };
        var sold_price = parseFloat($('input[name=sold_price]').val() || 0);
        var shipping_charge = parseFloat($('input[name=shipping_charge]').val() || 0);
        var shipping_cost = parseFloat($('input[name=shipping_cost]').val() || 0);
        var item_cost = parseFloat($('input[name=item_cost]').val() || 0);
        var ad_cost = parseFloat($('input[name=ad_cost]').val() || 0)
        var percent = $('input[name=percent]').val() / 100;
        var tax = parseFloat($('input[name=item_tax]').val() / 100 || 0)
        var flat_fee = 0;
        var etsy_flat_fee = 0;
        var etsy_transaction_fee = 0;
        var etsy_processing_fee = 0;
        var etsy_processing_flat_fee = 0;
        var total = sold_price + shipping_charge;
        if (total.toFixed(2) > 0) {
            flat_fee = parseFloat($('input[name=standard]').val() || 0);
            var etsy_flat_fee = .20;
            var etsy_transaction_fee = .05
        }
        var combine_fees = (total * percent + flat_fee) + (total * etsy_transaction_fee);
        var costfees = item_cost + ad_cost + shipping_cost + combine_fees + etsy_flat_fee;
        if (costfees < 0) {
            costfees = 0
        }
        var profit_number = ((total) - costfees).toFixed(2);
        if (profit_number < 0) {
            var tax = 0
        }
        var profit_total = profit_number - (profit_number * tax);
        var return_total = (profit_total / costfees) * 100 || 0;
        var margin_total = (profit_total / total) * 100 || 0;
        if (profit_total < 0) {
            margin_total = 0;
            return_total = 0
        }
        if (margin_total === Infinity || margin_total === -Infinity) {
            margin_total = 0
        }
        if (return_total === Infinity || return_total === -Infinity) {
            return_total = 0
        }
        profit_c(profit_total, return_total, margin_total);
        var other_fees = new CountUp('p-fees', 0, (total) * percent + flat_fee, 2, .2, options);
        var main_tax = new CountUp('main-tax', 0, profit_number * tax, 2, .2, options);
        var main_fees = new CountUp('main-fees', 0, (total * etsy_transaction_fee) + etsy_flat_fee, 2, .2, options);
        var main_return = new CountUp('main-return', 0, return_total, 2, .2, options);
        var main_margin = new CountUp('main-margin', 0, margin_total, 2, .2, options);
        var main_profit = new CountUp('main-profit', 0, profit_total, 2, .2, options);
        graph(sold_price, shipping_charge, shipping_cost, item_cost, main_tax.endVal, 0, other_fees.endVal, main_fees.endVal, main_profit.endVal);
        if (!other_fees.error) {  
            other_fees.start();
            main_fees.start();
            main_margin.start();
            main_return.start();
            main_profit.start()
            main_tax.start()
        } else {  
            console.error(other_fees.error)
        }
    }
})