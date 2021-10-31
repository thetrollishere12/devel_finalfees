$(document).ready(function(){calculations();$('#main-calculator').children().keyup(function(){calculations()});$('button[name=p-reset]').click(function(){$('input[name=sold_price],input[name=shipping_charge],input[name=shipping_cost],input[name=item_cost],input[name=name]').val(null);$('input[name=item_tax]').val($('input[name=item_tax]').attr('id'));$('input[name=percent]').val(2.9);$('input[name=standard]').val('.30');calculations()})
$('button[name=p-edit]').click(function(){if($(this).text()=="Edit Fees"){$('.standard input').each(function(){$(this).prop("disabled",!1)});$('.standard').slideDown();$(this).text('Done Edit')}else{$('.standard input').each(function(){$(this).prop("disabled",!0)});$(this).text('Edit Fees');calculations();$('.standard').slideUp()}});$("select").change(function(){$('input[name=percent]').val($("select[name=paypal_method]").find(":selected").val());$('input[name=standard]').val(.30);calculations()});function calculations(){var options={  
useEasing:!0,  useGrouping:!0,  separator:',',  decimal:'.',};var sold_price=parseFloat($('input[name=sold_price]').val()||0);var shipping_charge=parseFloat($('input[name=shipping_charge]').val()||0);var shipping_cost=parseFloat($('input[name=shipping_cost]').val()||0);var item_cost=parseFloat($('input[name=item_cost]').val()||0);var percent=parseFloat($("select[name=paypal_method]").val()/100);var tax=parseFloat($('input[name=item_tax]').val()/100||0);var flat_fee=0;var grailed_transaction_fee=0;var total=sold_price+shipping_charge;if(total.toFixed(2)>0){var flat_fee=parseFloat($('input[name=standard]').val()||0);var grailed_transaction_fee=.06}
var combine_fees=(total*percent+flat_fee)+(total*grailed_transaction_fee);var costfees=item_cost+shipping_cost+combine_fees;if(costfees<0){costfees=0}
var profit_number=(total-costfees).toFixed(2);if(profit_number<0){var tax=0}
var profit_total=profit_number-(profit_number*tax);var return_total=(profit_total/costfees)*100||0;var margin_total=(profit_total/total)*100||0;if(margin_total<0){margin_total=0}
profit_c(profit_total,return_total,margin_total);var p_fees=new CountUp('p-fees',0,(total)*percent+flat_fee,2,.2,options);var main_tax=new CountUp('main-tax',0,profit_number*tax,2,.2,options);var main_fees=new CountUp('main-fees',0,(total)*grailed_transaction_fee,2,.2,options);var main_return=new CountUp('main-return',0,return_total,2,.2,options);var main_margin=new CountUp('main-margin',0,margin_total,2,.2,options);var main_profit=new CountUp('main-profit',0,profit_total,2,.2,options);graph(sold_price,shipping_charge,shipping_cost,item_cost,main_tax.endVal,p_fees.endVal,0,main_fees.endVal,main_profit.endVal);if(!p_fees.error){p_fees.start();main_fees.start();main_margin.start();main_return.start();main_profit.start()
main_tax.start()}else{  
console.error(paypal_fees.error)}}})