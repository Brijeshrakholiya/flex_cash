<?php $form_attr = array('class' => 'comment_frm', 'id' => 'comment_frm', 'name' => 'comment_frm');
$invite_form = array('class' => 'invite_form', 'id' => 'invite_form', 'name' => 'invite_form');
$new_url = base64_encode(current_url());
$page_url = base_url().'flex/share_link/?link='.$new_url;

$fb_img = base_url().'/assets/images/fb.png';
$gp_img = base_url().'/assets/images/gp.png';
$tw_img = base_url().'/assets/images/tw.png';
//echo $url;
?>
<input type="hidden" name="flexid" id="flexid" value="<?php echo $flex_info->FlexID ;?>"/>
<div class="content">
    <div class="event_block">
        <div class="container">
            <div class="row">
                <div class="img_banner">
                         <?php
                        $file = FLEX_IMG_VIEW_PATH.$flex_info->FlexImageURL ;
                        if(!empty($flex_info->FlexImageURL) && file_exists($file)) {
                            $img = IMG_URL.FLEX_IMG_VIEW_PATH.$flex_info->FlexImageURL; 
                        }else{
                            $img = base_url().'/assets/images/default.jpg';
                        }?>
                        <img src="<?php echo $img;?>" class="thumbnail"/>
                    </div>
                
                <div class="col-md-6">
                    <div class="row">
                        <?php
                        $file = USER_IMG_THUMB_PATH.$flex_info->image; ;
                        if(!empty($flex_info->image) && file_exists($file)) {
                            $user_thumb_img = IMG_URL.USER_IMG_THUMB_PATH.$flex_info->image;
                        }else{
                            $user_thumb_img = base_url().'/assets/images/default_user.jpg';
                        }?>
                            <div class="col-md-6 pull-left">
                                <?php $url = 'user/user_activity/'.$flex_info->id; ;?>
                                <h3><a href="<?php echo base_url().$url;?>" ><img alt="" class="img-circle" src="<?php echo $user_thumb_img;?>" height="30px" width="30px" /> <span><?php echo $flex_info->username;?></a></span> Created</h3>
                            </div>
                            <div class="col-md-6 pull-right">
                                <h3 class="text-right"><span><?php if($flex_info->AmountType == 1){echo 'Any Amount';}else{ echo '$'.$flex_info->Amount;}?></span></h3>
                            </div>    
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                            <h2><a href="javascript:;" ><?php echo $flex_info->FlexName; ?></a></h2>
                            <p class="desc"><?php echo $flex_info->FlexDesc;?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h3><span><?php echo $flex_info->Joiner;?><?php if($flex_info->FlexCat == 1){echo ' Sold ';}else{echo ' Collected ';}?>(<?php if($flex_info->TotalAmount == NULL){echo '0';}else{ $Amt = $flex_info->TotalAmount; $NAmt = ($Amt * 3)/100;$Total = $Amt - $NAmt; echo '$'.$Total;} ?>)</span></h3>
                            </div>
                        </div>
                    <br>
                    <?php if(get_remaing_days($flex_info->EndsOn) != 'Ended'){?>
                    <?php 
                        $pro = $flex_info->Joiner * 100;
                        $progress = $pro/$flex_info->MaxQty;  
                        if($progress > 100 ){
                            $progress = 100;
                        }
                        
                    ?>
                   <div class="row">
                       <div class="col-md-12" >
                           <div id="myProgress" style="border: 1px solid #ccc;">
                            <div id="myBar" style="width:<?php echo $progress; ?>%;height:10px;background-color:#F59E2D;"></div>
                           </div>
                        </div>
                    </div>
                        <div class="row">
                            
                            <div class="col-md-6">
                                <h5><?php echo get_remaing_days($flex_info->EndsOn); ?></h5>
                                <?php
                                if($flex_info->FlexUserID != $this->tank_auth->get_user_id()){
                                    if($flex_info->MaxQty > $flex_info->Joiner){?>
                                    <a href="<?php echo base_url(); ?>flex/join_flex/<?php echo $flex_info->FlexID;?>" ><button class="btn btn-custom orange"><i class="fa fa-check"></i> Join Flex</button></a>
                                    <?php }else{ ?>
                                        <a href="javascript:;" ><button class="btn btn-custom orange full_flex"><i class="fa fa-check"></i> Join Flex</button></a>
                                    <?php }
                                }else{?>
                                    <a href="javascript:;" ><button class="btn btn-custom orange invite_btn"><i class="fa fa-plus"></i> Invite</button></a>
                                <?php } ?>
                            </div>
                            
                            <div class="col-md-6 text-right">
                                <?php if($flex_info->FlexCat == 1){ ?>
                                <h5 class="text-right">Flexes at <?php echo $flex_info->GoalQty ?><?php if($flex_info->FlexCat == 1){echo ' Sold ';}else{echo ' Collected ';}?></h5>
                                <?php }else{?>
                                <h5>Collection</h5>
                                <?php } ?>
                                <!-- <button class="btn btn-custom btn-share"><i class="fa fa-share-square-o"></i> Share</button> -->
                                 <div class="dropdown">
                                      <button class="btn btn-custom btn-share dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-share-square-o"></i> Share <span class="caret"></span></button>
                                      <ul class="dropdown-menu">
                                        <li><a target="_blank" href="http://www.facebook.com/sharer.php?u=<?php echo $page_url; ?>" title="Facebook Share"><img src="<?php echo $fb_img; ?>"></a></li>
                                        <li><a target="_blank" href="https://plus.google.com/share?url=<?php echo $page_url; ?>" title="google Share"><img src="<?php echo $gp_img; ?>"></a></li>
                                        <li><a target="_blank" href="http://twitter.com/share?url=<?php echo $page_url; ?>" title="Twitter Share"><img src="<?php echo $tw_img; ?>"></a></li>
                                      </ul>
                                    </div> 
                            </div>
                            
                        </div>
                    <?php }else{ ?>
                    <div class="row">
                        <div class="alert alert-danger">
                            <strong>Ended!</strong> This Flex already ended.(<?php echo time_elapsed_string($flex_info->EndsOn);?>)
                          </div>
                    </div>
                    <?php } ?>
                </div>
                <div class="col-md-6">
                <div class="row">
                <div class="col-md-12">
                    <div class="grid-body">
                            <ul class="nav nav-tabs  responsive-tabs panel-heading">
                              <li class="active"><a href="#comments"><i class="fa fa-comments-o"></i> Comments</a></li>
                              <li ><a href="#joined"><i class="fa fa-users"></i> Joined</a></li>
                              
                              <li><a href="#invited"><i class="fa fa-plus-circle"></i> Invited</a></li>
                              
                            </ul>
 
                            <div class="tab-content">
                                <div class="tab-pane" id="joined">
                                    <div class="join_box">  
                                    <?php foreach($join_info as $join){?> 
                                    <?php
                                    $file = USER_IMG_THUMB_PATH.$join->image; 
                                    if(!empty($join->image) && file_exists($file)) {
                                        $user_thumb_img = IMG_URL.USER_IMG_THUMB_PATH.$join->image;
                                    }else{
                                        $user_thumb_img = base_url().'/assets/images/default_user.jpg';
                                    }?>
                                    <div class="row">
                                            <div class="col-md-3">
                                                <img class="img-circle nav-user-photo" src="<?php echo $user_thumb_img;?>" height="65px" max-width="65px" alt="">
                                            </div>
                                        <div class="col-md-6">
                                            
                                            <p><?php echo $join->username;?></p>
                                            
                                            <p><span>Quantity : </span><?php echo $join->Qty;?></p>
                                        </div>
                                        <div class="col-md-3">
                                            <p><span>Join On</span> <?php echo date('M d',strtotime($join->JoinDate)); ?></p>
                                            <?php if($flex_info->FlexUserID == $this->tank_auth->get_user_id()){?>
                                            <p><span class="left-tooltip-container">
                                                    <button class="js-tooltip btn-xs btn-equal btn-mini btn-xs" onclick="user_details(<?php echo $join->UserFlexID;?>)" data-tooltip-prefix-class="left-tooltip" data-tooltip-content-id="informations_3" data-tooltip-title="Joiner Details" data-tooltip-close-text="Close" data-tooltip-close-title="Close this window" data-tooltip-close-img="blackcancel.svg" id="label_tooltip_5">More Details</button>
                                                </span></p>
                                            <?php } ?>
                                        </div>
                                         
                                        </div>
                                     
                                        <?php }?>
                                        <?php if(!isset($join_info)){?>
                                    <p class="text-danger">No User Joined Yet.</p>
                                        <?php } ?>
                                    </div>   
                                </div>
                                
                                <div class="tab-pane" id="invited">
                                    <div class="invite_box">
                                    <?php foreach($invitee_info as $invi){?>   
                                    <?php
                                    $file = USER_IMG_THUMB_PATH.$invi->image; 
                                    if(!empty($invi->image) && file_exists($file)) {
                                        $user_thumb_img = IMG_URL.USER_IMG_THUMB_PATH.$invi->image;
                                    }else{
                                        $user_thumb_img = base_url().'/assets/images/default_user.jpg';
                                    }?>    
                                    <div class="row">
                                            <div class="col-md-3">
                                                <img class="img-circle nav-user-photo" src="<?php echo $user_thumb_img ;?>" height="65px" max-width="65px" alt="">
                                            </div>
                                        <div class="col-md-6">
                                            <p><?php echo $invi->username;?></p>
                                        </div>
                                        <div class="col-md-3">
                                            <p><span>Invite On</span> <?php echo date('M d',strtotime($invi->InvitationDate)); ?></p>
                                        </div>
                                         
                                        </div>
                                
                                        <?php }?>
                                        <?php if(!isset($invitee_info)){?>
                                        <p class="text-danger">No User Invited Yet.</p>
                                        <?php } ?>
                                        </div>
                                </div>

                                <div class="tab-pane active" id="comments">
                                    
                                    <div class="row">
                                        
                                    <div class=" col-md-12 ">
                                    <ul id="comments-list" class="comment-list">
                                    <?php foreach($comment_info as $comment){?>  
                                    <?php
                                    $file = USER_IMG_THUMB_PATH.$comment->image; 
                                    if(!empty($comment->image) && file_exists($file)) {
                                        $user_thumb_img = IMG_URL.USER_IMG_THUMB_PATH.$comment->image;
                                    }else{
                                        $user_thumb_img = base_url().'/assets/images/default_user.jpg';
                                    }?>   
                                    <li>
                                        <div class="comment-main-level">
                                            <div class="col-md-3"><img class="img-circle nav-user-photo" src="<?php echo $user_thumb_img ;?>" alt=""></div>
					<div class="comment-box col-md-9">
                                            <div class="comment-head">
                                                <h6 class="comment-name by-author"><?php echo $comment->username ;?></h6>
                                                <div class="comment_date"><i class="fa fa-calendar"> </i> <?php echo date('M d',strtotime($comment->CommentDate)); ?></div>
                                            </div>
                                            <div class="comment-content">
                                                <h5><?php echo $comment->Comment ;?></h5>
                                            </div>
					</div>
                                        </div>
                                    </li>
                                    <?php } ?>
                                    </ul>
                                </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                        
                                            <?php echo form_open_multipart(base_url('flex/user_comments'), $form_attr); ?>
                                            <input type="hidden" name="flex_id" id="flex_id" value="<?php echo $flex_info->FlexID ; ?>" />    
                                        <div class="form-group">
                                            <textarea class="form-control" name="comment" placeholder="Comment..." id="comment" rows="5"></textarea>
                                        </div>
                                            <div class="pull-right">    
                                        <button type="submit" class="btn btn-warning">Post</button> 
                                            </div>
                                            <?php echo form_close(); ?> 
                                       
                                        </div>    
                                    </div>
                                </div>  
                            </div>
                    </div>   
                </div>
            </div></div>
            </div>
            
        </div>
    </div>
