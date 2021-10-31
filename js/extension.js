$(document).on('click','input[type=checkbox]',function(){
    disabled_btn();
});

function disabled_btn(){
    if ($('.fee-checkbox').filter(':checked').length > 0) {
        $('.delete-selected-sales').removeClass('delete-selected-disabled').prop("disabled", false);
    }else{
        $('.delete-selected-sales').addClass('delete-selected-disabled').prop("disabled", true);
    }
}

$(document).on('change on input','.table-input',function(){
    var sold_price = $(this).parent().parent().find("th").children().eq("5").val();
    var item_cost = $(this).parent().parent().find("th").children().eq("6").val();
    var shipping_charge = $(this).parent().parent().find("th").children().eq("7").val();
    var shipping_cost = $(this).parent().parent().find("th").children().eq("8").val();
    var fees = $(this).parent().parent().find("th").children().eq("9").val();
    var other_fees = $(this).parent().parent().find("th").children().eq("10").val();
    var proc_fees = $(this).parent().parent().find("th").children().eq("11").val();
    var tax = $(this).parent().parent().find("th").children().eq("12").val();
    var after = (Number(sold_price)+Number(shipping_charge))-(Number(item_cost)+Number(shipping_cost)+Number(fees)+Number(other_fees)+Number(proc_fees)+Number(tax));
    $(this).parent().parent().find("th").children().eq("13").val(after.toFixed(2));
    // popMessage("success", "The profit has been updated to " + after.toFixed(2) + "!")
});

$(document).on('mousemove','th input',function(t){
    1 == t.buttons && $(this).prop("checked", !0);
    disabled_btn();
});

function extension_ajax(){

    $.ajax({
        url: "extension-ajax",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        method: "POST",
        data: {
            code:"12f32fsk04f9"
        },
        success: function(e) {
            $("#loader").fadeOut()
            $('.extension-container').empty().html(e);
        },
        error: function(e, t, a) {
            $("#loader").fadeOut()
            $('.extension-container').empty().html(e);
        }
    });

}

extension_ajax();

function allcheck(platform) {
    var e = $(".all-check[data-input="+platform+"]");
    if (e.is(":checked")) {
         $(".fee-checkbox[data-input="+platform+"]").prop("checked", !0);
    }else{
         e.is(":not(':checked')") && $(".fee-checkbox[data-input="+platform+"]").prop("checked", !1);
    }
   
}

function popMessage(e, t) {
    var a = $(".msg");
    switch ($(".btn-success"), $(".btn-danger"), $(".btn-warning"), $(".btn-info"), hide(), e) {
        case "success":
            a.addClass("msg-success active").text(t);
            break;
        case "danger":
            a.addClass("msg-danger active").text(t);
            break;
        case "warning":
            a.addClass("msg-warning active").text(t);
            break;
        case "info":
            a.addClass("msg-info active").text(t)
    }
    timer()
}

function timer() {
    var e;
    clearTimeout(e), e = setTimeout(function() {
        hide()
    }, 3000)
}

function hide() {
    $(".msg").removeClass("msg-success msg-danger msg-warning msg-info active")
}

function list() {
    $.ajax({
        url: "pg_sheet_list",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        method: "POST",
        success: function(e) {
            $("#list").empty().append(e)
        },
        error: function(e, t, a) {
            $("#list").empty().append("Error")
        }
    })
}

$("#new_sheet").click(function(e) {
    e.preventDefault();
    var t = $("input[name='spreadsheet_name']"),
        a = t.val(),
        s = $("#loader");
    s.fadeIn(), $.ajax({
        url: "autonewsheet",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        method: "POST",
        data: {
            action: "new_sheet",
            spreadsheet_name: a
        },
        success: function(a) {
            "valid" == a.status ? (e.preventDefault(), t.val(""), $("#add_page").modal("hide"), popMessage("success", "The new spreadsheet has been created!"), s.fadeOut()) : "error" == a.status && (e.preventDefault(), t.val(""), $("#add_page").modal("hide"), popMessage("danger", "Please upgrade your account!"), s.fadeOut()), list()
        },
        error: function(e, t, a) {
            popMessage("danger", "Network error!"), s.fadeOut()
        }
    })
});

