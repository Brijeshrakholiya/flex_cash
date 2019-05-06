$(document).ready(function () {
    
    if (($(".form-group p").length > 0)){
        //alert($(".form-group p").text());
        $(".form-group p").css('display','none');
        
        var error_text = '';
        $('.form-group p').each(function(i, obj) {
            error_text += $(this).text() + '<br/>';
        });
        toster_message_error(error_text, 'Error', 'error');
//        toster_message_error($(".form-group p").text(), 'Error', 'error');
    }
    
    $("#register").click(function(){
        if($("#term_condition").prop('checked') != true){
            toster_message_error('You must agree to the terms and conditions before register.', 'Error', 'error');
        }
    });
    
    $('.input-phone').intlInputPhone();
    
    $("#phoneNumber").keypress(function (e) {
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
              return false;
            }
    });
    	
   
});