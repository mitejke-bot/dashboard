/*
 * oResizeDrag - jQuery Resize and Drag
 * Copyright (c) 2011 OpenAddon.com/vtem.net
 *
 * Dual licensed under the MIT and GPL licenses:
 * 	http://www.opensource.org/licenses/mit-license.php
 * 	http://www.gnu.org/licenses/gpl.html
 *
 */
;(function($){
	//////////// ACCORDION ITEMS LIST ///////////////////////
	function oRepeatble(self) {
		var oWidgets = [];
		self.find('.accordion-group').each(function(i, el) {
            var oInput = {};
			$(this).find('.widget-input').each(function(index, element) {
                oInput[$(element).attr('name')] = $(element).val();
            });
			oWidgets.push(oInput);
        });
		return oWidgets;
	}
	function listRepeatble(self, data) {
		var oFirstItem = self.children(':first').html();
		self.empty();
		$.each(data, function(i, el) {
            self.append('<div class="accordion-group panel panel-default">'+oFirstItem+'</div>');
			$.each(el, function(id, els) {
				self.children(':eq('+i+')').find('[name="'+id+'"]').val(els);
			});
        });
	}
	function sortableRepeatble(self) {
		self.sortable({
			handle: '.action-move',
			placeholder: "ui-state-highlight",
			axis: 'y',
			opacity: 0.8,
			tolerance: 'pointer'
		});
	}
	function cloneRepeatable(self)
	{
		var $clone = self.clone(true, true);
		$clone.find('.accordion-body').hide();
		$clone.find('.accordion-toggle').text('Item'+(self.closest('.accordion').children().length+1));
		$clone = $clone.appendTo(self.closest('.accordion'));
		$clone.find('.media').each(function(){
			var mediaID = 'vtem-media-'+Math.floor(Math.random()* 10000);
			$(this).find('input').attr('id', mediaID);
			$(this).find('a.modal').attr('href', 'index.php?option=com_media&view=images&tmpl=component&fieldid=' + mediaID);
			SqueezeBox.initialize({});
			SqueezeBox.assign($(this).find('a.modal').get(), {parse: 'rel'});
		});
		sortableRepeatble($clone.closest('.accordion'));
	}
	//////////// END ACCORDION ///////////////////////
	function selectOption() {
		$('.select-group').each(function() {
			currentValue = $(this).val();
			name = $(this).attr("name");		
			$(this).find("option").each(function(index,Element) {		
				if($(Element).val() == currentValue)	    	
					$('.' + name + '-' + $(Element).val()).show();
				else		    	
					$('.' + name + '-' + $(Element).val()).hide();
			});
		});	
		
		$('.select-group').change(function() {	   
			currentValue = $(this).val();
			name = $(this).attr("name");        		
			$(this).find("option").each(function(index,Element) {		
				if($(Element).val() == currentValue)	          
					$('.' + name + '-' + $(Element).val()).show();
				else
					$('.' + name + '-' + $(Element).val()).hide();
			});		
		});
	}
	function oGetJson() {
		return jsonData = JSON.parse($('textarea#layoutscript').val()); //JSON.parse = json_decode, JSON.stringify = json_encode
	}
	function oSetJson(jsonData) {
		return $('textarea#layoutscript').text(JSON.stringify(jsonData));
	}
	function odragdrop(drag, drop) {
		var sortItem = null;
		////////////Variable for Resizable ///////////////////
		var itemResize = {
			handles: 'e',
			containment: 'parent',
			grid: 80,
			stop: function(event, ui) {
				oGetJson();
				$.each(jsonData['children'], function(i, obj) {
					if (jsonData['children'][i]['id'] && jsonData['children'][i]['id'] === ui.element.closest('.vtem-section').data('id')) {
						$.each(obj, function(key, items) {
							if (items && $.isArray(items) && key == 'children') {
								$.each(items, function(index, value) {
									if (items[index]['blockid'] && items[index]['blockid'] === ui.element.data('id')) {
										$.each(value, function(idx, element) {
											if (idx && idx === 'attributes') {
												value[idx]['grid'] = 'col-md-'+Math.round(12*ui.element.width()/940);
												ui.element.find('em').text(Math.round(12*ui.element.width()/940));
											}
										});
									}
								});
							}
						});
					}
				});
				oSetJson(jsonData);
			}
		}
		//////////////sortable & draggable /////////////////////
		$(drop).sortable({
			revert: true,
			containment: '.layout-main',
			connectWith: drop,
			placeholder: 'ui-state-highlight',
			start: function( event, ui ) {
				oGetJson();
				if (sortItem === null || sortItem !== true) {
					$.each(jsonData['children'], function(i, obj) {
						if (jsonData['children'][i]['id'] && jsonData['children'][i]['id'] === ui.item.closest('.vtem-section').data('id')) {
							$.each(obj, function(key, items) {
								if (items && $.isArray(items) && key == 'children') {
									$.each(items, function(index, value) {
										if (items[index]['blockid'] && items[index]['blockid'] === ui.item.data('id')) {
											sortItem = value;
											items.splice(index, 1);
											return false;
										}
									});
								}
							});
						}
					});
					oSetJson(jsonData);
				}
			},
			stop: function( event, ui ) {
				oGetJson();
				$.each(jsonData['children'], function(i, obj) {
					if (jsonData['children'][i]['id'] && jsonData['children'][i]['id'] === ui.item.closest('.vtem-section').data('id')) {
						$.each(obj, function(key, items) {
							if (items && $.isArray(items) && key === 'children') {
								if (items.length > 0) {
									$.each(items, function(index, value) {
										if (items[index]['blockid'] && items[index]['blockid'] != ui.item.data('id')) {
											if (sortItem === true) {
												items.splice(ui.item.index(), 0, {"blockid":ui.item.data('id'), "title":ui.item.data('title'), "type": ui.item.data('type'), "widget":ui.item.data('name'), "content":{}, "attributes":{}, "options":{}});
												sortItem = 'vtemOpenModal';
												return false;
											} else {
												items.splice(ui.item.index(), 0, sortItem);
												sortItem = false;
												return false;
											}
										}
									});
								} else {
									if (sortItem === true) {
										items.splice(ui.item.index(), 0, {"blockid":ui.item.data('id'), "title":ui.item.data('title'), "type": ui.item.data('type'), "widget":ui.item.data('name'), "content":{}, "attributes":{}, "options":{}});
										sortItem = 'vtemOpenModal';
										return false;
									} else {
										items.splice(ui.item.index(), 0, sortItem);
										sortItem = false;
										return false;
									}
								}
							}
						});
					}
				});
				oSetJson(jsonData);
				if (sortItem === 'vtemOpenModal')
					oDialog(ui.item.data('name'), ui.item.closest('.vtem-section').data('id'), ui.item.data('id'), true);
				$(this).children().resizable(itemResize);
				$('.section-content').each(function(index, element) {
					if ($(element).children().length <= 0)
						$(element).addClass('empty');
					else
						$(element).removeClass('empty');
				});
			}
		}).children().resizable(itemResize).closest('.layout-main').sortable({
			containment: 'parent',
			stop: function(event, ui) {
				oGetJson();
				for (var i = 0; i < jsonData['children'].length; i++) {
					if (jsonData['children'][i]['id'] && jsonData['children'][i]['id'] === ui.item.data('id')) {
						var sectionSort = jsonData['children'][i];
						jsonData['children'].splice(i, 1);
						jsonData['children'].splice(ui.item.index(), 0, sectionSort); 
						break;
					}
				}
				oSetJson(jsonData);
			}
		});
		$(drag).children().draggable({
			connectToSortable: drop,
			helper: 'clone',
			revert: 'invalid',
			start: function( event, ui ) {
				sortItem = true;
				ui.helper.attr('data-id', (new Date().getTime()).toString(16)+Math.floor(Math.random()* 10000));
			},
			stop: function( event, ui ) {
				ui.helper.css({'width':'940px', 'height': 'auto'}).addClass('vtem-grid-12 build-control');
			}
		});
		$(drag).disableSelection().children().disableSelection();
	}
	
	//////////////Dialog /////////////////////
	function oDialog(objectName, sectionId, blockId, firstOpen) {
		oGetJson();
		var dialog = '#'+objectName;
		var modal = $(dialog).dialog({
			autoOpen: false,
			draggable: false,
			minHeight: 300,
			minWidth: 550,
			modal: true,
			dialogClass: (firstOpen ? 'firstOpen' : ''),
			show: { effect: "slideDown", duration: 500 },
			create: function( event, ui ) {
				$(this).find('select').chosen('destroy');
				sortableRepeatble($(this).find('.accordion'));
			},
			close: function( event, ui ) {
				$(this).find('.vtem-editor').each(function(){
					tinymce.execCommand('mceRemoveEditor', false, $(this).attr('id'));
				});
				$(this).find('.accordion').accordion('destroy');
			},
			open: function( event, ui ) {
				if (objectName != 'vtemHelp') {
					if (objectName === 'vtemMainBody') {
						$.each(jsonData['attributes'], function(i, obj) {
							$(dialog).find('[name="'+i+'"]').val(obj);
						});
					} else if (objectName === 'section') {
						$.each(jsonData['children'], function(i, obj) {
							if (jsonData['children'][i]['id'] && jsonData['children'][i]['id'] === sectionId) {
								$.each(obj, function(key, items) {
									if ( key == 'attributes' ) {
										$.each(items, function(index, value) {
											$(dialog).find('[name="'+index+'"]').val(value);
										});
									}
								});
							}
						});
					} else {
						$.each(jsonData['children'], function(i, obj) {
							if (jsonData['children'][i]['id'] && jsonData['children'][i]['id'] === sectionId) {
								$.each(obj, function(key, items) {
									if (items && $.isArray(items) && key == 'children') {
										$.each(items, function(index, value) {
											if (items[index]['blockid'] && items[index]['blockid'] === blockId) {
												$.each(value, function(j, val) {
													if ( j == 'options' || j == 'attributes' || j == 'content' ) {
														$.each(val, function(k, el) {
															if (k == 'itemList') {
																listRepeatble($(dialog).find('.accordion'), value['content']['itemList']);
															} else {
																$(dialog).find('[name="'+k+'"]').val(el);
															}
														});
													} else {
														$(dialog).find('[name="'+j+'"]').val(val);
													}
												});
											}
										});
									}
								}); 
							}
						});
					}
				}
				selectOption();
				$(this).find('.vtem-editor').each(function(){
					$(this).attr('id', 'vtem-editor-'+Math.floor(Math.random()* 10000));
					tinymce.execCommand('mceAddEditor', false, $(this).attr('id'));
				});
				$(this).find('.media').each(function(){
					$(this).children('input').attr('id', 'vtem-media-'+Math.floor(Math.random()* 10000));
					$(this).find('a.modal').attr('href', 'index.php?option=com_media&view=images&tmpl=component&fieldid=' + $(this).children('input').attr('id'));
					SqueezeBox.initialize({});
					SqueezeBox.assign($(this).find('a.modal').get(), {parse: 'rel'});
				});
				if ($(this).find('.accordion').hasClass('auto-title')) {
					$(this).find('.accordion-group').each(function(index, element) {
                        $(element).find('input.addon-title').val('Item'+(index+1));
                    });
				}
				$(this).find('.addon-title').each(function() {
					$(this).closest('.accordion-group').find('.accordion-toggle').text($(this).val());
				});
				$(this).find('.accordion').accordion({header: '> div > h3', active: false, collapsible: true});
				$(this).find('.tinycolor').colorPicker();
			},
			buttons: (objectName === 'vtemHelp') ? [] : {
				Accept: function() {
						tinyMCE.triggerSave();
						if (objectName === 'vtemMainBody') {
							$.each($(dialog).find('.widget-box'), function(k, el) {
								jsonData['attributes'][$(el).attr('name')] = $(el).val();
							});
						} else if (objectName === 'section') {
							$.each(jsonData['children'], function(i, obj) {
								if (jsonData['children'][i]['id'] && jsonData['children'][i]['id'] === sectionId) {
									$.each(obj, function(key, items) {
										if ( key == 'attributes' ) {
											$.each($(dialog).find('.widget-box'), function(k, el) {
												obj['attributes'][$(el).attr('name')] = $(el).val();
											});
										}
									});
								}
							});
						} else {
							$.each(jsonData['children'], function(i, obj) {
								if (jsonData['children'][i]['id'] && jsonData['children'][i]['id'] === sectionId) {
									$.each(obj, function(key, items) {
										if (items && $.isArray(items) && key == 'children') {
											$.each(items, function(index, value) {
												if (items[index]['blockid'] && items[index]['blockid'] === blockId) {
													$.each(value, function(j, val) {
														if (j == 'options' || j == 'attributes' || j == 'content') {
															$.each($(dialog).find('[data-name="'+j+'"]').find('.widget-box'), function(k, el) {
																if ($(el).is('div')) {
																	value[j]['itemList'] = oRepeatble($(el));
																} else {
																	value[j][$(el).attr('name')] = $(el).val();
																	if ($(el).attr('name') == 'module-positions')
																		$('.module-position-name', '[data-id="'+blockId+'"]').text('['+$(el).val()+']');
																}
															});
														} else {
															value[j] = $(dialog).find('[name="'+j+'"]').val();
														}
													});
												}
											});
										}
									}); 
								}
							});
						}
						oSetJson(jsonData);
						modal.dialog('close').dialog('destroy');
				},
				Cancel: function() {
					modal.dialog('close').dialog('destroy');
				}
			}
		}).dialog('open');
	}
	
	$(document).ready(function(e) {
		////////// EDIT SOME ELEMENT OF JOOMLA //////////
		if($('#system-message-container').length > 0 && $('#system-message-container').is(':visible'))
			$('#system-message-container').delay(3000).fadeOut(500);
		if($('.form-inline-header').children().length > 0 && $('.form-vertical').length > 0)
			$('.form-vertical').prepend($('.form-inline-header').html());
		/////////////////////////////////////////////////
		$('.tip').tooltip({position: { my: "center bottom-15", at: "bottom center" }});
		$( ".hasTooltip" ).tooltip({disabled: true});
		$('.layout-container').closest('.controls').addClass('layout-wrapper').prev().hide();
		// tinyMCE editor source code edit
		$.widget( "ui.dialog", $.ui.dialog, {
			_allowInteraction: function( event ) {
				return !!$( event.target ).closest( ".mce-window" ).length || this._super( event );
			}
		});
		//Add Repeatable
		$(document).on('click', '.clone-repeatable', function(){
			cloneRepeatable($(this).next('.accordion').children(':first'));
		});
		//Remove Repeatable
		$(document).on('click', '.action-remove', function(event){
			if($(this).closest('.accordion').find('.accordion-group').length != 1) //Do not delete last item
				$(this).closest('.accordion-group').remove();
		});
		////////OPEN WIDGET IN MODAL //////////////
		$('.widget-content').tabs();
		$('.layout-build').on('click', '.config', function(event) {
			var sectionId = $(this).closest('.vtem-section').data('id');
			var objectName = $(this).closest('.build-control').data('name');
			var blockId = $(this).closest('.build-control').data('id');
			oDialog(objectName, sectionId, blockId, false);
		});
		////////////// DELETE ONE ITEM ///////////////////////
		$('.layout-build').on('click', '.delete', function(event) {
			oGetJson();
			var objectName = $(this).closest('.build-control').data('name');
			var objectId = $(this).closest('.build-control').data('id');
			$('[data-id="'+objectId+'"]').remove();
			if (objectName != '' && objectName === 'section') {
				for (var i = 0; i < jsonData['children'].length; i++) {
					if (jsonData['children'][i]['id'] && jsonData['children'][i]['id'] === objectId) {
						jsonData['children'].splice(i, 1);
						break;
					}
				}
			} else {
				$.each(jsonData['children'], function(i, obj) {
					$.each(obj, function(key, items) {
						if (items && $.isArray(items) && key == 'children')
							$.each(items, function(index, value) {
								if (items[index]['blockid'] && items[index]['blockid'] === objectId) {
									items.splice(index, 1);
									return false;
								}
							});
					});
				});
			}
			oSetJson(jsonData);
		});
		////////////// ADD NEW SECTION ///////////////////////
		$('.layout-build').on('click', '#vtem-add-row', function(event){
			oGetJson();
			var uniqid = (new Date().getTime()).toString(16)+Math.floor(Math.random()* 10000);
            $('#layout-main').prepend('<div class="vtem-section build-control widget-items" data-name="section" data-id="'+uniqid+'"><div class="section-title clearfix"><i class="fa fa-cog vtem-button config"></i><b class="fa fa-trash vtem-button delete"></b></div><div class="section-content clearfix"></div></div>');
			jsonData['children'].splice(0, 0, {"id":uniqid, "type":"section", "children": [], "attributes":{"tagid":"","class":"","full-width":0,"extend":""}});
			oSetJson(jsonData);
			odragdrop('.widget-tools .widget-items', '.section-content');
        });
		odragdrop('.widget-tools .widget-items', '.section-content');
    });
})(jQuery);