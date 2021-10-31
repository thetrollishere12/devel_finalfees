$(document).ready(function() {

    $("td input").mousemove(function(t) {
        1 == t.buttons && $(this).prop("checked", !0)
    }),

    $.ajax({
        url: "/pg_sheet_list",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        method: "POST",
        success: function(t) {
            $("#list").empty().append(t)
        },
        error: function(t, s, e) {
            $("#list").empty().append("Error")
        }
    })
});

// $(document).ready(function(){function t(t,e){var i=$(".msg");switch($(".btn-success"),$(".btn-danger"),$(".btn-warning"),$(".btn-info"),s(),t){case"success":i.addClass("msg-success active").text(e);break;case"danger":i.addClass("msg-danger active").text(e);break;case"warning":i.addClass("msg-warning active").text(e);break;case"info":i.addClass("msg-info active").text(e)}!function(){var t;clearTimeout(t),t=setTimeout(function(){s()},3e3)}()}function s(){$(".msg").removeClass("msg-success msg-danger msg-warning msg-info active")}$("td input").mousemove(function(t){1==t.buttons&&$(this).prop("checked",!0)}),$("input.shipping-cost").bind("change keyup input",function(){var t=this.selectionStart-1,s=this.value.replace(/[^0-9\.]/g,"");"."===s.charAt(0)&&(s=s.slice(1));var e=s.indexOf(".")+1;e>=0&&(s=s.substr(0,e)+s.slice(e).replace(".","")),this.value!==s&&(this.value=s,this.selectionStart=t,this.selectionEnd=t)}),$("input.ad-fee").bind("change keyup input",function(){var t=this.selectionStart-1,s=this.value.replace(/[^0-9\.]/g,"");"."===s.charAt(0)&&(s=s.slice(1));var e=s.indexOf(".")+1;e>=0&&(s=s.substr(0,e)+s.slice(e).replace(".","")),this.value!==s&&(this.value=s,this.selectionStart=t,this.selectionEnd=t)}),$(".shipping-cost").focusin(function(){_this=$(this);var t=$.trim(_this.val())/1;_this.attr("old-val",t)}),$(".item-cost").focusin(function(){_this=$(this);var t=$.trim(_this.val())/1;_this.attr("old-val",t)}),$(".shipping-cost").focusout(function(){_this=$(this);var s=$.trim(_this.val())/1,e=$.trim(_this.closest("tr").find("td").eq("19").children().html())/1-s+_this.attr("old-val")/1;_this.closest("tr").find("td").eq("19").children().html(e.toFixed(2)),t("success","The profit has been updated to "+e.toFixed(2)+"!")}),$(".item-cost").focusout(function(){_this=$(this);var s=$.trim(_this.val())/1,e=_this.attr("old-val"),i=$.trim(_this.closest("tr").find("td").eq("19").children().html())/1-s+e/1;_this.closest("tr").find("td").eq("19").children().html(i.toFixed(2)),t("success","The profit has been updated to "+i.toFixed(2)+"!")}),$.ajax({url:"/pg_sheet_list",headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},method:"POST",success:function(t){$("#list").empty().append(t)},error:function(t,s,e){$("#list").empty().append("Error")}})});