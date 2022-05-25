'use strict';

var MFIT = MFIT || {};

/**
 * Predefined variables.
 */
var $ = jQuery,
	$window = $(window),
	$document = $(document),
	$body = $('body'),
	$mainMenu = $('.sf-menu'),
	$handheldMenu = $('.mfit-menu'),
	$intelHeader = $('.intelligent-header'),
	$preLoader = $('.mfit-pageloader'),
	$toTop = $('.mfit-scroll-to-top'),
	$headerSpace = $('.fixed-header-space'),
	$pSlider = $('#primary_slider'),
	$fns = MFIT.functions,
	cartSidebar = {
		container: '.drawer-container',
		close: '.close',
		overlay: '.drawer-overlay'
	};

/**
 * Check if element exists.
 */
$.fn.elExists = function() {
	return this.length > 0;
};

/**
 * Helpers.
 */
MFIT.helpers = {
	sampleFunction: function() {
		console.log('I am a helper function');
	}
};

/**
 * Functions.
 */
MFIT.functions = {
	preLoaderInit: function() {
		if (!$preLoader.elExists()) {
			return false;
		}

		$preLoader.delay(300).fadeOut('fast');
	},

	mainNavInit: function() {
		$mainMenu.superfish({
			delay: 0,
			animation: { opacity: 'show' },
			animationOut: { opacity: 'hide' },
			speed: 'fast',
			autoArrows: false,
			disableHI: true
		});
	},

	mainNavSubAction: function() {
		$document.on('mouseenter', '.sf-menu .sub-menu', function() {
			var menu = $(this);
			var child = $(this).find('ul');
			if ($(menu).offset().left + $(menu).width() + $(child).width() > $(window).width()) {
				$(child).css({ left: 'inherit', right: '100%' });
			}
		});
	},

	handheldNavInit: function() {
		var cButton = document.querySelector('.mfit-menu__close');
		if (cButton) {
			var slideLeft = new Menu();
		}

		var slideLeftBtn = document.querySelector('#mfit-trigger-button');
		if (slideLeftBtn) {
			slideLeftBtn.addEventListener('click', function(e) {
				e.preventDefault;
				slideLeft.open();
			});
		}
	},

	handheldNavSubAction: function() {
		// adds toggle button to li items that have children
		$handheldMenu.find('li a').each(function() {
			if ($(this).next().length > 0) {
				$(this)
					.parent('li')
					.addClass('has-child')
					.append('<a class="drawer-toggle" href="#"><i class="fa fa-angle-down"></i></a>');
			}
		});

		// expands the dropdown menu on each click
		$handheldMenu.find('li .drawer-toggle').on('click', function(e) {
			e.preventDefault();
			$(this).parent('li').children('ul').stop(true, true).slideToggle(250);
			$(this).parent('li').toggleClass('open');
		});
	},

	intelligentMenuInit: function() {
		if (!$intelHeader.elExists()) {
			return false;
		}

		var navContainer = document.querySelector('.intelligent-header');
		var options = {
			offset: 450,
			classes: {
				initial: 'iheader',
				pinned: 'iheader--pinned',
				unpinned: 'iheader--unpinned',
				top: 'iheader--top',
				notTop: 'iheader--not-top',
				bottom: 'iheader--bottom',
				notBottom: 'iheader--not-bottom'
			}
		};

		var headroom = new Headroom(navContainer, options);

		headroom.init();
	},

	menuClasses: function() {
		if (!$intelHeader.elExists()) {
			return false;
		}

		$window.on('scroll', function() {
			var height = $window.scrollTop();

			if (height < 100) {
				$intelHeader.removeClass('scrolling');
			} else {
				$intelHeader.addClass('scrolling');
			}
		});
	},

	footerTitleHeight: function() {
		var $footerTitle = $('.footer-top-column .widgettitle');
		var height = $footerTitle.innerHeight();

		$footerTitle.each(function() {
			$(this).css({
				height: height
			});
		});
	},

	scrollToTop: function() {
		$toTop.hide();
		$window.on('scroll', function() {
			if ($window.scrollTop() > 200) {
				$toTop.fadeIn();
			} else {
				$toTop.fadeOut();
			}
		});

		$toTop.on('click', function() {
			$('html,body').animate(
				{
					scrollTop: 0
				},
				{
					duration: 500,
					easing: 'swing'
				}
			);
		});
	},

	bodyClass: function() {
		$body.addClass('document-loaded');
	},

	headerActions: function() {
		if (!$intelHeader.elExists()) {
			return false;
		}

		var intHeight = $intelHeader[0].getBoundingClientRect().height;
		$headerSpace.height(intHeight);
	},

	showcaseSlider: function() {
		if (!$pSlider.elExists()) {
			return false;
		}

		var interleaveOffset = 0.5;

		var swiperOptions = {
			loop: true,
			speed: 1000,
			effect: 'slide',
			disableOnInteraction: true,
			watchSlidesProgress: true,
			mousewheelControl: true,
			keyboardControl: true,

			autoplay: {
				delay: 7000
			},

			navigation: {
				nextEl: '.swiper-arrow.next.slide',
				prevEl: '.swiper-arrow.prev.slide'
			},

			pagination: {
				el: '.swiper-pagination',
				clickable: true
			},

			on: {
				progress: function() {
					var swiper = this;
					for (var i = 0; i < swiper.slides.length; i++) {
						var slideProgress = swiper.slides[i].progress;
						var innerOffset = swiper.width * interleaveOffset;
						var innerTranslate = slideProgress * innerOffset;
						swiper.slides[i].querySelector('.slide-inner').style.transform =
							'translate3d(' + innerTranslate + 'px, 0, 0)';
					}
				},
				touchStart: function() {
					var swiper = this;
					for (var i = 0; i < swiper.slides.length; i++) {
						swiper.slides[i].style.transition = '';
					}
				},
				setTransition: function(speed) {
					var swiper = this;
					for (var i = 0; i < swiper.slides.length; i++) {
						swiper.slides[i].style.transition = speed + 'ms';
						swiper.slides[i].querySelector('.slide-inner').style.transition = speed + 'ms';
					}
				}
			}
		};

		var swiper = new Swiper($pSlider, swiperOptions);
	},

	closeCartSidebar: function() {
		$(''.concat(cartSidebar.container, ' ').concat(cartSidebar.close)).on('click', function(e) {
			MFIT.functions.closeSidebar();
		});

		$(cartSidebar.overlay).on('click', MFIT.functions.closeSidebar);
	},

	closeSidebar: function() {
		$(cartSidebar.container).removeClass('show-sidebar');
		$('body').removeClass('sidebar-open');
		$('.close.filter-drawer').trigger('click');
		$(cartSidebar.overlay).animate(
			{
				opacity: 0
			},
			300,
			'swing',
			function() {
				$(cartSidebar.overlay).hide();
			}
		);
	},

	openCart: function() {
		$(cartSidebar.container).addClass('show-sidebar');
		$('body').addClass('sidebar-open');
		$(cartSidebar.overlay).show('fast', function() {
			$(cartSidebar.overlay).animate(
				{
					opacity: 0.5
				},
				300,
				'swing'
			);
		});
		MFIT.functions.cartContent();
	},

	cartContent: function() {
		$.ajax({
			url: maxxSettings.ajaxurl,
			data: {
				action: 'load_template',
				template: 'cart/mini',
				part: 'cart'
			},
			type: 'POST',
			success: function success(data) {
				$('#side-content-area-id').html(data);
			},
			error: function error(MLHttpRequest, textStatus, errorThrown) {
				console.log(errorThrown);
			}
		});
	},

	openCartSidebar: function() {
		$('#masthead .action-buttons li.cart-btn a, .mobile-bar .list-inline > li.cart-btn a').click(function(e) {
			e.preventDefault();
			MFIT.functions.openCart();
		});

		$(document).on('added_to_cart', function() {
			MFIT.functions.openCart();
		});
	},

	removeFromCart: function() {
		$(document).on('removed_from_cart', MFIT.functions.cartContent);
	},

	accordion: function() {
		if (!$('.mfit-shop-sidebar').elExists()) {
			return false;
		}

		var firstEl = document.getElementsByClassName('accordion-toggle')[0];
		firstEl.classList.add('active');
		firstEl.nextElementSibling.style.maxHeight = firstEl.nextElementSibling.scrollHeight + 'px';

		var acc = document.getElementsByClassName('accordion-toggle');
		var i;

		for (i = 0; i < acc.length; i++) {
			acc[i].onclick = function() {
				var panel = this.nextElementSibling;
				var accPanel = document.getElementsByClassName('accordion-content');
				var accToggle = document.getElementsByClassName('accordion-toggle');
				var accToggleActive = document.getElementsByClassName('accordion-toggle active');

				if (panel.style.maxHeight) {
					panel.style.maxHeight = null;
					this.classList.remove('active');
				} else {
					for (var ii = 0; ii < accToggleActive.length; ii++) {
						accToggleActive[ii].classList.remove('active');
					}

					for (var iii = 0; iii < accPanel.length; iii++) {
						this.classList.remove('active');
						accPanel[iii].style.maxHeight = null;
					}

					panel.style.maxHeight = panel.scrollHeight + 'px';
					this.classList.add('active');
				}
			};
		}
	},

	stickySidebar: function() {
		if (!$('#secondary.widget-area').elExists()) {
			return false;
		}

		$('#secondary.widget-area').stickySidebar({
			topSpacing: 20,
			bottomSpacing: 20
		});
	},

	tooltips: function() {
		if (!$('.mfit-buttons .action-btn').elExists()) {
			return false;
		}

		$('.mfit-buttons .action-btn[title]').tipsy();
	},

	wishlistActions: function() {
		$(document).on('click', '.mfit-wishlist-icon', function() {
			if ($(this).hasClass('mfit-add-to-wishlist')) {
				var $obj = $(this),
					productId = $obj.data('product-id'),
					afterTitle = $obj.data('title-after');
				var data = {
					action: 'mfit_add_to_wishlist',
					nonce: $obj.data('nonce'),
					add_to_wishlist: productId
				};
				$.ajax({
					url: maxxSettings.ajaxurl,
					type: 'POST',
					data: data,
					beforeSend: function beforeSend() {
						$obj.find('.wishlist-icon').hide();
						$obj.find('.ajax-loading').show();
						$obj.addClass('mfit-wishlist-ajaxloading');
					},
					success: function success(data) {
						if (data['result'] != 'error') {
							$obj.find('.ajax-loading').hide();
							$obj.removeClass('mfit-wishlist-ajaxloading');
							$obj.removeClass('mfit-add-to-wishlist').addClass('mfit-remove-from-wishlist');
							$obj.parent().attr('original-title', afterTitle);
							$('body').trigger('mfit_added_to_wishlist', [ productId ]);
						} else {
							console.log(data['message']);
						}
					}
				});
				return false;
			} else if ($(this).hasClass('mfit-remove-from-wishlist')) {
				var $obj = $(this),
					productId = $obj.data('product-id'),
					afterTitle = $obj.data('title-after');
				var data = {
					action: 'mfit_remove_from_wishlist',
					context: 'frontend',
					nonce: $obj.data('nonce'),
					remove_from_wishlist: productId
				};
				$.ajax({
					url: maxxSettings.ajaxurl,
					type: 'POST',
					data: data,
					beforeSend: function beforeSend() {
						$obj.find('.wishlist-icon').hide();
						$obj.find('.ajax-loading').show();
						$obj.addClass('mfit-wishlist-ajaxloading');
					},
					success: function success(data) {
						if (data['result'] != 'error') {
							$obj.find('.ajax-loading').hide();
							$obj.removeClass('mfit-wishlist-ajaxloading');
							$obj.removeClass('mfit-remove-from-wishlist').addClass('mfit-add-to-wishlist');
							$obj.parent().attr('original-title', 'Zur Wunschliste hinzufügen');
							$('body').trigger('mfit_removed_from_wishlist', [ productId ]);
						} else {
							console.log(data['message']);
						}
					}
				});

				return false;
			}
		});

		$('body').on('mfit_added_to_wishlist', function(e, product_id) {
			$('.wishlist-icon-num').html(Number.parseInt($('.wishlist-icon-num').html()) + 1);
		});
		$('body').on('mfit_removed_from_wishlist', function(e, product_id) {
			$('.wishlist-icon-num').html(Number.parseInt($('.wishlist-icon-num').html()) - 1);
		});
	},

	quantityChange: function() {
		$(document).on('click', '.quantity .input-group-btn .quantity-btn', function() {
			var $input = $(this).closest('.quantity').find('.input-text');

			if ($(this).hasClass('quantity-plus')) {
				$input.trigger('stepUp').trigger('change');
			}

			if ($(this).hasClass('quantity-minus')) {
				$input.trigger('stepDown').trigger('change');
			}
		});
	},

	wcTabClass: function() {
		var $target = $('.woocommerce-tabs.wc-tabs-wrapper');

		if (!$target.elExists()) {
			return false;
		}

		$target.find('#tab-description').addClass('active');

		$('body').on('click', '.woocommerce-tabs ul.tabs li a', function(e) {
			var id = $(this).parent().attr('aria-controls');
			$target.find('.woocommerce-Tabs-panel').removeClass('active');
			$target.find('#' + id).addClass('active');
		});
	},

	mobileActions: function() {
		$('body').on('click', '.mobile-bar .list-inline > li.login-btn > a', function(e) {
			e.preventDefault();
			$('body').removeClass('mobile-search-active').toggleClass('mobile-popup-active');
			$('body').find('.mobile-search-overlay').removeClass('overlay-active');
			$(this).parents().find($('.mobile-bar .list-inline > li')).removeClass('active');
			$('#mobile-search').fadeOut('fast');
			$(this).next().fadeToggle('fast');
		});

		$('body').on('click', '.mobile-bar .list-inline > li.search-btn > a', function(e) {
			e.preventDefault();
			$('body').removeClass('mobile-popup-active').toggleClass('mobile-search-active');
			$('body').find('.mobile-search-overlay').toggleClass('overlay-active');
			$(this).parents().find($('.mobile-bar .list-inline > li')).removeClass('active');
			$('.mobile-bar .list-inline > li.login-btn .login-expanded').fadeOut('fast');
			$('#mobile-search').fadeToggle('fast');
		});

		$('body').on('click', '.mobile-search-overlay, #mobile-search .close-btn', function(e) {
			e.preventDefault();
			$('body').removeClass('mobile-search-active').removeClass('mobile-popup-active');
			$('.mobile-search-overlay').removeClass('overlay-active');
			$(this).parents().find($('.mobile-bar .list-inline > li')).removeClass('active');
			$('#mobile-search').fadeOut('fast');
		});
	}
};

