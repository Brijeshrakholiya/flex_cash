$(document).ready(function () {
   $("#mcard_no").keypress(function (e) {
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
              return false;
            }
   });
   $("#mcard_no").keyup(function(){
            var $this = $(this);
            if ((($this.val().length+1) % 5)==0){
                $this.val($this.val() + " ");
            }
        }); 
   $("#cvv_no").keypress(function (e) {
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
              return false;
            }
   });
   $("#card_dtl").keypress(function (e) {
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
              return false;
            }
   });
   $("#new_amount").keypress(function (e) {
            if (e.which != 8 && (e.which != 46 || $('#new_amount').val().indexOf('.') != -1) && e.which != 0 && (e.which < 48 || e.which > 57)) {
              return false;
            }
   });
   
   
    
   $('.responsive-tabs').responsiveTabs({
        accordionOn: ['xs', 'sm'] // xs, sm, md, lg 
    });
    
    $(document).on("click", ".add_payment", function (event) {
        $(".bs-example-modal-md").modal('show');
    });
    $(document).on("click", ".invite_btn", function (event) {
        $(".bs-invite-modal-md").modal('show');
    });
    
    $('.full_flex').click(function(){
        toster_message_error('This Flex already full.', 'Warning', 'error');
    });
    
    $('#ex_date').datepicker({
            format: "M yyyy",
            viewMode: "months", 
            minViewMode: "months",
            autoclose: true,
        });
        
    $('#mex_date').datepicker({
            format: "M yyyy",
            viewMode: "months", 
            minViewMode: "months",
            autoclose: true,
        });  
        
    $('#new_amount').change(function(){
       var amount = $('#new_amount').val();
       if(amount == ''){
           amount = 0;
       }
       var amt=parseFloat(amount).toFixed(2);
       //var amt = parseInt(amount);
       var quantity = $('#quantity').val(); 
       var d_amount_type = $('#d_amount_type').val();
       var old_amount = $('#amount').val();
       if(d_amount_type == 3 && old_amount > amt){
           toster_message_error('You have to Pay Atlest $'+old_amount+' !', 'Error', 'error');
       }
       
       var pay_amt = quantity * amount;
       var pay = add_tex(pay_amt);
       $('.total_pay').html(pay);
       $('#payable_amount').val(pay);
       //alert(pay); 
    });   
    
    $('#quantity').change(function(){
        var quantity = $('#quantity').val();
        var amount = $('#new_amount').val(); 
        var joiner = $('#joiner').val();
        var maxqty = $('#maxqty').val();
        var left = maxqty - joiner;
        if(quantity > left){
            toster_message_error('Entered Quantity not avilable !', 'Error', 'error');
        }else if (quantity == 0){
            toster_message_error('Entered Quantity is not valid !', 'Error', 'error');
        }
        
        var pay_amt = quantity * amount;
        var pay = add_tex(pay_amt);
        $('.total_pay').html(pay);
         $('#payable_amount').val(pay);
    });
    
    
        
    
    
    jQuery('.responsive-tabs-container').addClass('panel with-nav-tabs panel-warning').removeClass('accordion-xs accordion-sm');
    
    $(".confirm_pay").click(function(){  
            var amount_type = $('#amount_type').val();
            var card_no = $('#card_dtl').val();
            var ex_date = $('#ex_date').val();
            var cvv_no = $('#cvv_no').val();
            var ex = $('#expiry').val();
            var dS = ex.split("/");
            var amount = $('#new_amount').val(); 
            if(amount == ''){
                amount = 0;
            }
            var amt=parseFloat(amount).toFixed(2);
            var d_amount_type = $('#d_amount_type').val();
            var old_amount = $('#amount').val();
            var quantity = $('#quantity').val();
            var maxqty = $('#maxqty').val();
            var joiner = $('#joiner').val();
            var left = maxqty - joiner;
            
            var d1 = new Date(dS[1], (+dS[0] - 1),31);
            var today = new Date();
            if (d1 >= today) {
                var err = '';
            } else {
                var err = 1;
            }
            //var isdefault = $('#isdefault').val();
            var Error_msg = '';
            if($("#isdefault").is(':checked')){
                var isdefault = '1';
            }else{
                var isdefault = '0';
            }
            
            if(amount_type == 0 || card_no == ''){
                toster_message_error('Please Add Payment Details.', 'Error', 'error');
                setTimeout(function() {
                    $('.add_payment').click();
                }, 2000);
            }else{
            
            if(quantity > left){
                Error_msg += 'Entered Quantity not avilable !<br>';
            }
            if (quantity == 0){
                Error_msg += 'Entered Quantity is not valid !<br>';
            }
            
            if(d_amount_type == 3 && old_amount > amt){
                Error_msg += 'You Have to Pay Atlest $'+old_amount+' !<br>';
            }
            if(amount_type == 0){
                Error_msg += 'Place Select Payment Method !<br>';
            }
            if(card_no == ''){
                Error_msg += 'Place Enter Card No. !<br>';
            }
            if(ex_date == ''){
                Error_msg += 'Place Select Expiration Date !<br>';
            }
            if(cvv_no == ''){
                Error_msg += 'Place Enter CVV No. !<br>';
            }
            if(err == 1 && ex_date != ''){
                Error_msg += 'Your Card is Expire. Place Try with another Card!';
            }
            if(Error_msg != ''){
                toster_message_error(Error_msg, 'Error', 'error');
            }else{
                $('.submit_btn').click();
                //$("form.join_flex_frm").submit();
            }
        }
    });
    
    $(document).on("submit", "form.comment_frm", function (event) {
        var form = $('form')[0]; // You need to use standart javascript object here
            var formData = new FormData(form);
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: formData,
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,

            success: function (returnData) {
                if (returnData.status == "ok") {
                    toster_message(returnData.message, returnData.heading, 'success');
                    setTimeout(function() {
                        window.location.reload();
                        $(window).scrollTop(0);
                       //window.location.href = BASEURL +"flex/success_page";
                    }, 5000);
                } else {
                    //window.location.reload();
                    //toster_message('There was an unknown error that occurred. You will need to refresh the page to continue working.', 'Error', 'error');
                    var error_html = '';
                    if (typeof returnData.error != "undefined") {
                        $.each(returnData.error, function (idx, topic) {
                            error_html += '<li>' + topic + '</li>';
                        });
                    }
                    if (error_html != '') {
                        toster_message_error(error_html, 'Error', 'error');
                    } else {
                        toster_message(returnData.message, returnData.heading, 'error');
                    }
                    setTimeout(function() {
                        //window.location.reload();
                        $(window).scrollTop(0);
                    },5000);
                }

            },
            error: function (xhr, textStatus, errorThrown) {
                toster_message('There was an unknown error that occurred. You will need to refresh the page to continue working.', 'Error', 'error');
            },
            complete: function () {
                $('input[type="submit"]').val('Submit').removeAttr('disabled');
            }
        });

        return false;
        
    });
    
    $(document).on("submit", "form.join_flex_frm", function (event) {
        //alert();    
           var form = $('form')[0]; // You need to use standart javascript object here
            var formData = new FormData(form);
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: formData,
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $('.confirm_pay').val('Please wait..!').attr('disabled', 'disabled');
                },
                success: function (returnData) {
                    if (returnData.status == "ok") {
                        toster_message(returnData.message, returnData.heading, 'success');
                        setTimeout(function() {
                            window.location.reload();
                           // $(window).scrollTop(0);
                           window.location.href = BASEURL +"flex/success_page/"+returnData.id;
                        }, 5000);
                    } else {
                        //window.location.reload();
                        //toster_message('There was an unknown error that occurred. You will need to refresh the page to continue working.', 'Error', 'error');
                        var error_html = '';
                        if (typeof returnData.error != "undefined") {
                            $.each(returnData.error, function (idx, topic) {
                                error_html += '<li>' + topic + '</li>';
                            });
                        }
                        if (error_html != '') {
                            toster_message_error(error_html, 'Error', 'error');
                        } else {
                            toster_message(returnData.message, returnData.heading, 'error');
                        }
                        setTimeout(function() {
                            //window.location.reload();
                            $(window).scrollTop(0);
                        },5000);
                    }

                },
                
                error: function (xhr, textStatus, errorThrown) {
                    toster_message('There was an unknown error that occurred. You will need to refresh the page to continue working.', 'Error', 'error');
                },
                complete: function () {
                    $('.confirm_pay').val('Confirm Payment').removeAttr('disabled');
                }
            });

            return false;
        
    });
    
    
});

