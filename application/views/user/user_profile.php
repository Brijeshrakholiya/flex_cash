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
              <?php /* <div class="profile-userbuttons">
                <button type="button" class="btn btn-circle btn-warning btn-sm">Follow</button>
              </div> */?>
              <!-- END SIDEBAR BUTTONS -->
              <!-- SIDEBAR MENU -->
              <!-- PORTLET MAIN -->
            <div class="portlet light">
              <!-- STAT -->
              <div class="row list-separated profile-stat">
                <div class="col-md-4 col-sm-4 col-xs-6">
                  <div class="uppercase profile-stat-title">
                     <?php echo $user_info->Followers; ?>
                  </div>
                    <div class="uppercase profile-stat-text" >
                     <a href="#tab_1_9" id="tab9" data-toggle="tab">Followers</a>
                  </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-6">
                  <div class="uppercase profile-stat-title">
                     <?php echo $user_info->Following; ?>
                  </div>
                  <div class="uppercase profile-stat-text">
                     <a href="#tab_1_10" id="tab10" data-toggle="tab">Following</a>
                  </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-6">
                  <div class="uppercase profile-stat-title">
                     <?php echo $user_info->CreatFlex; ?>
                  </div>
                  <div class="uppercase profile-stat-text">
                      <a href="#tab_1_3" id="tab3a" data-toggle="tab">My Created</a>
                  </div>
                </div>
              </div>
              <div class="profile-usermenu">
                  <ul class="nav" id="myTab">
                  <li class="active">
                      <a href="#tab_1_1" id="tab1" data-toggle="tab"><i class="fa fa-cog"></i> Account Settings</a>
                      </li>
                      <li>
                          <a href="#tab_1_2" id="tab2" data-toggle="tab"><i class="fa fa-key"></i> Change Password</a>
                      </li>
                      <li>
                          <a href="#tab_1_5" id="tab5" data-toggle="tab"><i class="fa fa-info"></i> Payment Info.</a>
                      </li>
                       <li>
                          <a href="#tab_1_6" id="tab8" data-toggle="tab"><i class="fa fa-credit-card-alt"></i> Transaction Summary</a>
                      </li>
                      
                      <li>
                          <a href="#tab_1_3" id="tab3" data-toggle="tab"><i class="fa fa-th-large"></i> My Created</a>
                      </li>
                      <li>
                          <a href="#tab_1_4" id="tab4" data-toggle="tab"><i class="fa fa-plus-square"></i> My Joined</a>
                      </li>
                      <li class="hidden">
                          <a href="#tab_1_10" id="tab10" data-toggle="tab"></a>
                      </li>
                      <li class="hidden">
                          <a href="#tab_1_9" id="tab9" data-toggle="tab"></a>
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
                      <span class="caption-subject font-blue-madison bold uppercase" id="tab_hedding">Account Settings</span>
                    </div> 
                   <?php /* <ul class="nav nav-tabs">
                      <li class="active">
                        <a href="#tab_1_1" data-toggle="tab">Personal Info</a>
                      </li>
                      <li>
                          <a href="#tab_1_2" data-toggle="tab">Change Password</a>
                      </li>
                      <li>
                          <a href="#tab_1_3" data-toggle="tab">My Flexes</a>
                      </li>
                      <li>
                          <a href="#tab_1_4" data-toggle="tab">My Joined</a>
                      </li>
                    </ul>*/?>
                  </div>
                  <div class="portlet-body">
                    <div class="tab-content">
                      <!-- PERSONAL INFO TAB -->
                      <div class="tab-pane active" id="tab_1_1">
                        <?php echo form_open_multipart(base_url('index.php/user/submit_form'), $user_form_attr); ?>
                            <div class="row">
                                <div class="col-md-8">
                          <div class="form-group">
                            <label class="control-label">Full Name</label>
                            <input type="text" placeholder="" name="username" value="<?php echo $user_info->username; ?>" class="form-control"/>
                          </div>
                          <div class="form-group">
                            <label class="control-label">Email</label>
                            <input type="email" placeholder="" name="email" value="<?php echo $user_info->email; ?>" class="form-control" readonly/>
                          </div>
                          <div class="form-group">
                            <label class="control-label">Mobile Number</label>
                            <input type="text" placeholder="" name="phone" value="<?php echo $user_info->phone;?>" class="form-control"/>
                          </div>
                                </div>
                                <div class="col-md-4">      
                          <div class="form-group">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                              <div class="fileinput-new thumbnail" style="width: 160px; height: 160px;">
                                  <img src="<?php  echo $user_img; ?>" width="160px" height="160px" id="img_back" alt=""/>
                              </div>
                                                            <div>
                            <input type="file" id="fileUpload" class="" name="image">
                               
                              </div>
                            </div>
                          </div>  
                                </div>
                                    </div>
                          <div class="margiv-top-10">
                            <?php echo form_submit($user_submit_btn); ?>
                          </div>
                        <?php echo form_close(); ?> 
                      </div>
                      <!-- END PERSONAL INFO TAB -->
                      
                      <!-- CHANGE PASSWORD TAB -->
                      <div class="tab-pane" id="tab_1_2">
                        <?php echo form_open_multipart(base_url('index.php/user/change_password'), $pass_form_attr); ?>
                          <?php /*
                          <div class="form-group">
                            <?php echo form_label('Current Password', $old_password['id']); ?>
                            <?php echo form_password($old_password); ?>
                            <?php echo form_error($old_password['name']); ?><?php echo isset($errors[$old_password['name']])?$errors[$old_password['name']]:''; ?>
                          </div>
                          <div class="form-group">
                            <?php echo form_label('New Password', $new_password['id']); ?>
                            <?php echo form_password($new_password); ?>
                            <?php echo form_error($new_password['name']); ?><?php echo isset($errors[$new_password['name']])?$errors[$new_password['name']]:''; ?>
                          </div>
                          <div class="form-group">
                            <?php echo form_label('Re-type New Password', $confirm_new_password['id']); ?>
                            <?php echo form_password($confirm_new_password); ?>
                            <?php echo form_error($confirm_new_password['name']); ?><?php echo isset($errors[$confirm_new_password['name']])?$errors[$confirm_new_password['name']]:''; ?>
                          </div>
                          <div class="margin-top-10">
                            <?php echo form_submit($submit_btn); ?>
                          </div>
                          */ ?>
                        <div class="form-group">
                            <label>Current Password</label>
                            <input type="password" class="form-control" name="old_password" id="old_password" placeholder="Old Password" id="name">
                        </div>
                        <div class="form-group">
                            <label>New Password</label>
                            <input type="password" class="form-control" name="new_password" id="new_password" placeholder="New Password" id="name">
                        </div>
                        <div class="form-group">
                            <label>Re-type New Password</label>
                            <input type="password" class="form-control" name="confirm_new_password" id="confirm_new_password" placeholder="Confirm New Password" id="name">
                        </div>  
                        <div class="margin-top-10">
                            <button type="submit" class="btn btn-warning">Change Password</button>
                           <?php // echo form_submit($submit_btn); ?>
                        </div>
                        <?php echo form_close(); ?>
                      </div>
                      <!-- END CHANGE PASSWORD TAB -->
                      
                      <div class="tab-pane" id="tab_1_3">
                           <section id="event_section">
                        <div class="content">
                          <div class="event_block">
                              <div class="event_box">
                          <div class="event_inner">
                           <div class="row">
                           <?php 
                           if($flex_info){
                           foreach ($flex_info as $flex){?>
                            <div class="col-md-4">
                              <div class="session_box">
                                <div class="session my_flex">
                                    <?php
                                    $file = FLEX_IMG_VIEW_PATH.$flex->FlexImageURL ;
                                    if(!empty($flex->FlexImageURL) && file_exists($file)) {
                                        $img = IMG_URL.FLEX_IMG_VIEW_PATH.$flex->FlexImageURL; 
                                    }else{
                                        $img = base_url().'/assets/images/default.jpg';
                                    }?>
                                    <a href="<?php echo base_url(); ?>index.php/flex/flex_details/<?php echo $flex->FlexID; ?>"><img src="<?php echo $img ;?>" class="flex-img" width="363px" height="155px" /></a>
                                    <time><?php  echo get_remaing_days($flex->EndsOn); ?></time>
                                    <h5><span><?php echo $flex->Joiner;?></span><?php if($flex->FlexCat == 1){echo ' Sold ';}else{echo ' Collected ';}?><span>(<?php if($flex->Amount == NULL){echo '0';}else{ $Amt = $flex->Amount; $NAmt = ($Amt * 3)/100;$Total = $Amt - $NAmt; echo $Total;} ?>)</span></h5>
                                    <h3 class="my_flex_name"><a href="<?php echo base_url(); ?>index.php/flex/flex_details/<?php echo $flex->FlexID; ?>"><?php echo $flex->FlexName;?></a></h3>

                                </div>
                                <div class="session-next">
                                <h4><span><?php if($flex->Joiner == NULL){echo '0';}else{ echo $flex->Joiner;} ?> Joined</span><span class="pull-right"><?php if($flex->Comments == NULL){echo '0';}else{ echo $flex->Comments;} ?> Comments</span> </h4>
                                
                                <div class="text-center"><hr>
                                <?php if(get_remaing_days($flex->EndsOn) != 'Ended' && $flex->FlexCat == 2 && $flex->Joiner > 0){?>
                                    <button class="btn btn-warning" style="width:auto;border-radius:5px;" onclick="request_money(<?php echo $flex->FlexID;?>)" id="refund_btn_<?php echo $join->UserFlexID; ?>" >Money Request</button><?php } ?></div>
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
                      <div class="tab-pane" id="tab_1_4">
                          <section id="event_section">
                        <div class="content">
                          <div class="event_block">
                              <div class="event_box">
                          <div class="event_inner">
                           <div class="row">
                           <?php
                           if($join_info){
                           foreach ($join_info as $join){?>
                            <div class="col-md-4">
                              <div class="session_box">
                                  <?php
                                    $file = FLEX_IMG_VIEW_PATH.$join->FlexImageURL ;
                                    if(!empty($join->FlexImageURL) && file_exists($file)) {
                                        $img = IMG_URL.FLEX_IMG_VIEW_PATH.$join->FlexImageURL; 
                                    }else{
                                        $img = base_url().'/assets/images/default.jpg';
                                    }?> 
                                <div class="session my_flex">
                                    <a href="<?php echo base_url(); ?>index.php/flex/flex_details/<?php echo $join->FlexID; ?>"><img src="<?php echo $img ;?>" class="flex-img" width="363px" height="155px" /></a>
                                    <time><?php  echo get_remaing_days($join->EndsOn); ?></time>
                                    <h5>Join On <span><?php echo date('M d',strtotime($join->JoinDate)); ?></span></h5>
                                    <h3 class="my_flex_name"><a href="<?php echo base_url(); ?>index.php/flex/flex_details/<?php echo $join->FlexID; ?>"><?php echo $join->FlexName;?></a></h3>

                                </div>
                                <div class="session-next">
                                <h4><span><?php if($join->Joiner == NULL){echo '0';}else{ echo $join->Joiner;} ?> Joined</span><span class="pull-right"><?php if($join->Comments == NULL){echo '0';}else{ echo $join->Comments;} ?> Comments</span> </h4>
                                <div class="text-center"><hr>
                                <?php if(get_remaing_days($join->EndsOn) != 'Ended' && $join->FlexCat == 1){?>
                                    <button class="btn btn-warning" style="width:auto;border-radius:5px;" onclick="request_refund(<?php echo $join->UserFlexID.','.$join->FlexUserID.','.$join->FlexID;?>)" id="refund_btn_<?php echo $join->UserFlexID; ?>" >Request for Refund</button><?php } ?></div>
                                </div>  
                                  
                              </div>
                            </div>    
                           <?php }}else{?>
                               <p>Not Join Yet.</p>
                           <?php }?>
                           </div>
                        </div>
               
                      </div>                 </div>
                        </div>
                    </section>
                      </div>
                      <div class="tab-pane" id="tab_1_5">
                      <div class="row">
                          
                          <div class="pull-left">
                              <label><a href="javascript:;" class="btn btn-default add_merchant">Account Detail</a></label>
                          </div>
                          <div class="pull-right">
                              <label><a href="javascript:;" class="btn btn-default add_question">Add New Payment Detail</a></label>
                          </div>
                      </div>   
                        <hr>  
                    <?php
                    if($payment_info){$cnt = 1;
                    foreach($payment_info as $payment){ ?>
                          <div class="row">
                              <div class="col-md-2"><span class="card_count"><?php echo $cnt; ?></span></div>
                              <div class="col-md-8">
                    <div class="row">
                    <div class="form-group">
                        <div class="col-md-4"><label class="">Payment Method </label></div>
                        <div class="col-md-1"><b>:</b></div>
                        <div class="col-md-7">
                            <label><?php if(isset($payment) && $payment->PayType == 1){echo 'Apple Pay';}elseif($payment->PayType == 2){echo 'Credit Card';}else{echo 'Debit Card';} ?></label>
                        </div>
                             
                    </div>
                </div><br>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-4"><label class="">Card Details </label></div>
                        <div class="col-md-1"><b>:</b></div>
                        <div class="col-md-7">
                            <label><?php if(isset($payment) && $payment->CardNo != ""){ echo $payment->CardNo;}?></label></div>
                    </div>
                </div><br>
                
                <?php 
                if(isset($payment)){
                    $monthNum  = $payment->ExpiryMonth;
                    $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                    $monthName = $dateObj->format('M'); 
                }
                ?>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-4"><label class="">Expiration Date </label></div>
                        <div class="col-md-1"><b>:</b></div>
                        <div class="col-md-7">
                            <label><?php if(isset($payment)){ echo $monthName.' '. $payment->ExpiryYear; } ?></label>
                            </div>
                    </div>
                </div> <br>
                </div>
                  <div class="col-md-2">
                    <div class="row">
                        <?php if(isset($payment)){$id = $payment->UserpaymentDtlID;} ?>
                    <div class="form-group">  
                        <div class="checkbox">
                            <label class="switch">
                                <input class="" onchange="mackdefult(<?php echo $id;?>)" id="isdefault" name="isdefault" value="1" type="checkbox" <?php if(isset($payment) && $payment->isDefault == 1){echo 'checked';} ?>>  
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                        
                    <a  href="javascript:;"  class="btn btn-danger  btn-mini" onclick="del_paydtl(<?php echo $id;?>)"><i class="fa fa-trash-o"></i></a>    
                    </div>
                  </div></div><hr>
                    <?php $cnt++; }}else{
                        ?>
                            <p>No Payment Info. available</p>
                        <?php
                    } ?>
                      </div>
                      <div class="tab-pane" id="tab_1_6">
<!--                          <div class="pull-right">
                              <label><a href="javascript:;" class="btn btn-default" id="request_money" onclick="request_money()">Request Money</a></label>
                          </div>-->
                          <div class="row">
                <div class="col-md-12">
                    <div class="grid-body">
                            <ul class="nav nav-tabs  responsive-tabs panel-heading">
                              <li class="active"><a href="#all"><i class="fa fa-reply-all"></i> All</a></li>
                              <li ><a href="#in"><i class="fa fa-plus-circle"></i> Money In</a></li>
                              <li><a href="#out"><i class="fa fa-minus-circle"></i> Money Out</a></li>
                            </ul>
 
                            <div class="tab-content">
                                <div class="tab-pane active" id="all">
                                    <div class="join_box">  
                            <?php foreach($money_info as $money){?> 
                                <div class="row">
                                    <div class="col-md-3">
                                        <?php
                                            $file = FLEX_IMG_VIEW_PATH.$money->Image ;
                                            if(!empty($money->Image) && file_exists($file)) {
                                                    $img = IMG_URL.FLEX_IMG_VIEW_PATH.$money->Image; 
                                            }else{
                                                    $img = base_url().'/assets/images/default.jpg';
                                            }?>
                                        <p class="text-center" style="font-size: 12px;"><?php echo date('M d, Y',strtotime($money->JoinDate)); ?></p>
                                        <img class="img-circle nav-user-photo" src="<?php echo $img;?>" height="65px" max-width="65px" alt="">
                                        
                                    </div>
                                <div class="col-md-6">
                                    <p><?php echo $money->FlexName;?></p>
                                    <p style="font-size: 12px;"><span>TransactionID : </span><?php echo $money->TransactionID;?></p>
                                </div>
                                <div class="col-md-3">
                                    <?php if($money->type == 1){?>
                                        <?php $Amt = $money->FlexAmt; 
                                        $NAmt = ($Amt * 3)/100;
                                        $Total = $Amt - $NAmt; 
                                        if($money->Status == 0){?>
                                        <p style="color:#337ab7;"><?php echo '- $'.$Total;?></p>
                                        <p style="color:#f59d2d;font-size:13px;">Refunded</p>
                                    <?php }else{?>
                                        <p style="color:#4fa007e6;"><?php echo '+ $'.$Total;?></p>
                                    <?php }}else{
                                        if($money->Status == 0){?>
                                            <p style="color:#337ab7;"><?php echo '+ $'.$money->TxAmt;?></p>
                                            <p style="color:#f59d2d;font-size:13px;">Refunded</p>
                                        <?php }else{?> 
                                        <p style="color:#f62626e6;"><?php echo '- $'.$money->TxAmt;?></p>
                                    <?php }} ?>
                                </div>

                                </div>

                                <?php }?>
                                <?php if(!isset($money_info)){?>
                            <p class="text-danger">No Transaction Yet.</p>
                                <?php } ?>
                            </div>  
                                </div>
                                
                                <div class="tab-pane" id="in">
                                    <div class="join_box">  
                            <?php foreach($money_in as $money){?> 
                                <div class="row">
                                    <div class="col-md-3">
                                        <?php
                                            $file = FLEX_IMG_VIEW_PATH.$money->Image ;
                                            if(!empty($money->Image) && file_exists($file)) {
                                                    $img = IMG_URL.FLEX_IMG_VIEW_PATH.$money->Image; 
                                            }else{
                                                    $img = base_url().'/assets/images/default.jpg';
                                            }?>
                                        <p class="text-center" style="font-size: 12px;"><?php echo date('M d, Y',strtotime($money->JoinDate)); ?></p>
                                        <img class="img-circle nav-user-photo" src="<?php echo $img;?>" height="65px" max-width="65px" alt="">
                                        
                                    </div>
                                <div class="col-md-6">
                                    <p><?php echo $money->FlexName;?></p>
                                    <p style="font-size: 12px;"><span>TransactionID : </span><?php echo $money->TransactionID;?></p>
                                    
                                </div>
                                <div class="col-md-3">
                                    <?php $Amt = $money->FlexAmt; 
                                        $NAmt = ($Amt * 3)/100;
                                        $Total = $Amt - $NAmt; 
                                    if($money->Status == 0){?>
                                        <p style="color:#337ab7;"><?php echo '- $'.$Total;?></p>
                                        <p style="color:#f59d2d;font-size:13px;">Refunded</p>
                                    <?php }else{?>
                                        
                                        <p style="color:#4fa007e6;"><?php echo '+ $'.$Total;?></p>
                                    <?php }?>
                                </div>

                                </div>

                                <?php }?>
                                <?php if(!isset($money_in)){?>
                            <p class="text-danger">No Transaction Yet.</p>
                                <?php } ?>
                            </div>  
                                </div>

                                <div class="tab-pane" id="out">
                                    <div class="join_box">  
                            <?php foreach($money_out as $money){?> 
                                <div class="row">
                                    <div class="col-md-3">
                                        <?php
                                            $file = FLEX_IMG_VIEW_PATH.$money->Image ;
                                            if(!empty($money->Image) && file_exists($file)) {
                                                    $img = IMG_URL.FLEX_IMG_VIEW_PATH.$money->Image; 
                                            }else{
                                                    $img = base_url().'/assets/images/default.jpg';
                                            }?>
                                        <p class="text-center" style="font-size: 12px;"><?php echo date('M d, Y',strtotime($money->JoinDate)); ?></p>
                                        <img class="img-circle nav-user-photo" src="<?php echo $img;?>" height="65px" max-width="65px" alt="">
                                        
                                    </div>
                                <div class="col-md-6">
                                    <p><?php echo $money->FlexName;?></p>
                                    <p style="font-size: 12px;"><span>TransactionID : </span><?php echo $money->TransactionID;?></p>
                                    
                                </div>
                                <div class="col-md-3">
                                    
                                    <?php
                                        if($money->Status == 0){?>
                                            <p style="color:#337ab7;"><?php echo '+ $'.$money->TxAmt;?></p>
                                            <p style="color:#f59d2d;font-size:13px;">Refunded</p>
                                        <?php }else{?>
                                            <p style="color:#f62626e6;"><?php echo '- $'.$money->TxAmt;?></p>
                                        <?php }
                                    ?>
                                </div>

                                </div>

                                <?php }?>
                                <?php if(!isset($money_out)){?>
                            <p class="text-danger">No Transaction Yet.</p>
                                <?php } ?>
                            </div> 
                               </div>  
                            </div>
                    </div>   
                </div>
            </div>
                      </div>
                      
                      <div class="tab-pane" id="tab_1_9">
                          <div class="join_box">  
                            <?php foreach($follower_info as $follower){?> 
                                <div class="row">
                                    <div class="col-md-3">
                                        <?php
                                            $file = USER_IMG_VIEW_PATH.$follower->image ;
                                            if(!empty($follower->image) && file_exists($file)) {
                                                    $img = IMG_URL.USER_IMG_VIEW_PATH.$follower->image; 
                                            }else{
                                                    $img = base_url().'/assets/images/default_user.jpg';
                                            }?>
                                        <img class="img-circle nav-user-photo" src="<?php echo $img;?>" height="65px" max-width="65px" alt="">
                                    </div>
                                <div class="col-md-6">
                                    <?php $url = 'user/user_activity/'.$follower->id; ;?>
                                    <p><a href="<?php echo $url; ?>"><?php echo $follower->username;?></a></p>
                                    <p><span>Follow on</span> <?php echo date('M d',strtotime($follower->CreatedOn)); ?></p>
                                </div>
                                <div class="col-md-3">
                                    <?php 
                                        if($follower->IsFollow == 1){
                                            $str = 'Unfollow';
                                        }else{
                                            $str = 'Follow';
                                        }?>
                                    <div class="profile-userbuttons">
                                    <button type="button" class="btn btn-circle btn-warning btn-sm" id="follow_btn" onclick="follow(<?php echo $follower->id; ?>)"><?php echo $str; ?></button>
                                    </div>
                                </div>

                                </div>

                                <?php }?>
                                <?php if(!isset($follower_info)){?>
                            <p class="text-danger">No Followers Yet.</p>
                                <?php } ?>
                            </div> 
                      </div>
                      <div class="tab-pane" id="tab_1_10">
                          <div class="join_box">  
                            <?php foreach($following_info as $follower){?> 
                                <div class="row">
                                    <div class="col-md-3">
                                        <?php
                                            $file = USER_IMG_VIEW_PATH.$follower->image ;
                                            if(!empty($follower->image) && file_exists($file)) {
                                                    $img = IMG_URL.USER_IMG_VIEW_PATH.$follower->image; 
                                            }else{
                                                    $img = base_url().'/assets/images/default_user.jpg';
                                            }?>
                                        <img class="img-circle nav-user-photo" src="<?php echo $img;?>" height="65px" max-width="65px" alt="">
                                    </div>
                                <div class="col-md-6">
                                    <?php $url = 'user/user_activity/'.$follower->id; ;?>
                                    <p><a href="<?php echo $url; ?>"><?php echo $follower->username;?></a></p>
                                    <p><span>Follow on</span> <?php echo date('M d',strtotime($follower->CreatedOn)); ?></p>
                                </div>
                                <div class="col-md-3">
                                    <?php $str = 'Unfollow';?>
                                    <div class="profile-userbuttons">
                                    <button type="button" class="btn btn-circle btn-warning btn-sm" id="follow_btn" onclick="follow(<?php echo $follower->id; ?>)"><?php echo $str; ?></button>
                                    </div>
                                </div>

                                </div>

                                <?php }?>
                                <?php if(!isset($following_info)){?>
                            <p class="text-danger">Not Following  Yet.</p>
                                <?php } ?>
                            </div> 
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

<div class="modal fade bs-merchant-modal-md" id="custom" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" >
        <div class="modal-content" id="timetable_model_main">

            <div class="modal-header">
                
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4><span class="semi-bold" id="myModalLabel2">Account Details</span></h4>
            </div>
            <?php if($account_info){?>
                <div class="grid simple horizontal orenge" id="timetable-slot">
                <div class="grid-body" >
                    <p style="text-align:center;">We Send Your Payout in this Account. </p>
                    <hr>
                    <table class="table table-responsive field_wrapper" id="model_content_area">
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-4"><label class="">Account ID  </label></div>
                                    <div class="col-md-1"><b>:</b></div>
                                    <div class="col-md-7"><label class=""><?php echo $account_info->StripeAcID;?> </label></div>
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-4"><label class="">Email </label></div>
                                    <div class="col-md-1"><b>:</b></div>
                                    <div class="col-md-7"><label class=""><?php echo $account_info->Email;?></label></div>
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-4"><label class="">Account Holder Name </label></div>
                                    <div class="col-md-1"><b>:</b></div>
                                    <div class="col-md-7"><label class=""><?php echo $account_info->AccountHolderName;?> </label></div>
                                </div>
                            </div><br>    
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-4"><label class="">Bank Name </label></div>
                                    <div class="col-md-1"><b>:</b></div>
                                    <div class="col-md-7"><label class=""><?php echo $account_info->BankName;?></label></div>
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-4"><label class="">Account No. </label></div>
                                    <div class="col-md-1"><b>:</b></div>
                                    <div class="col-md-7"><label class=""><?php echo 'XXXXXXXX'.substr($account_info->AcNo,-4);?></label></div>
                                </div>
                            </div><br>
                    </table>
                
                </div>
            </div>
    
    <?php }else{?>
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
                                    <div class="col-md-7"><input type="email" class="form-control" name="ac_email" id="ac_email" value="<?php echo $user_info->email; ?>" readonly></div>
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
            <?php }?>
            <div class="clearfix"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <?php if(!$account_info){?>
                <button type="reset" class="btn btn-warning submitBtn" onclick="submitACForm()">Add</button>
                <?php } ?>
            </div>
        </div>
    </div>
    </div>

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
                    if(returnData.status == "error"){
                        toster_message("you can't delete defult card !", 'Error', 'error');
                        setTimeout(function() {
                            window.location.reload();
                        }, 3000);
                    }
                //consol.log('ok');
                },
            });
        }
    }
    
    function submitACForm(){
        var ac_email = $('#ac_email').val();
        var account_holder_name = $('#account_holder_name').val();
        var bank_name = $('#bank_name').val();
        var account_number = $('#account_number').val();
        
        var Error_msg = '';
            if(ac_email == 0){
                Error_msg += 'Place Enter Email !<br>';
            }
            if(account_holder_name == ''){
                Error_msg += '<br>Place Enter Account Holder Name !<br>';
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
                url: BASEURL +'index.php/user/add_accountdtl',
                data : {ac_email : ac_email,account_holder_name : account_holder_name, bank_name : bank_name, account_number : account_number},
                dataType: 'json',
                success: function (returnData) {
                    if (returnData.status == "ok") {
                        toster_message('Account Detail Added Successfully.', 'Success', 'success');
                        setTimeout(function() {
                            window.location.reload();
                        }, 3000);
                    } 
                },
            });    
            $(".bs-merchant-modal-md").modal('hide');
            }
    }
    
    
    function submitPaymentForm(){
        var mamount_type = $('#mamount_type').val();
        var mcard_no = $('#mcard_no').val();
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
                    data : {PayType : mamount_type,CardNo : mcard_no, ExpiryMonth : mmonth, ExpiryYear:myear, isDefault : isd},
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
    
    
    function request_refund(jid,uid,fid){
       
        var result = confirm("Want to Request for Refund ?");
        if (result) {
            $.ajax({
                type: 'POST',
                url: BASEURL +'index.php/user/refund_request',
                data : {jid : jid,uid : uid,fid : fid},
                dataType: 'json',
                beforeSend: function () {
                    $('#refund_btn_'+jid).val('Please wait..!').attr('disabled', 'disabled');
                },
                success: function (returnData) {
                    if (returnData.status == "ok") {
                        toster_message('Your Refund Request is send Successfully.', 'Success', 'success');
                    }else{
                        toster_message('There was an unknown error that occurred. You will need to refresh the page to continue working.', 'Error', 'error');
                    } 
                },
                complete: function () {
                    $('#refund_btn_'+jid).val('Request for Refund').removeAttr('disabled');
                }
                
            });  
        }    
    }
    
    function request_money(fid){
        
        var result = confirm("Want to Request Money Before Time ?");
        if (result) {
            $.ajax({
                type: 'POST',
                url: BASEURL +'index.php/user/request_money',
                data : {fid : fid},
                dataType: 'json',
                beforeSend: function () {
                    $('#request_money').val('Please wait..!').attr('disabled', 'disabled');
                },
                success: function (returnData) {
                    if (returnData.status == "ok") {
                        toster_message('Your Request is send Successfully.', 'Success', 'success');
                    }else{
                        toster_message(returnData.message, 'Error', 'error');
                    } 
                },
                complete: function () {
                    $('#request_money').val('Request Money').removeAttr('disabled');
                }
                
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
                    setTimeout(function() {
                        window.location.reload();
                    }, 3000);
                }
            },
        });
    }
</script>