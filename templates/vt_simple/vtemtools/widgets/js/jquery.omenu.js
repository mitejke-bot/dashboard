/**
 * oMenu - jQuery mega menu
 * Copyright (c) 2011 OpenAddon.com/vtem.net
 *
 * Dual licensed under the MIT and GPL licenses:
 * 	http://www.opensource.org/licenses/mit-license.php
 * 	http://www.gnu.org/licenses/gpl.html
 *
 */
;(function($){
	"use strict";
	$.fn.oMenu = function(options){ //define the defaults for the plugin and how to call it	
		var defaults = { //set default options  
		    width: '100%',
			orientation: 'Horizontal', // Horizontal, Vertical, Overlay
			mouseEvent: 'click', // 'click', 'hover'
			speed: 400,
			effect: 'slide', // 'fade', 'blind', 'slide', 'fold', 'bounce'
			subWidth: 220,
			easing: 'swing',
			stick: true,
			onLoad : function(){},
            beforeOpen : function(){},
			beforeClose: function(){}
		};
		var options = $.extend(defaults, options); //call in the default otions	
		return this.each(function(){ //The element that is passed into the design  
			var obj = $(this),
				opts = options,  
				classParent = 'vtem-menu',
				classSubContainer = 'sub-container',
				classHover = 'menu-hover';
			obj.addClass('main-'+classParent).show().wrap('<div class="o'+opts.orientation+' '+classParent+'-wrapper clearfix" />');
			if (opts.stick) {
				obj.before('<span data-stick="'+obj.attr('id')+'" class="menu-stick menu-stick-main hidden-md hidden-lg hidden-desktop">&equiv;</span>').addClass('mega-menu-stick hidden-xs hidden-sm hidden-phone hidden-tablet');
				obj.clone().attr('id', 'mobile-'+obj.attr('id')).attr('class','nav nav-canvas hidden-md hidden-lg hidden-desktop mega-menu-stick').appendTo('body');
				$(document).on('click', '[data-stick="'+obj.attr('id')+'"]', function() {
					if ($(this).hasClass('menu-stick-main'))
						$('#mobile-'+obj.attr('id')).animate({'left': 0},300).closest('body').removeClass('oMenuStickClose').addClass('oMenuStickOpen').append('<div data-stick="'+obj.attr('id')+'" class="oMenuOverwrite"/>');
					else
						$('#mobile-'+obj.attr('id')).animate({'left': -250},300).hide().closest('body').removeClass('oMenuStickOpen').addClass('oMenuStickClose').find('.oMenuOverwrite').remove();
				});
			}
			if (opts.orientation == 'Overlay') {
				obj.before('<span data-id="'+obj.attr('id')+'" class="menu-overlay-button menu-button-main '+(opts.stick ? 'hidden-xs hidden-sm hidden-phone hidden-tablet' : '')+'">&equiv;</span>').remove();
				obj.clone(true,true).attr('id', 'overlay-'+obj.attr('id')).attr('style', 'top:0; opacity:0').addClass('nav-overlay vtem-nav-overlay').appendTo('body');
				$(document).on('click', '[data-id="'+obj.attr('id')+'"]', function() {
					if ($(this).hasClass('menu-button-main')) {
						$('#overlay-'+obj.attr('id')).wrap('<div class="nav-overlay-wrap '+(opts.stick ? 'hidden-xs hidden-sm hidden-phone hidden-tablet' : '')+'" />');
						$('#overlay-'+obj.attr('id')).show().before('<span data-id="'+obj.attr('id')+'" class="menu-overlay-button menu-overlay-close">&times;</span>');
						$('#overlay-'+obj.attr('id')).animate({'top':'50%', 'opacity': 1},300);
					} else {
						$('#overlay-'+obj.attr('id')).animate({'top':'0', 'opacity': 0},300);
						$('#overlay-'+obj.attr('id')).hide().prev('span').remove();
						$('#overlay-'+obj.attr('id')).unwrap();
					}
				});
			}
			megaSetup();
			function menuOpen(self){
				if(opts.mouseEvent == 'hover') var self = $(this);
				var subNav = $('> .'+classSubContainer, self);
				self.addClass(classHover);
				switch(opts.effect){
					default:
					case 'fade':
						subNav.fadeIn(opts.speed, opts.easing);
						break;
					case 'slide':
						subNav.animate({'height': 'toggle'}, opts.speed, opts.easing);
						break;
				}
				opts.beforeOpen.call(this); // beforeOpen callback;
			}
			
			function menuClose(self){
				if(opts.mouseEvent == 'hover') var self = $(this);
				var subNav = $('> .'+classSubContainer, self);
				switch(opts.effect){
					default:
					case 'fade':
						subNav.fadeOut(opts.speed /2);
						break;
					case 'slide':
						subNav.animate({'height': 'toggle'}, opts.speed/2);
						break;
				}
				self.removeClass(classHover);
				opts.beforeClose.call(this); // beforeClose callback;
			}
			function megaSetup(){
				var arrow = '<span class="menu-arrow caret">&nbsp;</span>';
				$('li', obj).each(function(){ //Set Width of sub
					var $mainSub = $('> ul', this).addClass(classSubContainer+' dropdown-menu').css({'top':'100%', 'position':'absolute', 'z-index':999, 'width': opts.subWidth});
					var $primaryLink = $('> a, > span', this);
					if ($mainSub.length)
						$primaryLink.addClass(classParent).append(arrow);
				});
		
				if(opts.mouseEvent == 'hover') {
					$('li', obj).hoverIntent({
						sensitivity: 2,
						interval: 20,
						over: menuOpen,
						timeout: 100,
						out: menuClose
					}); 
				} else if(opts.mouseEvent == 'click') {
					$(document).mouseup(function(e){
						obj.find('li').removeClass(classHover).find('.'+classSubContainer).hide();
					});
					$('a.'+classParent, obj).click(function(e){
						$(this).parents('.'+classSubContainer).show().end().parents('li').addClass(classHover);
						e.preventDefault();
						menuOpen($(this).parent());		
					});
				}
				opts.onLoad.call(this); // onLoad callback;
			}
		});
	};
})(jQuery);