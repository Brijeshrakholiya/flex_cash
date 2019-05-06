$(document).ready(function () {
    setTimeout(function(){
        $.ajax({
            type: 'POST',
            url: BASEURL +'index.php/home/update_notification',
            dataType: 'json',
            success: function (returnData) {
                if(returnData.status == 'ok'){
                    $('.viewed').css('background-color','#fff');
                }
                $('.notify-bubble').hide(500);
            }
        });   
    }, 5000);
});        
        