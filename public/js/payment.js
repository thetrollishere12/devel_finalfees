$(document).ready(function(){$(".stripe-button-el")[0].disabled=!0;$('input[type=checkbox]').click(function(){if($('input[name=terms]').is(':checked')&&$('input[name=data]').is(':checked')){ if($(".stripe-button-el.paypal_btn")[0].disabled=!1){ console.log('ff'); }else{ console.log('dd'); } $(".stripe-button-el")[0].disabled=!1}else{$(".stripe-button-el.paypal_btn")[0].disabled=!0; $(".stripe-button-el")[0].disabled=!0}})})
