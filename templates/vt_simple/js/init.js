/*///////  Javascript initialization for template ///////*/
jQuery(document).ready(function() {
	if(jQuery('table').hasClass('category'))
		jQuery('table.category').addClass('table table-striped');
	if(!jQuery('.control-label', '.control-group').is('[class*="col-md-"]'))
		jQuery('.control-group').children('.control-label').attr('class', '').addClass('control-label col-md-4');
	if(!jQuery('.controls', '.control-group').is('[class*="col-md-"]'))
		jQuery('.control-group').children('.controls').attr('class', '').addClass('controls col-md-8');
	if(!jQuery('button').is('[class*="btn-"]'))
		jQuery('button').addClass('btn btn-primary');
	if(jQuery('.readmore').children().hasClass('btn'))
		jQuery('.readmore').children().addClass('btn btn-primary');
	if(jQuery('a.readmore').not('.btn'))
		jQuery('a.readmore').addClass('btn btn-primary');
	jQuery('.btn.btn-primary', '.com_users .well').parent().addClass('col-md-offset-4');
	jQuery('button.btn-primary', '#contact-form').addClass('col-md-offset-4');
	jQuery('.tagspopular').find('a').addClass('label label-info');
	
	//////////////// AUTO WIDTH FOR COMPONET AREA /////////////////////
	var $vCom = jQuery('.vtem-block.widget-component'),
		$vRight = jQuery('.vtem-block.position-right'),
		$vLeft = jQuery('.vtem-block.position-left');
	if((!$vCom.siblings().hasClass('position-right') && !$vCom.siblings().hasClass('position-left')) && ($vCom.data('vgrid') < 12))
		$vCom.removeClass('col-md-'+$vCom.data('vgrid')).addClass('col-md-12');
	else if(($vCom.siblings().hasClass('position-right') && !$vCom.siblings().hasClass('position-left')) && ($vCom.data('vgrid')+$vRight.data('vgrid') < 12))
		$vCom.removeClass('col-md-'+$vCom.data('vgrid')).addClass('col-md-'+(12 - $vRight.data('vgrid')));
	else if((!$vCom.siblings().hasClass('position-right') && $vCom.siblings().hasClass('position-left')) && ($vCom.data('vgrid')+$vLeft.data('vgrid') < 12))
		$vCom.removeClass('col-md-'+$vCom.data('vgrid')).addClass('col-md-'+(12 - $vLeft.data('vgrid')));
		
	//////////////// BEGIN GO TOP /////////////////////
	jQuery('.vtemgotop, .gotop, .totop').click(function () {
		jQuery('body, html').animate({scrollTop: 0}, 800);
		return false; 
	});
		
	//////////////// BLOG STYLES /////////////////////
	jQuery('.blog, .item-page', '.blog-classic.com_content').find('.item-image').each(function(id, el) {
		if (jQuery(el).length > 0) {
			jQuery(el).append('<dl class="article-info">'+jQuery(el).parent().find('.article-info:first').html()+'</dl>');
			jQuery(el).parent().find('.article-info:first').hide();
		}
		if (jQuery(el).prevAll('.tags').length <= 0)
			jQuery(el).siblings('.icons').addClass('clearfix');
	});
	
	//////////////// BEGIN MATCH HEIGHT /////////////////////
	jQuery('.matchHeight .widget-gridstack-item').matchHeight({property: 'height'});
		
	//////////////// WOW ANIMATE /////////////////////
	wow = new WOW({boxClass:'vtem-animation', animateClass:'animated', offset: 100});
	wow.init();
});