/*///////  Javascript for install the Sample Data ///////*/
jQuery(function() {
	jQuery('#vtemInstallData').click(function(e) {
		var self = this;
		jQuery(this).attr('disabled','disabled').parent().append('<span class="loading"><img src="../media/system/images/modal/spinner.gif" /> Installing data...</span>');
		jQuery.ajax({
				url : vtemInstallDataPath+'installData.php',
				data : {vtemInstallData:1}
		}).success(function(result) {
			jQuery(self).parent().find('.loading').remove();
			jQuery(self).removeAttr('disabled');
			jQuery(self).parent().append('<span class="success">Successful !!!</span>');
			jQuery(self).parent().find('.success').delay(3000).fadeOut(500);
		}).error(function(xhr) {
			jQuery(self).parent().find('.loading').remove();
			jQuery(self).parent().append('<span class="error">Error !!!</span>');
			jQuery(self).parent().find('.error').delay(3000).fadeOut(500);
        });
	});
});