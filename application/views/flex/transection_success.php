<?php $form_attr = array('class' => 'flex_frm', 'id' => 'add_flex_frm', 'name' => 'add_flex_frm');
$new_url = base64_encode(base_url().'flex/flex_details/'.$join_info->FlexID);
$page_url = base_url().'flex/share_link/?link='.$new_url;

$fb_img = base_url().'/assets/images/fb.png';
$gp_img = base_url().'/assets/images/gp.png';
$tw_img = base_url().'/assets/images/tw.png';
?>
<section id="flexform_section">
      <div class="content">
          <?php// var_dump($join_info); ?>
        <div class="flexform_block">
          <div class="container">
              <?php  //$this->load->view("includes/messages");?>
            <div class="flexform_box transection_block">
              <?php echo form_open_multipart(base_url('index.php/home/submit_form'), $form_attr); ?>
                <h4>Transaction Successful </h4>
                <div class="tra_no">
                  <h5>Please Note Your Transaction Number</h5>
                  <h4><?php echo $this->session->userdata('TransactionID'); ?></h4>
                </div>
                <h3>Thank you for your payment..!</h3>
                <a href="<?php echo base_url();?>home/flex_list" class="btn btn-default add_question">Done</a>
                </br>
                
                 <!--<a href="javascript:;" class="btn btn-custom orange" ><i class="fa fa-user"></i> Share this Flex</a>-->
                 <?php if($join_info->MaxQty > $join_info->Joiner){?>
                <a href="<?php echo base_url();?>flex/join_flex/<?php echo $join_info->FlexID;?>" class="btn btn-custom orange" ><i class="fa fa-user"></i> Join this Flex Again</a>
                <?php }else{ ?>
                <a href="javascript:;" class="btn aa btn-custom orange" onclick="full_flex()" ><i class="fa fa-user"></i> Join this Flex Again</a>    
                    <?php } ?>   
                <a href="javascript:;" class="btn aa btn-custom orange invite_btn"><i class="fa fa-user"></i> Invite Friends to this Flex</a>
               
                
                    <div class="dropdown aa">
                                      <a class="btn btn-custom orange dropdown-toggle"  data-toggle="dropdown"><i class="fa fa-share-square-o"></i> Share <span class="caret"></span> </a>
                                      <ul class="dropdown-menu">
                                        <li><a target="_blank" href="http://www.facebook.com/sharer.php?u=<?php echo $page_url; ?>" title="Facebook Share"><img src="<?php echo $fb_img; ?>"></a></li>
                                        <li><a target="_blank" href="https://plus.google.com/share?url=<?php echo $page_url; ?>" title="google Share"><img src="<?php echo $gp_img; ?>"></a></li>
                                        <li><a target="_blank" href="http://twitter.com/share?url=<?php echo $page_url; ?>" title="Twitter Share"><img src="<?php echo $tw_img; ?>"></a></li>
                                      </ul>
                                    </div>
                
                </div>
               
              <?php echo form_close(); ?> 
            
            </div>
            
          </div
          
        </div>
      </div>
    </section>



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
                            <input type="hidden" value="<?php echo $join_info->FlexID;?>" name="flexid" id="flexid" />
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

<script>
    
    function full_flex() {
        toster_message_error('This Flex already full.', 'Warning', 'error');
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
            url: BASEURL +'index.php/flex/invite_web_user',
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