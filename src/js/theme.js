jQuery(document).ready(function($){

	$('.menu-toggle').click(function(){
		var body = $('body');
		var navItems = $('.fixed-nav .nav-wrap .main-menu > li');
		var navItemsNum = navItems.length;
		if(!body.is('.active-nav')){
			setTimeout(function(){
				for(let i = 0; i < navItemsNum; i++){
			        setTimeout(function(){
			        	navItems.eq(i).addClass('nav-animated');
			        }, (40 * i));
			    }
			}, 200);
		} else {
			navItems.css('transition-duration', '0');
			setTimeout(function(){
				navItems.removeClass('nav-animated');
				navItems.css('transition-duration', '');
			}, 400);
		}
		body.toggleClass('active-nav');
	});

	$(window).click(function(e){
	    // var x = e.pageX - this.offsetLeft;
	    // var y = e.pageY - this.offsetTop;
	    // alert(y);
	    var navHeight = $('.fixed-nav').outerHeight();
	    var mouseClick = e.pageY - $(document).scrollTop();
	    if(mouseClick > navHeight){
	    	$('body').removeClass('active-nav');
	    }
	}); 

	function btnFix(){
		$('.btn, .main-menu > li > a').each(function(){
			$(this).find('.inner-fix').contents().unwrap();
			var height = $(this).outerHeight();
			var heightFix = height * .0560695;
			$(this).wrapInner('<span class="inner-fix d-inline-block" style="transform: translateY(' + heightFix + 'px);"></span>');
		});
	}
	btnFix();
	$(window).on('load resize', function(e){
    	btnFix();
	});

	function positionCalc(){
		$('*[data-position-calc]').each(function(){
			var el = $(this);
			var offset = el.offset().top + (el.outerHeight() / 2);
			var windowHeight = $(window).outerHeight();
			var scroll = $(document).scrollTop() + (windowHeight / 2);
			var position = offset - scroll;
			var percent = position / windowHeight;
			if(percent < -1){
				percent = -1;
			} else if(percent > 1){
				percent = 1;
			}
			el.attr('data-position-calc', percent);
			// $('.flex-layer--header .background, .flex-layer--centerpiece .background').each(function(){
			$('.layered-fog').each(function(){
				var fix = $(document).scrollTop();
				var size = ($(this).parents('.flex-layer').outerHeight() / windowHeight) * -.66;
				// console.log(size);
				// alert(size);
				// $(this).css('transform', (fix * size) + 'px');
				$(this).css('transform', 'translate(-50%, ' + (fix * size) + 'px)');
			});
			$('.flex-layer--header .background--short').each(function(){
				var fix = $(this).attr('data-position-calc');
				$(this).css('transform', 'translate(-50%, calc(-50% + ' + (fix * 30 * -1) + 'px))');
			});	
			$('.flex-layer--header .background--tall').each(function(){
				var fix = $(this).attr('data-position-calc');
				$(this).css('transform', 'translate(-50%, calc(-50% + ' + (fix * 300 * -1) + 'px))');
			});
			$('.flex-layer--centerpiece .background').each(function(){
				var fix = $(this).attr('data-position-calc');
				$(this).css('transform', 'translate(-50%, calc(-50% + ' + (fix * 300 * -1) + 'px))');
			});
			$('.flex-layer--photo-with-content .background').each(function(){
				var fix = $(this).attr('data-position-calc');
				$(this).css('transform', 'translate(-50%, calc(-50% + ' + (fix * 180 * -1) + 'px))');
			});
			// $('.flex-layer--photo-with-content .photo__inner').each(function(){
			// 	var fix = $(this).attr('data-position-calc');
			// 	fix = fix * 23;
			// 	$(this).css('top', (23 + (fix * 1)) + 'px');
			// 	$(this).css('bottom', (23 + (fix * -1)) + 'px');
			// });
			$('.flex-layer--menu .photo__inner').each(function(){
				var fix = $(this).attr('data-position-calc');
				$(this).css('transform', 'translateY(calc(-50% + ' + (fix * 175 * -1) + 'px))');
			});
			$('.flex-layer--map .location__inner').each(function(){
				var fix = $(this).attr('data-position-calc');
				$(this).css('transform', 'translateY(calc(-50% + ' + (fix * 100 * -1) + 'px))');
			});

			$('.compass__inner').each(function(){
				var compass = $(this);
				var fix = parseFloat(compass.attr('data-position-calc'));
				if(fix < .2){
					compass.addClass('compass__inner--activated')
				}
			})

			$('.stamp').each(function(){
				var stamp = $(this);
				// console.log(stamp.attr('data-position-calc'));
				var fix = parseFloat(stamp.attr('data-position-calc'));
				// console.log(fix);
				// if(stamp.parents('.wow.animated').length){
					if(typeof fix !== 'undefined' && fix < .25){
						if(stamp.parents('.flex-layer--centerpiece').length){
							// console.log(stamp.parents('.brown-wrap').css('opacity'));
							// console.log(typeof stamp.parents('.brown-wrap').css('opacity'));
							if(stamp.parents('.brown-wrap').css('opacity') == '1'){
								stamp.addClass('stamped');
							}
						} else {
							stamp.addClass('stamped');
						}
					}
				//}
			});

			$('.dot').each(function(index){
				var dot = $(this);
				var timing = index * .025;
				dot.css('transition-delay', timing + 's');
				if($(this).siblings('.dot:first').attr('data-position-calc') < .2){
					dot.addClass('dot--activated');
				}
			});
		});
	}
	positionCalc();
	$(window).on('load scroll', function(e){
    	positionCalc();
	});


	function sizeEventDots(){
		$('.event-layers').each(function(){
			var layers = $(this);
			var stripe = layers.find('.dot-separator');
			var currentDots = stripe.find('.dot').length;
			// alert(currentDots);
			// stripe.html('');
			var eventCount = parseInt($(this).find('.event-card').length);
			var dotCount = (eventCount * 9) + 8 - currentDots;
			// alert(dotCount);
			for(i = 0; i < dotCount; i++){
				// var delay = .25 + (.22 * i);
				// var animation = 'fadeInLeft';
				// if(i % 2 == 0){
				// 	animation = 'fadeInRight';
				// }
				// animation = 'zoomIn';
				var posCalc = '';
				// console.log(i);
				if(i == 0){
					posCalc = ' data-position-calc';
				}
				stripe.append('<div class="dot"' + posCalc + '></div>');
				// stripe.append('<div class="dot wow--disabled ' + animation + '"></div>');
			}
		});
	}
	sizeEventDots();

	function disableScroll(){ 
	    // Get the current page scroll position 
	    scrollTop = window.pageYOffset || document.documentElement.scrollTop; 
	    scrollLeft = window.pageXOffset || document.documentElement.scrollLeft, 
	        // if any scroll is attempted, set this to the previous value 
	        window.onscroll = function() { 
	            window.scrollTo(scrollLeft, scrollTop); 
	        }; 
	} 
	function enableScroll(){ 
	    window.onscroll = function() {}; 
	} 

	$('*[data-events-load]').click(function(e){
		e.preventDefault();
		var btn = $(this);
		btn.html('<span class="inner-fix d-inline-block">Loading ...</span>');
		btnFix();
		var events = btn.parents('.flex-layer').find('.event-layers');
		var offset = parseInt($(this).attr('data-events-count'));
		$.getJSON(siteUrl + '/wp-json/drifters/v1/events?offset=' + offset, function(result){
			disableScroll();
			$.each(result.documents, function(key, val){
				events.append(`
					<div class="row event-row" style="display: none;">
                        <div class="col-12 col-lg-5 mb-4 mb-lg-0 p-relative">
                            <div class="row event-card wow fadeInUp" data-wow-delay=".5s">
                                <div class="col-4 d-none d-sm-flex logo align-items-center">
                                    <a class="theme-logo d-inline-block" href="` + siteUrl + `">
                                        <img class="d-inline-block" src="` + result.logo_url + `">
                                    </a>
                                </div>
                                <div class="col-12 col-sm-8 info-wrap d-flex align-items-center">
                                    <div class="info">
                                        <p class="info__intro d-inline-block mx-auto">Drifters Kitchen &amp; Bar<span class="d-block">Presents</span></p>
                                        <h3>` + val.title + `</h3>
                                        <div class="stylized-line"></div>
                                        <p class="info__date mb-0">` + val.date + `</p>
                                    </div>
                                </div>
                                 <div class="event-hover p-4 d-flex align-items-center justify-content-center">
	                                <div>
	                                    <h2 class="single-line">` + val.subtitle + `</h2>
	                                    <p class="info__date mb-0">` + val.date + `</p>
	                                </div>
	                            </div>
                            </div>
                        </div>
                    </div>
				`);
				$('.event-row').fadeIn();
				sizeEventDots();
			});
			btn.html('<span class="inner-fix d-inline-block">See More Events</span>');
			btnFix();
			setTimeout(function(){
				enableScroll();
			}, 200);
			btn.attr('data-events-count', offset + 3);
			if(result.documents.length < 3){
				btn.remove();
			}
		});
	});

	// JS Scroll
	$('*[href="#js-scroll-next"]').click(function(){
		var nextLayer = $(this).parents('.flex-layer').next('.flex-layer');
		$('html, body').animate({
			scrollTop: nextLayer.offset().top
		}, 500);
	});

	// // Initiate WOW Library
	new WOW().init({
		offset: 65,
		mobile: false,
		resetAnimation: false
	});

});