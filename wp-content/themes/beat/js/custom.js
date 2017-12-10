/**
 * http://kopatheme.com
 * Copyright (c) 2015 Kopatheme
 *
 * Licensed under the GPL license:
 *  http://www.gnu.org/licenses/gpl.html
  **/
 
"use strict";

jQuery(document).ready(function() {
    /* =========================================================
    1. Main Menu
    ============================================================ */

    //Top menu
    jQuery('#top-menu').superfish({
        delay: 100,
        speed: 'fast',
        cssArrows: false
    });

    jQuery("#top-menu > li").each(function() {
        if(jQuery(this).has("ul").length > 0) {
            jQuery(this).addClass('has-child');
        }
    });

    //Main menu
    jQuery('#main-menu').superfish({
        delay: 100,
        speed: 'fast',
        cssArrows: true
    });

    /* =========================================================
    2. Mobile Menu
    ============================================================ */
    jQuery('#mobile-menu').navgoco({accordion: true});
    jQuery( "#main-nav i" ).click(function(){
        jQuery( "#mobile-menu" ).slideToggle( "slow" );
    });

    jQuery('.kopa-tabs-2 li a').click(function (e) {
      e.preventDefault()
      jQuery(this).tab('show')
    })

    /* =========================================================
    3. Breadking News
    ============================================================ */
    if(jQuery('.ticker-1').length){
        var _scroll = {
            delay: 1000,
            easing: 'linear',
            items: 1,
            duration: 0.07,
            timeoutDuration: 0,
            pauseOnHover: 'immediate'
        };
        jQuery('.ticker-1').carouFredSel({
            width: 419,
            align: false,
            items: {
                width: 'variable',
                height: 40,
                visible: 1
            },
            scroll: _scroll
        });
    }
    
    /* =========================================================
    5. Accordion
    ========================================================= */
    
    var acc_wrapper=jQuery('.acc-wrapper');
    if (acc_wrapper.length >0) 
    {
        
        jQuery('.acc-wrapper .accordion-container').hide();
        jQuery.each(acc_wrapper, function(index, item){
            jQuery(this).find(jQuery('.accordion-title')).first().addClass('active').next().show();
            
        });
        
        jQuery('.accordion-title').on('click', function(e) {
            kopa_accordion_click(jQuery(this));
            e.preventDefault();
        });
        
        var titles = jQuery('.accordion-title');
        
        jQuery.each(titles,function(){
            kopa_accordion_click(jQuery(this));
        });
    }  

    /* =========================================================
    6. Toggle Boxes
    ============================================================ */
    jQuery('.toggle-view li').click(function (event) {
        var text = jQuery(this).children('.kopa-panel');
        var icon = jQuery(this).children('span');

        if (text.is(':hidden')) {
            jQuery(this).addClass('active');
            text.slideDown('300');
            kopa_toggle_click(icon, 'fa-plus', 'fa-minus');
        } else {
            jQuery(this).removeClass('active');
            text.slideUp('300');
            kopa_toggle_click(icon, 'fa-minus', 'fa-plus');
        }
    });


    /* =========================================================
    7. Back to top
    ============================================================ */

    // hide #back-top first
    jQuery("#back-top").hide();

    // fade in #back-top
    jQuery(window).scroll(function () {
        if (jQuery(this).scrollTop() > 200) {
            jQuery('#back-top').fadeIn();
        } else {
            jQuery('#back-top').fadeOut();
        }
    });

    // scroll body to 0px on click
    jQuery('#back-top a').click(function () {
        jQuery('body,html').animate({
            scrollTop: 0
        }, 800);
        return false;
    });


    /* =========================================================
    12. Owl Carousel
    ============================================================ */
    if (jQuery('.kopa-blog-carousel').length > 0) {
        jQuery('.kopa-blog-carousel').owlCarousel({
            singleItem : true,
            lazyLoad : true,
            navigation : true,
            pagination: false,
            navigationText : false
        });
    };

    if (jQuery('.kopa-blog-classic-carousel').length > 0) {
        jQuery('.kopa-blog-classic-carousel').owlCarousel({
            singleItem : true,
            lazyLoad : true,
            navigation : true,
            pagination: false,
            navigationText : false
        });
    };    

    if (jQuery('.kopa-single-carousel').length > 0) {
        jQuery('.kopa-single-carousel').owlCarousel({
            singleItem : true,
            lazyLoad : true,
            navigation : true,
            pagination: false,
            navigationText : false
        });
    };    

    if (jQuery('.kopa-event-carousel').length > 0) {
        jQuery('.kopa-event-carousel').owlCarousel({
            singleItem : true,
            lazyLoad : true,
            navigation : true,
            pagination: false,
            navigationText: ["Previous Events","Next Events"]
        });
    };

    if (jQuery('.owl-carousel-1').length > 0) {
        var owl1 = jQuery(".owl-carousel-1");
        owl1.owlCarousel({
            items: 4,
            itemsTablet : [799,3],
            itemsMobile : [639,2],
            pagination: true,
            slideSpeed: 600,
            navigationText: false,
            navigation: true
        });
    };

    if (jQuery('.owl-carousel-2').length > 0) {
        var owl2 = jQuery(".owl-carousel-2");
        owl2.owlCarousel({
            items: 3,
            pagination: true,
            slideSpeed: 600,
            navigationText: false,
            navigation: false
        });
    };  

    if (jQuery('.owl-carousel-3').length > 0) {
        var owl3 = jQuery(".owl-carousel-3");
        owl3.owlCarousel({
            singleItem: true,
            pagination: true,
            slideSpeed: 600,
            navigationText: false,
            navigation: false
        });
    };

    if (jQuery('.owl-carousel-4').length > 0) {
        var owl4 = jQuery(".owl-carousel-4");
        owl4.owlCarousel({
            singleItem: true,
            pagination: true,
            slideSpeed: 600,
            navigationText: false,
            navigation: true,
            afterInit: function(){
                jQuery(".home-slider-box-2 .loading").hide();    
            }
        });
    };   


    if (jQuery('.kopa-sync-carousel-widget').length > 0) {
        var sync1 = jQuery(".kopa-sync-carousel-widget .sync1");
        var sync2 = jQuery(".kopa-sync-carousel-widget .sync2");


        sync1.owlCarousel({
            singleItem: true,
            slideSpeed: 1000,
            navigation: false,
            navigationText: false,
            pagination: false,
            afterAction: syncPosition,
            responsiveRefreshRate: 200
        });

        sync2.owlCarousel({
            items: 6,
            itemsTablet : [799,3],
            pagination: false,
            navigation: true,
            navigationText: false,
            responsiveRefreshRate: 100
        });



        jQuery(".sync2").on("click", ".owl-item", function(e) {
            e.preventDefault();
            var number = jQuery(this).data("owlItem");
            sync1.trigger("owl.goTo", number);
        });
    };

    var $masonry1 = jQuery('.kopa-masonry-list-1-widget .masonry-list-wrapper > ul');
    imagesLoaded($masonry1, function () {
        $masonry1.masonry({
            columnWidth: 1,
            itemSelector: '.masonry-item'
        });
        $masonry1.masonry('bindResize')
    });    

    if (jQuery('.kopa-masonry-widget').length > 0) {
        var jQuerymasonry1 = jQuery('.kopa-masonry-widget').find('.kopa-masonry-wrap');
        imagesLoaded(jQuerymasonry1, function () {
            jQuerymasonry1.masonry({
                columnWidth: 1,
                itemSelector: '.ms-item1'
            });
            jQuerymasonry1.masonry('bindResize')
        });
    };

    if (jQuery('.article-list-2').length > 0) {
        var post_1 = jQuery('.article-list-2').children("ul");
        
        post_1.each(function() {
            jQuery(this).children('li').matchHeight();
        });    
    };

    /* =========================================================
    18. Video wrapper
    ============================================================ */
    if (jQuery(".video-wrapper").length > 0) {
        jQuery(".video-wrapper").fitVids();
    };


    //LOAD MORE BUTTON
    jQuery('#beat_mix_lite_loadmore').on('click', '.beat_mix_lite_loadmore_button', function(event){
        event.preventDefault();

        var button = jQuery("#beat_mix_lite_loadmore");                        
        var href   = button.data('url');
        var paged  = button.data('paged');

        if( !button.hasClass('in-process') ){
            jQuery.ajax({
                type: 'POST',
                url: href + paged,
                dataType: 'html',
                data: {},
                beforeSend: function() {
                    button.addClass('in-process');                          
                },
                success: function(data) {                               
                    var newItems = jQuery(data).find('#beat_mix_lite_loadmore_placeholder > li');                                                   
                    if(newItems.length > 0){
                        imagesLoaded(newItems, function () {
                            var container = jQuery('#beat_mix_lite_loadmore_placeholder');
                            container.append(newItems).masonry('appended', newItems);
                        });    
                        button.data('paged', parseInt(paged) + 1);
                    }                                 
                },
                complete: function() {   
                    button.removeClass('in-process');             
                },
                error: function() {
                    
                }
            }).fail(function() { 
                button.remove();
            });
        }

        return false;
    });


});

