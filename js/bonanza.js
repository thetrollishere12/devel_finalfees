$(document).ready(function(){function e(){var e={useEasing:!0,useGrouping:!0,separator:",",decimal:"."},a=$("select[name=seller_ad]").val(),t=parseFloat($("input[name=sold_price]").val()||0),n=parseFloat($("input[name=shipping_charge]").val()||0),i=parseFloat($("input[name=shipping_cost]").val()||0),p=parseFloat($("input[name=item_cost]").val()||0),r=parseFloat($("input[name=ad_cost]").val()||0),l=$("input[name=percent]").val()/100,s=parseFloat($("input[name=item_tax]").val()/100||0),o=0,m=t+n;shipping_charge_fov=n>10?n-10:0;var c=(t+shipping_charge_fov)*a;t.toFixed(2)>0&&(o=parseFloat($("input[name=standard]").val()||0),c=c<=.5?.5:c),m>500?(flat_extra_fee=.015*(t+shipping_charge_fov-500),c=500*a+flat_extra_fee):flat_extra_fee=0;var d,u=m*l+o,v=(m-(d=p+r+i+c+u)).toFixed(2);if(v<0)s=0;(d=d+m*s)<0&&(d=0);var h=v-m*s,f=h/d*100||0,_=h/m*100||0;h<0&&(_=0,f=0),_!==1/0&&_!==-1/0||(_=0),f!==1/0&&f!==-1/0||(f=0),profit_c(h,f,_);var g=new CountUp("p-fees",0,u,2,.2,e),F=new CountUp("main-tax",0,m*s,2,.2,e),x=new CountUp("main-fees",0,c,2,.2,e),w=new CountUp("main-return",0,f,2,.2,e),y=new CountUp("main-margin",0,_,2,.2,e),U=new CountUp("main-profit",0,h,2,.2,e);graph(t,n,i,p,F.endVal,0,g.endVal,x.endVal,U.endVal),x.error?console.error(x.error):(x.start(),g.start(),w.start(),y.start(),U.start(),F.start())}e(),$("#main-calculator").children().keyup(function(){e()}),$("button[name=p-reset]").click(function(){$("input[name=sold_price],input[name=shipping_charge],input[name=shipping_cost],input[name=item_cost],input[name=name]").val(null),$("input[name=item_tax]").val($("input[name=item_tax]").attr("id")),$("select[name=payment-method]").val(1);var a=$("select[name=payment-method]").find(":selected").text().split("+");$("input[name=percent]").val(parseFloat(a[0].replace("%",""))),$("input[name=standard]").val(parseFloat(a[1].replace("$",""))),e()}),$("button[name=p-edit]").click(function(){"Edit Fees"==$(this).text()?($(".standard input").each(function(){$(this).prop("disabled",!1)}),$(".standard").slideDown(),$(this).text("Done Edit")):($(".standard input").each(function(){$(this).prop("disabled",!0)}),$(this).text("Edit Fees"),e(),$(".standard").slideUp())}),$("select").change(function(){if("other"==$("select[name=payment-method]").val())$("input[name=percent]").val(0),$("input[name=standard]").val(0);else if("2.9"!=$("select[name=payment-method]").val()){var a=$("select[name=payment-method]").find(":selected").text().split("+");$("input[name=percent]").val(parseFloat(a[0].replace("%",""))),$("input[name=standard]").val(parseFloat(a[1].replace("$","")))}e()})});