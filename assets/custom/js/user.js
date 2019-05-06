$(document).ready(function () {
    
        $("#mcard_no").keypress(function (e) {
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            //$("#errmsg").html("Digits Only").show().fadeOut("slow");
              return false;
            }
        });
        
        $("#mcard_no").keyup(function(){
            var $this = $(this);
            if ((($this.val().length+1) % 5)==0){
                $this.val($this.val() + " ");
            }
        });  
        
        $("#account_number").keypress(function (e) {
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            //$("#errmsg").html("Digits Only").show().fadeOut("slow");
              return false;
            }
        });
    
        $('#myTab a').click(function(e) {
          e.preventDefault();
          $(this).tab('show');
          $(window).scrollTop(250);
        });
       
        // store the currently selected tab in the hash value
        $("ul.nav > li > a").on("shown.bs.tab", function(e) {
          var id = $(e.target).attr("href").substr(1);
          window.location.hash = id;
        });
        
        $(".uppercase > a").on("shown.bs.tab", function(e) {
          var id = $(e.target).attr("href").substr(1);
          window.location.hash = id;
          $(window).scrollTop(250);
        });
        
        // on load of the page: switch to the currently selected tab
        var hash = window.location.hash;
        $('#myTab a[href="' + hash + '"]').tab('show');
        $(window).scrollTop(0);
    
        $("#tab1").click(function(){
            $("#tab_hedding").text('Account Settings');
        });
        $("#tab2").click(function(){
            $("#tab_hedding").text('Change Password');
        });
        $("#tab3").click(function(){
            $("#tab_hedding").text('My Created');
        });
        $("#tab3a").click(function(){
            $("#tab_hedding").text('My Created');
        });
        $("#tab4").click(function(){
            $("#tab_hedding").text('My Joined');
        });
        $("#tab5").click(function(){
            $("#tab_hedding").text('Payment Information');
        });
        $("#tab6").click(function(){
            $("#tab_hedding").text('User Activity');
        });
        $("#tab7").click(function(){
            $("#tab_hedding").text('User Flexes');
        });
        $("#tab8").click(function(){
            $("#tab_hedding").text('Transaction Summary');
        });
        $("#tab9").click(function(){
            $("#tab_hedding").text('Followers');
        });
         $("#tab10").click(function(){
            $("#tab_hedding").text('Following');
        });
        
        $('.responsive-tabs').responsiveTabs({
        accordionOn: ['xs', 'sm'] // xs, sm, md, lg 
    });
        
         $('#ex_date').datepicker({
            format: "M yyyy",
            viewMode: "months", 
            minViewMode: "months",
            autoclose: true,
        });
        
        $('#mex_date').datepicker({
            format: "M",
            viewMode: "months", 
            minViewMode: "months",
            autoclose: true,
        });  
        
        $("#fileUpload").change(function () {
            filePreview(this);
        });
        
       
        
        
        $(document).on("submit", "form.user_frm", function (event) {
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
                        window.location.reload();
                        $(window).scrollTop(0);
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
                $('input[type="submit"]').val('Save Changes').removeAttr('disabled');
            }
        });

        return false;

    });
    
    $(document).on("click", ".add_question", function (event) {
        $(".bs-example-modal-md").modal('show');
    });
    $(document).on("click", ".add_merchant", function (event) {
        $(".bs-merchant-modal-md").modal('show');
    });
    
    
    $(document).on("submit", "form.pass_frm", function (event) {
        var form = $('form')[1]; // You need to use standart javascript object here
        var formData = new FormData(form);
        //alert(formData);
        //console.log(form);
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
                        window.location.reload();
                        //window.location.href = BASEURL +"auth/logout";
                    }, 3000);
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
                $('input[type="submit"]').val('Change Password').removeAttr('disabled');
            }
        });

        return false;

    });
        
});