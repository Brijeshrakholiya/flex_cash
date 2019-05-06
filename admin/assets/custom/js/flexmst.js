$(document).ready(function () {
    
    $('#published_date').datepicker({
        format: "dd M yyyy",
        startView: 1,
        autoclose: true,
        todayHighlight: true            
    });
    
    $('#end_on').datepicker({
        format: "dd M yyyy",
        startView: 1,
        autoclose: true,
        todayHighlight: true            
    });
    
    $('.responsive-tabs').responsiveTabs({
        accordionOn: ['xs', 'sm'] // xs, sm, md, lg 
    });
    
    $('.is_testimonial').change(function(){
       
       var $this = $(this);
       alert($this);
    });
    
    $('.del_que').click(function(){
        
    });
    
    jQuery('.responsive-tabs-container').addClass('panel with-nav-tabs panel-warning').removeClass('accordion-xs accordion-sm');
    
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
    
     if ($('#flex').length > 0) {
        var $url = BASEURL + $('#flex').attr('data-control') + '/' + $('#flex').attr('data-method');
            var oTable = $('#flex').dataTable({
            "bProcessing": true,
            "bServerSide": true,
            "sServerMethod": "POST",
            "sAjaxSource": $url,
            "fnServerParams": function (aoData, fnCallback) {
                if ($('#flex_cat').length > 0) {
        		aoData.push({"name": "flex_cat", "value": $('#flex_cat').val()});
                }
                if ($('#amount_type').length > 0) {
        		aoData.push({"name": "amount_type", "value": $('#amount_type').val()});
                }
                if ($('#flex_type').length > 0) {
        		aoData.push({"name": "flex_type", "value": $('#flex_type').val()});
                }
                if ($('#status').length > 0) {
        		aoData.push({"name": "status", "value": $('#status').val()});
                }
            },
            "fnInitComplete": function () {
                $('.tooltip-top a').tooltip();
                
                $('.search').on('change', function(){
                    oTable.fnDraw();
                });
                $("#flex_length select").select2();
            },
            "oLanguage": {"sLengthMenu": "_MENU_ ", "sInfo": "Showing <b>_START_ to _END_</b> of _TOTAL_ entries"},
        });

    }
    
    $(document).on("click", ".remove-partner", function (event) {

        var data_id = $(this).attr('data-id');
        
            if(confirm('Want to Delete This Flex ?'))
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
                url: BASEURL+'flexmst/view_question',
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
                    //toster_message('There was an unknown error that occurred. You will need to refresh the page to continue working.', 'Error', 'error');
                },
                complete: function () {

                }
            });
    });
    
    $(document).on("click", ".view_user_details", function (event) {
        var $id = $(this).attr('data-id');
        var $uid = $(this).attr('data-userid');
            
            $.ajax({
                type: 'POST',
                url: BASEURL+'flexmst/flex_joiner_dtl',
                async: false,
                data: {id: $id,uid:$uid},
                dataType: 'json',
                beforeSend: function () {
                    $('#model_content_area').html('');
                },
                success: function (returnData) {
                    if (returnData.status == "ok") {
                        if (typeof returnData.join_info != "undefined") {
                            var html_data = '';
                            $.each(returnData.join_info, function (idx,join) {
                            html_data += 
                                '<tr>'
                                    +'<td style="width:25% !important;"><b>Name</b></td>'
                                    +'<td>'+join.username+'</td>'
                                    +'<td rowspan="3" style="width:25% !important;"><img src="'+returnData.path+join.image+'" class="img-thumbnail" /></td>'    
                                +'</tr>'
                        
                                +'<tr>'
                                    +'<td style="width:25% !important;"><b>Email</b></td>'
                                    +'<td>'+join.email+'</td>'
                                +'</tr>'

                                +'<tr>'
                                    +'<td style="width:25% !important;"><b>Phone No.</b></td>'
                                    +'<td>'+join.phone+'</td>'
                                +'</tr>'
                        
                                +'<tr>'
                                    +'<td style="width:25% !important;"><b>Join Date</b></td>'
                                    +'<td colspan="2">'+join.JoinDate+'</td>'
                                +'</tr>'
                        
                                +'<tr>'
                                    +'<td style="width:25% !important;"><b>Flex Amount</b></td>'
                                    +'<td colspan="2">'+join.FlexAmt+'</td>'
                                +'</tr>'
                        
                                +'<tr>'
                                    +'<td style="width:25% !important;"><b>Quantity</b></td>'
                                    +'<td colspan="2">'+join.Qty+'</td>'
                                +'</tr>'
                        
                                +'<tr>'
                                +'<td style="width:25% !important;"><b>Payment Type</b></td>';
                                if(join.PayType == 1){
                                    html_data += '<td colspan="2">Apple Pay</td>';    
                                }else if(join.PayType == 2) {
                                    html_data += '<td colspan="2">Credit Card</td>'; 
                                }else{
                                    html_data += '<td colspan="2">Dabit Card</td>'; 
                                }
                                html_data += '</tr>';
                                if(join.PayType != 1){    
                                html_data += 
                                +'<tr>'
                                    +'<td style="width:25% !important;"><b>Card Name</b></td>'
                                    +'<td colspan="2">'+join.CardName+'</td>'    
                                +'</tr>'
                                
                                +'<tr>'
                                    +'<td style="width:25% !important;"><b>Card No.</b></td>'
                                    +'<td colspan="2">'+join.CardNo+'</td>'    
                                +'</tr>'
                        
                                +'<tr>'
                                    +'<td style="width:25% !important;"><b>Expiry Month</b></td>'
                                    +'<td colspan="2">'+join.ExpiryMonth+'</td>'    
                                +'</tr>'
                        
                                +'<tr>'
                                    +'<td style="width:25% !important;"><b>Expiry Year</b></td>'
                                    +'<td colspan="2">'+join.ExpiryYear+'</td>'    
                                +'</tr>'
                                }
                                html_data +=
                                '<tr>'
                                    +'<td style="width:25% !important;"><b>Is Transaction Success ?</b></td>';
                                    if(join.isTransactionSuccess == 1){
                                        html_data += '<td colspan="2">YES</td>';    
                                    }else{
                                        html_data += '<td colspan="2">NO</td>'; 
                                    }
                                    html_data += '</tr>';
                                +'</tr>'
                                +'<tr>'
                                    +'<td style="width:25% !important;"><b>Transaction ID</b></td>'
                                    +'<td colspan="2">'+join.TransactionID+'</td>'
                                +'</tr>'
                            });
                                
                            $('#model_content_area').html(html_data);
                            $(".bs-example-modal-md").modal('show');
                        }
                        
                    }
                },
                error: function (xhr, textStatus, errorThrown) {
                    //toster_message('There was an unknown error that occurred. You will need to refresh the page to continue working.', 'Error', 'error');
                },
                complete: function () {

                }
            });
    });
});