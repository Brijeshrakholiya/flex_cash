<footer id="footer">
      <div class="content">
        <div class="footer">
            
          <div class="container">
               
            <div class="footer_box">
               <div class="main-nav footer-nav">
                <nav id="nav">
                  <ul>
                        <li><?php echo anchor('/home/about/', 'ABOUT US'); ?></li>
                        <li><?php echo anchor('/home/terms_conditions/', 'TERMS & CONDITIONS'); ?></li>
                        <li><?php echo anchor('/home/privacy/', 'PRIVACY-POLICY'); ?></li>
                        <li><?php echo anchor('/home/contact/', 'CONTACT US'); ?></li>
                  </ul>
                     <div class="clear"></div>
                </nav> 
                   <div class="clear"></div>
              </div> 
                <div class="f-img">
              <img src="<?php echo base_url(); ?>assets/images/foot-logo.png">
                </div>
              <p>Copyright @ flexcash 2018</p>
              <div class="social-icon">
                <ul>
                  <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                  <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                  <li><a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                  <li><a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a></li>
                </ul>
              </div>
            </div>
          </div>  
        </div>  
      </div>
    </footer>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<!--<script src="<?php echo base_url(); ?>assets/js/jquery-2.1.3.js"></script>-->
<!--<script src="<?php echo base_url(); ?>assets/js/jquery-1.9.1.min.js"></script>-->
<script src="<?php echo base_url(); ?>assets/js/jquery.bxslider.js"></script>
<script src="<?php echo base_url(); ?>assets/js/owl.carousel.js"></script>
<!--<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>-->
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/toastr-master/toastr.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-toggle-master/js/bootstrap-toggle.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/custom/js/custom-for-all.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-responsive-tabs-master/js/jquery.bootstrap-responsive-tabs.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/bootstrap-responsive-tabs-master/js/jquery.bootstrap-responsive-tabs.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>



<script src="<?php echo base_url(); ?>assets/js/custom.js"></script>
<script src="<?php echo base_url(); ?>assets/js/wow.js"></script> 
  <script>
        $(document).ready(function () {
            get_notification();
        });


    wow = new WOW(
      {
        animateClass: 'animated',
        offset:       100,
        callback:     function(box) {
          console.log("WOW: animating <" + box.tagName.toLowerCase() + ">")
        }
      }
    );
    wow.init();
    if (($("moar").length > 0)) {
    document.getElementById('moar').onclick = function() {
      var section = document.createElement('section');
      section.className = 'section--purple wow fadeInDown';
      this.parentNode.insertBefore(section, this);
    };
    }
  </script>
  
  <?php
        if (isset($extra_js) && is_array($extra_js) && count($extra_js) > 0) {
            foreach ($extra_js as $js) {
                if (!empty($js)) {
                    echo '<script type="text/javascript" src="' . base_url() . 'assets/custom/js/' . $js . '.js" ></script>';
                }
            }
        }
        ?>
  
  
<script src="https://fengyuanchen.github.io/js/common.js"></script>
  <script src="<?php echo base_url(); ?>assets/plugins/image_cropper/js/cropper.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/plugins/image_cropper/js/main.js"></script>
  
 <?php /*
<script src="<?php echo base_url(); ?>assets/plugins/imagecrop/jquery.imgareaselect.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/imagecrop/jquery.form.js"></script>

<script type="text/javascript">
	jQuery(document).ready(function(){
	var img = jQuery("#defulat_img").val();
	jQuery('#change-pic').on('click', function(e){
        jQuery('#changePic').modal({show:true});
        jQuery("#change-pic").attr('src', img);
        
    });
	
	jQuery('#photoimg').on('change', function()   
	{ 
		jQuery("#preview-avatar-profile").html('');
		jQuery("#preview-avatar-profile").html('Uploading....');
		jQuery("#cropimage").ajaxForm(
		{
		target: '#preview-avatar-profile',
		success:    function() { 
				jQuery('img#photo').imgAreaSelect({
				aspectRatio: '118:33',
				onSelectEnd: getSizes,
			});
			jQuery('#image_name').val(jQuery('#photo').attr('file-name'));
			}
		}).submit();

	});
	
	jQuery('#btn-crop').on('click', function(e){
    e.preventDefault();
    params = {
            targetUrl: 'flexbanner?action=save',
            action: 'save',
            x_axis: jQuery('#hdn-x1-axis').val(),
            y_axis : jQuery('#hdn-y1-axis').val(),
            x2_axis: jQuery('#hdn-x2-axis').val(),
            y2_axis : jQuery('#hdn-y2-axis').val(),
            thumb_width : jQuery('#hdn-thumb-width').val(),
            thumb_height:jQuery('#hdn-thumb-height').val()
        };

        saveCropImage(params);
    });
    
 
    
    function getSizes(img, obj)
    {
        var x_axis = obj.x1;
        var x2_axis = obj.x2;
        var y_axis = obj.y1;
        var y2_axis = obj.y2;
        var thumb_width = obj.width;
        var thumb_height = obj.height;
        if(thumb_width > 0)
            {

                jQuery('#hdn-x1-axis').val(x_axis);
                jQuery('#hdn-y1-axis').val(y_axis);
                jQuery('#hdn-x2-axis').val(x2_axis);
                jQuery('#hdn-y2-axis').val(y2_axis);
                jQuery('#hdn-thumb-width').val(thumb_width);
                jQuery('#hdn-thumb-height').val(thumb_height);
                
            }
        else
            alert("Please select portion..!");
    }
    
    function saveCropImage(params) {
    jQuery.ajax({
        url: params['targetUrl'],
        cache: false,
        dataType: "html",
        data: {
            action: params['action'],
            id: USERID,
            t: 'ajax',
            w1:params['thumb_width'],
            x1:params['x_axis'],
            h1:params['thumb_height'],
            y1:params['y_axis'],
            x2:params['x2_axis'],
            y2:params['y2_axis'],
            image_name :jQuery('#image_name').val()
        },
        type: 'Post',
       // async:false,
        success: function (response) {
                jQuery('#changePic').modal('hide');
                jQuery("#flex_image").val(response);
                jQuery(".selected , .imgareaselect-border1,.imgareaselect-border2,.imgareaselect-border3,.imgareaselect-border4,.imgareaselect-border2,.imgareaselect-outer").css('display', 'none');
                
                jQuery("#change-pic").attr('src', BASEURL+response);
                jQuery("#preview-avatar-profile").html('');
                jQuery("#photoimg").val();
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert('status Code:' + xhr.status + 'Error Message :' + thrownError);
        }
    });
    }
	});
</script>
  */?>
</body>
</html>