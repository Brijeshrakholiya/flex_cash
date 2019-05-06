<?php $form_attr = array('class' => 'flex_frm', 'id' => 'add_payment_frm', 'name' => 'add_payment_frm');?>  

<?php /*
<section id="content">
      <div class="content">
	      <div class="banner">
        	<ul class="bxslider">
                    <?php foreach ($flex_info as $flex){?>
                    <li>
                        <img src="<?php echo base_url(); ?>assets/images/slide1.jpg"/>
                        <?php /*<img src="<?php echo IMG_URL.FLEX_IMG_VIEW_PATH.$flex->FlexImageURL ;?>" class="thumbnail"/> ?>
                        <div class="banner_txt home">              	
                            <h5>MEGA EVENT</h5>
                            <p><?php  echo date('M d',strtotime($flex->PublishedDate)); ?>–<?php  echo date('M d',strtotime($flex->EndsOn)); ?>, 2017</p>
                            <h2><a href="<?php echo base_url(); ?>index.php/flex/flex_details/<?php echo $flex->FlexID; ?>"><?php echo $flex->FlexName;?></a></h2>
                            <p><?php echo short_desc($flex->FlexDesc,200,true);?></p>
                            <?php  if($flex->MaxQty != $flex->Joiner){?>
                            <a href="<?php echo base_url(); ?>index.php/flex/join_flex/<?php echo $flex->FlexID;?>" ><button class="btn btn-custom"><i class="fa fa-check"></i> Join This Flex</button></a>
                             <?php }else{ ?>
                                    <a href="javascript:;" ><button class="btn btn-custom full_flex"><i class="fa fa-check"></i> Join This Flex</button></a>
                                <?php } ?>
                        </div>
                    </li>
                    <?php }?>
                   </ul>
        </div>
	    </div>
    </section>
*/ ?>    
<section id="home_second">

    <section id="content">
      <div class="content">
	      <div class="banner">
        	<ul class="bxslider">
          	<li><img src="<?php echo base_url(); ?>assets/images/slide1.jpg"/></li>
          	</ul> 
          <div class="banner_txt home">
          	<div class="text_block">         	
            <h2 class="text-upper" style="margin:0; font-size:65px">CROWDFUNDING</h2>
            <h5>Made Easy</h5>  
            <br/><br />
            <p>Download Flexcash From Appstore &amp; Playstore</p>
            <br />            
            
            <div class="storelogos">
            	   <img src="<?php echo base_url(); ?>assets/images/ios.png">
                    <img src="<?php echo base_url(); ?>assets/images/play.png">
            </div>
        	</div>
            <img src="<?php echo base_url(); ?>assets/images/mobile.png">
          </div>
        </div>
	    </div>
    </section>

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
                    <a href="<?php echo base_url(); ?>index.php/home/create_flex" ><button class="btn btn-custom orange">Create Your Flex</button></a>
                </div>
              </div>  
            </div>
          </div>
        </div>
      </div>      
    </section>

    <section id="share_section">
      <div class="content">
        <div class="share_block">
          <div class="container">
            <div class="share_box">
              <h2>Share & Invite your friends via Facebook</h2>
              <a href="#"><img src="<?php echo base_url(); ?>assets/images/fb-share.jpg"></a>
              <a href="#"><img src="<?php echo base_url(); ?>assets/images/fb-invite.jpg"></a>
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
                        <div class="session_img">
                            <a href="<?php echo base_url(); ?>index.php/flex/flex_details/<?php echo $flex->FlexID; ?>" ><img src="<?php echo IMG_URL.FLEX_IMG_VIEW_PATH.$flex->FlexImageURL ;?>" class="flex-img" width="363px" height="155px" /></a>
                        </div>
                        <time>Ends on  <?php  echo date('M d',strtotime($flex->EndsOn)); ?></time>
                        <h3><span><?php echo $flex->Joiner;?></span><?php if($flex->FlexCat == 1){echo ' Sold ';}else{echo ' Collected ';}?><span>(<?php if($flex->TotalAmount == NULL){echo '0';}else{ echo $flex->TotalAmount;} ?>)</span></h3>
                        <h2><a href="<?php echo base_url(); ?>index.php/flex/flex_details/<?php echo $flex->FlexID; ?>" ><?php echo $flex->FlexName;?></a></h2>
                       
                    </div>
                    <div class="session-next">
                      <h5 class="first">Created By</h5>
                      <h3><?php echo $flex->username;?></h3>
                      <h4><span><?php if($flex->Joiner == NULL){echo '0';}else{ echo $flex->Joiner;} ?> Joined</span><span class="pull-right"><?php if($flex->Comments == NULL){echo '0';}else{ echo $flex->Comments;} ?> Comments</span> </h4>
                    </div>  
                  </div>
                </div>    
                    <!-- .session -->
               <?php }?>
               </div>
            </div>




            </div>
          </div>
        </div>
      </div>
    </section>


      <section id="testi_section">
      <div class="content">
        <div class="testi_block">
          <div class="container">
            <div class="testi_box">
               <div class="owl-carousel_company owl-theme">
              <div class="item">
                 <div class="testi_content">
                  <div class="testi_img">
                    <img src="<?php echo base_url(); ?>assets/images/testi1.png">
                  </div>
                  <div class="msg_box">
                    <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters</p>
                    <div class="writer_name">
                      <p>-  Connie Deo</p>
                    </div>
                  </div>  
                </div> 
              </div>
              <div class="item">
                 <div class="testi_content">
                  <div class="testi_img">
                    <img src="<?php echo base_url(); ?>assets/images/testi1.png">
                  </div>
                  <div class="msg_box">
                    <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters</p>
                    <div class="writer_name">
                      <p>-  Connie Deo</p>
                    </div>
                  </div>  
                </div> 
              </div>
              
            </div>
            </div>
          </div>
        </div>
      </div>      
   </section>


     <section id="stay_section">
      <div class="content">
        <div class="stay_block">
          <div class="container">
            <div class="stay_box">
              <div class="section-title">
                <h3>available in</h3>
              </div>
              <div class="stay_inner">
                <p>Download Now</p>
                <a href="#"><img src="<?php echo base_url(); ?>assets/images/ios.png"></a>
                <a href="#"><img src="<?php echo base_url(); ?>assets/images/play.png"></a>
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
                        <?php echo form_open(base_url('index.php/home/add_paymentdtl'), $form_attr); ?>
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
                        <div class="col-md-7"><input type="text" class="form-control" name="ex_date" id="ex_date" placeholder="MM / YY" ></div>
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