list();
var click1;
$(document).on("click", ".add_sales_btn", function(e) {

        s = $("#sheet_page_list").children("option:selected").attr("id"),
        r = $("#sheet_page_list").val();
        r = r.substring(13, r.length);
    var extensesales = [];
    $(".fee-checkbox").each(function(e) {
        if (_this = $(this), _this.is(":checked")) {

            var tempArray = {
                spreadsheet_id:s,
                spreadsheet_name:r,
                date:$.trim(_this.parent().parent().find("th").children().eq("1").html()),
                img:$.trim(_this.parent().parent().find("th").children().eq("2").attr("src")),
                name:$.trim(_this.parent().parent().find("th").eq("3").children().html()),
                currency:$.trim(_this.parent().parent().find("th").eq("4").children().html()),
                sold_price:$.trim(_this.parent().parent().find("th").eq("5").children().val())||0,
                item_cost:$.trim(_this.parent().parent().find("th").children().eq("6").val())||0,
                shipping_charge:$.trim(_this.parent().parent().find("th").children().eq("7").val())||0,
                shipping_cost:$.trim(_this.parent().parent().find("th").children().eq("8").val())||0,
                fees:$.trim(_this.parent().parent().find("th").children().eq("9").val())||0,
                other_fees:$.trim(_this.parent().parent().find("th").children().eq("10").val())||0,
                processing_fees:$.trim(_this.parent().parent().find("th").children().eq("11").val())||0,
                tax:$.trim(_this.parent().parent().find("th").children().eq("12").val())||0,
                profit:$.trim(_this.parent().parent().find("th").children().eq("13").val())||0,
                item_id:$.trim(_this.parent().parent().find("th").children().eq("14").val())||0,
                platform:$.trim(_this.parent().parent().find("th").children().eq("15").val())||0,
                extension_id:$.trim(_this.parent().parent().find("th").children().eq("16").val()),
                quantity:$.trim(_this.parent().parent().find("th").children().eq("17").val())
            }
            extensesales.push(tempArray)
        }
        
       
    }),

    0 === extensesales.length ? popMessage("danger", "Please  select checkbox!") : extensesales.length > 200 ? popMessage("danger", "Error! you can't select more than 200  at once ") : (console.log(extensesales),$("#loader").fadeIn(),

    $.ajax({
        url: "extension-post",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        method: "POST",
        data: {
            fee_array: extensesales
        },
        success: function(e) {
            console.log(e);
            extension_ajax();
            "valid" == e.status ? ($("#loader").fadeOut(),
            popMessage("success", "The selected sales has been added!")) : ($("#loader").fadeOut(),
            popMessage("danger", "Error! Please upgrade your account!")),
            "upgrade" === e.status && $("#sub_status").modal("show");
        },
        error: function(e, t, a) {
            console.log(e);
            popMessage("danger", "There was an error. Please try again.")
        }
    }))



    function popMessage(e, t) {
        var a = $(".msg");
        switch ($(".btn-success"), $(".btn-danger"), $(".btn-warning"), $(".btn-info"), hide(), e) {
            case "success":
                a.addClass("msg-success active").text(t);
                break;
            case "danger":
                a.addClass("msg-danger active").text(t);
                break;
            case "warning":
                a.addClass("msg-warning active").text(t);
                break;
            case "info":
                a.addClass("msg-info active").text(t)
        }
        timer()
    }


});

$(".delete-selected-sales").click(function(){

    var extensesales = [];
    $(".fee-checkbox").each(function(e) {
        if (_this = $(this), _this.is(":checked")) {

            var tempArray = {
                id:$(this).attr('data-id')
            }
            extensesales.push(tempArray)
        }
        
       
    });

    if (extensesales.length > 0) {

        $.ajax({
            url: "extension-delete",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            method: "POST",
            data: {
                id: extensesales
            },
            success: function(e) {
                extension_ajax();
                "valid" == e.status ? ($("#loader").fadeOut(),
                $('.delete-selected-sales').addClass('delete-selected-disabled').prop("disabled", true),
                popMessage("danger", "The selected sales has been Deleted!")) : ($("#loader").fadeOut(),
                popMessage("danger", "Error! Please upgrade your account!"));
            },
            error: function(e, t, a) {
                popMessage("danger", "There was an error. Please try again.")
            }
        });

    }else{
        popMessage("danger", "Error! Please Select");
    }

    


    function popMessage(e, t) {
        var a = $(".msg");
        switch ($(".btn-success"), $(".btn-danger"), $(".btn-warning"), $(".btn-info"), hide(), e) {
            case "success":
                a.addClass("msg-success active").text(t);
                break;
            case "danger":
                a.addClass("msg-danger active").text(t);
                break;
            case "warning":
                a.addClass("msg-warning active").text(t);
                break;
            case "info":
                a.addClass("msg-info active").text(t)
        }
        timer()
    }


});