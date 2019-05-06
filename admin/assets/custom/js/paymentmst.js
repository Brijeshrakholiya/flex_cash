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
    
     if ($('#paymentmst').length > 0) {
        var $url = BASEURL + $('#paymentmst').attr('data-control') + '/' + $('#paymentmst').attr('data-method');
            var oTable = $('#paymentmst').dataTable({
            "bProcessing": true,
            "bServerSide": true,
            "sServerMethod": "POST",
            "sAjaxSource": $url,
            "fnServerParams": function (aoData, fnCallback) {
                if ($('#pay_type').length > 0) {
        		aoData.push({"name": "pay_type", "value": $('#pay_type').val()});
                }
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
    
    $(document).on("click", ".view_details", function (event) {
        var $id = $(this).attr('data-id');
            
            $.ajax({
                type: 'POST',
                url: BASEURL+'flexquestion/view_question',
                async: false,
                data: {id: $id},
                dataType: 'json',
                beforeSend: function () {
                    $('#model_content_area').html('');
                },
                success: function (returnData) {
                    if (returnData.status == "ok") {
                        if (typeof returnData.que_info != "undefined") {
                            var html_data = '';
                            $.each(returnData.que_info, function (idx,que) {
                            html_data += 
                                '<tr>'
                                    +'<td style="width:25% !important;"><b>Question</b></td>'
                                    +'<td>'+que.QuestionText+'</td>'    
                                +'</tr>'
                                
                                +'<tr>'
                                    +'<td style="width:25% !important;"><b>Question Type</b></td>';
                                    if(que.Qtype == 1){
                                        html_data += '<td>Text</td>';    
                                    }else{
                                        html_data += '<td>Multiple</td>'; 
                                    }
                                    html_data += '</tr>';
                        
                                if(returnData.opt_info != null) {
                                    var $cnt = 1;
                                    $.each(returnData.opt_info, function (idx,opt) {
                                    html_data += 
                                        '<tr>'
                                            +'<td style="width:25% !important;"><b>Option '+$cnt+'</b></td>'
                                            +'<td>'+opt.FlexOption+'</td>'    
                                        +'</tr>';
                                        $cnt = $cnt + 1;
                                    });
                                }
                                
                                html_data += 
                                '<tr>'
                                    +'<td style="width:25% !important;"><b>Question Order</b></td>'
                                    +'<td>'+que.Qorder+'</td>'    
                                +'</tr>'
                                
                                +'<tr>'
                                    +'<td style="width:25% !important;"><b>Is Required</b></td>';
                                    if(que.isRequired == 1){
                                        html_data += '<td>YES</td>';    
                                    }else{
                                        html_data += '<td>NO</td>'; 
                                    }
                                    html_data += '</tr>';
                                +'</tr>';
                            });
                                
                            $('#model_content_area').html(html_data);
                            $(".bs-example-modal-md").modal('show');
                        }
                        
                    }
                },
                error: function (xhr, textStatus, errorThrown) {
                    toster_message('There was an unknown error that occurred. You will need to refresh the page to continue working.', 'Error', 'error');
                },
                complete: function () {

                }
            });
    });
});