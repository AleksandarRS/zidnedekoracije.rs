// "use strict";
const Global = module.exports = {
	
	$dom: {
		window: $(window),
		body: $('body')
	},

	device: {
		isMobile: false,
		isTablet: false,
		isPortable: false,
		width: window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width,
		height: window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height,
	},

	vars: {
		keys: { 37: 1, 38: 1, 39: 1, 40: 1 },
		scrollAllowed: [
			$('.main-navigation')
		],
	},

	functions: {

		
		escKey: function (callback) {
			$(document).on('keyup', function (e) {
				if (e.keyCode === 27) {
					callback();
				}
			});
		},

		clickOutsideContainer: function (selector, container, closeBtn, callback) {


			Global.privateFunctions.convertToObject( arguments );

			$(selector).on('mouseup', function (e) {
				e.preventDefault();
				if (!container.is(e.target) && container.has(e.target).length === 0 && !$(closeBtn).is( $(e.target) ) ) {
					callback();
				}
			});
		},

		throttle: function(fn, wait) {
			
			var time = Date.now();

			return function() {
				if ((time + wait - Date.now()) < 0) {
					fn();
					time = Date.now();
				}
			}
		},
	
		disableScroll: function() {
			if (window.addEventListener) {
				window.addEventListener('DOMMouseScroll', Global.privateFunctions.preventDefault, {passive: false});
			}
				
			document.addEventListener('wheel', Global.privateFunctions.preventDefault, {passive: false}); // Disable scrolling in Chrome
			document.onkeydown  = Global.privateFunctions.preventDefaultForScrollKeys;
	
			window.addEventListener('touchmove', Global.privateFunctions.preventDefault, { passive: false });
			window.addEventListener('mousewheel', Global.privateFunctions.preventDefault, { passive: false });
			document.addEventListener('mousewheel', Global.privateFunctions.preventDefault, { passive: false });
			window.addEventListener('wheel', Global.privateFunctions.preventDefault, { passive: false });
	
		},
	
		enableScroll: function() {
			if (window.removeEventListener) {
				window.removeEventListener('DOMMouseScroll', Global.privateFunctions.preventDefault, {passive: false});
			}
				
			document.removeEventListener('wheel', Global.privateFunctions.preventDefault, {passive: false}); // Enable scrolling in Chrome
	
			window.removeEventListener('touchmove', Global.privateFunctions.preventDefault, { passive: false });
			window.removeEventListener('mousewheel', Global.privateFunctions.preventDefault, { passive: false });
			document.removeEventListener('mousewheel', Global.privateFunctions.preventDefault, { passive: false });
			window.removeEventListener('wheel', Global.privateFunctions.preventDefault, { passive: false });
	
		}
		
	},

	privateFunctions: {

		init: function(){
			Global.privateFunctions.setupSizes();
			Global.privateFunctions.setupEvents();
		},

		setupSizes: function(){

			Global.device.width = $(window).outerWidth();
			Global.device.height = $(window).outerHeight();

			if( Global.device.width <= 1199 && Global.device.width >= 768 ){
				Global.device.isTablet = true;
				Global.device.isMobile = false;
				Global.device.isPortable = true;
			}
			else if( Global.device.width >= 1199 ){
				Global.device.iTablet = false;
				Global.device.isMobile = false;
				Global.device.isPortable = false;
			}
			else if( Global.device.width < 768 ){
				Global.device.iTablet = false;
				Global.device.isMobile = true;
				Global.device.isPortable = true;
			}

		},
		setupEvents: function(){
			Global.$dom.window.on( 'resize', Global.functions.throttle( this.setupSizes, 200 ) );
		},
		convertToObject: function( items ){
			
			for( let i = 0; i < items.length; i++ ){

				if( items[i] instanceof Function ) break;

				if( ( items[i] instanceof jQuery ) === false ){
					items[i] = $(items[i]);
				}
			}
		
		},

		preventDefault: function(e) {

			for( let allowedElement in Global.vars.scrollAllowed ){
				let $element = Global.vars.scrollAllowed[allowedElement];

				if( $element.is(e.target) || $element.has( $(e.target) ).length > 0 ){
					return;
				}
			}

			e = e || window.event;
			if (e.preventDefault)
				e.preventDefault();
			e.returnValue = false;  
		},
	
		preventDefaultForScrollKeys: function(e) {
			if (Global.vars.keys[e.keyCode]) {
				Global.preventDefault(e);
				return false;
			}
		},
	}
};

Global.privateFunctions.init();
