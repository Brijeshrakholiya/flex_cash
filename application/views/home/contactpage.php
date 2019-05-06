<?php $form_attr = array('class' => 'flex_frm', 'id' => 'contact_frm', 'name' => 'contact_frm','style'=>'margin:20px;');?>
<section id="flexform_section">
      <div class="content">
        <div class="flexform_block">
          <div class="container">
            <div class="flexform_box transection_block">
              <?php echo form_open(base_url('home/contact_form'), $form_attr); ?>
                <div class="tra_no support_mail">
                  <h4><i class="fa fa-envelope"></i> <?php echo ' '.$this->config->item('webmaster_email', 'tank_auth'); ?></h4>
                </div>
                </br>
                <div class="form-group">
                  <textarea class="form-control" name="message" placeholder="Write us your query, we will response on your query within 24 hours" id="flex_desc" rows="5"></textarea>
                </div>
                 <div class="row">
                     <div class="pull-left" style="margin-left:18px;">
                         <button type="submit" class="btn btn-custom orange"><i class="fa fa-paper-plane" ></i><strong> &numsp; Send</strong></button>
                    </div>
                 </div>   
              <?php echo form_close(); ?> 
            
            </div>
          </div>
        </div>
      </div>
    </section>