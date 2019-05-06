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
    
     if ($('#appuser').length > 0) {
        var $url = BASEURL + $('#appuser').attr('data-control') + '/' + $('#appuser').attr('data-method');
            var oTable = $('#appuser').dataTable({
            "bProcessing": true,
            "bServerSide": true,
            "sServerMethod": "POST",
            "sAjaxSource": $url,
            "fnServerParams": function (aoData, fnCallback) {
                if ($('#status').length > 0) {
        		aoData.push({"name": "status", "value": $('#status').val()});
                }
                
            },
            "fnInitComplete": function () {
                $('.tooltip-top a').tooltip();
                
                $('.search').on('change', function(){
                    oTable.fnDraw();
                });
                $("#appuser_length select").select2();
            },
            "oLanguage": {"sLengthMenu": "_MENU_ ", "sInfo": "Showing <b>_START_ to _END_</b> of _TOTAL_ entries"},
        });

    }
    
    $(document).on("click", ".remove-partner", function (event) {

        var data_id = $(this).attr('data-id');
        
            if(confirm('Want to Delete This User?'))
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
                url: BASEURL+'appuser/paymentdtl',
                async: false,
                data: {id: $id},
                dataType: 'json',
                beforeSend: function () {
                    $('#model_content_area').html('');
                },
                success: function (returnData) {
                    if (returnData.status == "ok") {
                        if (typeof returnData.pay_info != "undefined") {
                            if(returnData.pay_info == null){
                                toster_message('No Payment Details Avilable !.', 'Error', 'error');
                            }else{
                            var html_data = '';
                            $.each(returnData.pay_info, function (idx,pay) {
                            html_data += 
                                '<tr>'
                                +'<td style="width:25% !important;"><b>Payment Type</b></td>';
                                if(pay.PayType == 1){
                                    html_data += '<td>Apple Pay</td>';    
                                }else if(pay.PayType == 2) {
                                    html_data += '<td>Credit Card</td>'; 
                                }else{
                                    html_data += '<td>Dabit Card</td>'; 
                                }
                                html_data += '</tr>';
                                if(pay.PayType != 1){    
                                html_data += 
                                '<tr>'
                                    +'<td style="width:25% !important;"><b>Card Name</b></td>'
                                    +'<td>'+pay.CardName+'</td>'    
                                +'</tr>'
                                
                                +'<tr>'
                                    +'<td style="width:25% !important;"><b>Card No.</b></td>'
                                    +'<td>'+pay.CardNo+'</td>'    
                                +'</tr>'
                        
                                +'<tr>'
                                    +'<td style="width:25% !important;"><b>Expiry Month</b></td>'
                                    +'<td>'+pay.ExpiryMonth+'</td>'    
                                +'</tr>'
                        
                                +'<tr>'
                                    +'<td style="width:25% !important;"><b>Expiry Year</b></td>'
                                    +'<td>'+pay.ExpiryYear+'</td>'    
                                +'</tr>';
                                }
                                html_data +=
                                '<tr>'
                                    +'<td style="width:25% !important;"><b>Is Default</b></td>';
                                    if(pay.isDefault == 1){
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
                        
                    }
                },
                error: function (xhr, textStatus, errorThrown) {
                    toster_message('There was an unknown error that occurred. You will need to refresh the page to continue working.', 'Error', 'error');
                },
                complete: function () {

                }
            });
    });
    
    $(document).on("click", ".activation", function (event) {
        var $uid = $(this).attr('data-userid');
        var $val = $(this).attr('data-val');
        
        $.ajax({
                type: 'POST',
                url: BASEURL+'appuser/activation',
                async: false,
                data: {uid: $uid,val: $val},
                dataType: 'json',
                success: function (returnData) {
                    if (returnData.status == "ok") {
                        toster_message('User Details Updated Successfully.', 'Success', 'success');
                        setTimeout(function() {
                            window.location.href = $('#back-btn').attr('href');
                          }, 5000);
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