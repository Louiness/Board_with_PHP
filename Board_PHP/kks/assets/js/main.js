/*
	Introspect by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
*/

(function($) {

	skel.breakpoints({
		xlarge:	'(max-width: 1680px)',
		large:	'(max-width: 1280px)',
		medium:	'(max-width: 980px)',
		small:	'(max-width: 736px)',
		xsmall:	'(max-width: 480px)'
	});

	$(function() {

		var	$window = $(window),
			$body = $('body');

		// Disable animations/transitions until the page has loaded.
			$body.addClass('is-loading');

			$window.on('load', function() {
				window.setTimeout(function() {
					$body.removeClass('is-loading');
				}, 100);
			});

		// Fix: Placeholder polyfill.
			$('form').placeholder();

		// Prioritize "important" elements on medium.
			skel.on('+medium -medium', function() {
				$.prioritize(
					'.important\\28 medium\\29',
					skel.breakpoint('medium').active
				);
			});

		// Off-Canvas Navigation.

			// Navigation Panel Toggle.
				$('<a href="#navPanel" class="navPanelToggle"></a>')
					.appendTo($body);

			// Navigation Panel.
				$(
					'<div id="navPanel">' +
						$('#nav').html() +
						'<a href="#navPanel" class="close"></a>' +
					'</div>'
				)
					.appendTo($body)
					.panel({
						delay: 500,
						hideOnClick: true,
						hideOnSwipe: true,
						resetScroll: true,
						resetForms: true,
						side: 'left'
					});

			// Fix: Remove transitions on WP<10 (poor/buggy performance).
				if (skel.vars.os == 'wp' && skel.vars.osVersion < 10)
					$('#navPanel')
						.css('transition', 'none');

	});

})(jQuery);

$(document).ready(function Arrow_ScrollDown(){
		$('#downArrow').bind('click', function(){
			$('html, body').animate({scrollTop : $('#downArrow').offset().top-=3
		},1000);
		return false;
	})
});

$(document).ready(function Arrow_ScrollUp(){
		$('#upArrow').bind('click', function(){
			$('html, body').animate({scrollTop : $('#upArrow').offset().top-=1003
		},1000);
		return false;
	})
});


function ScrollDown(){
		$('html, body').stop().animate({
				scrollTop : $('#one').offset().top-=60
		},1000);
}

/* javascript */
window.addEventListener('scroll', function() {
  var el = document.querySelector('#downArrow');

  if(window.scrollY >= 400) el.classList.add('shown');
  else el.classList.remove('shown');
});

window.addEventListener('scroll', function() {
  var el2 = document.querySelector('#upArrow');

  if(window.scrollY >= 400) el2.classList.add('shown');
  else el2.classList.remove('shown');
});

window.addEventListener('scroll', function() {
  var el = document.querySelector('#downArrow');

  if(window.scrollY >= 2500) el.classList.add('unshown');
  else el.classList.remove('unshown');
});
window.addEventListener('scroll', function() {
  var el2 = document.querySelector('#upArrow');

  if(window.scrollY >= 400) el2.classList.add('unshown');
  else el2.classList.remove('unshown');
});
