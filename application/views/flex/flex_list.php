<?php $form_attr = array('class' => 'flex_frm', 'id' => 'add_payment_frm', 'name' => 'add_payment_frm');?>  
<section id="flex_section">
      <div class="content">
        <div class="flex_block">
          <div class="container">
            <div class="flex_box">
              <div class="row">
                <div class="col-md-8">
                  <div class="flex_text">
                    <p>Quickly  disintermediate empowered methodologies with ubiquitous best practices.
                      Distinctively fabricate exceptional niches with technically sound technologies.
                      professionally revolutionize seamless synergy with real-time imperatives. Interactively
                      pursue top-line bandwidth whereas visionary e-services.</p>
                  </div>
                </div>
                <div class="col-md-4">
                <?php if(isset($pay_dtl) && $pay_dtl == 'yes'){ ?>
                    <a href="<?php echo base_url(); ?>home/create_flex" ><button class="btn btn-custom orange">Create Your Flex</button></a>
                <?php }else{?>
                    <a href="#"><button class="btn btn-custom orange" id="add_merchant">Create Your Flex</button></a>
                <?php } ?>
                </div>
              </div>  
            </div>
          </div>
        </div>
      </div>      
    </section>

    <section id="event_section">
      <div class="content">
        <div class="event_block">
          <div class="container">
            <div class="event_box">
              <div class="section-title">
                <h3>All Flexes</h3>
              </div>
              <div class="event_inner">
               <div class="row">
               <?php foreach ($flex_info as $flex){?>
                <div class="col-md-4">
                  <div class="session_box">
                    <div class="session">
                        
                        <?php
                        $file = FLEX_IMG_VIEW_PATH.$flex->FlexImageURL ;
                        if(!empty($flex->FlexImageURL) && file_exists($file)) {
                            $user_thumb_img = IMG_URL.FLEX_IMG_VIEW_PATH.$flex->FlexImageURL; 
                        }else{
                            $user_thumb_img = base_url().'/assets/images/default.jpg';
                        }?>
                        
                        <a href="<?php echo base_url(); ?>flex/flex_details/<?php echo $flex->FlexID; ?>">
                            <img src="<?php echo $user_thumb_img ;?>" class="flex-img" width="363px" height="155px" />
                        </a>
                        <time><?php  echo get_remaing_days($flex->EndsOn)/*.date('M d',strtotime($flex->EndsOn))*/; ?></time>
                        <h3><span><?php echo ($flex->Joiner == '')?'0':$flex->Joiner;?></span><?php if($flex->FlexCat == 1){echo ' Sold ';}else{echo ' Collected ';}if($flex->FlexCat != 1){?><span>(<?php if($flex->Amount == NULL){echo '0';}else{ $Amt = $flex->Amount; $NAmt = ($Amt * 3)/100;$Total = $Amt - $NAmt; echo $Total;} ?>)</span><?php } ?></h3>
                        <h2><a href="<?php echo base_url(); ?>flex/flex_details/<?php echo $flex->FlexID; ?>"><?php echo $flex->FlexName;?></a></h2>
                       
                    </div>
                    <div class="session-next">
                      <h5 class="first">Created By</h5>
                      <h3><?php echo $flex->username;?></h3>
                      <h4><span><?php if($flex->Joiner == NULL){echo '0';}else{ echo $flex->Joiner;} ?> Joined</span><span class="pull-right"><?php if($flex->Comments == NULL){echo '0';}else{ echo $flex->Comments;} ?> Comments</span> </h4>
                    </div>  
                  </div>
                </div>    
               <?php }?>
               </div>
            </div>




            </div>
          </div>
        </div>
      </div>
    </section>


  
<input type="hidden" id="login_id" name="login_id" value="<?php echo $pay_dtl; ?>" >
<input type="hidden" id="skip" name="skip" value="<?php echo $skip; ?>" >

