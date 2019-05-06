<?php
$old_password = array(
	'name'	=> 'old_password',
	'id'	=> 'old_password',
        'class' => 'form-control', 
	'value' => set_value('old_password'),
);
$new_password = array(
	'name'	=> 'new_password',
	'id'	=> 'new_password',
        'class' => 'form-control',
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
);
$confirm_new_password = array(
	'name'	=> 'confirm_new_password',
	'id'	=> 'confirm_new_password',
        'class' => 'form-control',
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
);
$submit_btn = array(
    'name' => 'change',
    'id' => 'change',
    'value' => 'Change Password',
    'class' => 'btn btn-warning',
);
?>

<?php 
$pass_form_attr = array('class' => 'pass_frm', 'id' => 'pass_frm', 'name' => 'pass_frm');
$payment_form_attr = array('class' => 'pay_flex_frm', 'id' => 'pay_flex_frm', 'name' => 'pay_flex_frm');
$user_form_attr = array('class' => 'user_frm', 'id' => 'update_user_frm', 'name' => 'update_user_frm');
$user_submit_btn = array(
    'name' => 'update',
    'id' => 'update',
    'value' => 'Save Changes',
    'class' => 'btn btn-warning',
);
?>

<section id="flex_section">
  <div class="content">
    <div class="flex_block">
      <div class="container">    
     
        <!-- BEGIN PAGE CONTENT-->
      <div class="row margin-top-20">
        <div class="col-md-12">
          <!-- BEGIN PROFILE SIDEBAR -->
          <div class="profile-sidebar">
            <!-- PORTLET MAIN -->
            <div class="portlet light profile-sidebar-portlet">
              <!-- SIDEBAR USERPIC -->
              <?php
                $file = USER_IMG_VIEW_PATH.$user_info->image;
                    if(!empty($user_info->image) && file_exists($file)) {
                        $user_img = IMG_URL.USER_IMG_VIEW_PATH.$user_info->image;
                    }else{
                        $user_img = base_url().'/assets/images/default_user.jpg';
                    }
              ?>
              <div class="profile-userpic">
                  <img src="<?php  echo $user_img; ?>" height="150px" width="150px" class="img-responsive" alt="">
              </div>
              <!-- END SIDEBAR USERPIC -->
              <!-- SIDEBAR USER TITLE -->
              <div class="profile-usertitle">
                <div class="profile-usertitle-name uppercase">
                   <?php echo $user_info->username; ?>
                </div>
              </div>
              <div class="profile-usertitle-job">
                  <?php $Amt = $user_info->TotalEarning;
                        $NAmt = ($Amt * 3)/100;
                        $Total = $Amt - $NAmt;
                  ?>
                  Total Collected : <span> <?php echo ' $'.$Total;?></span>
              </div>
              <!-- END SIDEBAR USER TITLE -->
              <!-- SIDEBAR BUTTONS -->
              <?php 
              if($user_info->IsFollow == 1){
                  $str = 'Unfollow';
              }else{
                  $str = 'Follow';
              }
              
              if($user_info->id != $uid){
                ?>
               <div class="profile-userbuttons">
                   <button type="button" class="btn btn-circle btn-warning btn-sm" id="follow_btn" onclick="follow(<?php echo $user_info->id; ?>)"><?php echo $str; ?></button>
              </div>
              <?php } ?>
              <!-- END SIDEBAR BUTTONS -->
              <!-- SIDEBAR MENU -->
              <!-- PORTLET MAIN -->
            <div class="portlet light">
              <!-- STAT -->
              <div class="row list-separated profile-stat">
                <div class="col-md-4 col-sm-4 col-xs-6">
                    <div class="uppercase profile-stat-title" id="followers">
                     <?php echo $user_info->Followers; ?>
                  </div>
                  <div class="uppercase profile-stat-text">
                      Followers
                  </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-6">
                  <div class="uppercase profile-stat-title">
                     <?php echo $user_info->Following; ?>
                  </div>
                  <div class="uppercase profile-stat-text">
                      Following
                  </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-6">
                  <div class="uppercase profile-stat-title">
                     <?php echo $user_info->CreatFlex; ?>
                  </div>
                  <div class="uppercase profile-stat-text">
                     Create Flexes
                  </div>
                </div>
              </div>
              <div class="profile-usermenu">
                <ul class="nav" id="myTab">
                  <li class="active">
                      <a href="#tab_1_6" id="tab6" data-toggle="tab"><i class="fa fa-history"></i> User Activity</a>
                      </li>
                      <li>
                          <a href="#tab_1_7" id="tab7" data-toggle="tab"><i class="fa fa-th-large"></i>User Flexes</a>
                      </li>
                </ul>
              </div>
              <!-- END STAT -->
            </div>
             
            <!-- END PORTLET MAIN -->
             
              <!-- END MENU -->
            </div>
            <!-- END PORTLET MAIN -->
            
          </div>
          <!-- END BEGIN PROFILE SIDEBAR -->
          <!-- BEGIN PROFILE CONTENT -->
          <div class="profile-content">
            <div class="row">
              <div class="col-md-12">
                <div class="portlet light">
                  <div class="portlet-title tabbable-line">
                   <div class="caption caption-md">
                      <i class="icon-globe theme-font hide"></i>
                      <span class="caption-subject font-blue-madison bold uppercase" id="tab_hedding">User Activity</span>
                    </div> 
                  </div>
                  <div class="portlet-body">
                    <div class="tab-content">
                      <!-- PERSONAL INFO TAB -->
                      <div class="tab-pane active" id="tab_1_6">
                          <div class="join_box">  
                            <?php foreach($act_info as $join){?> 
                             <?php
                                if($join->act_type == 'Comment'){
                                    $txt = ' on';
                                }else{
                                    $txt = '';
                                }
                             ?> 
                            <div class="row">
                                    <div class="col-md-3">
                                        <?php
                                            $file = FLEX_IMG_VIEW_PATH.$join->FlexImageURL ;
                                            if(!empty($join->FlexImageURL) && file_exists($file)) {
                                                $img = IMG_URL.FLEX_IMG_VIEW_PATH.$join->FlexImageURL; 
                                            }else{
                                                $img = base_url().'/assets/images/default.jpg';
                                            }?>
                                        <img class="img-circle nav-user-photo" src="<?php echo $img;?>" height="65px" max-width="65px" alt="">
                                    </div>
                                <div class="col-md-6">
                                    <p><?php echo $join->username.' '.$join->act_type.$txt.' '. $join->FlexName;?></p>
                                    
                                </div>
                                <div class="col-md-3">
                                    <p><span><?php echo $join->act_type;?> On</span> <?php echo date('M d',strtotime($join->CreatedOn)); ?></p>
                                </div>

                                </div>

                                <?php }?>
                                <?php if(!isset($act_info)){?>
                            <p class="text-danger">No User Joined Yet.</p>
                                <?php } ?>
                            </div>  
                      </div>
                      
                      <div class="tab-pane" id="tab_1_7">
                           <section id="event_section">
                        <div class="content">
                          <div class="event_block">
                              <div class="event_box">
                          <div class="event_inner">
                           <div class="row">
                           <?php 
                           if($flex_info){
                           foreach ($flex_info as $flex){?>
                               <?php
                                $file = FLEX_IMG_VIEW_PATH.$flex->FlexImageURL ;
                                if(!empty($flex->FlexImageURL) && file_exists($file)) {
                                    $img = IMG_URL.FLEX_IMG_VIEW_PATH.$flex->FlexImageURL; 
                                }else{
                                    $img = base_url().'/assets/images/default.jpg';
                                }?>
                            <div class="col-md-4">
                              <div class="session_box">
                                <div class="session my_flex">
                                    <a href="<?php echo base_url(); ?>index.php/flex/flex_details/<?php echo $flex->FlexID; ?>"><img src="<?php echo $img ;?>" class="flex-img" width="363px" height="155px" /></a>
                                    <time><?php  echo get_remaing_days($flex->EndsOn); ?></time>
                                    <h5><span><?php echo $flex->Joiner;?></span><?php if($flex->FlexCat == 1){echo ' Sold ';}else{echo ' Collected ';}?><span>(<?php if($flex->Amount == NULL){echo '0';}else{$Amt = $flex->Amount; $NAmt = ($Amt * 3)/100;$Total = $Amt - $NAmt; echo $Total;} ?>)</span></h5>
                                    <h3 class="my_flex_name"><a href="<?php echo base_url(); ?>index.php/flex/flex_details/<?php echo $flex->FlexID; ?>"><?php echo $flex->FlexName;?></a></h3>

                                </div>
                                <div class="session-next">
                                <h4><span><?php if($flex->Joiner == NULL){echo '0';}else{ echo $flex->Joiner;} ?> Joined</span><span class="pull-right"><?php if($flex->Comments == NULL){echo '0';}else{ echo $flex->Comments;} ?> Comments</span> </h4>
                                </div>  
                              </div>
                            </div>    
                           <?php }}else{?>
                               <p>No Flexes Yet.</p>
                           <?php }?>
                           </div>
                        </div>
               
                      </div>                 </div>
                        </div>
                    </section>
                      </div>
                      
                      
                      
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- END PROFILE CONTENT -->
        </div>
      </div>
      <!-- END PAGE CONTENT-->

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
                        <div class="col-md-7"><input type="text" class="form-control" name="mcard_no" id="mcard_no" placeholder="XXXX XXXX XXXX XXXX" maxlength="16"></div>
                    </div>
                </div>
                            <br>        
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-4"><label class="">Expiration Date </label></div>
                        <div class="col-md-1"><b>:</b></div>
                        <div class="col-md-7"><input type="text" class="form-control" name="mex_date" id="mex_date" placeholder="MM / YY" ></div>
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
                                            <input id="misdefault" name="misdefault" value="1" type="checkbox">  
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
    function filePreview(input) {
       if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#img_back').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
        }
    }
    
    function del_paydtl(id){
        var result = confirm("Want to delete this Payment Detail ?");
        if (result) {
            $.ajax({
                type: 'POST',
                url: BASEURL +'index.php/user/del_user_paydtl',
                data : {id : id},
                dataType: 'json',
                success: function (returnData) {
                    if (returnData.status == "ok") {
                        toster_message('Payment Detail Deleted Successfully.', 'Success', 'success');
                        setTimeout(function() {
                            window.location.reload();
                        }, 3000);
                    }
                //consol.log('ok');
                },
            });
        }
    }
    
    function submitPaymentForm(){
        var mamount_type = $('#mamount_type').val();
        var mcard_no = $('#mcard_no').val();
        var mex_date = $('#mex_date').val();
        var misdefault = $('#misdefault').val();
        
        if($("#misdefault").is(':checked')){
            var isd = '1';
        }else{
            var isd = '0';
        }
        var Error_msg = '';
            if(mamount_type == 0){
                Error_msg += 'Place Select Amount Type !<br>';
            }
            if(mcard_no == ''){
                Error_msg += 'Place Enter Card No. !<br>';
            }
            if(mex_date == ''){
                Error_msg += 'Place Select Expiration Date !<br>';
            }
            if(Error_msg != ''){
                toster_message_error(Error_msg, 'Error', 'error');
            }else{ 
        
            $.ajax({
                type: 'POST',
                url: BASEURL +'index.php/flex/add_new_paymentdtl',
                data : {PayType : mamount_type,CardNo : mcard_no, Expiry : mex_date, isDefault : isd},
                dataType: 'json',
                success: function (returnData) {
                    if (returnData.status == "ok") {
                        toster_message('Payment Detail Added Successfully.', 'Success', 'success');
                        setTimeout(function() {
                            window.location.reload();
                        }, 3000);
                    } 
                },
                /*error: function (xhr, textStatus, errorThrown) {
                    toster_message('There was an unknown error that occurred. You will need to refresh the page to continue working.', 'Error', 'error');
                },*/
            });    
            $(".bs-example-modal-md").modal('hide');
        }
    }
    
    function mackdefult(id){
        var result = confirm("Want to Set Defult Payment ?");
        if (result) {
            $.ajax({
                type: 'POST',
                url: BASEURL +'index.php/user/make_defult_payment',
                data : {id : id},
                dataType: 'json',
                success: function (returnData) {
                    if (returnData.status == "ok") {
                        toster_message('Detail Saved Successfully.', 'Success', 'success');
                        setTimeout(function() {
                            window.location.reload();
                        }, 3000);
                    }
                //consol.log('ok');
                },
            });
        }
    }
    
    function follow(id){
        $.ajax({
            type: 'POST',
            url: BASEURL +'index.php/user/follow_user',
            data : {id : id},
            dataType: 'json',
            success: function (returnData) {
                if (returnData.status == "ok") {
                    toster_message(returnData.message, 'Success', 'success');
                        $('#followers').text(returnData.data);
                        $('#follow_btn').text(returnData.btn);
                }
            },
        });
    }
</script>