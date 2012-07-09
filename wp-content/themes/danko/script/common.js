jQuery(document).ready(function(){

    // Menu

    jQuery("ul.menu").superfish();


    //Hovers for big buttons

    $(".border-header-text a").mouseover(function(){
      $(".border-header-text").attr('style','background-position:bottom;');
    }).mouseout(function(){
      $(".border-header-text").attr('style','background-position:top;');
    });

    $(".red-tape a").mouseover(function(){
      $(".red-tape").attr('style','background-position:bottom;');
    }).mouseout(function(){
      $(".red-tape").attr('style','background-position:top;');
    });

    $(".gray-tape a").mouseover(function(){
      $(".gray-tape").attr('style','background-position:bottom;');
    }).mouseout(function(){
      $(".gray-tape").attr('style','background-position:top;');
    });

    $(".footer-red-tape a").mouseover(function(){
      $(".footer-red-tape").attr('style','background-position:bottom center;');
    }).mouseout(function(){
      $(".footer-red-tape").attr('style','background-position:top center;');
    });

    jQuery('.nav-center .sub-menu').attr('style', 'display:block!important;visibility:visible!important');

    $('.nivo-directionNav a').html('');

    $().piroBox({
        my_speed: 300, //animation speed
        bg_alpha: 0.5, //background opacity
        slideShow : 'true', // true == slideshow on, false == slideshow off
        slideSpeed : 3, //slideshow
        close_all : '.piro_close' // add class .piro_overlay(with comma)if you want overlay click close piroBox
    });

    // Clear Widget Titles

    jQuery('.footer_widgettitle').each(function(){
        jQuery(this).remove();
    });



    
  
 
    // Sidebar fix

    jQuery('.sidebar_widget_holder').each(function(){

        var checker = jQuery('.sidebar_widgettitle', this).html();
        if (checker !== null){}else{

            var menjac = jQuery(this).html();
            jQuery(this).empty().append('<div class="widget-top"></div>' + menjac);
        }
    });

    

    //WP Recent fix

   

    $('.footer_box-down .app_recent_post:last').attr('style','padding:0px!important');

    $('.footer_box-down .app_recent_comm:last').attr('style','border-bottom:none !important; padding:0;');

    $('.sidebar_widget_holder .app_recent_post:last').attr('style','margin:0px!important');
    
    $('.sidebar_widget_holder .app_recent_comm:last').attr('style','border-bottom:none !important; padding:0;');
    
    



    jQuery('#menu-left').addClass("sf-menu");
    jQuery('#menu-right').addClass("sf-menu");

    jQuery(".menu ul li:first-child").before('<li class="sub-menu-top"></li>');
    jQuery(".menu ul li:last-child").after('<li class="sub-menu-bottom"></li>');
    
    //Pirobox
        
    jQuery('.pirobox').each(function(){
        jQuery('img',this).animate({
            opacity:1
        },0);
    });
	
    jQuery('img','.pirobox').hover(function(){
        jQuery(this).stop().animate({
            opacity:0.4
        },500);
    },function(){
        jQuery(this).stop().animate({
            opacity:1
        },300);
    });
	
    //Tag Cloud
    jQuery('.tagcloud a').each(function(){
        var acont = jQuery(this).html();
        jQuery(this).html('<div class="widgets-tags-button"><div class="tag-left left"></div><div class="tag-center left">'+acont+'</div><div class="tag-right left"></div></div>');
    });
	
		
    //Search style


    jQuery(".top-content-title #searchsubmit").remove();
    jQuery(".top-content-title .screen-reader-text").remove();

    jQuery(".top-search div .screen-reader-text").remove();

    var searchfix2 = $('.sidebar_widget_holder #searchform').html();
    $('.sidebar_widget_holder #searchform').html('').append('<div class="sidebar_widget-top left"></div><div class="search-center">'+searchfix2+'<div class="sidebar_widget-down left"></div>');
    jQuery(".search-center div .screen-reader-text").remove();

    var searchfix3 = $('.footer-search_box #searchform').html();
    $('.footer-search_box #searchform').html('').append('<div class="search-left"></div>'+searchfix3+'<div class="sidebar_widget-down left"></div>');
    jQuery(".footer-search_box div .screen-reader-text").remove();
    jQuery(".footer-search_box div #searchsubmit").val('');

    var searchfix4 = $('.footer_box-down #searchform').html();
    $('.footer_box-down #searchform').html('').append('<div class="sidebar_widget-top left"></div><div class="search-center">'+searchfix4+'<div class="sidebar_widget-down left"></div>');
    jQuery(".search-center div .screen-reader-text").remove();



//Recent post
    jQuery('.footer .app_recent_post').each(function() {
	var text = jQuery('.app_recent_title_a', this).html();
       
	if(text.length > 27) {
		text = text.substring(0, 27);
                text = text+'...';
	jQuery('.app_recent_title_a' , this).html(text);

    }
});

        
    //Prevent empty search form submit
    jQuery('#searchsubmit').click(function(e){
        e.preventDefault();
        var value = jQuery('#s').val();
        if(value !== ""){
            jQuery('#searchform').submit();
        }
    });


    jQuery('.images img').hover(function(){
        jQuery('img',this).stop().animate({
            opacity:0.4
        },500);
    },function(){
        jQuery('img',this).stop().animate({
            opacity:1
        },300);
    });


   // HOVER-IMAGES
        jQuery('.post-image-hover').hover(function(){
            jQuery(this).stop().animate({opacity:0.8},500);
        },function(){
           jQuery(this).stop().animate({opacity:0},300);
        });
        jQuery('.image-hover').css('opacity','0');



         jQuery('.post-image-hover').hover(function(){
            jQuery(this).stop().animate({opacity:0.8},500);
        },function(){
           jQuery(this).stop().animate({opacity:0},300);
        });
        jQuery('.image-hover').css('opacity','0');




        jQuery('.post-image-hover-two').hover(function(){
            jQuery(this).stop().animate({opacity:0.8},500);
        },function(){
           jQuery(this).stop().animate({opacity:0},300);
        });
        jQuery('.image-hover').css('opacity','0');



         jQuery('.post-images-hover').hover(function(){
            jQuery(this).stop().animate({opacity:0.8},500);
        },function(){
           jQuery(this).stop().animate({opacity:0},300);
        });
        jQuery('.image-hover').css('opacity','0');



        jQuery('.app_recent_img a').hover(function(){
           jQuery('img',this).stop().animate({opacity:0.4},500);
        },function(){
           jQuery('img',this).stop().animate({opacity:1},300);
        });

        jQuery('.recent-actions-img a').hover(function(){
           jQuery('img',this).stop().animate({opacity:0.4},500);
        },function(){
           jQuery('img',this).stop().animate({opacity:1},300);
        });


    jQuery("input[name='s']").focus(function(){
        if (jQuery(this).val() === "To search type and hit enter") {
            jQuery(this).val("");
        }
    }).blur(function(){
        if (jQuery(this).val() === "") {
            jQuery(this).val("To search type and hit enter");
        }
    }).val("To search type and hit enter");
                    

jQuery(".one h2:eq(0)").css({'color':'#fff','margin':'0 0 32px 0'});
jQuery(".two h2:eq(0)").css({'color':'#fff','margin':'0 0 32px 0'});
jQuery(".three h2:eq(0)").css({'color':'#fff','margin':'0 0 32px 0'});
jQuery(".last-footer h2:eq(0)").css({'color':'#fff','margin':'0 0 32px 0'});

jQuery(".one .app_recent_post:eq(0)").css({'margin':'0'});
jQuery(".two .app_recent_post:eq(0)").css({'margin':'0'});
jQuery(".three .app_recent_post:eq(0)").css({'margin':'0'});
jQuery(".last-footer .app_recent_post:eq(0)").css({'margin':'0'});

jQuery(".one .footer_box-down:eq(0)").css('margin','0px');
jQuery(".two .footer_box-down:eq(0)").css('margin','0px');
jQuery(".three .footer_box-down:eq(0)").css('margin','0px');
jQuery(".last-footer .footer_box-down:eq(0)").css('margin','0px');

$(".rsswidget").parent("li").css("background-position", "0 4px");

$('.recentcomments a').attr('style', 'line-height:20px!important;width:200px; margin: 0 0 10px 5px !important; background:none;');
$('.recentcomments .url').attr('style', 'margin: 0 !important;');


        $('.circle').mosaic({
            opacity		:	0.8			//Opacity for overlay (0-1)
        });

        $('.fade').mosaic();

        $('.bar').mosaic({
            animation	:	'slide'		//fade or slide
        });

        $('.bar2').mosaic({
            animation	:	'slide'		//fade or slide
        });

        $('.bar3').mosaic({
            animation	:	'slide',	//fade or slide
            anchor_y	:	'top'		//Vertical anchor position
        });

        $('.cover').mosaic({
            animation	:	'slide',	//fade or slide
            hover_x		:	'400px'		//Horizontal position on hover
        });

        $('.cover2').mosaic({
            animation	:	'slide',	//fade or slide
            anchor_y	:	'top',		//Vertical anchor position
            hover_y		:	'80px'		//Vertical position on hover
        });

        $('.cover3').mosaic({
            animation	:	'slide',	//fade or slide
            hover_x		:	'0px',	//Horizontal position on hover
            hover_y		:	'300px'		//Vertical position on hover
        });

    //Prevent empty search form submit
    jQuery('#searchsubmit').click(function(e){
        e.preventDefault();
        var value = jQuery('#s').val();
        if(value !== ""){
            jQuery('#searchform').submit();
        }
    });


    jQuery("div.comment-start:odd").css("background-color", "#DCEFF3");
    

jQuery(".social-middle .subscribe-follow-icons:last").css({border: 'none'});

});
