$(document).ready(function () {
        
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
            beforeSend: function () {
                $('.alert.alert-danger').slideUp(500).remove();
                $('input[type="submit"]').val('Please wait..!').attr('disabled', 'disabled');
            },
            success: function (returnData) {
		if (returnData.status == "ok") {
                        //toster_message(returnData.message, returnData.heading, 'success');
                        window.location.href = $('.cancel_button').attr('href');
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
                        toster_message(returnData.message, returnData.heading, 'error');
                    }
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
    
     if ($('#paymentdtl').length > 0) {
        var $url = BASEURL + $('#paymentdtl').attr('data-control') + '/' + $('#paymentdtl').attr('data-method');
            var oTable = $('#paymentdtl').dataTable({
            "bProcessing": true,
            "bServerSide": true,
            "sServerMethod": "POST",
            "sAjaxSource": $url,
            "fnServerParams": function (aoData, fnCallback) {
                
            },
            "fnInitComplete": function () {
                $('.tooltip-top a').tooltip();
                
                $('.search').on('change', function(){
                    oTable.fnDraw();
                });
            },
            "oLanguage": {"sLengthMenu": "_MENU_ ", "sInfo": "Showing <b>_START_ to _END_</b> of _TOTAL_ entries"},
        });

    }
    
    $(document).on("click", ".remove-partner", function (event) {

        var data_id = $(this).attr('data-id');
        
            if(confirm('Want to Delete This Data ?'))
            {
                $.ajax({
                        type: 'POST',
                        url: 'remove',
                        async: false,
                        data: 'id=' + data_id,
                        dataType: 'json',
                        beforeSend: function () {
                                //                $(this).text('Please wait..!').attr('disabled', 'disabled');
                        },
                        success: function (returnData) {
                                if (returnData.status == "ok") {
                                        //location.reload();
                                        toster_message(returnData.message, returnData.heading, 'success');
                                } else {
                                        toster_message(returnData.message, returnData.heading, 'error');
                                }
                                if ($(".dataTables_paginate li.active a").length > 0)
                                        $(".dataTables_paginate li.active a").trigger("click");
                                else
                                        $(".dataTable > th.sorting").trigger("click");
                        },
                        error: function (xhr, textStatus, errorThrown) {
                                toster_message("error", "Error", UNKNOWN_ERROR);
                                toster_message(UNKNOWN_ERROR, 'Error', 'error');
                        },
                        complete: function () {
                        }
                });
            }	
    });
});