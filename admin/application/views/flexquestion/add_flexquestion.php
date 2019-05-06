<?php

    $flexque_id = array('name' => 'flexque_id', 'id' => 'flexque_id', 'value' => (isset($flexque_info) && $flexque_info->FlexQID > 0) ? $flexque_info->FlexQID : "", 'type' => 'hidden');
   
    $form_attr = array('class' => 'flexque_frm', 'id' => 'add_flexque_frm', 'name' => 'add_flexque_frm');
?>
<div class="page-content">
   
    <div class="clearfix"></div>
    <div class="content">
      <div class="page-title"> <i class="icon-custom-left"></i>
        <h3><span class="semi-bold"><?php echo (isset($page_title) ? ucwords($page_title) : "Add Flex Question"); ?></span></h3>
      </div>
	<!-- BEGIN BASIC FORM ELEMENTS-->
        <div class="row">
            <div class="col-md-12">
              <div class="grid simple horizontal orenge">
                <?php echo form_open_multipart(base_url('flexmst/submit_form'), $form_attr); ?>
                <?php echo form_input($flexque_id); ?>
                <div class="grid-body no-border"> <br>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="flex_name"><b>Flex Name</b></label>
                            <input class="form-control" id="flex_name" placeholder="Enter Flex Name" name="flex_name" value="<?php echo ((isset($flexque_info) && $flexque_info->FlexName != "") ? $flexque_info->FlexName : set_value('flex_name')); ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="flex_image"><b>Flex Image</b></label>
                            <input type="file" class="form-control-file" id="flex_image" name="flex_image" aria-describedby="fileHelp">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">	                           
                      <div class="form-group">
                          <label class=""><b>Flex Category</b></label>
                             <select id="flex_cat" name="flex_cat" style="width:100%">
                                 <option value="0"> --- Select Flex Category ---</option>
                                 <option value="1" <?php if(isset($flexque_info) && $flexque_info->FlexCat == 1){ echo 'selected="selected"'; }?>>Sell</option>
                                <option value="2" <?php if(isset($flexque_info) && $flexque_info->FlexCat == 2){ echo 'selected="selected"'; }?>>Collect</option>
                            </select>
                      </div>
                    </div>
                    <div class="col-md-6">	                           
                      <div class="form-group">
                          <label class=""><b>Flex Type</b></label>
                             <select id="flex_type" name="flex_type" style="width:100%">
                                 <option value="1" <?php if(isset($flexque_info) && $flexque_info->FlexType == 1){ echo 'selected="selected"'; }?>>Public</option>
                                <option value="2" <?php if(isset($flexque_info) && $flexque_info->FlexType == 2){ echo 'selected="selected"'; }?>>Private</option>
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
                                 <option value="1" <?php if(isset($flexque_info) && $flexque_info->AmountType == 1){ echo 'selected="selected"'; }?>>Any</option>
                                <option value="2" <?php if(isset($flexque_info) && $flexque_info->AmountType == 2){ echo 'selected="selected"'; }?>>Exact</option>
                                <option value="3" <?php if(isset($flexque_info) && $flexque_info->AmountType == 3){ echo 'selected="selected"'; }?>>Atleast</option>
                            </select>
                      </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="amount"><b>Amount</b></label>
                            <input class="form-control" id="amount" placeholder="Enter Amount" name="amount" value="<?php echo ((isset($flexque_info) && $flexque_info->Amount != "") ? $flexque_info->Amount : set_value('amount')); ?>">
                        </div>
                    </div>
                </div>    
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="maxqty"><b>Maximum Quantity Available</b></label>
                            <input class="form-control" id="maxqty" placeholder="Maximum Quantity Available" name="maxqty" value="<?php echo ((isset($flexque_info) && $flexque_info->MaxQty != "") ? $flexque_info->MaxQty : set_value('maxqty')); ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="goalqty"><b>Goal Quantity to Sell</b></label>
                            <input class="form-control" id="goalqty" placeholder="Goal Quantity to Sell" name="goalqty" value="<?php echo ((isset($flexque_info) && $flexque_info->GoalQty != "") ? $flexque_info->GoalQty : set_value('goalqty')); ?>">
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                    <br>    
                <div class="row">
                    <div class="col-md-6">
                        <div class="row-fluid">
                            <div class="checkbox check-success 	">
                              <input id="ischarged" name="ischarged" type="checkbox" value="1" <?php if(isset($flexque_info) && $flexque_info->isCharged == 1){ echo 'checked="checked"';}?>>
                              <label for="ischarged"><b>Do not Charge Contributors Until Goal is Reached.</b></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row-fluid">
                            <div class="checkbox check-success 	">
                              <input id="ispublished" name="ispublished" type="checkbox" value="1" <?php if(isset($flexque_info) && $flexque_info->isPublished == 1){ echo 'checked="checked"';}?>>
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
                            <input type="text" class="form-control" id="published_date" placeholder="Enter Published Date" name="published_date" value="<?php echo ((isset($flexque_info) && $flexque_info->PublishedDate != "") ? date('d-m-Y',strtotime($flexque_info->PublishedDate)) : set_value('published_date')); ?>" style="width:94% !important" tabindex="3">
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
                            <input type="text" class="form-control" id="end_on" placeholder="Enter Flex End Date" name="end_on" value="<?php echo ((isset($flexque_info) && $flexque_info->EndsOn != "") ? date('d-m-Y',strtotime($flexque_info->EndsOn)) : set_value('end_on')); ?>" style="width:94% !important" tabindex="3">
                            <span class="add-on"><span class="arrow"></span><i class="fa fa-th"></i></span>

                        </div>
                        </div>
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
