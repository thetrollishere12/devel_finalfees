$(document).ready(function(){calculations();$('#main-calculator').children().keyup(function(){calculations()});$('button[name=p-reset]').click(function(){$('input[name=sold_price],input[name=item_cost],input[name=name]').val(null);$('input[name=item_tax]').val($('input[name=item_tax]').attr('id'));calculations()})
$("select").change(function(){calculations()});function calculations(){var options={  
useEasing:!0,  useGrouping:!0,  separator:',',  decimal:'.',};var country_fee=0;var sold_price=parseFloat($('input[name=sold_price]').val()||0);var item_cost=parseFloat($('input[name=item_cost]').val()||0);var tax=parseFloat($('input[name=item_tax]').val()/100||0)
var goat_transaction_fee=0;var cash_out_fee=$("select[name=cash_out]").val();if(sold_price.toFixed(2)>0){var country_fee=parseFloat($("select[name=seller_location]").val());goat_transaction_fee=.095}
if(sold_price>25){$("#category-slide").slideDown()}else{$("#category-slide").slideUp()}
var combine_fees=(sold_price*goat_transaction_fee)+country_fee;var costfees=combine_fees+item_cost+(sold_price-combine_fees)*cash_out_fee;if(costfees<0){costfees=0}
var profit_number=(sold_price-costfees).toFixed(2);if(profit_number<0){var tax=0}
var profit_total=profit_number-(profit_number*tax);var return_total=(profit_total/costfees)*100||0;var margin_total=(profit_total/sold_price)*100||0;if(profit_total<0){margin_total=0;return_total=0}
if(margin_total===Infinity||margin_total===-Infinity){margin_total=0}
if(return_total===Infinity||return_total===-Infinity){return_total=0}
profit_c(profit_total,return_total,margin_total);var other_fees=new CountUp('other-fees',0,(sold_price-combine_fees)*cash_out_fee,2,.2,options);var main_tax=new CountUp('main-tax',0,profit_number*tax,2,.2,options);var main_fees=new CountUp('main-fees',0,combine_fees,2,.2,options);var main_return=new CountUp('main-return',0,return_total,2,.2,options);var main_margin=new CountUp('main-margin',0,margin_total,2,.2,options);var main_profit=new CountUp('main-profit',0,profit_total,2,.2,options);graph(sold_price,0,0,item_cost,main_tax.endVal,0,other_fees.endVal,main_fees.endVal,main_profit.endVal);if(!other_fees.error){other_fees.start();main_fees.start();main_margin.start();main_return.start();main_profit.start()
main_tax.start()}else{  
console.error(other_fees.error)}}})