<?php

    $flex_id = array('name' => 'flex_id', 'id' => 'flex_id', 'value' => (isset($flex_info) && $flex_info->FlexID > 0) ? $flex_info->FlexID : "", 'type' => 'hidden');
   
    $form_attr = array('class' => 'flex_frm', 'id' => 'add_flex_frm', 'name' => 'add_flex_frm');
?>
<div class="page-content">
   
    <div class="clearfix"></div>
    <div class="content">
      <div class="page-title"> <i class="icon-custom-left"></i>
        <h3><span class="semi-bold"><?php echo (isset($page_title) ? ucwords($page_title) : "Add Flex"); ?></span></h3>
      </div>
	<!-- BEGIN BASIC FORM ELEMENTS-->
        <div class="row">
            <div class="col-md-12">
              <div class="grid simple horizontal orenge">
                <?php echo form_open_multipart(base_url('flexmst/submit_form'), $form_attr); ?>
                <?php echo form_input($flex_id); ?>
                <div class="grid-body no-border"> <br>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="flex_name"><b>Flex Name</b></label>
                            <input class="form-control" id="flex_name" placeholder="Enter Flex Name" name="flex_name" value="<?php echo ((isset($flex_info) && $flex_info->FlexName != "") ? $flex_info->FlexName : set_value('flex_name')); ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="flex_image"><b>Flex Image</b></label>
                                <input type="file" class="form-control-file" id="flex_image" name="flex_image" aria-describedby="fileHelp" style="border: medium none; box-shadow: none; padding: 0px !important;">
                            </div>
                        </div>
                        <div class="col-md-6">
                        <?php
                        if (isset($flex_info) && $flex_info->FlexImageURL != ""){ ?>
                            <div class="form-group">
                                <label for="flex_image"><b>Current Image : </b>
                                <img src="<?php echo IMG_URL.FLEX_IMG_VIEW_PATH.$flex_info->FlexImageURL ;?>" class="img-thumbnail" width="60" height="50" /></label>
                            </div>
                        <?php } ?>
                        </div>
                    </div>    
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-12">
                        <label for="flex_desc"><b>Flex Description</b></label>
                            <textarea name="flex_desc" id="flex_desc" rows="5">
                                <?php echo ((isset($flex_info) && $flex_info->FlexDesc != "") ? $flex_info->FlexDesc : set_value('flex_desc')); ?>
                            </textarea>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>    
                    
                <div class="row">
                    <div class="col-md-6">	                           
                      <div class="form-group">
                          <label class=""><b>Flex Category</b></label>
                             <select id="flex_cat" name="flex_cat" style="width:100%">
                                 <option value="0"> --- Select Flex Category ---</option>
                                 <option value="1" <?php if(isset($flex_info) && $flex_info->FlexCat == 1){ echo 'selected="selected"'; }?>>Sell</option>
                                <option value="2" <?php if(isset($flex_info) && $flex_info->FlexCat == 2){ echo 'selected="selected"'; }?>>Collect</option>
                            </select>
                      </div>
                    </div>
                    <div class="col-md-6">	                           
                      <div class="form-group">
                          <label class=""><b>Flex Type</b></label>
                             <select id="flex_type" name="flex_type" style="width:100%">
                                 <option value="1" <?php if(isset($flex_info) && $flex_info->FlexType == 1){ echo 'selected="selected"'; }?>>Public</option>
                                <option value="2" <?php if(isset($flex_info) && $flex_info->FlexType == 2){ echo 'selected="selected"'; }?>>Private</option>
                            </select>
                      </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">	                           
                      <div class="form-group">
                          <label class=""><b>Amount Type</b></label>
                             <select id="amount_type" name="amount_type" style="width:100%">
                                 <option value="0"> --- Select Amount Type ---</option>
                                 <option value="1" <?php if(isset($flex_info) && $flex_info->AmountType == 1){ echo 'selected="selected"'; }?>>Any</option>
                                <option value="2" <?php if(isset($flex_info) && $flex_info->AmountType == 2){ echo 'selected="selected"'; }?>>Exact</option>
                                <option value="3" <?php if(isset($flex_info) && $flex_info->AmountType == 3){ echo 'selected="selected"'; }?>>Atleast</option>
                            </select>
                      </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="amount"><b>Amount</b></label>
                            <input class="form-control" id="amount" placeholder="Enter Amount" name="amount" value="<?php echo ((isset($flex_info) && $flex_info->Amount != "") ? $flex_info->Amount : set_value('amount')); ?>">
                        </div>
                    </div>
                </div>    
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="maxqty"><b>Maximum Quantity Available</b></label>
                            <input class="form-control" id="maxqty" placeholder="Maximum Quantity Available" name="maxqty" value="<?php echo ((isset($flex_info) && $flex_info->MaxQty != "") ? $flex_info->MaxQty : set_value('maxqty')); ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="goalqty"><b>Goal Quantity to Sell</b></label>
                            <input class="form-control" id="goalqty" placeholder="Goal Quantity to Sell" name="goalqty" value="<?php echo ((isset($flex_info) && $flex_info->GoalQty != "") ? $flex_info->GoalQty : set_value('goalqty')); ?>">
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                    <br>    
                <div class="row">
                    <div class="col-md-6">
                        <div class="row-fluid">
                            <div class="checkbox check-success 	">
                              <input id="ischarged" name="ischarged" type="checkbox" value="1" <?php if(isset($flex_info) && $flex_info->isCharged == 1){ echo 'checked="checked"';}?>>
                              <label for="ischarged"><b>Do not Charge Contributors Until Goal is Reached.</b></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row-fluid">
                            <div class="checkbox check-success 	">
                              <input id="ispublished" name="ispublished" type="checkbox" value="1" <?php if(isset($flex_info) && $flex_info->isPublished == 1){ echo 'checked="checked"';}?>>
                              <label for="ispublished"><b>Is Published</b></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                    <br>    
                <div class="row">
                    <div class="col-md-6">	                           
                      <div class="form-group">
                            <div class="row">
                                <label class="col-md-12"><b>Published Date</b></label>
                        <div class="input-append success date right col-md-12">
                            <input type="text" class="form-control" id="published_date" placeholder="Enter Published Date" name="published_date" value="<?php echo ((isset($flex_info) && $flex_info->PublishedDate != "") ? date('d M Y',strtotime($flex_info->PublishedDate)) : set_value('published_date')); ?>" style="width:94% !important" tabindex="3">
                            <span class="add-on"><span class="arrow"></span><i class="fa fa-th"></i></span>

                        </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">	                           
                      <div class="form-group">
                            <div class="row">
                                <label class="col-md-12"><b>Flex End Date</b></label>
                        <div class="input-append success date right col-md-12">
                            <input type="text" class="form-control" id="end_on" placeholder="Enter Flex End Date" name="end_on" value="<?php echo ((isset($flex_info) && $flex_info->EndsOn != "") ? date('d M Y',strtotime($flex_info->EndsOn)) : set_value('end_on')); ?>" style="width:94% !important" tabindex="3">
                            <span class="add-on"><span class="arrow"></span><i class="fa fa-th"></i></span>

                        </div>
                        </div>
                      </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">	                           
                      <div class="form-group">
                          <label class=""><b>Flex Status</b></label>
                             <select id="status" name="status" style="width:100%">
                                 <option value="1" <?php if(isset($flex_info) && $flex_info->Status == 1){ echo 'selected="selected"'; }?>>Active</option>
                                <option value="2" <?php if(isset($flex_info) && $flex_info->Status == 2){ echo 'selected="selected"'; }?>>Deactive</option>
                            </select>
                      </div>
                    </div>
                </div>    
                <div class="form-actions">  
                    <div class="pull-left">
                        <input type="submit" class="btn btn-info" value="Submit" />
                        <a class="btn btn-default cancel_button" href="<?php echo base_url('flexmst/'); ?>">Cancel</a>
                    </div>
                </div>
                </div>
                
                <?php echo form_close(); ?>
              </div>
            </div>
          </div>
	<!-- END BASIC FORM ELEMENTS-->	   
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/ckeditor/ckeditor.js" type="text/javascript"></script>
<script>
    CKEDITOR.replace( 'flex_desc' );
</script>