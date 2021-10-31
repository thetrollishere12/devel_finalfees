$(document).ready(function(){calculations();$('#main-calculator').children().keyup(function(){calculations()});$('button[name=p-reset]').click(function(){$('input[name=sold_price],input[name=item_cost],input[name=shipping_cost],input[name=name]').val(null);$('input[name=item_tax]').val($('input[name=item_tax]').attr('id'));calculations()})
function calculations(){var options={  
useEasing:!0,  useGrouping:!0,  separator:',',  decimal:'.',};var sold_price=parseFloat($('input[name=sold_price]').val()||0);var item_cost=parseFloat($('input[name=item_cost]').val()||0);var shipping_cost=parseFloat($('input[name=shipping_cost]').val()||0);var tax=parseFloat($('input[name=item_tax]').val()/100||0)
var discount_amount=parseFloat($('input[name=discount_amount]').val()||0);var poshmark_fee=0;if(sold_price.toFixed(2)>0){if(sold_price<15){var poshmark_fee=2.95}else{var poshmark_fee=(sold_price-discount_amount)*.2}}
var costfees=item_cost+poshmark_fee+shipping_cost+discount_amount;var profit_number=(sold_price-costfees).toFixed(2);if(costfees<0){costfees=0}
if(profit_number<0){var tax=0}
var profit_total=profit_number-(profit_number*tax);var return_total=(profit_total/costfees)*100||0;var margin_total=(profit_total/sold_price)*100||0;if(profit_total<0){margin_total=0;return_total=0}
if(margin_total===Infinity||margin_total===-Infinity){margin_total=0}
if(return_total===Infinity||return_total===-Infinity){return_total=0}
profit_c(profit_total,return_total,margin_total);var main_tax=new CountUp('main-tax',0,profit_number*tax,2,.2,options);var main_fees=new CountUp('main-fees',0,poshmark_fee,2,.2,options);var main_return=new CountUp('main-return',0,return_total,2,.2,options);var main_margin=new CountUp('main-margin',0,margin_total,2,.2,options);var main_profit=new CountUp('main-profit',0,profit_total,2,.2,options);graph(sold_price,0,shipping_cost,item_cost,main_tax.endVal,0,0,main_fees.endVal,main_profit.endVal);if(!main_profit.error){main_margin.start();main_return.start();main_profit.start();main_fees.start()
main_tax.start()}else{  
console.error(main_profit.error)}}})