<div class="modal fade bs-example-modal-md" id="custom" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" >
        <div class="modal-content" id="timetable_model_main">

            <div class="modal-header">
                
                <?php /* <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button> */ ?>
                <h4><span class="semi-bold" id="myModalLabel2">Setup Payment </span></h4>
            </div>
            <div class="grid simple horizontal orenge" id="timetable-slot">
                <div class="grid-body" >
                
                    <table class="table table-responsive field_wrapper" id="model_content_area">
                        <?php echo form_open(base_url('home/add_paymentdtl'), $form_attr); ?>
                            <div class="row">
                    <div class="form-group">
                        <div class="col-md-4"><label class="">Payment Method</label></div>
                        <div class="col-md-1"><b>:</b></div>
                        <div class="col-md-7"><select class="form-control" id="amount_type" class="search" style="width:100%">
                        <option value="0">Select Payment Method</option>        
                        <?php /*<option value="1">Apple Pay</option>*/?>
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
                        <div class="col-md-7"><input type="text" class="form-control" name="card_no" id="card_no" placeholder="XXXX XXXX XXXX XXXX" ></div>
                    </div>
                </div><br>
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
                                <option value="0">YY</option> 
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
                                            <input id="isdefault" name="isdefault" value="1" type="checkbox">  
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                                </div>
                            </div>              
                        
                    </table>
                
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" id="skip_btn" data-dismiss="modal">Skip</button>
                <button type="reset" class="btn btn-warning submitBtn">Add</button>
            </div>
            <?php echo form_close(); ?> 
        </div>
    </div>
    </div>

<div class="modal fade bs-merchant-modal-md" id="custom" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" >
        <div class="modal-content" id="timetable_model_main">

            <div class="modal-header">
                
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4><span class="semi-bold" id="myModalLabel2">Account Details</span></h4>
            </div>
            
            <div class="grid simple horizontal orenge" id="timetable-slot">
                <div class="grid-body" >
                    <p style="text-align:center;"> Where Should We Send Your Payout ?</p>
                    <hr>
                    <table class="table table-responsive field_wrapper" id="model_content_area">
                        <form id="myform">
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-4"><label class="">Email </label></div>
                                    <div class="col-md-1"><b>:</b></div>
                                    <div class="col-md-7"><input type="email" class="form-control" name="ac_email" id="ac_email" value="<?php echo $user_info->email; ?>"></div>
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-4"><label class="">Account Holder Name </label></div>
                                    <div class="col-md-1"><b>:</b></div>
                                    <div class="col-md-7"><input type="text" class="form-control" name="account_holder_name" id="account_holder_name" placeholder=""></div>
                                </div>
                            </div><?php /*<br>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-4"><label class="">Account Holder Type </label></div>
                                    <div class="col-md-1"><b>:</b></div>
                                    <div class="col-md-7"><select class="form-control" id="account_holder_type" class="search" name="account_holder_type" style="width:100%">
                                    <option value="0">Select Account Holder type</option>        
                                    <option value="1">Individual</option>
                                    <option value="2">Business</option>
                                </select></div>
                                </div>
                            </div> */ ?><br>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-4"><label class="">Bank Name </label></div>
                                    <div class="col-md-1"><b>:</b></div>
                                    <div class="col-md-7"><input type="text" class="form-control" name="bank_name" id="bank_name" placeholder=""></div>
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-4"><label class="">Account No. </label></div>
                                    <div class="col-md-1"><b>:</b></div>
                                    <div class="col-md-7"><input type="text" class="form-control" name="account_number" id="account_number" maxlength="16" placeholder=""></div>
                                </div>
                            </div><br>
                        </form>
                    </table>
                
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" id="skip_btn" data-dismiss="modal">Skip</button>
                <button type="reset" class="btn btn-warning" onclick="submitACForm()">Add</button>
            </div>
        </div>
    </div>
    </div>



<script>
    function submitACForm(){
        var ac_email = $('#ac_email').val();
        var account_holder_name = $('#account_holder_name').val();
        var bank_name = $('#bank_name').val();
        var account_number = $('#account_number').val();
        
        var Error_msg = '';
            if(ac_email == ''){
                Error_msg += 'Place Enter Email !<br>';
            }
            if(account_holder_name == ''){
                Error_msg += 'Place Enter Account Holder Name !<br>';
            }
            if(bank_name == ''){
                Error_msg += 'Place Enter Bank Name !<br>';
            }
            if(account_number == ''){
                Error_msg += 'Place Account No. !<br>';
            }
            if(Error_msg != ''){
                toster_message_error(Error_msg, 'Error', 'error');
            }else{ 
                $.ajax({
                type: 'POST',
                url: BASEURL +'user/add_accountdtl',
                data : {ac_email : ac_email,account_holder_name : account_holder_name, bank_name : bank_name, account_number : account_number},
                dataType: 'json',
                success: function (returnData) {
                    if (returnData.status == "ok") {
                        toster_message('Account Detail Added Successfully.', 'Success', 'success');
                        setTimeout(function() {
                            window.location.href = BASEURL +'home/create_flex';
                        }, 3000);
                    }else{
                        toster_message_error(returnData.message, returnData.heading, 'error');
                    } 
                },
            });    
            $(".bs-merchant-modal-md").modal('hide');
            }
    }
</script>