function kopa_accordion_click (obj) {
    if( obj.next().is(':hidden') ) {
        obj.parent().find(jQuery('.active')).removeClass('active').next().slideUp(300);
        obj.toggleClass('active').next().slideDown(300);
                            
    }
    jQuery('.accordion-title span').removeClass('fa-minus').addClass('fa-plus');
    if (obj.hasClass('active')) {
        obj.find('span').removeClass('fa-plus');
        obj.find('span').addClass('fa-minus');              
    } 
}

function kopa_toggle_click(obj, remove_class, new_class) {
    obj.removeClass(remove_class);
    obj.addClass(new_class);
}

function s_width () {

    var imgs = jQuery('.kopa-home-slider-carousel .carousel-item > img');
    var c_width;
    var i_height;

    jQuery.each( imgs, function( index, value){
        c_width = parseInt(jQuery(this).parent().parent().parent().parent().width());
        
        jQuery(this).width(c_width);

        i_height = jQuery(this).height();

        jQuery(this).parent().height(i_height);
        jQuery(this).parent().parent().height(i_height);
        jQuery(this).parent().parent().parent().height(i_height);
        jQuery(this).parent().parent().parent().width(c_width);
    });
} 

function syncPosition(el) {
    var current = this.currentItem;
    jQuery(".sync2").find(".owl-item").removeClass("synced").eq(current).addClass("synced")
    if (jQuery(".sync2").data("owlCarousel") !== undefined) {
        center(current)
    }
}

function center(number){
    
    var sync2visible = sync2.data("owlCarousel").owl.visibleItems;
    var num = number;
    var found = false;
    for(var i in sync2visible){
      if(num === sync2visible[i]){
        var found = true;
      }
    }
 
    if(found===false){
        if (undefined != sync2visible){
            if(num > sync2visible[sync2visible.length-1]){
                sync2.trigger("owl.goTo", num - sync2visible.length+2)
            }else{
                if(num - 1 === -1){
                    num = 0;
                }
                sync2.trigger("owl.goTo", num);
            } 
        }
    } else if(num === sync2visible[sync2visible.length-1]){
        sync2.trigger("owl.goTo", sync2visible[1])
    } else if(num === sync2visible[0]){
        sync2.trigger("owl.goTo", num-1)
    }
}

