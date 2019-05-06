


function get_notification(){
    $.ajax({
        type: 'POST',
        url: BASEURL +'index.php/home/get_notification_cnt',
        dataType: 'json',
        success: function (returnData) {
            if(returnData.cnt != 0){
                $('.notify-bubble').text(returnData.cnt);
                $('.notify-bubble').show(400);
            }
            setTimeout(function(){get_notification();}, 10000);
        }
    });    
}

function toster_message_error(msg, title, behaviour) { //behaviour = success, warning, error
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "20000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    toastr[behaviour](msg, title)
}
function toster_message(msg, title, behaviour) { //behaviour = success, warning, error
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    toastr[behaviour](msg, title)
}

