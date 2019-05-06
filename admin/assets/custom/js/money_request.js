 $(document).ready(function () {
     
        if ($('#money').length > 0) {
               var $url = BASEURL + $('#money').attr('data-control') + '/' + $('#money').attr('data-method');
                   var oTable = $('#money').dataTable({
                   "bProcessing": true,
                   "bServerSide": true,
                   "sServerMethod": "POST",
                   "sAjaxSource": $url,
                   "bLengthChange": false,
                   "aaSorting": [[ 3, "desc" ]],
                   bFilter: false,
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
                       $("#flex_length select").select2();
                   },
                   "oLanguage": {"sLengthMenu": "_MENU_ ", "sInfo": "Showing <b>_START_ to _END_</b> of _TOTAL_ entries"},
               });

           }
     
     $(document).on("click", ".return_req", function (event) {
         var $id = $(this).attr('data-id');
         var $type = $(this).attr('data-type');
         var $amt = $(this).attr('data-amt');
            
            $(".bs-example-modal-md").modal('hide');
            if($type == 1){
                $.alert.open('confirm', 'Are you sure you want Transfer Payment?', function(button) {
                    if (button == 'yes') {
                        $.alert.open({
                        type: 'prompt',
                        title: 'Admin Password',
                        inputtype: 'password',
                        content: 'Please enter the password',
                        callback: function(pass_btn, value) {
                            if (pass_btn == 'ok'){
                                $.ajax({
                                    type: 'POST',
                                    url: BASEURL+'money_request/update_money_request',
                                    async: false,
                                    data: {id: $id,type: $type,amt:$amt,pass: value},
                                    dataType: 'json',
                                    success: function (returnData) {
                                        if (returnData.status == "ok") {
                                            if(returnData.type == 1){
                                                toster_message('Money is Sent to Flex Owner Successfully.', 'Success', 'success');
                                                oTable.fnDraw();
                                            }else{
                                                toster_message('Money Request Denied Successfully.', 'Success', 'success');
                                            }
                                            $(".bs-example-modal-md").modal('hide');
                                        }else if(returnData.status == "error"){
                                            toster_message(returnData.message, 'Error', 'error');
                                        }
                                    },
                                    error: function (xhr, textStatus, errorThrown) {
                                        toster_message('There was an unknown error that occurred. You will need to refresh the page to continue working.', 'Error', 'error');
                                    },
                                    complete: function () {

                                    }
                                });
                            }
                        }
                    });
                    }
                });
            }else if($type == 2){
                $.ajax({
                type: 'POST',
                url: BASEURL+'money_request/update_money_request',
                async: false,
                data: {id: $id,type: $type},
                dataType: 'json',
                success: function (returnData) {
                    if (returnData.status == "ok") {
                        if(returnData.type == 1){
                            toster_message('Money is Sent to Flex Owner Successfully.', 'Success', 'success');
                        }else{
                            toster_message('Money Request Denied Successfully.', 'Success', 'success');
                            oTable.fnDraw();
                        }
                        $(".bs-example-modal-md").modal('hide');
                    }else if(returnData.status == "error"){
                        toster_message(returnData.message, 'Error', 'error');
                    }
                },
                error: function (xhr, textStatus, errorThrown) {
                    toster_message('There was an unknown error that occurred. You will need to refresh the page to continue working.', 'Error', 'error');
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
                url: BASEURL+'money_request/requestdtl',
                async: false,
                data: {id: $id},
                dataType: 'json',
                beforeSend: function () {
                    $('#model_content_area').html('');
                },
                success: function (returnData) {
                    if (returnData.status == "ok") {
                        if (typeof returnData.req_info != "undefined") {
                            if(returnData.req_info == null){
                                toster_message('No Details Avilable !.', 'Error', 'error');
                            }else{
                            var html_data = '';
                            var btn_data = '';
                            
                            html_data += 
                                '<tr>'
                                    +'<td style="width:30% !important;"><b>Money Request For</b></td>'
                                    +'<td>'+returnData.req_info.FlexName+'</td>'    
                                +'</tr>'
                                +'<tr>'
                                    +'<td style="width:30% !important;"><b>Money Request By</b></td>'
                                    +'<td>'+returnData.req_info.username+'</td>'    
                                +'</tr>'
                                +'<tr>'
                                    +'<td style="width:30% !important;"><b>Transferable Amount</b></td>'
                                    +'<td>'+returnData.amt+'</td>'    
                                +'</tr>'
                                +'<tr>'
                                    +'<td style="width:30% !important;"><b>Account ID</b></td>'
                                    +'<td>'+returnData.req_info.AccountID+'</td>'    
                                +'</tr>'
                                +'<tr>'
                                    +'<td style="width:30% !important;"><b>Requested On</b></td>'
                                    +'<td>'+returnData.req_info.RequestDate+'</td>'    
                                +'</tr>';
                                
                                
                            $('#model_content_area').html(html_data);
                            if(returnData.req_info.Status == 1){
                                btn_data += 
                                     '<div class="alert alert-success pull-right"><b>Approved On '+returnData.req_info.ModifiedOn+'</b></div>';   
                            }else if(returnData.req_info.Status == 2){
                                btn_data += 
                                        '<div class="alert alert-danger pull-right"><b>Denied On '+returnData.req_info.ModifiedOn+'</b></div>'; 
                            }else{
                                if(returnData.amt > 0){
                                btn_data += 
                                    '<button type="button" class="btn btn-success return_req" data-id ='+returnData.req_info.MoneyReqID+' data-amt = '+returnData.amt+' data-type=1 >Approve</button>'
                                    +'<button type="button" class="btn btn-danger return_req" data-id ='+returnData.req_info.MoneyReqID+' data-type=2 >Denied</button>';
                                }else{
                                    btn_data += 
                                        '<div class="alert alert-danger pull-right"><b>No Amount For Transfer.</b></div>'; 
                                }    
                            }
                            $('#refund_btns').html(btn_data);
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
});