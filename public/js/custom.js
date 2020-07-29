(function($) {
  "use strict";
//Start Menu JS Function Taksi Theme
	// Superfish Menu Hover Effect
/* 	jQuery(function(){
		jQuery('ul.sf-menu').superfish({
			hoverClass:    'sfHover',         
		    pathClass:     'overideThisToUse',
		    pathLevels:    1,    
		    delay:         200, 
		    animation:     {opacity:'show', height:'show'}, 
		    speed:         'normal',   
		    autoArrows:    false, 
		    dropShadows:   true, 
		    disableHI:     false, 
		    easing:        "easeOutQuad",
		    onInit:        function(){},
		    onBeforeShow:  function(){},
		    onShow:        function(){},
		    onHide:        function(){}
		});
	});

    // Mean Menu
	jQuery(document).ready(function () {
		jQuery('.navigation nav').meanmenu();
	}); */
//End Menu JS Function Taksi Theme
 

//End Menu JS Function Taksi Theme
	$(window).on('load', function () {

		$('.selectpicker').selectpicker({
			'selectedText': 'cat'
		});

		// $('.selectpicker').selectpicker('hide');
	});
//End Menu JS Function Taksi Theme

		

/* ==============================================
Preloader
=============================================== */

jQuery(window).load(function(){
    jQuery("#preloader").delay(500).fadeOut(1000);
		jQuery(".preload-gif").addClass('fadeOutUp');
    
});

})(jQuery);
/* ===================== */
/* ==============================================
Parallax
=============================================== */
	
	try {
		$(window).stellar({ 
		horizontalScrolling: false,

		});
	} catch(err) {

		}	

/* ==============================================*/





/* ==============================================
Animated Custom
=============================================== */
	try {		
		if ($(".animated")[0]) {
            $('.animated').css('opacity', '1');
			}
			$('.triggerAnimation').waypoint(function() {
            var animation = $(this).attr('data-animate');
            $(this).css('opacity', '');
            $(this).addClass("animated " + animation);

			},
                {
                    offset: '80%',
                    triggerOnce: true
                }
			);
	} catch(err) {

		}
		
		
/* ==============================================
text-rotator
=============================================== */












