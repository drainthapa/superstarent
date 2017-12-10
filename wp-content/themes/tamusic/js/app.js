(function($) {
	jQuery.fn.doesExist = function(){
		return jQuery(this).length > 0;
	};

	$(document).ready(function() {

		// Search field toggle in top bar
		$('#top-links li.search a').click(function(e) {
			$(this).parent().find('#top-search').toggle().focus();
			$('#top-links').toggleClass('search-open');
			e.preventDefault();
		});

		function setFooterSeparators() {
			$('.footer-col').each(function() {
				$(this).height("auto");
			});

			if (parseInt($(window).width()) < 768) 
				return;

			var max = 0;
			$('.footer-col').each(function() {
				if (parseInt($(this).height()) > max)
					max = parseInt($(this).height());
			});

			$('.footer-col').each(function() {
				$(this).height(max + "px");
			});
		}

		setFooterSeparators();

		$(window).resize(function() {
			setFooterSeparators();
		});

		// go to top link
		$("a[href='#top']").click(function() {
			$("html, body").animate({ scrollTop: 0 }, "slow");
			return false;
		});

		/*
		 * event view styles
		 */
		$(".view a[href='#grid']").click(function() {
			$('#upcoming-events').removeClass('list-style');
			$('#upcoming-events').addClass('grid-style');

			$(this).parent().find('a').removeClass('current');
			$(this).addClass('current');
			return false;
		});

		$(".view a[href='#list']").click(function() {
			$('#upcoming-events').addClass('list-style');
			$('#upcoming-events').removeClass('grid-style');

			$(this).parent().find('a').removeClass('current');
			$(this).addClass('current');
			return false;
		});

		/*
		 * audio players
		 */
		if (typeof audiojs != 'undefined') {
			audiojs.events.ready(function() {
				var as = audiojs.createAll();
				var playing;
				$('.audiojs').on('click', function () {
					var id = $(this).attr('id').substr(15);
					if (id == playing)
						return;
					for (var i = 0; i < as.length; i++) {
						as[i].pause();
					}
					as[id].play();
					playing = id;
				});
			});
		}

		/*
		 * Contact form
		 */
		$("#contact-form").submit(function() {
		 	var form = $(this);
			$.ajax({
				type : "POST",
				url : cf.url,
				dataType : "html",
				data : $(this).serialize(),
				beforeSend : function() {
					form.find('.loading').remove();
					form.find('.dynamic').append('<div class="loading"><i class="fa fa-3x fa-spinner fa-spin"></i></div>')
				},
				success : function(response) {
					form.find(".loading").remove();
					form.find('.dynamic').append('<div class="result">' + response + '</div>')
				},
				error : function(response) {
					form.find(".loading").remove();
					form.find('.dynamic').append('<div class="result">' + response + '</div>')
				}
			});

			return false;
		});

		$('.panel-title > a, .panel-title > a:after').on('click', function(){
			$('.panel-title > a').removeClass('open');
			if (!$(this).parent().parent().parent().find('.panel-collapse').hasClass('in'))
				$(this).addClass('open');
		});

		$('.toggle').find('.panel-collapse.in').parent().find('.panel-heading').hide();
		$('.toggle .panel-title > a, .panel-title > a:after').on('click', function(){
			$($(this).attr('data-parent')).find('.panel-collapse.in').parent().find('.panel-heading').show();
			$(this).parent().parent().hide();
		});

	});

	$(window).load(function() {
		// homepage banner
		if ($('#banner .flexslider').doesExist()) {
			$('#banner .flexslider').flexslider({
				directionNav: false,
			});
		}

		// event image gallery
		if ($('.flexslider.event-gallery').doesExist()) {
			$('.flexslider.event-gallery').flexslider({
				controlNav: false,
				prevText: '<i class="fa fa-chevron-left"></i>',
				nextText: '<i class="fa fa-chevron-right"></i>',
			});
		}

    	// blog post galleries
    	if ($('.flexslider.post-gallery').doesExist()) {
    		$('.flexslider.post-gallery').flexslider({
    			directionNav: false,
    		});
    	}

    	/*
    	 * artists isotope filtering
    	 */

		// cache container
		var $artists = $('.artists');
		// initialize isotope
		if ($artists.doesExist()) 		
			$artists.isotope();

		// filter items when filter link is clicked
		$('.isotope-filters.artist-filter a').click(function() {
			var selector = $(this).attr('data-filter');
			$artists.isotope({ filter: selector });

			$('.isotope-filters.artist-filter').find('li').removeClass('current');
			$(this).parent().addClass('current');

			return false;
		});

		/*
    	 * albums isotope filtering
    	 */

		// cache container
		var $albums = $('.albums');
		// initialize isotope
		if ($albums.doesExist()) 		
			$albums.isotope();

		// filter items when filter link is clicked
		$('.isotope-filters.album-filter a').click(function() {
			var selector = $(this).attr('data-filter');
			$albums.isotope({ filter: selector });

			$('.isotope-filters.album-filter').find('li').removeClass('current');
			$(this).parent().addClass('current');

			return false;
		});

		/*
    	 * galleries isotope filtering
    	 */

		// cache container
		var $galleries = $('.galleries');
		// initialize isotope
		if ($galleries.doesExist()) 		
			$galleries.isotope();

		// filter items when filter link is clicked
		$('.isotope-filters.gallery-filter a').click(function() {
			var selector = $(this).attr('data-filter');
			$galleries.isotope({ filter: selector });

			$('.isotope-filters.gallery-filter').find('li').removeClass('current');
			$(this).parent().addClass('current');

			return false;
		});

		/*
    	 * video isotope filtering
    	 */

		// cache container
		var $videos = $('.videos');
		// initialize isotope
		if ($videos.doesExist()) 		
			$videos.isotope();

		// filter items when filter link is clicked
		$('.isotope-filters.video-filter a').click(function() {
			var selector = $(this).attr('data-filter');
			$videos.isotope({ filter: selector });

			$('.isotope-filters.video-filter').find('li').removeClass('current');
			$(this).parent().addClass('current');

			return false;
		});

		if ($('.video-link').doesExist()) {
			$('.video-link').magnificPopup({
				type: 'iframe',
				iframe: {

					patterns: {
						youtube: {
	      					index: 'youtube.com/', // String that detects type of video (in this case YouTube). Simply via url.indexOf(index).

	      					id: 'v=', // String that splits URL in a two parts, second part should be %id%
	      								// Or null - full URL will be returned
	      								// Or a function that should return %id%, for example:
	      								// id: function(url) { return 'parsed id'; } 

	      					src: 'http://www.youtube.com/embed/%id%?autoplay=1' // URL that will be set as a source for iframe. 
	      				}
	      			}
	      		}
      		});
		}


		/*
    	 * grid blog
    	 */

		// cache container
		var $blog = $('.grid-blog').imagesLoaded( function() {
			// initialize isotope
			if ($blog.doesExist()) {
				$blog.isotope({layoutMode:'masonry'});
			}
		});
	});

	$(window).resize(function() {
		if ($('.grid-blog').doesExist())
			$('.grid-blog').isotope( 'reLayout' );
	});

	/*
	 * Add Isotope filter & sort magical layouts.
	 */

	$(function(){
		var $container = $('.grid-blog');

		$container.isotope({
			itemSelector : '.grid-item'
		});

		$container.infinitescroll({
			navSelector  : '.pager-nav',    // selector for the paged navigation 
			nextSelector : '.pager-nav a',  // selector for the NEXT link (to page 2)
			itemSelector : '.grid-item',     // selector for all items you'll retrieve
			behavior: "twitter",
		},

		// call Isotope as a callback
		function( newElements ) {
			$container.imagesLoaded( function() {
				if ($('.flexslider.post-gallery').doesExist()) {
					$('.flexslider.post-gallery').flexslider({
						directionNav: false,
					});
				}
				$container.isotope( 'appended', $( newElements ) );
			});
		});

		$('.grid-blog').infinitescroll('unbind');

		$('a.load-more').click(function() {
			$('.grid-blog').infinitescroll('retrieve');
			return false;
		});
	});

	/*
	 * Control load more button.
	 */

	$(document).ready(function($) {
		// The number of the next page to load (/page/x/).
		var pageNum = parseInt(ta_music.startPage) + 1;

		// The maximum number of pages the current query can return.
		var max = parseInt(ta_music.maxPages);

		if(max == 1) {
			$('#load-more-enable').addClass('hide');
		}

		$('a.load-more').click(function() {

			if(pageNum < max) {
				pageNum++;
			} else {
				$('#load-more-enable').addClass('hide');
				$('#load-more-disable').removeClass('hide');
				$('#load-more-disable').css('pointer-events', 'none');
			}

			return false;
		});
	});

	/*
	 * Add specific functions and styling.
	 */

	$('.single-event .sd-title').css('display', 'none');
	$('.single-event .sd-content ul').addClass('share');
	$('.post-type-archive-event ul.pagination').addClass('events-pagination');
	$('.comment-reply-link').addClass('reply');
	$('select').addClass('form-control');
	$('table#wp-calendar').addClass('table table-striped');
	$('.sidebar .widget ul').not(document.getElementsByClassName('tweets')).not(document.getElementsByClassName('wp-tag-cloud')).not(document.getElementsByClassName('tabs')).addClass('nav');

})(jQuery);