$("#auto_billing").addClass("select-blue");


function activeAccounts(){
    billing();
}

function billing(){
    
    var etsy_id = $('#active_account').find(":selected").val();
    var month = $('#active_month').val();
    var year = $('#active_year').val();
    $(".load_ctn").fadeIn();
    $.ajax({
        headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},
        url:"billing",
        method:"POST",
        data : {page:1,month:month,year:year,etsy_id:etsy_id},
        success:function(e){
            console.log(e)
            $(".load_ctn").fadeOut();
            $(".billing-grid").empty().append(e)
        },
        error:function(e,t,a){
            console.log(e);
            $(".billing-grid").empty().append("Error")
        }
    });

}

function activeBilling(e) {

    var etsy_id = $('#active_account').find(":selected").val();
    var month = $('#active_month').val();
    var year = $('#active_year').val();

    $(".load_ctn").fadeIn();
    $.ajax({
        headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},
        url:"billing",
        method:"POST",
        data : {page:1,month:month,year:year,etsy_id:etsy_id},
        success:function(e){
            console.log(e)
            $(".billing-grid").empty().append(e);
            $(".load_ctn").fadeOut();
        },
        error:function(e,t,a){
            console.log(e);
            $(".billing-grid").empty().append("Error")
        }
    });
}

billing();

$(document).on("click", ".add_sales_btn", function(e) {

    var a, s = $("#sheet_page_list").children("option:selected").attr("id"),
        n = [],
        i = [],
        r = $("#sheet_page_list").val();
    // sheet name
    r = r.substring(13, r.length),

        expenses = [],
        $('.fee-checkbox-billing').each(function(e) {
            if (_this = $(this), _this.is(":checked")) {
                var tempArray = {
                    sale_id: $.trim(_this.parent().parent().find("td").children().eq("1").html()),
                    date: $.trim(_this.parent().parent().find("td").children().eq("2").html()),
                    name: $.trim(_this.parent().parent().find("td").children().eq("3").html()),
                    currency: "$",
                    other_fees: $.trim(_this.parent().parent().find("td").children().eq("4").html()),
                    spreadsheet_id: $("#sheet_page_list").children("option:selected").attr("id"),
                    spreadsheet_name: r,
                    item_id: "-",
                    platform: 'etsy',
                    quantity: 1,
                    tax: 0,
                    profit: 0,
                    shipping_cost: 0,
                    shipping_charge: 0,
                    fees: 0,
                    sold_price: 0,
                    item_cost: 0,
                    processing_fees: 0,


                }
                expenses.push(tempArray)
            }

        }),

        (expenses.length === 0) ? popMessage("danger", "Wrong! Please  select checkbox!!") : n.length > 200 ? popMessage("danger", "Wrong! you can't select more than 200  at once ") : (console.log(n), $("#loader").fadeIn(),

        $.ajax({
            url: "add-billing-expense",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            type: "POST",
            data: {
                expense: expenses
            },
            success: function(e) {
                console.log(e);
                "valid" == e.status ? ($("#loader").fadeOut(), popMessage("success", "The selected sales has been added!")) : ($("#loader").fadeOut(), popMessage("danger", "Wrong! Please upgrade your account!"))
            },
            error: function(e, t, a) {
                console.log(e);
                popMessage("danger", "Wrong! Please upgrade your account!")
            }
        }))
    
});