<section id="flex_section">
      <div class="container"> 
        <div class="profile-content">
            <div class="row">
              <div class="col-md-12">
                <div class="portlet light">
                  <div class="portlet-title tabbable-line">
                   <div class="caption caption-md">
                      <i class="icon-globe theme-font hide"></i>
                      <span class="caption-subject font-blue-madison bold" id="tab_hedding"><i class="fa fa-bell-o"></i> Your Notifications</span>
                    </div> 
                  </div>
                  <div class="portlet-body">
                    <div class="tab-content">
                      <!-- PERSONAL INFO TAB -->
                      <div class="tab-pane active" id="tab_1_6">
                          <div class="join_box">  
                            <?php foreach($not_info as $notificatin){?> 
                              <div class="row <?php if($notificatin->IsViewed == 0){echo 'viewed';}?>" style="padding-top: 5px;padding-bottom: 5px;">
                                    <div class="col-md-4">
                                        <?php
                                            $file = USER_IMG_THUMB_PATH.$notificatin->ImageURL;
                                            if(!empty($notificatin->ImageURL) && file_exists($file)) {
                                                $img = IMG_URL.USER_IMG_THUMB_PATH.$notificatin->ImageURL; 
                                            }else{
                                                $img = base_url().'/assets/images/default.jpg';
                                            }?>
                                        <img class="img-circle nav-user-photo" src="<?php echo $img;?>" height="65px" max-width="65px" alt="">
                                    </div>
                                <div class="col-md-8">
                                    <p><?php echo $notificatin->NotificationDesc;?></p>
                                    <p><span style="font-size: 18px;"><i class="fa fa-<?php echo $notificatin->Icon;?>"></i></span><?php echo ' '.time_elapsed_string($notificatin->NotificationDate); ?></p>
                                </div>
                                

                                </div>

                                <?php }?>
                                <?php if(!isset($not_info)){?>
                            <p class="text-danger">No Notification Yet.</p>
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
                                    <h5><span><?php echo $flex->Joiner;?></span><?php if($flex->FlexCat == 1){echo ' Sold ';}else{echo ' Collected ';}?><span>(<?php if($flex->Amount == NULL){echo '0';}else{ echo $flex->Amount;} ?>)</span></h5>
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
      </div>
</section>