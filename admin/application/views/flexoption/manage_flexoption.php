<div class="page-content">
    <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
    
    <div class="content">
      <?php $this->load->view("includes/messages");?>
      <div class="page-title"> <i class="icon-custom-left"></i>
        <h3><span class="semi-bold"><?php echo (isset($page_title) ? ucwords($page_title) : "Manage Flex Option"); ?></span></h3>
      </div>
      <div id="container">
    	<div class="row">
        <div class="row-fluid">
        <div class="span12">
          <div class="grid simple horizontal orenge">
            <div class="grid-title">
              <h4><span class="semi-bold"><?php echo (isset($page_title) ? ucwords($page_title) : "Manage Flex Option"); ?></span></h4>
              <?php /*
              <div class="col-md-1 pull-right">  
              <a href="<?php echo base_url('flexmst/add')?>" class="btn btn-block btn-primary" ><span class="bold">ADD</span></a>
              </div*/?>
            </div>
              
            <div class="grid-body ">
                 
              <table class="table table-bordered table-advance table-hover" id="flexopt" data-control="flexoption" data-method="manage">
                <thead>
                  <tr>
                    <th>Question</th>
                    <th>Option </th>
                    <th>Option Order</th>
                    <th style="width:8% !important;">Action</th>
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
