graph();function graph(sold,ship_charge,ship_cost,itm_cost,taxes,p_fees,o_fees,pg_fee,profits){if(window.myChart!=null){window.myChart.destroy()}
var pg_name=$('.pg-name').text().replace(':','');var total_sold=sold.toFixed(2);var ship_charge=ship_charge.toFixed(2);var ship_cost=ship_cost.toFixed(2);var itm_cost=itm_cost.toFixed(2);var pg_fee=(pg_fee+o_fees).toFixed(2);var fees=(p_fees).toFixed(2);var tax=(taxes).toFixed(2);var profit=(profits).toFixed(2);window.myChart=new Chart($('#barchart'),{type:'bar',data:{labels:['Sold','Cost','Profit'],datasets:[{label:'Sold',data:[total_sold],backgroundColor:'#007bff'},{label:'Shipping Charge',data:[ship_charge],backgroundColor:'#004fa5'},{label:'Shipping Cost',data:[0,ship_cost],backgroundColor:'#ffc107'},{label:'Item Cost',data:[0,itm_cost],backgroundColor:'#a50044'},{label:pg_name,data:[0,pg_fee],backgroundColor:'#f99a36'},{label:'Paypal/Proc Fees',data:[0,fees],backgroundColor:'#e83c4c'},{label:'Tax',data:[0,tax],backgroundColor:'#c82333'},{label:'Profit',data:[0,0,profit],backgroundColor:'#4caf50'}]},options:{response:!1,legend:{display:!1},scales:{xAxes:[{stacked:!0}],yAxes:[{stacked:!0}]}}})}