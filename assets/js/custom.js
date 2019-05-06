 $(document).ready(function () {     
	       
		 $(".main-nav a.menu-icon").click(function(e) {
                    e.preventDefault();
                    $(".main-nav ul").slideToggle(300);
                   
         });
		  
		if($('.bxslider').length > 0) 
		{
                     $('.bxslider').bxSlider({
                        auto: true,
                        pager: false,
                        autoControls: false,
                        speed:1500,
                        autoHover:true
                   });   
                }
		 
		//$( "#tabs" ).tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
		//$( "#tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );
		 
		
		$(".owl-carousel_company").owlCarousel({
		         items : 1,
				 lazyLoad : true,
   				 itemsCustom : false,
				itemsDesktop : [1199,1],
				itemsDesktopSmall : [992,1],
				itemsTablet: [768,1],
				itemsTabletSmall: false,
				itemsMobile : [479,1],
				itemsScaleUp : false,
				navigation : true,
       			navigationText : ["<i class='fa fa-caret-left'></i>", "<i class='fa fa-caret-right'></i>"]
       	   });


		$('a.moveto').click(function(){
			$('html, body').animate({
				scrollTop: $('[id="' + $.attr(this, 'href').substr(1) + '"]').offset().top
			}, 900);
			return false;
		}); 


		
        });