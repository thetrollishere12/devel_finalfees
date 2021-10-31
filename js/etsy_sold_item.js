$("#auto_sold").addClass("select-blue");


function activeAccounts(){
    var etsy_id = $('#active_account').find(":selected").val();
    var month = $('#active_month').val();
    var year = $('#active_year').val();
    $(".load_ctn").fadeIn();
    $.ajax({
        headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},
        url:"sold",
        method:"POST",
        data : {etsy_id:etsy_id},
        success:function(e){
            console.log(e)
            $(".auto-grid").empty().append(e),$(".load_ctn").fadeOut()
        },
        error:function(e,t,a){
            console.log(e)
            $(".auto-grid").empty().append("Error")
        }
    });
}

function transaction(){

    var etsy_id = $('#active_account').find(":selected").val();
    var month = $('#active_month').val();
    var year = $('#active_year').val();
    $(".load_ctn").fadeIn();
    $.ajax({
        headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},
        url:"sold",
        method:"POST",
        data : {etsy_id:etsy_id},
        success:function(e){
            console.log(e)
            $(".auto-grid").empty().append(e),$(".load_ctn").fadeOut()
        },
        error:function(e,t,a){
            console.log(e)
            $(".auto-grid").empty().append("Error")
        }
    });
    
}

transaction();

function profit_update(num){
    
    var sum = 0;
    $(".item-cost-"+num+"").each(function(){
     
        sum += parseFloat(this.value);
    });
 
    sum += parseFloat($(".shipping_cost_blk_"+num+"").val());
    og_profit=$(".profit_blk_"+num+"").attr('data-profit');
   
    $(".profit_blk_"+num+"").html(parseFloat(og_profit)-sum);
}

$(".shipping-cost").focusin(function() {
    _this = $(this);
    var e = $.trim(_this.val()) / 1;
    _this.attr("old-val", e)
}),

$(".item-cost").focusin(function() {
    _this = $(this);
    var e = $.trim(_this.val()) / 1;
    _this.attr("old-val", e)
}),


$(".item-cost").focusout(function() {
    var _this = $(this);
    var sum = 0;
    var num = _this.closest("tr").attr("data-count");
    $(".item-cost-"+num+"").each(function(){
        sum += parseFloat(this.value);
    });
    var aa = $(".item_cost_"+num+"").html(sum);

        // a = $.trim(_this.closest("tr").find("td").eq("15").children().html()) / 1 - e + t / 1;
    // _this.closest("tr").find("td").eq("15").children().html(a.toFixed(2)), popMessage("success", "The profit has been updated to " + a.toFixed(2) + "!")
    profit_update(num);
});

$(".shipping-cost").focusout(function() {
    _this = $(this);
    var e = $.trim(_this.val()) / 1;
    var num = _this.closest("tr").attr("data-count");
    profit_update(num);
});


function selectPage(e) {
    var etsy_id = $('#active_account').find(":selected").val();
    var t = $.trim(e);
    s = $("#loader");
    s.fadeIn();
    
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        url: "sold",
        type: "POST",
        data:{etsy_id:etsy_id,current_page:t},
        success: function(e) {
            s.fadeOut();
            console.log(e);
            $(".auto-grid").empty().append(e);
        },
        error: function(e, t, a) {
            console.log(e);
            s.fadeOut();
            popMessage("danger", "Network error! ");
        }
    })
}


$(document).on("click", ".add_sales_btn", function(e) {
  
    var a, s = $("#sheet_page_list").children("option:selected").attr("id"),
        n = [],
        i = [],
        r = $("#sheet_page_list").val();
    // sheet name
    r = r.substring(13, r.length),
    
        sold_product = [],
        $('.fee-checkbox').each(function(e) {
            if (_this = $(this), _this.is(":checked")) {
                var tempArray = {
                    spreadsheet_id:$("#sheet_page_list").children("option:selected").attr("id"),
                    date:$.trim(_this.parent().parent().find("td").eq("2").children().html()),
                    spreadsheet_name:r,
                    platform:"Etsy",
                    currency:$.trim(_this.parent().parent().find("td").eq("6").children().html()),
                    name:$.trim(_this.parent().parent().find("td").eq("4").children().html()),
                    sold_price:$.trim(_this.parent().parent().find("td").eq("7").children().html()),
                    item_cost:$.trim(_this.parent().parent().find("td").eq("8").children().html()),
                    shipping_charge:$.trim(_this.parent().parent().find("td").eq("9").children().html()),
                    shipping_cost:$.trim(_this.parent().parent().find("td").eq("10").children().val()),
                    fees:123,
                    other_fees:123,
                    processing_fees:123,
                    tax:$.trim(_this.parent().parent().find("td").eq("12").children().html()),
                    profit:$.trim(_this.parent().parent().find("td").eq("14").children().html()),
                    sale_id:$.trim(_this.parent().parent().find("td").eq("1").children().html()),
                    item_id:$("#sheet_page_list").children("option:selected").attr("id"),
                    quantity:$.trim(_this.parent().parent().find("td").eq("5").children().html())
                }
                sold_product.push(tempArray)
            }

        }),
        

        (0 === sold_product.length) ? popMessage("danger", "Wrong! Please  select checkbox!!") : n.length > 200 ? popMessage("danger", "Wrong! you can't select more than 200  at once ") : (console.log(n), $("#loader").fadeIn(),

            $.ajax({
                url: "add-sold-listing",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                type: "POST",
                data: {
                    fee_array:sold_product
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