/**
 * Theme JS
 */

'use strict';

/*** Preloader ***/

var preloader = (function() {

	// Variables
	var $window = $(window);
	var loader = $("#loader-wrapper");

	// Methods
	$window.on({
		'load': function() {

			loader.fadeOut();

		}
	});

	// Events

})();


/*** Navbar ***/

var navbar = (function() {

	// Variables
	var navbar = $('.navbar');
	var navbarLinks = navbar.find('.navbar-nav > li:not(.dropdown) > a');
	var navbarCollapse = $('.navbar-collapse');
	var scrollTop = $(window).scrollTop();

	// Methods
	function makeInverse() {
		navbar.removeClass('navbar-default').addClass('navbar-inverse');
	}
	function makeDefault() {
		navbar.removeClass('navbar-inverse').addClass('navbar-default');
	}

	// Events

	// Toggle navbar on page load if needed
	if (scrollTop > 0) {
		makeInverse();
	}

	// Toggle navbar on scroll
	$(window).scroll(function() {
		scrollTop = $(window).scrollTop();

		if (scrollTop > 0 && $('.navbar-default').length) {
			makeInverse();
		} else if (scrollTop === 0) {
			makeDefault();
		}

	});

	// Toggle navbar on collapse
	navbarCollapse.on({
		'show.bs.collapse': function() {
			makeInverse();
		},
		'hidden.bs.collapse': function() {
			scrollTop = $(window).scrollTop();

			if (scrollTop === 0) {
				makeDefault();
			}
		}
	});

	// Close collapsed navbar on click
	navbarLinks.on('click', function() {
		navbarCollapse.collapse('hide');
	});

})();


/*** Home parallax ***/

var parallax = (function() {

	// Variables
	var elem = $(".section__home");
    var elemHeight = elem.height();
    var parallaxRate = 2;

	// Methods
	$(window).scroll(function() {

        var scrollTop = $(window).scrollTop(),
            elementOffsetTop = scrollTop,
            parallaxOffset = elementOffsetTop / parallaxRate;

        if (elementOffsetTop <= elemHeight) {
            $(".home-parallax__bg").css({
                "-webkit-transform": "translateY(" + parallaxOffset + "px)",
                        "transform": "translateY(" + parallaxOffset + "px)"
            });
        }

    });

	// Events

})();


/*** Smooth scroll to anchor ***/

var smoothScroll = (function() {

	// Variables
	var link = $('a[href^="#section__"]');
	var duration = 1000;

	// Methods
	function scrollTo(link) {
		var target = $(link.attr('href'));
		var navbar = $('.navbar');
		var navbarHeight = navbar.outerHeight();

		if ( target.length ) {
			$('html, body').animate({
				scrollTop: target.offset().top - navbarHeight + 20
			}, duration);
		}
	}

	// Events
	link.on('click', function(e) {
		e.preventDefault();
		scrollTo( $(this) );
	});

})();


/*** Button to top page ***/

var toTopButton = (function() {

	// Variables
	var topButton = $('#back-to-top');
	var scrollTop = $(window).scrollTop();
	var isActive = false;
	if (scrollTop > 100) {
		isActive = true;
	}

	// Methods

	// Events
	$(window).scroll(function() {
		scrollTop = $(window).scrollTop();

		if (scrollTop > 100 && !isActive) {
	        isActive = true;
	        topButton.fadeIn();
	    } else if (scrollTop <= 100 && isActive) {
	        isActive = false;
	        topButton.fadeOut();
	    }

	});

})();


/*** Search ***/

var search = (function() {

	// Variables
	var searchForm = $(".navbar-search");
	var searchToggle = $(".navbar-search__toggle");

	// Method
	function toggleSearch() {
		searchForm.toggle();
	}

	// Events
	searchToggle.on('click', function(e) {
		e.preventDefault();

		toggleSearch();
	});

})();


/*** Modals ***/

var modals = (function() {

	// Variables
	var $modals = $('.modal [href="#signupModal"], .modal [href="#signinModal"]');

	// Methods
	function toggleModals(elem) {
		var $this = elem;
		var target = $this.attr('href');
		var currentModal = $this.parents('.modal');

		currentModal.modal('hide');
		currentModal.on('hidden.bs.modal', function() {
			if (target.length) {
				$(target).modal('show');
			}
			target = '';
		});
	}

	// Events
	$modals.on('click', function() {
		toggleModals( $(this) );

		return false;
	});

})();


/*** AOS ***/

var aos = (function() {

	// Variables
	var $aos = $('[data-aos]');

	// Methods
	function init() {
		AOS.init({
			duration: 1000
		});
	}

	// Events
	if ( $aos.length ) {
		init();
	}

})();


/*** Mobile hover ***/

var mobileHover = (function() {

	// Variables
	var item = $('.teacher__item');

	// Methods
	function trigger(elem) {
		elem.trigger('hover');
	}

	// Events
	item.on({
		'touchstart': function() {
			trigger( $(this) );
		},
		'touchend': function() {
			trigger( $(this) );
		}
	});

})();


/*** Countdown ***/

var countdown = (function() {

	// Variables
	var clock = $('#clock');
	var toDate = '2017/10/09';

	// Methods
	function init() {
		clock.countdown(toDate, function(event) {
			$(this).html(event.strftime(''
				+ '<span>%D</span> days '
				+ '<span>%H</span> hr '
				+ '<span>%M</span> min '
				+ '<span>%S</span> sec'));
		});
	}

	// Events
	if ( clock.length ) {
		init();
	}

})();


/*** Countdown: Alt ***/

var countdown_alt = (function() {

	// Variables
	var clock = $('#event__timer');
	var toDate = '2017/10/09';

	// Methods
	function init() {
		clock.countdown(toDate, function(event) {
			$(this).html(event.strftime(''
				+ '<span>%D</span> days '
				+ '<span>%H</span> hr '
				+ '<span>%M</span> min '
				+ '<span>%S</span> sec'));
		});
	}

	// Events
	if ( clock.length ) {
		init();
	}

})();


/*** Count to ***/

var countTo = (function() {

	// Variables
	var statsItem = $('.stats_item__nbr');

	// Methods
	function init() {
		statsItem.each(function() {
			var $this = $(this);

			$this.waypoint(function(direction) {
				$this.not('.finished').countTo();
				}, {
				offset: 500
			});
		});
	}

	// Events
	if ( statsItem.length ) {
		init();
	}

})();


/*** Owl carousel ***/

var owl = (function() {

	// Variables
	var testimonialItem = $("#testimonials__carousel");

	// Methods
	function init() {
		testimonialItem.owlCarousel({
			items: 1,
			loop: true,
			slideSpeed: 1500,
			dots: true,
			autoplay: true,
			responsiveClass: true
		});
	}

	// Events
	if ( testimonialItem.length ) {
		init();
	}
})();