/**
 * Scripts to run on document ready event.
 */
MFIT.onReady = function() {
	var fns = MFIT.functions;

	$document.on('ready', function() {
		fns.preLoaderInit();
		fns.mainNavInit();
		fns.mainNavSubAction();
		fns.handheldNavInit();
		fns.handheldNavSubAction();
		fns.intelligentMenuInit();
		fns.menuClasses();
		fns.scrollToTop();
		fns.headerActions();
		fns.footerTitleHeight();
		fns.showcaseSlider();
		fns.openCartSidebar();
		fns.closeCartSidebar();
		fns.removeFromCart();
		fns.accordion();
		// fns.stickySidebar();
		fns.tooltips();
		fns.wishlistActions();
		fns.quantityChange();
		fns.wcTabClass();
		fns.mobileActions();
	});
};

/**
 * Scripts to run on window load event.
 */
MFIT.onLoad = function() {
	var fns = MFIT.functions;

	$window.on('load', function() {
		fns.bodyClass();
	});
};

/**
 * Scripts to run on window resize event.
 */
MFIT.onResize = function() {
	var fns = MFIT.functions;

	$window.on('resize', function() {
		fns.headerActions();
		fns.footerTitleHeight();
	});
};

/**
 * App Init.
 */
MFIT.init = (function() {
	MFIT.onReady(), MFIT.onLoad(), MFIT.onResize();
})();
