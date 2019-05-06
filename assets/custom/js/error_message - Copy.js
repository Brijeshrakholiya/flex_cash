$(document).ready(function () {
    if (($(".form-group p").length > 0)){
        //alert($(".form-group p").text());
        $(".form-group p").css('display','none');
        toster_message_error($(".form-group p").text(), 'Error', 'error');
    }
    
    $("#register").click(function(){
        if($("#term_condition").prop('checked') != true){
            toster_message_error('You must agree to the terms and conditions before register.', 'Error', 'error');
        }
    });
});