</div>

<div class="modal fade bs-invite-modal-md" id="custom" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" >
        <div class="modal-content" id="timetable_model_main">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4><span class="semi-bold" id="myModalLabel2">Invite Friend's</span></h4>
            </div>
            <div class="grid simple horizontal orenge" id="timetable-slot">
                <div class="grid-body" >
                    <table class="table table-responsive field_wrapper" id="model_content_area">
                        <div class="join_box">  
                            <?php 
                            if(isset($inv_info)){
                                foreach($inv_info as $inv){?> 
                                    <div class="row">
                                        <div class="col-md-3">
                                          <div class="checkbox">
                                            <div class="form-group">        
                                                <label class="switch">
                                                    <input id="inv" name="inv" value="<?php echo $inv->id;?>" type="checkbox">                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                          </div>
                                        </div>    
                                        <div class="col-md-3">
                                            <?php
                                                $file = USER_IMG_VIEW_PATH.$inv->image ;
                                                if(!empty($inv->image) && file_exists($file)) {
                                                        $img = IMG_URL.USER_IMG_VIEW_PATH.$inv->image; 
                                                }else{
                                                        $img = base_url().'/assets/images/default_user.jpg';
                                                }?>
                                            <img class="img-circle nav-user-photo" src="<?php echo $img;?>" height="65px" max-width="65px" alt="">
                                        </div>
                                        <div class="col-md-6">
                                            <p><?php echo $inv->username;?></p>
                                        </div>
                                    </div>

                                <?php }}
                                else{?>
                                    <p class="text-danger">No Friend's Found.</p>
                                <?php } ?>
                            </div>
                    </table>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="reset" class="btn btn-warning submitBtn" onclick="submitinviteeForm()">Invite</button>
            </div>
        </div>
    </div>
    </div>

