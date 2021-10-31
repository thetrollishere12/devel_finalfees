function profit_update(num){
    
    var sum = 0;
    $(".item-cost-"+num+"").each(function(){
     
        sum += parseFloat(this.value);
    });
 
    sum += parseFloat($(".shipping_cost_blk_"+num+"").val());
    og_profit=$(".profit_blk_"+num+"").attr('data-profit');
   
    $(".profit_blk_"+num+"").html(parseFloat(og_profit)-sum);
}

$(".shipping-cost").keyup(function() {
    _this = $(this);
    var e = $.trim(_this.val()) / 1;
    _this.attr("old-val", e)
}),

$(".item-cost").keyup(function() {
    _this = $(this);
    var e = $.trim(_this.val()) / 1;
    _this.attr("old-val", e)
}),


$(".item-cost").keyup(function() {
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

$(".shipping-cost").keyup(function() {
    _this = $(this);
    var e = $.trim(_this.val()) / 1;
    var num = _this.closest("tr").attr("data-count");
    profit_update(num);
});
 