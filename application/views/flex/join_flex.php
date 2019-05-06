<?php $form_attr = array('class' => 'join_flex_frm', 'id' => 'join_flex_frm', 'name' => 'join_flex_frm','autocomplete'=>'off');?>
<section id="flexform_section">
      <div class="content">
          
        <div class="flexform_block">
          <div class="container">
            <div class="flexform_box payment_box">
                
                <h3>Confirm Your Payment information</h3>
              <?php echo form_open_multipart(base_url('index.php/flex/join_form'), $form_attr); ?>
                <input type="hidden" value="<?php echo $flex_info->FlexID;?>" name="flex_id">
                <input type="hidden" value="<?php echo $flex_info->FlexName;?>" name="flex_name">
                <input type="hidden" value="<?php echo $flex_info->Amount;?>" id="amount" name="amount">
                <input type="hidden" value="<?php echo $flex_info->MaxQty;?>" id="maxqty" name="maxqty">
                <input type="hidden" value="<?php echo $flex_info->Joiner;?>" id="joiner"  name="joiner">
                <input type="hidden" value="<?php echo $flex_info->AmountType;?>" id="d_amount_type" name="amount_type">
                
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-5"><label class="">Flex Name </label></div>
                        <div class="col-md-1"><b>:</b></div>
                        <div class="col-md-6"><p><?php echo $flex_info->FlexName ;?></p></div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-5"><label class="">Amount </label></div>
                        <div class="col-md-1"><b>:</b></div>
                        <div class="col-md-6">
                            <?php if($flex_info->AmountType == 2){?>
                            <p><input type="text" class="form-control" value="<?php echo $flex_info->Amount;?>" name="new_amount" id="new_amount" disabled></p>
                            <?php }else if($flex_info->AmountType == 3){?>
                            <p><input type="text" class="form-control" name="new_amount" value="<?php echo $flex_info->Amount;?>" id="new_amount" placeholder="Atleast $<?php echo $flex_info->Amount;?>"></p>
                            <?php }else{ ?>
                            <p><input type="text" class="form-control" name="new_amount" id="new_amount" placeholder="Any Amount..."></p>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php if($flex_info->FlexCat == 1){?>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-5"><label class="">Quantity </label></div>
                        <div class="col-md-1"><b>:</b></div>
                        <div class="col-md-3"><p><input type="number" class="form-control" name="quantity" id="quantity" value="1" placeholder=""  ></p></div>
                    </div>
                </div>
                <?php }else{?>
                <input type="hidden" class="form-control" name="quantity" id="quantity" value="1">
                <?php } ?>
                <?php if(isset($que_info)){?>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-5"><label class="">Request information</label></div>
                        <div class="col-md-1"><b>:</b></div>
                        
                    </div>
                </div> 
                
                <?php $cnt = 1; $cn=1; foreach($que_info as $que){?>
                <div class="row">
                    <div class="col-md-12"><p class="question"><?php echo '<b>Q.'.$cnt.'</b> '. $que->QuestionText;?><span><?php  if($que->isRequired == 1){echo ' *';} ?></span></p></div>
                </div>
                <div class="row">
                    <?php if($que->Qtype == 1){?>
                    <div class="form-group">
                  <textarea class="form-control" name="ans[<?php echo $que->FlexQID;?>]" placeholder="Contributors response" id="flex_desc" rows="5" <?php if($que->isRequired == 1){echo ' required';} ?>></textarea>
                    </div>
                    <?php }else{$c = 1;
                    foreach($que->sub as $opt){?>
                    <div class="col-md-1"></div><div class="col-md-11"><input type="radio" value="<?php echo $opt->FlexOptID; ?>" class="" name="opt_ans[<?php echo $que->FlexQID ?>]" <?php if($que->isRequired == 1){echo ' required';} ?>> <?php echo $opt->FlexOption;?></div>
                    <?php $c++;}$cn++;} ?>
                </div>
                <?php $cnt++; }} ?>
                <hr>
                <p>(2.9% + $0.30 fee for users that pay with a credit or Debit card)</p>
                <!--<p>(No fee for users that pay with a bank account)</p>-->
                <?php if(isset($payment_info)){ ?>
                    <input type="hidden" value="<?php echo $payment_info->UserpaymentDtlID;?>" name="pay_dtlid" id="pay_dtlid">
                <?php } ?>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-5"><label class="">Payment Method </label></div>
                        <div class="col-md-1"><b>:</b></div>
                        <div class="col-md-6"><select class="form-control" name="payment_method" id="amount_type" class="search" style="width:100%" onchange="newcard()" <?php  /*if(isset($payment_info)){echo 'disabled';}  */?>>
                                <option value="0"></option>        
                       <?php /* <option value="1" <?php if(isset($payment_info) && $payment_info->PayType == 1){ echo 'selected="selected"'; }?>>Apple Pay</option> */?>
                        <option value="2" <?php if(isset($payment_info) && $payment_info->PayType == 2){ echo 'selected="selected"'; }?>>Credit Card</option>
                        <option value="3" <?php if(isset($payment_info) && $payment_info->PayType == 3){ echo 'selected="selected"'; }?>>Debit Card</option>
                    </select></div>
                    </div>
                </div>
                 
                <?php if($payment_info){?>    
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-5"><label class="">Card Details </label></div>
                        <div class="col-md-1"><b>:</b></div>
                        <div class="col-md-6">            
                    <select class="form-control" id="card_dtl" class="search" style="width:100%" onchange="newno()">
                        <?php if(isset($payment_info) && $payment_info->CardNo != ""){ ?>
                            
                        <option value="<?php echo $payment_info->CardNo;?>"><?php echo $payment_info->CardNo; ?></option>
                        <?php }?>
                    </select>
                            </div>
                    </div>
                </div>
                <?php }else{ ?>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-5"><label class="">Card Details </label></div>
                        <div class="col-md-1"><b>:</b></div>
                        <div class="col-md-6"><input type="text" class="form-control" name="card_dtl" id="card_dtl" placeholder="" maxlength="16" value="<?php if(isset($payment_info) && $payment_info->CardNo != ""){ echo 'XXXX XXXX XXXX '.substr($payment_info->CardNo,-4);}?>" disabled ></div>
                    </div>
                </div>
                <?php } ?>    
                <input type="hidden" value="<?php echo $payment_info->CardNo;?>" name="card_no" id="card_no">
                <?php 
                if(isset($payment_info)){
                    $monthNum  = $payment_info->ExpiryMonth;
                    $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                    $monthName = $dateObj->format('M'); 
                }
                ?>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-5"><label class="">Expiration Date </label></div>
                        <div class="col-md-1"><b>:</b></div>
                        <div class="col-md-6"><input type="text" class="form-control" name="ex_date" id="ex_date" placeholder="MM / YYYY" value="<?php if(isset($payment_info)){ echo $monthName.' '. $payment_info->ExpiryYear; } ?>"disabled >
                        
                            <input type="hidden" name="expiry" id="expiry" value="<?php if(isset($payment_info)){ echo $payment_info->ExpiryMonth.'/'. $payment_info->ExpiryYear; } ?>">
                        </div>
                    </div>
                </div> 
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-5"><label class="">Enter CVV Code </label></div>
                        <div class="col-md-1"><b>:</b></div>
                        <div class="col-md-3"><input type="password" class="form-control" name="cvv_no" id="cvv_no" placeholder="***" maxlength="3"></div>
                    </div>
                </div>
                <?php /* if(!isset($payment_info)){ ?>
                <br>
                <div class="row">
                                <div class="form-group">
                                    <div class="col-md-5"><label class="">Save as Default Payment </label></div>
                                    <div class="col-md-1"><b>:</b></div>
                                    <div class="col-md-6">
                                    <div class="checkbox">
                                        <label class="switch">
                                            <input id="isdefault" name="isdefault" value="1" type="checkbox">  
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                                </div>
                            </div> 
                <?php } */ ?>
                <br>
                <?php 
                    if($flex_info->AmountType != 1){
                        $amount = $flex_info->Amount;
//                        
//                        var amt = (amount * 2.90)/100;
//        var new_amt = amount + amt + 0.30;
//        return new_amt.toFixed(2);
//                        $amt1 = ($amount * 2.90)/100;
//                        $new_amt = $amount + $amt1 + 0.30;
//                        $amt = number_format($new_amt, 2);
                    $amount += 0.30;
                    $new_amt = $amount / (1 - .029);
                    $amt = number_format($new_amt, 2);  
                    }else{
                        $amt = 0;
                    }
                ?>
                <input type="hidden" value="<?php echo $amt; ?>" id="payable_amount" name="payable_amount">    
            <div class="form-footer">
                <span>Amount to be paid $<span class="total_pay"><?php echo $amt;?></span></span>
                <p>Inclusive Processing fee</p>
            </div>
                <br>
                <div class="row">
                    <div class="col-md-6"><a href="javascript:;" class="btn btn-default btn-large add_payment">New Payment Method</a></div>
                    <div class="col-md-6"><button type="button" class="btn btn-warning pull-right confirm_pay" >Confirm Payment</button>
                        <button type="submit" class="btn btn-warning pull-right submit_btn hidden" >Confirm Payment</button></div>
                </div>
                    <?php echo form_close(); ?> 
                </div>
            </div>
          </div>
        </div>
    </section>


<div class="modal fade bs-example-modal-md" id="custom" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" >
        <div class="modal-content" id="timetable_model_main">

            <div class="modal-header">
                
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4><span class="semi-bold" id="myModalLabel2">Add Payment Details</span></h4>
            </div>
            <div class="grid simple horizontal orenge" id="timetable-slot">
                <div class="grid-body" >
                
                    <table class="table table-responsive field_wrapper" id="model_content_area">
                        <form id="myform">
                            <div class="row">
                    <div class="form-group">
                        <div class="col-md-4"><label class="">Payment Method </label></div>
                        <div class="col-md-1"><b>:</b></div>
                        <div class="col-md-7"><select class="form-control" id="mamount_type" class="search" style="width:100%">
                        <option value="0">Select Payment Method</option>        
                      <?php /*   <option value="1">Apple Pay</option> */ ?>
                        <option value="2">Credit Card</option>
                        <option value="3">Debit Card</option>
                    </select></div>
                    </div>
                </div>
                
                            <br>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-4"><label class="">Card Details </label></div>
                        <div class="col-md-1"><b>:</b></div>
                        <div class="col-md-7"><input type="text" class="form-control" name="mcard_no" id="mcard_no" placeholder="XXXX XXXX XXXX XXXX" maxlength="19" ></div>
                    </div>
                </div>
                            <br>        
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-4"><label class="">Expiration Date </label></div>
                        <div class="col-md-1"><b>:</b></div>
                        <div class="col-md-3">
                            <select class="form-control" id="mmonth" class="search" style="width:100%">
                                <option value="0">MM</option>        
                                <option value="01">01</option>
                                <option value="02">02</option>
                                <option value="03">03</option>
                                <option value="04">04</option>
                                <option value="05">05</option>
                                <option value="06">06</option>
                                <option value="07">07</option>
                                <option value="08">08</option>
                                <option value="09">09</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <?php $y = date('Y');
                                $ey = $y+35;?>
                            <select class="form-control" id="myear" class="search" style="width:100%">
                                <option value="0">YYYY</option> 
                                <?php
                                for($i=$y;$i<=$ey;$i++){
                                    echo '<option value="'.$i.'">'.$i.'</option>';
                                }
                                ?>
                            </select></div>
                    </div>
                </div>             
                            <br>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-4"><label class="">Save as Default Payment </label></div>
                                    <div class="col-md-1"><b>:</b></div>
                                    <div class="col-md-7">
                                    <div class="checkbox">
                                        <label class="switch">
                                            <input id="misdefault" name="misdefault" value="1" type="checkbox" checked="">  
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                                </div>
                            </div>              
                        </form>
                    </table>
                
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="reset" class="btn btn-warning submitBtn" onclick="submitPaymentForm()">Add</button>
            </div>
        </div>
    </div>
    </div>

<script>
    
    function submitPaymentForm(){
        var mamount_type = $('#mamount_type').val();
        var mcard_no = $('#mcard_no').val();
        //var mex_date = $('#mex_date').val();
        var mmonth = $('#mmonth').val();
        var myear = $('#myear').val();
        var misdefault = $('#misdefault').val();
        
        if($("#misdefault").is(':checked')){
            var isd = '1';
        }else{
            var isd = '0';
        }
        var Error_msg = '';
            if(mamount_type == 0){
                Error_msg += 'Place Select Payment Method !<br>';
            }
            if(mcard_no == ''){
                Error_msg += 'Place Enter Card No. !<br>';
            }
           if(mmonth == 0){
                Error_msg += 'Place Select Month !<br>';
            }
            if(myear == 0){
                Error_msg += 'Place Select Year !<br>';
            }
            if(Error_msg != ''){
                toster_message_error(Error_msg, 'Error', 'error');
            }else{ 
        
            $.ajax({
                type: 'POST',
                url: BASEURL +'index.php/flex/add_new_paymentdtl',
                data : {PayType : mamount_type,CardNo : mcard_no,  ExpiryMonth : mmonth, ExpiryYear:myear, isDefault : isd},
                dataType: 'json',
                success: function (returnData) {
                        if (returnData.status == "ok") {
                        window.location.reload();
                    } 
                },
                /*error: function (xhr, textStatus, errorThrown) {
                    toster_message('There was an unknown error that occurred. You will need to refresh the page to continue working.', 'Error', 'error');
                },*/
            });    
            $(".bs-example-modal-md").modal('hide');
        }
    }
    
    function newcard(){
        var type = $("#amount_type").val();
        var card_no = $('#card_dtl').val();
        if(card_no == ''){
            toster_message_error('Please Add Payment Details.', 'Error', 'error');
            setTimeout(function() {
                $('.add_payment').click();
            }, 2000);
        }
        
        var uid = USERID;
        $.ajax({
            type: 'POST',
            url: BASEURL +'index.php/flex/change_card',
            data : {type : type, uid : uid},
            dataType: 'json',
            success: function (returnData) {
                if (returnData.status == "ok") {
                    
                    if (typeof returnData.no_info != "undefined") {
                        var html_data = '';
                        //alert(typeof returnData.no_info);
                        $.each(returnData.no_info, function (idx,no) {
                            html_data += 
                                '<option value="'+no.CardNo+'">'+no.CardNo+'</option>';
                            });
                            
                        $('#card_dtl').html(html_data);  
                        newno();
                    }
                    
                }
            }
        }); 
    }
    
    function newno(){
        var no = $("#card_dtl").val();
        var uid = USERID;
        $('#card_no').val(no);
        $.ajax({
            type: 'POST',
            url: BASEURL +'index.php/flex/change_card_no',
            data : {no : no, uid : uid},
            dataType: 'json',
            success: function (returnData) {
                if (returnData.status == "ok") {
                    if (returnData.date != null) {
                        $("#ex_date").val(returnData.date);
                        $("#expiry").val(returnData.hi_date);
                        $("#pay_dtlid").val(returnData.pay_id);
                    }
                }
            }
        }); 
        }
        
   function add_tex(amount){
       amount += .30;
        number = amount / (1 - .029);
        return number.toFixed(2);
        
        //var amt = (amount * 2.90)/100;
        //var new_amt = amount + amt + 0.30;
        //return new_amt.toFixed(2);
        
    }
   
</script>