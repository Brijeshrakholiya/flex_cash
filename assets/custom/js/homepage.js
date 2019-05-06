 $(document).ready(function () {
     
        
        $("#card_no").keypress(function (e) {
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            //$("#errmsg").html("Digits Only").show().fadeOut("slow");
              return false;
            }
        }); 
        
        
        
        $("#account_number").keypress(function (e) {
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            //$("#errmsg").html("Digits Only").show().fadeOut("slow");
              return false;
            }
        });
        
        
        $("input").attr("autocomplete", "off"); 
        $('#skip_btn').click(function(){
            $.ajax({
               type: "POST",
               url: "home/sessions"
            }).done(function() {
               
            });
        });
        
        if($('#login_id').val() === 'no' && $('#skip').val() === 'no'){
           $(".bs-merchant-modal-md").modal('show');
        }
        
        $("#add_merchant").click(function(){
           toster_message_error('You have to add Your Bank Details to Create Flex. !', 'Warning', 'error');
           setTimeout(function() {
              $(".bs-merchant-modal-md").modal('show');
           }, 3000);
           
        });
        
        
        $('#ex_date').datepicker({
            format: "M yyyy",
            viewMode: "months", 
            minViewMode: "months",
            autoclose: true,
        });  
        
        $(".submitBtn").click(function(){
            var amount_type = $('#amount_type').val();
            var card_no = $('#card_no').val();
            //var ex_date = $('#ex_date').val();
            var mmonth = $('#mmonth').val();
            var myear = $('#myear').val();
            //var isdefault = $('#isdefault').val();
            var Error_msg = '';
            if($("#isdefault").is(':checked')){
                var isdefault = '1';
            }else{
                var isdefault = '0';
            }
            
            if(amount_type == 0){
                Error_msg += 'Place Select Payment Method !<br>';
            }
            if(card_no == ''){
                Error_msg += 'Place Enter Card No. !<br>';
            }
            if(mmonth == 0){
                Error_msg += 'Place Select Month !<br>';
            }
            if(myear == 0){
                Error_msg += 'Place Select Year !<br>';
            }
            if(Error_msg != ''){
                toster_message_error(Error_msg, 'Error', 'error');
            }else{
                $.ajax({
                    type: 'POST',
                    url: BASEURL +'index.php/flex/add_new_paymentdtl',
                    data: {PayType : amount_type,CardNo : card_no, ExpiryMonth : mmonth, ExpiryYear:myear, isDefault : isdefault},
                    dataType: 'json',
                    cache: false,
                    success: function (returnData) {
                        if (returnData.status == "ok") {
                            $.ajax({
                                type: "POST",
                                url: "home/sessions"
                             }).done(function() {
                                $(".bs-example-modal-md").modal('hide');  
                                toster_message('Your details Saved Succesfully.', Success, 'success');
                             });
                            //toster_message('Your details Saved Succesfully.', Success, 'success');
                        }
                    }
                });
            }
        });
        
        $('.full_flex').click(function(){
            toster_message_error('This Flex already full.!', 'Warning', 'error');
        });
        
        
        $(document).on("submit", "form.flex_frm", function (event) {
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
                    toster_message(returnData.message, 'Success', 'success');
                    setTimeout(function() {
                        window.location.href = BASEURL +"user";
                    }, 5000);
                } else {
                    var error_html = '';
                    if (typeof returnData.error != "undefined") {
                        $.each(returnData.error, function (idx, topic) {
                            error_html += '<li>' + topic + '</li>';
                        });
                    }
                    if (error_html != '') {
                        toster_message_error(error_html, 'Error', 'error');
                    } else {
                        toster_message(returnData.message, 'Error', 'error');
                    }
                    setTimeout(function() {
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
        
    });
    
    
    