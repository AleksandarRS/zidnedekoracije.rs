"use strict";

const Global = require('../site/global');

let _this = module.exports = {

	/*-------------------------------------------------------------------------------
		# Cache dom and strings
	-------------------------------------------------------------------------------*/
	$dom: {
		menuToggle: $(".menu-toggle"),
		mainNavigation: $(".main-navigation"),
    },

    vars: {
		arrowDownHTML: "<i class='icon-angle-down' aria-hidden='true'></i>",
		arrowRightHTML: "<i class='icon-angle-right' aria-hidden='true'></i>",
		arrowLefttHTML: "<i class='icon-angle-left' aria-hidden='true'></i>",
		selectors: {
			mainMenuWrapper: '.logo-menu-wrapper',
			triggerMenu: ".menu-toggle, .menu-toggle span",
			navItemsWithChildren: 'li.menu-item-has-children',
		},
		menuOpened: false,
	},

	/*-------------------------------------------------------------------------------
		# Initialize
	-------------------------------------------------------------------------------*/
	init: function () {
		_this = this;
		_this.setup();
		_this.bind();
	},

	toggle: function(e, close) {
		
		if(  typeof e !== 'undefined'  )
			e.preventDefault();

		if( close ){

			Global.$dom.body.removeClass('menu-opened');
			Global.functions.enableScroll();
			_this.$dom.mainNavigation.attr( 'area-expanded', 'false' );
			_this.vars.menuOpened = false;

			return false;
		}

		_this.$dom.mainNavigation.attr( 'area-expanded', function(index, attr){
			return attr === 'true' ? 'false' : 'true';
		});

		_this.vars.menuOpened = !_this.vars.menuOpened; 

		if( _this.vars.menuOpened )
			Global.functions.disableScroll();
		else
			Global.functions.enableScroll();

		Global.$dom.body.toggleClass('menu-opened');

	},
	
	bind: function() {

		_this.$dom.menuToggle.on( 'click', _this.toggle );

		// Close the menu when we press escape button
		Global.functions.escKey(function(){
			_this.toggle( undefined, true );			
		});

		// Close the menu when we click outside the container
		Global.functions.clickOutsideContainer(_this.vars.selectors.mainMenuWrapper, _this.$dom.mainNavigation, _this.vars.selectors.triggerMenu, function(){
			_this.toggle( undefined, true );
		});

		Global.$dom.window.on( 'resize', Global.functions.throttle(function(){
			_this.setup();
			_this.toggleSubmenuArrows();
		}, 200));

	},

	setup: function(){
		//No menu present on the website
		if( !_this.$dom.mainNavigation.length ) return;

		_this.$dom.mainNavigation.attr( 'area-expanded', 'false' );
		

		_this.toggleSubmenuArrows();

	},

	toggleSubmenuArrows: function(){

		if( Global.device.isPortable === false ){
			$('.sub-menu').removeAttr( 'style' );
			_this.toggle( undefined, true );
		}

		_this.$dom.mainNavigation.find(_this.vars.selectors.navItemsWithChildren).each(function(){

			const $parent = this
			let $arrow;

			if( $(this).find(' > a').has('.arrow-toggle').length === 0 ) {

				if( $(this).parent().parent().is('div') ) {
					$arrow = $("<span class='arrow-toggle'>" + _this.vars.arrowDownHTML + "</span>");
				} else {
					$arrow = $("<span class='arrow-toggle'>" + _this.vars.arrowRightHTML + "</span>");
				}

				$(this).find('> a').append( $arrow );

			} else {
				$arrow = $(this).find('.arrow-toggle');
			}

			if( Global.device.isPortable ){

				$arrow.html( _this.vars.arrowDownHTML );

				$(this).find('> a').unbind('click').on('click', function(e){

					let attr = $(this).attr('href').trim();

					if( attr === '#' || $(e.target).is($arrow) || $(e.target).is( $('i') ) ){

						e.preventDefault();

						if( Global.device.isPortable ){
							$( $parent ).toggleClass( "sub-menu-open" );
							$( $parent ).find('> .sub-menu').slideToggle(400);
							$arrow.find('i').toggleClass('icon-angle-up icon-angle-down')
						}
					}

				});

			} else {
				if( $(this).parent().parent().is('div') ) {
					$arrow.html( _this.vars.arrowDownHTML );
				} else {
					$arrow.html( _this.vars.arrowRightHTML );
				}
			}

		});

	},

};