<div class="col autotablet aligncenter"> 
    <div id="informations_3" class="hidden">
        <section id="flexform_section">
            <div class="flexform_box payment_box joiner" style="width: 475px;">
                   <?php /* <div class="row">
                        <div class="col-md-3">
                            <img class="img-circle nav-user-photo" src="<?php echo $user_thumb_img;?>" height="65px" max-width="65px" alt="">
                        </div>
                        <div class="col-md-9">
                            <p></p>
                            <p><span>Quantity : </span></p>
                            <p><span>Amount : </span></p>
                            <p><span>Join Date : </span></p>
                        </div>    
                    </div>    
                <div class="form-group">
                    <label class="">Request information & Contributors response :</label>
                </div>*/ ?>
                <div id="joiner_data"></div>
<!--                    <div class="form-group">
                        
                        <p class="question">Q.1 This is Question ?</p>
                        <p class="option"><span class="fa fa-user"></span> Doing business electronically</p>
                    </div>-->
            </div>
        </section>    
    </div>
</div>

<script>
    
    function user_details(jid){
        $.ajax({
            type: 'POST',
            url: BASEURL +'flex/joiner_dtl',
            data : {jid : jid},
            dataType: 'json',
            success: function (returnData) {
                if (returnData.status == "ok") {
                    
                    if (returnData.joiner_info != null) {
                            var html_data ='';
                                html_data += '<div class="row">'
                                +'<div class="col-md-3">'
                                +'<img class="img-circle nav-user-photo" src="'+returnData.joiner_info.UserImage+'" height="65px" max-width="65px" alt="">'
                                +'</div>'
                                +'<div class="col-md-9">'
                                +'<p>'+returnData.joiner_info.username+'</p>'
                                +'<p><span>Quantity : </span>'+returnData.joiner_info.Qty+'</p>'
                                +'<p><span>Amount : </span>'+returnData.joiner_info.FlexAmt+'</p>'
                                +'<p><span>Join Date : </span>'+returnData.joiner_info.JoinDate+'</p>'
                                +'</div></div>'    
                                +'<div class="form-group"><label class="">Request information & Contributors response :</label></div>';
                        }
                        if (returnData.que_info != null) {
                            var cnt = 1;
                            $.each(returnData.que_info, function (idx,que) {
                                html_data +='<div class="form-group">'
                                +'<p class="question">Q.'+cnt + ' '+que.Question+'</p>'
                                +'<p class="option"><span>Ans.</span> '+que.Answer+'</p>'
                                +'</div>';
                                cnt++;
                            });   
                        }    
                        
                    $('#joiner_data').html(html_data);  
                }
            }
        });    
    }
    
    function submitinviteeForm(){
        var user_ids = [];
        $.each($('input[name="inv"]:checked'), function() {
            var val =$(this).val();
            user_ids.push(val);
        });
        //alert(user_ids);
        if(user_ids != ''){
            var flexid = $('#flexid').val();
            var uid = USERID;
        $.ajax({
            type: 'POST',
            url: BASEURL +'flex/invite_web_user',
            data : {flexid : flexid, uid : uid, user_ids : user_ids},
            dataType: 'json',
            success: function (returnData) {
                if (returnData.status == "ok") {
                    toster_message(returnData.message, returnData.heading, 'success');
                    setTimeout(function() {
                        window.location.reload();
                        $(window).scrollTop(0);
                    }, 5000);
                    $(".bs-invite-modal-md").modal('hide');
                }
            }
        }); 
            
        }else{
            toster_message_error('Please Select User to Invite !', 'Warning', 'error');
        }
        
    }
    
</script>


