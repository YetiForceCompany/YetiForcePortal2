/* {[The file is published on the basis of YetiForce Public License that can be found in the following directory: licenses/License.html]} */
jQuery.Class("Install_Install_Js", {
}, {
	changeLanguage: function(e) {
		var target = $(e.currentTarget);
		jQuery('input[name="mode"]').val('Step1');
		jQuery('form').submit();
	},
	registerEvents: function () {
		$('select[name="lang"]').change(this.changeLanguage);
	}
});
