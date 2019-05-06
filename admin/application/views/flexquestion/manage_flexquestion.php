<div class="page-content">
    <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
    
    <div class="content">
      <?php $this->load->view("includes/messages");?>
      <div class="page-title"> <i class="icon-custom-left"></i>
        <h3><span class="semi-bold"><?php echo (isset($page_title) ? ucwords($page_title) : "Manage Flex Question"); ?></span></h3>
      </div>
      <div id="container">
    	<div class="row">
        <div class="row-fluid">
        <div class="span12">
          <div class="grid simple horizontal orenge">
            <div class="grid-title">
              <h4><span class="semi-bold"><?php echo (isset($page_title) ? ucwords($page_title) : "Manage Flex Question"); ?></span></h4>
              <?php /*
              <div class="col-md-1 pull-right">  
              <a href="<?php echo base_url('flexmst/add')?>" class="btn btn-block btn-primary" ><span class="bold">ADD</span></a>
              </div*/?>
            </div>
              
            <div class="grid-body">
                <div class="col-md-4">	                           
                    <select id="qtype" class="search" style="width:100%">
                        <option value="0"> Select Question Type</option>
                        <option value="1" >Text</option>
                        <option value="2" >Multiple</option>
                    </select>
                </div>
            </div>  
            <div class="grid-body ">
                 
              <table class="table table-bordered table-advance table-hover" id="flexque" data-control="flexquestion" data-method="manage">
                <thead>
                  <tr>
                    <th>Flex Name</th>
                    <th>Question Type</th>
                    <th>Question </th>
                    <th>is Required</th>
                    <th>QUestion Order</th>
                    <th style="width:10% !important;">Action</th>
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

    <div class="modal fade bs-example-modal-md" id="custom" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" >
        <div class="modal-content" id="timetable_model_main">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4><span class="semi-bold" id="myModalLabel2">Question Details</span></h4>
            </div>
            <div class="grid simple horizontal orenge" id="timetable-slot">
                <div class="grid-body" >
                    <table class="table table-responsive table-bordered" id="model_content_area">
                        
                    </table>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>