$(document).ready(function () {
    
    $("#fileUpload").change(function () {
        filePreview(this);
    });
    
    $("#maxqty").keypress(function (e) {
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
              return false;
            }
   });
   $("#amount").keypress(function (e) {
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
              return false;
            }
   });
   $("#goalqty").keypress(function (e) {
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
              return false;
            }
   });
    
    $('#published_date').datepicker({
        format: "dd M yyyy",
        startView: 1,
        autoclose: true,
        todayHighlight: true            
    });
    
    /*$('#end_on').datepicker({
        startDate: new Date(),
        format: 'yyyy-mm-dd hh:ii',
        autoclose: true,
    });*/
    
    $('#end_on').datetimepicker({
        startDate: new Date(),
        format: 'yyyy-mm-dd hh:ii',
        autoclose: true,
    });
    
    //$('#end_on').datepicker();
    
    $('#flex_cat').change(function(){    
        if($('#flex_cat').val() == 1){
            $('#sell_type').css('display','block');
        }else{
            $('#sell_type').css('display','none');
        }    
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
                    //window.location.reload();
                    toster_message(returnData.message, returnData.heading, 'success');
                    setTimeout(function() {
                        window.location.href = BASEURL +"flex/flex_details/"+returnData.id;
                        //window.location.reload();
                        //$(window).scrollTop(0);
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
    
    $(document).on("click", ".add_question", function (event) {
        $(".bs-example-modal-md").modal('show');
    });
    
        $('#qtype').change(function() {
            if($(this).is(":checked")) {
               $('.mult_opt').css('display','block'); 
            }else{
               $('.mult_opt').css('display','none'); 
            }
        });
        
   
        var maxField = 10; //Input fields increment limitation
        var addButton = $('.add_button'); //Add button selector
        var wrapper = $('.field_wrapper'); //Input field wrapper
        //var fieldHTML = "<tr ><td style='width:70% !important;'><input type='text' class='form-control' name='option[]' id='option[]' placeholder='Option'></td><td style='width:20% !important;'><input type='text' class='form-control' name='order[]' id='order[]' placeholder='Order'></td><td style='width:10% !important;'><a  href='javascript:;' class='btn btn-danger btn-xs btn-equal btn-mini remove_button'><i class='fa fa-minus'></i></a></td><tr>"; //New input field html 
        var fieldHTML = "<tr><td style='width:90% !important;'><input type='text' class='form-control' name='option[]' id='option[]' placeholder='Option'></td><td style='width:10% !important;'><a  href='javascript:;' class='btn btn-danger btn-xs btn-equal btn-mini remove_button'><i class='fa fa-minus'></i></a></td><tr>"; //New input field html 
        var x = 1; //Initial field counter is 1
        $(addButton).click(function(){ //Once add button is clicked
            if(x < maxField){ //Check maximum number of input fields
                x++; //Increment field counter
                $(wrapper).append(fieldHTML); // Add field html
            }
        });
        $(wrapper).on('click', '.remove_button', function(e){//Once remove button is clicked
           // e.preventDefault();
            $(this).closest('tr').remove(); //Remove field html
            x--; //Decrement field counter
        });
        
        $('.bs-example-modal-md').on('hidden.bs.modal', function (e) {
            $(this).find("input,textarea,select").val('').end().find("input[type=checkbox], input[type=radio]").prop("checked", "").end();
            $('.mult_opt').css('display','none');
            $('.field_wrapper tr').slice(1).remove();
            
        });
        
        
        
//     $(document).on("change", "#photoimg", function (event) {
//        var form = $('form')[0]; // You need to use standart javascript object here
//        var formData = new FormData(form);
//
//        $.ajax({
//            type: 'POST',
//            url: $(this).attr('action'),
//            data: formData,
//            dataType: 'json',
//            cache: false,
//            contentType: false,
//            processData: false,
//            
//            success: function (returnData) {
//		if (returnData.status == "ok") {
//                    //window.location.reload();
//                    toster_message(returnData.message, returnData.heading, 'success');
//                    setTimeout(function() {
//                        window.location.href = BASEURL +"flex/flex_details/"+returnData.id;
//                        //window.location.reload();
//                        //$(window).scrollTop(0);
//                    }, 5000);
//                } else {
//                    //window.location.reload();
//                    //toster_message('There was an unknown error that occurred. You will need to refresh the page to continue working.', 'Error', 'error');
//                    var error_html = '';
//                    if (typeof returnData.error != "undefined") {
//                        $.each(returnData.error, function (idx, topic) {
//                            error_html += '<li>' + topic + '</li>';
//                        });
//                    }
//                    if (error_html != '') {
//                        toster_message_error(error_html, 'Error', 'error');
//                    } else {
//                        toster_message(returnData.message, returnData.heading, 'error');
//                    }
//                    setTimeout(function() {
//                        //window.location.reload();
//                        $(window).scrollTop(0);
//                    },5000);
//                }
//                
//            },
//            error: function (xhr, textStatus, errorThrown) {
//                toster_message('There was an unknown error that occurred. You will need to refresh the page to continue working.', 'Error', 'error');
//            },
//            complete: function () {
//                $('input[type="submit"]').val('Submit').removeAttr('disabled');
//            }
//        });
//
//        return false;
//
//    });
        
        
});