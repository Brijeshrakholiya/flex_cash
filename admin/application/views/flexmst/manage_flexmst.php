<div class="page-content">
    <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
    
    <div class="content">
      <?php $this->load->view("includes/messages");?>
      <div class="page-title"> <i class="icon-custom-left"></i>
        <h3><span class="semi-bold"><?php echo (isset($page_title) ? ucwords($page_title) : "Manage Flex"); ?></span></h3>
      </div>
      <div id="container">
    	<div class="row">
        <div class="row-fluid">
        <div class="span12">
          <div class="grid simple horizontal orenge">
            <div class="grid-title">
              <h4><span class="semi-bold"><?php echo (isset($page_title) ? ucwords($page_title) : "Manage Flex"); ?></span></h4>
              <?php /*
              <div class="col-md-1 pull-right">  
              <a href="<?php echo base_url('flexmst/add')?>" class="btn btn-block btn-primary" ><span class="bold">ADD</span></a>
              </div*/?>
            </div>
              
            <div class="grid-body">
                <div class="col-md-4">	                           
                    <select id="flex_cat" class="search" style="width:100%">
                        <option value="0"> Select Flex Category</option>
                        <option value="1" >Sell</option>
                        <option value="2" >Collection</option>
                    </select>
                </div>
                <div class="col-md-4">	                           
                    <select id="amount_type" class="search" style="width:100%">
                        <option value="0"> Select Amount Type </option>
                        <option value="1">Any</option>
                        <option value="2">Exact</option>
                        <option value="3">Atleast</option>
                    </select>
                </div>
                <div class="col-md-4">	                           
                    <select id="flex_type" class="search" style="width:100%">
                        <option value="0"> Select Flex Type</option>
                        <option value="1">Public</option>
                        <option value="2">Private</option>
                    </select>
                </div>
                <?php /*
                <div class="col-md-3">	                           
                    <select id="status" class="search" style="width:100%">
                        <option value="0"> Flex Status</option>
                        <option value="1">Active</option>
                        <option value="2">Inactive</option>
                    </select>
                </div> */?>
            </div>  
            <div class="grid-body ">
                 
              <table class="table table-bordered table-advance table-hover" id="flex" data-control="flexmst" data-method="manage">
                <thead>
                  <tr>
                    <th style="width:12% !important;">Name</th>
                    <th>Created By</th>
                    <th>Category</th>
                    <th>Amount</th>
                    <th>Ends On</th>
                    <th style="width:15px !important;">Total Joiners</th>
                    <th>Flex Question</th>
                    <th style="width:150px !important;">Action</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>    
      	</div>
    </div>
  </div>
    
